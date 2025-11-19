# Ferrotec Multisite Theme Migration - Refactored Plan

## Project Alignment

This refactored plan aligns the current implementation with the original project brief requirements.

---

## Environment Clarification Needed

**CRITICAL: Determine actual architecture**

- [ ] Is this a WP Engine multisite with 10 subsites? (Original brief)
- [ ] OR is this a single site with 5 product-line themes? (Current docs)
- [ ] Identify all 10 subsites mentioned in original brief

**Current child themes found (5):**
1. child-corporate
2. child-ferrofluid
3. child-meivac
4. child-seals
5. child-thermalelectric

**Missing subsites (5 more if multisite):**
- Quartz?
- Ceramics?
- Others?

**Action Required:** Audit actual WP Engine environment to confirm architecture.

---

## Phase 0: Architecture Audit & Field Standardization (2–3 weeks)

### Week 1-2: Environment & Field Audit

**Tasks:**
- [ ] **Confirm multisite architecture** (vs single site with child themes)
- [ ] Document all 10 subsites (if multisite) or confirm single-site approach
- [ ] Audit current Bootstrap version per site (BS3 vs BS4 conflicts documented)
- [ ] Create performance baseline metrics for each site
- [ ] Document all Woo template overrides per site

### Week 2-3: ACF Field Standardization ⭐ **CRITICAL MISSING PHASE**

**ACF Field Mapping Audit:**

**Step 1: Field Discovery Across All Sites**
```sql
-- Query to find all ACF field variations
SELECT DISTINCT meta_key, post_type, COUNT(*) as usage_count
FROM wp_postmeta
WHERE meta_key LIKE '%field_%'
GROUP BY meta_key, post_type
ORDER BY post_type, meta_key;
```

**Step 2: Document Field Name Variations**

Create spreadsheet mapping:

| Data Type | Site 1 (Thermal) | Site 2 (Seals) | Site 3 (Ferrofluid) | Unified Name | Data Type |
|-----------|------------------|----------------|---------------------|--------------|-----------|
| CAD File | `step_file` | `cad_download` | `step_model` | `product_cad_file` | file |
| Model Number | `model` | `part_number` | `model_number` | `product_model` | text |
| Saturation (Gauss) | - | - | `sat_guass` ← typo | `ferrofluid_saturation_gauss` | number |
| Viscosity | - | - | `vis_cp` | `ferrofluid_viscosity_cp` | number |
| Shaft Type | - | `shaft_type` | - | `seal_shaft_type` | select |
| Mount Type | - | `mount_type` | - | `seal_mount_type` | select |
| Performance Data | `te_perf_data` | - | - | `thermal_performance_data` | repeater |
| Modeling Tab Content | `modeling_content` | - | - | `thermal_modeling_content` | wysiwyg |

**Step 3: Create Unified Field Schema**

**Shared Product Fields (All Sites):**
```php
// wp-content/plugins/ftc-product-ui/acf-json/group_shared_product_fields.json
{
    "key": "group_shared_product",
    "title": "Shared Product Fields",
    "fields": [
        {
            "key": "field_product_model",
            "label": "Model Number",
            "name": "product_model",
            "type": "text"
        },
        {
            "key": "field_product_cad_file",
            "label": "CAD File (STEP)",
            "name": "product_cad_file",
            "type": "file"
        },
        {
            "key": "field_product_datasheet",
            "label": "Datasheet PDF",
            "name": "product_datasheet",
            "type": "file"
        }
    ]
}
```

**Thermal-Specific Fields:**
```php
// group_thermal_product_fields.json
{
    "key": "group_thermal_product",
    "title": "Thermal Electric Product Fields",
    "fields": [
        {
            "key": "field_thermal_performance_data",
            "label": "Performance Data",
            "name": "thermal_performance_data",
            "type": "repeater"
        },
        {
            "key": "field_thermal_modeling_content",
            "label": "Modeling Tab Content",
            "name": "thermal_modeling_content",
            "type": "wysiwyg"
        }
    ],
    "location": [
        [{
            "param": "post_type",
            "operator": "==",
            "value": "product"
        },
        {
            "param": "product_cat",
            "operator": "==",
            "value": "thermal-modules"
        }]
    ]
}
```

