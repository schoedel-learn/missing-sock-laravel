# Hostinger VPS Quick Reference Guide
## The Missing Sock Photography - Common Commands

Quick reference for managing your Laravel application on Hostinger VPS.

---

## 🚀 Quick Installation

### Automated Installation (Recommended)

**IMPORTANT:** Run these commands on your Hostinger VPS (after SSH), not on your local machine.

```bash
# SSH into your VPS first
ssh root@your-vps-ip-address

# Then on your VPS, download and run the script:
cd /tmp
wget https://raw.githubusercontent.com/schoedel-learn/missing-sock-laravel/main/scripts/hostinger-install.sh
sudo bash hostinger-install.sh

# OR if wget is not available, use curl:
curl -O https://raw.githubusercontent.com/schoedel-learn/missing-sock-laravel/main/scripts/hostinger-install.sh
sudo bash hostinger-install.sh
```

### Manual Installation
See [HOSTINGER_VPS_DEPLOYMENT.md](HOSTINGER_VPS_DEPLOYMENT.md) for step-by-step guide.

---

## 📁 Common File Locations

```
Application Directory:  /var/www/missing-sock-laravel
Configuration File:     /var/www/missing-sock-laravel/.env
Laravel Logs:          /var/www/missing-sock-laravel/storage/logs/laravel.log
Queue Worker Logs:     /var/www/missing-sock-laravel/storage/logs/worker.log
Nginx Config:          /etc/nginx/sites-available/missing-sock-laravel
Nginx Logs:            /var/log/nginx/missing-sock-laravel.*.log
Supervisor Config:     /etc/supervisor/conf.d/missing-sock-worker.conf
SSL Certificates:      /etc/letsencrypt/live/yourdomain.com/
```

---

## 🔧 Essential Commands

### Application Management

```bash
# Navigate to application directory
cd /var/www/missing-sock-laravel

# Check application status
php artisan about

# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Rebuild caches (production)
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# Run migrations
php artisan migrate

# Rollback last migration
php artisan migrate:rollback

# Check migration status
php artisan migrate:status
```

### User Management

```bash
# Create admin user
cd /var/www/missing-sock-laravel
php artisan make:filament-user

# List all users (via tinker)
php artisan tinker
>>> User::all();
>>> exit
```

### Queue Management

```bash
# Check queue worker status
sudo supervisorctl status

# Start queue workers
sudo supervisorctl start missing-sock-worker:*

# Stop queue workers
sudo supervisorctl stop missing-sock-worker:*

# Restart queue workers
sudo supervisorctl restart missing-sock-worker:*

# Reload supervisor configuration
sudo supervisorctl reread
sudo supervisorctl update

# Process one job manually (testing)
cd /var/www/missing-sock-laravel
php artisan queue:work --once
```

### Web Server (Nginx)

```bash
# Test Nginx configuration
sudo nginx -t

# Reload Nginx (apply changes without downtime)
sudo systemctl reload nginx

# Restart Nginx
sudo systemctl restart nginx

# Check Nginx status
sudo systemctl status nginx

# View Nginx error log
sudo tail -f /var/log/nginx/missing-sock-laravel.error.log

# View Nginx access log
sudo tail -f /var/log/nginx/missing-sock-laravel.access.log
```

### PHP-FPM

```bash
# Restart PHP-FPM
sudo systemctl restart php8.2-fpm

# Check PHP-FPM status
sudo systemctl status php8.2-fpm

# View PHP-FPM error log
sudo tail -f /var/log/php8.2-fpm.log
```

### Database (MySQL)

```bash
# Login to MySQL
sudo mysql -u root -p

# Login as application user
mysql -u missing_sock_user -p missing_sock_production

# Backup database
mysqldump -u missing_sock_user -p missing_sock_production > backup_$(date +%Y%m%d).sql

# Restore database
mysql -u missing_sock_user -p missing_sock_production < backup_file.sql

# Check database size
mysql -u missing_sock_user -p -e "
    SELECT table_schema AS 'Database', 
    ROUND(SUM(data_length + index_length) / 1024 / 1024, 2) AS 'Size (MB)' 
    FROM information_schema.TABLES 
    WHERE table_schema = 'missing_sock_production';"
```

---

## 📊 Monitoring & Logs

### View Logs in Real-Time

```bash
# Laravel application log
tail -f /var/www/missing-sock-laravel/storage/logs/laravel.log

# Queue worker log
tail -f /var/www/missing-sock-laravel/storage/logs/worker.log

# Nginx error log
sudo tail -f /var/log/nginx/missing-sock-laravel.error.log

# Nginx access log
sudo tail -f /var/log/nginx/missing-sock-laravel.access.log

# System logs
sudo journalctl -f

# PHP-FPM logs
sudo tail -f /var/log/php8.2-fpm.log
```

