#!/bin/bash
# Master Installation Script - Run this to install on server
# This script will guide you through the installation process

set -e

SERVER_IP="31.97.65.164"
SERVER_DOMAIN="srv949418.hstgr.cloud"
SSH_HOST="missing-sock-server"

echo "🚀 Missing Sock Laravel - Server Installation"
echo "=============================================="
echo ""
echo "This script will help you install the application on:"
echo "  Domain: $SERVER_DOMAIN"
echo "  IP: $SERVER_IP"
echo ""

# Check if SSH config exists
if [ ! -f ~/.ssh/config ] || ! grep -q "Host $SSH_HOST" ~/.ssh/config; then
    echo "📝 Setting up SSH configuration..."
    ./ssh-setup.sh
    echo ""
fi

# Check if we can connect
echo "🔐 Testing SSH connection..."
if ssh -o ConnectTimeout=5 -o BatchMode=yes root@$SERVER_IP "echo 'Connected'" 2>/dev/null; then
    echo "✅ SSH connection successful!"
    echo ""
    
    echo "📤 Uploading installation script..."
    scp install-server.sh root@$SERVER_IP:/tmp/
    
    echo "🚀 Running installation on server..."
    echo "   (This may take 10-15 minutes)"
    echo ""
    
    ssh root@$SERVER_IP "chmod +x /tmp/install-server.sh && /tmp/install-server.sh"
    
    echo ""
    echo "✅ Installation complete!"
    echo ""
    echo "🌐 Your application should be available at:"
    echo "   https://$SERVER_DOMAIN"
    echo ""
    
else
    echo "❌ Cannot connect to server automatically."
    echo ""
    echo "You'll need to manually connect and run the installation."
    echo ""
    echo "📋 Manual Installation Steps:"
    echo ""
    echo "1. Connect to your server:"
    echo "   ssh root@$SERVER_IP"
    echo ""
    echo "2. Upload the installation script (from another terminal):"
    echo "   scp install-server.sh root@$SERVER_IP:/tmp/"
    echo ""
    echo "3. On the server, run:"
    echo "   chmod +x /tmp/install-server.sh"
    echo "   /tmp/install-server.sh"
    echo ""
    echo "Or, if you prefer, you can copy-paste the installation script"
    echo "contents directly into the server terminal."
    echo ""
    echo "📝 Installation script location:"
    echo "   $(pwd)/install-server.sh"
    echo ""
    
    read -p "Would you like to display the installation script for copy-paste? (y/n): " SHOW_SCRIPT
    if [ "$SHOW_SCRIPT" = "y" ]; then
        echo ""
        echo "=========================================="
        echo "Installation Script Contents:"
        echo "=========================================="
        cat install-server.sh
    fi
fi

