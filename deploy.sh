#!/bin/bash
# Deployment script for tms.opshub.photos

set -e

echo "🚀 Starting deployment..."

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Check if running as root or with sudo
if [ "$EUID" -ne 0 ]; then 
    echo -e "${RED}Please run as root or with sudo${NC}"
    exit 1
fi

APP_DIR="/var/www/missing-sock-laravel"
APP_USER="www-data"

echo -e "${YELLOW}Step 1: Pulling latest code...${NC}"
cd $APP_DIR
git pull origin main

echo -e "${YELLOW}Step 2: Installing dependencies...${NC}"
composer install --optimize-autoloader --no-dev --no-interaction
npm install
npm run build

echo -e "${YELLOW}Step 3: Running migrations...${NC}"
php artisan migrate --force

echo -e "${YELLOW}Step 4: Clearing and caching...${NC}"
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

echo -e "${YELLOW}Step 5: Setting permissions...${NC}"
chown -R $APP_USER:$APP_USER $APP_DIR
chmod -R 755 $APP_DIR
chmod -R 775 $APP_DIR/storage
chmod -R 775 $APP_DIR/bootstrap/cache

echo -e "${YELLOW}Step 6: Restarting queue workers...${NC}"
supervisorctl restart missing-sock-worker:*

echo -e "${GREEN}✅ Deployment complete!${NC}"
echo -e "${GREEN}Application is live at: https://tms.opshub.photos${NC}"
