# Troubleshooting Guide - Page Not Loading

## Quick Diagnostics

Please run these commands and share the output:

### 1. Check if Laravel is running
```bash
cd /Users/schoedel/Projects/missing-sock-photos
php artisan serve
```

### 2. Check for errors
```bash
# Check Laravel logs
tail -n 50 storage/logs/laravel.log

# Check if routes are registered
php artisan route:list | grep home
```

### 3. Check if views exist
```bash
ls -la resources/views/
ls -la resources/views/layouts/
ls -la resources/views/components/
```

### 4. Check if assets are compiled
```bash
ls -la public/build/
```

---

## Common Issues & Solutions

### Issue 1: "404 Not Found"
**Problem:** Routes not registered

**Solution:**
```bash
php artisan route:clear
php artisan config:clear
php artisan cache:clear
```

### Issue 2: "View not found"
**Problem:** View files missing or in wrong location

**Solution:**
Check that these files exist:
- `resources/views/welcome.blade.php`
- `resources/views/layouts/app.blade.php`
- `resources/views/components/navigation.blade.php`
- `resources/views/components/footer.blade.php`

### Issue 3: "Vite manifest not found"
**Problem:** Assets not compiled

**Solution:**
```bash
npm install
npm run dev
```

Or for production:
```bash
npm run build
```

### Issue 4: "Class not found"
**Problem:** Composer autoload needs updating

**Solution:**
```bash
composer dump-autoload
```

---

## Step-by-Step Setup (if starting fresh)

```bash
# 1. Navigate to projects directory
cd /Users/schoedel/Projects

# 2. Create new Laravel project (if not already created)
composer create-project laravel/laravel missing-sock-photos

# 3. Enter project directory
cd missing-sock-photos

# 4. Install Composer dependencies
composer install

# 5. Copy .env file
cp .env.example .env

# 6. Generate app key
php artisan key:generate

# 7. Install NPM dependencies
npm install

# 8. Compile assets
npm run dev

# 9. Start server
php artisan serve
```

Then visit: http://127.0.0.1:8000

---

## What Error Are You Seeing?

Please share:
1. The exact error message (screenshot or text)
2. Which URL you're trying to access
3. Output of `php artisan serve`
4. Output of `npm run dev` (if running)

This will help me identify the exact issue!

