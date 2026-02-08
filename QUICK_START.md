# 🚀 QUICK START - Aplikasi Donasi Online

Panduan cepat untuk menjalankan aplikasi dalam 5 menit!

## ⚡ Setup Cepat

### Langkah 1: Install Dependencies (2 menit)
```bash
composer install
npm install
```

### Langkah 2: Setup Database (1 menit)
```bash
# MySQL: Buat database
mysql -u root -e "CREATE DATABASE donasi_app;"

# Jalankan migrations
php artisan migrate
```

### Langkah 3: Setup Midtrans Credentials (1 menit)

Edit `.env`:
```env
MIDTRANS_SERVER_KEY=your_server_key_here
MIDTRANS_CLIENT_KEY=your_client_key_here
MIDTRANS_ENVIRONMENT=sandbox
MIDTRANS_MERCHANT_ID=your_merchant_id
```

### Langkah 4: Run Server (1 menit)
```bash
# Terminal 1
php artisan serve

# Terminal 2
npm run dev
```

**✅ Ready! Buka:** http://localhost:8000

## 🎯 Fitur Yang Tersedia

| Fitur | URL | Deskripsi |
|-------|-----|-----------|
| 🏠 Beranda | `/` | Landing page dengan info |
| 📋 Form Donasi | `/donasi/form` | Isi form donasi baru |
| 💳 Pembayaran | `/donasi/{id}/pembayaran` | Proses pembayaran |
| 📊 Admin Dashboard | `/admin/dashboard` | Lihat statistik donasi |
| 🏦 Kelola Rekening | `/admin/bank-accounts` | Add/edit rekening bank |
| 📜 Daftar Donasi | `/donasi/daftar/sukses` | Lihat semua donasi sukses |

## 🔑 Login Admin

Tidak ada auth khusus di versi beta. Akses langsung ke:
- `/admin/dashboard` - Dashboard
- `/admin/bank-accounts` - Manajemen rekening

## 🎮 Test Payment

**Sandbox Midtrans:**
- Kartu: `4811 1111 1111 1114`
- Bulan: `12`
- Tahun: `25`
- CVC: `123`

## 📝 Database Schema

### Donations Table
```sql
- id
- donor_name
- donor_email
- donor_phone
- amount
- campaign_title
- message
- payment_method (qris/bank_transfer)
- status (pending/success/failed/expired)
- transaction_id
- payment_token
- payment_completed_at
- timestamps
```

### Bank Accounts Table
```sql
- id
- bank_name
- account_number
- account_holder_name
- description
- is_active
- timestamps
```

## 📂 File Penting

| File | Fungsi |
|------|--------|
| `config/midtrans.php` | Konfigurasi Midtrans |
| `app/Models/Donation.php` | Model donasi |
| `app/Http/Controllers/DonationController.php` | Controller donasi |
| `app/Services/MidtransPaymentService.php` | Service pembayaran |
| `resources/views/donations/` | Views donasi |
| `routes/web.php` | Routes aplikasi |

## 🔍 Debugging

**Lihat logs:**
```bash
tail -f storage/logs/laravel.log
```

**Debug Midtrans:**
```php
// Di controller
\Log::info('Midtrans Notification:', $notificationPayload);
```

**Clear cache:**
```bash
php artisan cache:clear
php artisan view:clear
```

## 🆘 Troubleshooting

| Masalah | Solusi |
|--------|--------|
| Database tidak connect | Check .env DB credentials |
| Assets tidak load | Run `npm run build` |
| Pagination error | Publish vendor: `php artisan vendor:publish` |
| Midtrans error | Verify API keys di .env |

## 📚 Dokumentasi Lengkap

Lihat `SETUP_GUIDE.md` untuk panduan lengkap.

## ✨ Next Steps

1. ✅ Verifikasi database terisi dengan donasi
2. ✅ Test pembayaran QRIS di sandbox
3. ✅ Tambah rekening bank di admin
4. ✅ Test transfer bank method
5. ✅ Setup webhook Midtrans
6. ✅ Deploy ke production

---

**Need Help?** Check SETUP_GUIDE.md atau dokumentasi Midtrans: https://docs.midtrans.com
