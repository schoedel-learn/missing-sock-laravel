# Quick Installation Guide - srv949418.hstgr.cloud

## 🚀 Fast Track Installation

### Step 1: Set Up SSH Access (Local Machine)

```bash
# Run the SSH setup script
./ssh-setup.sh
```

This will configure your local SSH to connect to the server easily.

### Step 2: Connect to Server

```bash
# Connect via SSH (you'll need to authenticate)
ssh root@31.97.65.164

# Or if you've set up the SSH config:
ssh missing-sock-server
```

### Step 3: Upload Installation Script

From your local machine:

```bash
# Upload the installation script
scp install-server.sh root@31.97.65.164:/tmp/
```

### Step 4: Run Installation

On the server:

```bash
# Make executable and run
chmod +x /tmp/install-server.sh
/tmp/install-server.sh
```

The script will guide you through:
- ✅ Installing all dependencies
- ✅ Setting up the database
- ✅ Configuring Nginx
- ✅ Setting up SSL
- ✅ Configuring queue workers

### Step 5: Clone Your Repository

During installation, you'll be prompted to clone your Git repository. If you haven't already:

```bash
cd /var/www
git clone <your-repository-url> missing-sock-laravel
cd missing-sock-laravel
```

### Step 6: Configure Environment

After installation, edit the `.env` file:

```bash
nano /var/www/missing-sock-laravel/.env
```

**Required Settings:**
- `APP_URL=https://srv949418.hstgr.cloud`
- Database credentials (set during installation)
- Stripe keys (get from Stripe dashboard)
- Mail settings (SMTP credentials)

### Step 7: Create Admin User

```bash
cd /var/www/missing-sock-laravel
php artisan make:filament-user
```

### Step 8: Test Application

Visit:
- **Homepage:** https://srv949418.hstgr.cloud
- **Admin Panel:** https://srv949418.hstgr.cloud/admin
- **Pre-Order Form:** https://srv949418.hstgr.cloud/pre-order/start

## 📋 What Gets Installed

- ✅ PHP 8.2 with all required extensions
- ✅ Composer (PHP dependency manager)
- ✅ Node.js 20.x and NPM
- ✅ Nginx web server
- ✅ MySQL database server
- ✅ SSL certificate (Let's Encrypt)
- ✅ Supervisor (queue workers)
- ✅ Cron jobs (scheduled tasks)

## 🔧 Post-Installation

### Check Status

```bash
# Check Nginx
systemctl status nginx

# Check PHP-FPM
systemctl status php8.2-fpm

# Check Queue Workers
supervisorctl status

# Check MySQL
systemctl status mysql
```

### View Logs

```bash
# Application logs
tail -f /var/www/missing-sock-laravel/storage/logs/laravel.log

# Queue worker logs
tail -f /var/www/missing-sock-laravel/storage/logs/worker.log

# Nginx error logs
tail -f /var/log/nginx/error.log
```

## 🆘 Need Help?

See `SERVER_INSTALLATION_GUIDE.md` for detailed manual installation steps and troubleshooting.

## 📞 Support

For issues, contact: contact@schoedel.design

