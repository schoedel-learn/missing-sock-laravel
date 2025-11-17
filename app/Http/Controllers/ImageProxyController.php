<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ImageProxyController extends Controller
{
    /**
     * Proxy an image from storage (local or S3) through Laravel routes.
     * This hides external URLs and allows for access control.
     *
     * @param  Request  $request
     * @param  string  $disk
     * @param  string  $path
     * @return Response
     */
    public function proxy(Request $request, string $disk, string $path)
    {
        try {
            if (!$request->hasValidSignature()) {
                abort(401, 'Invalid image link');
            }

            // Validate disk
            if (!in_array($disk, ['local', 'public', 's3'])) {
                abort(404, 'Invalid storage disk');
            }

            // Sanitize path to prevent directory traversal attacks
            $path = $this->sanitizePath($path);

            // Check if file exists
            if (!Storage::disk($disk)->exists($path)) {
                abort(404, 'Image not found');
            }

            // Validate file is an image
            $mimeType = Storage::disk($disk)->mimeType($path);
            if (!str_starts_with($mimeType, 'image/')) {
                abort(403, 'Invalid file type');
            }

            // Optional: Add access control here
            // Example: Check if user has access to this gallery/image
            // if (!$this->userHasAccess($request, $path)) {
            //     abort(403, 'Access denied');
            // }

            // Get file contents
            $fileContents = Storage::disk($disk)->get($path);

            // Set cache headers
            $headers = [
                'Content-Type' => $mimeType,
                'Cache-Control' => 'public, max-age=31536000', // 1 year cache
            ];

            return response($fileContents, 200, $headers);
        } catch (\Exception $e) {
            Log::error('Image proxy error: ' . $e->getMessage());

            abort(500, 'Error serving image');
        }
    }

    /**
     * Serve a temporary URL for S3 images.
     * Useful for private images that need time-limited access.
     *
     * @param  Request  $request
     * @param  string  $path
     * @return \Illuminate\Http\RedirectResponse
     */
    public function temporaryS3Url(Request $request, string $path)
    {
        try {
            if (!$request->hasValidSignature()) {
                abort(401, 'Invalid image link');
            }

            // Sanitize path to prevent directory traversal attacks
            $path = $this->sanitizePath($path);

            // Optional: Add access control
            // if (!$this->userHasAccess($request, $path)) {
            //     abort(403, 'Access denied');
            // }

            $url = Storage::disk('s3')->temporaryUrl(
                $path,
                now()->addMinutes(config('storage.temporary_url_expiry', 60))
            );

            return redirect($url);
        } catch (\Exception $e) {
            Log::error('S3 temporary URL error: ' . $e->getMessage());

            abort(500, 'Error generating temporary URL');
        }
    }

    /**
     * Sanitize file path to prevent directory traversal attacks.
     *
     * @param  string  $path
     * @return string
     */
    protected function sanitizePath(string $path): string
    {
        // Remove directory traversal attempts
        $path = str_replace(['../', '..\\', '/../', '\\..\\'], '', $path);
        
        // Remove leading slashes and normalize
        $path = ltrim($path, '/\\');
        
        // Remove any remaining dangerous characters
        $path = preg_replace('/[^a-zA-Z0-9\-_\.\/\\\]/', '', $path);
        
        return $path;
    }

    /**
     * Example: Check if user has access to an image/gallery.
     * Implement based on your access control requirements.
     *
     * @param  Request  $request
     * @param  string  $path
     * @return bool
     */
    protected function userHasAccess(Request $request, string $path): bool
    {
        // TODO: Implement access control logic
        // Example: Check if user owns the gallery, has access token, etc.
        return true;
    }
}

