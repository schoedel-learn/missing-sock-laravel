# Hostinger VPS Deployment Guide
## The Missing Sock Photography - Laravel Application

Complete step-by-step guide for deploying this Laravel application on a Hostinger VPS.

---

## 📋 Prerequisites

Before you begin, ensure you have:

- **Hostinger VPS Plan** (KVM 1 or higher recommended)
- **Domain Name** configured in Hostinger
- **SSH Access** to your VPS
- **Basic Linux Command Line Knowledge**
- **Git Repository Access** (or application files ready to upload)

### Minimum VPS Requirements
- **CPU:** 1 core (2+ recommended)
- **RAM:** 2GB minimum (4GB+ recommended for production)
- **Storage:** 20GB minimum
- **OS:** Ubuntu 20.04/22.04 (recommended) or CentOS 7/8

---

## 🚀 Part 1: Initial VPS Setup

### Step 1: Access Your VPS via SSH

From your local terminal:

```bash
# Replace with your VPS IP address
ssh root@your-vps-ip-address

# Or if you have a non-root user:
ssh username@your-vps-ip-address
```

If prompted, enter your VPS password (found in Hostinger's hPanel).

### Step 2: Update System Packages

```bash
# Update package lists
sudo apt update

# Upgrade installed packages
sudo apt upgrade -y

# Install essential tools
sudo apt install -y curl wget git unzip software-properties-common
```

### Step 3: Create a Swap File (If RAM < 4GB)

```bash
# Create 2GB swap file
sudo fallocate -l 2G /swapfile
sudo chmod 600 /swapfile
sudo mkswap /swapfile
sudo swapon /swapfile

# Make swap permanent
echo '/swapfile none swap sw 0 0' | sudo tee -a /etc/fstab

# Verify swap
free -h
```

---

## 🔧 Part 2: Install Required Software

### Step 4: Install PHP 8.2 and Extensions

```bash
# Add PHP repository
sudo add-apt-repository ppa:ondrej/php -y
sudo apt update

# Install PHP 8.2 and required extensions
sudo apt install -y php8.2-fpm php8.2-cli php8.2-mysql php8.2-xml \
    php8.2-mbstring php8.2-curl php8.2-zip php8.2-gd php8.2-bcmath \
    php8.2-intl php8.2-soap php8.2-redis php8.2-sqlite3

# Verify PHP installation
php -v
```

### Step 5: Install Composer

```bash
# Download and install Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
sudo chmod +x /usr/local/bin/composer

# Verify Composer installation
composer --version
```

### Step 6: Install Node.js and NPM

```bash
# Install Node.js 20.x LTS
curl -fsSL https://deb.nodesource.com/setup_20.x | sudo -E bash -
sudo apt install -y nodejs

# Verify installation
node -v
npm -v
```

### Step 7: Install MySQL/MariaDB

```bash
# Install MySQL Server
sudo apt install -y mysql-server

# Secure MySQL installation
sudo mysql_secure_installation

# Follow prompts:
# - Set root password: YES (choose a strong password)
# - Remove anonymous users: YES
# - Disallow root login remotely: YES
# - Remove test database: YES
# - Reload privilege tables: YES
```

### Step 8: Install Nginx Web Server

```bash
# Install Nginx
sudo apt install -y nginx

# Start and enable Nginx
sudo systemctl start nginx
sudo systemctl enable nginx

# Check status
sudo systemctl status nginx
```

### Step 9: Install Supervisor (For Queue Workers)

```bash
# Install Supervisor
sudo apt install -y supervisor

# Start and enable Supervisor
sudo systemctl start supervisor
sudo systemctl enable supervisor
```

---

## 📦 Part 3: Deploy Application

### Step 10: Create Application Directory

```bash
# Create web directory
sudo mkdir -p /var/www/missing-sock-laravel
cd /var/www

# Set ownership (replace 'www-data' if using different user)
sudo chown -R $USER:www-data missing-sock-laravel
```

### Step 11: Clone or Upload Application Files

**Option A: Clone from Git (Recommended)**

```bash
cd /var/www/missing-sock-laravel

# Clone repository
git clone https://github.com/schoedel-learn/missing-sock-laravel.git .

# Or if already in directory:
git clone https://github.com/schoedel-learn/missing-sock-laravel.git temp
mv temp/* temp/.* . 2>/dev/null
rm -rf temp
```

**Option B: Upload via SFTP**

Use an SFTP client (FileZilla, WinSCP, or Cyberduck):
- Host: your-vps-ip-address
- Port: 22
- Username: your-ssh-username
- Password: your-ssh-password
- Upload all files to: `/var/www/missing-sock-laravel`

### Step 12: Set File Permissions

```bash
cd /var/www/missing-sock-laravel

# Set proper ownership
sudo chown -R www-data:www-data .
sudo chown -R $USER:www-data storage bootstrap/cache

# Set directory permissions
sudo find . -type d -exec chmod 755 {} \;
sudo find . -type f -exec chmod 644 {} \;

# Set writable directories
sudo chmod -R 775 storage bootstrap/cache
sudo chmod +x artisan

# Set secure .env permissions (we'll create this next)
touch .env
sudo chmod 600 .env
```

### Step 13: Install PHP Dependencies

```bash
cd /var/www/missing-sock-laravel

# Install Composer dependencies (production mode)
composer install --optimize-autoloader --no-dev

# If you encounter memory issues, use:
# php -d memory_limit=-1 /usr/local/bin/composer install --optimize-autoloader --no-dev
```

### Step 14: Install Node Dependencies and Build Assets

```bash
cd /var/www/missing-sock-laravel

# Install NPM packages
npm install

# Build production assets
npm run build

# Clean up node_modules to save space (optional)
# rm -rf node_modules
```

---

## ⚙️ Part 4: Configure Application

### Step 15: Create Database

```bash
# Login to MySQL
sudo mysql -u root -p

# Create database and user
CREATE DATABASE missing_sock_production CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'missing_sock_user'@'localhost' IDENTIFIED BY 'your_secure_password_here';
GRANT ALL PRIVILEGES ON missing_sock_production.* TO 'missing_sock_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

### Step 16: Configure Environment File

```bash
cd /var/www/missing-sock-laravel

# Copy example environment file
cp .env.example .env

# Edit environment file
nano .env
```

**Update the following in `.env`:**

```env
APP_NAME="The Missing Sock Photography"
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=https://yourdomain.com

LOG_CHANNEL=stack
LOG_LEVEL=error

# Database Configuration
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=missing_sock_production
DB_USERNAME=missing_sock_user
DB_PASSWORD=your_secure_password_here

# Session & Cache
SESSION_DRIVER=database
CACHE_STORE=file

# Queue Configuration
QUEUE_CONNECTION=database

# Mail Configuration (configure based on your provider)
MAIL_MAILER=smtp
MAIL_HOST=your_smtp_host
MAIL_PORT=587
MAIL_USERNAME=your_email@domain.com
MAIL_PASSWORD=your_email_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@yourdomain.com
MAIL_FROM_NAME="${APP_NAME}"

# Stripe Configuration (get from https://dashboard.stripe.com)
STRIPE_KEY=pk_live_your_publishable_key
STRIPE_SECRET=sk_live_your_secret_key
STRIPE_WEBHOOK_SECRET=whsec_your_webhook_secret
```

Save and exit (Ctrl+X, then Y, then Enter).

### Step 17: Generate Application Key

```bash
cd /var/www/missing-sock-laravel

# Generate application key
php artisan key:generate

# Verify the key was added to .env
grep APP_KEY .env
```

### Step 18: Run Database Migrations

```bash
cd /var/www/missing-sock-laravel

# Run migrations
php artisan migrate --force

# Seed initial data (if applicable)
php artisan db:seed --class=PackageSeeder
php artisan db:seed --class=AddOnSeeder
```

### Step 19: Create Admin User

```bash
cd /var/www/missing-sock-laravel

# Create Filament admin user
php artisan make:filament-user

# Follow prompts to enter:
# - Name
# - Email
# - Password
```

### Step 20: Optimize Application

```bash
cd /var/www/missing-sock-laravel

# Cache configuration
php artisan config:cache

# Cache routes
php artisan route:cache

# Cache views
php artisan view:cache

# Cache events
php artisan event:cache
```

---

## 🌐 Part 5: Configure Web Server

### Step 21: Configure Domain in Hostinger hPanel

1. Login to **Hostinger hPanel**
2. Navigate to **Domains**
3. Select your domain
4. Update DNS settings:
   - **A Record:** Point to your VPS IP address
   - **CNAME (www):** Point to your domain

Wait 5-15 minutes for DNS propagation.

### Step 22: Create Nginx Server Block

```bash
# Create Nginx configuration file
sudo nano /etc/nginx/sites-available/missing-sock-laravel
```

**Add the following configuration:**

```nginx
server {
    listen 80;
    listen [::]:80;
    server_name yourdomain.com www.yourdomain.com;

    root /var/www/missing-sock-laravel/public;
    index index.php index.html;

    # Logging
    access_log /var/log/nginx/missing-sock-laravel.access.log;
    error_log /var/log/nginx/missing-sock-laravel.error.log;

    # Gzip Compression
    gzip on;
    gzip_vary on;
    gzip_proxied any;
    gzip_comp_level 6;
    gzip_types text/plain text/css text/xml text/javascript 
               application/json application/javascript application/xml+rss 
               application/rss+xml font/truetype font/opentype 
               application/vnd.ms-fontobject image/svg+xml;

    # Handle Laravel routes
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    # PHP-FPM Configuration
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
        fastcgi_hide_header X-Powered-By;
        fastcgi_buffer_size 128k;
        fastcgi_buffers 4 256k;
        fastcgi_busy_buffers_size 256k;
    }

    # Deny access to hidden files
    location ~ /\. {
        deny all;
    }

    # Cache static assets
    location ~* \.(jpg|jpeg|png|gif|ico|css|js|woff|woff2|ttf|svg|webp)$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
    }

    # Security Headers
    add_header X-Frame-Options "SAMEORIGIN" always;
    add_header X-Content-Type-Options "nosniff" always;
    add_header X-XSS-Protection "1; mode=block" always;
    add_header Referrer-Policy "no-referrer-when-downgrade" always;
}
```

**Replace `yourdomain.com` with your actual domain.**

Save and exit (Ctrl+X, then Y, then Enter).

### Step 23: Enable Site and Test Configuration

```bash
# Create symbolic link to enable site
sudo ln -s /etc/nginx/sites-available/missing-sock-laravel /etc/nginx/sites-enabled/

