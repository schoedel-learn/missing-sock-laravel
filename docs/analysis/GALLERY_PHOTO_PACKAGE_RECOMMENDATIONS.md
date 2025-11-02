# Gallery & Photo Management Package Recommendations

**Date:** 2025-01-27  
**Status:** Analysis of Laravel packages for Gallery/Photo management

---

## 🎯 Best Option: Spatie Laravel Media Library

### ✅ **Already Installed!**

You already have `spatie/laravel-medialibrary` v11.0 installed in your `composer.json`. This is the **best choice** for your Gallery & Photo Management system.

### **Why Spatie Media Library?**

1. **✅ Battle-tested** - Most popular Laravel media package (10k+ stars)
2. **✅ Powerful Features:**
   - Automatic file handling and storage
   - Multiple file system support (local, S3, etc.)
   - Image conversions/thumbnails (multiple sizes)
   - Responsive images
   - Organized file structure
   - Collections (different file groups)
   - MIME type validation
   - File size limits

3. **✅ Perfect for Your Use Case:**
   - Associate photos with Gallery models
   - Generate thumbnails automatically
   - Works with S3 storage
   - Clean API
   - Supports collections (e.g., "thumbnails", "originals", "previews")

4. **✅ Integration:**
   - Works seamlessly with Filament
   - Compatible with your existing structure
   - No breaking changes needed

---

## 📦 Package Comparison

| Package | Pros | Cons | Recommendation |
|--------|------|------|----------------|
| **Spatie Media Library** ⭐ | Most popular, feature-rich, thumbnails, collections | Learning curve | ✅ **BEST CHOICE** |
| **Filament Gallery** | Filament integration, drag-drop | Filament-specific, less flexible | ⚠️ Consider as addon |
| **Laravel ImageUp** | Simple, automatic | Less features, older | ❌ Not recommended |
| **UniSharp File Manager** | Full UI, WYSIWYG support | Heavy, UI-focused | ❌ Overkill |

---

## 🏗️ Implementation Structure with Spatie Media Library

### **Gallery Model Structure**

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Gallery extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia;

    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'description',
        'access_type', // 'public', 'password', 'private'
        'password_hash',
        'expires_at',
        'published_at',
        'settings',
    ];

    protected function casts(): array
    {
        return [
            'expires_at' => 'datetime',
            'published_at' => 'datetime',
            'settings' => 'array',
        ];
    }

    /**
     * Register media collections for this model.
     * Spatie will automatically handle thumbnails if configured.
     */
    public function registerMediaCollections(): void
    {
        // Main photo collection
        $this->addMediaCollection('photos')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp'])
            ->singleFile(false); // Allow multiple files

        // Featured photo (single)
        $this->addMediaCollection('featured')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp'])
            ->singleFile(); // Only one file
    }

    /**
     * Register media conversions (thumbnails).
     * Automatically generated when files are added.
     */
    public function registerMediaConversions(Media $media = null): void
    {
        // Thumbnail: 150x150
        $this->addMediaConversion('thumb')
            ->width(150)
            ->height(150)
            ->sharpen(10)
            ->performOnCollections('photos', 'featured');

        // Medium: 400px width (maintains aspect ratio)
        $this->addMediaConversion('medium')
            ->width(400)
            ->sharpen(10)
            ->performOnCollections('photos', 'featured');

        // Large: 1200px width
        $this->addMediaConversion('large')
            ->width(1200)
            ->sharpen(10)
            ->performOnCollections('photos', 'featured');
    }

    /**
     * Get all photos in this gallery.
     */
    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    /**
     * Get featured photo.
     */
    public function getFeaturedPhotoAttribute()
    {
        return $this->getFirstMedia('featured');
    }
}
```

### **Photo Model Structure**

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Photo extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia;

    protected $fillable = [
        'gallery_id',
        'title',
        'description',
        'is_featured',
        'sort_order',
        'metadata', // JSON field for EXIF, etc.
    ];

    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
            'metadata' => 'array',
        ];
    }

    /**
     * Register media collections.
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('original')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp', 'image/heic'])
            ->singleFile();
    }

    /**
     * Register media conversions (thumbnails).
     */
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(150)
            ->height(150)
            ->sharpen(10);

        $this->addMediaConversion('medium')
            ->width(400)
            ->sharpen(10);

        $this->addMediaConversion('large')
            ->width(1200)
            ->sharpen(10);
    }

    /**
     * Get the gallery that owns this photo.
     */
    public function gallery()
    {
        return $this->belongsTo(Gallery::class);
    }

    /**
     * Get photo URL (original).
     */
    public function getUrlAttribute(): string
    {
        return $this->getFirstMediaUrl('original');
    }

    /**
     * Get thumbnail URL.
     */
    public function getThumbnailUrlAttribute(): string
    {
        return $this->getFirstMediaUrl('original', 'thumb');
    }

    /**
     * Get medium size URL.
     */
    public function getMediumUrlAttribute(): string
    {
        return $this->getFirstMediaUrl('original', 'medium');
    }

    /**
     * Get large size URL.
     */
    public function getLargeUrlAttribute(): string
    {
        return $this->getFirstMediaUrl('original', 'large');
    }
}
```

