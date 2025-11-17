# SSH Setup for Coolify Deployment

Quick guide to set up and deploy using Coolify via SSH.

## 🚀 Quick Start

### 1. Run Setup Check (via SSH)

SSH into your VPS and run:

```bash
# Upload the setup script first
scp setup-coolify.sh user@your-server-ip:/tmp/

# Then SSH in and run it
ssh user@your-server-ip
sudo bash /tmp/setup-coolify.sh
```

Or run the checks manually:

```bash
# Check Docker
docker --version

# Check if Coolify is running
docker ps | grep coolify

# Check ports
netstat -tuln | grep -E ':(80|443|8000)'

# Check DNS
dig +short tms.opshub.photos
```

### 2. Access Coolify Dashboard

Open in browser: `http://31.97.65.164:8000`

### 3. Create Application in Coolify

1. **Navigate to your project/environment**
   - Project ID: `agk4cs8ccgsk80cccgw0w0sg`
   - Environment ID: `ukws40c8kcs88k0kk4cggok8`
   - Direct URL: `http://31.97.65.164:8000/project/agk4cs8ccgsk80cccgw0w0sg/environment/ukws40c8kcs88k0kk4cggok8/new?server=0`

2. **Click "New Application"**

3. **Configure Source:**
   - **Source Type:** Git Repository
   - **Repository URL:** Your Git repo URL (GitHub/GitLab)
   - **Branch:** `main`
   - **Build Pack:** Dockerfile

### 4. Build Configuration

**Build Command:**
```bash
composer install --optimize-autoloader --no-dev --no-interaction && npm install && npm run build
```

**Start Command:**
```bash
php-fpm
```

**Port:** `9000` (PHP-FPM)

**Dockerfile:** Use `Dockerfile.coolify` (or the default `Dockerfile`)

### 5. Environment Variables

Add these in Coolify's environment variables section:

```env
APP_NAME="The Missing Sock Photography"
APP_ENV=production
APP_KEY=base64:YOUR_GENERATED_KEY_HERE
APP_DEBUG=false
APP_URL=https://tms.opshub.photos

DB_CONNECTION=mysql
DB_HOST=your_database_host
DB_PORT=3306
DB_DATABASE=missing_sock_production
DB_USERNAME=your_db_user
DB_PASSWORD=your_secure_password

STRIPE_KEY=pk_live_your_publishable_key
STRIPE_SECRET=sk_live_your_secret_key
STRIPE_WEBHOOK_SECRET=whsec_your_webhook_secret

MAIL_MAILER=smtp
MAIL_HOST=your_smtp_host
MAIL_PORT=587
MAIL_USERNAME=your_smtp_username
MAIL_PASSWORD=your_smtp_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@opshub.photos
MAIL_FROM_NAME="The Missing Sock Photography"

QUEUE_CONNECTION=database
SESSION_DRIVER=database
CACHE_DRIVER=file
```

**Important:** 
- Generate `APP_KEY` after first deployment: `php artisan key:generate`
- Fill in your actual database credentials
- Add your Stripe keys
- Configure mail settings

### 6. Domain Configuration

- **Domain:** `tms.opshub.photos`
- **Enable SSL:** Yes (Let's Encrypt)
- **Force HTTPS:** Yes

**DNS Setup:**
- Point `tms.opshub.photos` A record to your server IP: `31.97.65.164`

### 7. Post-Deployment Commands

Add these in Coolify's "Post Deploy" section:

```bash
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan storage:link
chmod -R 775 storage bootstrap/cache
```

### 8. Deploy!

1. Click "Deploy" in Coolify
2. Monitor build logs
3. Wait for deployment to complete
4. Check application at: `https://tms.opshub.photos`

## 🔧 Troubleshooting via SSH

### Check Application Logs

```bash
# If deployed, check container logs
docker ps  # Find your container name
docker logs <container-name> -f
```

### Check Coolify Logs

```bash
# Find Coolify container
docker ps | grep coolify

# View logs
docker logs <coolify-container> -f
```

### Manual Database Migration (if needed)

```bash
# Get into the container
docker exec -it <container-name> bash

# Run migrations
php artisan migrate --force
php artisan config:cache
```

### Check File Permissions

```bash
# If you need to fix permissions manually
docker exec -it <container-name> bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

## 📋 Pre-Deployment Checklist

- [ ] DNS A record points to server IP
- [ ] Git repository is accessible
- [ ] Database server is ready
- [ ] Environment variables prepared
- [ ] Stripe keys ready
- [ ] Mail server configured
- [ ] Coolify dashboard accessible

## 🔄 Updates

After making code changes:

1. Push to Git repository (main branch)
2. In Coolify, click "Redeploy"
3. Monitor build logs
4. Verify deployment success

Or enable auto-deploy:
- Configure webhook in Coolify
- Set up Git webhook to trigger on push

## 📞 Quick Reference

- **Coolify Dashboard:** http://31.97.65.164:8000
- **Application URL:** https://tms.opshub.photos
- **Admin Panel:** https://tms.opshub.photos/admin
- **Health Check:** https://tms.opshub.photos/up

---

**Need Help?** Check `docs/setup/COOLIFY_DEPLOYMENT.md` for detailed guide.

