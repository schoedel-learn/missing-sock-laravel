<?php

namespace App\Http\Controllers;

use App\Models\Download;
use App\Models\Order;
use App\Models\Photo;
use App\Services\DownloadService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Spatie\MediaLibrary\Support\MediaStream;

class DownloadController extends Controller
{
    /**
     * Download a single photo.
     * Route must be signed via Laravel's signed URL middleware.
     *
     * @param Request $request
     * @param Photo $photo
     * @param Order $order
     * @param Download $download
     * @param DownloadService $downloadService
     * @return Response
     */
    public function downloadPhoto(
        Request $request,
        Photo $photo,
        Order $order,
        Download $download,
        DownloadService $downloadService
    ): Response {
        // Validate signed URL (handled by middleware, but double-check)
        if (!$request->hasValidSignature()) {
            abort(401, 'Invalid download link');
        }

        // Validate download record
        if (!$downloadService->validateAccess($download, $request->user())) {
            abort(403, 'Download link expired or access denied');
        }

        // Verify download matches photo and order
        if ($download->photo_id !== $photo->id || $download->order_id !== $order->id) {
            abort(403, 'Download link mismatch');
        }

        // Record download attempt
        $downloadService->recordDownload(
            $download,
            $request->ip(),
            $request->userAgent()
        );

        // Get media file from Spatie Media Library
        $media = $photo->getFirstMedia('original');
        if (!$media) {
            abort(404, 'Photo file not found');
        }

        // Serve the file
        try {
            $fileContents = $media->get();
            $mimeType = $media->mime_type ?? 'application/octet-stream';

            return response($fileContents, 200, [
                'Content-Type' => $mimeType,
                'Content-Disposition' => sprintf(
                    'attachment; filename="%s"',
                    $photo->title ?: $media->file_name
                ),
                'Cache-Control' => 'no-cache, no-store, must-revalidate',
            ]);
        } catch (\Exception $e) {
            Log::error('Download failed', [
                'download_id' => $download->id,
                'photo_id' => $photo->id,
                'error' => $e->getMessage(),
            ]);

            abort(500, 'Failed to serve download');
        }
    }

    /**
     * Download batch ZIP archive for an order.
     * Route must be signed via Laravel's signed URL middleware.
     *
     * @param Request $request
     * @param Order $order
     * @param Download $download
     * @param DownloadService $downloadService
     * @return MediaStream|Response
     */
    public function downloadBatch(
        Request $request,
        Order $order,
        Download $download,
        DownloadService $downloadService
    ) {
        // Validate signed URL
        if (!$request->hasValidSignature()) {
            abort(401, 'Invalid download link');
        }

        // Validate download record
        if (!$downloadService->validateAccess($download, $request->user())) {
            abort(403, 'Download link expired or access denied');
        }

        // Verify download matches order and is batch type
        if ($download->order_id !== $order->id || !$download->is_batch) {
            abort(403, 'Download link mismatch');
        }

        // Record download attempt
        $downloadService->recordDownload(
            $download,
            $request->ip(),
            $request->userAgent()
        );

        // Get photos for this order
        // TODO: Implement based on your Order structure
        // For now, this is a placeholder - you'll need to define how Order relates to Photos
        // Options:
        // 1. Order → OrderItems → Photos (if OrderItem model exists)
        // 2. Order → Gallery → Photos (if order has gallery_id)
        // 3. Order → Registration → Project → Gallery → Photos

        // Example implementation (adjust based on your structure):
        $photos = collect([]);
        
        // If Order has gallery relationship:
        // if ($order->gallery_id) {
        //     $photos = Photo::where('gallery_id', $order->gallery_id)->get();
        // }

        if ($photos->isEmpty()) {
            abort(404, 'No photos found for this order');
        }

        // Get media items using Spatie Media Library
        $mediaItems = $photos->map(function ($photo) {
            return $photo->getFirstMedia('original');
        })->filter();

        if ($mediaItems->isEmpty()) {
            abort(404, 'No media files found for download');
        }

        // Generate ZIP using Spatie Media Library's MediaStream
        try {
            $zipName = sprintf('order-%s-photos.zip', $order->order_number);

            return MediaStream::create($zipName)
                ->addMedia($mediaItems);
        } catch (\Exception $e) {
            Log::error('Batch download failed', [
                'download_id' => $download->id,
                'order_id' => $order->id,
                'error' => $e->getMessage(),
            ]);

            abort(500, 'Failed to generate download archive');
        }
    }
}
