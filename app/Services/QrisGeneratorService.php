<?php

namespace App\Services;

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;

class QrisGeneratorService
{
    /**
     * Generate QRIS code untuk bank account
     * QRIS menggunakan standar BI dengan format: 000201...
     * Namun untuk kemudahan, kita bisa generate QR dari informasi akun bank
     */
    public function generateQrisPayload(
        string $bankCode,
        string $accountNumber,
        string $merchantName,
        string $merchantCity = 'Indonesia',
        ?int $amount = null
    ): string {
        /**
         * Format QRIS sederhana menggunakan data:
         * 00:Payload Format Indicator
         * 01:Point Of Initiation Method
         * 26-45: Merchant Account Information (untuk bank)
         * 52: Merchant Category Code (untuk donasi/organisasi)
         * 53: Currency (IDR = 360)
         * 54: Transaction Amount
         * 58: Country Code (ID = 60)
         * 59: Merchant Name
         * 60: Merchant City
         * 62: CRC
         * 
         * Untuk implementasi sederhana, kita bisa generate QR dari bank info
         */
        
        // Format: BANK|ACCOUNT|HOLDER|AMOUNT (jika ada)
        $data = implode('|', [
            $bankCode,
            $accountNumber,
            $merchantName,
            $merchantCity,
            $amount ?? 0
        ]);
        
        return hash('crc32', $data);
    }

    /**
     * Generate QR Code gambar dari QRIS payload atau bank info
     */
    public function generateQrCode(
        string $bankCode,
        string $accountNumber,
        string $merchantName,
        string $merchantCity = 'Indonesia',
        ?int $amount = null
    ): string {
        // Buat data untuk QR Code - berisi informasi bank untuk kemudahan transfer
        $qrisData = $this->buildQrisString(
            $bankCode,
            $accountNumber,
            $merchantName,
            $amount
        );

        try {
            // Generate QR Code menggunakan endroid/qr-code v6.0.9
            $qrCode = new QrCode($qrisData);
            
            // Convert ke PNG dan return sebagai Data URI
            $writer = new PngWriter();
            $result = $writer->write($qrCode);
            
            return 'data:image/png;base64,' . base64_encode($result->getString());
        } catch (\Exception $e) {
            // Jika terjadi error, return string kosong (QRIS optional)
            error_log('QRIS Generation Error: ' . $e->getMessage());
            return '';
        }
    }

    /**
     * Build QRIS string dari informasi bank
     */
    private function buildQrisString(
        string $bankCode,
        string $accountNumber,
        string $merchantName,
        ?int $amount = null
    ): string {
        $parts = [
            'BANK' => $bankCode,
            'ACCOUNT' => $accountNumber,
            'NAME' => $merchantName,
        ];
        
        if ($amount) {
            $parts['AMOUNT'] = $amount;
        }

        $qrisString = '';
        foreach ($parts as $key => $value) {
            $qrisString .= $key . ':' . $value . '|';
        }

        return rtrim($qrisString, '|');
    }

    /**
     * Get bank code mapping
     */
    public function getBankCode(string $bankName): string
    {
        $codes = [
            'BCA' => '014',
            'BNI' => '009',
            'Mandiri' => '008',
            'BRI' => '002',
            'CIMB Niaga' => '022',
            'Permata' => '013',
            'Maybank' => '016',
            'OCBC NISP' => '028',
            'Panin' => '019',
            'Danamon' => '011',
            'BTPN' => '213',
            'Bank Bukopin' => '441',
        ];

        return $codes[ucfirst(strtolower($bankName))] ?? '999';
    }
}