---

## 🚀 Setup Steps

### **1. Publish Configuration**

```bash
php artisan vendor:publish --provider="Spatie\MediaLibrary\MediaLibraryServiceProvider" --tag="medialibrary-config"
php artisan vendor:publish --provider="Spatie\MediaLibrary\MediaLibraryServiceProvider" --tag="medialibrary-migrations"
```

### **2. Run Migrations**

```bash
php artisan migrate
```

### **3. Configure Storage**

Update `config/media-library.php`:

```php
return [
    'disk_name' => env('MEDIA_DISK', 's3'), // or 'public' for local
    
    'conversions_disk_name' => env('MEDIA_CONVERSIONS_DISK', 's3'), // Where thumbnails are stored
    
    // ... other config
];
```

### **4. Install Image Driver**

Spatie Media Library requires an image driver:

```bash
# Option 1: GD (usually included with PHP)
# No installation needed, but check php.ini

# Option 2: Imagick (better quality, more features)
# Install: sudo apt-get install php-imagick (Linux)
# Or use Homebrew on macOS: brew install imagemagick
```

---

## 💡 Usage Examples

### **Uploading Photos**

```php
use Illuminate\Http\UploadedFile;

// Upload single photo to gallery
$gallery = Gallery::find(1);

$gallery->addMediaFromRequest('photo')
    ->toMediaCollection('photos');

// Or from UploadedFile
$gallery->addMedia($uploadedFile)
    ->usingName('Photo Title')
    ->usingFileName('custom-filename.jpg')
    ->toMediaCollection('photos');

// Upload to Photo model
$photo = Photo::create([
    'gallery_id' => $gallery->id,
    'title' => 'School Photo 2024',
]);

$photo->addMedia($uploadedFile)
    ->toMediaCollection('original');
```

### **Accessing Photos**

```php
// Get all photos in a gallery
$gallery = Gallery::find(1);
$photos = $gallery->getMedia('photos');

// Get thumbnails
foreach ($photos as $media) {
    $thumbnailUrl = $media->getUrl('thumb');
    $mediumUrl = $media->getUrl('medium');
    $largeUrl = $media->getUrl('large');
}

// Get single photo with conversions
$photo = Photo::find(1);
$originalUrl = $photo->getFirstMediaUrl('original');
$thumbnailUrl = $photo->getFirstMediaUrl('original', 'thumb');
```

### **In Blade Templates**

```blade
{{-- Display thumbnail --}}
<img src="{{ $photo->thumbnail_url }}" alt="{{ $photo->title }}">

{{-- Display original with lazy loading --}}
<img src="{{ $photo->url }}" 
     srcset="{{ $photo->thumbnail_url }} 150w,
             {{ $photo->medium_url }} 400w,
             {{ $photo->large_url }} 1200w"
     sizes="(max-width: 400px) 150px, (max-width: 1200px) 400px, 1200px"
     alt="{{ $photo->title }}"
     loading="lazy">
```

---

## 🔧 Integration with Your Existing Code

### **Update ImageService**

You can enhance your existing `ImageService` to work with Spatie:

```php
<?php

namespace App\Services;

use App\Models\Gallery;
use App\Models\Photo;
use Illuminate\Http\UploadedFile;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class ImageService
{
    /**
     * Upload photo to gallery using Spatie Media Library.
     */
    public function uploadToGallery(UploadedFile $file, Gallery $gallery, array $attributes = []): Photo
    {
        // Create photo record
        $photo = Photo::create([
            'gallery_id' => $gallery->id,
            'title' => $attributes['title'] ?? $file->getClientOriginalName(),
            'sort_order' => $attributes['sort_order'] ?? 0,
        ]);

        // Add media using Spatie
        $media = $photo->addMediaFromRequest('photo')
            ->usingName($photo->title)
            ->toMediaCollection('original');

        // Extract and store metadata
        $metadata = $this->extractMetadata($file);
        $photo->update(['metadata' => $metadata]);

        return $photo->fresh();
    }

    /**
     * Extract metadata from uploaded file.
     */
    private function extractMetadata(UploadedFile $file): array
    {
        $metadata = [
            'original_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
        ];

        // Extract EXIF if available
        if (function_exists('exif_read_data') && $file->isValid()) {
            try {
                $exif = @exif_read_data($file->getRealPath());
                if ($exif) {
                    $metadata['exif'] = [
                        'camera' => $exif['Make'] ?? null,
                        'model' => $exif['Model'] ?? null,
                        'iso' => $exif['ISOSpeedRatings'] ?? null,
                        // ... more EXIF data
                    ];
                }
            } catch (\Exception $e) {
                // Silently fail
            }
        }

        return $metadata;
    }
}
```

---

## 📊 Database Schema

### **Galleries Migration**

```php
Schema::create('galleries', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->string('name');
    $table->string('slug')->unique();
    $table->text('description')->nullable();
    $table->enum('access_type', ['public', 'password', 'private'])->default('public');
    $table->string('password_hash')->nullable();
    $table->timestamp('expires_at')->nullable();
    $table->timestamp('published_at')->nullable();
    $table->json('settings')->nullable();
    $table->timestamps();
    $table->softDeletes();
    
    $table->index('user_id');
    $table->index('slug');
});
```

### **Photos Migration**

```php
Schema::create('photos', function (Blueprint $table) {
    $table->id();
    $table->foreignId('gallery_id')->constrained()->onDelete('cascade');
    $table->string('title')->nullable();
    $table->text('description')->nullable();
    $table->boolean('is_featured')->default(false);
    $table->integer('sort_order')->default(0);
    $table->json('metadata')->nullable();
    $table->timestamps();
    $table->softDeletes();
    
    $table->index('gallery_id');
    $table->index('is_featured');
    $table->index('sort_order');
});
```

**Note:** Spatie Media Library creates its own `media` table automatically via migration.

---

## 🎨 Filament Integration

Spatie Media Library works great with Filament:

```php
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;

// In your Filament form
SpatieMediaLibraryFileUpload::make('photos')
    ->collection('photos')
    ->multiple()
    ->image()
    ->imageEditor()
    ->maxFiles(50)
    ->directory('galleries')
    ->visibility('public')
    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
    ->imageResizeMode('cover')
    ->imageCropAspectRatio('16:9')
    ->imageResizeTargetWidth('1920')
    ->imageResizeTargetHeight('1080');
```

---

## ⚡ Performance Considerations

### **1. Queue Conversions**

Generate thumbnails in background:

```php
// In config/media-library.php
'queue_conversions_by_default' => true,
```

### **2. CDN Integration**

Spatie works with S3/CDN:

```php
// Store conversions on same disk as originals
'conversions_disk_name' => 's3',
```

### **3. Lazy Loading**

Use responsive images and lazy loading in templates.

---

## 🔗 Additional Resources

- **Spatie Media Library Docs:** https://spatie.be/docs/laravel-medialibrary
- **Filament Media Library Plugin:** https://filamentphp.com/plugins/spatie-media-library
- **GitHub:** https://github.com/spatie/laravel-medialibrary

---

## ✅ Recommendation

**Use Spatie Laravel Media Library** - It's already installed, powerful, and perfect for your needs. You'll get:

- ✅ Automatic thumbnail generation
- ✅ Organized file storage
- ✅ S3 compatibility
- ✅ Clean API
- ✅ Filament integration
- ✅ No need to reinvent the wheel

The reference implementation in `piwigo-got/schoedel-photo-app` uses custom code, but Spatie Media Library would be **better** because:
- Less code to maintain
- Battle-tested and actively maintained
- Better performance optimizations
- More features out of the box

---

**Last Updated:** 2025-01-27

