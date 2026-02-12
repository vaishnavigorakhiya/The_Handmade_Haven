<<<<<<< HEAD
<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

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
=======
# The_Handmade_Haven
The_Handmade_Haven is a Laravel-powered web application designed to sell handmade products online. It focuses on showcasing artisanal creations with a clean UI, secure checkout, and easy product management.

Full-stack handcrafted products marketplace built with **Laravel (API)** and **React (Vite)**.

My Contribution:
- Continuous daily improvements (features, bug fixes, UI refinement, and code cleanup)

## Features

- Product listing and product detail page
- Product customization options (color, size, custom text)
- Add to cart (localStorage-based cart)
- Customer auth (Register / Login) with Laravel Sanctum
- Header profile section for logged-in user
- Admin product management (create, edit, delete products)
- Image upload for products
- Responsive boutique-style UI

## Tech Stack

- Backend: Laravel, Sanctum, SQLite
- Frontend: React, React Router, Vite
- Styling: CSS (modularized into `styles/` files)

## Project Structure

```bash
react-laravel-app/
├─ app/                         # Laravel backend logic
├─ routes/                      # API routes
├─ database/                    # SQLite + migrations + seeders
├─ frontend/
│  ├─ src/
│  │  ├─ components/            # shared components (Header, etc.)
│  │  ├─ pages/                 # page-level components
│  │  ├─ styles/                # App.css, Header.css, Home.css, Shop.css...
│  │  ├─ App.jsx
│  │  └─ main.jsx
│  └─ package.json
└─ .env

Prerequisites

PHP 8.2+
Composer
Node.js 18+
npm

Installation

1. Backend setup (Laravel)
composer install
cp .env.example .env
php artisan key:generate
Set SQLite in .env:

DB_CONNECTION=sqlite
DB_DATABASE=database/databa

Create database file (if missing):
# Windows PowerShell
New-Item -ItemType File -Path

Run migrations + seed:
php artisan migrate --seed

Create storage symlink (for uploaded product images):
php artisan storage:link

2. Frontend setup (React)
cd frontend
npm install

Run the project
Terminal 1 (Laravel API)
php artisan serve 

Terminal 2 (React app)
cd frontend
npm run dev

Authentication Notes
Register/Login uses Sanctum cookie auth.
CORS and Sanctum must allow frontend domain (localhost (line 5173)).
Email uniqueness is enforced in backend validation (users.email).

Main Routes (Frontend)
/ Home
/shop Shop
/product/:slug Product Detail
/cart Cart
/login Login
/register Register
/admin Admin

Main API Endpoints (Backend)
GET /api/products
GET /api/products/{slug}
POST /api/products (auth)
PUT /api/products/{product} (auth)
DELETE /api/products/{product} (auth)
POST /api/register
POST /api/login
POST /api/logout
GET /api/me
PUT /api/profile (auth)

Common Commands
# backend
php artisan migrate
php artisan migrate:fresh --seed
php artisan serve

# frontend
cd frontend
npm run dev
npm run build

Troubleshooting

If frontend can’t call API, check CORS + Sanctum settings.
If images don’t load, run php artisan storage:link.
If push fails (non-fast-forward), run:
git pull --rebase origin main
git push -u origin main

Author
Vaishnavi Gorakhiya
If you want, I can also gen

>>>>>>> be2177284c6ad73992492e368f15c4ee23951821# The Handmade Haven


