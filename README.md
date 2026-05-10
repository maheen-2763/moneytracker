<div align="center">

# 💰 MoneyTracker

**A full-featured personal finance web application**

[![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?style=flat&logo=php)](https://php.net)
[![Laravel](https://img.shields.io/badge/Laravel-11-FF2D20?style=flat&logo=laravel)](https://laravel.com)
[![Tests](https://img.shields.io/badge/Tests-57%20passing-22c55e?style=flat)](https://pestphp.com)
[![License](https://img.shields.io/badge/License-MIT-6366f1?style=flat)](LICENSE)

[Live Demo](#) · [API Docs](#) · [Report Bug](#)

</div>

---

## 📸 Screenshots

| Dashboard                          | Expenses                       | Admin                    |
| ---------------------------------- | ------------------------------ | ------------------------ |
| ![Dashboard](images/dashboard.png) | ![Expenses](docs/expenses.png) | ![Admin](docs/admin.png) |

---

## ✨ Features

- 🔐 **Authentication** — Register, login, logout with Laravel Breeze
- 💸 **Expense CRUD** — Full create, read, update, soft-delete
- 📊 **Dashboard** — Charts, summary cards, category breakdown
- 📈 **Reports** — Filter by date/category, export PDF & Excel
- 🏷️ **Budget Limits** — Set monthly limits with progress bars
- 🔔 **Notifications** — Bell icon alerts when budget exceeded
- 👤 **User Profile** — Avatar upload, edit info, change password
- 🔒 **2FA Security** — Google Authenticator support
- 📧 **Email Notifications** — Welcome, budget alert, weekly report
- 🌙 **Dark Mode** — Persists via localStorage
- 📱 **Mobile Responsive** — Slide-in sidebar, card views
- 🛡️ **Admin Panel** — Separate admin with full management
- 🌐 **REST API** — Sanctum token auth with full docs
- 🧪 **Tests** — 57 tests, 117 assertions with PestPHP

---

## 🛠️ Tech Stack

| Layer    | Technology                               |
| -------- | ---------------------------------------- |
| Backend  | PHP 8.2, Laravel 11                      |
| Frontend | Bootstrap 5, Chart.js, Plus Jakarta Sans |
| Database | MySQL (production), SQLite (testing)     |
| Auth     | Laravel Breeze + Sanctum                 |
| 2FA      | pragmarx/google2fa-laravel               |
| PDF      | barryvdh/laravel-dompdf                  |
| Excel    | maatwebsite/laravel-excel                |
| Testing  | PestPHP — 57 tests                       |
| Mail     | SMTP (Mailtrap/Gmail)                    |

---

## 🚀 Quick Start

### Requirements

- PHP 8.2+
- Composer
- Node.js & NPM
- MySQL

### Installation

```bash
# 1. Clone
git clone https://github.com/maheen-2763/moneytracker.git
cd moneytracker

# 2. Install dependencies
composer install
npm install

# 3. Environment
cp .env.example .env
php artisan key:generate

# 4. Configure .env
# Set DB_DATABASE, DB_USERNAME, DB_PASSWORD
# Set MAIL_* credentials

# 5. Database
php artisan migrate --seed

# 6. Storage
php artisan storage:link

# 7. Build assets
npm run build

# 8. Serve
php artisan serve
```

Visit `http://moneytracker.test`

---

## 👑 Admin Access

```bash
# Create admin account
php artisan db:seed --class=AdminSeeder

# Login at: /admin/login
# Email:    admin@moneytracker.com
# Password: admin123
```

---

## 🧪 Running Tests

```bash
# All tests
php artisan test

# Specific suite
php artisan test --filter=BudgetTest

# With coverage
php artisan test --coverage
```

```
Tests:    57 passed (117 assertions)
Duration: 5.68s
```

---

## 🌐 API

Base URL: `/api/v1`

| Method | Endpoint     | Description    |
| ------ | ------------ | -------------- |
| POST   | `/login`     | Get auth token |
| POST   | `/register`  | Create account |
| GET    | `/expenses`  | List expenses  |
| POST   | `/expenses`  | Create expense |
| GET    | `/budgets`   | List budgets   |
| GET    | `/dashboard` | Summary stats  |

Full docs at `/api/docs`

---

## 📁 Project Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Api/          ← REST API controllers
│   │   ├── Admin/        ← Admin panel controllers
│   │   └── ...           ← Web controllers
│   ├── Middleware/
│   │   ├── AdminMiddleware.php
│   │   └── RequiresTwoFactor.php
│   └── Requests/         ← Form validation
├── Models/               ← Eloquent models
├── Mail/                 ← Email classes
├── Notifications/        ← DB notifications
└── Services/             ← Business logic

resources/views/
├── admin/                ← Admin panel views
├── api/                  ← API documentation
├── auth/                 ← Login, register, 2FA
├── components/           ← Blade components
├── emails/               ← Email templates
└── ...                   ← Feature views
```

---

## 👨‍💻 Author

**Mohammed Maheen Afzal**

[![GitHub](https://img.shields.io/badge/GitHub-yourusername-181717?style=flat&logo=github)](https://github.com/maheen-2763)
[![LinkedIn](https://img.shields.io/badge/LinkedIn-yourprofile-0A66C2?style=flat&logo=linkedin)](https://linkedin.com/in/yourprofile)

---

## 📄 License

MIT License — free to use for learning and portfolio purposes.
