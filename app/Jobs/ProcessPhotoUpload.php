<?php

namespace App\Jobs;

use App\Models\Photo;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProcessPhotoUpload implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 3;

    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    public $timeout = 300; // 5 minutes for large images

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected int $photoId,
        protected ?array $options = []
    ) {
        $this->onQueue('photos');
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $photo = Photo::findOrFail($this->photoId);

        try {
            Log::info('Processing photo upload', [
                'photo_id' => $this->photoId,
                'gallery_id' => $photo->gallery_id,
            ]);

            // Extract EXIF data if not already done
            if (empty($photo->metadata)) {
                $this->extractMetadata($photo);
            }

            // Generate thumbnails via Spatie Media Library
            // (Thumbnails are auto-generated via registerMediaConversions)
            // Force regeneration if needed
            if ($this->options['regenerate_thumbnails'] ?? false) {
                $media = $photo->getFirstMedia('photos');
                if ($media) {
                    $media->clearMediaConversions();
                    // Conversions will be regenerated on next access
                }
            }

            // Update processing status
            $photo->update([
                'metadata' => array_merge($photo->metadata ?? [], [
                    'processed_at' => now()->toIso8601String(),
                    'processing_duration' => microtime(true) - LARAVEL_START,
                ]),
            ]);

            Log::info('Photo processing completed', [
                'photo_id' => $this->photoId,
            ]);

        } catch (\Exception $e) {
            Log::error('Photo processing failed', [
                'photo_id' => $this->photoId,
                'error' => $e->getMessage(),
            ]);
            
            throw $e;
        }
    }

    /**
     * Extract EXIF metadata from photo
     */
    protected function extractMetadata(Photo $photo): void
    {
        $media = $photo->getFirstMedia('photos');
        
        if (!$media) {
            return;
        }

        $path = $media->getPath();
        
        if (!file_exists($path)) {
            return;
        }

        $metadata = [];

        // Extract EXIF data if available
        if (function_exists('exif_read_data') && exif_imagetype($path)) {
            try {
                $exif = @exif_read_data($path);
                
                if ($exif !== false) {
                    $metadata['exif'] = [
                        'camera' => $exif['Make'] ?? null,
                        'model' => $exif['Model'] ?? null,
                        'iso' => $exif['ISOSpeedRatings'] ?? null,
                        'date_taken' => $exif['DateTimeOriginal'] ?? null,
                        'aperture' => $exif['FNumber'] ?? null,
                        'shutter_speed' => $exif['ExposureTime'] ?? null,
                        'focal_length' => $exif['FocalLength'] ?? null,
                    ];
                }
            } catch (\Exception $e) {
                Log::warning('Could not extract EXIF data', [
                    'photo_id' => $photo->id,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        // Get image dimensions
        $imageSize = @getimagesize($path);
        if ($imageSize !== false) {
            $metadata['dimensions'] = [
                'width' => $imageSize[0],
                'height' => $imageSize[1],
            ];
        }

        // File info
        $metadata['file'] = [
            'size' => filesize($path),
            'mime_type' => $media->mime_type,
            'extension' => $media->extension,
        ];

        $photo->update(['metadata' => $metadata]);
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error('Photo processing job failed after all retries', [
            'photo_id' => $this->photoId,
            'error' => $exception->getMessage(),
        ]);
    }
}

