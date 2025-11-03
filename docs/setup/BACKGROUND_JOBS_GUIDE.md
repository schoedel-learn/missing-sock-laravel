# Background Jobs Implementation Guide

## Overview

This application implements Laravel queues for asynchronous processing of heavy operations to improve user experience and application performance.

## Implemented Jobs

### 1. SendEmailJob

**Purpose:** Asynchronous email delivery  
**Queue:** `emails`  
**Timeout:** 60 seconds  
**Retries:** 3 attempts

**Usage:**
```php
use App\Jobs\SendEmailJob;

// Via EmailService (automatic queuing)
$emailService = app(EmailService::class);
$emailService->send(new OrderConfirmationMail($order), 'customer@example.com');

// Direct dispatch
SendEmailJob::dispatch(new OrderConfirmationMail($order), 'customer@example.com');

// Synchronous (bypass queue)
$emailService->send(new OrderConfirmationMail($order), 'customer@example.com', queue: false);
```

**Features:**
- Automatic retry on failure (3 attempts)
- Detailed logging of send attempts
- Failed job handling
- Non-blocking email delivery

---

### 2. ProcessPhotoUpload

**Purpose:** Photo processing, EXIF extraction, thumbnail generation  
**Queue:** `photos`  
**Timeout:** 5 minutes  
**Retries:** 3 attempts

**Usage:**
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

**What it does:**
- Extracts EXIF metadata (camera, ISO, date taken, etc.)
- Extracts image dimensions
- Stores file metadata
- Triggers Spatie Media Library thumbnail generation
- Updates processing timestamps

---

### 3. GenerateDownloadArchive

**Purpose:** Generate ZIP archives for batch photo downloads  
**Queue:** `downloads`  
**Timeout:** 10 minutes  
**Retries:** 2 attempts

**Usage:**
```php
use App\Jobs\GenerateDownloadArchive;
use App\Services\DownloadService;

// Via DownloadService (automatic queuing)
$downloadService = app(DownloadService::class);
$download = $downloadService->generateBatchDownloadLink($order);

// Direct dispatch
$download = Download::create([...]);
GenerateDownloadArchive::dispatch($download->id);
```

**What it does:**
- Collects photos for order
- Creates ZIP archive with organized filenames
- Updates download record with file path and size
- Marks download as 'ready' when complete
- Handles errors gracefully

---

## Queue Structure

### Queue Hierarchy

Jobs are processed in priority order:

```
1. emails     - Highest priority (quick)
2. photos     - Medium priority (moderate time)
3. downloads  - Lower priority (long running)
4. default    - Catch-all
```

### Queue Worker Command

```bash
# Process all queues in priority order
php artisan queue:work --queue=emails,photos,downloads,default --tries=3
```

## Service Integration

### EmailService

The `EmailService` automatically queues emails when queue driver is not `sync`:

```php
// In app/Services/EmailService.php
public function send(Mailable $mailable, ?string $to = null, bool $queue = true): bool
{
    if ($queue && config('queue.default') !== 'sync') {
        SendEmailJob::dispatch($mailable, $to);
        return true;
    }

    return $this->mailService->send($mailable, $to);
}
```

### DownloadService

The `DownloadService` queues ZIP generation for batch downloads:

```php
// In app/Services/DownloadService.php
public function generateBatchDownloadLink(Order $order, ?int $expirationDays = null, bool $queue = true): Download
{
    // ... create download record ...
    
    if ($queue && config('queue.default') !== 'sync') {
        GenerateDownloadArchive::dispatch($download->id);
    }
    
    return $download;
}
```

## Monitoring & Debugging

### View Queue Status

```bash
# Monitor queues in real-time
php artisan queue:monitor emails,photos,downloads

# List failed jobs
php artisan queue:failed

# View specific failed job
php artisan queue:failed <job-id>
```

### Logs

All jobs log their progress:

```bash
# Live log viewing
php artisan pail

# Filter by job type
php artisan pail --filter="Email sent"
php artisan pail --filter="Photo processing"
```

### Failed Job Handling

Each job has a `failed()` method that logs failure details:

```php
public function failed(\Throwable $exception): void
{
    Log::error('Email job failed after all retries', [
        'recipient' => $this->recipient,
        'mailable' => get_class($this->mailable),
        'error' => $exception->getMessage(),
    ]);
}
```

## Production Deployment

### 1. Set Queue Driver

```env
QUEUE_CONNECTION=database  # or redis
```

### 2. Run Migrations

```bash
php artisan migrate
```

### 3. Set Up Supervisor

See "Queue Workers > Production > Option A" above for Supervisor configuration.

### 4. Monitor Workers

```bash
# Check worker status
sudo supervisorctl status missing-sock-worker:*

# Restart workers after deployment
sudo supervisorctl restart missing-sock-worker:*
```

### 5. Clear Cache

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## Testing

### Testing Queued Jobs

```php
// In tests
use Illuminate\Support\Facades\Queue;

public function test_email_is_queued(): void
{
    Queue::fake();
    
    $emailService = app(EmailService::class);
    $emailService->send(new TestMail(), 'test@example.com');
    
    Queue::assertPushed(SendEmailJob::class);
}
```

### Running Jobs Synchronously in Tests

Jobs run synchronously during tests by default (queue driver = `sync` in phpunit.xml).

## Best Practices

1. **Keep jobs focused** - One responsibility per job
2. **Make jobs idempotent** - Safe to run multiple times
3. **Handle failures gracefully** - Use failed() method
4. **Log important events** - Success and failures
5. **Set appropriate timeouts** - Match job complexity
6. **Use job batching** - For related jobs (advanced)
7. **Monitor queue depth** - Alert on backlogs

## Scaling

### When to Scale

Monitor these metrics:
- Queue depth (backlog)
- Job processing time
- Failed job rate

### Scaling Options

1. **Add more workers** - Increase `numprocs` in Supervisor
2. **Use Redis** - Faster than database queue
3. **Add dedicated servers** - Separate queue workers from web servers
4. **Use job batching** - Group related jobs
5. **Optimize jobs** - Reduce processing time

## Common Issues

### Jobs Not Processing

**Problem:** Queue worker not running  
**Solution:**
```bash
# Check if worker is running
ps aux | grep queue:work

# Start worker
php artisan queue:work
```

### Memory Leaks

**Problem:** Worker consuming too much memory  
**Solution:**
```bash
# Restart worker after processing X jobs
php artisan queue:work --max-jobs=1000

# Or set memory limit
php artisan queue:work --memory=512
```

### Stuck Jobs

**Problem:** Jobs timeout and block queue  
**Solution:**
```bash
# Increase timeout
php artisan queue:work --timeout=900

# Or in job class
public $timeout = 900;
```

## File Storage for Downloads

### Downloads Disk

A dedicated `downloads` disk is configured for ZIP archives:

```php
// config/filesystems.php
'downloads' => [
    'driver' => 'local',
    'root' => storage_path('app/downloads'),
    'visibility' => 'private',
],
```

### Cleaning Old Archives

Create a scheduled command to clean expired archives:

```php
// In app/Console/Kernel.php
protected function schedule(Schedule $schedule)
{
    $schedule->command('downloads:cleanup')->daily();
}
```

```bash
# Create cleanup command
php artisan make:command CleanupExpiredDownloads
```

## Related Documentation

- [Queue Configuration](./QUEUE_CONFIGURATION.md)
- [Mail Provider Setup](./MAIL_PROVIDER_SETUP.md)
- [Laravel Queue Documentation](https://laravel.com/docs/queues)

---

**Last Updated:** November 2, 2025

