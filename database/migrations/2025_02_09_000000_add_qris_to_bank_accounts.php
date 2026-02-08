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
        Schema::table('bank_accounts', function (Blueprint $table) {
            $table->string('merchant_name')->nullable(); // Nama merchant untuk QRIS
            $table->string('merchant_city')->nullable(); // Kota merchant
            $table->string('qris_path')->nullable(); // Path ke gambar QRIS yang di-generate
            $table->text('qris_payload')->nullable(); // QRIS payload (jika disimpan)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bank_accounts', function (Blueprint $table) {
            $table->dropColumn(['merchant_name', 'merchant_city', 'qris_path', 'qris_payload']);
        });
    }
};
