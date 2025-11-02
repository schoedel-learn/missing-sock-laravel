# Import Demo Photos Guide

**Date:** 2025-01-27  
**Status:** Ready to import 67 demo photos

---

## 🚀 Quick Start

You have **67 demo photos** ready to import from Adobe Stock. Here's how to set them up:

### **Step 1: Run Migrations**

First, make sure the database tables exist:

```bash
php artisan migrate
```

This will create:
- `galleries` table
- `photos` table
- (Media table should be created automatically by Spatie)

### **Step 2: Ensure You Have a User**

You need at least one user in the database. If you don't have one:

```bash
php artisan tinker
```

Then:
```php
User::create([
    'name' => 'Admin',
    'email' => 'admin@example.com',
    'password' => Hash::make('password'),
]);
```

### **Step 3: Import Demo Photos**

Run the import command:

```bash
php artisan photos:import-demo
```

This will:
- ✅ Create a demo gallery
- ✅ Import all 67 photos
- ✅ Generate thumbnails automatically (thumb, medium, large)
- ✅ Extract metadata (dimensions, EXIF if available)
- ✅ Set proper ordering

### **Step 4: View Your Gallery**

After import, you'll see:
- Gallery ID
- Gallery Slug
- View URL

Access your gallery at: `http://localhost:8000/galleries/{slug}`

---

## ⚙️ Command Options

### **Basic Import**
```bash
php artisan photos:import-demo
```

### **Custom Gallery Name**
```bash
php artisan photos:import-demo --gallery-name="Spring 2024 Session"
```

### **Import into Existing Gallery**
```bash
php artisan photos:import-demo --gallery-id=1
```

### **Specify User**
```bash
php artisan photos:import-demo --user-id=1
```

### **Custom Path**
```bash
php artisan photos:import-demo --path=storage/app/public/my-photos
```

---

## 📋 What Happens During Import

1. **Creates Gallery** (if not using existing)
   - Name: "Demo Gallery" (or custom)
   - Slug: auto-generated
   - Access: Public
   - Published: Immediately

2. **Creates Photo Records**
   - One Photo model per image file
   - Title: Generated from filename
   - Sort order: Sequential (1, 2, 3...)
   - Published: Immediately

3. **Uploads Media Files**
   - Uses Spatie Media Library
   - Stores in `storage/app/media/{photo_id}/`
   - Generates thumbnails automatically

4. **Extracts Metadata**
   - File size
   - Dimensions (width/height)
   - MIME type
   - EXIF data (if available)

---

## 🎨 Photo Organization

Photos are imported in alphabetical order by filename. You can reorder them later by updating the `sort_order` field:

```php
$photo = Photo::find(1);
$photo->update(['sort_order' => 10]);
```

---

## 🔍 Troubleshooting

### **"Migrations not run"**
```bash
php artisan migrate
```

### **"No users found"**
Create a user first (see Step 2 above)

### **"No image files found"**
Check that photos are in:
```
storage/app/public/demo-photos/
```

### **Thumbnails Not Generating**
1. Check image driver is installed:
   ```bash
   php -m | grep -i gd
   ```

2. If using queue, make sure queue worker is running:
   ```bash
   php artisan queue:work
   ```

### **Import Fails on Specific Photo**
The command will continue importing other photos. Check the error message for the specific file that failed.

---

## 📊 After Import

### **View Gallery**
```php
$gallery = Gallery::find(1);
$photos = $gallery->photos;

foreach ($photos as $photo) {
    echo $photo->title . "\n";
    echo $photo->thumbnail_url . "\n";
    echo $photo->medium_url . "\n";
    echo $photo->large_url . "\n";
}
```

### **Get Photo URLs**
```php
$photo = Photo::find(1);

// Access URLs
$photo->url;              // Original
$photo->thumbnail_url;    // 150x150
$photo->medium_url;       // 400px width
$photo->large_url;        // 1200px width
```

### **Re-import**
If you want to import again:
- Delete existing gallery: `Gallery::find(1)->delete();`
- Or import into a new gallery: `php artisan photos:import-demo --gallery-name="New Gallery"`

---

## ✅ Next Steps

After importing:
1. ✅ Test gallery viewing
2. ✅ Verify thumbnails are generated
3. ✅ Check photo URLs work
4. ✅ Create gallery view pages
5. ✅ Set up access control if needed

---

**Last Updated:** 2025-01-27

