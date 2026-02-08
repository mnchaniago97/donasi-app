# Email Configuration untuk Notifikasi Donasi

## Konfigurasi Saat Ini

```env
MAIL_DRIVER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=465
MAIL_USERNAME=xxx
MAIL_PASSWORD=xxx
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="no-reply@donasi.mudacita.or.id"
MAIL_FROM_NAME="Mudacita Donasi"
APP_NAME="Mudacita Donasi"
```

## Email yang Dikirim

### 1. **Bukti Pembayaran (Payment Receipt)**
- **Dikirim ke:** Email donatur
- **From:** no-reply@donasi.mudacita.or.id
- **From Name:** Mudacita Donasi
- **Subject:** Bukti Pembayaran Donasi - Mudacita Donasi
- **Trigger:** Ketika pembayaran berhasil (webhook dari Midtrans)
- **Template:** `resources/views/emails/payment-receipt.blade.php`

### 2. **Kapan Email Dikirim**

Email bukti pembayaran otomatis dikirim ke donatur ketika:
1. Donor melakukan pembayaran melalui salah satu metode:
   - QRIS
   - Transfer Bank
   - Dana
   - GoPay

2. Midtrans memberikan notifikasi pembayaran berhasil (status: settlement/capture)

3. DonationController menerima webhook dan mengupdate donation status menjadi "success"

4. PaymentReceiptMail di-queue untuk dikirim

## Informasi Email Template

File: `resources/views/emails/payment-receipt.blade.php`

Menampilkan:
- ✓ Data pemberi donasi (nama, email, telepon)
- ✓ Detail donasi (kampanye, tanggal, metode pembayaran)
- ✓ Jumlah donasi
- ✓ Status pembayaran (Berhasil)
- ✓ Referensi/ID Transaksi
- ✓ Waktu konfirmasi pembayaran
- ✓ Instruksi dan catatan penting

## Testing Email

Untuk test email configuration:

```bash
php artisan email:test-payment test@gmail.com
```

Email test akan dikirim ke alamat yang Anda berikan dengan data dummy.

## Produksi vs Development

### Development (Mailtrap)
- Email tidak benar-benar terkirim
- Semua email masuk ke inbox Mailtrap untuk testing
- Berguna untuk development tanpa spam

### Production (Real SMTP)
Ganti credentials dengan:
- SendGrid API
- Sendinblue/Brevo
- AWS SES
- Mailgun
- Email host provider Anda

Contoh production config:
```env
MAIL_DRIVER=sendgrid
SENDGRID_API_KEY=your-sendgrid-api-key
```

atau:

```env
MAIL_DRIVER=smtp
MAIL_HOST=mail.yourdomain.com
MAIL_PORT=587
MAIL_USERNAME=noreply@yourdomain.com
MAIL_PASSWORD=your-password
```

## Troubleshooting

### Email tidak terkirim
1. Check `.env` configuration
2. Verify credentials terbaru dari SMTP provider
3. Check Laravel logs: `storage/logs/laravel.log`
4. Test connectivity: `php artisan email:test-payment test@example.com`

### Email masuk spam
- Setup SPF/DKIM/DMARC records untuk domain
- Gunakan email provider yang terpercaya
- Jangan frequent error notifications

### Queue tidak process
Jika menggunakan database queue:
```bash
php artisan queue:listen
```

Untuk production, setup queue worker:
```bash
php artisan queue:work
```
