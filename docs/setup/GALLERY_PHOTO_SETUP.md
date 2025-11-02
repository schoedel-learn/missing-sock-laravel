# Gallery & Photo Management Setup Guide

**Date:** 2025-01-27  
**Status:** Ready for demo photography

---

## ✅ What's Been Created

1. **Gallery Model** (`app/Models/Gallery.php`)
   - Spatie Media Library integration
   - Access control (public, password, private, token)
   - Featured image support
   - Expiration and publishing

2. **Photo Model** (`app/Models/Photo.php`)
   - Spatie Media Library integration
   - Automatic thumbnail generation (thumb, medium, large)
   - Metadata storage (EXIF, dimensions)
   - Publishing control

3. **Migrations**
   - `create_galleries_table.php`
   - `create_photos_table.php`

4. **Storage Strategy Analysis**
   - See `docs/analysis/STORAGE_STRATEGY_ANALYSIS.md`

---

## 🚀 Quick Start for Demo Photography

### **Step 1: Run Migrations**

```bash
php artisan migrate
```

This creates:
- `galleries` table
- `photos` table
- `media` table (if Spatie Media Library migration exists)

### **Step 2: Publish Spatie Media Library Config (Optional)**

```bash
php artisan vendor:publish --tag="medialibrary-config"
```

This creates `config/media-library.php` if you want to customize settings.

### **Step 3: Configure Storage**

**For Demo (Local Storage):**

Update `.env`:
```env
FILESYSTEM_DISK=public
MEDIA_DISK=public
```

**For Production (Cloudflare R2 or S3):**

Update `.env`:
```env
FILESYSTEM_DISK=s3
MEDIA_DISK=s3
AWS_ACCESS_KEY_ID=your_key
AWS_SECRET_ACCESS_KEY=your_secret
AWS_DEFAULT_REGION=auto
AWS_BUCKET=your-bucket
AWS_ENDPOINT=https://your-account-id.r2.cloudflarestorage.com
AWS_USE_PATH_STYLE_ENDPOINT=true
```

### **Step 4: Install Image Driver**

Spatie Media Library needs an image driver:

**Check if GD is installed:**
```bash
php -m | grep -i gd
```

**Or install Imagick (better quality):**
```bash
# macOS
brew install imagemagick
pecl install imagick

# Ubuntu/Debian
sudo apt-get install php-imagick
```

**Configure in `config/media-library.php`:**
```php
'image_driver' => env('MEDIA_IMAGE_DRIVER', 'gd'), // or 'imagick'
```

### **Step 5: Test Photo Upload**

Create a test gallery and upload a photo:

```php
use App\Models\Gallery;
use App\Models\Photo;
use Illuminate\Http\UploadedFile;

// Create gallery
$gallery = Gallery::create([
    'user_id' => 1, // Your user ID
    'name' => 'Demo Gallery',
    'slug' => 'demo-gallery',
    'access_type' => 'public',
    'published_at' => now(),
]);

// Upload photo (example in a controller)
$photo = Photo::create([
    'gallery_id' => $gallery->id,
    'title' => 'Demo Photo',
    'sort_order' => 1,
    'published_at' => now(),
]);

// Add media file
$photo->addMediaFromRequest('photo') // From form upload
    ->toMediaCollection('original');

// Or from UploadedFile
$photo->addMedia($uploadedFile)
    ->toMediaCollection('original');
```

### **Step 6: Display Photos**

In your Blade template:

```blade
@foreach($gallery->photos as $photo)
    <div class="photo-item">
        <img src="{{ $photo->thumbnail_url }}" 
             alt="{{ $photo->title }}"
             data-large="{{ $photo->large_url }}">
        <h3>{{ $photo->title }}</h3>
    </div>
@endforeach
```

---

## 📋 API Usage Examples

### **Create Gallery**

```php
$gallery = Gallery::create([
    'user_id' => auth()->id(),
    'project_id' => $project->id, // Optional: link to Project
    'name' => 'Spring 2024 Photos',
    'slug' => 'spring-2024-photos',
    'description' => 'Spring photography session',
    'access_type' => 'password', // or 'public', 'private', 'token'
    'password_hash' => Hash::make('password123'),
    'expires_at' => now()->addMonths(3),
    'published_at' => now(),
]);
```

### **Upload Photo**

```php
// Method 1: From request
$photo = Photo::create([
    'gallery_id' => $gallery->id,
    'title' => 'Student Photo 001',
    'sort_order' => 1,
]);

$photo->addMediaFromRequest('photo')
    ->usingName('Student Photo 001')
    ->toMediaCollection('original');

// Method 2: From UploadedFile
$photo->addMedia($request->file('photo'))
    ->toMediaCollection('original');

// Method 3: From path
$photo->addMediaFromPath('/path/to/image.jpg')
    ->toMediaCollection('original');
```

### **Access Photo URLs**

```php
$photo = Photo::find(1);

// Get URLs
$photo->url;              // Original
$photo->thumbnail_url;    // 150x150
$photo->medium_url;       // 400px width
$photo->large_url;        // 1200px width

// Or manually
$media = $photo->getFirstMedia('original');
$media->getUrl();         // Original
$media->getUrl('thumb');  // Thumbnail
$media->getUrl('medium'); // Medium
$media->getUrl('large');  // Large
```

### **Check Gallery Access**

```php
$gallery = Gallery::find(1);

// Check if user has access
if ($gallery->userHasAccess(auth()->user(), $password, $token)) {
    // Show gallery
}

// Check if expired
if ($gallery->is_expired) {
    // Gallery expired
}

// Check if published
if ($gallery->is_published) {
    // Gallery is live
}
```

---

## 🔧 Configuration Options

### **Thumbnail Sizes**

Edit conversions in `Photo` model (`registerMediaConversions`):

```php
// Custom sizes
$this->addMediaConversion('custom')
    ->width(800)
    ->height(600)
    ->fit(\Spatie\Image\Enums\Fit::Contain, 800, 600)
    ->sharpen(10);
```

### **Storage Path**

Spatie Media Library organizes files automatically:
```
storage/
  app/
    media/
      1/
        conversions/
          thumb.jpg
          medium.jpg
          large.jpg
        original.jpg
```

Or on S3/R2:
```
media/
  1/
    conversions/
      thumb.jpg
      medium.jpg
      large.jpg
    original.jpg
```

### **Proxy Mode**

To use ImageProxyController for all images:

Update `config/media-library.php` (if published):
```php
'use_proxy' => env('MEDIA_USE_PROXY', false),
```

Or add to Photo model's `getUrlAttribute()` method.

---

## 🐛 Troubleshooting

### **"Class 'Spatie\Image\Enums\Fit' not found"**

Spatie Media Library v11 requires `spatie/image` package:

```bash
composer require spatie/image
```

### **Thumbnails Not Generating**

1. Check image driver is installed:
   ```bash
   php -m | grep -i gd
   ```

2. Check queue is running (if using queue):
   ```bash
   php artisan queue:work
   ```

3. Check permissions:
   ```bash
   chmod -R 775 storage/app/public
   ```

### **Images Not Displaying**

1. Create storage link:
   ```bash
   php artisan storage:link
   ```

2. Check file permissions

3. Check `.env` `APP_URL` is correct

---

## 📚 Next Steps

1. ✅ Models and migrations created
2. ⏭️ Run migrations
3. ⏭️ Upload demo photos
4. ⏭️ Create gallery view pages
5. ⏭️ Test access control
6. ⏭️ Set up production storage (R2/S3)

---

**Last Updated:** 2025-01-27