# Remove default site (optional)
sudo rm /etc/nginx/sites-enabled/default

# Test Nginx configuration
sudo nginx -t

# If test passes, reload Nginx
sudo systemctl reload nginx
```

---

## 🔒 Part 6: SSL Certificate (HTTPS)

### Step 24: Install Certbot

```bash
# Install Certbot and Nginx plugin
sudo apt install -y certbot python3-certbot-nginx
```

### Step 25: Obtain SSL Certificate

```bash
# Get certificate (replace with your domain)
sudo certbot --nginx -d yourdomain.com -d www.yourdomain.com

# Follow prompts:
# - Enter email address
# - Agree to terms of service
# - Choose whether to share email
# - Choose option 2: Redirect HTTP to HTTPS
```

Certbot will automatically:
- Obtain SSL certificate from Let's Encrypt
- Update Nginx configuration
- Set up auto-renewal

### Step 26: Test Auto-Renewal

```bash
# Test certificate renewal (dry run)
sudo certbot renew --dry-run

# Auto-renewal is configured via systemd timer
sudo systemctl status certbot.timer
```

---

## ⚡ Part 7: Configure Background Jobs

### Step 27: Create Supervisor Configuration for Queue Workers

```bash
# Create supervisor config
sudo nano /etc/supervisor/conf.d/missing-sock-worker.conf
```

**Add the following:**

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

Save and exit (Ctrl+X, then Y, then Enter).

### Step 28: Start Queue Workers

```bash
# Reload Supervisor configuration
sudo supervisorctl reread
sudo supervisorctl update

