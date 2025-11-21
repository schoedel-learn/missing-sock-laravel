#!/bin/bash
# Server Installation Script for Missing Sock Laravel Application
# Domain: srv949418.hstgr.cloud
# IP: 31.97.65.164

set -e

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Configuration
DOMAIN="srv949418.hstgr.cloud"
APP_DIR="/var/www/missing-sock-laravel"
APP_USER="www-data"
DB_NAME="missing_sock_production"
DB_USER="missing_sock_user"

echo -e "${BLUE}========================================${NC}"
echo -e "${BLUE}Missing Sock Laravel Installation${NC}"
echo -e "${BLUE}========================================${NC}"
echo ""

# Check if running as root
if [ "$EUID" -ne 0 ]; then 
    echo -e "${RED}Please run as root or with sudo${NC}"
    exit 1
fi

# Step 1: Update system
echo -e "${YELLOW}[1/10] Updating system packages...${NC}"
apt update && apt upgrade -y

# Step 2: Install required packages
echo -e "${YELLOW}[2/10] Installing required packages...${NC}"
apt install -y \
    software-properties-common \
    curl \
    git \
    unzip \
    nginx \
    mysql-server \
    certbot \
    python3-certbot-nginx

# Step 3: Install PHP 8.2 and extensions
echo -e "${YELLOW}[3/10] Installing PHP 8.2 and extensions...${NC}"
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

# Step 4: Install Composer
echo -e "${YELLOW}[4/10] Installing Composer...${NC}"
if [ ! -f /usr/local/bin/composer ]; then
    curl -sS https://getcomposer.org/installer | php
    mv composer.phar /usr/local/bin/composer
    chmod +x /usr/local/bin/composer
fi

# Step 5: Install Node.js and NPM
echo -e "${YELLOW}[5/10] Installing Node.js and NPM...${NC}"
if ! command -v node &> /dev/null; then
    curl -fsSL https://deb.nodesource.com/setup_20.x | bash -
    apt install -y nodejs
fi

# Step 6: Create application directory
echo -e "${YELLOW}[6/10] Setting up application directory...${NC}"
mkdir -p $APP_DIR
cd $APP_DIR

# Check if directory is empty or has files
if [ "$(ls -A $APP_DIR)" ]; then
    echo -e "${YELLOW}Directory not empty. Assuming code is already there.${NC}"
else
    echo -e "${RED}Please clone your Git repository to $APP_DIR${NC}"
    echo -e "${YELLOW}Example: git clone <your-repo-url> $APP_DIR${NC}"
    read -p "Press Enter after you've cloned the repository..."
fi

# Step 7: Install application dependencies
echo -e "${YELLOW}[7/10] Installing application dependencies...${NC}"
cd $APP_DIR
composer install --optimize-autoloader --no-dev --no-interaction
npm install
npm run build

# Step 8: Set up database
echo -e "${YELLOW}[8/10] Setting up database...${NC}"
read -p "Enter MySQL root password (or press Enter if no password): " MYSQL_ROOT_PASSWORD
read -p "Enter database password for $DB_USER: " DB_PASSWORD

# Create database and user
mysql -u root ${MYSQL_ROOT_PASSWORD:+-p$MYSQL_ROOT_PASSWORD} <<EOF
CREATE DATABASE IF NOT EXISTS $DB_NAME CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER IF NOT EXISTS '$DB_USER'@'localhost' IDENTIFIED BY '$DB_PASSWORD';
GRANT ALL PRIVILEGES ON $DB_NAME.* TO '$DB_USER'@'localhost';
FLUSH PRIVILEGES;
EOF

# Step 9: Configure environment file
echo -e "${YELLOW}[9/10] Configuring environment...${NC}"
if [ ! -f $APP_DIR/.env ]; then
    if [ -f $APP_DIR/.env.example ]; then
        cp $APP_DIR/.env.example $APP_DIR/.env
    else
        echo -e "${RED}.env.example not found. Creating basic .env file...${NC}"
        cat > $APP_DIR/.env <<ENVFILE
APP_NAME="The Missing Sock Photography"
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=https://${DOMAIN}

