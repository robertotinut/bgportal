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
        FinanceWallet::firstOrCreate(
            ['user_id' => $userId, 'name' => 'Kas / Cash'],
            ['type' => 'cash', 'balance' => 5000000, 'color' => '#8C4325']
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
                ['contributor_name' => 'Jessica', 'type' => 'savings', 'amount' => 200000, 'transaction_date' => '2026-08-20', 'description' => 'Tabungan Agustus'],
                ['contributor_name' => 'Rudy', 'type' => 'income', 'amount' => 500000, 'transaction_date' => '2026-08-03', 'description' => 'Freelance Project'],
                ['contributor_name' => 'Rudy', 'type' => 'income', 'amount' => 1200000, 'transaction_date' => '2026-07-25', 'description' => 'Gaji Bulan Juli'],
                ['contributor_name' => 'Jessica', 'type' => 'savings', 'amount' => 300000, 'transaction_date' => '2026-07-24', 'description' => 'Setoran Bulanan'],
                ['contributor_name' => 'Rudy', 'type' => 'expense', 'amount' => 450000, 'transaction_date' => '2026-06-25', 'description' => 'Belanja Bulanan'],
            ];

            foreach ($sampleData as $item) {
                FinanceTransaction::create([
                    'user_id' => $userId,
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
     * Finance Dashboard Overview (Matching Screenshot Design).
     */
    public function index(Request $request)
    {
        $userId = Auth::id();
        $this->initUserData();

        $budgets = FinanceBudget::where('user_id', $userId)->get();

        // Selected Budget ID or first budget
        $selectedBudgetId = $request->get('budget_id', $budgets->first()->id ?? null);
        $activeBudget = FinanceBudget::where('user_id', $userId)->find($selectedBudgetId) ?? $budgets->first();

        // Recalculate collected amount for active budget (income + savings - expense)
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

        // Calculations for header donut & target cards
        $targetAmount = max(1, $activeBudget->target_amount);
        $collectedAmount = $activeBudget->collected_amount;
        $percentage = min(100, round(($collectedAmount / $targetAmount) * 100));

        $remainingAmount = max(0, $targetAmount - $collectedAmount);
        $monthlySuggestion = ceil($remainingAmount / 16);

        // Overall Finance Stats
        $totalRealisasi = FinanceTransaction::where('user_id', $userId)->whereIn('type', ['income', 'savings'])->sum('amount');
        $totalTarget = $budgets->sum('target_amount');
        $overallPercentage = $totalTarget > 0 ? min(100, round(($totalRealisasi / $totalTarget) * 100)) : 0;
        $overallEst = $totalTarget * 0.65;
        $overallSisa = max(0, $totalTarget - $totalRealisasi);

        // Transactions history
        $transactions = FinanceTransaction::where('user_id', $userId)
            ->where('budget_id', $activeBudget->id)
            ->orderBy('transaction_date', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        return view('apps.finance.index', compact(
            'budgets',
            'activeBudget',
            'percentage',
            'remainingAmount',
            'monthlySuggestion',
            'totalRealisasi',
            'totalTarget',
            'overallPercentage',
            'overallEst',
            'overallSisa',
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

        return redirect()->route('apps.finance.index', ['budget_id' => $budget->id])
            ->with('success', "Target anggaran '{$budget->name}' berhasil dibuat!");
    }

    /**
     * Store new transaction (Pemasukan / Pengeluaran / Tabungan).
     */
    public function storeTransaction(Request $request)
    {
        $request->validate([
            'budget_id' => 'required|exists:finance_budgets,id',
            'type' => 'required|in:income,expense,savings',
            'contributor_name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:1000',
            'transaction_date' => 'required|date',
            'description' => 'nullable|string|max:255',
        ]);

        $budget = FinanceBudget::where('user_id', Auth::id())->findOrFail($request->budget_id);

        FinanceTransaction::create([
            'user_id' => Auth::id(),
            'budget_id' => $budget->id,
            'type' => $request->type,
            'amount' => $request->amount,
            'contributor_name' => $request->contributor_name,
            'category' => ucfirst($request->type),
            'description' => $request->description,
            'transaction_date' => $request->transaction_date,
        ]);

        // Recalculate collected amount
        $inc = FinanceTransaction::where('user_id', Auth::id())
            ->where('budget_id', $budget->id)
            ->whereIn('type', ['income', 'savings'])
            ->sum('amount');
        $exp = FinanceTransaction::where('user_id', Auth::id())
            ->where('budget_id', $budget->id)
            ->where('type', 'expense')
            ->sum('amount');

        $budget->collected_amount = max(0, $inc - $exp);
        $budget->save();

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

        // Recalculate budget total
        if ($transaction->budget_id) {
            $budget = FinanceBudget::find($transaction->budget_id);
            if ($budget) {
                $inc = FinanceTransaction::where('user_id', Auth::id())
                    ->where('budget_id', $budget->id)
                    ->whereIn('type', ['income', 'savings'])
                    ->sum('amount');
                $exp = FinanceTransaction::where('user_id', Auth::id())
                    ->where('budget_id', $budget->id)
                    ->where('type', 'expense')
                    ->sum('amount');

                $budget->collected_amount = max(0, $inc - $exp);
                $budget->save();
            }
        }

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

        $budgetId = $transaction->budget_id;
        $transaction->delete();

        if ($budgetId) {
            $budget = FinanceBudget::find($budgetId);
            if ($budget) {
                $inc = FinanceTransaction::where('user_id', Auth::id())
                    ->where('budget_id', $budget->id)
                    ->whereIn('type', ['income', 'savings'])
                    ->sum('amount');
                $exp = FinanceTransaction::where('user_id', Auth::id())
                    ->where('budget_id', $budget->id)
                    ->where('type', 'expense')
                    ->sum('amount');

                $budget->collected_amount = max(0, $inc - $exp);
                $budget->save();
            }
        }

        return redirect()->back()->with('success', 'Catatan transaksi berhasil dihapus!');
    }
}