# Start workers
sudo supervisorctl start missing-sock-worker:*

# Check status
sudo supervisorctl status
```

### Step 29: Setup Cron for Scheduled Tasks

```bash
# Edit crontab for www-data user
sudo crontab -e -u www-data
```

**Add this line at the bottom:**

```bash
* * * * * cd /var/www/missing-sock-laravel && php artisan schedule:run >> /dev/null 2>&1
```

Save and exit.

---

## 🔥 Part 8: Configure Firewall

### Step 30: Setup UFW Firewall

```bash
# Install UFW (if not already installed)
sudo apt install -y ufw

# Allow SSH (IMPORTANT - do this first!)
sudo ufw allow ssh
sudo ufw allow 22/tcp

# Allow HTTP and HTTPS
sudo ufw allow 'Nginx Full'
sudo ufw allow 80/tcp
sudo ufw allow 443/tcp

# Enable firewall
sudo ufw enable

# Check status
sudo ufw status
```

---

## ✅ Part 9: Final Checks & Testing

### Step 31: Verify Application

```bash
# Check file permissions
ls -la /var/www/missing-sock-laravel/storage
ls -la /var/www/missing-sock-laravel/bootstrap/cache

# Test application
curl -I https://yourdomain.com

# Check Laravel logs
tail -f /var/www/missing-sock-laravel/storage/logs/laravel.log

