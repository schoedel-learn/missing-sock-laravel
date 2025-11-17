# Coolify Quick Start Guide

Quick reference for deploying to Coolify at `http://31.97.65.164:8000`

## 🚀 Quick Deployment Steps

### 1. In Coolify Dashboard

Navigate to: `http://31.97.65.164:8000/project/agk4cs8ccgsk80cccgw0w0sg/environment/ukws40c8kcs88k0kk4cggok8/new?server=0`

### 2. Application Configuration

**Basic Settings:**
- **Name:** `missing-sock-laravel` or `tms-opshub-photos`
- **Source:** Git Repository
- **Repository URL:** Your Git repository URL
- **Branch:** `main`
- **Build Pack:** Dockerfile (or Laravel)

**Build Settings:**
- **Build Command:** `composer install --optimize-autoloader --no-dev --no-interaction && npm install && npm run build`
- **Start Command:** `php-fpm` (or `php artisan serve --host=0.0.0.0 --port=8000` for testing)
- **Port:** `8000` (or `9000` for PHP-FPM)

### 3. Required Environment Variables

Copy these into Coolify's environment variables section:

```env
APP_NAME=The Missing Sock Photography
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=https://tms.opshub.photos

DB_CONNECTION=mysql
DB_HOST=
DB_PORT=3306
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=

STRIPE_KEY=
STRIPE_SECRET=
STRIPE_WEBHOOK_SECRET=

MAIL_MAILER=smtp
MAIL_HOST=
MAIL_PORT=587
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@opshub.photos
MAIL_FROM_NAME=The Missing Sock Photography

QUEUE_CONNECTION=database
SESSION_DRIVER=database
CACHE_DRIVER=file
```

**Important:** 
- Generate `APP_KEY` after first deployment: `php artisan key:generate`
- Fill in database credentials
- Add Stripe keys
- Configure mail settings

### 4. Domain Configuration

- **Domain:** `tms.opshub.photos`
- **Enable SSL:** Yes (Let's Encrypt)
- **Force HTTPS:** Yes

### 5. Post-Deployment Commands

Add these in Coolify's "Post Deploy" section:

```bash
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan storage:link
chmod -R 775 storage bootstrap/cache
```

### 6. Queue Worker (Optional)

If Coolify supports separate services, create a queue worker:

- **Service Type:** Background Worker
- **Command:** `php artisan queue:work database --sleep=3 --tries=3 --max-time=3600`
- **Restart Policy:** Always

### 7. Health Check

- **Health Check Path:** `/up`
- **Expected Response:** `{"status":"ok"}`

## 📝 Checklist

- [ ] Repository connected in Coolify
- [ ] Environment variables configured
- [ ] Domain `tms.opshub.photos` added
- [ ] SSL certificate configured
- [ ] Database created and connected
- [ ] Post-deployment commands configured
- [ ] Application deployed successfully
- [ ] Health check passing
- [ ] Test all routes:
  - [ ] Homepage: `https://tms.opshub.photos`
  - [ ] Pre-order: `https://tms.opshub.photos/pre-order/start`
  - [ ] Admin: `https://tms.opshub.photos/admin`
  - [ ] User panel: `https://tms.opshub.photos/my-account`

## 🔧 Troubleshooting

**Build Fails:**
- Check build logs in Coolify
- Verify Dockerfile syntax
- Ensure all dependencies are in composer.json/package.json

**Application Not Loading:**
- Check application logs
- Verify APP_URL matches domain
- Check database connection
- Verify file permissions

**500 Errors:**
- Check Laravel logs: `storage/logs/laravel.log`
- Verify APP_DEBUG=false
- Check environment variables
- Verify database migrations ran

## 🔄 Updates

To update the application:
1. Push changes to Git repository
2. In Coolify, click "Redeploy"
3. Monitor build logs
4. Verify deployment success

---

**Coolify Dashboard:** http://31.97.65.164:8000  
**Full Guide:** See `docs/setup/COOLIFY_DEPLOYMENT.md`

