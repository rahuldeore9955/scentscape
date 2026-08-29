# ScentScape — Premium Fragrance E-Commerce

Laravel 11 e-commerce platform for luxury fragrances.

## Project Structure

```
scentscape/
├── ref/                        ← Original static HTML reference (do not edit)
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/           ← Login, Register, Logout
│   │   │   ├── Admin/          ← Admin panel (upcoming)
│   │   │   ├── HomeController
│   │   │   ├── ProductController
│   │   │   ├── ContactController
│   │   │   └── DashboardController
│   │   ├── Middleware/
│   │   └── Requests/           ← Form validation
│   ├── Models/                 ← User, Product, Order, OrderItem, Review, Address
│   ├── Services/               ← Business logic layer
│   └── Repositories/           ← Data access layer
├── database/
│   ├── migrations/             ← All table definitions
│   ├── seeders/                ← Sample data (users, products)
│   └── factories/              ← Faker factories (upcoming)
├── public/
│   ├── assets/css|js|images    ← Compiled front-end assets
│   └── index.php               ← Laravel entry point
├── resources/
│   ├── views/
│   │   ├── layouts/            ← app.blade.php + partials (navbar, footer)
│   │   ├── auth/               ← login.blade.php, register.blade.php
│   │   ├── products/           ← index.blade.php, show.blade.php
│   │   ├── dashboard/          ← index, orders, wishlist, profile
│   │   └── contact/
│   ├── css/                    ← Source CSS (if using Vite)
│   └── js/                     ← Source JS (if using Vite)
├── routes/
│   ├── web.php                 ← All web routes
│   ├── api.php                 ← API routes (Sanctum)
│   └── console.php
├── storage/
├── tests/
├── .env.example
├── artisan
└── composer.json
```

## Setup

```bash
# 1. Install dependencies
composer install

# 2. Copy environment file
cp .env.example .env

# 3. Generate app key
php artisan key:generate

# 4. Create the database in phpMyAdmin: scentscape

# 5. Run migrations
php artisan migrate

# 6. Seed sample data
php artisan db:seed

# 7. Copy assets to public
# (Copy ref/assets → public/assets)

# Access at: http://localhost/scentscape/public
```

## Database

| Table        | Description                  |
|--------------|------------------------------|
| users        | Customers & admins           |
| products     | Perfume catalogue            |
| orders       | Customer orders              |
| order_items  | Line items per order         |
| reviews      | Product ratings & comments   |
| wishlists    | User saved products          |
| addresses    | Delivery addresses           |
