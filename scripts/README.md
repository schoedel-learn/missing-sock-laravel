# Installation Scripts

Automated installation and deployment scripts for The Missing Sock Photography Laravel application.

---

## 📦 Available Scripts

### `hostinger-install.sh`

Automated installation script for deploying the application on a Hostinger VPS.

#### What It Does

This script automates the entire deployment process:

1. ✅ Updates system packages
2. ✅ Installs PHP 8.2 with all required extensions
3. ✅ Installs Composer (PHP dependency manager)
4. ✅ Installs Node.js 20.x and NPM
5. ✅ Installs and configures MySQL database
6. ✅ Installs and configures Nginx web server
7. ✅ Installs Supervisor for queue workers
8. ✅ Configures UFW firewall
9. ✅ Creates application directory
10. ✅ Clones repository (optional)
11. ✅ Installs SSL certificate with Let's Encrypt
12. ✅ Configures Nginx server block
13. ✅ Sets up application (dependencies, .env, migrations)
14. ✅ Configures queue workers with Supervisor
15. ✅ Sets up cron jobs for scheduled tasks
16. ✅ Obtains and installs SSL certificate

#### Prerequisites

- Hostinger VPS with Ubuntu 20.04/22.04 or CentOS 7/8
- Root or sudo access
- Domain name pointed to your VPS IP address
- Basic knowledge of Linux command line

#### Usage

**Option 1: Download and Run (Recommended)**

```bash
# SSH into your Hostinger VPS
ssh root@your-vps-ip-address

# Download the script (using wget)
cd /tmp
wget https://raw.githubusercontent.com/schoedel-learn/missing-sock-laravel/main/scripts/hostinger-install.sh

# OR download using curl (if wget not available)
curl -O https://raw.githubusercontent.com/schoedel-learn/missing-sock-laravel/main/scripts/hostinger-install.sh

# Make it executable
chmod +x hostinger-install.sh

# Run with sudo
sudo bash hostinger-install.sh
```

**Option 2: Clone Repository First**

```bash
# SSH into your Hostinger VPS
ssh root@your-vps-ip-address

# Clone the repository
cd /tmp
git clone https://github.com/schoedel-learn/missing-sock-laravel.git

# Run the script
cd missing-sock-laravel/scripts
sudo bash hostinger-install.sh
```

**Option 3: One-Line Installation**

```bash
# From your Hostinger VPS (after SSH)
curl -s https://raw.githubusercontent.com/schoedel-learn/missing-sock-laravel/main/scripts/hostinger-install.sh | sudo bash
```

#### Interactive Prompts

The script will ask you for the following information:

1. **Domain name** (e.g., `yourdomain.com`)
2. **Email address** (for SSL certificate notifications)
3. **Application directory** (default: `/var/www/missing-sock-laravel`)
4. **Database name** (default: `missing_sock_production`)
5. **Database username** (default: `missing_sock_user`)
6. **Clone from Git?** (y/n) - If yes, provide repository URL
7. **Obtain SSL certificate?** (y/n) - If yes, automatic SSL setup

The script will automatically generate a secure database password.

#### What You'll Get

After successful installation:

```
✓ Fully configured VPS with all requirements
✓ Laravel application installed and configured
✓ Database created and migrated
✓ Nginx web server with SSL certificate
✓ Queue workers running via Supervisor
✓ Cron jobs configured for scheduled tasks
✓ Firewall configured and enabled
✓ Application accessible via your domain
```

#### Output Information

At the end, the script provides:

- Application directory path
- Domain URL
- Database credentials (SAVE THESE!)
- Important URLs (homepage, admin panel, etc.)
- Next steps
- Useful commands

#### Next Steps After Installation

1. **Create Admin User:**
   ```bash
   cd /var/www/missing-sock-laravel
   php artisan make:filament-user
   ```

2. **Configure Mail Settings:**
   ```bash
   nano /var/www/missing-sock-laravel/.env
   # Update MAIL_* settings
   ```

3. **Configure Stripe Settings:**
   ```bash
   nano /var/www/missing-sock-laravel/.env
   # Update STRIPE_* settings
   ```

4. **Test Your Application:**
   - Visit: `https://yourdomain.com`
   - Admin: `https://yourdomain.com/admin`

#### Troubleshooting

If the script fails:

