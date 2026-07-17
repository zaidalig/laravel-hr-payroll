# laravel-mysql-hr-payroll

Laravel MySQL HR and payroll system with departments, employees, attendance, leave requests, payroll generation, users, roles, dashboard, and activity logs.

## Tech Stack

- PHP 8.2+
- Laravel 11
- MySQL / MariaDB
- Blade + Bootstrap 5 + Font Awesome

## Features

- Dashboard with employee count, present today, pending leaves, and pending payrolls
- Department CRUD with employee counts
- Employee profiles with code, designation, salary, and department
- Daily attendance (present, absent, late, half day, leave) with check-in/out times
- Leave requests with approve/reject workflow and reviewer tracking
- Payroll generation per period (base + allowances − deductions), payslip view, mark-as-paid
- Duplicate protection: one attendance per employee per day, one payroll per employee per period
- Role-based access: owner, hr, accountant, viewer
- Search and filter controls on every list page
- Activity logs

## Roles

| Role | Access |
|------|--------|
| owner | Everything |
| hr | Departments, employees, attendance, leaves |
| accountant | Payroll |
| viewer | Dashboard and activity logs only |

## Setup

```bash
composer install
cp .env.example .env
php artisan key:generate
```

Create database:

```sql
CREATE DATABASE hr_payroll CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Set `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hr_payroll
DB_USERNAME=root
DB_PASSWORD=
```

Run:

```bash
php artisan migrate --seed
php artisan serve
php artisan test
```

## Demo Login

| Email | Role | Password |
|-------|------|----------|
| owner@example.com | Owner | password |
| hr@example.com | HR | password |
| accountant@example.com | Accountant | password |

## Branching & promote

```
feature/*  →  develop (dev)  →  qa  →  main (production)
```

1. Open a PR from `feature/<name>` into `develop`.
2. After QA sign-off on `develop`, run **Actions → Promote** (`develop` → `qa`).
3. After QA environment verification, run **Promote** (`qa` → `main`).
4. CI (PHPUnit) must pass on every PR to `develop`, `qa`, and `main`.
