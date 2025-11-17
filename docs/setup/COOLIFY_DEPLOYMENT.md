# Coolify Deployment Guide - tms.opshub.photos

Complete guide for deploying The Missing Sock Laravel application using Coolify.

## 🎯 Overview

Coolify is a self-hosted PaaS that simplifies Laravel deployment. This guide will help you deploy to `tms.opshub.photos` using your Coolify instance at `http://31.97.65.164:8000`.

## 📋 Prerequisites

- Coolify instance running and accessible
- Git repository with your code (GitHub, GitLab, etc.)
- Domain `tms.opshub.photos` DNS configured
- Database server (MySQL/PostgreSQL) accessible from Coolify

## 🚀 Deployment Steps

### Step 1: Prepare Your Repository

Ensure your repository includes:
- ✅ `Dockerfile` (included in project)
- ✅ `.dockerignore` (included in project)
- ✅ `composer.json` and `package.json`
- ✅ All application files

### Step 2: Create New Application in Coolify

1. **Login to Coolify**
   - Navigate to: `http://31.97.65.164:8000`
   - Login with your credentials

2. **Create New Application**
   - Go to your project: `agk4cs8ccgsk80cccgw0w0sg`
   - Navigate to environment: `ukws40c8kcs88k0kk4cggok8`
   - Click "New Application" or use the URL provided

3. **Configure Application Source**
   - **Source Type:** Git Repository
   - **Repository URL:** Your Git repository URL (GitHub/GitLab)
   - **Branch:** `main` (or your production branch)
   - **Build Pack:** Dockerfile (or Laravel if available)

### Step 3: Configure Build Settings

**Build Command:**
```bash
composer install --optimize-autoloader --no-dev --no-interaction && npm install && npm run build
```

**Start Command:**
```bash
php-fpm
```

**Or if using PHP built-in server (for testing):**
```bash
php artisan serve --host=0.0.0.0 --port=8000
```

**Port:** `8000` (or configure based on your setup)

### Step 4: Configure Environment Variables

Add these environment variables in Coolify:

#### Application Settings
```env
APP_NAME="The Missing Sock Photography"
APP_ENV=production
APP_KEY=base64:YOUR_GENERATED_KEY_HERE
APP_DEBUG=false
APP_URL=https://tms.opshub.photos
```

#### Database Configuration
```env
DB_CONNECTION=mysql
DB_HOST=your_database_host
DB_PORT=3306
DB_DATABASE=missing_sock_production
DB_USERNAME=your_db_user
DB_PASSWORD=your_secure_password
```

#### Stripe Configuration
```env
STRIPE_KEY=pk_live_your_publishable_key
STRIPE_SECRET=sk_live_your_secret_key
STRIPE_WEBHOOK_SECRET=whsec_your_webhook_secret
```

#### Mail Configuration
```env
MAIL_MAILER=smtp
MAIL_HOST=your_smtp_host
MAIL_PORT=587
MAIL_USERNAME=your_smtp_username
MAIL_PASSWORD=your_smtp_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@opshub.photos
MAIL_FROM_NAME="The Missing Sock Photography"
```

#### Queue Configuration
```env
QUEUE_CONNECTION=database
SESSION_DRIVER=database
CACHE_DRIVER=file
```

### Step 5: Configure Domain

1. **Add Domain in Coolify**
   - Domain: `tms.opshub.photos`
   - Enable SSL: Yes (Let's Encrypt)
   - Force HTTPS: Yes

2. **DNS Configuration**
   - Point `tms.opshub.photos` A record to your Coolify server IP
   - Or use CNAME if Coolify provides one

### Step 6: Database Setup

#### Option A: Use Coolify Database Service

1. Create MySQL/PostgreSQL database in Coolify
2. Use the connection details provided by Coolify
3. Update environment variables with database credentials

#### Option B: External Database

1. Use existing database server
2. Ensure it's accessible from Coolify network
3. Configure firewall rules if needed

### Step 7: Post-Deployment Commands

Configure these commands in Coolify's "Post Deployment" section:

```bash
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan storage:link
```

### Step 8: Queue Worker Setup

Coolify can run queue workers as a separate service:

1. **Create New Service** (if supported)
   - Service Type: Queue Worker
   - Command: `php artisan queue:work database --sleep=3 --tries=3 --max-time=3600`
   - Or use the `docker-compose.yml` queue service

2. **Or Use Scheduled Tasks**
   - Configure cron in Coolify: `* * * * * cd /var/www/html && php artisan schedule:run`

### Step 9: Storage Configuration

Ensure storage directories are writable:

```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

Coolify should handle this automatically, but verify in logs.

### Step 10: Deploy

1. Click "Deploy" in Coolify
2. Monitor build logs
3. Check deployment status
4. Verify application is running

## 🔧 Coolify-Specific Configuration

### Dockerfile Optimization

The included `Dockerfile` is optimized for Coolify:
- Uses PHP 8.2 FPM
- Includes required extensions
- Sets proper permissions
- Exposes port 9000 for PHP-FPM

### Nginx Configuration (if needed)

If Coolify doesn't auto-configure Nginx, you may need to add:

```nginx
server {
    listen 80;
    server_name tms.opshub.photos;
    
    root /var/www/html/public;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass app:9000;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

## 📊 Health Checks

Configure health check endpoint in Coolify:

**Health Check URL:** `/up`

**Expected Response:** `200 OK` with JSON `{"status":"ok"}`

## 🔄 Updates & Redeployment

### Automatic Deployments

Coolify can auto-deploy on git push:
1. Enable webhook in Coolify
2. Configure webhook in your Git provider
3. Push to main branch triggers deployment

### Manual Deployment

1. Go to application in Coolify
2. Click "Redeploy"
3. Monitor build logs

## 🐛 Troubleshooting

### Build Fails

1. Check build logs in Coolify
2. Verify Dockerfile syntax
3. Check composer/npm dependencies
4. Ensure `.dockerignore` is correct

### Application Not Loading

1. Check application logs in Coolify
2. Verify environment variables
3. Check database connection
4. Verify file permissions

### Queue Not Processing

1. Check if queue worker service is running
2. View queue worker logs
3. Verify QUEUE_CONNECTION setting
4. Check database jobs table

### SSL Issues

1. Verify domain DNS is correct
2. Check Let's Encrypt certificate status
3. Ensure port 80/443 are accessible
4. Review SSL configuration in Coolify

## 📝 Post-Deployment Checklist

- [ ] Application accessible at `https://tms.opshub.photos`
- [ ] Pre-order form loads: `/pre-order/start`
- [ ] Admin panel accessible: `/admin`
- [ ] User panel accessible: `/my-account`
- [ ] Database migrations completed
- [ ] Queue workers running
- [ ] SSL certificate active
- [ ] Environment variables configured
- [ ] Storage directories writable
- [ ] Logs accessible

## 🔗 Useful Links

- Coolify Dashboard: `http://31.97.65.164:8000`
- Application URL: `https://tms.opshub.photos`
- Admin Panel: `https://tms.opshub.photos/admin`

---

**Last Updated:** 2025-01-27  
**Coolify Instance:** http://31.97.65.164:8000