1. **Check the error message** - The script will display detailed error information
2. **Check system logs:**
   ```bash
   sudo journalctl -xe
   ```
3. **Verify prerequisites:**
   ```bash
   # Check Ubuntu version
   lsb_release -a
   
   # Check available disk space
   df -h
   
   # Check available memory
   free -h
   ```
4. **Re-run the script** - The script is idempotent and can be safely re-run
5. **Manual installation** - See [HOSTINGER_VPS_DEPLOYMENT.md](../docs/setup/HOSTINGER_VPS_DEPLOYMENT.md) for step-by-step manual installation

#### Script Features

- **Color-coded output** for easy reading
- **Error handling** - Exits on error
- **Idempotent** - Safe to run multiple times
- **Secure** - Generates strong passwords
- **Interactive** - Asks for necessary information
- **Informative** - Provides progress updates
- **Complete** - Handles entire installation process

#### Safety & Security

- Generates secure random database password (32 characters)
- Sets proper file permissions (755/775)
- Configures UFW firewall
- Enables HTTPS with Let's Encrypt SSL
- Secures .env file (600 permissions)
- Runs queue workers as www-data user

#### Estimated Installation Time

- **Fresh VPS:** 15-20 minutes
- **With existing software:** 10-15 minutes
- **SSL certificate:** +2-3 minutes
- **Repository clone & build:** +5-10 minutes

*Time may vary based on VPS specifications and internet speed.*

---

## 📚 Related Documentation

- **Complete Manual Guide:** [../docs/setup/HOSTINGER_VPS_DEPLOYMENT.md](../docs/setup/HOSTINGER_VPS_DEPLOYMENT.md)
- **Quick Reference:** [../docs/setup/HOSTINGER_QUICK_REFERENCE.md](../docs/setup/HOSTINGER_QUICK_REFERENCE.md)
- **General Deployment:** [../docs/setup/DEPLOYMENT.md](../docs/setup/DEPLOYMENT.md)
- **Troubleshooting:** [../docs/setup/TROUBLESHOOTING.md](../docs/setup/TROUBLESHOOTING.md)

---

## 🔧 Script Maintenance

### Updating the Script

If you need to modify the script:

1. Edit the script:
   ```bash
   nano scripts/hostinger-install.sh
   ```

2. Test in a development environment first

3. Commit changes:
   ```bash
   git add scripts/hostinger-install.sh
   git commit -m "Update installation script"
   git push
   ```

### Adding New Scripts

When adding new installation scripts:

1. Create the script in this directory
2. Make it executable: `chmod +x script-name.sh`
3. Add documentation to this README
4. Test thoroughly before committing

---

## ❓ FAQ

**Q: Can I run this script on a non-Hostinger VPS?**  
A: Yes! The script works on any Ubuntu 20.04/22.04 or CentOS 7/8 VPS.

**Q: Will this script overwrite my existing installation?**  
A: The script checks for existing installations and can be safely re-run. However, backup your data first.

**Q: What if I don't have a domain name yet?**  
A: You can use your VPS IP address initially and add the domain later.

**Q: Can I customize the installation?**  
A: Yes! Edit the script or use the manual installation guide for full control.

**Q: Is this script safe to use?**  
A: Yes! The script is open source, follows best practices, and includes security measures.

**Q: What if the script fails midway?**  
A: Review the error message, fix the issue, and re-run the script. It's designed to be re-runnable.

---

## 💡 Tips

1. **Save the database credentials** - They're only shown once during installation
2. **Take a VPS snapshot** - Before running the script (available in Hostinger hPanel)
3. **Point your domain first** - Configure DNS before running the script
4. **Use screen/tmux** - For long-running installations over SSH
5. **Test in staging** - Try on a development VPS first if possible

---

## 🆘 Getting Help

If you encounter issues:

1. Check the [troubleshooting guide](../docs/setup/HOSTINGER_VPS_DEPLOYMENT.md#-troubleshooting)
2. Review the [quick reference](../docs/setup/HOSTINGER_QUICK_REFERENCE.md)
3. Check application logs: `tail -f /var/www/missing-sock-laravel/storage/logs/laravel.log`
4. Check system logs: `sudo journalctl -xe`

---

**Last Updated:** November 2024  
**Script Version:** 1.0  
**Compatibility:** Ubuntu 20.04/22.04, CentOS 7/8