# Check queue worker logs
tail -f /var/www/missing-sock-laravel/storage/logs/worker.log

# Check Nginx error logs
sudo tail -f /var/log/nginx/missing-sock-laravel.error.log
```

### Step 32: Test Application Features

Visit these URLs in your browser:

1. **Homepage:** `https://yourdomain.com`
2. **Pre-Order Form:** `https://yourdomain.com/pre-order/start`
3. **Admin Panel:** `https://yourdomain.com/admin`
4. **User Panel:** `https://yourdomain.com/my-account`
5. **Health Check:** `https://yourdomain.com/up`

**Test Checklist:**
- [ ] Homepage loads correctly
- [ ] SSL certificate is valid (https with lock icon)
- [ ] Pre-order form is accessible
- [ ] Admin panel login works
- [ ] Static assets (images, CSS, JS) load properly
- [ ] Forms submit without errors
- [ ] Email notifications work (if configured)
- [ ] Queue jobs process (check supervisor status)

---

## 🔄 Part 10: Maintenance & Updates

### Deploying Updates

```bash
cd /var/www/missing-sock-laravel

# Pull latest code
git pull origin main

# Install/update dependencies
composer install --optimize-autoloader --no-dev
npm install
npm run build

# Run migrations
php artisan migrate --force

# Clear and cache
php artisan config:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Restart queue workers
sudo supervisorctl restart missing-sock-worker:*
```

### Backup Database

```bash
# Create backups directory
mkdir -p /home/$USER/backups

# Backup database
mysqldump -u missing_sock_user -p missing_sock_production > /home/$USER/backups/missing-sock-$(date +%Y%m%d_%H%M%S).sql

# Compress backup
gzip /home/$USER/backups/missing-sock-$(date +%Y%m%d_%H%M%S).sql
```

### Monitor Logs

```bash
# Application logs
tail -f /var/www/missing-sock-laravel/storage/logs/laravel.log

# Queue worker logs
tail -f /var/www/missing-sock-laravel/storage/logs/worker.log

# Nginx access logs
sudo tail -f /var/log/nginx/missing-sock-laravel.access.log

# Nginx error logs
sudo tail -f /var/log/nginx/missing-sock-laravel.error.log

# System logs
sudo journalctl -f
```

---

## 🆘 Troubleshooting

### Issue: 500 Internal Server Error

