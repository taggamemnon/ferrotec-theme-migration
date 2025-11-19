# ACF Field Migration Scripts

This directory contains scripts for migrating old ACF field names to the new unified schema.

## Overview

The Ferrotec multisite migration consolidates multiple child themes into a single unified theme with a centralized plugin (`ftc-product-ui`). Part of this migration involves standardizing ACF field names across all subsites.

## Files

- **`field-migration-map.php`** - Maps old field names to new unified names
- **`01-rename-fields.php`** - WP-CLI script to perform field renaming
- **`02-validate-migration.php`** - WP-CLI script to validate migration
- **`README.md`** - This file

## Prerequisites

- WP-CLI installed on server
- Database backup completed
- Staging environment for testing
- ACF Pro active on all subsites

## Migration Process

### Step 1: Backup

**CRITICAL: Always backup before running migration scripts!**

```bash
# Database backup (all subsites)
wp db export backup-$(date +%Y%m%d-%H%M%S).sql

# Export all products to CSV (safety net)
wp post list --post_type=product --format=csv > products-backup.csv

# Document current ACF field groups
wp acf export --path=acf-backup/
```

### Step 2: Dry Run (Preview)

Test on staging first with dry-run mode:

```bash
# Single site dry run
wp ftc migrate-fields --dry-run --verbose

# Multisite dry run (specific site)
wp ftc migrate-fields --dry-run --verbose --url=thermal.ferrotec.com

# Multisite dry run (all sites)
wp ftc migrate-fields --dry-run --verbose --network
```

**Review the output carefully before proceeding!**

### Step 3: Execute Migration

Run the actual migration:

```bash
# Single site
wp ftc migrate-fields --verbose

# Multisite (specific site)
wp ftc migrate-fields --verbose --url=thermal.ferrotec.com

# Multisite (all sites) - use with caution!
wp ftc migrate-fields --verbose --network
```

### Step 4: Validate

Verify migration completed successfully:

```bash
# Validation report
wp ftc validate-migration --verbose

# Export validation report to CSV
wp ftc validate-migration --format=csv > migration-report.csv

# Export validation report to JSON
wp ftc validate-migration --format=json > migration-report.json
```

### Step 5: Field Statistics

Check field usage statistics:

```bash
wp ftc field-stats
```

## Migration Map

The migration map (`field-migration-map.php`) defines:

- **Old field name** - Original field name from child themes
- **New field name** - Unified standardized field name
- **Sites** - Which subsites use this field
- **Product categories** - Which product categories use this field
- **Transform function** - Optional data transformation (e.g., boolean conversion)

Example mapping:

```php
'iMax' => array(
    'new_name'     => 'thermal_current_max',
    'sites'        => array( 'thermal' ),
    'product_cats' => array( 'thermal-modules', 'peltier-coolers' ),
    'description'  => 'Maximum Current (Amps)',
),
```

## Field Naming Convention

New field names follow this pattern:

- **`product_*`** - Shared across all product types
- **`thermal_*`** - Thermal electric products only
- **`seal_*`** - Vacuum feedthrough/seal products only
- **`ferrofluid_*`** - Ferrofluid products only
- **`meivac_*`** - MEI VAC products only
- **`page_*`** - Page-level fields (banners, layout)
- **`resource_*`** - Resources/events/news

## Rollback

If migration fails or causes issues:

### Option 1: Database Restore

```bash
# Restore from backup
wp db import backup-YYYYMMDD-HHMMSS.sql
```

### Option 2: Manual Rollback (if needed)

```php
// Get reverse mapping
$reverse_map = ftc_get_reverse_migration_map();

// Manually update postmeta table
UPDATE wp_postmeta
SET meta_key = 'old_field_name'
WHERE meta_key = 'new_field_name';
```

## Site-Specific Migration

### Thermal (thermal.ferrotec.com)

**Recommended:** Migrate Thermal first as baseline

```bash
wp ftc migrate-fields --verbose --url=thermal.ferrotec.com
wp ftc validate-migration --url=thermal.ferrotec.com
```

**Key fields:**
- Performance specs: `iMax`, `vMax`, `tMax`, `qcMax` → `thermal_*`
- Dimensions: `baseW`, `baseL`, `topW`, `topL`, `hDim` → `thermal_*`
- Part number: `fullPN` → `product_model`

### Seals (seals.ferrotec.com)

```bash
wp ftc migrate-fields --verbose --url=seals.ferrotec.com
wp ftc validate-migration --url=seals.ferrotec.com
```

**Key fields:**
- Model/Part: `mNum`, `pNum` → `seal_model_number`, `product_model`
- Dimensions: `d1`-`d45` → `seal_*`
- Features: `f1`-`f5`, `b1`-`b3` → `seal_feature_*`, `seal_support_*`

### Ferrofluid (ferrofluid.ferrotec.com)

```bash
wp ftc migrate-fields --verbose --url=ferrofluid.ferrotec.com
wp ftc validate-migration --url=ferrofluid.ferrotec.com
```

**Key fields:**
- Magnetic: `sat_guass` (typo fixed!) → `ferrofluid_saturation_gauss`
- Physical: `vis_cp`, `den_g_ml` → `ferrofluid_viscosity_cp`, `ferrofluid_density_gml`

### MEI VAC (meivac.ferrotec.com)

```bash
wp ftc migrate-fields --verbose --url=meivac.ferrotec.com
wp ftc validate-migration --url=meivac.ferrotec.com
```

**Key fields:**
- CAD: `step_file` → `product_cad_file`
- Vari-Q: `vari-q_*` → `meivac_vari_q_*`

## Troubleshooting

### Error: "Field already exists"

**Cause:** New field name already has data (potential conflict)

**Solution:**
1. Check if existing data is valid
2. Manually merge data if needed
3. Skip conflicting field in migration map

### Error: "Transaction rollback"

**Cause:** Database error during migration

**Solution:**
1. Check database logs: `wp db query "SHOW ENGINE INNODB STATUS"`
2. Verify database has sufficient storage
3. Check for table locks: `wp db query "SHOW PROCESSLIST"`

### Warning: "Partial Migration"

**Cause:** Some records migrated, some didn't

**Solution:**
1. Run validation: `wp ftc validate-migration --verbose`
2. Identify orphaned records
3. Manually complete migration or re-run script

## Testing Checklist

After migration, verify:

- [ ] All product pages display correctly
- [ ] Product specifications show correct data
- [ ] Product dimensions accurate
- [ ] CAD files downloadable
- [ ] Charts render (thermal products)
- [ ] No PHP errors in logs
- [ ] Search functionality works
- [ ] Product listings display correctly
- [ ] WooCommerce checkout unaffected
- [ ] Print view works

## Performance Considerations

- **Large datasets:** Migration may take several minutes
- **Timeouts:** Increase PHP `max_execution_time` if needed
- **Memory:** Ensure sufficient PHP `memory_limit` (256MB+)
- **Indexes:** Database indexes will be preserved during UPDATE operations

## Timeline

**Week 1 (Nov 19-20):** ACF field audit (COMPLETE)
**Week 2 (Nov 25-27):** Thermal baseline migration
**Week 3 (Dec 2-8):** Seals, Ferrofluid, MEI VAC migration
**Week 5 (Dec 16-22):** Final ACF migration across all sites

## Support

For issues or questions:
1. Check `ACF_FIELD_MAPPING.md` for field documentation
2. Review `ACF_UNIFIED_SCHEMA.md` for new schema
3. Check migration logs: `wp ftc validate-migration --format=json`
4. Contact development team

---

**Last Updated:** 2025-11-19
**Version:** 1.0.0
