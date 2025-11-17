<?php

namespace App\Jobs;

use App\Models\Download;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class GenerateDownloadArchive implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 2;

    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    public $timeout = 600; // 10 minutes for large archives

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected int $downloadId
    ) {
        $this->onQueue('downloads');
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $download = Download::with(['order.registration', 'photos'])->findOrFail($this->downloadId);

        try {
            Log::info('Generating download archive', [
                'download_id' => $this->downloadId,
                'order_id' => $download->order_id,
            ]);

            // Determine photos to include
            $photos = $this->getPhotosForDownload($download);

            if ($photos->isEmpty()) {
                Log::warning('No photos found for download', [
                    'download_id' => $this->downloadId,
                ]);
                
                $download->update([
                    'status' => 'failed',
                    'error_message' => 'No photos available for download',
                ]);
                
                return;
            }

            // Generate ZIP archive
            $zipPath = $this->generateZipArchive($download, $photos);

            // Update download record
            $download->update([
                'file_path' => $zipPath,
                'file_size_bytes' => Storage::disk('downloads')->size($zipPath),
                'status' => 'ready',
                'expires_at' => now()->addDays(7),
            ]);

            Log::info('Download archive generated successfully', [
                'download_id' => $this->downloadId,
                'file_path' => $zipPath,
                'photo_count' => $photos->count(),
            ]);

            // TODO: Send email notification that download is ready
            // dispatch(new SendEmailJob(new DownloadReadyMail($download), $download->order->registration->parent_email));

        } catch (\Exception $e) {
            Log::error('Download archive generation failed', [
                'download_id' => $this->downloadId,
                'error' => $e->getMessage(),
            ]);

            $download->update([
                'status' => 'failed',
                'error_message' => $e->getMessage(),
            ]);
            
            throw $e;
        }
    }

    /**
     * Get photos that should be included in the download
     */
    protected function getPhotosForDownload(Download $download)
    {
        // If specific photos are attached to download
        if ($download->photos && $download->photos->isNotEmpty()) {
            return $download->photos;
        }

        // Otherwise get all photos from order's gallery
        // This assumes orders are linked to galleries
        // Adjust based on your actual data model
        
        return collect(); // Return empty for now - implement based on your photo selection logic
    }

    /**
     * Generate ZIP archive of photos
     */
    protected function generateZipArchive(Download $download, $photos): string
    {
        $zipFilename = 'order-' . $download->order->order_number . '-' . now()->format('Ymd-His') . '.zip';
        $zipPath = 'archives/' . $download->order->order_number . '/' . $zipFilename;
        
        // Ensure directory exists
        $fullPath = Storage::disk('downloads')->path($zipPath);
        $directory = dirname($fullPath);
        
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $zip = new ZipArchive();
        
        if ($zip->open($fullPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            throw new \RuntimeException('Could not create ZIP archive');
        }

        foreach ($photos as $index => $photo) {
            $media = $photo->getFirstMedia('original');
            
            if (!$media) {
                continue;
            }

            $sourcePath = $media->getPath();
            
            if (!file_exists($sourcePath)) {
                Log::warning('Photo file not found', [
                    'photo_id' => $photo->id,
                    'path' => $sourcePath,
                ]);
                continue;
            }

            // Add to ZIP with a clean filename
            $extension = $media->extension;
            $filename = sprintf(
                '%s-%03d.%s',
                $download->order->order_number,
                $index + 1,
                $extension
            );
            
            $zip->addFile($sourcePath, $filename);
        }

        $zip->close();

        Log::info('ZIP archive created', [
            'download_id' => $this->downloadId,
            'path' => $zipPath,
            'photo_count' => $photos->count(),
        ]);

        return $zipPath;
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error('Download generation job failed after all retries', [
            'download_id' => $this->downloadId,
            'error' => $exception->getMessage(),
        ]);
    }
}