**Solution:**
```bash
# Check Laravel logs
tail -50 /var/www/missing-sock-laravel/storage/logs/laravel.log

# Check Nginx logs
sudo tail -50 /var/log/nginx/missing-sock-laravel.error.log

# Verify file permissions
sudo chown -R www-data:www-data /var/www/missing-sock-laravel
sudo chmod -R 775 storage bootstrap/cache

# Clear all caches
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

### Issue: Database Connection Failed

**Solution:**
```bash
# Test MySQL connection
mysql -u missing_sock_user -p missing_sock_production

# Verify credentials in .env
cat /var/www/missing-sock-laravel/.env | grep DB_

# Restart MySQL
sudo systemctl restart mysql
```

### Issue: Queue Jobs Not Processing

**Solution:**
```bash
# Check supervisor status
sudo supervisorctl status

# Restart workers
sudo supervisorctl restart missing-sock-worker:*

# Check worker logs
tail -50 /var/www/missing-sock-laravel/storage/logs/worker.log

# Manually process queue (for testing)
cd /var/www/missing-sock-laravel
php artisan queue:work --once
```

### Issue: Composer Memory Limit Error

**Solution:**
```bash
# Install with unlimited memory
php -d memory_limit=-1 /usr/local/bin/composer install --optimize-autoloader --no-dev
```

### Issue: NPM Build Fails

**Solution:**
```bash
# Clear npm cache
npm cache clean --force

# Remove node_modules and reinstall
rm -rf node_modules package-lock.json
npm install
npm run build
```

### Issue: Permission Denied Errors

**Solution:**
```bash
cd /var/www/missing-sock-laravel

# Reset ownership
sudo chown -R www-data:www-data .

# Reset permissions
sudo find . -type d -exec chmod 755 {} \;
sudo find . -type f -exec chmod 644 {} \;
sudo chmod -R 775 storage bootstrap/cache
sudo chmod 600 .env
```

### Issue: SSL Certificate Not Working

**Solution:**
```bash
# Re-run certbot
sudo certbot --nginx -d yourdomain.com -d www.yourdomain.com --force-renewal

# Check certificate
sudo certbot certificates

# Test Nginx configuration
sudo nginx -t
sudo systemctl reload nginx
```

---

## 📊 Performance Optimization

### Enable OPcache

```bash
# Edit PHP-FPM configuration
sudo nano /etc/php/8.2/fpm/php.ini

# Find and update these values:
opcache.enable=1
opcache.memory_consumption=256
opcache.interned_strings_buffer=16
opcache.max_accelerated_files=10000
opcache.revalidate_freq=2
opcache.fast_shutdown=1

# Restart PHP-FPM
sudo systemctl restart php8.2-fpm
```

### Optimize MySQL

```bash
# Edit MySQL configuration
sudo nano /etc/mysql/mysql.conf.d/mysqld.cnf

# Add under [mysqld] section:
innodb_buffer_pool_size = 256M
innodb_log_file_size = 64M
max_connections = 100

# Restart MySQL
sudo systemctl restart mysql
```

---

## 🎉 Success!

Your application is now deployed on Hostinger VPS! 

**Next Steps:**
1. Configure email provider (SendGrid, Mailgun, etc.)
2. Set up Stripe webhooks for payment processing
3. Configure regular backups
4. Set up monitoring (optional)
5. Test all features thoroughly
6. Import your data/content

**Important URLs:**
- Homepage: `https://yourdomain.com`
- Admin Panel: `https://yourdomain.com/admin`
- User Panel: `https://yourdomain.com/my-account`
- Pre-Order Form: `https://yourdomain.com/pre-order/start`

---

## 📞 Need Help?

- Review the [main deployment guide](DEPLOYMENT.md) for additional information
- Check the [troubleshooting guide](TROUBLESHOOTING.md)
- Review Laravel logs: `/var/www/missing-sock-laravel/storage/logs/laravel.log`

**Common Hostinger Support Links:**
- Hostinger Knowledge Base: https://support.hostinger.com/
- VPS Management: Login to hPanel > VPS
- DNS Management: Login to hPanel > Domains

---

**Last Updated:** November 2024  
**Application:** The Missing Sock Photography - Laravel 12  
**Target Platform:** Hostinger VPS (Ubuntu 20.04/22.04)
