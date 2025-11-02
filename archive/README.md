# Archived Directories

This directory contains archived duplicate directories and folders that don't fit the current project structure.

## Archived on: 2025-11-01

### Archived Directories

1. **missing-sock-photos/**
   - Reason: Duplicate app structure with its own app/, resources/, routes/
   - Contains: Duplicate Laravel application files
   - Note: Graphics files were preserved in `assets/graphics/`

2. **missing-sock-colors/**
   - Reason: Empty directory, no longer needed

3. **schoedel-photo-app/**
   - Reason: Duplicate Laravel application structure
   - Contains: Another complete Laravel project instance

## Recovery

If you need to recover files from these archives:
```bash
# Extract specific files
tar -czf archive/recovery.tar.gz archive/20251101/
# Or copy specific directories back
cp -r archive/20251101/directory-name ./
```

## Cleanup

These archives can be removed after confirming:
- No unique code exists in these directories
- All assets have been moved to proper locations
- No configuration unique to these directories is needed

**Recommendation:** Review after 30 days, then delete if not needed.

