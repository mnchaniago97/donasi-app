# 🔐 Admin Login Setup Guide

## ✅ Credentials Sudah Dibuat

Admin account telah dibuat secara otomatis saat menjalankan migrations dan seeds.

### Login Details:
```
Email:    admin@donasi.app
Password: admin123456
URL:      http://localhost:8000/auth/login
```

## 🚀 Cara Login

### Step 1: Akses Halaman Login
Buka: [http://localhost:8000/auth/login](http://localhost:8000/auth/login)

atau dari homepage, klik tombol "Login Admin" di navigation bar.

### Step 2: Masukkan Credentials
- **Email:** admin@donasi.app
- **Password:** admin123456

### Step 3: Masuk ke Admin Dashboard
Setelah login berhasil, Anda akan diarahkan ke:
[http://localhost:8000/admin/dashboard](http://localhost:8000/admin/dashboard)

## 📊 Admin Dashboard Features

### 1. **Statistics Overview**
- Total Donasi
- Total Terkumpul
- Rata-rata Donasi
- Donasi Bulan Ini

### 2. **Recent Donations**
- Tampilkan 10 donasi terbaru
- Info donatur (nama, email, jumlah)
- Metode pembayaran
- Tanggal pembayaran

### 3. **Quick Actions**
- Kelola Rekening Bank
- Lihat Semua Donasi
- Tambah Donasi Manual

## 🏦 Manajemen Rekening Bank

### Akses Rekening Bank
1. Login ke Admin Dashboard
2. Klik "Kelola Rekening Bank"
3. atau langsung ke: [http://localhost:8000/admin/bank-accounts](http://localhost:8000/admin/bank-accounts)

### Tambah Rekening Baru
1. Klik tombol "+ Tambah Rekening"
2. Isi form dengan data rekening bank
3. Pilih bank (BCA, BNI, Mandiri, dll)
4. Masukkan nomor rekening dan nama pemilik
5. Klik "Simpan Rekening"

### Contoh Data Rekening:
```
Bank:                BCA
Nomor Rekening:      1234567890
Nama Pemilik:        PT Donasi Indonesia
Deskripsi:           Rekening utama untuk penerimaan donasi
```

## 🔒 Keamanan Password

⚠️ **PENTING: Ganti Password Setelah Login Pertama**

Untuk mengubah password, gunakan salah satu cara:

### Opsi 1: Via Tinker (Development)
```bash
php artisan tinker
```

```php
use App\Models\User;
use Illuminate\Support\Facades\Hash;

$admin = User::where('email', 'admin@donasi.app')->first();
$admin->password = Hash::make('password_baru');
$admin->save();
```

### Opsi 2: Update Langsung di Database
```sql
UPDATE users SET password = SHA2(CONCAT('password_baru', 'salt'), 256) 
WHERE email = 'admin@donasi.app';
```

*Catatan: Gunakan password_hash() atau Hash::make() dari Laravel untuk security.*

## 🔑 Lupa Password?

Jika lupa password, reset dengan:

```bash
php artisan tinker
```

```php
use App\Models\User;
use Illuminate\Support\Facades\Hash;

$admin = User::where('email', 'admin@donasi.app')->first();
$admin->password = Hash::make('admin123456');
$admin->save();
```

## ✔️ Troubleshooting

### Error: "Login Failed"
**Solusi:**
- Pastikan email dan password benar
- Periksa database sudah ter-seed: `php artisan db:seed`
- Pastikan user tabel sudah ter-create: `php artisan migrate`

### Error: "Halaman tidak ditemukan"
**Solusi:**
- Clear cache: `php artisan cache:clear`
- Restart server: `php artisan serve`

### Admin User Tidak Ada
**Solusi:**
```bash
# Jalankan seeder
php artisan db:seed --class=AdminSeeder

# atau reset semua
php artisan migrate:refresh --seed
```

### Logout Tidak Bekerja
**Solusi:**
- Clear cache: `php artisan cache:clear` 
- Pastikan session sudah ter-set di `config/session.php`
- Restart browser

## 📝 User Management

### Lihat Semua Admin Users
```bash
php artisan tinker
```

```php
use App\Models\User;
User::all();
```

### Tambah Admin User Baru
```bash
php artisan tinker
```

```php
use App\Models\User;
use Illuminate\Support\Facades\Hash;

User::create([
    'name' => 'Admin 2',
    'email' => 'admin2@donasi.app',
    'password' => Hash::make('password123'),
]);
```

### Hapus Admin User
```bash
php artisan tinker
```

```php
use App\Models\User;
$user = User::where('email', 'admin2@donasi.app')->first();
$user->delete();
```

## 🔐 Security Notes

1. ✅ Password di-hash menggunakan bcrypt
2. ✅ Session di-protect dengan CSRF token
3. ✅ Admin routes di-protect dengan auth middleware
4. ✅ Logout invalidates session
5. ⚠️ Jangan share credentials
6. ⚠️ Ganti default password setelah setup

## 🛣️ Routes

| URL | Method | Action |
|-----|--------|--------|
| `/auth/login` | GET | Show login form |
| `/auth/login` | POST | Handle login |
| `/auth/logout` | POST | Handle logout |
| `/admin/dashboard` | GET | Admin dashboard |
| `/admin/bank-accounts` | GET | Daftar rekening |
| `/admin/bank-accounts/create` | GET | Form tambah rekening |
| `/admin/bank-accounts` | POST | Simpan rekening |
| `/admin/bank-accounts/{id}/edit` | GET | Form edit rekening |
| `/admin/bank-accounts/{id}` | PUT | Update rekening |
| `/admin/bank-accounts/{id}` | DELETE | Hapus rekening |

## 💡 Tips

- Gunakan "Remember Me" option untuk tetap login
- Admin dashboard dapat diakses hanya setelah login
- Logout secara otomatis menghapus session
- Setiap akses admin routes dicek auth middleware
- Error message untuk keamanan dibuat general

---

## Ready to Go! 🎉

Login ke admin panel Anda dan mulai manage donasi!

**URL:** http://localhost:8000/auth/login  
**Email:** admin@donasi.app  
**Password:** admin123456  

---

*Jangan lupa untuk mengganti password default!* ⚠️
