<?php

namespace App\Console\Commands;

use App\Models\Gallery;
use App\Models\Photo;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImportDemoPhotos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'photos:import-demo 
                            {--gallery-id= : ID of existing gallery to import into}
                            {--user-id= : User ID to assign gallery to (defaults to first user)}
                            {--gallery-name=Demo Gallery : Name for the gallery}
                            {--path=storage/app/public/demo-photos : Path to demo photos folder}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import demo photos from storage/app/public/demo-photos into a gallery';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🎨 Starting demo photo import...');

        // Check if migrations have been run
        if (!$this->checkMigrations()) {
            $this->error('❌ Migrations not run. Please run: php artisan migrate');
            return Command::FAILURE;
        }

        // Get or create gallery
        $gallery = $this->getOrCreateGallery();
        if (!$gallery) {
            return Command::FAILURE;
        }

        // Get demo photos path
        $path = $this->option('path');
        $fullPath = base_path($path);

        if (!File::exists($fullPath)) {
            $this->error("❌ Demo photos folder not found: {$fullPath}");
            return Command::FAILURE;
        }

        // Find all image files
        $imageFiles = $this->findImageFiles($fullPath);
        
        if (empty($imageFiles)) {
            $this->warn("⚠️  No image files found in {$fullPath}");
            return Command::FAILURE;
        }

        $this->info("📸 Found " . count($imageFiles) . " images to import");

        // Import photos
        $imported = 0;
        $failed = 0;
        $bar = $this->output->createProgressBar(count($imageFiles));
        $bar->start();

        foreach ($imageFiles as $index => $filePath) {
            try {
                $this->importPhoto($gallery, $filePath, $index + 1);
                $imported++;
            } catch (\Exception $e) {
                $this->newLine();
                $this->error("Failed to import {$filePath}: " . $e->getMessage());
                $failed++;
            }
            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);

        // Summary
        $this->info("✅ Successfully imported {$imported} photos");
        if ($failed > 0) {
            $this->warn("⚠️  Failed to import {$failed} photos");
        }

        $this->info("📁 Gallery ID: {$gallery->id}");
        $this->info("🔗 Gallery Slug: {$gallery->slug}");
        $this->info("🌐 View gallery: " . url("/galleries/{$gallery->slug}"));

        return Command::SUCCESS;
    }

    /**
     * Check if required migrations have been run.
     */
    protected function checkMigrations(): bool
    {
        try {
            // Check if galleries table exists
            \DB::select('SELECT 1 FROM galleries LIMIT 1');
            \DB::select('SELECT 1 FROM photos LIMIT 1');
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Get or create gallery.
     */
    protected function getOrCreateGallery(): ?Gallery
    {
        $galleryId = $this->option('gallery-id');
        
        if ($galleryId) {
            $gallery = Gallery::find($galleryId);
            if (!$gallery) {
                $this->error("❌ Gallery with ID {$galleryId} not found");
                return null;
            }
            $this->info("📁 Using existing gallery: {$gallery->name}");
            return $gallery;
        }

        // Get user ID
        $userId = $this->option('user-id');
        if (!$userId) {
            $user = User::first();
            if (!$user) {
                $this->error('❌ No users found. Please create a user first.');
                return null;
            }
            $userId = $user->id;
        } else {
            $user = User::find($userId);
            if (!$user) {
                $this->error("❌ User with ID {$userId} not found");
                return null;
            }
        }

        // Create gallery
        $galleryName = $this->option('gallery-name');
        $slug = Str::slug($galleryName);

        // Check if slug exists
        $existingGallery = Gallery::where('slug', $slug)->first();
        if ($existingGallery) {
            $slug = $slug . '-' . time();
        }

        $gallery = Gallery::create([
            'user_id' => $userId,
            'name' => $galleryName,
            'slug' => $slug,
            'description' => 'Demo gallery with imported photos from Adobe Stock',
            'access_type' => 'public',
            'published_at' => now(),
        ]);

        $this->info("✅ Created gallery: {$gallery->name} (ID: {$gallery->id})");
        
        return $gallery;
    }

    /**
     * Find all image files in the directory.
     */
    protected function findImageFiles(string $path): array
    {
        $files = [];
        $extensions = ['jpg', 'jpeg', 'png', 'webp', 'gif', 'heic'];

        foreach (File::allFiles($path) as $file) {
            $extension = strtolower($file->getExtension());
            if (in_array($extension, $extensions)) {
                $files[] = $file->getPathname();
            }
        }

        // Sort files for consistent ordering
        sort($files);

        return $files;
    }

    /**
     * Import a single photo.
     */
    protected function importPhoto(Gallery $gallery, string $filePath, int $sortOrder): void
    {
        // Create photo record
        $filename = basename($filePath);
        $title = $this->generateTitleFromFilename($filename);

        $photo = Photo::create([
            'gallery_id' => $gallery->id,
            'title' => $title,
            'sort_order' => $sortOrder,
            'published_at' => now(),
        ]);

        // Add media file using Spatie Media Library
        // Use addMedia with file path - Spatie handles file paths directly
        $photo->addMedia($filePath)
            ->usingName($title)
            ->usingFileName($filename)
            ->toMediaCollection('original');

        // Extract and store metadata if possible
        $this->extractMetadata($photo, $filePath);
    }

    /**
     * Generate a title from filename.
     */
    protected function generateTitleFromFilename(string $filename): string
    {
        // Remove extension
        $name = pathinfo($filename, PATHINFO_FILENAME);
        
        // Replace underscores and hyphens with spaces
        $name = str_replace(['_', '-'], ' ', $name);
        
        // Remove "AdobeStock" prefix if present
        $name = preg_replace('/^AdobeStock\s*/i', '', $name);
        
        // Capitalize words
        $name = ucwords($name);
        
        // If empty or just numbers, use generic name
        if (empty(trim($name)) || is_numeric(trim($name))) {
            return 'Photo ' . time() . rand(100, 999);
        }

        return $name;
    }

    /**
     * Extract metadata from photo file.
     */
    protected function extractMetadata(Photo $photo, string $filePath): void
    {
        try {
            $metadata = [
                'original_filename' => basename($filePath),
                'file_size' => filesize($filePath),
                'mime_type' => mime_content_type($filePath),
            ];

            // Try to get image dimensions
            if (function_exists('getimagesize')) {
                $imageInfo = @getimagesize($filePath);
                if ($imageInfo) {
                    $metadata['width'] = $imageInfo[0];
                    $metadata['height'] = $imageInfo[1];
                    $metadata['mime_type'] = $imageInfo['mime'];
                }
            }

            // Try to extract EXIF data (JPEG only)
            if (function_exists('exif_read_data') && strtolower(pathinfo($filePath, PATHINFO_EXTENSION)) === 'jpeg') {
                $exif = @exif_read_data($filePath);
                if ($exif) {
                    $metadata['exif'] = [
                        'camera' => $exif['Make'] ?? null,
                        'model' => $exif['Model'] ?? null,
                        'iso' => $exif['ISOSpeedRatings'] ?? null,
                        'date_taken' => $exif['DateTimeOriginal'] ?? null,
                    ];
                    // Remove null values
                    $metadata['exif'] = array_filter($metadata['exif'], fn($value) => $value !== null);
                }
            }

            // Update photo with metadata
            $photo->update(['metadata' => $metadata]);
        } catch (\Exception $e) {
            // Silently fail metadata extraction
        }
    }
}