**Ferrofluid-Specific Fields:**
```php
// group_ferrofluid_product_fields.json
{
    "key": "group_ferrofluid_product",
    "title": "Ferrofluid Product Fields",
    "fields": [
        {
            "key": "field_ferrofluid_saturation_gauss",
            "label": "Saturation (Gauss)",
            "name": "ferrofluid_saturation_gauss",
            "type": "number"
        },
        {
            "key": "field_ferrofluid_saturation_mt",
            "label": "Saturation (mT)",
            "name": "ferrofluid_saturation_mt",
            "type": "number"
        },
        {
            "key": "field_ferrofluid_viscosity_cp",
            "label": "Viscosity (cP)",
            "name": "ferrofluid_viscosity_cp",
            "type": "number"
        },
        {
            "key": "field_ferrofluid_viscosity_mpa",
            "label": "Viscosity (mPa-s)",
            "name": "ferrofluid_viscosity_mpa",
            "type": "number"
        }
    ],
    "location": [
        [{
            "param": "post_type",
            "operator": "==",
            "value": "product"
        },
        {
            "param": "product_cat",
            "operator": "==",
            "value": "ferrofluid"
        }]
    ]
}
```

**Seal/VF-Specific Fields:**
```php
// group_seal_product_fields.json
{
    "key": "group_seal_product",
    "title": "Seal Product Fields",
    "fields": [
        {
            "key": "field_seal_shaft_type",
            "label": "Shaft Type",
            "name": "seal_shaft_type",
            "type": "select",
            "choices": {
                "solid": "Solid Shaft",
                "hollow": "Hollow Shaft"
            }
        },
        {
            "key": "field_seal_mount_type",
            "label": "Mount Type",
            "name": "seal_mount_type",
            "type": "select",
            "choices": {
                "cartridge": "Cartridge",
                "flange": "Flange",
                "nose": "Nose",
                "nut": "Nut",
                "compliant": "Compliant"
            }
        },
        {
            "key": "field_seal_environment",
            "label": "Environment",
            "name": "seal_environment",
            "type": "select",
            "choices": {
                "standard": "Standard",
                "reactive_gas": "Reactive Gas"
            }
        },
        {
            "key": "field_seal_temperature",
            "label": "Temperature Rating",
            "name": "seal_temperature",
            "type": "select",
            "choices": {
                "standard": "Standard",
                "high_temp": "High-Temperature"
            }
        }
    ],
    "location": [
        [{
            "param": "post_type",
            "operator": "==",
            "value": "product"
        },
        {
            "param": "product_cat",
            "operator": "==",
            "value": "vacuum-feedthrough"
        }]
    ]
}
```

**Step 4: Create Migration Scripts**

**Script 1: Field Rename Migration**
```php
// wp-content/plugins/ftc-product-ui/migrations/01-rename-fields.php

/**
 * Migrate old field names to unified schema
 * Run once per site via WP-CLI or admin page
 */
function ftc_migrate_field_names() {
    global $wpdb;

    $field_mappings = [
        // Old name => New name
        'step_file' => 'product_cad_file',
        'cad_download' => 'product_cad_file',
        'step_model' => 'product_cad_file',
        'model' => 'product_model',
        'part_number' => 'product_model',
        'model_number' => 'product_model',
        'sat_guass' => 'ferrofluid_saturation_gauss', // Fix typo
        'sat_mt' => 'ferrofluid_saturation_mt',
        'vis_cp' => 'ferrofluid_viscosity_cp',
        'sat_mpa_s' => 'ferrofluid_viscosity_mpa',
        'shaft_type' => 'seal_shaft_type',
        'mount_type' => 'seal_mount_type',
        'te_perf_data' => 'thermal_performance_data',
        'modeling_content' => 'thermal_modeling_content',
    ];

    foreach ( $field_mappings as $old_name => $new_name ) {
        // Update post meta
        $updated = $wpdb->query( $wpdb->prepare(
            "UPDATE {$wpdb->postmeta}
             SET meta_key = %s
             WHERE meta_key = %s
             AND post_id IN (
                 SELECT ID FROM {$wpdb->posts}
                 WHERE post_type = 'product'
             )",
            $new_name,
            $old_name
        ) );

        if ( $updated ) {
            echo "✓ Migrated {$updated} records from '{$old_name}' to '{$new_name}'\n";
        }
    }

    echo "✓ Field migration complete\n";
}

// WP-CLI command
if ( defined( 'WP_CLI' ) && WP_CLI ) {
    WP_CLI::add_command( 'ftc migrate-fields', 'ftc_migrate_field_names' );
}
```

