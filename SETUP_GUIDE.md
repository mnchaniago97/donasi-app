# 🎁 Aplikasi Donasi Online - Panduan Setup dan Penggunaan

Selamat datang di aplikasi donasi online dengan sistem pembayaran QRIS dan transfer bank terintegrasi dengan Midtrans!

## 📋 Persyaratan Sistem

- PHP 8.1+
- Laravel 11.x
- MySQL 8.0+
- Node.js 18+
- Composer
- Git

## 🚀 Instalasi & Setup

### 1. Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install Node dependencies
npm install

# Build frontend assets
npm run build
```

### 2. Konfigurasi Database

```bash
# Buat database baru
mysql -u root -e "CREATE DATABASE donasi_app;"

# Jalankan migrations
php artisan migrate

# (Opsional) Jalankan seeders jika ada
php artisan db:seed
```

### 3. Konfigurasi Midtrans

Edit file `.env` dan tambahkan konfigurasi Midtrans Anda:

```env
MIDTRANS_ENABLED=true
MIDTRANS_SERVER_KEY=your_server_key_here
MIDTRANS_CLIENT_KEY=your_client_key_here
MIDTRANS_ENVIRONMENT=sandbox  # atau production
MIDTRANS_MERCHANT_ID=your_merchant_id
```

**Dapatkan kredensial Midtrans:**
1. Daftar di [Midtrans.com](https://midtrans.com)
2. Buat akun merchant
3. Copy Server Key dan Client Key dari dashboard
4. Gunakan di `.env`

### 4. Generate Application Key

```bash
php artisan key:generate
```

### 5. Jalankan Server

```bash
# Terminal 1: Jalankan Laravel server
php artisan serve

# Terminal 2: Jalankan Vite development server
npm run dev
```

Aplikasi akan berjalan di: `http://localhost:8000`

## 📁 Struktur Aplikasi

```
app/
├── Models/
│   ├── Donation.php           # Model untuk donasi
│   └── BankAccount.php        # Model untuk rekening bank
├── Http/
│   └── Controllers/
│       ├── DonationController.php      # Controller untuk donasi
│       └── BankAccountController.php   # Controller untuk rekening bank
└── Services/
    └── MidtransPaymentService.php      # Service untuk pembayaran Midtrans

config/
└── midtrans.php               # Konfigurasi Midtrans

database/
├── migrations/
│   ├── 2025_02_08_000000_create_donations_table.php
│   └── 2025_02_08_000001_create_bank_accounts_table.php
└── seeders/

resources/
└── views/
    ├── layouts/
    │   └── app.blade.php      # Layout utama
    ├── donations/
    │   ├── create.blade.php   # Form donasi
    │   ├── payment.blade.php  # Halaman pembayaran
    │   ├── show.blade.php     # Detail donasi
    │   ├── list.blade.php     # Daftar donasi sukses
    │   └── dashboard.blade.php # Dashboard admin
    ├── bank-accounts/
    │   ├── index.blade.php    # Daftar rekening
    │   ├── create.blade.php   # Form tambah rekening
    │   └── edit.blade.php     # Form edit rekening
    └── welcome.blade.php      # Halaman depan

routes/
└── web.php                    # Routes aplikasi
```

## 🎯 Fitur Utama

### 1. **Halaman Donasi**
- Form donasi dengan validasi
- Pilihan metode pembayaran (QRIS / Transfer Bank)
- Input data donatur (nama, email, telepon)
- Pesan personal opsional
- Validasi jumlah minimum Rp 10.000

### 2. **Pembayaran QRIS**
- Integrasi Snap Midtrans
- Widget embed untuk payment gateway
- Auto-detecting QRIS payment
- Notifikasi status pembayaran real-time

### 3. **Pembayaran Transfer Bank**
- Daftar rekening bank yang dapat dikelola
- Copy nomor rekening dengan 1 klik
- Support multiple bank accounts
- Notifikasi pembayaran otomatis

### 4. **Admin Dashboard**
- Statistik donasi (total, jumlah, rata-rata)
- Daftar donasi terbaru
- Monitor donasi bulanan
- Manajemen rekening bank

### 5. **Rekening Bank Management**
- Tambah/edit/hapus rekening
- Aktifkan/nonaktifkan rekening
- Support berbagai bank (BCA, BNI, Mandiri, BTN, etc.)

