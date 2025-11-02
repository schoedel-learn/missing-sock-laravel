# Download Management Package Options

**Date:** 2025-01-27  
**Context:** Need for secure token-based download system with expiration and tracking

---

## 🎯 Requirements

Based on the reference implementation, we need:
- Secure token-based downloads (HMAC-signed)
- Expiring download links (default 7 days)
- Download attempt tracking
- Batch download (ZIP archive) generation
- Access control per user/order
- Download analytics

---

## 📦 Package Options

### **Option 1: Spatie Laravel Media Library (Already Installed!)**

**Status:** ✅ **Already Installed** (`spatie/laravel-medialibrary` v11.0)

**Built-in Download Features:**
- ✅ Stream multiple files as ZIP (on-the-fly, no storage needed)
- ✅ Temporary download URLs
- ✅ File access via models
- ✅ Storage abstraction (works with S3/local)

**What It Provides:**
```php
// Stream multiple files as ZIP
$mediaItems = Photo::all()->pluck('media')->flatten();
return MediaStream::create('photos.zip')->addMedia($mediaItems);

// Temporary URLs (if using S3)
$url = $photo->getFirstMedia('original')->getTemporaryUrl(now()->addDays(7));
```

**What's Missing:**
- ❌ No built-in secure token system (HMAC-signed)
- ❌ No download attempt tracking
- ❌ No expiration handling (for local storage)
- ❌ No download link management
- ❌ No per-user/order access control tracking

**Verdict:** Great for file access, but you'd still need to build:
- Download model for tracking
- Token generation and validation
- Attempt tracking
- Access control middleware

---

### **Option 2: Laravel Signed URLs (Built-in)**

**Status:** ✅ **Built-in Laravel Feature** (No package needed!)

**What It Provides:**
```php
// Generate signed URL
$url = URL::temporarySignedRoute(
    'downloads.photo',
    now()->addDays(7),
    ['photo' => $photo->id]
);

// Validate in route
Route::get('/downloads/{photo}', function (Request $request, Photo $photo) {
    if (!$request->hasValidSignature()) {
        abort(401);
    }
    // Serve file
})->name('downloads.photo');
```

**Features:**
- ✅ Built-in HMAC signing
- ✅ Expiration support
- ✅ Validation middleware
- ✅ No dependencies

**What's Missing:**
- ❌ No download attempt tracking (need custom model)
- ❌ No download link management
- ❌ No analytics/tracking built-in
- ❌ No batch ZIP generation (need custom)

**Verdict:** Perfect foundation! You'd add:
- Download model for tracking attempts
- DownloadService wrapper
- Batch ZIP generation (can use Spatie Media Library for this)

---

### **Option 3: Custom Implementation (Recommended Approach)**

**Status:** ⚠️ **Recommended** - Combine Laravel Signed URLs + Spatie Media Library

**Why This Works Best:**
1. **Laravel Signed URLs** - Handles secure token generation/validation
2. **Spatie Media Library** - Handles file access and ZIP generation
3. **Custom Download Model** - Tracks attempts, expiration, access control

**Architecture:**
```
User requests download
  ↓
Generate signed URL (Laravel)
  ↓
Store Download record (track attempts, expiration)
  ↓
Validate signed URL (Laravel middleware)
  ↓
Check Download record (access control, attempts)
  ↓
Serve file (Spatie Media Library)
  ↓
Track download attempt
```

**Implementation Complexity:** Medium
**Maintenance:** Low (uses Laravel built-ins)
**Flexibility:** High (full control)

---

### **Option 4: Third-Party Packages**

#### **A. laravel-download-link**
- Simple download link generation
- Basic expiration
- ⚠️ Limited features, may not be actively maintained

#### **B. laravel-secure-downloads**
- Secure download handling
- Token-based access
- ⚠️ May not have all features needed

#### **C. Digital Product Packages**
- Some e-commerce packages include download management
- Often overkill for photo galleries
- ⚠️ Too heavy, includes shopping cart, payments, etc.

