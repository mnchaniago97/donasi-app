# 📖 API Documentation - Aplikasi Donasi Online

Dokumentasi lengkap API endpoints untuk aplikasi donasi online.

## 🔐 Authentication

Aplikasi ini **tidak menggunakan authentication token** di versi beta. Semua endpoint public dan admin dapat diakses langsung.

**TODO untuk production:**
- Implementasi Laravel Sanctum untuk API tokens
- Implementasi middleware untuk proteksi admin routes

## 📡 Base URL

```
http://localhost:8000
```

## 🎁 Donasi Endpoints

### 1. **Dapatkan Form Donasi**

```bash
GET /donasi/form
```

**Response:** HTML form untuk donasi

---

### 2. **Buat Donasi Baru**

```bash
POST /donasi
Content-Type: application/x-www-form-urlencoded
```

**Request Parameters:**
```
donor_name        : string (required, max 255)
donor_email       : email (required)
donor_phone       : string (optional, max 20)
amount            : numeric (required, minimum 10000)
campaign_title    : string (optional, max 255)
message           : string (optional, max 1000)
payment_method    : string (required, qris|bank_transfer)
```

**Example Request:**
```bash
curl -X POST http://localhost:8000/donasi \
  -H "Content-Type: application/x-www-form-urlencoded" \
  -d "donor_name=John Doe" \
  -d "donor_email=john@example.com" \
  -d "donor_phone=08123456789" \
  -d "amount=100000" \
  -d "campaign_title=Bantuan Bencana" \
  -d "message=Semoga membantu" \
  -d "payment_method=qris"
```

**Response:** Redirect ke halaman pembayaran

**Status Codes:**
- `302` - Redirect ke payment page
- `422` - Validation error

---

### 3. **Halaman Pembayaran**

```bash
GET /donasi/{donation_id}/pembayaran
```

**URL Parameters:**
```
donation_id : integer (ID dari donation)
```

**Response:** HTML payment page dengan Snap widget

---

### 4. **Dapatkan Detail Donasi**

```bash
GET /donasi/{donation_id}/status
```

**URL Parameters:**
```
donation_id : integer
```

**Response:** HTML halaman dengan detail donasi

---

### 5. **Cek Status Pembayaran**

```bash
POST /donasi/{donation_id}/check-status
Content-Type: application/json
X-CSRF-TOKEN: {csrf_token}
```

**Request Body:**
```json
{}
```

**Response:**
```json
{
  "status": "success|pending|failed|expired",
  "donation": {
    "id": 1,
    "donor_name": "John Doe",
    "donor_email": "john@example.com",
    "amount": 100000,
    "status": "success",
    "payment_method": "qris",
    "payment_completed_at": "2025-02-08 10:30:00"
  }
}
```

**Status Codes:**
- `200` - Success
- `404` - Donation not found

---

### 6. **Midtrans Webhook Notification**

```bash
POST /donasi/webhook/midtrans
Content-Type: application/json
```

**Request Body** (dari Midtrans):
```json
{
  "transaction_time": "2025-02-08 10:30:00",
  "transaction_status": "settlement",
  "transaction_id": "1234567890",
  "status_message": "Settlement has been processed",
  "status_code": "200",
  "signature_key": "...",
  "settlement_time": "2025-02-08 10:31:00",
  "payment_type": "qris",
  "order_id": "1-1707374400",
  "merchant_id": "G141532590",
  "masked_card": null,
  "fraud_status": "accept"
}
```

**Response:**
```json
{
  "success": true,
  "message": "Payment confirmed|Payment pending|Payment failed|Status updated"
}
```

**Transaction Status Values:**
- `capture` - Pembayaran berhasil (credit card)
- `settlement` - Settlement berhasil (transfer)
- `pending` - Menunggu pembayaran
- `deny` - Pembayaran ditolak
- `cancel` - Pembayaran dibatalkan
- `expire` - Pembayaran expired

---

### 7. **Daftar Donasi Sukses**

```bash
GET /donasi/daftar/sukses
```

**Query Parameters:**
```
page : integer (optional, default 1)
```

**Response:** HTML dengan daftar donasi yang berhasil (paginated)

---

## 🏦 Bank Account Endpoints

### 1. **Dapatkan Daftar Rekening Bank**

```bash
GET /admin/bank-accounts
```

**Response:** HTML dengan daftar semua rekening bank

---

### 2. **Dapatkan Form Tambah Rekening**

```bash
GET /admin/bank-accounts/create
```

**Response:** HTML form untuk tambah rekening baru

---

### 3. **Buat Rekening Bank Baru**

```bash
POST /admin/bank-accounts
Content-Type: application/x-www-form-urlencoded
```

**Request Parameters:**
```
bank_name             : string (required, max 255)
account_number        : string (required, max 255, unique)
account_holder_name   : string (required, max 255)
description           : string (optional)
is_active             : boolean (optional, default true)
```

