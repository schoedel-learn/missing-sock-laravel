#!/bin/bash
# Setup script for Coolify deployment on VPS
# Run this via SSH to prepare your server for Coolify deployment

set -e

echo "🚀 Setting up server for Coolify deployment..."

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Check if running as root or with sudo
if [ "$EUID" -ne 0 ]; then 
    echo -e "${RED}Please run as root or with sudo${NC}"
    exit 1
fi

echo -e "${BLUE}========================================${NC}"
echo -e "${BLUE}Coolify Deployment Setup${NC}"
echo -e "${BLUE}========================================${NC}"
echo ""

# Step 1: Check if Coolify is installed
echo -e "${YELLOW}Step 1: Checking Coolify installation...${NC}"
if command -v coolify &> /dev/null || docker ps | grep -q coolify; then
    echo -e "${GREEN}✓ Coolify appears to be installed${NC}"
else
    echo -e "${YELLOW}⚠ Coolify not detected. Checking Docker...${NC}"
    if command -v docker &> /dev/null; then
        echo -e "${GREEN}✓ Docker is installed${NC}"
        echo -e "${YELLOW}You may need to install Coolify. Visit: https://coolify.io/docs${NC}"
    else
        echo -e "${RED}✗ Docker is not installed. Please install Docker first.${NC}"
        exit 1
    fi
fi

# Step 2: Check Docker and Docker Compose
echo ""
echo -e "${YELLOW}Step 2: Checking Docker setup...${NC}"
if command -v docker &> /dev/null; then
    DOCKER_VERSION=$(docker --version)
    echo -e "${GREEN}✓ Docker: $DOCKER_VERSION${NC}"
else
    echo -e "${RED}✗ Docker is not installed${NC}"
    exit 1
fi

if command -v docker-compose &> /dev/null || docker compose version &> /dev/null; then
    echo -e "${GREEN}✓ Docker Compose is available${NC}"
else
    echo -e "${YELLOW}⚠ Docker Compose not found, but may not be required${NC}"
fi

# Step 3: Check if ports are available
echo ""
echo -e "${YELLOW}Step 3: Checking port availability...${NC}"
if netstat -tuln | grep -q ':8000 '; then
    echo -e "${GREEN}✓ Port 8000 is in use (likely Coolify)${NC}"
else
    echo -e "${YELLOW}⚠ Port 8000 is not in use${NC}"
fi

if netstat -tuln | grep -q ':80 '; then
    echo -e "${YELLOW}⚠ Port 80 is in use${NC}"
fi

if netstat -tuln | grep -q ':443 '; then
    echo -e "${YELLOW}⚠ Port 443 is in use${NC}"
fi

# Step 4: Check DNS configuration
echo ""
echo -e "${YELLOW}Step 4: Checking DNS configuration...${NC}"
DOMAIN="tms.opshub.photos"
echo "Checking DNS for: $DOMAIN"
DNS_RESULT=$(dig +short $DOMAIN || echo "")
if [ -z "$DNS_RESULT" ]; then
    echo -e "${YELLOW}⚠ DNS not resolving for $DOMAIN${NC}"
    echo -e "${YELLOW}  Make sure your DNS A record points to this server's IP${NC}"
else
    echo -e "${GREEN}✓ DNS resolves to: $DNS_RESULT${NC}"
fi

# Step 5: Display Coolify access information
echo ""
echo -e "${BLUE}========================================${NC}"
echo -e "${BLUE}Next Steps:${NC}"
echo -e "${BLUE}========================================${NC}"
echo ""
echo -e "${GREEN}1. Access Coolify Dashboard:${NC}"
echo -e "   http://31.97.65.164:8000"
echo ""
echo -e "${GREEN}2. Create New Application:${NC}"
echo -e "   - Go to your project/environment"
echo -e "   - Click 'New Application'"
echo -e "   - Select 'Git Repository' as source"
echo ""
echo -e "${GREEN}3. Configure Application:${NC}"
echo -e "   Repository URL: Your Git repository URL"
echo -e "   Branch: main"
echo -e "   Build Pack: Dockerfile"
echo ""
echo -e "${GREEN}4. Build Settings:${NC}"
echo -e "   Build Command: composer install --optimize-autoloader --no-dev --no-interaction && npm install && npm run build"
echo -e "   Start Command: php-fpm"
echo -e "   Port: 9000 (for PHP-FPM)"
echo ""
echo -e "${GREEN}5. Environment Variables:${NC}"
echo -e "   See COOLIFY_QUICK_START.md for required variables"
echo ""
echo -e "${GREEN}6. Domain Configuration:${NC}"
echo -e "   Domain: $DOMAIN"
echo -e "   Enable SSL: Yes (Let's Encrypt)"
echo ""
echo -e "${BLUE}========================================${NC}"
echo -e "${GREEN}Setup check complete!${NC}"
echo -e "${BLUE}========================================${NC}"

