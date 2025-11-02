# Directory Organization Plan

## ✅ Completed Actions

1. **Created Directory Structure:**
   - `docs/migration/` - JotForm migration documentation
   - `docs/analysis/` - Analysis and comparison documents
   - `docs/setup/` - Setup and troubleshooting guides
   - `assets/logos/` - Logo files
   - `assets/images/` - General images
   - `assets/graphics/` - Graphics and design assets

2. **Moved Files:**
   - All `JOTFORM_*.md` files → `docs/migration/`
   - `PROMPT_COMPARISON_*.md` → `docs/analysis/`
   - `ARCHITECTURE_CONSISTENCY.md` → `docs/analysis/`
   - `SETUP_GUIDE.md` → `docs/setup/`
   - `TROUBLESHOOTING.md` → `docs/setup/`
   - `README.md` → `docs/`
   - `prompt from co-pilot.txt` → `docs/analysis/`
   - `LOGO_LOGOLARGE-74.webp` → `assets/logos/`

3. **Created Brand Config:**
   - `config/brand.php` - Centralized brand configuration

## 📋 Next Steps - Recommendations

### 1. **Logo Organization**
Create a standardized logo structure:

```
assets/logos/
├── primary/
│   ├── logo-full-color.svg
│   ├── logo-full-color.png
│   └── logo-full-color.webp
├── white/
│   ├── logo-white.svg
│   └── logo-white.png
├── dark/
│   ├── logo-dark.svg
│   └── logo-dark.png
└── icons/
    ├── favicon.ico
    ├── favicon-32x32.png
    ├── favicon-16x16.png
    └── apple-touch-icon.png
```

### 2. **Color Palette Update**
Once you provide the hex values, we should:
- Update `config/brand.php` with correct values
- Update `tailwind.config.js` to match
- Update `resources/css/app.css` CSS variables
- Ensure all three are synchronized

### 3. **Graphics Organization**
Move graphics from `missing-sock-photos/tms-graphics/` to:
```
assets/graphics/
├── testimonials/
├── backgrounds/
└── icons/
```

### 4. **Duplicate Directory Cleanup**
Decide what to do with:
- `missing-sock-photos/` - Contains duplicate app structure
- `schoedel-photo-app/` - Another duplicate structure
- `missing-sock-colors/` - Empty directory

**Recommendation:** 
- Archive or remove duplicate directories
- Keep only the main project structure

### 5. **Asset Linking**
After organizing assets:
- Create symbolic links from `public/assets` to `storage/app/public/assets`
- Update all references in code to use config values
- Document asset paths in `docs/`

## 🎨 Brand Configuration Usage

Once colors are provided, update the config like this:

```php
// In Blade templates
$primaryColor = config('brand.colors.primary.blue');

// In JavaScript
const primaryColor = '{{ config('brand.colors.primary.blue') }}';

// In CSS (via PHP)
:root {
  --primary-blue: {{ config('brand.colors.primary.blue') }};
}
```

## 📝 Documentation Structure

```
docs/
├── README.md                    # Main project README
├── migration/                   # JotForm migration docs
│   ├── JOTFORM_01_OVERVIEW.md
│   ├── JOTFORM_04_CONDITIONAL_LOGIC.md
│   ├── JOTFORM_08_BRANDING_UI.md
│   └── ...
├── analysis/                    # Analysis documents
│   ├── PROMPT_COMPARISON_ANALYSIS.md
│   ├── PROMPT_COMPARISON_SUMMARY.md
│   ├── ARCHITECTURE_CONSISTENCY.md
│   └── prompt from co-pilot.txt
└── setup/                       # Setup guides
    ├── SETUP_GUIDE.md
    └── TROUBLESHOOTING.md
```

## 🔄 File References to Update

After moving files, update references in:
- [ ] `README.md` (if it references other docs)
- [ ] Any code that references logo paths
- [ ] Any documentation that references other docs
- [ ] `.gitignore` if needed

