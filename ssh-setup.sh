#!/bin/bash
# SSH Setup Script for Missing Sock Server
# This script helps configure SSH access to the server

set -e

SERVER_IP="31.97.65.164"
SERVER_DOMAIN="srv949418.hstgr.cloud"
SSH_KEY="ssh-ed25519 AAAAC3NzaC1lZDI1NTE5AAAAIGYS7EdrN2hR0pFA1Ndm5akMK7A/ZbzdzsZqC9f6aG7L contact@schoedel.design"
SSH_CONFIG_HOST="missing-sock-server"

echo "🔐 Setting up SSH access for Missing Sock server..."
echo ""

# Create .ssh directory if it doesn't exist
mkdir -p ~/.ssh
chmod 700 ~/.ssh

# Add server to SSH config
echo "📝 Adding server to SSH config..."

# Check if host already exists
if grep -q "Host $SSH_CONFIG_HOST" ~/.ssh/config 2>/dev/null; then
    echo "⚠️  Host $SSH_CONFIG_HOST already exists in SSH config"
    read -p "Do you want to update it? (y/n): " UPDATE_CONFIG
    if [ "$UPDATE_CONFIG" = "y" ]; then
        # Remove old entry
        sed -i.bak "/Host $SSH_CONFIG_HOST/,/^$/d" ~/.ssh/config
    else
        echo "Skipping SSH config update"
        exit 0
    fi
fi

# Add new SSH config entry
cat >> ~/.ssh/config <<EOF

Host $SSH_CONFIG_HOST
    HostName $SERVER_IP
    User root
    IdentitiesOnly yes
    # Add your private key path here if you have it
    # IdentityFile ~/.ssh/missing_sock_key
EOF

chmod 600 ~/.ssh/config

echo "✅ SSH config updated!"
echo ""
echo "📋 Server Information:"
echo "  Host: $SSH_CONFIG_HOST"
echo "  IP: $SERVER_IP"
echo "  Domain: $SERVER_DOMAIN"
echo ""
echo "🔑 SSH Public Key (for server setup):"
echo "$SSH_KEY"
echo ""
echo "📝 Next Steps:"
echo "1. Add the public key above to the server's authorized_keys:"
echo "   ssh-copy-id -i ~/.ssh/your_key.pub root@$SERVER_IP"
echo ""
echo "2. Or manually add it on the server:"
echo "   ssh root@$SERVER_IP"
echo "   echo '$SSH_KEY' >> ~/.ssh/authorized_keys"
echo ""
echo "3. Test connection:"
echo "   ssh $SSH_CONFIG_HOST"
echo ""
echo "4. Upload installation script:"
echo "   scp install-server.sh $SSH_CONFIG_HOST:/tmp/"
echo ""
echo "5. Run installation:"
echo "   ssh $SSH_CONFIG_HOST 'chmod +x /tmp/install-server.sh && /tmp/install-server.sh'"
echo ""

