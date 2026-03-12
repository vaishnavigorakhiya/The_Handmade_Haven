# 🧵 The Handmade Haven — Stitch & Bloom

> A full-stack handmade embroidery e-commerce shop built with Laravel 12

![Laravel](https://img.shields.io/badge/Laravel-12-FF6B6B?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.4-4ECDC4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-Database-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![Twilio](https://img.shields.io/badge/Twilio-OTP%20SMS-F22F46?style=for-the-badge&logo=twilio&logoColor=white)

---

## 📖 About

**Stitch & Bloom** is a handmade embroidery shop where customers can browse and buy hoops, pillowcases, sofa covers, and custom embroidery. Built as a beginner Laravel project — every feature was learned and built from scratch.

---

## ✨ Features

### 🛍️ Shop
- Product listings with category filters
- Product detail page with images, tags, stock status
- Shopping cart with add/remove and quantity controls
- Checkout with stock auto-decrement

### 🔐 Authentication
- **Phone OTP login** — customers get a real SMS via Twilio
- **Email + Password login** — for admin accounts
- Auto-register new customers on first OTP login
- Single login modal accessible from navbar AND footer

### 👤 User Dashboard
- Order history and total spending
- Welcome coupon (STITCH10 — 10% off first order)
- Edit profile name

### ⚙️ Admin Dashboard
- Add products with image upload, emoji, color themes
- One-click restock (+5 units)
- Delete products
- Live stats — total products, orders, revenue

---

## 🛠️ Tech Stack

| Layer | Technology |
|---|---|
| Backend | Laravel 12, PHP 8.4 |
| Frontend | Blade Templates, Custom CSS |
| Database | MySQL |
| Auth | Laravel Auth + Twilio SMS OTP |
| Storage | Laravel Storage (product images) |
| Fonts | Playfair Display + Nunito |

---

## 🚀 Getting Started

### Prerequisites
- PHP 8.4+
- Composer
- MySQL
- Twilio account (free trial works)

### Installation

```bash
# 1. Clone the repo
git clone https://github.com/YOUR_USERNAME/the-handmade-haven.git
cd the-handmade-haven

# 2. Install dependencies
composer install

# 3. Setup environment
cp .env.example .env
php artisan key:generate

# 4. Configure .env (database + Twilio credentials)

# 5. Run migrations and seed
php artisan migrate:fresh
php artisan db:seed --class=AdminSeeder
php artisan db:seed --class=ProductSeeder

# 6. Link storage for images
php artisan storage:link

# 7. Start server
php artisan serve
```

Visit: `http://127.0.0.1:8000`

---

## ⚙️ Environment Variables

```env
DB_DATABASE=stitch_bloom
DB_USERNAME=root
DB_PASSWORD=

SESSION_DRIVER=file

TWILIO_SID=ACxxxxxxxxxxxxxxxxx
TWILIO_TOKEN=your_auth_token
TWILIO_FROM=+1234567890

APP_ENV=local   # Shows OTP on screen for local testing
```

> 💡 When `APP_ENV=local`, the OTP is shown on screen — no Twilio needed for testing!

---

## 🔑 Default Admin Login

| Field | Value |
|---|---|
| Email | `admin@stitchandbloom.com` |
| Password | `Admin@1234` |

> ⚠️ Change the password after first login!

---

## 📁 Project Structure

```
app/
  Http/Controllers/   → Auth, Product, Order, UserDashboard
  Http/Middleware/    → AdminMiddleware
  Models/             → User, Product, Order, OrderItem
  Services/           → TwilioService
database/
  migrations/         → All table schemas
  seeders/            → AdminSeeder, ProductSeeder
resources/views/
  layouts/            → app.blade.php (main layout)
  components/         → login-modal, product-card
  user/               → dashboard
  admin.blade.php
routes/
  web.php             → All routes
```

---

## 📚 What I Learned

- Laravel MVC architecture
- Database design and Eloquent ORM
- Role-based authentication with middleware
- Real SMS OTP with Twilio API
- File uploads and Laravel storage
- Blade templating — layouts, components, slots
- AJAX calls from Blade to Laravel backend
- Session management and CSRF protection

---

## 🌸 Made with love

> Handmade embroidery deserves a handmade website. Built stitch by stitch. 🧵
