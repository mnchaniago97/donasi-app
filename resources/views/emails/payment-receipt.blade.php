<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bukti Pembayaran Donasi</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #0b5b80, #064a66);
            color: white;
            padding: 30px 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: bold;
        }
        .header p {
            margin: 5px 0 0 0;
            opacity: 0.9;
            font-size: 14px;
        }
        .content {
            padding: 30px;
        }
        .section {
            margin-bottom: 25px;
        }
        .section-title {
            color: #0b5b80;
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 12px;
            border-bottom: 2px solid #d4e9f5;
            padding-bottom: 8px;
        }
        .detail-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding: 8px 0;
        }
        .detail-label {
            color: #666;
            font-size: 14px;
        }
        .detail-value {
            color: #333;
            font-weight: 500;
            font-size: 14px;
        }
        .amount-section {
            background-color: #f0f9fc;
            border-left: 4px solid #0b5b80;
            padding: 15px;
            border-radius: 4px;
            margin: 20px 0;
        }
        .amount-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }
        .amount-row:last-child {
            margin-bottom: 0;
        }
        .amount-label {
            color: #666;
            font-size: 14px;
        }
        .amount-value {
            color: #333;
            font-weight: 500;
        }
        .amount-total {
            border-top: 1px solid #d4e9f5;
            padding-top: 10px;
            margin-top: 10px;
        }
        .amount-total .amount-label {
            font-weight: bold;
            color: #0b5b80;
            font-size: 16px;
        }
        .amount-total .amount-value {
            font-weight: bold;
            color: #0b5b80;
            font-size: 18px;
        }
        .status-badge {
            display: inline-block;
            background-color: #d4edda;
            color: #155724;
            padding: 6px 12px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .info-box {
            background-color: #e7f3ff;
            border: 1px solid #b3d9ff;
            border-radius: 4px;
            padding: 12px;
            margin: 15px 0;
            font-size: 13px;
            color: #0c5460;
        }
        .footer {
            background-color: #f9f9f9;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #666;
            border-top: 1px solid #e0e0e0;
        }
        .footer p {
            margin: 5px 0;
        }
        .button {
            display: inline-block;
            background-color: #0b5b80;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 15px;
            font-size: 14px;
            font-weight: bold;
        }
        .transaction-id {
            background-color: #f5f5f5;
            padding: 10px;
            border-radius: 4px;
            font-family: monospace;
            font-size: 12px;
            word-break: break-all;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>✓ Pembayaran Berhasil</h1>
            <p>Terima kasih atas donasi Anda</p>
        </div>

        <!-- Content -->
        <div class="content">
            <!-- Greeting -->
            <p>Halo {{ $donation->donor_name }},</p>
            <p>Kami dengan senang hati mengkonfirmasi bahwa pembayaran donasi Anda telah berhasil diproses. Berikut adalah detail bukti pembayaran Anda:</p>

            <!-- Donor Information -->
            <div class="section">
                <div class="section-title">Data Pemberi Donasi</div>
                <div class="detail-row">
                    <span class="detail-label">Nama:</span>
                    <span class="detail-value">{{ $donation->donor_name }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Email:</span>
                    <span class="detail-value">{{ $donation->donor_email }}</span>
                </div>
                @if($donation->donor_phone)
                <div class="detail-row">
                    <span class="detail-label">Telepon:</span>
                    <span class="detail-value">{{ $donation->donor_phone }}</span>
                </div>
                @endif
            </div>

            <!-- Donation Details -->
            <div class="section">
                <div class="section-title">Detail Donasi</div>
                @if($donation->campaign_title)
                <div class="detail-row">
                    <span class="detail-label">Kampanye:</span>
                    <span class="detail-value">{{ $donation->campaign_title }}</span>
                </div>
                @endif
                <div class="detail-row">
                    <span class="detail-label">Tanggal:</span>
                    <span class="detail-value">{{ $donation->created_at->format('d F Y H:i') }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Metode Pembayaran:</span>
                    <span class="detail-value">
                        @if($donation->payment_method === 'qris')
                            <span>QRIS</span>
                        @else
                            <span>Transfer Bank</span>
                        @endif
                    </span>
                </div>
            </div>

            <!-- Amount -->
            <div class="amount-section">
                <div class="amount-row">
                    <span class="amount-label">Jumlah Donasi:</span>
                    <span class="amount-value">Rp {{ number_format($donation->amount, 0, ',', '.') }}</span>
                </div>
                <div class="amount-row amount-total">
                    <span class="amount-label">Total Pembayaran:</span>
                    <span class="amount-value">Rp {{ number_format($donation->amount, 0, ',', '.') }}</span>
                </div>
            </div>

            <!-- Status -->
            <div class="section">
                <div class="section-title">Status Pembayaran</div>
                <div class="detail-row" style="margin-bottom: 15px;">
                    <span class="detail-label" style="display: block; width: 100%; margin-bottom: 8px;">Status Transaksi:</span>
                    <span class="status-badge" style="display: inline-block; width: auto;">✓ Berhasil</span>
                </div>
                @if($donation->payment_completed_at)
                <div class="detail-row">
                    <span class="detail-label">Waktu Konfirmasi:</span>
                    <span class="detail-value">{{ $donation->payment_completed_at->format('d F Y H:i:s') }}</span>
                </div>
                @endif
                @if($donation->transaction_id)
                <div class="detail-row">
                    <span class="detail-label">Referensi Transaksi:</span>
                    <span class="transaction-id">{{ $donation->transaction_id }}</span>
                </div>
                @endif
            </div>

            <!-- Info Box -->
            <div class="info-box">
                <strong>Catatan Penting:</strong><br>
                Simpan email ini sebagai bukti pembayaran Anda. Anda dapat menggunakan referensi transaksi di atas jika memiliki pertanyaan tentang donasi Anda.
            </div>

            <!-- Appreciation -->
            <p style="color: #0b5b80; font-weight: 500; font-size: 15px;">
                Terima kasih telah menjadi bagian dari misi kami. Donasi Anda akan membuat perbedaan yang nyata!
            </p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p><strong>{{ config('app.name') }}</strong></p>
            <p>© {{ date('Y') }} Semua Hak Dilindungi</p>
            <p>Email ini dikirim otomatis. Jangan balas email ini.</p>
        </div>
    </div>
</body>
</html>