**Example:**
```bash
curl -X POST http://localhost:8000/admin/bank-accounts \
  -H "Content-Type: application/x-www-form-urlencoded" \
  -d "bank_name=BCA" \
  -d "account_number=1234567890" \
  -d "account_holder_name=PT Donasi Indonesia" \
  -d "description=Rekening utama" \
  -d "is_active=1"
```

**Response:** Redirect ke `/admin/bank-accounts` dengan flash message

**Status Codes:**
- `302` - Redirect success
- `422` - Validation error

---

### 4. **Dapatkan Form Edit Rekening**

```bash
GET /admin/bank-accounts/{bank_account_id}/edit
```

**Response:** HTML form untuk edit rekening

---

### 5. **Update Rekening Bank**

```bash
PUT /admin/bank-accounts/{bank_account_id}
Content-Type: application/x-www-form-urlencoded
```

**Request Parameters:** (same as create)

**Response:** Redirect ke `/admin/bank-accounts`

---

### 6. **Hapus Rekening Bank**

```bash
DELETE /admin/bank-accounts/{bank_account_id}
```

**Response:** Redirect dengan flash message

---

## 📊 Admin Dashboard

### Dashboard Statistics

```bash
GET /admin/dashboard
```

**Response:** HTML dashboard dengan:
- Total donasi
- Total terkumpul
- Rata-rata donasi
- Donasi bulan ini
- Daftar 10 donasi terbaru

---

## 💾 Database Models

### Donation Model

```php
class Donation extends Model {
    protected $fillable = [
        'donor_name',
        'donor_email',
        'donor_phone',
        'amount',
        'campaign_title',
        'message',
        'payment_method',
        'status',
        'transaction_id',
        'payment_token',
        'payment_completed_at',
    ];
    
    public function isSuccess(): bool {}
    public function isPending(): bool {}
    public function scopeCompleted($query) {}
}
```

### BankAccount Model

```php
class BankAccount extends Model {
    protected $fillable = [
        'bank_name',
        'account_number',
        'account_holder_name',
        'description',
        'is_active',
    ];
    
    public function scopeActive($query) {}
}
```

---

## 🔄 Payment Flow

```
1. User isi form donasi
   ↓
2. System buat Donation (status: pending)
   ↓
3. Generate payment token ke Midtrans
   ↓
4. Tampilkan payment page (Snap widget)
   ↓
5. User pilih metode & bayar
   ↓
6. Midtrans konfirmasi pembayaran via webhook
   ↓
7. System update status menjadi "success"
   ↓
8. Tampilkan halaman konfirmasi sukses
```

---

## 🧪 Testing Endpoints

### Test dengan cURL

**Buat donasi:**
```bash
curl -X POST http://localhost:8000/donasi \
  -d "donor_name=Test User" \
  -d "donor_email=test@example.com" \
  -d "amount=50000" \
  -d "payment_method=qris" \
  -L
```

**Cek status:**
```bash
curl http://localhost:8000/donasi/1/status -s | grep "success\|pending\|failed"
```

**Lihat logs:**
```bash
tail -f storage/logs/laravel.log | grep -i donation
```

### Test dengan Postman

Import collection:
1. `GET` http://localhost:8000/donasi/form
2. `POST` http://localhost:8000/donasi
3. `GET` http://localhost:8000/donasi/1/pembayaran
4. `POST` http://localhost:8000/donasi/1/check-status

---

## ⚠️ Error Handling

### Validation Errors

```json
{
  "message": "The given data was invalid.",
  "errors": {
    "amount": ["The amount must be at least 10000."],
    "donor_email": ["The donor email must be a valid email address."]
  }
}
```

### Not Found Error

```json
{
  "message": "Donation not found"
}
```

---

## 🔒 Security Notes

1. Semua input di-validate menggunakan Laravel validation
2. CSRF token required untuk POST/PUT/DELETE requests
3. Midtrans webhook signature di-verify
4. Email tidak di-expose (hanya untuk verifikasi)
5. Gunakan HTTPS di production

---

## 📈 Performance Tips

1. **Enable Query Caching:**
   ```bash
   php artisan config:cache
   ```

2. **Database Indexing:**
   ```sql
   CREATE INDEX idx_donations_status ON donations(status);
   CREATE INDEX idx_donations_email ON donations(donor_email);
   ```

3. **Redis Caching:**
   Update `.env`: `CACHE_STORE=redis`

---

## 📝 Changelog

### v1.0.0 (February 2025)
- ✅ Initial release
- ✅ QRIS payment support
- ✅ Bank transfer support
- ✅ Admin dashboard
- ✅ Midtrans integration

---

## 📞 Support & Contact

- Midtrans Docs: https://docs.midtrans.com
- Laravel Docs: https://laravel.com/docs
- Report Issues: Create issue di repository

