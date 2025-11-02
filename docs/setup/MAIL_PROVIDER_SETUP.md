# Mail Provider Configuration Guide

## Overview

This application uses a custom mail service abstraction layer that supports multiple providers: Laravel's built-in mail, SendGrid, and Mailgun.

## Quick Setup

### 1. Choose Your Provider

Edit your `.env` file and set:

```env
MAIL_CUSTOM_PROVIDER=laravel  # or 'sendgrid' or 'mailgun'
```

### 2. Configure Provider-Specific Settings

#### Option A: Laravel Mail (Default - Recommended for Development)

```env
MAIL_MAILER=log
MAIL_CUSTOM_PROVIDER=laravel
MAIL_FROM_ADDRESS="noreply@missingsockphotography.com"
MAIL_FROM_NAME="The Missing Sock Photography"
```

For production with Laravel Mail + SMTP:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@missingsockphotography.com"
MAIL_FROM_NAME="The Missing Sock Photography"
```

#### Option B: SendGrid (Recommended for Production)

```env
MAIL_CUSTOM_PROVIDER=sendgrid
SENDGRID_API_KEY=your_sendgrid_api_key_here
MAIL_FROM_ADDRESS="noreply@missingsockphotography.com"
MAIL_FROM_NAME="The Missing Sock Photography"

# Optional SendGrid Settings
SENDGRID_TEMPLATE_ID=          # Optional: Use SendGrid templates
SENDGRID_MAIL_CATEGORY=transactional
SENDGRID_CLICK_TRACKING=true
SENDGRID_OPEN_TRACKING=true
SENDGRID_BYPASS_LIST_MANAGEMENT=true  # Important for transactional emails
```

**Important Notes for SendGrid:**
- Use a dedicated SendGrid server for transactional emails
- `SENDGRID_BYPASS_LIST_MANAGEMENT=true` ensures order confirmations bypass unsubscribe lists
- Set up SPF and DKIM records in your DNS for better deliverability
- See `docs/setup/SENDGRID_CONFIGURATION.md` for detailed setup

#### Option C: Mailgun

```env
MAIL_CUSTOM_PROVIDER=mailgun
MAILGUN_SECRET=your_mailgun_secret_here
MAILGUN_DOMAIN=your_mailgun_domain_here
MAIL_FROM_ADDRESS="noreply@missingsockphotography.com"
MAIL_FROM_NAME="The Missing Sock Photography"
```

### 3. Cache Configuration

After updating `.env`, clear and cache config:

```bash
php artisan config:clear
php artisan config:cache
```

## Testing Your Mail Setup

### Test Email Sending

Create a test route (for development only):

```php
// routes/web.php (temporary test route)
Route::get('/test-email', function () {
    $user = \App\Models\User::first();
    
    try {
        \Illuminate\Support\Facades\Mail::raw(
            'This is a test email from Missing Sock Photography.',
            function ($message) use ($user) {
                $message->to($user->email)
                        ->subject('Test Email');
            }
        );
        
        return 'Email sent successfully!';
    } catch (\Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
});
```

Or use Artisan Tinker:

```bash
php artisan tinker
```

```php
use App\Services\EmailService;
use Illuminate\Support\Facades\Mail;

// Simple test
Mail::raw('Test email body', function($msg) {
    $msg->to('your-email@example.com')
        ->subject('Test from Missing Sock');
});
```

### Check Mail Logs

For `log` mailer, check:
```bash
tail -f storage/logs/laravel.log
```

## Environment Variables Reference

```env
# ===== MAIL CONFIGURATION =====

# Provider Selection (laravel, sendgrid, mailgun)
MAIL_CUSTOM_PROVIDER=laravel

# Default Mailer (log, smtp, sendmail, etc)
MAIL_MAILER=log

# From Address (Used by all providers)
MAIL_FROM_ADDRESS="noreply@missingsockphotography.com"
MAIL_FROM_NAME="The Missing Sock Photography"

# ===== SMTP Configuration (if using Laravel Mail with SMTP) =====
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=tls

# ===== SendGrid Configuration =====
SENDGRID_API_KEY=
SENDGRID_TEMPLATE_ID=
SENDGRID_MAIL_CATEGORY=transactional
SENDGRID_CLICK_TRACKING=true
SENDGRID_OPEN_TRACKING=true
SENDGRID_BYPASS_LIST_MANAGEMENT=true

# ===== Mailgun Configuration =====
MAILGUN_SECRET=
MAILGUN_DOMAIN=
```

## Provider Comparison

| Feature | Laravel Mail | SendGrid | Mailgun |
|---------|-------------|----------|---------|
| **Setup Complexity** | Simple | Moderate | Moderate |
| **Cost** | Free (your SMTP) | Paid | Paid |
| **Deliverability** | Depends on SMTP | Excellent | Excellent |
| **Analytics** | No | Yes | Yes |
| **Templates** | Blade | SendGrid | Mailgun |
| **Transactional Focus** | No | Yes | Yes |
| **Best For** | Development | Production | Production |

## Recommendations

### Development
```env
MAIL_MAILER=log
MAIL_CUSTOM_PROVIDER=laravel
```
All emails written to `storage/logs/laravel.log`

### Staging
```env
MAIL_MAILER=smtp
MAIL_CUSTOM_PROVIDER=laravel
# Use Mailtrap or similar
MAIL_HOST=smtp.mailtrap.io
```

### Production
```env
MAIL_CUSTOM_PROVIDER=sendgrid
SENDGRID_API_KEY=your_production_key
SENDGRID_BYPASS_LIST_MANAGEMENT=true
```

## Troubleshooting

### "Connection refused" Error
- Check SMTP host and port
- Verify firewall isn't blocking outbound connections
- Confirm credentials are correct

### Emails Not Arriving
- Check spam folder
- Verify `MAIL_FROM_ADDRESS` is authorized to send
- Check provider dashboard for delivery issues
- Ensure SPF/DKIM records are configured (SendGrid/Mailgun)

### SendGrid Specific Issues
- Verify API key has "Mail Send" permission
- Check if domain is verified in SendGrid
- Review SendGrid activity feed for errors

### Mailgun Specific Issues
- Confirm domain is verified
- Check if sending from sandbox domain (limited recipients)
- Verify webhook signatures if using events

## Security Best Practices

1. **Never commit API keys** - Always use environment variables
2. **Use separate keys** - Different keys for dev/staging/production
3. **Rotate keys regularly** - Especially if compromised
4. **Monitor usage** - Watch for unusual sending patterns
5. **Enable 2FA** - On provider accounts (SendGrid/Mailgun)

## Next Steps

After configuring mail:
1. Test sending with a simple email
2. Verify receipt in target inbox
3. Check provider dashboard for delivery status
4. Set up email templates for:
   - Order confirmations
   - Registration confirmations
   - Gallery ready notifications
   - Download link emails

## Related Documentation

- [SendGrid Configuration](./SENDGRID_CONFIGURATION.md) - Detailed SendGrid setup
- [SendGrid Quick Setup](./SENDGRID_QUICK_SETUP.md) - Quick SendGrid guide
- [Setup Guide](./SETUP_GUIDE.md) - Overall application setup

---

**Last Updated:** November 2, 2025

