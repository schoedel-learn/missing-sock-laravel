# Queue Configuration Guide

## Overview

This application uses Laravel queues for asynchronous processing of:
- **Email sending** - Non-blocking email delivery
- **Photo processing** - EXIF extraction and thumbnail generation
- **ZIP generation** - Large archive creation for batch downloads

## Quick Setup

### 1. Choose Queue Driver

Edit your `.env` file:

```env
# For Development (synchronous, no worker needed)
QUEUE_CONNECTION=sync

# For Production (database-backed, requires worker)
QUEUE_CONNECTION=database

# For High-Traffic Production (Redis-backed, requires Redis + worker)
QUEUE_CONNECTION=redis
```

### 2. Run Migrations

The jobs table migration already exists. Ensure it's applied:

```bash
php artisan migrate
```

### 3. Configure Queue Settings (Optional)

```env
# Database Queue Settings
DB_QUEUE_TABLE=jobs
DB_QUEUE=default
DB_QUEUE_RETRY_AFTER=90

# Redis Queue Settings (if using Redis)
REDIS_QUEUE_CONNECTION=default
REDIS_QUEUE=default
REDIS_QUEUE_RETRY_AFTER=90
```

## Queue Workers

### Development

For local development with database queue:

```bash
# Run queue worker in foreground
php artisan queue:work --queue=emails,photos,downloads,default

# Or run specific queue
php artisan queue:work --queue=emails --tries=3
```

### Production

#### Option A: Supervisor (Recommended)

Create `/etc/supervisor/conf.d/missing-sock-worker.conf`:

```ini
[program:missing-sock-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /path/to/missing-sock-laravel/artisan queue:work database --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=4
redirect_stderr=true
stdout_logfile=/path/to/missing-sock-laravel/storage/logs/worker.log
stopwaitsecs=3600
```

Then:
```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start missing-sock-worker:*
```

#### Option B: Laravel Horizon (For Redis)

Install Horizon:
```bash
composer require laravel/horizon
php artisan horizon:install
```

Update `config/horizon.php` with your queue configuration.

Start Horizon:
```bash
php artisan horizon
```

### Composer Dev Script

The project includes a convenient dev script that runs everything:

```bash
composer run dev
```

This starts:
- PHP artisan serve (web server)
- Queue worker
- Log viewer (Pail)
- Vite dev server

## Queue Priorities

Jobs are distributed across queues by priority:

1. **emails** - High priority, quick execution
2. **photos** - Medium priority, moderate execution time
3. **downloads** - Lower priority, long execution time
4. **default** - Catch-all for other jobs

### Running with Priorities

```bash
# Process emails first, then others
php artisan queue:work --queue=emails,photos,downloads,default
```

## Job Configuration

### Email Jobs (SendEmailJob)

```php
// app/Jobs/SendEmailJob.php
public $tries = 3;
public $timeout = 60; // seconds
public $queue = 'emails';
```

- **Retries:** 3 attempts
- **Timeout:** 60 seconds
- **Queue:** emails

### Photo Processing Jobs (ProcessPhotoUpload)

```php
// app/Jobs/ProcessPhotoUpload.php
public $tries = 3;
public $timeout = 300; // 5 minutes
public $queue = 'photos';
```

- **Retries:** 3 attempts
- **Timeout:** 5 minutes (for large images)
- **Queue:** photos

### Download Archive Jobs (GenerateDownloadArchive)

```php
// app/Jobs/GenerateDownloadArchive.php
public $tries = 2;
public $timeout = 600; // 10 minutes
public $queue = 'downloads';
```

- **Retries:** 2 attempts
- **Timeout:** 10 minutes (for large ZIP files)
- **Queue:** downloads

## Usage in Code

### Dispatching Email Jobs

```php
use App\Jobs\SendEmailJob;
use App\Services\EmailService;

// Option 1: Via EmailService (automatic queuing)
$emailService = app(EmailService::class);
$emailService->send(new OrderConfirmationMail($order), $customer->email);

// Option 2: Direct dispatch
SendEmailJob::dispatch(new OrderConfirmationMail($order), $customer->email);

// Option 3: Synchronous (bypass queue)
$emailService->send(new OrderConfirmationMail($order), $customer->email, queue: false);
```

