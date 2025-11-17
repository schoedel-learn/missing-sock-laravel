#!/bin/bash

################################################################################
# Hostinger VPS Installation Script
# The Missing Sock Photography - Laravel Application
#
# This script automates the installation of the Laravel application on a
# Hostinger VPS running Ubuntu 20.04/22.04
#
# Usage: sudo bash hostinger-install.sh
################################################################################

set -e  # Exit on error

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Functions
print_success() {
    echo -e "${GREEN}✓ $1${NC}"
}

print_error() {
    echo -e "${RED}✗ $1${NC}"
}

print_info() {
    echo -e "${BLUE}ℹ $1${NC}"
}

print_warning() {
    echo -e "${YELLOW}⚠ $1${NC}"
}

print_header() {
    echo ""
    echo -e "${BLUE}================================================${NC}"
    echo -e "${BLUE}$1${NC}"
    echo -e "${BLUE}================================================${NC}"
    echo ""
}

# Check if running as root
if [ "$EUID" -ne 0 ]; then 
    print_error "Please run as root (use sudo)"
    exit 1
fi

print_header "Hostinger VPS Installation Script"
print_info "The Missing Sock Photography - Laravel Application"
echo ""

# Get user input
read -p "Enter your domain name (e.g., yourdomain.com): " DOMAIN_NAME
read -p "Enter your email address (for SSL certificate): " EMAIL_ADDRESS
read -p "Enter your application directory [/var/www/missing-sock-laravel]: " APP_DIR
APP_DIR=${APP_DIR:-/var/www/missing-sock-laravel}

read -p "Enter database name [missing_sock_production]: " DB_NAME
DB_NAME=${DB_NAME:-missing_sock_production}

read -p "Enter database username [missing_sock_user]: " DB_USER
DB_USER=${DB_USER:-missing_sock_user}

print_info "Generating secure database password..."
DB_PASSWORD=$(openssl rand -base64 32)

echo ""
print_warning "Please save these credentials:"
echo "Database Name: $DB_NAME"
echo "Database User: $DB_USER"
echo "Database Password: $DB_PASSWORD"
echo ""
read -p "Press Enter to continue..."

# Step 1: Update system
print_header "Step 1: Updating System Packages"
apt update -y
apt upgrade -y
print_success "System updated"

# Step 2: Install essential tools
print_header "Step 2: Installing Essential Tools"
apt install -y curl wget git unzip software-properties-common ufw supervisor
print_success "Essential tools installed"

# Step 3: Install PHP 8.2
print_header "Step 3: Installing PHP 8.2"
add-apt-repository ppa:ondrej/php -y
apt update -y
apt install -y php8.2-fpm php8.2-cli php8.2-mysql php8.2-xml \
    php8.2-mbstring php8.2-curl php8.2-zip php8.2-gd php8.2-bcmath \
    php8.2-intl php8.2-soap php8.2-redis php8.2-sqlite3

php -v
print_success "PHP 8.2 installed"

# Step 4: Install Composer
print_header "Step 4: Installing Composer"
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer
chmod +x /usr/local/bin/composer
composer --version
print_success "Composer installed"

# Step 5: Install Node.js
print_header "Step 5: Installing Node.js 20.x"
curl -fsSL https://deb.nodesource.com/setup_20.x | bash -
apt install -y nodejs
node -v
npm -v
print_success "Node.js installed"

# Step 6: Install MySQL
print_header "Step 6: Installing MySQL"
apt install -y mysql-server
systemctl start mysql
systemctl enable mysql
print_success "MySQL installed"

# Step 7: Create database and user
print_header "Step 7: Creating Database and User"
mysql -e "CREATE DATABASE IF NOT EXISTS $DB_NAME CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
mysql -e "CREATE USER IF NOT EXISTS '$DB_USER'@'localhost' IDENTIFIED BY '$DB_PASSWORD';"
mysql -e "GRANT ALL PRIVILEGES ON $DB_NAME.* TO '$DB_USER'@'localhost';"
mysql -e "FLUSH PRIVILEGES;"
print_success "Database created: $DB_NAME"
print_success "User created: $DB_USER"

