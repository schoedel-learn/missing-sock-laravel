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

### Local Development

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

### Hostinger VPS Deployment

**Automated Installation (Recommended):**

**Step 1:** SSH into your Hostinger VPS:
```bash
ssh root@your-vps-ip-address
```

**Step 2:** Run the installation script on your VPS:
```bash
# Using wget (Ubuntu/Debian default)
cd /tmp
wget https://raw.githubusercontent.com/schoedel-learn/missing-sock-laravel/main/scripts/hostinger-install.sh
sudo bash hostinger-install.sh

# OR using curl (if wget not available)
cd /tmp
curl -O https://raw.githubusercontent.com/schoedel-learn/missing-sock-laravel/main/scripts/hostinger-install.sh
sudo bash hostinger-install.sh
```

See `docs/setup/HOSTINGER_VPS_DEPLOYMENT.md` for complete step-by-step manual installation guide.

## 📚 Documentation

### Setup & Deployment
- **Local Setup Guide:** `docs/setup/SETUP_GUIDE.md`
- **Hostinger VPS Deployment:** `docs/setup/HOSTINGER_VPS_DEPLOYMENT.md` ⭐ **NEW**
- **Hostinger Quick Reference:** `docs/setup/HOSTINGER_QUICK_REFERENCE.md` ⭐ **NEW**
- **General Deployment Guide:** `docs/setup/DEPLOYMENT.md` (Production deployment to tms.opshub.photos)
- **Deployment Checklist:** `DEPLOYMENT_CHECKLIST.md`

### Other Documentation
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

