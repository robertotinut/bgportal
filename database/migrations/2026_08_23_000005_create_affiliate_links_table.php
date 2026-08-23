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
        Schema::create('affiliate_links', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('shopee_url');
            $table->text('affiliate_url');
            $table->string('product_title')->nullable();
            $table->string('category')->nullable();
            $table->text('product_image')->nullable();
            $table->text('promo_image')->nullable();
            $table->string('pin_title')->nullable();
            $table->text('pin_description')->nullable();
            $table->enum('status', ['pending', 'skipped', 'processing', 'posted', 'failed'])->default('pending');
            $table->timestamp('scheduled_at')->nullable();
            $table->timestamp('posted_at')->nullable();
            $table->text('error_message')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('affiliate_links');
    }
};
