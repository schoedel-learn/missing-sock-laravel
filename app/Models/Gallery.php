<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Gallery extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'project_id', // Link to Project (school photography session)
        'name',
        'slug',
        'description',
        'access_type', // 'public', 'password', 'private', 'token'
        'password_hash',
        'access_token', // For token-based access
        'expires_at',
        'published_at',
        'settings',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password_hash',
        'access_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
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
        // Featured/cover image (single)
        $this->addMediaCollection('featured')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp'])
            ->singleFile();

        // Gallery images will be stored via Photo model, not directly on Gallery
        // This keeps the structure clean: Gallery → Photos → Media
    }

    /**
     * Register media conversions (thumbnails) for featured image.
     */
    public function registerMediaConversions(?Media $media = null): void
    {
        // Thumbnail: 150x150 (square)
        $this->addMediaConversion('thumb')
            ->width(150)
            ->height(150)
            ->sharpen(10)
            ->performOnCollections('featured');

        // Medium: 400px width (maintains aspect ratio)
        $this->addMediaConversion('medium')
            ->width(400)
            ->sharpen(10)
            ->performOnCollections('featured');

        // Large: 1200px width
        $this->addMediaConversion('large')
            ->width(1200)
            ->sharpen(10)
            ->performOnCollections('featured');
    }

    /**
     * Get the user (photographer/admin) that owns the gallery.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the project this gallery belongs to (optional).
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get the photos for the gallery.
     */
    public function photos(): HasMany
    {
        return $this->hasMany(Photo::class)->orderBy('sort_order');
    }

    /**
     * Get published photos only.
     */
    public function publishedPhotos(): HasMany
    {
        return $this->photos()->whereNotNull('published_at');
    }

    /**
     * Get featured photo.
     */
    public function getFeaturedPhotoAttribute()
    {
        return $this->getFirstMedia('featured');
    }

    /**
     * Get featured photo URL.
     */
    public function getFeaturedPhotoUrlAttribute(): ?string
    {
        $media = $this->getFeaturedPhotoAttribute();
        return $media ? $media->getUrl('medium') : null;
    }

    /**
     * Check if the gallery has expired.
     */
    public function getIsExpiredAttribute(): bool
    {
        return $this->expires_at !== null && $this->expires_at->isPast();
    }

    /**
     * Check if gallery is published.
     */
    public function getIsPublishedAttribute(): bool
    {
        return $this->published_at !== null && $this->published_at->isPast();
    }

    /**
     * Generate a unique access token for token-based galleries.
     */
    public function generateAccessToken(): string
    {
        $token = \Illuminate\Support\Str::random(32);
        $this->update(['access_token' => hash('sha256', $token)]);
        return $token;
    }

    /**
     * Verify access token.
     */
    public function verifyAccessToken(?string $token): bool
    {
        if (!$token || !$this->access_token) {
            return false;
        }

        return hash_equals($this->access_token, hash('sha256', $token));
    }

    /**
     * Verify password.
     */
    public function verifyPassword(string $password): bool
    {
        if (!$this->password_hash) {
            return false;
        }

        return \Illuminate\Support\Facades\Hash::check($password, $this->password_hash);
    }

    /**
     * Check if user has access to this gallery.
     */
    public function userHasAccess(?User $user = null, ?string $password = null, ?string $token = null): bool
    {
        // Public galleries are accessible to everyone
        if ($this->access_type === 'public') {
            return true;
        }

        // Owner always has access
        if ($user && $user->id === $this->user_id) {
            return true;
        }

        // Check password
        if ($this->access_type === 'password' && $password) {
            return $this->verifyPassword($password);
        }

        // Check token
        if ($this->access_type === 'token' && $token) {
            return $this->verifyAccessToken($token);
        }

        // Private galleries require authentication and ownership
        if ($this->access_type === 'private') {
            return $user && $user->id === $this->user_id;
        }

        return false;
    }
}