**Script 2: Data Validation**
```php
// migrations/02-validate-migration.php

function ftc_validate_field_migration() {
    global $wpdb;

    // Check for orphaned old field names
    $old_fields = [
        'step_file', 'cad_download', 'step_model',
        'model', 'part_number', 'model_number',
        'sat_guass', 'sat_mt', 'vis_cp', 'sat_mpa_s',
        'shaft_type', 'mount_type',
        'te_perf_data', 'modeling_content'
    ];

    $report = [];

    foreach ( $old_fields as $old_field ) {
        $count = $wpdb->get_var( $wpdb->prepare(
            "SELECT COUNT(*) FROM {$wpdb->postmeta}
             WHERE meta_key = %s
             AND post_id IN (SELECT ID FROM {$wpdb->posts} WHERE post_type = 'product')",
            $old_field
        ) );

        if ( $count > 0 ) {
            $report[] = "⚠️  Found {$count} products still using old field '{$old_field}'";
        }
    }

    if ( empty( $report ) ) {
        echo "✓ All fields migrated successfully\n";
    } else {
        echo "❌ Migration incomplete:\n";
        foreach ( $report as $issue ) {
            echo "   {$issue}\n";
        }
    }
}

if ( defined( 'WP_CLI' ) && WP_CLI ) {
    WP_CLI::add_command( 'ftc validate-migration', 'ftc_validate_field_migration' );
}
```

**Step 5: Test Migration on Staging**
```bash
# Run on each subsite (if multisite)
wp ftc migrate-fields --url=thermal.ferrotec.com
wp ftc validate-migration --url=thermal.ferrotec.com

wp ftc migrate-fields --url=seals.ferrotec.com
wp ftc validate-migration --url=seals.ferrotec.com

# etc.
```

### Hook Conflict Testing

**Identify conflicting hooks:**
- YITH Request a Quote
- Gravity Forms
- Relevanssi
- WooCommerce

**Test plan:**
```php
// Log all hooks firing on product page
add_action( 'all', function( $hook ) {
    if ( is_product() && stripos( $hook, 'woocommerce' ) !== false ) {
        error_log( "Hook: {$hook}" );
    }
});
```

---

## Phase 1: Plugin Scaffold + Baseline Migration (Thermal) (3–4 weeks)

### Plugin Naming Decision

**Options:**
1. `ftc-product-ui` (original brief - emphasizes UI components)
2. `ferrotec-woocommerce` (current docs - emphasizes WooCommerce)
3. `ftc-product-display` (hybrid)

**Recommendation:** Use `ftc-product-ui` to match original brief

### Plugin Structure

