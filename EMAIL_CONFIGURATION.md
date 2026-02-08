# Konfigurasi Email Bukti Pembayaran

Sistem aplikasi sekarang sudah dilengkapi dengan fitur pengiriman bukti pembayaran otomatis ke email donor ketika pembayaran berhasil.

## Komponen yang Ditambahkan

### 1. **PaymentReceiptMail** (`app/Mail/PaymentReceiptMail.php`)
   - Mailable class untuk generate email bukti pembayaran
   - Menggunakan queue untuk pengiriman asynchronous
   - Menampilkan detail donasi dan informasi pembayaran

### 2. **Email Template** (`resources/views/emails/payment-receipt.blade.php`)
   - Template HTML profesional dengan styling
   - Menampilkan:
     - Data pemberi donasi (nama, email, telepon)
     - Detail donasi dan kampanye
     - Jumlah dan metode pembayaran
     - Status dan referensi transaksi
     - Informasi penting untuk donor

### 3. **Webhook Handler Update** (`app/Services/MidtransPaymentService.php`)
   - Ketika Midtrans mengirim notification pembayaran success
   - Donation status di-update menjadi "success"
   - Email bukti pembayaran otomatis dikirim ke donor

### 4. **Test Command** (`app/Console/Commands/SendTestPaymentEmail.php`)
   - Command untuk testing pengiriman email
   - Usage: `php artisan email:test-payment your-email@example.com`

## Konfigurasi Email (.env)

Pastikan file `.env` Anda memiliki konfigurasi email yang tepat:

```env
# Gunakan salah satu dari berikut:

# 1. MENGGUNAKAN MAILTRAP (RECOMMENDED untuk development)
MAIL_DRIVER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=465
MAIL_USERNAME=xxxxxxxxxxxx
MAIL_PASSWORD=xxxxxxxxxxxx
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@donasi-app.local"
MAIL_FROM_NAME="Aplikasi Donasi"

# 2. MENGGUNAKAN GMAIL
MAIL_DRIVER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password  # Bukan password biasa, gunakan App Password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="your-email@gmail.com"
MAIL_FROM_NAME="Aplikasi Donasi"

# 3. MENGGUNAKAN SENDGRID
MAIL_DRIVER=sendgrid
SENDGRID_API_KEY=your-sendgrid-api-key
MAIL_FROM_ADDRESS="noreply@donasi-app.local"
MAIL_FROM_NAME="Aplikasi Donasi"

# 4. MENGGUNAKAN SENDINBLUE
MAIL_DRIVER=sendinblue
SENDINBLUE_KEY=your-sendinblue-api-key
MAIL_FROM_ADDRESS="noreply@donasi-app.local"
MAIL_FROM_NAME="Aplikasi Donasi"

# 5. MENGGUNAKAN LOG (untuk testing/development - email hanya disimpan di log)
MAIL_DRIVER=log
MAIL_LOG_CHANNEL=single
```

## Testing Email

### Test di Development (Tanpa Email Service)
Jika ingin testing tanpa setup email service:

```bash
# Edit .env dan set:
MAIL_DRIVER=log
MAIL_LOG_CHANNEL=single
```

Email akan disimpan di file log: `storage/logs/laravel.log`

### Test Dengan Mailtrap (Recommended)

1. Daftar di https://mailtrap.io
2. Buat project kosong baru
3. Copy credentials dari Mailtrap ke file `.env`
4. Jalankan test command:
   ```bash
   php artisan email:test-payment test@example.com
   ```
5. Email akan muncul di inbox Mailtrap tanpa benar-benar terkirim

### Test Dengan Gmail

1. Enable 2FA di Gmail
2. Generate App Password di https://myaccount.google.com/apppasswords
3. Gunakan App Password di file `.env`
4. Jalankan test:
   ```bash
   php artisan email:test-payment your-email@gmail.com
   ```

## Cara Kerja Pengiriman Email

### Flow Pembayaran:

```
Donor submit pembayaran
    ↓
Midtrans process pembayaran
    ↓
Midtrans kirim webhook notification
    ↓
DonationController->webhook() handle notifikasi
    ↓
MidtransPaymentService->handleNotification()
    ↓
Jika berhasil (settlement/capture):
    - Update donation status → "success"
    - Trigger PaymentReceiptMail queue
    ↓
Email di-queue untuk dikirim
    ↓
Email terkirim ke donor
```

## Queue Configuration

Email dikirim menggunakan queue (asynchronous) untuk better performance.

Default queue driver di Laravel adalah `sync` (synchronous - langsung terkirim).

Untuk production, gunakan:
- Redis queue
- Database queue

Edit `.env`:
```env
QUEUE_CONNECTION=redis  # atau "database"
```

## Troubleshooting

### Email tidak terkirim

1. **Check konfigurasi .env**
   ```bash
   php artisan config:show mail
   ```

2. **Test email connection**
   ```bash
   php artisan email:test-payment your-email@example.com
   ```

3. **Check log files**
   ```bash
   tail -f storage/logs/laravel.log
   ```

4. **Jika menggunakan queue, pastikan queue worker running**
   ```bash
   php artisan queue:listen
   ```

### Email masuk spam

- Pastikan MAIL_FROM_ADDRESS adalah email yang valid
- Setup SPF, DKIM, DMARC records jika domain Anda sendiri
- Gunakan email service yang terpercaya (SendGrid, Sendinblue, dll)

## Informasi Lebih Lanjut

- Laravel Mail Documentation: https://laravel.com/docs/11.x/mail
- Mailtrap: https://mailtrap.io
- SendGrid: https://sendgrid.com
- Sendinblue: https://www.brevo.com

## Testing Menggunakan Command Line

Untuk mengirim test email secara manual tanpa menunggu webhook:

```bash
php artisan email:test-payment test@gmail.com
```

Maka akan:
1. Create test donation record
2. Send payment receipt email
3. Delete test donation record
4. Show success/error message