# Step 8: Install Nginx
print_header "Step 8: Installing Nginx"
apt install -y nginx
systemctl start nginx
systemctl enable nginx
print_success "Nginx installed"

# Step 9: Setup firewall
print_header "Step 9: Configuring Firewall"
ufw --force enable
ufw allow ssh
ufw allow 22/tcp
ufw allow 'Nginx Full'
ufw allow 80/tcp
ufw allow 443/tcp
ufw status
print_success "Firewall configured"

# Step 10: Create application directory
print_header "Step 10: Creating Application Directory"
mkdir -p $APP_DIR
print_success "Directory created: $APP_DIR"

# Step 11: Clone repository (if provided)
read -p "Do you want to clone from Git repository? (y/n): " CLONE_REPO
if [ "$CLONE_REPO" = "y" ]; then
    read -p "Enter Git repository URL: " GIT_REPO
    print_info "Cloning repository..."
    git clone $GIT_REPO $APP_DIR
    print_success "Repository cloned"
else
    print_warning "Skipping git clone. Please upload your files to $APP_DIR manually."
fi

# Step 12: Install Certbot for SSL
print_header "Step 11: Installing Certbot"
apt install -y certbot python3-certbot-nginx
print_success "Certbot installed"

# Step 13: Create Nginx configuration
print_header "Step 12: Creating Nginx Configuration"
cat > /etc/nginx/sites-available/missing-sock-laravel << EOF
server {
    listen 80;
    listen [::]:80;
    server_name $DOMAIN_NAME www.$DOMAIN_NAME;

    root $APP_DIR/public;
    index index.php index.html;

    access_log /var/log/nginx/missing-sock-laravel.access.log;
    error_log /var/log/nginx/missing-sock-laravel.error.log;

    gzip on;
    gzip_vary on;
    gzip_proxied any;
    gzip_comp_level 6;
    gzip_types text/plain text/css text/xml text/javascript 
               application/json application/javascript application/xml+rss 
               application/rss+xml font/truetype font/opentype 
               application/vnd.ms-fontobject image/svg+xml;

    location / {
        try_files \$uri \$uri/ /index.php?\$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME \$realpath_root\$fastcgi_script_name;
        include fastcgi_params;
        fastcgi_hide_header X-Powered-By;
        fastcgi_buffer_size 128k;
        fastcgi_buffers 4 256k;
        fastcgi_busy_buffers_size 256k;
    }

    location ~ /\. {
        deny all;
    }

    location ~* \.(jpg|jpeg|png|gif|ico|css|js|woff|woff2|ttf|svg|webp)$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
    }

    add_header X-Frame-Options "SAMEORIGIN" always;
    add_header X-Content-Type-Options "nosniff" always;
    add_header X-XSS-Protection "1; mode=block" always;
    add_header Referrer-Policy "no-referrer-when-downgrade" always;
}
EOF

ln -sf /etc/nginx/sites-available/missing-sock-laravel /etc/nginx/sites-enabled/
rm -f /etc/nginx/sites-enabled/default
nginx -t
systemctl reload nginx
print_success "Nginx configured"

