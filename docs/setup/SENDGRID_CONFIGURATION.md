# SendGrid Transactional Email Configuration

## Overview

This application uses a **dedicated SendGrid server** for transactional emails. The SendGrid implementation has been optimized for transactional email delivery with proper tracking, categorization, and list management settings.

## Configuration

### Environment Variables

Add these to your `.env` file:

```env
# Set SendGrid as the mail provider
MAIL_CUSTOM_PROVIDER=sendgrid

# SendGrid API Key (from your dedicated transactional server)
SENDGRID_API_KEY=your_sendgrid_api_key_here

# Optional: Transactional template ID (if using SendGrid templates)
SENDGRID_TEMPLATE_ID=your_template_id_here

# Optional: Mail category for analytics (default: 'transactional')
SENDGRID_MAIL_CATEGORY=transactional

# Optional: Tracking settings (default: true)
SENDGRID_CLICK_TRACKING=true
SENDGRID_OPEN_TRACKING=true

# Important: Bypass list management for transactional emails (default: true)
SENDGRID_BYPASS_LIST_MANAGEMENT=true
```

## Features Enabled

### ✅ Transactional Email Optimizations

1. **Bypass List Management** - Enabled by default
   - Ensures transactional emails bypass unsubscribe lists
   - Critical for order confirmations, password resets, etc.
   - Recipients receive emails even if they've unsubscribed from marketing

2. **Click Tracking** - Enabled by default
   - Tracks link clicks in emails
   - Useful for order confirmation links, account links, etc.

3. **Open Tracking** - Enabled by default
   - Tracks email opens
   - Helps measure engagement

4. **Mail Categories** - Set to 'transactional'
   - Categorizes emails for analytics
   - Helps distinguish transactional from marketing emails in SendGrid dashboard

5. **Template Support** - Optional
   - Can use SendGrid transactional templates
   - Set `SENDGRID_TEMPLATE_ID` to use

## Usage

The SendGrid service is automatically used when `MAIL_CUSTOM_PROVIDER=sendgrid` is set in your `.env` file.

```php
use App\Services\EmailService;
use App\Notifications\OrderConfirmation;

$emailService = app(EmailService::class);
$emailService->send(new OrderConfirmation($order), $customerEmail);
```

## Transactional Email Best Practices

1. **Always provide recipient** - Transactional emails should always have explicit recipients
2. **Use appropriate categories** - Helps with analytics and filtering
3. **Keep content focused** - Transactional emails should be concise and action-oriented
4. **Monitor delivery** - Check SendGrid dashboard for delivery rates
5. **Handle bounces** - Set up webhooks for bounce handling (future enhancement)

## SendGrid Dashboard

Monitor your transactional emails in the SendGrid dashboard:
- **Activity Feed** - See all sent emails
- **Statistics** - View delivery rates, opens, clicks
- **Categories** - Filter by 'transactional' category
- **Suppressions** - Manage bounces and spam reports

## Notes

- The dedicated SendGrid server ensures reliable delivery for transactional emails
- Transactional emails bypass marketing unsubscribe lists (bypass_list_management: true)
- All emails are categorized as 'transactional' for easy filtering
- Template support available if using SendGrid's template system

---

**Last Updated:** November 1, 2025

