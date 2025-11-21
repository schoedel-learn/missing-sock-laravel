# Server Installation Guide - srv949418.hstgr.cloud

Complete guide for installing The Missing Sock Laravel application on your server.

## 📋 Server Information

- **Domain:** srv949418.hstgr.cloud
- **IP Address:** 31.97.65.164
- **SSH Key:** ssh-ed25519 AAAAC3NzaC1lZDI1NTE5AAAAIGYS7EdrN2hR0pFA1Ndm5akMK7A/ZbzdzsZqC9f6aG7L contact@schoedel.design

## 🚀 Quick Installation (Automated)

### Step 1: Configure SSH Access

First, add the SSH key to your local machine:

```bash
# Add SSH key to your SSH config
mkdir -p ~/.ssh
chmod 700 ~/.ssh

# Add the server to your SSH config
cat >> ~/.ssh/config <<EOF
Host missing-sock-server
    HostName 31.97.65.164
    User root
    IdentityFile ~/.ssh/missing_sock_key
    IdentitiesOnly yes
EOF

# Save the SSH key
cat > ~/.ssh/missing_sock_key <<'EOF'
-----BEGIN OPENSSH PRIVATE KEY-----
# You'll need to add your private key here if you have it
# Otherwise, use password authentication for initial setup
EOF

chmod 600 ~/.ssh/missing_sock_key
```

### Step 2: Upload Installation Script

```bash
# Upload the installation script to the server
scp install-server.sh root@31.97.65.164:/tmp/

# Or if you need to use password authentication
scp install-server.sh root@31.97.65.164:/tmp/
```

### Step 3: Connect to Server and Run Installation

```bash
# SSH into the server
ssh root@31.97.65.164

# Make script executable and run
chmod +x /tmp/install-server.sh
/tmp/install-server.sh
```