# Step 14: Setup application (if files exist)
if [ -f "$APP_DIR/composer.json" ]; then
    print_header "Step 13: Setting Up Application"
    
    cd $APP_DIR
    
    # Set permissions
    chown -R www-data:www-data .
    find . -type d -exec chmod 755 {} \;
    find . -type f -exec chmod 644 {} \;
    chmod -R 775 storage bootstrap/cache
    chmod +x artisan
    
    # Create .env file
    if [ ! -f ".env" ]; then
        cp .env.example .env
        chmod 600 .env
        
        # Update .env file
        sed -i "s|APP_ENV=.*|APP_ENV=production|g" .env
        sed -i "s|APP_DEBUG=.*|APP_DEBUG=false|g" .env
        sed -i "s|APP_URL=.*|APP_URL=https://$DOMAIN_NAME|g" .env
        sed -i "s|DB_CONNECTION=.*|DB_CONNECTION=mysql|g" .env
        sed -i "s|DB_DATABASE=.*|DB_DATABASE=$DB_NAME|g" .env
        sed -i "s|DB_USERNAME=.*|DB_USERNAME=$DB_USER|g" .env
        sed -i "s|DB_PASSWORD=.*|DB_PASSWORD=$DB_PASSWORD|g" .env
        
        print_success ".env file created and configured"
    fi
    
    # Install dependencies
    print_info "Installing Composer dependencies (this may take a while)..."
    sudo -u www-data composer install --optimize-autoloader --no-dev
    
    # Generate app key
    php artisan key:generate --force
    
    # Install NPM dependencies and build
    print_info "Installing NPM dependencies and building assets..."
    npm install
    npm run build
    
    # Run migrations
    print_info "Running database migrations..."
    php artisan migrate --force
    
    # Optimize
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
    php artisan event:cache
    
    print_success "Application setup complete"
else
    print_warning "Application files not found. Please upload your files to $APP_DIR and run setup manually."
fi

# Step 15: Setup queue workers
print_header "Step 14: Configuring Queue Workers"
cat > /etc/supervisor/conf.d/missing-sock-worker.conf << EOF
[program:missing-sock-worker]
process_name=%(program_name)s_%(process_num)02d
command=php $APP_DIR/artisan queue:work database --sleep=3 --tries=3 --max-time=3600 --queue=emails,photos,downloads,default
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=$APP_DIR/storage/logs/worker.log
stopwaitsecs=3600
EOF

supervisorctl reread
supervisorctl update
supervisorctl start missing-sock-worker:*
print_success "Queue workers configured"

# Step 16: Setup cron
print_header "Step 15: Configuring Cron Jobs"
CRON_CMD="* * * * * cd $APP_DIR && php artisan schedule:run >> /dev/null 2>&1"
(crontab -u www-data -l 2>/dev/null; echo "$CRON_CMD") | crontab -u www-data -
print_success "Cron job configured"

# Step 17: Get SSL certificate
print_header "Step 16: Obtaining SSL Certificate"
print_info "This will obtain a free SSL certificate from Let's Encrypt"
read -p "Do you want to obtain SSL certificate now? (y/n): " GET_SSL

if [ "$GET_SSL" = "y" ]; then
    certbot --nginx -d $DOMAIN_NAME -d www.$DOMAIN_NAME --non-interactive --agree-tos --email $EMAIL_ADDRESS --redirect
    print_success "SSL certificate obtained"
else
    print_warning "SSL certificate not obtained. Run manually: sudo certbot --nginx -d $DOMAIN_NAME"
fi

# Final output
print_header "Installation Complete!"
echo ""
print_success "Your Laravel application has been installed on Hostinger VPS!"
echo ""
echo -e "${BLUE}Important Information:${NC}"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "Application Directory: $APP_DIR"
echo "Domain: https://$DOMAIN_NAME"
echo ""
echo "Database Credentials:"
echo "  Database: $DB_NAME"
echo "  Username: $DB_USER"
echo "  Password: $DB_PASSWORD"
echo ""
echo "Important URLs:"
echo "  Homepage: https://$DOMAIN_NAME"
echo "  Admin Panel: https://$DOMAIN_NAME/admin"
echo "  Pre-Order Form: https://$DOMAIN_NAME/pre-order/start"
echo ""
echo -e "${YELLOW}Next Steps:${NC}"
echo "1. Create admin user: cd $APP_DIR && php artisan make:filament-user"
echo "2. Configure mail settings in .env file"
echo "3. Configure Stripe settings in .env file"
echo "4. Test your application: https://$DOMAIN_NAME"
echo ""
echo -e "${YELLOW}Useful Commands:${NC}"
echo "View logs: tail -f $APP_DIR/storage/logs/laravel.log"
echo "Queue status: sudo supervisorctl status"
echo "Restart workers: sudo supervisorctl restart missing-sock-worker:*"
echo ""
echo -e "${GREEN}Installation script completed successfully!${NC}"
echo ""
