# Quick Deployment Checklist - tms.opshub.photos

## Pre-Deployment

- [ ] Server has PHP 8.2+ with required extensions
- [ ] MySQL/MariaDB database server ready
- [ ] Domain DNS configured (A record pointing to server IP)
- [ ] SSH access to server configured
- [ ] Git repository accessible from server

## Server Setup

- [ ] PHP 8.2+ and extensions installed
- [ ] Composer installed globally
- [ ] Node.js and NPM installed
- [ ] Nginx/Apache installed and configured
- [ ] SSL certificate obtained (Let's Encrypt)

## Application Deployment

- [ ] Application files uploaded/cloned to `/var/www/missing-sock-laravel`
- [ ] `.env` file created with production settings
- [ ] `APP_URL=https://tms.opshub.photos` set in .env
- [ ] `APP_DEBUG=false` set in .env
- [ ] Application key generated (`php artisan key:generate`)
- [ ] Dependencies installed (`composer install --no-dev`)
- [ ] Assets compiled (`npm run build`)
- [ ] File permissions set correctly (755/775)
- [ ] Storage and cache directories writable

## Database Setup

- [ ] Database created
- [ ] Database user created with proper permissions
- [ ] Database credentials in .env
- [ ] Migrations run (`php artisan migrate --force`)
- [ ] Seeders run (Packages, AddOns)

## Web Server Configuration

- [ ] Nginx/Apache virtual host configured
- [ ] SSL certificate installed
- [ ] Document root set to `/var/www/missing-sock-laravel/public`
- [ ] PHP-FPM configured
- [ ] Site enabled and tested
- [ ] HTTP to HTTPS redirect working

## Background Services

- [ ] Supervisor installed
- [ ] Queue worker configuration created
- [ ] Queue workers started
- [ ] Cron job for scheduled tasks configured

## Security

- [ ] Firewall configured (UFW recommended)
- [ ] .env file permissions restricted (600)
- [ ] Storage directories secured
- [ ] Admin user created
- [ ] Strong passwords set

## Testing

- [ ] Homepage loads: `https://tms.opshub.photos`
- [ ] Pre-order form loads: `https://tms.opshub.photos/pre-order/start`
- [ ] Admin panel accessible: `https://tms.opshub.photos/admin`
- [ ] User panel accessible: `https://tms.opshub.photos/my-account`
- [ ] Stripe payment flow tested
- [ ] Email sending tested
- [ ] Queue processing verified

## Post-Deployment

- [ ] Application optimized (config:cache, route:cache, view:cache)
- [ ] Logs monitored for errors
- [ ] Backup strategy configured
- [ ] Monitoring set up
- [ ] Documentation updated

---

**Quick Commands:**

```bash
# Deploy updates
cd /var/www/missing-sock-laravel
git pull
composer install --no-dev
npm run build
php artisan migrate --force
php artisan config:cache
php artisan route:cache
sudo supervisorctl restart missing-sock-worker:*

# Check status
sudo supervisorctl status
tail -f storage/logs/laravel.log
```

