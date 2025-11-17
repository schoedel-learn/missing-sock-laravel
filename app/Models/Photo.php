<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\URL;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Photo extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'gallery_id',
        'title',
        'description',
        'is_featured',
        'sort_order',
        'published_at',
        'metadata', // JSON field for EXIF, dimensions, etc.
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
            'metadata' => 'array',
            'published_at' => 'datetime',
        ];
    }

    /**
     * Register media collections.
     * Photos are stored in the 'original' collection.
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('original')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp', 'image/heic'])
            ->singleFile(); // One file per photo
    }

    /**
     * Register media conversions (thumbnails).
     * Automatically generated when files are added.
     */
    public function registerMediaConversions(?Media $media = null): void
    {
        // Thumbnail: 150x150 (square, cropped)
        $this->addMediaConversion('thumb')
            ->width(150)
            ->height(150)
            ->fit(\Spatie\Image\Enums\Fit::Crop, 150, 150)
            ->sharpen(10)
            ->performOnCollections('original');

        // Medium: 400px width (maintains aspect ratio)
        $this->addMediaConversion('medium')
            ->width(400)
            ->sharpen(10)
            ->performOnCollections('original');

        // Large: 1200px width (for full-screen viewing)
        $this->addMediaConversion('large')
            ->width(1200)
            ->sharpen(10)
            ->performOnCollections('original');

        // Extra large: Original resolution (if needed for downloads)
        // Note: This doesn't resize, just creates a conversion reference
        $this->addMediaConversion('xlarge')
            ->performOnCollections('original');
    }

    /**
     * Get the gallery that owns this photo.
     */
    public function gallery(): BelongsTo
    {
        return $this->belongsTo(Gallery::class);
    }

    /**
     * Get orders that include this photo.
     * Note: This relationship can be implemented when OrderItem model is created.
     */
    // public function orderItems(): HasMany
    // {
    //     return $this->hasMany(OrderItem::class);
    // }

    /**
     * Get the media file for this photo.
     */
    public function getMediaFileAttribute(): ?Media
    {
        return $this->getFirstMedia('original');
    }

    /**
     * Get photo URL (original).
     * Uses proxy route if configured.
     */
    public function getUrlAttribute(): ?string
    {
        $media = $this->getMediaFileAttribute();
        if (!$media) {
            return null;
        }

        // If using proxy, return proxied URL
        if (config('media-library.use_proxy', false)) {
            return $this->generateProxyUrl($media);
        }

        return $media->getUrl();
    }

    /**
     * Get thumbnail URL.
     */
    public function getThumbnailUrlAttribute(): ?string
    {
        $media = $this->getMediaFileAttribute();
        if (!$media) {
            return null;
        }

        if (config('media-library.use_proxy', false)) {
            return $this->generateProxyUrl($media, 'thumb');
        }

        return $media->getUrl('thumb');
    }

    /**
     * Get medium size URL.
     */
    public function getMediumUrlAttribute(): ?string
    {
        $media = $this->getMediaFileAttribute();
        if (!$media) {
            return null;
        }

        if (config('media-library.use_proxy', false)) {
            return $this->generateProxyUrl($media, 'medium');
        }

        return $media->getUrl('medium');
    }

    /**
     * Get large size URL.
     */
    public function getLargeUrlAttribute(): ?string
    {
        $media = $this->getMediaFileAttribute();
        if (!$media) {
            return null;
        }

        if (config('media-library.use_proxy', false)) {
            return $this->generateProxyUrl($media, 'large');
        }

        return $media->getUrl('large');
    }

    /**
     * Check if photo is published.
     */
    public function getIsPublishedAttribute(): bool
    {
        return $this->published_at !== null && $this->published_at->isPast();
    }

    /**
     * Get file size in human-readable format.
     */
    public function getFileSizeAttribute(): ?string
    {
        $media = $this->getMediaFileAttribute();
        if (!$media) {
            return null;
        }

        $size = $media->size;
        $units = ['B', 'KB', 'MB', 'GB'];
        
        for ($i = 0; $size > 1024 && $i < count($units) - 1; $i++) {
            $size /= 1024;
        }

        return round($size, 2) . ' ' . $units[$i];
    }

    /**
     * Scope: Published photos only.
     */
    public function scopePublished($query)
    {
        return $query->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    /**
     * Scope: Featured photos.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    protected function generateProxyUrl(Media $media, ?string $conversion = null): ?string
    {
        $expiryMinutes = config('storage.temporary_url_expiry', 60);
        $relativePath = ltrim($media->getPathRelativeToRoot($conversion ?? ''), '/');

        return URL::temporarySignedRoute(
            'images.proxy',
            now()->addMinutes($expiryMinutes),
            [
                'disk' => $media->disk,
                'path' => $relativePath,
            ]
        );
    }
}
