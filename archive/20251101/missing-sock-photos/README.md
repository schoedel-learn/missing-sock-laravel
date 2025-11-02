# The Missing Sock Photography - Laravel Application

Professional school photography pre-order system built with Laravel 10+ and Filament 3.

![Brand Colors](https://via.placeholder.com/800x100/4A90E2/FFFFFF?text=The+Missing+Sock+Photography)

## 🎨 Brand Colors

- **Primary Blue:** `#4A90E2`
- **Accent Warm:** `#FF9F43`
- **Accent Pink:** `#FFC0CB`
- **Success:** `#27AE60`

---

## 📋 Project Overview

This application manages pre-orders for school photography sessions across 149+ schools in Miami and South Florida. It features:

- ✅ Beautiful, responsive homepage with brand-consistent design
- ✅ Multi-step pre-order wizard (10 pages)
- ✅ Complex conditional logic (11 rules)
- ✅ Stripe payment integration
- ✅ Order management admin panel
- ✅ Email notifications
- ✅ Time slot booking system

---

## 🚀 Quick Start

### Prerequisites

- PHP 8.2+
- Composer
- Node.js 20+ & NPM
- MySQL 8.0+ or PostgreSQL 15+
- Redis (optional, for caching & queues)

### Installation Steps

```bash
# 1. Clone or navigate to project directory
cd missing-sock-photos

# 2. Install PHP dependencies
composer install

# 3. Install NPM dependencies
npm install

# 4. Copy environment file
cp .env.example .env

# 5. Generate application key
php artisan key:generate

# 6. Configure your database in .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=missing_sock_photos
DB_USERNAME=root
DB_PASSWORD=your_password

# 7. Run migrations
php artisan migrate

# 8. Seed the database (optional)
php artisan db:seed

# 9. Install Filament
php artisan filament:install --panels

# 10. Create admin user
php artisan make:filament-user

# 11. Compile assets
npm run dev

# 12. Start development server
php artisan serve
```

Your application will be available at:
- **Homepage:** http://localhost:8000
- **Admin Panel:** http://localhost:8000/admin

---

## 📁 Project Structure

```
missing-sock-photos/
├── app/
│   ├── Filament/
│   │   ├── Pages/
│   │   │   └── PreOrderWizard.php        # Main pre-order form
│   │   └── Resources/
│   │       ├── OrderResource.php
│   │       ├── SchoolResource.php
│   │       └── ProjectResource.php
│   ├── Http/
│   │   └── Controllers/
│   │       ├── HomeController.php
│   │       └── PreOrderController.php
│   ├── Models/
│   │   ├── School.php
│   │   ├── Project.php
│   │   ├── Registration.php
│   │   ├── Child.php
│   │   ├── Order.php
│   │   ├── Package.php
│   │   ├── AddOn.php
│   │   ├── Payment.php
│   │   ├── TimeSlot.php
│   │   └── TimeSlotBooking.php
│   └── Services/
│       ├── PricingCalculator.php
│       └── PaymentService.php
├── resources/
│   ├── views/
│   │   ├── welcome.blade.php             # Homepage
│   │   ├── layouts/
│   │   │   └── app.blade.php
│   │   └── components/
│   │       ├── navigation.blade.php
│   │       └── footer.blade.php
│   └── css/
│       └── app.css                       # Tailwind + custom styles
├── routes/
│   └── web.php
└── database/
    ├── migrations/
    └── seeders/
```

---

## 🎨 Brand Guidelines

All UI components follow **The Missing Sock Photography** brand guidelines:

- **Typography:**
  - Primary: Nunito (body text)
  - Secondary: Playfair Display (headings)
  - Monospace: Inter (numbers, pricing)

- **Color Palette:**
  - Primary Blue: #4A90E2
  - Warm Accent: #FF9F43
  - Soft Pink: #FFC0CB
  - Gray Scale: 900-100

- **Design Principles:**
  - Rounded corners (8px default)
  - Generous spacing (8px grid system)
  - Subtle shadows for depth
  - Mobile-first responsive design

See `JOTFORM_08_BRANDING_UI.md` for complete guidelines.

---

## 🛠 Development Workflow

### Running in Development

```bash
# Terminal 1: Laravel server
php artisan serve

# Terminal 2: Vite dev server (hot reload)
npm run dev

# Terminal 3: Queue worker (for emails)
php artisan queue:work
```

### Building for Production

```bash
# Compile assets
npm run build

# Optimize Laravel
php artisan optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## 📊 Database Schema

### Core Tables

1. **schools** - 149+ schools in South Florida
2. **projects** - Photography sessions per school
3. **registrations** - Parent submissions
4. **children** - 1-3 children per registration
5. **orders** - Package selections & pricing
6. **packages** - 6 package options
7. **add_ons** - Additional products & services
8. **payments** - Stripe transactions
9. **time_slots** - Photo session scheduling
10. **time_slot_bookings** - Appointment confirmations

See `JOTFORM_09_DATABASE_SCHEMA.md` for complete ERD.

---

## 🎯 Key Features

### 1. Homepage (`/`)
- Hero section with CTA
- Statistics (149+ schools, 10,000+ families)
- Package showcase
- How it works (4 steps)
- FAQ section
- Contact info

### 2. Pre-Order Form (`/pre-order/start`)
- 10-page multi-step wizard
- School selection (149 schools)
- Parent & children information
- Package selection
- Add-ons & upgrades
- Shipping options
- Time slot booking
- Order summary
- Payment processing

### 3. Admin Panel (`/admin`)
- Order management
- School management
- Project management
- Customer database
- Reporting dashboard

---

## 💳 Payment Integration

### Stripe Setup

```env
# Add to .env
STRIPE_KEY=pk_test_...
STRIPE_SECRET=sk_test_...
STRIPE_WEBHOOK_SECRET=whsec_...
```

### Test Cards
- **Success:** 4242 4242 4242 4242
- **Decline:** 4000 0000 0000 0002

See `JOTFORM_07_INTEGRATIONS.md` for complete setup.

---

## 📧 Email Notifications

Configured emails:
- Order confirmation
- Gallery ready notification
- Image selection reminder
- Shipping confirmation

Configure mail settings in `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
```

---

## 🧪 Testing

```bash
# Run tests
php artisan test

# Run with coverage
php artisan test --coverage

# Test specific feature
php artisan test --filter=PreOrderTest
```

---

## 📚 Documentation

Complete documentation is available in the project root:

- **[JOTFORM_MIGRATION_INDEX.md](../JOTFORM_MIGRATION_INDEX.md)** - Master index
- **[JOTFORM_01_OVERVIEW.md](../JOTFORM_01_OVERVIEW.md)** - Executive summary
- **[JOTFORM_04_CONDITIONAL_LOGIC.md](../JOTFORM_04_CONDITIONAL_LOGIC.md)** - All conditional rules
- **[JOTFORM_08_BRANDING_UI.md](../JOTFORM_08_BRANDING_UI.md)** - Brand guidelines
- **[JOTFORM_10_LARAVEL_IMPLEMENTATION.md](../JOTFORM_10_LARAVEL_IMPLEMENTATION.md)** - Technical guide

---

## 🔒 Security

- CSRF protection enabled
- XSS protection
- SQL injection prevention (Eloquent)
- Secure password hashing
- HTTPS enforced in production
- PCI DSS compliant (Stripe handles cards)

---

## 🚢 Deployment

### Recommended Hosting
- **Laravel Forge** (easiest)
- **Laravel Vapor** (serverless)
- **DigitalOcean App Platform**
- **AWS EC2** (manual)

### Deployment Checklist
- [ ] Set `APP_ENV=production`
- [ ] Set `APP_DEBUG=false`
- [ ] Configure production database
- [ ] Set up SSL certificate
- [ ] Configure Stripe production keys
- [ ] Set up email service (Mailgun/SendGrid)
- [ ] Configure queue worker
- [ ] Set up automated backups
- [ ] Configure logging

---

## 🐛 Troubleshooting

### Common Issues

**Issue:** Assets not loading
```bash
# Solution
npm run build
php artisan optimize:clear
```

**Issue:** Database connection failed
```bash
# Solution: Check .env database credentials
php artisan config:clear
```

**Issue:** Filament not accessible
```bash
# Solution: Clear cache and reinstall
php artisan optimize:clear
php artisan filament:install --panels
```

---

## 📞 Support

For questions or issues:
- **Email:** info@themissingsock.photo
- **Phone:** (123) 456-7890
- **Documentation:** See markdown files in project root

---

## 📄 License

Proprietary - The Missing Sock Photography © 2025

---

## 🎉 Next Steps

1. ✅ Review homepage at http://localhost:8000
2. ✅ Access admin panel at http://localhost:8000/admin
3. ✅ Test pre-order form at http://localhost:8000/pre-order/start
4. ⏳ Customize brand colors and content
5. ⏳ Add school data (149 schools)
6. ⏳ Configure Stripe payment
7. ⏳ Set up email notifications
8. ⏳ Deploy to production

**You're ready to build! 🚀**

