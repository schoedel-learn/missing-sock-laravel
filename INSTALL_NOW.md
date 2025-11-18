# 🚀 Install Now - Quick Commands

## Option 1: Automated (Recommended)

Run these commands **one at a time** in your terminal:

```bash
# 1. Upload the installation script to your server
scp install-server.sh root@31.97.65.164:/tmp/

# 2. Connect to your server and run installation
ssh root@31.97.65.164 "chmod +x /tmp/install-server.sh && /tmp/install-server.sh"
```

The installation will take about 10-15 minutes and will guide you through:
- Database password setup
- Git repository cloning
- SSL certificate setup

## Option 2: Copy-Paste Installation Script

If you prefer to copy-paste the script directly:

1. **Connect to your server:**
   ```bash
   ssh root@31.97.65.164
   ```

2. **Create and run the installation script:**
   ```bash
   # Copy the entire install-server.sh file content
   # Then paste it into a file on the server:
   nano /tmp/install-server.sh
   # (Paste the content, save with Ctrl+X, then Y, then Enter)
   
   chmod +x /tmp/install-server.sh
   /tmp/install-server.sh
   ```

## Option 3: Use the Master Script

Run this locally (it will guide you):

```bash
./run-installation.sh
```

## 📋 What You'll Need During Installation

1. **Git Repository URL** - To clone your code
2. **MySQL Root Password** - For database setup
3. **Database Password** - For the application database user
4. **Domain DNS** - Make sure `srv949418.hstgr.cloud` points to `31.97.65.164`

## ✅ After Installation

1. **Update .env file** with Stripe keys and mail settings:
   ```bash
   ssh root@31.97.65.164
   nano /var/www/missing-sock-laravel/.env
   ```

2. **Create admin user:**
   ```bash
   cd /var/www/missing-sock-laravel
   php artisan make:filament-user
   ```

3. **Test your application:**
   - https://srv949418.hstgr.cloud
   - https://srv949418.hstgr.cloud/admin

## 🆘 Need Help?

See `SERVER_INSTALLATION_GUIDE.md` for detailed troubleshooting.

