# The Missing Sock Photography - Laravel Application

Professional school photography pre-order system built with Laravel 12+ and Filament 3.

## 📁 Project Structure

```
missing-sock-laravel/
├── app/                    # Application code
│   ├── Contracts/          # Interfaces
│   ├── Http/               # Controllers, middleware
│   ├── Models/             # Eloquent models
│   ├── Providers/          # Service providers
│   └── Services/           # Business logic services
├── assets/                 # Brand assets (logos, images, graphics)
├── config/                 # Configuration files
├── database/               # Migrations, seeders, factories
├── docs/                   # Documentation
│   ├── migration/          # JotForm migration docs
│   ├── analysis/           # Analysis and comparisons
│   └── setup/              # Setup and troubleshooting
├── public/                 # Public web root
├── resources/              # Views, CSS, JS
├── routes/                 # Route definitions
└── storage/                # File storage
```

## 🚀 Quick Start

See `docs/setup/SETUP_GUIDE.md` for detailed installation instructions.

```bash
# Install dependencies
composer install
npm install

# Configure environment
cp .env.example .env
php artisan key:generate

# Run migrations
php artisan migrate

# Start development
php artisan serve
npm run dev
```

## 📚 Documentation

- **Setup Guide:** `docs/setup/SETUP_GUIDE.md`
- **Migration Docs:** `docs/migration/` (JotForm migration)
- **Brand Guidelines:** `docs/migration/JOTFORM_08_BRANDING_UI.md`
- **Architecture:** `docs/analysis/ARCHITECTURE_CONSISTENCY.md`

## 🎨 Brand Assets

Brand colors, logos, and assets are configured in `config/brand.php`.

**Note:** Color values and logo paths need to be updated with the correct hex values and asset locations.

## 🛠️ Development

- **Framework:** Laravel 12
- **Admin Panel:** Filament 3
- **Frontend:** Tailwind CSS, Alpine.js
- **Payment:** Laravel Cashier (Stripe)

## 📝 License

Proprietary - The Missing Sock Photography

