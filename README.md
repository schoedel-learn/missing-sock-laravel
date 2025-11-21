# The Missing Sock Photography – Application Overview

This repository contains the custom school-photography platform for The Missing Sock.  
It is a full Laravel 12 application with Filament 4 admin panels, a multi-step Livewire preorder wizard, and Stripe-powered payments.

The goal is to make a better program than than GotPhoto in terms of the genus of this type of application, but also to customize it, making it specific, i.e. a species of the genus that is embedded, as it were, in a way that it acts to unifiy and simplify the experience of all the users: customers, site coordinators, photo managers, and administrators.

This is system that The Missing Sock could use in a number of ways that ensured the possession of their branch of the OpsHub.Photos, that matches your studio’s workflow today, but is flexible and “stack-agnostic” enough to grow into a white‑label or SaaS offering later.

---

## What this application does

At a high level, the app is a modern, end‑to‑end pre-order and operations hub for school photography:

- Pre-order wizard for parents
  - 12-step, guided Livewire form for picture day registration and prepay orders.
  - School/project selection, packages, add‑ons, shipping choices, ordering preferences, digital signature, and Stripe checkout.
  - “Register only” path for parents who are not ready to prepay.

- Role-based portals (Filament panels)
  - Admin panel: global configuration, products, pricing, projects, schools, reporting.
  - Parent panel (“My Account”): orders, registrations, and (future) galleries.
  - Organization Coordinator panel: tools for school contacts to see rosters, dates, and communication status.
  - Photo Manager panel: production, lab, and gallery workflows.

- Stripe-powered e‑commerce
  - Uses Laravel Cashier and Stripe to handle secure payments.
  - Designed so pricing, add‑ons, and packages can evolve without rewriting core payment logic.

---

## Why this will be superior to GotPhoto (for you)

GotPhoto is a strong general-purpose system, but it is opinionated and closed.  
This application is designed to be:

- Owned, not rented
  - All business logic, branding, and data live in your code and database.
  - No dependency on a third‑party SaaS roadmap.

- Tailored to school volume and your studio’s theology of service
  - Flows match how you communicate with parents, coordinators, and production, not the other way around.
  - The pre-order experience is built around clarity, simplicity, and trust – especially important for parents who are not tech‑savvy.

- Extensible where GotPhoto is rigid
  - New products, pricing models, upsells, coupons, and campaigns can be added in Laravel and Filament.
  - You can integrate additional systems (labs, CRM, email marketing, AI tools) directly in code.

- Transparent and debuggable
  - When something goes wrong, you can see the log, the code, and the data – and fix it.

Over time, this can become not just “your GotPhoto replacement”, but the backbone for a white‑label or SaaS product serving other studios with similar needs.

---

## Flexibility and extensibility

Architecturally, the app is structured to let you change and grow without rewriting from scratch:

- Clean Laravel domain structure
  - `app/Http`, `app/Models`, `app/Services`, and `app/Livewire` keep concerns separated.
  - Eloquent models and service classes encapsulate business rules, keeping controllers/lightweight entry points.

- Filament 4 panels
  - Each “portal” (Admin, User, Coordinator, Photo Manager) is its own panel provider.
  - You can add resources (e.g., Orders, Schools, Projects), widgets (dashboards), and custom pages per role.
  - Role-based access is handled via `UserRole` and Filament’s `FilamentUser` contract.

### Local Development

See `docs/setup/SETUP_GUIDE.md` for detailed installation instructions.
- Livewire preorder wizard
  - The multi-step form is a Livewire component (`PreOrderWizard`) with a Blade view.
  - Steps, validation rules, and transitions are explicit and testable.
  - Adding or reordering steps is a matter of updating the component and view, not re-engineering the whole flow.

- Tailwind-first frontend
  - Navigation, login, and the wizard UI use Tailwind and semantic HTML, so it is straightforward to restyle or create new layouts.

---

## Designed for customization and SaaS

The current implementation is branded and configured for The Missing Sock, but the underlying design is deliberately agnostic:

- Branding and content are layered on top of reusable components.
- Panels and roles are defined in enums and providers, not hard-coded only for one studio.
- Package/add‑on/price data is stored in the database and seeded, not baked into source code.

This means:

- For a new studio, you would primarily:
  - Adjust branding assets, copy, and email templates.
  - Seed new packages, schools, and default settings.
  - Configure domain and environment variables.

- For a SaaS version, you could:
  - Introduce a “tenant” model (per studio or per brand).
  - Scope users, projects, and billing by tenant.
  - Offer a set of configuration defaults while keeping the core codebase shared.

The stack (Laravel + Filament + Livewire + Tailwind + Stripe) is widely adopted, well-documented, and cloud‑friendly, which is exactly what you want for a future SaaS.

---

## Technology stack

- Backend:
  - PHP 8.2+
  - Laravel 12
  - Eloquent ORM
  - Spatie Permission (roles/permissions)
  - Spatie Medialibrary (assets)
  - Laravel Cashier (Stripe)
  - Guzzle, DOMPDF, Laravel Excel as needed for integrations and exports

- Admin and portals:
  - Filament 4 (multi-panel setup)

- Frontend:
  - Blade + Livewire components
  - Tailwind CSS 3
  - Alpine.js
  - Vite build tooling

- Database:
  - MySQL or compatible (configured via `.env`)

This is a modern, mainstream Laravel stack: easy to hire for, easy to host on Forge, Vapor, Ploi, or any standard PHP host.

---

## Local development quick start

For a developer setting this up locally:

```bash
# 1. Install PHP and Node dependencies
composer install
npm install

# 2. Configure environment
cp .env.example .env
php artisan key:generate

# 3. Configure database in .env, then run migrations and seeders
php artisan migrate --seed

# 4. Start the dev services
php artisan serve    # or use Sail / Valet / Forge-style setup
npm run dev          # Tailwind + Vite
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
---

## Deployment notes (high-level)

This project is no longer tied to a single deployment platform such as Coolify.  
It can be deployed to any modern PHP host that supports:

- PHP 8.2+
- A supported database (e.g., MySQL)
- Running `composer install`, `npm run build`, and `php artisan migrate --force`

Typical production deployment steps:

1. Build and upload code (or deploy from Git).
2. Configure environment variables (`.env`) for:
   - `APP_ENV`, `APP_URL`, `APP_KEY`
   - `DB_*` settings
   - `STRIPE_*` keys
   - Mail and queue drivers
3. Run:
   - `php artisan migrate --force`
   - `php artisan config:cache`
   - `php artisan route:cache`
   - `php artisan view:cache`
4. Ensure a queue worker is running for background jobs.

If you would like, we can create a separate, host-specific deployment guide (for example, “Deploying to Laravel Forge” or “Deploying to Vapor”) that lives alongside this README.

---

## License

Proprietary – The Missing Sock Photography

