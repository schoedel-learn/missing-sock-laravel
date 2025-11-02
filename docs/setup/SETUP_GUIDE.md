# The Missing Sock Photography - Laravel Application Setup Guide

## 🚀 Quick Start Installation

Follow these steps to get your application running:

### Step 1: Create Laravel Project

```bash
# Create new Laravel project
composer create-project laravel/laravel missing-sock-photos
cd missing-sock-photos

# Install required packages
composer require filament/filament:"^3.2"
composer require laravel/cashier:"^15.0"
composer require spatie/laravel-permission
composer require google/recaptcha

# Install frontend dependencies
npm install
npm install -D tailwindcss@latest postcss@latest autoprefixer@latest
```

### Step 2: Configure Environment

```bash
# Copy .env.example to .env
cp .env.example .env

# Generate application key
php artisan key:generate

# Configure database in .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=missing_sock_photos
DB_USERNAME=root
DB_PASSWORD=your_password

# Configure Stripe
STRIPE_KEY=your_stripe_publishable_key
STRIPE_SECRET=your_stripe_secret_key

# Configure mail (for notifications)
MAIL_MAILER=smtp
MAIL_HOST=mailhog
MAIL_PORT=1025
```

### Step 3: Install Filament

```bash
# Install Filament admin panel
php artisan filament:install --panels

# Create admin user
php artisan make:filament-user
```

### Step 4: Set Up Database

```bash
# Run migrations (after creating migration files)
php artisan migrate

# Seed database (after creating seeders)
php artisan db:seed
```

### Step 5: Compile Assets

```bash
# Install and compile
npm install
npm run dev

# For production
npm run build
```

### Step 6: Start Development Server

```bash
# Terminal 1: Laravel server
php artisan serve

# Terminal 2: Vite dev server (for hot reload)
npm run dev
```

Your application will be available at: `http://localhost:8000`

---

## 📁 File Structure Created

```
missing-sock-photos/
├── app/
│   ├── Filament/
│   │   ├── Pages/
│   │   │   └── PreOrderWizard.php
│   │   └── Resources/
│   ├── Http/
│   │   └── Controllers/
│   │       └── HomeController.php
│   ├── Models/
│   │   ├── School.php
│   │   ├── Project.php
│   │   ├── Registration.php
│   │   └── ... (other models)
│   └── Services/
│       └── PricingCalculator.php
├── resources/
│   ├── views/
│   │   ├── welcome.blade.php (homepage)
│   │   ├── layouts/
│   │   │   └── app.blade.php
│   │   └── components/
│   │       ├── navigation.blade.php
│   │       └── footer.blade.php
│   └── css/
│       └── app.css
├── routes/
│   └── web.php
└── database/
    ├── migrations/
    └── seeders/
```

---

## ✅ Next Steps

After running the installation:
1. Access homepage: `http://localhost:8000`
2. Access admin panel: `http://localhost:8000/admin`
3. Start pre-order form: `http://localhost:8000/pre-order`

---

**Ready to start building!** 🎉

