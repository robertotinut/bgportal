<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('finance_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('wallet_id')->nullable()->constrained('finance_wallets')->onDelete('cascade');
            $table->foreignId('budget_id')->nullable()->constrained('finance_budgets')->onDelete('set null');
            $table->enum('type', ['income', 'expense', 'savings'])->default('income');
            $table->decimal('amount', 15, 2);
            $table->string('contributor_name')->nullable(); // e.g. Jessica, Rudy, Gaji
            $table->string('category')->default('Umum');
            $table->text('description')->nullable();
            $table->date('transaction_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('finance_transactions');
    }
};