```
wp-content/plugins/ftc-product-ui/
├── ftc-product-ui.php              # Main plugin file
├── includes/
│   ├── class-ftc-plugin.php        # Main plugin class
│   ├── class-ftc-tabs.php          # Product tab system
│   ├── class-ftc-attributes.php    # Attribute tables
│   ├── class-ftc-shortcodes.php    # Product shortcodes
│   ├── class-ftc-feature-flags.php # ⭐ Per-site feature toggles
│   ├── class-ftc-print-view.php    # ⭐ Print functionality
│   └── helpers.php                 # Utility functions
├── templates/
│   ├── tabs/
│   │   ├── specs.php               # Specifications tab
│   │   ├── modeling.php            # ⭐ Modeling tab (Thermal only)
│   │   ├── ordering.php            # Ordering tab
│   │   ├── downloads.php           # Downloads tab
│   │   ├── spare-parts.php         # ⭐ Spare parts tab
│   │   ├── quote.php               # ⭐ Quote request tab
│   │   └── cad.php                 # ⭐ CAD models tab
│   ├── print/
│   │   ├── product-print.php       # ⭐ Print view template
│   │   └── print-header.php        # ⭐ Print header
│   └── listings/
│       └── product-table.php
├── assets/
│   ├── css/
│   │   ├── ftc-tabs.css            # Tab styles (Bootstrap 5)
│   │   └── ftc-print.css           # ⭐ Print stylesheet
│   └── js/
│       ├── ftc-tabs.js             # Tab interactions
│       └── ftc-print.js            # ⭐ Print preparation
├── admin/
│   ├── class-ftc-admin.php         # ⭐ Admin settings page
│   └── views/
│       └── feature-flags.php       # ⭐ Feature flag UI
├── migrations/
│   ├── 01-rename-fields.php        # Field migration script
│   └── 02-validate-migration.php   # Validation script
└── acf-json/
    ├── group_shared_product.json
    ├── group_thermal_product.json
    ├── group_ferrofluid_product.json
    └── group_seal_product.json
```

### Feature Flag System Implementation

**Admin Settings Page:**

```php
// admin/views/feature-flags.php
<div class="wrap">
    <h1>FTC Product UI - Feature Flags</h1>

    <form method="post" action="options.php">
        <?php settings_fields( 'ftc_feature_flags' ); ?>

        <h2>Product Tabs</h2>
        <table class="form-table">
            <tr>
                <th>Specifications Tab</th>
                <td>
                    <input type="checkbox" name="ftc_tabs[specs]" value="1"
                        <?php checked( ftc_tab_enabled( 'specs' ) ); ?>>
                    <span class="description">Display product specifications</span>
                </td>
            </tr>
            <tr>
                <th>Modeling Tab</th>
                <td>
                    <input type="checkbox" name="ftc_tabs[modeling]" value="1"
                        <?php checked( ftc_tab_enabled( 'modeling' ) ); ?>>
                    <span class="description">Thermal site only - modeling tools and data</span>
                </td>
            </tr>
            <tr>
                <th>Ordering Tab</th>
                <td>
                    <input type="checkbox" name="ftc_tabs[ordering]" value="1"
                        <?php checked( ftc_tab_enabled( 'ordering' ) ); ?>>
                    <span class="description">Ordering information</span>
                </td>
            </tr>
            <tr>
                <th>Downloads Tab</th>
                <td>
                    <input type="checkbox" name="ftc_tabs[downloads]" value="1"
                        <?php checked( ftc_tab_enabled( 'downloads' ) ); ?>>
                    <span class="description">CAD files, datasheets, etc.</span>
                </td>
            </tr>
            <tr>
                <th>Spare Parts Tab</th>
                <td>
                    <input type="checkbox" name="ftc_tabs[spare_parts]" value="1"
                        <?php checked( ftc_tab_enabled( 'spare_parts' ) ); ?>>
                    <span class="description">Replacement parts and accessories</span>
                </td>
            </tr>
            <tr>
                <th>Quote Request Tab</th>
                <td>
                    <input type="checkbox" name="ftc_tabs[quote]" value="1"
                        <?php checked( ftc_tab_enabled( 'quote' ) ); ?>>
                    <span class="description">Request a quote form</span>
                </td>
            </tr>
            <tr>
                <th>CAD Models Tab</th>
                <td>
                    <input type="checkbox" name="ftc_tabs[cad]" value="1"
                        <?php checked( ftc_tab_enabled( 'cad' ) ); ?>>
                    <span class="description">3D CAD model viewer</span>
                </td>
            </tr>
        </table>

        <?php submit_button(); ?>
    </form>
</div>
```