### Dispatching Photo Processing Jobs

```php
use App\Jobs\ProcessPhotoUpload;

// After photo upload
$photo = Photo::create([...]);
ProcessPhotoUpload::dispatch($photo->id);

// With options
ProcessPhotoUpload::dispatch($photo->id, [
    'regenerate_thumbnails' => true,
]);
```

### Dispatching Download Archive Jobs

```php
use App\Jobs\GenerateDownloadArchive;
use App\Services\DownloadService;

// Option 1: Via DownloadService (automatic queuing)
$downloadService = app(DownloadService::class);
$download = $downloadService->generateBatchDownloadLink($order);

// Option 2: Direct dispatch
$download = Download::create([...]);
GenerateDownloadArchive::dispatch($download->id);
```

## Monitoring

### Check Queue Status

```bash
# See queued jobs
php artisan queue:monitor

# See failed jobs
php artisan queue:failed

# Retry failed jobs
php artisan queue:retry all

# Clear failed jobs
php artisan queue:flush
```

### View Logs

```bash
# Live tail logs
php artisan pail

# Or tail Laravel logs
tail -f storage/logs/laravel.log
```

## Failed Jobs

### Retry Strategy

Failed jobs are automatically retried based on `$tries` property:
- Emails: 3 attempts
- Photos: 3 attempts
- Downloads: 2 attempts

### Manual Retry

```bash
# Retry specific failed job
php artisan queue:retry <job-id>

# Retry all failed jobs
php artisan queue:retry all

# Retry failed jobs for specific queue
php artisan queue:retry --queue=emails
```

## Performance Tuning

### Multiple Workers

Run multiple queue workers for better throughput:

```bash
# Terminal 1 - Email worker
php artisan queue:work --queue=emails --tries=3

# Terminal 2 - Photo worker
php artisan queue:work --queue=photos --tries=3

# Terminal 3 - Download worker
php artisan queue:work --queue=downloads --tries=2
```

### Worker Options

```bash
# Run worker with memory limit
php artisan queue:work --memory=512

# Run worker with time limit
php artisan queue:work --max-time=3600

# Run specific number of jobs then stop
php artisan queue:work --max-jobs=100

# Delay between jobs (seconds)
php artisan queue:work --sleep=3
```

## Environment-Specific Configuration

### Development (.env)

```env
QUEUE_CONNECTION=sync  # No worker needed, immediate execution
LOG_CHANNEL=stack
```

### Staging (.env)

```env
QUEUE_CONNECTION=database
LOG_CHANNEL=stack
```

### Production (.env)

```env
QUEUE_CONNECTION=redis  # Or database
LOG_CHANNEL=daily
LOG_LEVEL=error
```

## Troubleshooting

### Jobs Not Processing

1. **Check queue worker is running:**
   ```bash
   ps aux | grep 'artisan queue:work'
   ```

2. **Check queue connection:**
   ```bash
   php artisan queue:monitor
   ```

3. **Check failed jobs:**
   ```bash
   php artisan queue:failed
   ```

### Memory Issues

```bash
# Increase memory limit
php artisan queue:work --memory=512

# Or in php.ini
memory_limit = 512M
```

### Timeout Issues

Increase job timeout in job class:
```php
public $timeout = 600; // 10 minutes
```

Or worker timeout:
```bash
php artisan queue:work --timeout=600
```

## Security Considerations

1. **Queue access** - Ensure queue tables/Redis are not publicly accessible
2. **Job data** - Avoid storing sensitive data in job payloads
3. **Rate limiting** - Consider rate limiting job dispatch for external APIs
4. **Resource limits** - Set appropriate memory and timeout limits

## Related Documentation

- [Laravel Queue Documentation](https://laravel.com/docs/queues)
- [Setup Guide](./SETUP_GUIDE.md)
- [Mail Provider Setup](./MAIL_PROVIDER_SETUP.md)

---

**Last Updated:** November 2, 2025