**Verdict:** Most third-party packages are either too simple or too complex. Custom implementation using Laravel built-ins is better.

---

## 🏆 **Recommendation: Hybrid Approach**

### **Use Laravel Signed URLs + Spatie Media Library + Custom Download Model**

**Why:**
1. ✅ **Laravel Signed URLs** - Built-in, secure, well-tested
2. ✅ **Spatie Media Library** - Already installed, handles files/ZIP
3. ✅ **Custom Download Model** - Tracks attempts, expiration, analytics
4. ✅ **No additional packages** - Uses what you already have
5. ✅ **Full control** - Implement exactly what you need

---

## 🏗️ **Recommended Implementation**

### **Step 1: Create Download Model**

```php
// app/Models/Download.php
class Download extends Model
{
    protected $fillable = [
        'photo_id',
        'order_id',
        'user_id',
        'token_hash', // Hashed version of signed URL token
        'expires_at',
        'max_attempts',
        'attempts',
        'last_attempted_at',
        'downloaded_at',
    ];
    
    public function photo() { return $this->belongsTo(Photo::class); }
    public function order() { return $this->belongsTo(Order::class); }
    public function user() { return $this->belongsTo(User::class); }
    
    public function isExpired(): bool { ... }
    public function canDownload(): bool { ... }
    public function recordAttempt(): void { ... }
}
```

### **Step 2: Create DownloadService**

```php
// app/Services/DownloadService.php
class DownloadService
{
    public function generateDownloadLink(Photo $photo, Order $order): string
    {
        // Create Download record
        $download = Download::create([...]);
        
        // Generate Laravel signed URL
        return URL::temporarySignedRoute(
            'downloads.photo',
            now()->addDays(7),
            [
                'photo' => $photo->id,
                'order' => $order->id,
                'download' => $download->id,
            ]
        );
    }
    
    public function generateBatchDownloadLink(Order $order): string
    {
        // Similar but for ZIP download
        return URL::temporarySignedRoute(
            'downloads.batch',
            now()->addDays(7),
            ['order' => $order->id]
        );
    }
    
    public function serveDownload(Request $request, Photo $photo): Response
    {
        // Validate signed URL (Laravel middleware)
        // Check Download record
        // Track attempt
        // Serve file via Spatie Media Library
    }
    
    public function serveBatchDownload(Request $request, Order $order): Response
    {
        // Use Spatie Media Library's MediaStream for ZIP
        $photos = $order->photos; // via OrderItem relationship
        $mediaItems = $photos->pluck('media')->flatten();
        
        return MediaStream::create("order-{$order->order_number}.zip")
            ->addMedia($mediaItems);
    }
}
```

### **Step 3: Use Spatie Media Library for ZIP**

```php
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\MediaStream;

// In DownloadService
public function generateZip(Order $order): MediaStream
{
    $photos = $order->photos;
    $mediaItems = $photos->map(fn($photo) => $photo->getFirstMedia('original'))->filter();
    
    return MediaStream::create("order-{$order->order_number}.zip")
        ->addMedia($mediaItems);
}
```

---

## ✅ **Final Recommendation**

**Use:** Laravel Signed URLs + Spatie Media Library + Custom Download Model

**Why:**
- No additional packages needed
- Uses Laravel built-ins (secure, maintained)
- Leverages Spatie Media Library (already installed)
- Full control over features
- Easy to customize

**Implementation Steps:**
1. Create `Download` model and migration
2. Create `DownloadService` using Laravel Signed URLs
3. Use Spatie Media Library's `MediaStream` for ZIP downloads
4. Add routes with signed URL validation
5. Track downloads in Download model

**Estimated Effort:** 4-6 hours for full implementation

---

## 📚 **Resources**

- **Laravel Signed URLs:** https://laravel.com/docs/routing#signed-urls
- **Spatie Media Library Downloads:** https://spatie.be/docs/laravel-medialibrary/v11/downloading-media/downloading-multiple-files
- **Laravel Media Stream:** Part of Spatie Media Library

---

**Last Updated:** 2025-01-27