**Feature Flag Check Function:**
```php
// includes/class-ftc-feature-flags.php

class FTC_Feature_Flags {
    /**
     * Check if a tab is enabled for current site
     */
    public static function tab_enabled( $tab_slug ) {
        // Multisite support
        if ( is_multisite() ) {
            return get_blog_option( get_current_blog_id(), "ftc_tab_{$tab_slug}", false );
        }

        // Single site
        $enabled_tabs = get_option( 'ftc_tabs', [] );
        return isset( $enabled_tabs[ $tab_slug ] ) && $enabled_tabs[ $tab_slug ];
    }

    /**
     * Get all enabled tabs for current site
     */
    public static function get_enabled_tabs() {
        $all_tabs = [
            'specs' => __( 'Specifications', 'ftc-product-ui' ),
            'modeling' => __( 'Modeling', 'ftc-product-ui' ),
            'ordering' => __( 'Ordering', 'ftc-product-ui' ),
            'downloads' => __( 'Downloads', 'ftc-product-ui' ),
            'spare_parts' => __( 'Spare Parts', 'ftc-product-ui' ),
            'quote' => __( 'Request Quote', 'ftc-product-ui' ),
            'cad' => __( 'CAD Models', 'ftc-product-ui' ),
        ];

        $enabled = [];
        foreach ( $all_tabs as $slug => $label ) {
            if ( self::tab_enabled( $slug ) ) {
                $enabled[ $slug ] = $label;
            }
        }

        return $enabled;
    }
}
```

### Print View Implementation

**Detect Print Mode:**
```php
// includes/class-ftc-print-view.php

class FTC_Print_View {
    public function __construct() {
        add_action( 'template_redirect', [ $this, 'handle_print_request' ] );
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_print_styles' ] );
    }

    /**
     * Check if print mode is requested
     */
    public static function is_print_mode() {
        return isset( $_GET['print'] ) && $_GET['print'] === '1';
    }

    /**
     * Load print template
     */
    public function handle_print_request() {
        if ( ! is_product() || ! self::is_print_mode() ) {
            return;
        }

        // Load print template instead of normal single-product
        add_filter( 'template_include', function( $template ) {
            $print_template = plugin_dir_path( dirname( __FILE__ ) ) . 'templates/print/product-print.php';
            if ( file_exists( $print_template ) ) {
                return $print_template;
            }
            return $template;
        });
    }

    /**
     * Enqueue print-specific styles
     */
    public function enqueue_print_styles() {
        if ( ! self::is_print_mode() ) {
            return;
        }

        wp_enqueue_style(
            'ftc-print',
            plugins_url( '../assets/css/ftc-print.css', __FILE__ ),
            [],
            '1.0.0',
            'all'
        );
    }
}
```

