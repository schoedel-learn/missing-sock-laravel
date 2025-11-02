<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageService
{
    /**
     * Upload and store an image.
     *
     * @param  UploadedFile  $file
     * @param  string  $disk
     * @param  string  $directory
     * @return array
     */
    public function upload(UploadedFile $file, string $disk = 'public', string $directory = 'images'): array
    {
        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs($directory, $filename, $disk);

        return [
            'path' => $path,
            'filename' => $filename,
            'url' => Storage::disk($disk)->url($path),
            'size' => $file->getSize(),
            'mime_type' => $file->getMimeType(),
        ];
    }

    /**
     * Delete an image from storage.
     *
     * @param  string  $path
     * @param  string  $disk
     * @return bool
     */
    public function delete(string $path, string $disk = 'public'): bool
    {
        return Storage::disk($disk)->delete($path);
    }

    /**
     * Get image URL (proxied if needed).
     *
     * @param  string  $path
     * @param  string  $disk
     * @param  bool  $useProxy
     * @return string
     */
    public function getUrl(string $path, string $disk = 'public', bool $useProxy = false): string
    {
        if ($useProxy) {
            return route('images.proxy', ['disk' => $disk, 'path' => $path]);
        }

        return Storage::disk($disk)->url($path);
    }

    /**
     * Check if file is an image.
     *
     * @param  UploadedFile  $file
     * @return bool
     */
    public function isValidImage(UploadedFile $file): bool
    {
        $allowedMimes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/svg+xml'];

        return in_array($file->getMimeType(), $allowedMimes);
    }
}