LOG_CHANNEL=stack
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=${DB_NAME}
DB_USERNAME=${DB_USER}
DB_PASSWORD=${DB_PASSWORD}

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=database
SESSION_DRIVER=database
SESSION_LIFETIME=120

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="noreply@${DOMAIN}"
MAIL_FROM_NAME="${APP_NAME}"

STRIPE_KEY=
STRIPE_SECRET=
STRIPE_WEBHOOK_SECRET=
ENVFILE
    fi
fi

# Generate application key
cd $APP_DIR
php artisan key:generate --force

# Step 10: Set permissions
echo -e "${YELLOW}[10/10] Setting permissions...${NC}"
chown -R $APP_USER:$APP_USER $APP_DIR
chmod -R 755 $APP_DIR
chmod -R 775 $APP_DIR/storage
chmod -R 775 $APP_DIR/bootstrap/cache

# Step 11: Run migrations
echo -e "${YELLOW}[11/12] Running database migrations...${NC}"
cd $APP_DIR
php artisan migrate --force

# Step 12: Configure Nginx
echo -e "${YELLOW}[12/12] Configuring Nginx...${NC}"
cat > /etc/nginx/sites-available/$DOMAIN <<NGINXCONF
server {
    listen 80;
    listen [::]:80;
    server_name ${DOMAIN};
    root ${APP_DIR}/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files \$uri \$uri/ /index.php?\$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME \$realpath_root\$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
NGINXCONF

# Enable site
ln -sf /etc/nginx/sites-available/$DOMAIN /etc/nginx/sites-enabled/
rm -f /etc/nginx/sites-enabled/default

# Test Nginx configuration
nginx -t

# Reload Nginx
systemctl reload nginx

# Step 13: Set up SSL certificate
echo -e "${YELLOW}[13/13] Setting up SSL certificate...${NC}"
read -p "Do you want to set up SSL certificate with Let's Encrypt? (y/n): " SETUP_SSL
if [ "$SETUP_SSL" = "y" ]; then
    certbot --nginx -d $DOMAIN --non-interactive --agree-tos --email contact@schoedel.design
    systemctl reload nginx
fi

# Step 14: Set up queue worker with Supervisor
echo -e "${YELLOW}[14/14] Setting up queue worker...${NC}"
apt install -y supervisor

cat > /etc/supervisor/conf.d/missing-sock-worker.conf <<SUPERVISORCONF
[program:missing-sock-worker]
process_name=%(program_name)s_%(process_num)02d
command=php ${APP_DIR}/artisan queue:work database --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=${APP_USER}
numprocs=2
redirect_stderr=true
stdout_logfile=${APP_DIR}/storage/logs/worker.log
stopwaitsecs=3600
SUPERVISORCONF

supervisorctl reread
supervisorctl update
supervisorctl start missing-sock-worker:*

# Step 15: Set up cron job
echo -e "${YELLOW}[15/15] Setting up cron job...${NC}"
(crontab -u $APP_USER -l 2>/dev/null; echo "* * * * * cd ${APP_DIR} && php artisan schedule:run >> /dev/null 2>&1") | crontab -u $APP_USER -

# Optimize Laravel
echo -e "${YELLOW}Optimizing Laravel...${NC}"
cd $APP_DIR
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

echo ""
echo -e "${GREEN}========================================${NC}"
echo -e "${GREEN}Installation Complete!${NC}"
echo -e "${GREEN}========================================${NC}"
echo ""
echo -e "Application URL: ${BLUE}https://${DOMAIN}${NC}"
echo -e "Admin Panel: ${BLUE}https://${DOMAIN}/admin${NC}"
echo ""
echo -e "${YELLOW}Next Steps:${NC}"
echo "1. Update .env file with your Stripe keys and mail settings"
echo "2. Create an admin user: php artisan make:filament-user"
echo "3. Test the application at https://${DOMAIN}"
echo ""
echo -e "${YELLOW}Useful Commands:${NC}"
echo "  View logs: tail -f ${APP_DIR}/storage/logs/laravel.log"
echo "  Restart queue: supervisorctl restart missing-sock-worker:*"
echo "  Clear cache: php artisan cache:clear"
echo ""

