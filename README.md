# 🎁 Aplikasi Donasi Online dengan Midtrans

Platform donasi online modern dengan sistem pembayaran QRIS dan transfer bank terintegrasi.

## ✨ Fitur Utama

- ✅ **Pembayaran QRIS** - Scan dengan mudah menggunakan e-wallet
- ✅ **Transfer Bank** - Support multiple rekening bank
- ✅ **Admin Dashboard** - Monitor statistik donasi real-time
- ✅ **Integrasi Midtrans** - Payment gateway terpercaya
- ✅ **Notifikasi Otomatis** - Webhook untuk real-time updates
- ✅ **Responsive Design** - Mobile-friendly interface
- ✅ **Manajemen Rekening** - Kelola bank accounts dengan mudah

## 🚀 Quick Start

### Requirements
- PHP 8.1+
- Laravel 11.x
- MySQL 8.0+
- Node.js 18+

### Installation

```bash
# 1. Install dependencies
composer install
npm install

# 2. Setup database
mysql -u root -e "CREATE DATABASE donasi_app;"
php artisan migrate

# 3. Setup Midtrans (edit .env)
MIDTRANS_SERVER_KEY=your_key
MIDTRANS_CLIENT_KEY=your_key
MIDTRANS_ENVIRONMENT=sandbox

# 4. Run server
php artisan serve    # Terminal 1
npm run dev          # Terminal 2
```

Buka: **http://localhost:8000**

## 📚 Dokumentasi

- **[QUICK_START.md](QUICK_START.md)** - Setup dalam 5 menit
- **[SETUP_GUIDE.md](SETUP_GUIDE.md)** - Panduan lengkap
- **[API_DOCUMENTATION.md](API_DOCUMENTATION.md)** - Referensi API

## 🎯 Routes

| URL | Purpose |
|-----|---------|
| `/` | Landing page |
| `/donasi/form` | Form donasi |
| `/donasi/{id}/pembayaran` | Halaman pembayaran |
| `/donasi/daftar/sukses` | Daftar donasi sukses |
| `/admin/dashboard` | Dashboard admin |
| `/admin/bank-accounts` | Manajemen rekening |

## 💾 Database Schema

### Donations
```
- id, donor_name, donor_email, donor_phone
- amount, campaign_title, message
- payment_method (qris/bank_transfer)
- status (pending/success/failed/expired)
- transaction_id, payment_token
- payment_completed_at, timestamps
```

### Bank Accounts
```
- id, bank_name, account_number, account_holder_name
- description, is_active, timestamps
```

## 🔧 Teknologi

- **Laravel 11** - Backend framework
- **Tailwind CSS** - Styling
- **Vite** - Asset bundling
- **Midtrans** - Payment gateway
- **MySQL** - Database

## 📦 Project Structure

```
app/
├── Models/               # Eloquent models
├── Http/Controllers/    # Application controllers
└── Services/            # Business logic services

config/
└── midtrans.php         # Midtrans configuration

database/
├── migrations/          # Database migrations
└── seeders/             # Database seeders

resources/
├── views/               # Blade templates
├── css/                 # Stylesheets
└── js/                  # JavaScript

routes/
└── web.php              # Application routes
```

## 🔐 Keamanan

- ✅ CSRF protection
- ✅ Input validation
- ✅ HTTPS recommended
- ✅ Midtrans security
- ✅ Database query protection

## 🧪 Testing

**Test Payment (Sandbox):**
- Kartu: `4811 1111 1111 1114`
- Bulan: `12` | Tahun: `25` | CVC: `123`

```bash
# View logs
tail -f storage/logs/laravel.log

# Clear cache
php artisan cache:clear
```

## 🚀 Deployment

```bash
# Build for production
npm run build
php artisan optimize

# Deploy steps
composer install --no-dev
php artisan migrate --force
php artisan config:cache
```

**Checklist:**
- [ ] HTTPS enabled
- [ ] Environment to production
- [ ] Database backed up
- [ ] Midtrans keys updated
- [ ] Webhook URL configured
- [ ] Error logging setup

## 📞 Support

- Midtrans Docs: https://docs.midtrans.com
- Laravel Docs: https://laravel.com/docs
- Check troubleshooting in SETUP_GUIDE.md

## 📝 License

MIT License - see LICENSE file

## 🙏 Credits

Built with ❤️ for charitable organizations

---

**Version:** 1.0.0  
**Last Updated:** February 2025

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