The script will:
- ✅ Install PHP 8.2 and all required extensions
- ✅ Install Composer, Node.js, and NPM
- ✅ Set up MySQL database
- ✅ Configure Nginx web server
- ✅ Set up SSL certificate (Let's Encrypt)
- ✅ Configure queue workers (Supervisor)
- ✅ Set up cron jobs
- ✅ Optimize Laravel for production

## 📝 Manual Installation Steps

If you prefer to install manually, follow these steps:

### 1. Connect to Server

```bash
ssh root@31.97.65.164
```

### 2. Update System

```bash
apt update && apt upgrade -y
```

### 3. Install Required Packages

```bash
apt install -y \
    software-properties-common \
    curl \
    git \
    unzip \
    nginx \
    mysql-server \
    certbot \
    python3-certbot-nginx
```

### 4. Install PHP 8.2

```bash
add-apt-repository -y ppa:ondrej/php
apt update
apt install -y \
    php8.2-fpm \
    php8.2-mysql \
    php8.2-xml \
    php8.2-mbstring \
    php8.2-curl \
    php8.2-zip \
    php8.2-gd \
    php8.2-bcmath \
    php8.2-intl \
    php8.2-exif \
    php8.2-pcntl
```

### 5. Install Composer

```bash
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer
chmod +x /usr/local/bin/composer
```

### 6. Install Node.js

```bash
curl -fsSL https://deb.nodesource.com/setup_20.x | bash -
apt install -y nodejs
```

### 7. Clone Repository

```bash
cd /var/www
git clone <your-repository-url> missing-sock-laravel
cd missing-sock-laravel
```

### 8. Install Dependencies

```bash
composer install --optimize-autoloader --no-dev --no-interaction
npm install
npm run build
```

### 9. Set Up Database

```bash
mysql -u root -p <<EOF
CREATE DATABASE missing_sock_production CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'missing_sock_user'@'localhost' IDENTIFIED BY 'your_secure_password';
GRANT ALL PRIVILEGES ON missing_sock_production.* TO 'missing_sock_user'@'localhost';
FLUSH PRIVILEGES;
EOF
```

### 10. Configure Environment

```bash
cp .env.example .env
nano .env
```

Update these key values:

```env
APP_NAME="The Missing Sock Photography"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://srv949418.hstgr.cloud

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=missing_sock_production
DB_USERNAME=missing_sock_user
DB_PASSWORD=your_secure_password

STRIPE_KEY=pk_live_your_publishable_key
STRIPE_SECRET=sk_live_your_secret_key
STRIPE_WEBHOOK_SECRET=whsec_your_webhook_secret

MAIL_MAILER=smtp
MAIL_HOST=your_smtp_host
MAIL_PORT=587
MAIL_USERNAME=your_email
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@srv949418.hstgr.cloud
MAIL_FROM_NAME="The Missing Sock Photography"
```

Generate application key:

```bash
php artisan key:generate
```

### 11. Set Permissions

```bash
chown -R www-data:www-data /var/www/missing-sock-laravel
chmod -R 755 /var/www/missing-sock-laravel
chmod -R 775 /var/www/missing-sock-laravel/storage
chmod -R 775 /var/www/missing-sock-laravel/bootstrap/cache
```

### 12. Run Migrations

```bash
php artisan migrate --force
```

### 13. Configure Nginx

Create Nginx configuration:

```bash
nano /etc/nginx/sites-available/srv949418.hstgr.cloud
```

Add this configuration:

```nginx
server {
    listen 80;
    listen [::]:80;
    server_name srv949418.hstgr.cloud;
    root /var/www/missing-sock-laravel/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

Enable site:

```bash
ln -s /etc/nginx/sites-available/srv949418.hstgr.cloud /etc/nginx/sites-enabled/
rm /etc/nginx/sites-enabled/default
nginx -t
systemctl reload nginx
```

### 14. Set Up SSL Certificate

```bash
certbot --nginx -d srv949418.hstgr.cloud --non-interactive --agree-tos --email contact@schoedel.design
systemctl reload nginx
```

### 15. Set Up Queue Worker

Install Supervisor:

```bash
apt install -y supervisor
```

Create worker configuration:

```bash
nano /etc/supervisor/conf.d/missing-sock-worker.conf
```

Add:

```ini
[program:missing-sock-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/missing-sock-laravel/artisan queue:work database --sleep=3 --tries=3 --max-time=3600
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

Start worker:

```bash
supervisorctl reread
supervisorctl update
supervisorctl start missing-sock-worker:*
```

### 16. Set Up Cron Job

```bash
crontab -u www-data -e
```

Add:

```
* * * * * cd /var/www/missing-sock-laravel && php artisan schedule:run >> /dev/null 2>&1
```

### 17. Optimize Laravel

```bash
cd /var/www/missing-sock-laravel
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache
```

## ✅ Post-Installation Checklist

- [ ] Application accessible at `https://srv949418.hstgr.cloud`
- [ ] Admin panel accessible at `https://srv949418.hstgr.cloud/admin`
- [ ] Create admin user: `php artisan make:filament-user`
- [ ] Test pre-order form: `https://srv949418.hstgr.cloud/pre-order/start`
- [ ] Verify SSL certificate is working
- [ ] Check queue workers: `supervisorctl status`
- [ ] Test email sending
- [ ] Configure Stripe webhooks
- [ ] Set up backups

## 🔧 Useful Commands

### View Logs
```bash
tail -f /var/www/missing-sock-laravel/storage/logs/laravel.log
tail -f /var/www/missing-sock-laravel/storage/logs/worker.log
```

### Restart Services
```bash
# Restart PHP-FPM
systemctl restart php8.2-fpm

# Restart Nginx
systemctl restart nginx

# Restart queue workers
supervisorctl restart missing-sock-worker:*
```

### Clear Cache
```bash
cd /var/www/missing-sock-laravel
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### Update Application
```bash
cd /var/www/missing-sock-laravel
git pull
composer install --optimize-autoloader --no-dev --no-interaction
npm install
npm run build
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
supervisorctl restart missing-sock-worker:*
```

## 🆘 Troubleshooting

### Application Not Loading
- Check Nginx error logs: `tail -f /var/log/nginx/error.log`
- Check PHP-FPM logs: `tail -f /var/log/php8.2-fpm.log`
- Verify file permissions: `ls -la /var/www/missing-sock-laravel`
- Check Laravel logs: `tail -f /var/www/missing-sock-laravel/storage/logs/laravel.log`

### Database Connection Issues
- Verify database credentials in `.env`
- Test MySQL connection: `mysql -u missing_sock_user -p missing_sock_production`
- Check MySQL is running: `systemctl status mysql`

### Queue Not Processing
- Check Supervisor status: `supervisorctl status`
- View worker logs: `tail -f /var/www/missing-sock-laravel/storage/logs/worker.log`
- Restart workers: `supervisorctl restart missing-sock-worker:*`

### SSL Certificate Issues
- Renew certificate: `certbot renew`
- Check certificate status: `certbot certificates`
- Verify DNS is pointing to server IP

## 📞 Support

For issues or questions, contact: contact@schoedel.design

