<?php

namespace App\Services;

use App\Models\Download;
use App\Models\Order;
use App\Models\Photo;
use Illuminate\Support\Facades\URL;

class DownloadService
{
    /**
     * Default expiration days for download links.
     */
    protected int $defaultExpirationDays = 7;

    /**
     * Default maximum download attempts.
     */
    protected int $defaultMaxAttempts = 3;

    /**
     * Generate a secure download link for a single photo.
     *
     * @param Photo $photo
     * @param Order $order
     * @param int|null $expirationDays
     * @return Download
     */
    public function generateDownloadLink(Photo $photo, Order $order, ?int $expirationDays = null): Download
    {
        $expirationDays = $expirationDays ?? $this->defaultExpirationDays;
        $expiresAt = now()->addDays($expirationDays);

        // Use firstOrCreate to handle race conditions via unique constraint
        $download = Download::firstOrCreate(
            [
                'photo_id' => $photo->id,
                'order_id' => $order->id,
                'user_id' => $order->user_id,
            ],
            [
                'expires_at' => $expiresAt,
                'max_attempts' => $this->defaultMaxAttempts,
                'attempts' => 0,
                'is_batch' => false,
            ]
        );

        // If existing record, handle expiry
        if (!$download->wasRecentlyCreated) {
            if ($download->isExpired()) {
                // Expired - extend expiry and reset attempts
                $download->update([
                    'expires_at' => $expiresAt,
                    'attempts' => 0,
                ]);
            } elseif ($download->expires_at->lt(now()->addDays(2))) {
                // Expiring soon - extend expiry WITHOUT resetting attempts
                // This preserves existing links while extending validity
                $download->update(['expires_at' => $expiresAt]);
            }
        } else {
            // New record - ensure expiry is set
            $download->update(['expires_at' => $expiresAt]);
        }

        return $download->fresh();
    }

    /**
     * Generate download links for all photos in an order.
     *
     * @param Order $order
     * @param int|null $expirationDays
     * @return array Array of Download models
     */
    public function generateDownloadLinksForOrder(Order $order, ?int $expirationDays = null): array
    {
        // Note: This assumes Order has a relationship to photos
        // For now, you'll need to implement this based on your Order structure
        // For pre-orders, photos might not be linked yet
        
        $downloads = [];
        $expiresAt = now()->addDays($expirationDays ?? $this->defaultExpirationDays);

        // TODO: Implement based on your Order structure
        // If Order has OrderItems → Photos relationship:
        // foreach ($order->items as $item) {
        //     if ($item->photo) {
        //         $downloads[] = $this->generateDownloadLink($item->photo, $order, $expirationDays);
        //     }
        // }

        return $downloads;
    }

    /**
     * Generate a signed URL for a download.
     * Uses Laravel's built-in signed URL functionality.
     *
     * @param Download $download
     * @return string
     */
    public function getSignedUrl(Download $download): string
    {
        if ($download->is_batch) {
            return URL::temporarySignedRoute(
                'downloads.batch',
                $download->expires_at,
                [
                    'order' => $download->order_id,
                    'download' => $download->id,
                ]
            );
        }

        return URL::temporarySignedRoute(
            'downloads.photo',
            $download->expires_at,
            [
                'photo' => $download->photo_id,
                'order' => $download->order_id,
                'download' => $download->id,
            ]
        );
    }

    /**
     * Generate a batch download link (ZIP) for an order.
     *
     * @param Order $order
     * @param int|null $expirationDays
     * @return Download
     */
    public function generateBatchDownloadLink(Order $order, ?int $expirationDays = null): Download
    {
        $expirationDays = $expirationDays ?? $this->defaultExpirationDays;
        $expiresAt = now()->addDays($expirationDays);

        // Use firstOrCreate for batch downloads (photo_id is null)
        $download = Download::firstOrCreate(
            [
                'order_id' => $order->id,
                'user_id' => $order->user_id,
                'photo_id' => null,
                'is_batch' => true,
            ],
            [
                'expires_at' => $expiresAt,
                'max_attempts' => $this->defaultMaxAttempts,
                'attempts' => 0,
            ]
        );

        // Handle expiry similar to single photo downloads
        if (!$download->wasRecentlyCreated) {
            if ($download->isExpired()) {
                $download->update([
                    'expires_at' => $expiresAt,
                    'attempts' => 0,
                ]);
            } elseif ($download->expires_at->lt(now()->addDays(2))) {
                $download->update(['expires_at' => $expiresAt]);
            }
        } else {
            $download->update(['expires_at' => $expiresAt]);
        }

        return $download->fresh();
    }

    /**
     * Validate download access.
     *
     * @param Download $download
     * @param int|null $userId
     * @return bool
     */
    public function validateAccess(Download $download, ?int $userId = null): bool
    {
        // Check if expired
        if ($download->isExpired()) {
            return false;
        }

        // Check if attempts exceeded
        if (!$download->hasAttemptsRemaining()) {
            return false;
        }

        // Check user access (if provided)
        if ($userId !== null && $download->user_id !== $userId) {
            return false;
        }

        return true;
    }

    /**
     * Record a download attempt.
     *
     * @param Download $download
     * @param string $ipAddress
     * @param string|null $userAgent
     * @return void
     */
    public function recordDownload(Download $download, string $ipAddress, ?string $userAgent = null): void
    {
        $download->markAsDownloaded($ipAddress, $userAgent);
    }
}

