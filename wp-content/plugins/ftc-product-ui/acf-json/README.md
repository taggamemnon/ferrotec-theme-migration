# ACF Field Groups - Plugin (Product Data)

This directory contains ACF field groups for **product data fields** only.

## ⚠️ Important: Field Separation

**PLUGIN fields (this directory):**
- Product specifications (thermal, seal, ferrofluid, meivac)
- Product files (CAD, datasheets, manuals)
- Performance data, dimensions
- Features, benefits, applications
- Ordering information

**THEME fields** (`/wp-content/themes/layers2025/acf-json/`):
- Page banners (images, colors, text)
- Flexible content rows (page layout)
- Resource/event display fields
- Theme-specific presentation logic

## Field Groups Stored Here

### `group_shared_product_fields.json`

**Applied to:** ALL WooCommerce products

Product identification and common fields:
- `product_model` - Product model/part number
- `product_legacy_model` - Legacy model number
- `product_features` - Product features (WYSIWYG)
- `product_benefits` - Product benefits (WYSIWYG)
- `product_applications` - Applications and use cases
- `product_additional_specs` - Additional specifications
- `product_datasheet` - Datasheet PDF file
- `product_cad_file` - CAD file (STEP/STP)
- `product_drawing` - Technical drawing
- `product_manual` - User manual
- `product_certificate` - Certificate of compliance
- `product_additional_files` - Additional downloadable files (repeater)
- `product_ordering_info` - Ordering information
- `product_lead_time` - Lead time text
- `product_min_order_quantity` - Minimum order quantity
- `product_quote_required` - Quote required flag

**Location Rule:** `post_type == 'product'`

### `group_thermal_product_fields.json`

**Applied to:** Thermal electric products only

Thermal performance specifications:
- `thermal_current_max` - Maximum Current (Imax) in Amps
- `thermal_voltage_max` - Maximum Voltage (Vmax) in Volts
- `thermal_delta_t_max` - Maximum Temperature Difference (ΔTmax) in °C
- `thermal_cooling_capacity_max` - Maximum Cooling Capacity (Qcmax) in Watts

Thermal dimensions:
- `thermal_base_width` - Base width in mm
- `thermal_base_length` - Base length in mm
- `thermal_top_width` - Top width in mm
- `thermal_top_length` - Top length in mm
- `thermal_height` - Module height in mm

Modeling & Charts:
- `thermal_performance_data` - Performance curve datasets (repeater for Chart.js)
  - `dataset_label` - Label for this dataset
  - `x_values` - Comma-separated X values
  - `y_values` - Comma-separated Y values
  - `x_axis_label` - X axis label
  - `y_axis_label` - Y axis label
  - `line_color` - Chart line color
- `thermal_modeling_content` - Modeling tab introduction
- `thermal_modeling_notes` - Modeling notes/disclaimers

**Location Rules:**
- `post_type == 'product'` AND `product_cat == 'thermal-modules'`
- OR `post_type == 'product'` AND `product_cat == 'peltier-coolers'`

## Future Field Groups (To Be Created)

### `group_seal_product_fields.json`
- Vacuum feedthrough and seal specifications
- Shaft types, mounting, environment ratings
- Dimensional data (d1-d45)
- Spare parts (repeater)

### `group_ferrofluid_product_fields.json`
- Magnetic properties (saturation gauss, saturation mT)
- Physical properties (viscosity, density)
- Chemical properties (flash point, fluid type)

### `group_meivac_product_fields.json`
- MEI VAC product specifications
- Vari-Q parameters
- Custom product fields

## Why Separate Plugin & Theme Fields?

### Advantages

1. **Portability**: Product data remains independent of theme
2. **Theme Swapping**: Change theme without affecting product structure
3. **Version Control**: Track product data changes separately from presentation
4. **Deployment**: Update theme without touching product data
5. **Clarity**: Clear separation of concerns (data vs. presentation)

### How It Works

Both theme and plugin register ACF JSON save/load points:

```php
// THEME (functions.php) - Priority 5
add_filter( 'acf/settings/save_json', 'layers2025_acf_json_save_point', 5 );
add_filter( 'acf/settings/load_json', 'layers2025_acf_json_load_point', 5 );

// PLUGIN (ftc-product-ui.php) - Priority 10
add_filter( 'acf/settings/save_json', array( $this, 'acf_json_save_point' ), 10 );
add_filter( 'acf/settings/load_json', array( $this, 'acf_json_load_point' ), 10 );
```

**Result:** ACF loads field groups from BOTH locations with no conflicts.

## Usage in Templates

### Accessing Product Fields

```php
// In tab templates (specs.php, features.php, etc.)
global $product;
$product_id = $product->get_id();

// Shared fields (all products)
$model = get_field( 'product_model', $product_id );
$datasheet = get_field( 'product_datasheet', $product_id );
$features = get_field( 'product_features', $product_id );

// Thermal fields (thermal products only)
$imax = get_field( 'thermal_current_max', $product_id );
$vmax = get_field( 'thermal_voltage_max', $product_id );
$performance_data = get_field( 'thermal_performance_data', $product_id );
```

## Migration

These field groups will be populated during Week 2-3 migrations:

**Week 2 (Thermal Baseline):** Test with thermal products
**Week 3 (High-Priority Sites):** Create seal, ferrofluid, MEI VAC field groups
**Week 5 (Final Migration):** Complete ACF migration across all sites

See `migrations/README.md` for migration scripts and process.

---

**Last Updated:** 2025-11-19
**Version:** 1.0.0