**Print Template:**
```php
// templates/print/product-print.php

<?php
/**
 * Product Print View Template
 * Accessed via ?print=1
 */

get_header( 'print' ); // Minimal print header

global $product;

if ( ! $product ) {
    $product = wc_get_product( get_the_ID() );
}
?>

<div class="ftc-print-container">
    <div class="print-header">
        <img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/logo-print.svg' ); ?>"
             alt="Ferrotec" class="print-logo">
        <div class="print-meta">
            <strong><?php echo esc_html( $product->get_name() ); ?></strong><br>
            Model: <?php echo esc_html( get_field( 'product_model' ) ?: $product->get_sku() ); ?><br>
            Date: <?php echo date( 'F j, Y' ); ?>
        </div>
    </div>

    <div class="print-content">
        <?php
        // Product image
        if ( $product->get_image_id() ) {
            echo wp_get_attachment_image( $product->get_image_id(), 'large', false, [
                'class' => 'print-product-image'
            ]);
        }

        // Description
        ?>
        <div class="print-section">
            <h2>Description</h2>
            <?php echo wpautop( $product->get_description() ); ?>
        </div>

        <?php
        // Specifications table
        $attributes = $product->get_attributes();
        if ( ! empty( $attributes ) ) :
        ?>
        <div class="print-section">
            <h2>Specifications</h2>
            <table class="print-specs-table">
                <?php foreach ( $attributes as $attribute ) :
                    if ( ! $attribute->get_visible() ) continue;
                    ?>
                    <tr>
                        <th><?php echo wc_attribute_label( $attribute->get_name() ); ?></th>
                        <td><?php echo $product->get_attribute( $attribute->get_name() ); ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <?php endif; ?>

        <?php
        // Performance charts (render as SVG for vector quality)
        if ( FTC_Feature_Flags::tab_enabled( 'modeling' ) && get_field( 'thermal_performance_data' ) ) :
        ?>
        <div class="print-section page-break-before">
            <h2>Performance Data</h2>
            <?php
            // Render Chart.js charts as SVG
            // This requires chart.js with svg adapter or server-side rendering
            $performance_data = get_field( 'thermal_performance_data' );
            // TODO: Implement SVG chart rendering
            ?>
        </div>
        <?php endif; ?>

        <?php
        // CAD file information
        if ( $cad_file = get_field( 'product_cad_file' ) ) :
        ?>
        <div class="print-section">
            <h2>CAD Files</h2>
            <p>
                <strong><?php echo esc_html( basename( $cad_file['filename'] ) ); ?></strong><br>
                Download: <?php echo esc_url( home_url( '?product=' . get_the_ID() ) ); ?>
            </p>
        </div>
        <?php endif; ?>
    </div>

    <div class="print-footer">
        <p>Ferrotec | <?php echo esc_url( home_url() ); ?> | Page <?php echo '<span class="page-number"></span>'; ?> of <?php echo '<span class="page-count"></span>'; ?></p>
    </div>
</div>

<script>
// Add page numbers via JavaScript
window.onload = function() {
    const pageNumbers = document.querySelectorAll('.page-number');
    const pageCounts = document.querySelectorAll('.page-count');

    pageNumbers.forEach(el => el.textContent = '1'); // Placeholder
    pageCounts.forEach(el => el.textContent = '1');
};
</script>

<?php get_footer( 'print' ); ?>
```

**Print Stylesheet:**
```css
/* assets/css/ftc-print.css */

@media print {
    /* Hide navigation, sidebars, footers */
    nav, aside, .site-header, .site-footer, .woocommerce-breadcrumb {
        display: none !important;
    }

    /* Page breaks */
    .print-section {
        page-break-inside: avoid;
    }

    .page-break-before {
        page-break-before: always;
    }

    /* Print header */
    .print-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 2px solid #000;
        padding-bottom: 1rem;
        margin-bottom: 2rem;
    }

    .print-logo {
        max-width: 200px;
        height: auto;
    }

    /* Tables */
    .print-specs-table {
        width: 100%;
        border-collapse: collapse;
        margin: 1rem 0;
    }

    .print-specs-table th,
    .print-specs-table td {
        border: 1px solid #000;
        padding: 0.5rem;
        text-align: left;
    }

    .print-specs-table th {
        background: #f0f0f0;
        font-weight: bold;
        width: 40%;
    }

    /* Images */
    .print-product-image {
        max-width: 400px;
        height: auto;
        display: block;
        margin: 1rem 0;
    }

    /* Charts - ensure SVG renders well */
    svg {
        max-width: 100%;
        height: auto;
    }

    /* Footer */
    .print-footer {
        position: fixed;
        bottom: 0;
        width: 100%;
        text-align: center;
        font-size: 10pt;
        border-top: 1px solid #ccc;
        padding-top: 0.5rem;
    }
}
```

### Conditional Plugin Loading

**Efficient loading for non-WooCommerce sites:**

```php
// ftc-product-ui.php

if ( ! class_exists( 'WooCommerce' ) ) {
    // Don't load WooCommerce-dependent features
    return;
}

// Only load on product pages
add_action( 'wp', function() {
    if ( ! is_product() && ! is_shop() && ! is_product_category() ) {
        return; // Don't load plugin assets on non-product pages
    }

    // Load plugin features
    FTC_Tabs::init();
    FTC_Attributes::init();
    // etc.
});
```

### Baseline Site: Thermal Migration First

**Phase 1 Focus:**
- Migrate Thermal site only initially
- Thermal has most complex tabs (includes Modeling tab)
- Test all features on Thermal before rolling out

