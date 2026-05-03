# 💰 MoneyTracker

A full-featured personal finance web application built with **Laravel 11**, designed to help users track expenses, set budgets, and get alerts when spending limits are exceeded.

> Built as a portfolio project to demonstrate real-world Laravel development skills.

---

## 🌐 Live Demo

🔗 [moneytracker.yourdomain.com](https://moneytracker.yourdomain.com)

**Demo credentials:**

- Email: `demo@moneytracker.com`
- Password: `password`

---

## ✨ Features

| Feature           | Description                                        |
| ----------------- | -------------------------------------------------- |
| 🔐 Authentication | Register, login, logout via Laravel Breeze         |
| 💸 Expense CRUD   | Create, view, edit, soft-delete expenses           |
| 📊 Dashboard      | Summary cards, category breakdown, monthly charts  |
| 📈 Reports        | Filter by date/category, export to PDF & Excel     |
| 🏷️ Budgets        | Set monthly limits per category with progress bars |
| 🔔 Notifications  | Bell icon alerts when budget is exceeded           |
| 👤 Profile        | Avatar upload, edit info, change password          |
| 🌙 Dark Mode      | Persists via localStorage                          |
| 📱 Responsive     | Mobile-first with slide-in sidebar                 |

---

## 🛠️ Tech Stack

| Layer           | Technology                           |
| --------------- | ------------------------------------ |
| Backend         | PHP 8.2, Laravel 11                  |
| Frontend        | Bootstrap 5, Plus Jakarta Sans       |
| Database        | MySQL (production), SQLite (testing) |
| Auth            | Laravel Breeze                       |
| PDF Export      | barryvdh/laravel-dompdf              |
| Excel Export    | maatwebsite/laravel-excel            |
| Testing         | PestPHP — 57 tests, 117 assertions   |
| Dev Environment | Laravel Herd                         |

---

## 🚀 Local Setup

### Requirements

- PHP 8.2+
- Composer
- Node.js & NPM
- MySQL

### Installation

```bash
# 1. Clone the repo
git clone https://github.com/yourusername/moneytracker.git
cd moneytracker

# 2. Install dependencies
composer install
npm install

# 3. Environment setup
cp .env.example .env
php artisan key:generate

# 4. Configure database in .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=moneytracker
DB_USERNAME=root
DB_PASSWORD=

# 5. Run migrations and seed
php artisan migrate --seed

# 6. Create storage symlink
php artisan storage:link

# 7. Build assets
npm run dev

# 8. Start server
php artisan serve
```

Visit `http://localhost:8000`

---

## 🧪 Running Tests

```bash
# Run all tests
php artisan test

# Run specific test file
php artisan test --filter=BudgetTest

# Run with coverage report
php artisan test --coverage
```

**Test results:**

```
Tests: 57 passed (117 assertions)
Duration: 5.68s
```

---

## 📁 Project Structure

```
app/
├── Http/Controllers/
│   ├── BudgetController.php
│   ├── ExpenseController.php
│   ├── NotificationController.php
│   ├── ProfileController.php
│   ├── ReportController.php
│   └── ExportController.php
├── Models/
│   ├── Budget.php
│   ├── Expense.php
│   └── User.php
├── Notifications/
│   └── BudgetExceeded.php
└── Services/
    └── ExpenseService.php

resources/views/
├── layouts/app.blade.php
├── components/
│   ├── sidebar.blade.php
│   ├── navbar.blade.php
│   └── alert.blade.php
├── expenses/
├── budgets/
├── reports/
├── profile/
└── notifications/

tests/
├── Feature/
│   ├── Auth/
│   ├── BudgetTest.php
│   ├── ExpenseTest.php
│   ├── NotificationTest.php
│   └── ProfileTest.php
└── Unit/
    └── BudgetTest.php
```

---

## 🔌 API Endpoints

| Method   | Endpoint             | Description       |
| -------- | -------------------- | ----------------- |
| `POST`   | `/api/login`         | Get auth token    |
| `GET`    | `/api/expenses`      | List expenses     |
| `POST`   | `/api/expenses`      | Create expense    |
| `PUT`    | `/api/expenses/{id}` | Update expense    |
| `DELETE` | `/api/expenses/{id}` | Delete expense    |
| `GET`    | `/api/budgets`       | List budgets      |
| `GET`    | `/api/dashboard`     | Dashboard summary |

Full API docs: [api-docs link]

---

## 📸 Screenshots

| Dashboard                        | Expenses                       | Budgets                      |
| -------------------------------- | ------------------------------ | ---------------------------- |
| ![Dashboard](docs/dashboard.png) | ![Expenses](docs/expenses.png) | ![Budgets](docs/budgets.png) |

---

## 🔑 Key Implementation Highlights

**Service Layer Pattern**

```php
// ExpenseService handles all business logic
// Controllers stay thin and focused
$this->service->create($userId, $data, $receipt);
```

**Policy-based Authorization**

```php
// Every resource is protected
$this->authorize('update', $expense);
$this->authorize('delete', $budget);
```

**Smart Budget Notifications**

```php
// Fires only once per budget breach
// Duplicate guard prevents notification spam
if (!$alreadyNotified) {
    Auth::user()->notify(new BudgetExceeded($budget, $spent));
}
```

**Comprehensive Test Coverage**

```php
// 57 tests covering features, auth, policies & units
test('user cannot edit another users expense', function () {
    // ...
    ->assertForbidden();  // 403 enforced
});
```

---

## 👨‍💻 Author

**Mohammed Maheen Afzal**

- GitHub: [@yourusername](https://github.com/yourusername)
- LinkedIn: [linkedin.com/in/yourprofile](https://linkedin.com/in/yourprofile)
- Email: your@email.com

---

## 📄 License

MIT License — free to use for learning and portfolio purposes.
