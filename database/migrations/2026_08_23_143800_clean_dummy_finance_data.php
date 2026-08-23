<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\FinanceWallet;
use App\Models\FinanceTransaction;
use App\Models\FinanceBill;
use App\Models\FinanceBudget;

return new class extends Migration
{
    /**
     * Run the migrations to wipe all dummy test records for non-admin accounts.
     */
    public function up(): void
    {
        $nonAdminUsers = User::where('role', '!=', 'admin')->get();

        foreach ($nonAdminUsers as $user) {
            DB::table('finance_transactions')->where('user_id', $user->id)->delete();
            DB::table('finance_bills')->where('user_id', $user->id)->delete();
            DB::table('finance_budgets')->where('user_id', $user->id)->delete();
            DB::table('finance_wallets')->where('user_id', $user->id)->delete();

            // Create 1 clean starter wallet with 0 balance
            FinanceWallet::create([
                'user_id' => $user->id,
                'name' => 'Kas Utama / Cash',
                'type' => 'cash',
                'balance' => 0,
                'color' => '#0d6efd'
            ]);

            // Create 1 clean starter budget
            FinanceBudget::create([
                'user_id' => $user->id,
                'name' => 'Target Anggaran Utama',
                'target_amount' => 0,
                'collected_amount' => 0,
                'target_date' => now()->addYear(),
                'status' => 'active'
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
