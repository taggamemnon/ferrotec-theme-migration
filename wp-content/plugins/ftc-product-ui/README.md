# FTC Product UI

Network-activated product display system for Ferrotec multisite with tabs, charts, and print views.

## Description

This plugin provides a unified product UI system across all Ferrotec subsites with:

- **Product Tabs**: Customizable tabs (Specs, Features, Modeling, Ordering, Downloads, etc.)
- **Feature Flags**: Per-site tab configuration via admin UI
- **Chart.js Integration**: Performance graphs for Thermal products
- **Print View**: Clean product printouts at `?print=1`
- **ACF Integration**: Standardized product fields across all sites
- **Template System**: Category-specific product layouts

## Requirements

- WordPress 6.0+
- PHP 8.0+
- WooCommerce (active)
- Advanced Custom Fields Pro (recommended)
- WP Engine Multisite environment

## Installation

### Network Activation (Multisite)

1. Upload the `ftc-product-ui` folder to `/wp-content/plugins/`
2. Go to **Network Admin → Plugins**
3. Click **Network Activate** for FTC Product UI
4. Go to each subsite's **Settings → FTC Feature Flags** to configure tabs

### Single Site

1. Upload the `ftc-product-ui` folder to `/wp-content/plugins/`
2. Go to **Plugins** and activate **FTC Product UI**
3. Go to **Settings → FTC Feature Flags** to configure tabs

## Features

### Product Tabs

Customize which tabs appear on product pages per subsite:

- **Specs Tab**: Product specifications table
- **Features Tab**: Feature highlights
- **Modeling Tab**: Performance graphs (Thermal site only)
- **Ordering Tab**: Order form
- **Downloads Tab**: CAD files, datasheets
- **Spare Parts Tab**: Replacement parts (Seals site)
- **Quote Tab**: Quote request form
- **CAD Tab**: 3D model viewer

### Feature Flags Admin

Each subsite admin can toggle tabs on/off:

```
Dashboard → Settings → FTC Feature Flags
```

### Print View

Add `?print=1` to any product URL for printable view:

```
https://thermal.ferrotec.com/product/example/?print=1
```

Features:
- Clean layout without navigation
- All tabs displayed sequentially
- Chart.js charts rendered as static images
- Pagination-friendly
- Vector-quality output

### Chart.js Integration

For Thermal products with performance data:

```php
// ACF field: thermal_performance_data (repeater)
$chart_data = get_field( 'thermal_performance_data' );
```

Charts automatically render in:
- Web view (interactive)
- Print view (static images)

## Directory Structure

```
ftc-product-ui/
├── ftc-product-ui.php          # Main plugin file
├── includes/
│   ├── class-ftc-feature-flags.php   # Per-site tab config
│   ├── class-ftc-tabs.php            # Product tabs system
│   ├── class-ftc-attributes.php      # Attribute tables
│   ├── class-ftc-shortcodes.php      # Product shortcodes
│   ├── class-ftc-print-view.php      # Print functionality
│   ├── class-ftc-charts.php          # Chart.js integration
│   └── helpers.php                   # Utility functions
├── admin/
│   ├── class-ftc-admin.php           # Admin settings
│   └── views/
│       └── feature-flags.php         # Feature flag UI
├── templates/
│   ├── tabs/                         # Tab templates
│   ├── listings/                     # Product listings
│   ├── single-product/               # Product templates
│   └── print/                        # Print templates
├── assets/
│   ├── css/                          # Plugin styles
│   └── js/                           # Plugin scripts
├── migrations/                       # ACF field migration scripts
└── acf-json/                         # ACF field groups
```

## ACF Field Groups

Included ACF field groups (in `acf-json/`):

- **Shared Product Fields**: Common to all products
  - `product_model` - Model number
  - `product_cad_file` - CAD file download
  - `product_datasheet` - PDF datasheet

- **Thermal Product Fields**: Thermal-specific
  - `thermal_performance_data` - Chart data repeater
  - `thermal_modeling_content` - Modeling tab content

- **Ferrofluid Product Fields**: Ferrofluid-specific
  - `ferrofluid_saturation_gauss` - Saturation (Gauss)
  - `ferrofluid_viscosity_cp` - Viscosity (cP)

- **Seal Product Fields**: Seal-specific
  - `seal_shaft_type` - Shaft type dropdown
  - `seal_mount_type` - Mount type dropdown

## Shortcodes

### [show_meivac_products]

Display MEI VAC product listing:

```
[show_meivac_products category="sputter-targets"]
```

### [ferrofluid_products]

Display ferrofluid products table:

```
[ferrofluid_products family="audio"]
```

## Hooks & Filters

### Actions

```php
// Before/after product tabs
do_action( 'ftc_before_product_tabs' );
do_action( 'ftc_after_product_tabs' );

// Before/after specs table
do_action( 'ftc_before_specs_table' );
do_action( 'ftc_after_specs_table' );
```

### Filters

```php
// Modify available tabs
add_filter( 'ftc_available_tabs', 'my_custom_tabs' );

// Modify tab content
add_filter( 'ftc_tab_content', 'my_custom_tab_content', 10, 2 );

// Modify print view
add_filter( 'ftc_print_template', 'my_custom_print_template' );
```

## Configuration

### Per-Site Tab Configuration

**Thermal (thermal.ferrotec.com)**
```
✓ Specs
✓ Features
✓ Modeling (UNIQUE)
✓ Ordering
✓ Downloads
✓ Print View
```

**Seals (seals.ferrotec.com)**
```
✓ Specs
✓ Features
✓ Ordering
✓ Downloads
✓ Spare Parts (UNIQUE)
✓ Print View
```

**Info Sites (www, quartz, ceramics, temescal)**
```
✓ Specs
✓ Features
✗ Ordering (no e-commerce)
✓ Downloads
```

## Development

### Testing

```bash
# Check plugin syntax
php -l ftc-product-ui.php

# Check all PHP files
find . -name "*.php" -exec php -l {} \;
```

### WP-CLI Commands

```bash
# Network activate
wp plugin activate ftc-product-ui --network

# Check plugin status
wp plugin status ftc-product-ui

# Run ACF field migration
wp ftc migrate-fields --url=thermal.ferrotec.com --dry-run
wp ftc migrate-fields --url=thermal.ferrotec.com --execute
```

## Support

For issues and questions:
- GitHub: https://github.com/taggamemnon/ferrotec-theme-migration
- Email: support@ferrotec.com

## License

GPL v2 or later

## Changelog

### 1.0.0 (2026-01-01)
- Initial release
- Network activation support
- Feature flag system
- Product tabs (8 types)
- Chart.js integration
- Print view functionality
- ACF field standardization
- Template hierarchy system

## Credits

Developed by Tagg Swift for Ferrotec Corporation
Built on WordPress, WooCommerce, and Chart.js
