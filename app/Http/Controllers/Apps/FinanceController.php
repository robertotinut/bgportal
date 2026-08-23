<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Models\FinanceBill;
use App\Models\FinanceBudget;
use App\Models\FinanceTransaction;
use App\Models\FinanceWallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FinanceController extends Controller
{
    /**
     * Ensure default budgets & wallets exist for authenticated user.
     */
    protected function initUserData()
    {
        $userId = Auth::id();

        // Default Wallets
        $cash = FinanceWallet::firstOrCreate(
            ['user_id' => $userId, 'name' => 'Kas Utama / Cash'],
            ['type' => 'cash', 'balance' => 3500000, 'color' => '#0d6efd']
        );

        $bank = FinanceWallet::firstOrCreate(
            ['user_id' => $userId, 'name' => 'Rekening Bank BCA'],
            ['type' => 'bank', 'balance' => 15200000, 'color' => '#198754']
        );

        $ewallet = FinanceWallet::firstOrCreate(
            ['user_id' => $userId, 'name' => 'E-Wallet (GoPay/OVO)'],
            ['type' => 'ewallet', 'balance' => 850000, 'color' => '#0dcaf0']
        );

        // Default Bills
        FinanceBill::firstOrCreate(
            ['user_id' => $userId, 'name' => 'Listrik PLN'],
            [
                'category' => 'Listrik',
                'amount' => 250000,
                'due_day' => 20,
                'status' => 'unpaid',
                'notes' => 'Tagihan pascabayar PLN',
            ]
        );

        FinanceBill::firstOrCreate(
            ['user_id' => $userId, 'name' => 'Internet & WiFi'],
            [
                'category' => 'Internet',
                'amount' => 350000,
                'due_day' => 15,
                'status' => 'unpaid',
                'notes' => 'Langganan bulanan Biznet/Indihome',
            ]
        );

        FinanceBill::firstOrCreate(
            ['user_id' => $userId, 'name' => 'BPJS Kesehatan'],
            [
                'category' => 'Asuransi',
                'amount' => 150000,
                'due_day' => 10,
                'status' => 'paid',
                'last_paid_at' => now()->startOfMonth(),
                'notes' => 'Iuran BPJS Kelas 1',
            ]
        );

        // Default Budget Targets
        $defaultBudget = FinanceBudget::firstOrCreate(
            ['user_id' => $userId, 'name' => 'Dana Nikah'],
            [
                'target_amount' => 60000000,
                'collected_amount' => 24400000,
                'target_date' => now()->addYear(),
                'status' => 'active',
            ]
        );

        FinanceBudget::firstOrCreate(
            ['user_id' => $userId, 'name' => 'Budgeting Bulanan'],
            [
                'target_amount' => 15000000,
                'collected_amount' => 8500000,
                'target_date' => now()->endOfMonth(),
                'status' => 'active',
            ]
        );

        FinanceBudget::firstOrCreate(
            ['user_id' => $userId, 'name' => 'Pengeluaran Rutin'],
            [
                'target_amount' => 10000000,
                'collected_amount' => 4200000,
                'target_date' => now()->endOfMonth(),
                'status' => 'active',
            ]
        );

        // Seed Sample Transactions if empty
        if (FinanceTransaction::where('user_id', $userId)->count() === 0) {
            $sampleData = [
                ['contributor_name' => 'Gaji Bulanan', 'type' => 'income', 'amount' => 8500000, 'transaction_date' => '2026-08-01', 'description' => 'Gaji Utama', 'wallet_id' => $bank->id],
                ['contributor_name' => 'Belanja Bulanan', 'type' => 'expense', 'amount' => 1250000, 'transaction_date' => '2026-08-05', 'description' => 'Supermarket & Bahan Pokok', 'wallet_id' => $cash->id],
                ['contributor_name' => 'Jessica', 'type' => 'savings', 'amount' => 200000, 'transaction_date' => '2026-08-20', 'description' => 'Tabungan Agustus', 'wallet_id' => $bank->id],
                ['contributor_name' => 'Rudy', 'type' => 'income', 'amount' => 500000, 'transaction_date' => '2026-08-03', 'description' => 'Freelance Project', 'wallet_id' => $ewallet->id],
                ['contributor_name' => 'Tagihan Listrik & Wifi', 'type' => 'expense', 'amount' => 650000, 'transaction_date' => '2026-08-10', 'description' => 'Rutin Bulanan', 'wallet_id' => $bank->id],
            ];

            foreach ($sampleData as $item) {
                FinanceTransaction::create([
                    'user_id' => $userId,
                    'wallet_id' => $item['wallet_id'],
                    'budget_id' => $defaultBudget->id,
                    'type' => $item['type'],
                    'amount' => $item['amount'],
                    'contributor_name' => $item['contributor_name'],
                    'category' => ucfirst($item['type']),
                    'description' => $item['description'],
                    'transaction_date' => $item['transaction_date'],
                ]);
            }
        }
    }

    /**
     * PAGE 1: Beranda Finanza Overview (/apps/finance).
     */
    public function index(Request $request)
    {
        $userId = Auth::id();
        $this->initUserData();

        $wallets = FinanceWallet::where('user_id', $userId)->latest()->get();
        $totalBalance = $wallets->sum('balance');

        $currentMonth = now()->month;
        $currentYear = now()->year;

        $monthlyIncome = FinanceTransaction::where('user_id', $userId)
            ->where('type', 'income')
            ->whereMonth('transaction_date', $currentMonth)
            ->whereYear('transaction_date', $currentYear)
            ->sum('amount');

        $monthlyExpense = FinanceTransaction::where('user_id', $userId)
            ->where('type', 'expense')
            ->whereMonth('transaction_date', $currentMonth)
            ->whereYear('transaction_date', $currentYear)
            ->sum('amount');

        $recentTransactions = FinanceTransaction::where('user_id', $userId)
            ->with('wallet')
            ->orderBy('transaction_date', 'desc')
            ->orderBy('id', 'desc')
            ->take(10)
            ->get();

        $budgets = FinanceBudget::where('user_id', $userId)->get();

        $unpaidBills = FinanceBill::where('user_id', $userId)->where('status', 'unpaid')->get();
        $unpaidBillsCount = $unpaidBills->count();
        $totalUnpaidBills = $unpaidBills->sum('amount');

        return view('apps.finance.index', compact(
            'wallets',
            'totalBalance',
            'monthlyIncome',
            'monthlyExpense',
            'recentTransactions',
            'budgets',
            'unpaidBillsCount',
            'totalUnpaidBills'
        ));
    }

    /**
     * PAGE 4: Tagihan & Langganan Rutin (/apps/finance/bills).
     */
    public function bills(Request $request)
    {
        $userId = Auth::id();
        $this->initUserData();

        $bills = FinanceBill::where('user_id', $userId)
            ->with('wallet')
            ->orderBy('status', 'asc') // 'unpaid' first, then 'paid'
            ->orderBy('due_day', 'asc')
            ->get();

        $unpaidBills = $bills->where('status', 'unpaid');
        $paidBills = $bills->where('status', 'paid');
        $totalUnpaid = $unpaidBills->sum('amount');
        $totalPaid = $paidBills->sum('amount');

        $wallets = FinanceWallet::where('user_id', $userId)->get();

        return view('apps.finance.bills', compact(
            'bills',
            'unpaidBills',
            'paidBills',
            'totalUnpaid',
            'totalPaid',
            'wallets'
        ));
    }

    /**
     * Store new Bill.
     */
    public function storeBill(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'amount' => 'required|numeric|min:1000',
            'due_day' => 'required|integer|min:1|max:31',
            'notes' => 'nullable|string|max:255',
        ]);

        FinanceBill::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'category' => $request->category,
            'amount' => $request->amount,
            'due_day' => $request->due_day,
            'status' => 'unpaid',
            'notes' => $request->notes,
        ]);

        return redirect()->back()->with('success', "Tagihan '{$request->name}' berhasil ditambahkan!");
    }

    /**
     * Update Bill.
     */
    public function updateBill(Request $request, FinanceBill $bill)
    {
        if ($bill->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'amount' => 'required|numeric|min:1000',
            'due_day' => 'required|integer|min:1|max:31',
            'status' => 'required|in:unpaid,paid',
            'notes' => 'nullable|string|max:255',
        ]);

        $bill->update([
            'name' => $request->name,
            'category' => $request->category,
            'amount' => $request->amount,
            'due_day' => $request->due_day,
            'status' => $request->status,
            'notes' => $request->notes,
        ]);

        return redirect()->back()->with('success', "Tagihan '{$bill->name}' berhasil diperbarui!");
    }

    /**
     * Pay Bill (Bayar Tagihan & Potong Saldo Rekening Otomatis).
     */
    public function payBill(Request $request, FinanceBill $bill)
    {
        if ($bill->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'wallet_id' => 'required|exists:finance_wallets,id',
        ]);

        $userId = Auth::id();
        $wallet = FinanceWallet::where('user_id', $userId)->findOrFail($request->wallet_id);

        if ($wallet->balance < $bill->amount) {
            return redirect()->back()->with('error', "Saldo pada dompet '{$wallet->name}' tidak mencukupi untuk membayar tagihan!");
        }

        // Deduct from wallet
        $wallet->balance -= $bill->amount;
        $wallet->save();

        // Log expense transaction
        FinanceTransaction::create([
            'user_id' => $userId,
            'wallet_id' => $wallet->id,
            'type' => 'expense',
            'amount' => $bill->amount,
            'contributor_name' => "Bayar {$bill->name}",
            'category' => $bill->category ?: 'Tagihan',
            'description' => "Pembayaran tagihan {$bill->name} (Jatuh tempo tgl {$bill->due_day})",
            'transaction_date' => now(),
        ]);

        // Update bill status
        $bill->update([
            'status' => 'paid',
            'wallet_id' => $wallet->id,
            'last_paid_at' => now(),
        ]);

        return redirect()->back()->with('success', "Tagihan '{$bill->name}' sebesar Rp " . number_format($bill->amount, 0, ',', '.') . " berhasil dibayar dan dipotong dari dompet {$wallet->name}!");
    }

    /**
     * Delete Bill.
     */
    public function destroyBill(FinanceBill $bill)
    {
        if ($bill->user_id !== Auth::id()) {
            abort(403);
        }

        $bill->delete();
        return redirect()->back()->with('success', 'Tagihan berhasil dihapus!');
    }

    /**
     * Store new Wallet / Rekening.
     */
    public function storeWallet(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:cash,bank,ewallet,investment',
            'balance' => 'required|numeric|min:0',
        ]);

        FinanceWallet::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'type' => $request->type,
            'balance' => $request->balance,
            'color' => '#0d6efd',
        ]);

        return redirect()->back()->with('success', 'Rekening/Dompet baru berhasil ditambahkan!');
    }

    /**
     * Transfer funds between wallets / accounts.
     */
    public function transferWallet(Request $request)
    {
        $request->validate([
            'from_wallet_id' => 'required|exists:finance_wallets,id',
            'to_wallet_id' => 'required|exists:finance_wallets,id|different:from_wallet_id',
            'amount' => 'required|numeric|min:1000',
            'transaction_date' => 'required|date',
            'description' => 'nullable|string|max:255',
        ]);

        $userId = Auth::id();
        $fromWallet = FinanceWallet::where('user_id', $userId)->findOrFail($request->from_wallet_id);
        $toWallet = FinanceWallet::where('user_id', $userId)->findOrFail($request->to_wallet_id);

        if ($fromWallet->balance < $request->amount) {
            return redirect()->back()->with('error', "Saldo pada dompet '{$fromWallet->name}' tidak mencukupi untuk transfer!");
        }

        // Deduct from source
        $fromWallet->balance -= $request->amount;
        $fromWallet->save();

        // Add to destination
        $toWallet->balance += $request->amount;
        $toWallet->save();

        // Create transaction logs
        FinanceTransaction::create([
            'user_id' => $userId,
            'wallet_id' => $fromWallet->id,
            'type' => 'expense',
            'amount' => $request->amount,
            'contributor_name' => "Transfer ke {$toWallet->name}",
            'category' => 'Transfer',
            'description' => $request->description ?: "Transfer dana dari {$fromWallet->name} ke {$toWallet->name}",
            'transaction_date' => $request->transaction_date,
        ]);

        FinanceTransaction::create([
            'user_id' => $userId,
            'wallet_id' => $toWallet->id,
            'type' => 'income',
            'amount' => $request->amount,
            'contributor_name' => "Transfer dari {$fromWallet->name}",
            'category' => 'Transfer',
            'description' => $request->description ?: "Transfer dana masuk dari {$fromWallet->name}",
            'transaction_date' => $request->transaction_date,
        ]);

        return redirect()->back()->with('success', "Transfer sebesar Rp " . number_format($request->amount, 0, ',', '.') . " berhasil dilakukan!");
    }

    /**
     * Update Wallet / Rekening.
     */
    public function updateWallet(Request $request, FinanceWallet $wallet)
    {
        if ($wallet->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:cash,bank,ewallet,investment',
            'balance' => 'required|numeric|min:0',
        ]);

        $wallet->update([
            'name' => $request->name,
            'type' => $request->type,
            'balance' => $request->balance,
        ]);

        return redirect()->back()->with('success', 'Rekening/Dompet berhasil diperbarui!');
    }

    /**
     * Delete Wallet / Rekening.
     */
    public function destroyWallet(FinanceWallet $wallet)
    {
        if ($wallet->user_id !== Auth::id()) {
            abort(403);
        }

        $wallet->delete();
        return redirect()->back()->with('success', 'Rekening/Dompet berhasil dihapus!');
    }

    /**
     * PAGE 3: Laporan Keuangan & Analitik (Pemasukan, Pengeluaran, & Cashflow).
     */
    public function reports(Request $request)
    {
        $userId = Auth::id();
        $this->initUserData();

        $selectedMonth = $request->get('month', now()->format('Y-m'));
        $selectedWalletId = $request->get('wallet_id');
        $selectedType = $request->get('type');

        $query = FinanceTransaction::where('user_id', $userId)
            ->with('wallet')
            ->whereYear('transaction_date', substr($selectedMonth, 0, 4))
            ->whereMonth('transaction_date', substr($selectedMonth, 5, 2));

        if ($selectedWalletId) {
            $query->where('wallet_id', $selectedWalletId);
        }

        if ($selectedType) {
            $query->where('type', $selectedType);
        }

        $transactions = $query->orderBy('transaction_date', 'desc')->orderBy('id', 'desc')->get();

        $totalIncome = $transactions->where('type', 'income')->sum('amount');
        $totalExpense = $transactions->where('type', 'expense')->sum('amount');
        $totalSavings = $transactions->where('type', 'savings')->sum('amount');
        $netCashflow = $totalIncome - $totalExpense;

        // Category breakdown for expenses
        $expenseCategories = $transactions->where('type', 'expense')
            ->groupBy('category')
            ->map(function ($items, $category) use ($totalExpense) {
                $sum = $items->sum('amount');
                $percentage = $totalExpense > 0 ? round(($sum / $totalExpense) * 100) : 0;
                return [
                    'category' => $category ?: 'Lainnya',
                    'amount' => $sum,
                    'percentage' => $percentage,
                    'count' => $items->count(),
                ];
            })->sortByDesc('amount');

        // Prepare Daily Chart Data for ApexCharts
        $year = (int) substr($selectedMonth, 0, 4);
        $month = (int) substr($selectedMonth, 5, 2);
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

        $dailyDates = [];
        $dailyIncomeData = [];
        $dailyExpenseData = [];

        for ($d = 1; $d <= $daysInMonth; $d++) {
            $dateStr = sprintf('%04d-%02d-%02d', $year, $month, $d);
            $dailyDates[] = sprintf('%02d %s', $d, date('M', mktime(0, 0, 0, $month, 10)));
            $dailyIncomeData[] = (int) $transactions->where('type', 'income')->filter(function ($t) use ($dateStr) {
                return $t->transaction_date && $t->transaction_date->format('Y-m-d') === $dateStr;
            })->sum('amount');
            $dailyExpenseData[] = (int) $transactions->where('type', 'expense')->filter(function ($t) use ($dateStr) {
                return $t->transaction_date && $t->transaction_date->format('Y-m-d') === $dateStr;
            })->sum('amount');
        }

        $donutLabels = $expenseCategories->pluck('category')->toArray();
        $donutSeries = $expenseCategories->pluck('amount')->map(function ($amt) { return (int) $amt; })->toArray();

        $wallets = FinanceWallet::where('user_id', $userId)->get();

        return view('apps.finance.reports', compact(
            'transactions',
            'totalIncome',
            'totalExpense',
            'totalSavings',
            'netCashflow',
            'expenseCategories',
            'selectedMonth',
            'selectedWalletId',
            'selectedType',
            'wallets',
            'dailyDates',
            'dailyIncomeData',
            'dailyExpenseData',
            'donutLabels',
            'donutSeries'
        ));
    }

    /**
     * PAGE 2: Dedicated Halaman Anggaran & Target Tabungan (/apps/finance/budgets).
     */
    public function budgets(Request $request)
    {
        $userId = Auth::id();
        $this->initUserData();

        $budgets = FinanceBudget::where('user_id', $userId)->get();

        $selectedBudgetId = $request->get('budget_id', $budgets->first()->id ?? null);
        $activeBudget = FinanceBudget::where('user_id', $userId)->find($selectedBudgetId) ?? $budgets->first();

        // Recalculate collected amount for active budget
        $incomeSavings = FinanceTransaction::where('user_id', $userId)
            ->where('budget_id', $activeBudget->id)
            ->whereIn('type', ['income', 'savings'])
            ->sum('amount');
        $expenses = FinanceTransaction::where('user_id', $userId)
            ->where('budget_id', $activeBudget->id)
            ->where('type', 'expense')
            ->sum('amount');

        $netCollected = max(0, $incomeSavings - $expenses);

        if ($activeBudget->collected_amount != $netCollected) {
            $activeBudget->collected_amount = $netCollected;
            $activeBudget->save();
        }

        // Stats for Donut Chart & Target Cards
        $targetAmount = max(1, $activeBudget->target_amount);
        $collectedAmount = $activeBudget->collected_amount;
        $percentage = min(100, round(($collectedAmount / $targetAmount) * 100));

        $remainingAmount = max(0, $targetAmount - $collectedAmount);
        $monthlySuggestion = ceil($remainingAmount / 16);

        $transactions = FinanceTransaction::where('user_id', $userId)
            ->where('budget_id', $activeBudget->id)
            ->orderBy('transaction_date', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        return view('apps.finance.budgets', compact(
            'budgets',
            'activeBudget',
            'percentage',
            'remainingAmount',
            'monthlySuggestion',
            'transactions'
        ));
    }

    /**
     * Store new target / budget category.
     */
    public function storeBudget(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'target_amount' => 'required|numeric|min:100000',
        ]);

        $budget = FinanceBudget::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'target_amount' => $request->target_amount,
            'collected_amount' => 0,
            'status' => 'active',
        ]);

        return redirect()->route('apps.finance.budgets', ['budget_id' => $budget->id])
            ->with('success', "Target anggaran '{$budget->name}' berhasil dibuat!");
    }

    /**
     * Store new transaction (Pemasukan / Pengeluaran / Tabungan).
     */
    public function storeTransaction(Request $request)
    {
        $request->validate([
            'wallet_id' => 'nullable|exists:finance_wallets,id',
            'budget_id' => 'nullable|exists:finance_budgets,id',
            'type' => 'required|in:income,expense,savings',
            'contributor_name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:1000',
            'transaction_date' => 'required|date',
            'description' => 'nullable|string|max:255',
        ]);

        $userId = Auth::id();

        $transaction = FinanceTransaction::create([
            'user_id' => $userId,
            'wallet_id' => $request->wallet_id,
            'budget_id' => $request->budget_id,
            'type' => $request->type,
            'amount' => $request->amount,
            'contributor_name' => $request->contributor_name,
            'category' => ucfirst($request->type),
            'description' => $request->description,
            'transaction_date' => $request->transaction_date,
        ]);

        // Adjust Wallet Balance if wallet selected
        if ($request->wallet_id) {
            $wallet = FinanceWallet::where('user_id', $userId)->find($request->wallet_id);
            if ($wallet) {
                if ($request->type === 'income') {
                    $wallet->balance += $request->amount;
                } elseif ($request->type === 'expense') {
                    $wallet->balance = max(0, $wallet->balance - $request->amount);
                }
                $wallet->save();
            }
        }

        // Recalculate Budget if budget selected
        if ($request->budget_id) {
            $budget = FinanceBudget::where('user_id', $userId)->find($request->budget_id);
            if ($budget) {
                $inc = FinanceTransaction::where('user_id', $userId)
                    ->where('budget_id', $budget->id)
                    ->whereIn('type', ['income', 'savings'])
                    ->sum('amount');
                $exp = FinanceTransaction::where('user_id', $userId)
                    ->where('budget_id', $budget->id)
                    ->where('type', 'expense')
                    ->sum('amount');

                $budget->collected_amount = max(0, $inc - $exp);
                $budget->save();
            }
        }

        $typeText = $request->type === 'income' ? 'Pemasukan' : ($request->type === 'expense' ? 'Pengeluaran' : 'Tabungan');
        return redirect()->back()->with('success', "Catatan {$typeText} berhasil ditambahkan!");
    }

    /**
     * AI Scan Struk Vision Analysis.
     */
    public function analyzeReceipt(Request $request)
    {
        $request->validate([
            'receipt_image' => 'required|image|max:5120', // max 5MB
        ]);

        try {
            $file = $request->file('receipt_image');
            $imageContent = file_get_contents($file->getRealPath());
            $base64 = base64_encode($imageContent);
            $mime = $file->getClientMimeType();

            $apiKey = env('SUMOPOD_API_KEY');
            $baseUrl = env('SUMOPOD_BASE_URL', 'https://ai.sumopod.com/v1');
            $model = env('SUMOPOD_MODEL', 'MiniMax-M3');

            $prompt = "Tolong analisis struk belanja ini. Ekstrak informasi berikut dan JANGAN menambahkan teks apapun selain format JSON murni yang divalidasi. 
Kembalikan HANYA JSON object dengan format persis seperti ini:
{
    \"amount\": 150000, 
    \"date\": \"YYYY-MM-DD\",
    \"category\": \"Nama Kategori\",
    \"description\": \"Nama Toko\\n- Item 1 (Harga)\\n- Item 2 (Harga)\"
}
Perhatikan:
- 'amount' harus berupa angka bulat (integer) murni tanpa titik atau koma, mewakili total pembayaran.
- 'date' harus format YYYY-MM-DD. Jika tidak terbaca, gunakan tanggal hari ini (" . date('Y-m-d') . ").
- 'category' tebak dari opsi ini: Makan & Minum, Transportasi, Belanja, Tagihan & Utilitas, Hiburan, atau Lainnya.
- 'description' tulis nama toko di baris pertama, lalu rincikan SEMUA item yang dibeli di baris-baris berikutnya menggunakan bullet list (-).";

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type' => 'application/json',
            ])->timeout(60)->post($baseUrl . '/chat/completions', [
                'model' => $model,
                'messages' => [
                    [
                        'role' => 'user',
                        'content' => [
                            ['type' => 'text', 'text' => $prompt],
                            ['type' => 'image_url', 'image_url' => ['url' => "data:{$mime};base64,{$base64}"]]
                        ]
                    ]
                ],
                'max_tokens' => 500,
                'temperature' => 0.1
            ]);

            if ($response->successful()) {
                $responseBody = $response->json();
                $aiContent = $responseBody['choices'][0]['message']['content'] ?? '';
                
                // Clean markdown code blocks & think tags
                $aiContent = preg_replace('/<think>.*?<\/think>/s', '', $aiContent);
                $aiContent = preg_replace('/```json\s*(.*?)\s*```/s', '$1', $aiContent);
                $aiContent = preg_replace('/```\s*(.*?)\s*```/s', '$1', $aiContent);

                if (preg_match('/\{[^{}]*"amount"[^{}]*\}/s', $aiContent, $matches)) {
                    $aiContent = $matches[0];
                } elseif (preg_match('/\{.*\}/s', $aiContent, $matches)) {
                    $aiContent = $matches[0];
                }

                $extractedData = json_decode(trim($aiContent), true);

                if ($extractedData && isset($extractedData['amount'])) {
                    return response()->json([
                        'status' => 'success',
                        'data' => $extractedData,
                    ]);
                }
            }

            return response()->json([
                'status' => 'error',
                'message' => 'Gagal membaca rincian struk otomatis. Silakan masukkan secara manual.',
            ], 422);

        } catch (\Exception $e) {
            Log::error('AI Receipt Scan Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan sistem saat menganalisis struk: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update target amount for budget.
     */
    public function updateTarget(Request $request, FinanceBudget $budget)
    {
        if ($budget->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'target_amount' => 'required|numeric|min:100000',
            'name' => 'required|string|max:255',
        ]);

        $budget->name = $request->name;
        $budget->target_amount = $request->target_amount;
        $budget->save();

        return redirect()->back()->with('success', 'Target anggaran berhasil diperbarui!');
    }

    /**
     * Delete budget target.
     */
    public function destroyBudget(FinanceBudget $budget)
    {
        if ($budget->user_id !== Auth::id()) {
            abort(403);
        }

        $userId = Auth::id();
        $count = FinanceBudget::where('user_id', $userId)->count();
        if ($count <= 1) {
            return redirect()->back()->with('error', 'Minimal harus ada 1 target anggaran yang aktif!');
        }

        FinanceTransaction::where('user_id', $userId)->where('budget_id', $budget->id)->delete();
        $budget->delete();

        $nextBudget = FinanceBudget::where('user_id', $userId)->first();
        return redirect()->route('apps.finance.budgets', ['budget_id' => $nextBudget->id])
            ->with('success', "Target anggaran '{$budget->name}' berhasil dihapus!");
    }

    /**
     * Update transaction.
     */
    public function updateTransaction(Request $request, FinanceTransaction $transaction)
    {
        if ($transaction->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'type' => 'required|in:income,expense,savings',
            'contributor_name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:1000',
            'transaction_date' => 'required|date',
            'description' => 'nullable|string|max:255',
        ]);

        $transaction->update([
            'type' => $request->type,
            'contributor_name' => $request->contributor_name,
            'amount' => $request->amount,
            'transaction_date' => $request->transaction_date,
            'description' => $request->description,
        ]);

        return redirect()->back()->with('success', 'Catatan keuangan berhasil diperbarui!');
    }

    /**
     * Delete transaction.
     */
    public function destroyTransaction(FinanceTransaction $transaction)
    {
        if ($transaction->user_id !== Auth::id()) {
            abort(403);
        }

        $transaction->delete();
        return redirect()->back()->with('success', 'Catatan transaksi berhasil dihapus!');
    }
}