**Thermal-Specific Features:**
- Modeling tab with performance charts
- Thermal performance data (ACF repeater)
- TE module family grouping
- Print view with vector charts

**Success Metrics for Thermal Baseline:**
- [ ] All Thermal products display correctly
- [ ] Modeling tab renders with charts
- [ ] Print view works (including charts)
- [ ] ACF fields migrated successfully
- [ ] No template overrides in child theme needed
- [ ] Performance baseline met or exceeded

---

## Phase 2: Rollout to Remaining Sites (4–6 weeks)

### Site-by-Site Migration Order

**Week 1-2: Seals (seals.ferrotec.com)**
- Apply standardized ACF fields
- Enable tabs: Specs, Ordering, Downloads, Spare Parts
- Test VF feedthrough filtering
- Migrate seal-specific templates

**Week 2-3: Ferrofluid (ferrofluid.ferrotec.com)**
- Apply ferrofluid ACF field schema
- Enable tabs: Specs, Ordering, Downloads
- Test ferrofluid product tables
- Migrate chemical properties display

**Week 3-4: Corporate + Non-WC Sites**
- Quartz site
- Ceramics site
- Corporate main site
- Enable basic product display (no WooCommerce)

**Week 4-5: Remaining Sites**
- Final 2-3 sites (identify from multisite audit)
- Apply learnings from previous migrations
- QA all feature flags per site

### Per-Site QA Checklist

For each site:
- [ ] Feature flags configured correctly
- [ ] Only relevant tabs displayed
- [ ] ACF fields display correctly
- [ ] Print view works
- [ ] Product listings formatted correctly
- [ ] Search works
- [ ] No template overrides needed
- [ ] Performance metrics acceptable

---

## Phase 3: Cleanup & Go-Live (2–3 weeks)

### Bootstrap 3 Removal

**Status:** ✅ Already done (migrated to Bootstrap 5)

### Final Performance Optimization

**Tasks:**
- [ ] Minify all CSS/JS
- [ ] Optimize images
- [ ] Implement caching strategy
- [ ] Test page load times < 3 seconds
- [ ] Test on slow connections (3G simulation)

### SEO Audit

**Include print routes:**
- [ ] `?print=1` URLs not indexed
- [ ] Canonical URLs correct
- [ ] Structured data for products
- [ ] XML sitemap includes all products
- [ ] Meta descriptions present
- [ ] Alt text on images

**Print Route Handling:**
```php
// Prevent search engines from indexing print views
add_action( 'wp_head', function() {
    if ( FTC_Print_View::is_print_mode() ) {
        echo '<meta name="robots" content="noindex,nofollow">' . "\n";
    }
});
```

### Cutover All Sites at Once

**Deployment Strategy:**
1. Final staging tests on all 10 subsites
2. Database backup (all sites)
3. Enable plugin network-wide
4. Activate new theme on all sites simultaneously
5. Monitor for 24 hours
6. Deactivate old child themes

**Rollback Plan:**
1. Deactivate new plugin
2. Reactivate old child themes
3. Restore database from backup (if needed)
4. Investigate issues
5. Fix on staging
6. Re-attempt deployment

---

## Component Change Classification (Original Brief)

### CSS-Only Changes (Low Effort)
Can be changed without plugin modifications:
- Colors, fonts, spacing, borders
- Button styles
- Tab appearance
- Column count in grids
- Backgrounds, shadows
- Icon swaps

### Hook/Template Adjustments (Medium Effort)
Requires plugin or theme changes:
- Moving blocks/sections (Woo hook priorities)
- Adding/removing tabs (toggle feature flags)
- Changing tab order
- Adding data fields from ACF/Woo meta
- Layout changes within tabs
- Form placements

### Backend/Major Changes (High Effort)
Requires significant development:
- New interactive behavior (filters, calculators, charts)
- New data sources or APIs
- New page types/post types
- Major single-product layout changes
- New archive/listing logic

---

## Network Activation for Multisite

**If this is a multisite:**

