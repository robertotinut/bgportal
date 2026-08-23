<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Models\FinanceBudget;
use App\Models\FinanceTransaction;
use App\Models\FinanceWallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        return view('apps.finance.index', compact(
            'wallets',
            'totalBalance',
            'monthlyIncome',
            'monthlyExpense',
            'recentTransactions',
            'budgets'
        ));
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