### Check Disk Space

```bash
# Check overall disk usage
df -h

# Check directory sizes
du -sh /var/www/missing-sock-laravel/*

# Find large files
sudo find /var/www/missing-sock-laravel -type f -size +100M -exec ls -lh {} \;
```

### Check Memory Usage

```bash
# System memory
free -h

# Process memory
ps aux --sort=-%mem | head -10

# Top processes
htop  # (install with: sudo apt install htop)
```

### Check Server Load

```bash
# Current load
uptime

# Detailed system info
top

# Process list
ps aux

# Check running services
sudo systemctl list-units --type=service --state=running
```

---

## 🔄 Deployment & Updates

### Pull Latest Code and Update

```bash
cd /var/www/missing-sock-laravel

# Pull latest changes
git pull origin main

# Install/update dependencies
composer install --optimize-autoloader --no-dev
npm install
npm run build

# Run migrations
php artisan migrate --force

# Clear and rebuild caches
php artisan config:clear
php artisan cache:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Restart queue workers
sudo supervisorctl restart missing-sock-worker:*

# Check status
php artisan about
```

### Rollback Deployment

```bash
cd /var/www/missing-sock-laravel

# Revert to previous commit
git reset --hard HEAD~1

# Or checkout specific commit
git checkout <commit-hash>

# Rollback migrations (if needed)
php artisan migrate:rollback

# Rebuild caches
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Restart workers
sudo supervisorctl restart missing-sock-worker:*
```

---

## 🔒 SSL Certificate Management

### Renew SSL Certificate

```bash
# Test renewal (dry run)
sudo certbot renew --dry-run

# Force renewal
sudo certbot renew --force-renewal

# Renew specific domain
sudo certbot certonly --nginx -d yourdomain.com -d www.yourdomain.com

# Check certificate expiry
sudo certbot certificates
```

### Auto-Renewal

```bash
# Check auto-renewal timer
sudo systemctl status certbot.timer

# Enable auto-renewal
sudo systemctl enable certbot.timer
sudo systemctl start certbot.timer
```

---

## 🔥 Firewall Management

### UFW Firewall Commands

```bash
# Check firewall status
sudo ufw status

# Enable firewall
sudo ufw enable

# Disable firewall (not recommended)
sudo ufw disable

# Allow SSH (IMPORTANT!)
sudo ufw allow ssh
sudo ufw allow 22/tcp

# Allow HTTP/HTTPS
sudo ufw allow 80/tcp
sudo ufw allow 443/tcp
sudo ufw allow 'Nginx Full'

# Allow specific IP
sudo ufw allow from 123.123.123.123

# Delete rule
sudo ufw delete allow 80/tcp

# Reset firewall (remove all rules)
sudo ufw reset
```

---

## 🛠️ Troubleshooting Commands

### Fix Permissions

```bash
cd /var/www/missing-sock-laravel

# Reset ownership
sudo chown -R www-data:www-data .

# Reset directory permissions
sudo find . -type d -exec chmod 755 {} \;

# Reset file permissions
sudo find . -type f -exec chmod 644 {} \;

# Set writable directories
sudo chmod -R 775 storage bootstrap/cache

# Secure .env file
sudo chmod 600 .env

# Make artisan executable
sudo chmod +x artisan
```

### Clear Everything (Nuclear Option)

```bash
cd /var/www/missing-sock-laravel

# Clear all Laravel caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan event:clear

# Clear compiled files
php artisan clear-compiled

# Clear queue jobs
php artisan queue:clear

# Optimize autoloader
composer dump-autoload -o

# Rebuild everything
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# Restart services
sudo systemctl restart php8.2-fpm
sudo systemctl restart nginx
sudo supervisorctl restart missing-sock-worker:*
```

### Test Database Connection

```bash
cd /var/www/missing-sock-laravel

# Test via artisan
php artisan migrate:status

# Test via tinker
php artisan tinker
>>> DB::connection()->getPdo();
>>> exit
```

### Debug Mode (NEVER in Production!)

```bash
# ONLY for troubleshooting, NEVER leave enabled!
nano /var/www/missing-sock-laravel/.env

# Change:
APP_DEBUG=true

# After debugging, IMMEDIATELY set back:
APP_DEBUG=false

# Clear config cache
php artisan config:clear
```

---

## 📦 Backup & Restore

### Create Backup

```bash
# Create backup directory
mkdir -p ~/backups

# Backup database
mysqldump -u missing_sock_user -p missing_sock_production > ~/backups/db_$(date +%Y%m%d_%H%M%S).sql

# Backup files
tar -czf ~/backups/files_$(date +%Y%m%d_%H%M%S).tar.gz /var/www/missing-sock-laravel

# Backup .env file
cp /var/www/missing-sock-laravel/.env ~/backups/env_$(date +%Y%m%d_%H%M%S).backup

# List backups
ls -lh ~/backups/
```

