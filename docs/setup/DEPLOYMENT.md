# Deployment Guide - tms.opshub.photos

Complete guide for deploying The Missing Sock Laravel application to production.

## 📋 Prerequisites

- Server with PHP 8.2+ and required extensions
- MySQL/MariaDB or PostgreSQL database
- Nginx or Apache web server
- SSL certificate (Let's Encrypt recommended)
- Domain DNS configured to point to server IP

## 🚀 Deployment Steps

### 1. Server Setup

#### Install Required PHP Extensions
```bash
sudo apt update
sudo apt install php8.2-fpm php8.2-mysql php8.2-xml php8.2-mbstring php8.2-curl php8.2-zip php8.2-gd php8.2-bcmath php8.2-intl
```

#### Install Composer
```bash
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
```

#### Install Node.js & NPM
```bash
curl -fsSL https://deb.nodesource.com/setup_20.x | sudo -E bash -
sudo apt install -y nodejs
```

### 2. Application Deployment

#### Clone/Upload Application
```bash
# Option A: Git clone
cd /var/www
sudo git clone <your-repo-url> missing-sock-laravel
cd missing-sock-laravel

# Option B: Upload via SFTP/SCP
# Upload files to /var/www/missing-sock-laravel
```

#### Set Permissions
```bash
cd /var/www/missing-sock-laravel
sudo chown -R www-data:www-data .
sudo chmod -R 755 .
sudo chmod -R 775 storage bootstrap/cache
```

#### Install Dependencies
```bash
composer install --optimize-autoloader --no-dev
npm install
npm run build
```

### 3. Environment Configuration

#### Create Production .env File
```bash
cp .env.example .env
nano .env
```

#### Configure .env for Production
```env
APP_NAME="The Missing Sock Photography"
APP_ENV=production
APP_KEY=base64:YOUR_GENERATED_KEY_HERE
APP_DEBUG=false
APP_URL=https://tms.opshub.photos

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=error

# Database Configuration
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=missing_sock_production
DB_USERNAME=your_db_user
DB_PASSWORD=your_secure_password

# Stripe Configuration
STRIPE_KEY=pk_live_your_publishable_key
STRIPE_SECRET=sk_live_your_secret_key
STRIPE_WEBHOOK_SECRET=whsec_your_webhook_secret

# Mail Configuration
MAIL_MAILER=smtp
MAIL_HOST=your_smtp_host
MAIL_PORT=587
MAIL_USERNAME=your_smtp_username
MAIL_PASSWORD=your_smtp_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@opshub.photos
MAIL_FROM_NAME="${APP_NAME}"

# Queue Configuration
QUEUE_CONNECTION=database

# Session & Cache
SESSION_DRIVER=database
CACHE_DRIVER=file
```

#### Generate Application Key
```bash
php artisan key:generate
```

#### Run Migrations
```bash
php artisan migrate --force
```

#### Seed Initial Data (Optional)
```bash
php artisan db:seed --class=PackageSeeder
php artisan db:seed --class=AddOnSeeder
```

#### Optimize Application
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache
```

### 4. Web Server Configuration

#### Nginx Configuration

Create `/etc/nginx/sites-available/tms.opshub.photos`:

```nginx
server {
    listen 80;
    listen [::]:80;
    server_name tms.opshub.photos;
    
    # Redirect HTTP to HTTPS
    return 301 https://$server_name$request_uri;
}

server {
    listen 443 ssl http2;
    listen [::]:443 ssl http2;
    server_name tms.opshub.photos;
    
    root /var/www/missing-sock-laravel/public;
    index index.php;

    # SSL Configuration (Let's Encrypt)
    ssl_certificate /etc/letsencrypt/live/tms.opshub.photos/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/tms.opshub.photos/privkey.pem;
    ssl_protocols TLSv1.2 TLSv1.3;
    ssl_ciphers HIGH:!aNULL:!MD5;
    ssl_prefer_server_ciphers on;

    # Security Headers
    add_header X-Frame-Options "SAMEORIGIN" always;
    add_header X-Content-Type-Options "nosniff" always;
    add_header X-XSS-Protection "1; mode=block" always;
    add_header Referrer-Policy "no-referrer-when-downgrade" always;
    add_header Content-Security-Policy "default-src 'self' http: https: data: blob: 'unsafe-inline'" always;

    # Logging
    access_log /var/log/nginx/tms.opshub.photos.access.log;
    error_log /var/log/nginx/tms.opshub.photos.error.log;

    # Gzip Compression
    gzip on;
    gzip_vary on;
    gzip_proxied any;
    gzip_comp_level 6;
    gzip_types text/plain text/css text/xml text/javascript application/json application/javascript application/xml+rss application/rss+xml font/truetype font/opentype application/vnd.ms-fontobject image/svg+xml;

    # Laravel Public Directory
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    # PHP-FPM Configuration
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
        fastcgi_hide_header X-Powered-By;
    }

    # Deny access to hidden files
    location ~ /\. {
        deny all;
    }

    # Deny access to storage and bootstrap cache
    location ~ ^/(storage|bootstrap/cache) {
        deny all;
    }

    # Cache static assets
    location ~* \.(jpg|jpeg|png|gif|ico|css|js|woff|woff2|ttf|svg|webp)$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
    }
}
```

#### Enable Site
```bash
sudo ln -s /etc/nginx/sites-available/tms.opshub.photos /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx
```

#### Apache Configuration (Alternative)

Create `/etc/apache2/sites-available/tms.opshub.photos.conf`:

```apache
<VirtualHost *:80>
    ServerName tms.opshub.photos
    Redirect permanent / https://tms.opshub.photos/
