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
        Schema::create('affiliate_post_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('account_id')->constrained('pinterest_accounts')->onDelete('cascade');
            $table->foreignId('affiliate_link_id')->constrained('affiliate_links')->onDelete('cascade');
            $table->string('pin_id')->nullable();
            $table->enum('status', ['success', 'failed', 'skipped'])->default('success');
            $table->text('message')->nullable();
            $table->timestamp('posted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('affiliate_post_logs');
    }
};