### Restore Backup

```bash
# Restore database
mysql -u missing_sock_user -p missing_sock_production < ~/backups/db_20240101_120000.sql

# Restore files
tar -xzf ~/backups/files_20240101_120000.tar.gz -C /

# After restore
cd /var/www/missing-sock-laravel
php artisan config:cache
php artisan route:cache
sudo supervisorctl restart missing-sock-worker:*
```

### Automated Backup Script

```bash
# Create backup script
nano ~/backup-script.sh

# Add this content:
#!/bin/bash
BACKUP_DIR=~/backups
mkdir -p $BACKUP_DIR
DATE=$(date +%Y%m%d_%H%M%S)

# Backup database
mysqldump -u missing_sock_user -p'your_password' missing_sock_production > $BACKUP_DIR/db_$DATE.sql

# Backup files
tar -czf $BACKUP_DIR/files_$DATE.tar.gz /var/www/missing-sock-laravel

# Keep only last 7 days of backups
find $BACKUP_DIR -name "*.sql" -mtime +7 -delete
find $BACKUP_DIR -name "*.tar.gz" -mtime +7 -delete

# Make executable
chmod +x ~/backup-script.sh

# Add to crontab (daily at 2 AM)
(crontab -l 2>/dev/null; echo "0 2 * * * ~/backup-script.sh") | crontab -
```

---

## 📈 Performance Optimization

### Enable OPcache

```bash
# Edit PHP configuration
sudo nano /etc/php/8.2/fpm/php.ini

# Add/update:
opcache.enable=1
opcache.memory_consumption=256
opcache.interned_strings_buffer=16
opcache.max_accelerated_files=10000

# Restart PHP-FPM
sudo systemctl restart php8.2-fpm
```

### Check OPcache Status

```bash
# Via command line
php -r "var_dump(opcache_get_status());"

# Via artisan
cd /var/www/missing-sock-laravel
php artisan optimize
```

---

## 🔑 SSH Key Authentication (More Secure)

### Setup SSH Key (From Local Machine)

```bash
# Generate SSH key (on your local machine)
ssh-keygen -t rsa -b 4096 -C "your_email@example.com"

# Copy to VPS
ssh-copy-id username@your-vps-ip

# Test connection
ssh username@your-vps-ip
```

---

## 📞 Emergency Commands

### Server is Unresponsive

```bash
# Check system load
uptime

# Kill hung processes
sudo pkill -9 php

# Restart all services
sudo systemctl restart php8.2-fpm
sudo systemctl restart nginx
sudo systemctl restart mysql
sudo supervisorctl restart all
```

### Out of Disk Space

```bash
# Find largest directories
du -h /var/www/missing-sock-laravel | sort -rh | head -20

# Clear logs
sudo truncate -s 0 /var/log/nginx/*.log
sudo truncate -s 0 /var/www/missing-sock-laravel/storage/logs/*.log

# Clear apt cache
sudo apt clean

# Remove old kernels
sudo apt autoremove -y
```

---

## 📱 Useful One-Liners

```bash
# Check if application is responding
curl -I https://yourdomain.com

# Count failed jobs in queue
cd /var/www/missing-sock-laravel && php artisan tinker -e "echo DB::table('failed_jobs')->count();"

# List recent errors in Laravel log
tail -100 /var/www/missing-sock-laravel/storage/logs/laravel.log | grep ERROR

# Check PHP version
php -v

# Check Composer version
composer --version

# Check Node version
node -v

# Restart all services at once
sudo systemctl restart php8.2-fpm nginx mysql && sudo supervisorctl restart all
```

---

## 🎯 Important URLs

```
Homepage:           https://yourdomain.com
Admin Panel:        https://yourdomain.com/admin
User Panel:         https://yourdomain.com/my-account
Pre-Order Form:     https://yourdomain.com/pre-order/start
Health Check:       https://yourdomain.com/up
```

---

## 📚 Additional Resources

- **Full Deployment Guide:** [HOSTINGER_VPS_DEPLOYMENT.md](HOSTINGER_VPS_DEPLOYMENT.md)
- **General Deployment:** [DEPLOYMENT.md](DEPLOYMENT.md)
- **Troubleshooting:** [TROUBLESHOOTING.md](TROUBLESHOOTING.md)
- **Laravel Documentation:** https://laravel.com/docs
- **Hostinger Support:** https://support.hostinger.com

---

**Last Updated:** November 2024  
**Version:** 1.0