```php
// ftc-product-ui.php

/*
Plugin Name: FTC Product UI
Network: true  ← Enable network activation
*/

// Network-wide activation hook
register_activation_hook( __FILE__, 'ftc_network_activate' );

function ftc_network_activate( $network_wide ) {
    if ( ! is_multisite() || ! $network_wide ) {
        ftc_single_site_activate();
        return;
    }

    // Activate on all sites
    $sites = get_sites();
    foreach ( $sites as $site ) {
        switch_to_blog( $site->blog_id );
        ftc_single_site_activate();
        restore_current_blog();
    }
}

function ftc_single_site_activate() {
    // Set default feature flags
    $default_tabs = [
        'specs' => true,
        'ordering' => true,
        'downloads' => true,
        'modeling' => false,  // Only Thermal
        'spare_parts' => false,
        'quote' => true,
        'cad' => true,
    ];

    add_option( 'ftc_tabs', $default_tabs );

    // Run field migration (one-time)
    if ( ! get_option( 'ftc_fields_migrated' ) ) {
        require_once plugin_dir_path( __FILE__ ) . 'migrations/01-rename-fields.php';
        ftc_migrate_field_names();
        update_option( 'ftc_fields_migrated', true );
    }
}
```

---

## Success Criteria (from Original Brief)

### Plugin Loading
- [ ] No per-site Woo template overrides needed for core layouts
- [ ] Plugin loads efficiently (no resource waste on non-WC sites)
- [ ] Network-activated and working across all subsites

### Data Standardization
- [ ] Standardized ACF field schema across all sites
- [ ] Successful field name migration with zero data loss
- [ ] All products display correct data post-migration

### UI Consistency
- [ ] Tabs and shared UI consistent across all sites
- [ ] Feature flags allow per-site tab customization
- [ ] Bootstrap 5 accessible tabs implemented

### Print Functionality
- [ ] Print view at `?print=1` renders cleanly
- [ ] Pagination works well for multi-page products
- [ ] Charts output in vector-quality (SVG)
- [ ] Print routes not indexed by search engines

### Performance
- [ ] No SEO regressions vs. baseline metrics
- [ ] Page load times maintained or improved
- [ ] Efficient conditional loading

### Maintainability
- [ ] Site differences limited to feature flags + brand skin CSS
- [ ] No duplicate code across sites
- [ ] Easy to add new product lines

---

## Questions Requiring Answers

1. **Is this actually a multisite?** Or single site with child themes?
2. **What are the 10 subsites?** (Only 5 child themes found)
3. **Should plugin be named `ftc-product-ui` or `ferrotec-woocommerce`?**
4. **Is Thermal the confirmed baseline site for first migration?**
5. **What's the WP Engine staging environment URL?**
6. **Is there an existing performance baseline?**
7. **Are there Modeling tab requirements for sites other than Thermal?**
8. **What charts need to render in print view?** (libraries: Chart.js, Raphael?)
9. **Should old child themes be deleted after migration or kept as reference?**
10. **What's the go-live target date?**

---

## Next Immediate Actions

1. **Clarify Architecture:**
   - [ ] Confirm if multisite or single-site
   - [ ] Identify all 10 subsites (if multisite)
   - [ ] Document which sites have WooCommerce

2. **ACF Field Audit:**
   - [ ] Export all ACF field groups from production
   - [ ] Document field name variations per site
   - [ ] Create unified schema spreadsheet

3. **Performance Baseline:**
   - [ ] Run GTmetrix on all current sites
   - [ ] Document current page load times
   - [ ] Identify bottlenecks

4. **Feature Flag Requirements:**
   - [ ] Confirm which tabs each site needs
   - [ ] Identify site-specific features (Modeling tab for Thermal?)
   - [ ] Document print view requirements per site

5. **Update Documentation:**
   - [ ] Revise README.md with multisite details
   - [ ] Update MIGRATION_PLAN.md with refactored phases
   - [ ] Create ACF_FIELD_AUDIT.md

---

**Last Updated:** November 18, 2025
**Status:** Refactored plan created - awaiting architecture clarification
**Next Step:** Answer 10 critical questions above before proceeding with implementation
