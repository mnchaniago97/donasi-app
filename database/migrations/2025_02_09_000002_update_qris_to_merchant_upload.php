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
            // Tambah kolom untuk QRIS merchant file upload
            $table->string('qris_merchant_file')->nullable(); // Path file QRIS
            
            // Drop kolom-kolom yang sudah tidak dipakai (auto-generate)
            $table->dropColumn(['merchant_name', 'merchant_city', 'qris_path', 'qris_payload']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bank_accounts', function (Blueprint $table) {
            $table->string('merchant_name')->nullable();
            $table->string('merchant_city')->nullable();
            $table->longText('qris_path')->nullable();
            $table->text('qris_payload')->nullable();
            $table->dropColumn('qris_merchant_file');
        });
    }
};
