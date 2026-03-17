# 🧵 The Handmade Haven — Stitch & Bloom

> A full-stack handmade embroidery e-commerce shop built with Laravel 12

---

## 🔧 Bugs Fixed in This Version

| # | Bug | Fix |
|---|-----|-----|
| 1 | `/login` redirect loop — modal never opened | `showLogin()` redirects to `/home` with `open_login_modal` flash; layout reads flash and calls `openLoginModal()` with correct timing |
| 2 | Registered email showed "Create Account" form again | `submitIdentifier()` always returns `step: password` for existing emails — register form only for brand-new emails |
| 3 | Checkout worked without login | `checkoutPage()` checks `Auth::check()`; saves `url.intended`; opens login modal |
| 4 | No delivery address on checkout | New `checkout.blade.php` with full address form; address columns added to `orders` table |
| 5 | Navbar broken/missing on About page for admin | `app.blade.php` navbar always renders for all authenticated roles |
| 6 | `MassAssignmentException` on Order/OrderItem | Added `$fillable` to both models |
| 7 | Sessions table missing (database session driver) | New migration `0001_01_01_000003_create_sessions_table.php` |
| 8 | After login, no redirect to intended page | All auth handlers (`verifyPassword`, `verifyOtp`, `register`) pull `url.intended` from session |

---

## 🚀 Fresh Setup

```bash
# 1. Clone / extract project
cd the-handmade-haven

# 2. Install PHP dependencies
composer install

# 3. Setup environment
cp .env.example .env
php artisan key:generate

# 4. Configure .env — set DB_DATABASE, DB_USERNAME, DB_PASSWORD

# 5. Run all migrations
php artisan migrate:fresh

# 6. Seed admin + products
php artisan db:seed --class=AdminSeeder
php artisan db:seed --class=ProductSeeder

# 7. Link storage
php artisan storage:link

# 8. Install JS deps & build
npm install && npm run build

# 9. Serve
php artisan serve
```

Visit: **http://127.0.0.1:8000**

---

## ⚙️ Important .env Note

For **local development**, use `SESSION_DRIVER=file` to skip needing the sessions table:
```env
SESSION_DRIVER=file
```

For **production**, use `SESSION_DRIVER=database` (sessions table migration is included).

---

## 🔑 Default Admin Login

| Field | Value |
|-------|-------|
| Email | `admin@stitchandbloom.com` |
| Password | `Admin@1234` |

> ⚠️ Change the password after first login!

---

## 🔐 How Login Works

1. Click **Login / Join** → modal opens
2. **Enter email** → if registered → password step | if new → register step
3. **Enter phone** → OTP sent (shows on screen when `APP_ENV=local`)
4. After login → redirects to intended page (e.g. checkout) or dashboard

---

## 📁 Key Changed Files

```
app/Http/Controllers/AuthController.php   ← login flow fixes
app/Http/Controllers/OrderController.php  ← checkout auth + address
app/Http/Middleware/AdminMiddleware.php    ← no redirect loop
app/Models/Order.php                      ← $fillable added
app/Models/OrderItem.php                  ← $fillable added
bootstrap/app.php                         ← redirectGuestsTo registered
database/migrations/*_create_sessions_table.php  ← new
database/migrations/*_create_orders_table.php    ← address fields included
resources/views/layouts/app.blade.php     ← navbar + modal timing fix
resources/views/checkout.blade.php        ← NEW address form
resources/views/cart.blade.php            ← points to checkout page
resources/views/auth/login.blade.php      ← cleaner step flow
```