</VirtualHost>

<VirtualHost *:443>
    ServerName tms.opshub.photos
    DocumentRoot /var/www/missing-sock-laravel/public

    SSLEngine on
    SSLCertificateFile /etc/letsencrypt/live/tms.opshub.photos/fullchain.pem
    SSLCertificateKeyFile /etc/letsencrypt/live/tms.opshub.photos/privkey.pem

    <Directory /var/www/missing-sock-laravel/public>
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/tms.opshub.photos.error.log
    CustomLog ${APACHE_LOG_DIR}/tms.opshub.photos.access.log combined
</VirtualHost>
```

### 5. SSL Certificate (Let's Encrypt)

```bash
sudo apt install certbot python3-certbot-nginx
sudo certbot --nginx -d tms.opshub.photos
# Or for Apache:
sudo certbot --apache -d tms.opshub.photos
```

### 6. Queue Worker Setup

#### Create Supervisor Configuration

Create `/etc/supervisor/conf.d/missing-sock-worker.conf`:

```ini
[program:missing-sock-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/missing-sock-laravel/artisan queue:work database --sleep=3 --tries=3 --max-time=3600 --queue=emails,photos,downloads,default
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/var/www/missing-sock-laravel/storage/logs/worker.log
stopwaitsecs=3600
```

#### Start Supervisor
```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start missing-sock-worker:*
```

### 7. Scheduled Tasks (Cron)

Add to crontab (`crontab -e`):

```bash
* * * * * cd /var/www/missing-sock-laravel && php artisan schedule:run >> /dev/null 2>&1
```

### 8. Database Setup

#### Create Database
```sql
CREATE DATABASE missing_sock_production CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'missing_sock_user'@'localhost' IDENTIFIED BY 'secure_password_here';
GRANT ALL PRIVILEGES ON missing_sock_production.* TO 'missing_sock_user'@'localhost';
FLUSH PRIVILEGES;
```

### 9. Create Admin User

```bash
cd /var/www/missing-sock-laravel
php artisan make:filament-user
```

### 10. Final Checks

```bash
# Test configuration
php artisan config:clear
php artisan config:cache
php artisan route:clear
php artisan route:cache

# Check permissions
ls -la storage bootstrap/cache

# Test application
curl -I https://tms.opshub.photos
```

## 🔒 Security Checklist

- [ ] APP_DEBUG=false in production
- [ ] Strong database passwords
- [ ] SSL certificate installed and working
- [ ] File permissions set correctly (755/775)
- [ ] Storage and cache directories writable
- [ ] .env file not accessible via web
- [ ] Queue workers running
- [ ] Scheduled tasks configured
- [ ] Firewall configured (UFW recommended)
- [ ] Regular backups configured

## 📊 Monitoring

### Log Files
- Application: `/var/www/missing-sock-laravel/storage/logs/laravel.log`
- Nginx: `/var/log/nginx/tms.opshub.photos.error.log`
- Queue Worker: `/var/www/missing-sock-laravel/storage/logs/worker.log`

### Health Check Endpoint
```bash
curl https://tms.opshub.photos/up
```

## 🔄 Updates & Maintenance

### Update Application
```bash
cd /var/www/missing-sock-laravel
git pull origin main
composer install --optimize-autoloader --no-dev
npm install
npm run build
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
sudo supervisorctl restart missing-sock-worker:*
```

### Backup Database
```bash
mysqldump -u missing_sock_user -p missing_sock_production > backup_$(date +%Y%m%d).sql
```

## 🆘 Troubleshooting

### Application Not Loading
1. Check file permissions: `ls -la storage bootstrap/cache`
2. Check web server error logs
3. Verify .env configuration
4. Clear caches: `php artisan config:clear && php artisan cache:clear`

### Queue Not Processing
1. Check supervisor status: `sudo supervisorctl status`
2. Check worker logs: `tail -f storage/logs/worker.log`
3. Restart workers: `sudo supervisorctl restart missing-sock-worker:*`

### 500 Errors
1. Check Laravel logs: `tail -f storage/logs/laravel.log`
2. Verify APP_DEBUG=false (don't enable in production)
3. Check PHP-FPM logs
4. Verify database connection

## 📝 Post-Deployment

1. Test all routes:
   - Homepage: `https://tms.opshub.photos`
   - Pre-order form: `https://tms.opshub.photos/pre-order/start`
   - Admin panel: `https://tms.opshub.photos/admin`
   - User panel: `https://tms.opshub.photos/my-account`

2. Test Stripe payment flow (use test mode first)

3. Verify email sending

4. Check queue processing

5. Monitor logs for errors

---

**Last Updated:** 2025-01-27  
**Domain:** tms.opshub.photos

