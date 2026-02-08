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
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->string('donor_name');
            $table->string('donor_email');
            $table->string('donor_phone')->nullable();
            $table->decimal('amount', 12, 2);
            $table->string('campaign_title')->nullable();
            $table->text('message')->nullable();
            $table->string('payment_method')->default('qris'); // qris atau bank_transfer
            $table->enum('status', ['pending', 'success', 'failed', 'expired'])->default('pending');
            $table->string('transaction_id')->nullable()->unique();
            $table->string('payment_token')->nullable();
            $table->timestamp('payment_completed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};
