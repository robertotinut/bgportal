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

        // Default Budget / Target Tabungan (Matching Screenshot: Dana Nikah)
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
                ['contributor_name' => 'Jessica', 'amount' => 200000, 'transaction_date' => '2026-08-20', 'description' => 'Tabungan Agustus'],
                ['contributor_name' => 'Rudy', 'amount' => 500000, 'transaction_date' => '2026-08-03', 'description' => 'Freelance'],
                ['contributor_name' => 'Rudy', 'amount' => 1200000, 'transaction_date' => '2026-07-25', 'description' => 'Gaji Bulan Juli'],
                ['contributor_name' => 'Jessica', 'amount' => 300000, 'transaction_date' => '2026-07-24', 'description' => 'Setoran Bulanan'],
                ['contributor_name' => 'Rudy', 'amount' => 1200000, 'transaction_date' => '2026-06-25', 'description' => 'Gaji Bulan Juni'],
            ];

            foreach ($sampleData as $item) {
                FinanceTransaction::create([
                    'user_id' => $userId,
                    'budget_id' => $defaultBudget->id,
                    'type' => 'savings',
                    'amount' => $item['amount'],
                    'contributor_name' => $item['contributor_name'],
                    'category' => 'Tabungan',
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

        // Selected Budget ID or first budget (default: Dana Nikah)
        $selectedBudgetId = $request->get('budget_id', $budgets->first()->id ?? null);
        $activeBudget = FinanceBudget::where('user_id', $userId)->find($selectedBudgetId) ?? $budgets->first();

        // Recalculate collected amount for active budget
        $totalCollected = FinanceTransaction::where('user_id', $userId)
            ->where('budget_id', $activeBudget->id)
            ->where('type', 'savings')
            ->sum('amount');

        if ($totalCollected > 0 && $activeBudget->collected_amount != $totalCollected) {
            $activeBudget->collected_amount = $totalCollected;
            $activeBudget->save();
        }

        // Calculations for header donut & target cards
        $targetAmount = max(1, $activeBudget->target_amount);
        $collectedAmount = $activeBudget->collected_amount;
        $percentage = min(100, round(($collectedAmount / $targetAmount) * 100));

        $remainingAmount = max(0, $targetAmount - $collectedAmount);
        $monthlySuggestion = ceil($remainingAmount / 16); // Suggested monthly savings over 16 months

        // Total Overall Finance Realisasi across all user budgets
        $totalRealisasi = FinanceTransaction::where('user_id', $userId)->where('type', 'savings')->sum('amount');
        $totalTarget = $budgets->sum('target_amount');
        $overallPercentage = $totalTarget > 0 ? min(100, round(($totalRealisasi / $totalTarget) * 100)) : 0;
        $overallEst = $totalTarget * 0.65;
        $overallSisa = max(0, $totalTarget - $totalRealisasi);

        // Savings transactions history
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
     * Store new transaction (Catat Tabungan / Income / Expense).
     */
    public function storeTransaction(Request $request)
    {
        $request->validate([
            'budget_id' => 'required|exists:finance_budgets,id',
            'contributor_name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:1000',
            'transaction_date' => 'required|date',
            'description' => 'nullable|string|max:255',
        ]);

        $budget = FinanceBudget::where('user_id', Auth::id())->findOrFail($request->budget_id);

        FinanceTransaction::create([
            'user_id' => Auth::id(),
            'budget_id' => $budget->id,
            'type' => 'savings',
            'amount' => $request->amount,
            'contributor_name' => $request->contributor_name,
            'category' => 'Tabungan',
            'description' => $request->description,
            'transaction_date' => $request->transaction_date,
        ]);

        // Recalculate collected amount
        $budget->collected_amount = FinanceTransaction::where('user_id', Auth::id())
            ->where('budget_id', $budget->id)
            ->where('type', 'savings')
            ->sum('amount');
        $budget->save();

        return redirect()->back()->with('success', 'Catatan tabungan berhasil ditambahkan!');
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
            'contributor_name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:1000',
            'transaction_date' => 'required|date',
            'description' => 'nullable|string|max:255',
        ]);

        $transaction->update([
            'contributor_name' => $request->contributor_name,
            'amount' => $request->amount,
            'transaction_date' => $request->transaction_date,
            'description' => $request->description,
        ]);

        // Recalculate budget total
        if ($transaction->budget_id) {
            $budget = FinanceBudget::find($transaction->budget_id);
            if ($budget) {
                $budget->collected_amount = FinanceTransaction::where('user_id', Auth::id())
                    ->where('budget_id', $budget->id)
                    ->where('type', 'savings')
                    ->sum('amount');
                $budget->save();
            }
        }

        return redirect()->back()->with('success', 'Catatan tabungan berhasil diperbarui!');
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
                $budget->collected_amount = FinanceTransaction::where('user_id', Auth::id())
                    ->where('budget_id', $budget->id)
                    ->where('type', 'savings')
                    ->sum('amount');
                $budget->save();
            }
        }

        return redirect()->back()->with('success', 'Catatan tabungan berhasil dihapus!');
    }
}