## 🔐 Keamanan API Midtrans

### Notifikasi Webhook

Aplikasi akan menerima notifikasi pembayaran dari Midtrans ke endpoint:
```
POST /donasi/webhook/midtrans
```

**Setup di Midtrans Dashboard:**
1. Masuk ke Midtrans Dashboard
2. Settings → Notification URL
3. Isikan URL: `https://yourdomain.com/donasi/webhook/midtrans`
4. Pilih: HTTP POST

### Endpoint Produksi

Ubah `.env` ketika siap ke production:
```env
MIDTRANS_ENVIRONMENT=production
MIDTRANS_SERVER_KEY=prod_server_key
MIDTRANS_CLIENT_KEY=prod_client_key
```

## 📤 Deployment

### 1. Production Build

```bash
# Build assets untuk production
npm run build

# Optimize Laravel
php artisan config:cache
php artisan route:cache
php artisan optimize
```

### 2. Upload ke Server

```bash
# Gunakan Git atau FTP untuk upload
# Jangan upload folder: node_modules, .env (setup di server)

# Di server, jalankan:
composer install --no-dev
php artisan migrate --force
```

### 3. SSL Certificate

Pastikan HTTPS diaktifkan. Midtrans memerlukan HTTPS untuk production.

## 🧪 Testing

### Test Payment (Sandbox Mode)

Gunakan kartu test dari Midtrans:
- **Kartu**: 4811 1111 1111 1114
- **Ekspirasi**: 12/25
- **CVC**: 123

### Test QRIS

Scan dengan aplikasi e-wallet test atau simulator Midtrans.

## 📚 API Routes

### Routes Donasi (Public)
```
GET    /donasi/form              -> Tampilkan form donasi
POST   /donasi                   -> Simpan donasi baru
GET    /donasi/{id}/pembayaran   -> Halaman pembayaran
GET    /donasi/{id}/status       -> Lihat detail donasi
POST   /donasi/{id}/check-status -> Cek status pembayaran
POST   /donasi/webhook/midtrans  -> Webhook Midtrans
GET    /donasi/daftar/sukses     -> Daftar donasi sukses
```

### Routes Admin
```
GET    /admin/dashboard          -> Dashboard statistik
GET    /admin/bank-accounts      -> Daftar rekening
GET    /admin/bank-accounts/create -> Form tambah rekening
POST   /admin/bank-accounts      -> Simpan rekening
GET    /admin/bank-accounts/{id}/edit -> Form edit rekening
PUT    /admin/bank-accounts/{id} -> Update rekening
DELETE /admin/bank-accounts/{id} -> Hapus rekening
```

## 🐛 Troubleshooting

### Database Connection Error
```bash
# Check koneksi DB di .env
# Ensure MySQL service berjalan
# Buat database manual jika perlu

mysql -u root -e "CREATE DATABASE donasi_app;"
```

### Midtrans Keys Invalid
```
Error: Invalid server key atau client key
→ Verifikasi kredensial di .env
→ Pastikan sudah copy dari dashboard Midtrans yang benar
→ Periksa environment (sandbox vs production)
```

### Assets Not Loading
```bash
# Rebuild assets
npm run build

# Clear cache
php artisan view:clear
php artisan cache:clear
```

### Database Migration Error
```bash
# Reset database dan migrate ulang
php artisan migrate:refresh
php artisan db:seed
```

## 📞 Support

Untuk bantuan:
1. Lihat dokumentasi Midtrans: https://docs.midtrans.com
2. Check Laravel documentation: https://laravel.com/docs
3. Hubungi tim support

## 📝 Catatan Penting

1. **Sandbox vs Production:**
   - Mulai dengan sandbox mode untuk testing
   - Switch ke production setelah semua tested

2. **Database Maintenance:**
   - Regular backup database
   - Monitor file storage untuk logs

3. **Performance:**
   - Enable database query cache
   - Optimalkan assets dengan minification
   - Setup CDN untuk static files

4. **Security:**
   - Keep Laravel dan dependencies updated
   - Use strong APP_KEY
   - Enable HTTPS untuk production
   - Validate semua user inputs

## 🎉 Selesai!

Aplikasi donasi Anda siap digunakan. Selamat berkontribusi! 🚀

---

**Versi**: 1.0.0  
**Last Updated**: February 2025  
**License**: MIT
