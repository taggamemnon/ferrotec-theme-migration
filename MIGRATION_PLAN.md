# Custom Functions Migration Plan
**Ferrotec Theme Migration - Phase 2 & 3 Planning**

This document outlines the complete migration strategy for all custom functions, shortcodes, templates, and custom post types from the old themes to the new layers2025 theme and ferrotec-woocommerce plugin.

---

## 📊 Migration Overview

### Files Analyzed:
- ✅ `old-themes/layers2/functions.php` (1,535 lines)
- ✅ `old-themes/child-meivac/functions.php` (307 lines)
- ✅ `old-themes/child-corporate/functions.php` (42 lines)
- ✅ `old-themes/child-thermalelectric/functions.php` (247 lines)
- ✅ Template files in all child themes
- ✅ `old-themes/layers2/functions-indexing.php` (search customization)

### Migration Destinations:
1. **Theme**: `wp-content/themes/layers2025/` - Presentation & content functions
2. **Plugin**: `wp-content/plugins/ferrotec-woocommerce/` - WooCommerce & e-commerce functions
3. **Plugin (CPT)**: `wp-content/plugins/ferrotec-content/` - Custom post types (optional separate plugin)

---

## 🎯 PHASE 2A: WooCommerce Plugin Functions

### Priority: **CRITICAL** - Core E-commerce Functionality

### Source: `old-themes/child-meivac/functions.php`

#### 1. Product Tab Customization ⭐⭐⭐
**Destination:** `ferrotec-woocommerce/includes/class-ft-woo-tabs.php`

**Functions to Migrate:**
```php
✓ ft_woo_custom_description_tabs()       // Lines 51-75
  - Removes: reviews, additional_information tabs
  - Adds: Ordering tab, conditional Downloads tab
  - Uses: ACF field 'step_file' to conditionally show Downloads

✓ ft_woo_description_tab_content()       // Lines 78-86
  - Loads category-specific tab templates
  - get_template_part() based on product_cat slug

✓ ft_woo_ordering_tab_content()          // Lines 88-96
  - Loads category-specific ordering templates

✓ ft_woo_downloads_tab_content()         // Lines 98-101
  - Loads downloads template
```

**Dependencies:**
- ACF field: `step_file`
- Template files in plugin: `templates/tabs/`
- Product category taxonomy access

**Migration Strategy:**
1. Create class-based structure for tab management
2. Register filter: `woocommerce_product_tabs` (priority 98)
3. Implement template loader for category-specific tabs
4. Add ACF field check for conditional Downloads tab
5. Create default + category-specific tab templates

**Template Files to Migrate:**
```
old-themes/child-meivac/page-templates/single-product/woocommerce-tabs/
├── tab-description.php                              → templates/tabs/description.php
├── tab-description-aqua-lok.php                     → templates/tabs/description-aqua-lok.php
├── tab-description-mak-sputter.php                  → templates/tabs/description-mak-sputter.php
├── tab-description-power-supplies.php               → templates/tabs/description-power-supplies.php
├── tab-description-substrate-heaters.php            → templates/tabs/description-substrate-heaters.php
├── tab-description-vari-q-throttle-valves.php       → templates/tabs/description-vari-q-throttle-valves.php
├── tab-ordering.php                                 → templates/tabs/ordering.php
├── tab-ordering-aqua-lok.php                        → templates/tabs/ordering-aqua-lok.php
└── tab-downloads.php                                → templates/tabs/downloads.php
```

---

#### 2. Product Attribute Tables ⭐⭐⭐
**Destination:** `ferrotec-woocommerce/includes/class-ft-woo-attributes.php`

**Functions to Migrate:**
```php
✓ ft_woo_custom_attributes_table()       // Lines 114-204
  - Custom attribute table generation
  - Filters attributes by provided list or shows all visible
  - Includes weight & dimensions
  - Custom label mapping for specific attributes
  - Uses template part for output

Action Hook:
✓ add_action('ft_display_product_specs', 'ft_woo_custom_attributes_table', 10, 1);
```

**Function Arguments:**
```php
$args = array(
  'product'        => WC_Product object,
  'attribute_list' => array( 'pa_attribute_slug', ... ), // Optional
  'table_head'     => 'Specifications'                  // Optional
)
```

**Custom Label Mapping:**
```php
'mc2inputpower'    => 'Input Power',
'mc2dimensions'    => 'Dimensions',
'mc2ioconnections' => 'I/O Connections',
'at3dimensions'    => 'Dimensions',
'at3cooling'       => 'Cooling',
'at3tuningrange'   => 'Tuning Range',
'at3rfconn'        => 'RF Conn.'
```

**Template File:**
```
old-themes/child-meivac/page-templates/single-product/product-specs-tables.php
  → templates/single-product/specs-table.php
```

**Migration Strategy:**
1. Create class for attribute management
2. Register custom action hook: `ft_display_product_specs`
3. Implement attribute filtering logic
4. Create template for specs table output
5. Add extensible label mapping system

---

#### 3. Product Listing Shortcodes ⭐⭐⭐
**Destination:** `ferrotec-woocommerce/includes/class-ft-woo-shortcodes.php`

**Functions to Migrate:**
```php
✓ show_meivac_products_func()            // Lines 210-267
  - Builds HTML table of products by category
  - Custom columns: Image, Product, O.D., I.D., Material/Coating, Actuation
  - Hardcoded table structure

✓ show_meivac_template()                 // Lines 270-279
  - Loads category template file
  - Uses get_template_part() for flexibility
  - CURRENTLY ACTIVE (line 281)
```

**Shortcode:**
```
[show_meivac_products category="product-category-slug"]
```

**Category Templates to Migrate:**
```
old-themes/child-meivac/category-templates/
├── listing.php                          → templates/listings/default.php
├── listing-e-vap.php                    → templates/listings/e-vap.php
├── listing-mak-sputter.php              → templates/listings/mak-sputter.php
├── listing-re-vap.php                   → templates/listings/re-vap.php
└── listing-vari-q-throttle-valves.php   → templates/listings/vari-q-throttle-valves.php
```

**Migration Strategy:**
1. Create shortcode handler class
2. Register shortcode: `show_meivac_products`
3. Implement template loader by category slug
4. Create default listing template
5. Migrate category-specific templates
6. Add filters for customization

---

#### 4. Helper Functions ⭐⭐
**Destination:** `ferrotec-woocommerce/includes/helpers.php`

**Functions to Migrate:**
```php
✓ meta_list()                            // Lines 284-294
  - Get unique meta values for dropdowns/filters
  - Used on product listing pages
  - SQL query to postmeta table

✓ meta_list_numeric()                    // Lines 296-306
  - Same as meta_list but sorted numerically
  - Uses CAST(meta_value as unsigned)
```

**Use Case:**
Used in JavaScript filter dropdowns on product listing pages (e.g., vari-q-listings.js)

**Migration Strategy:**
1. Create utility functions file
2. Add proper escaping and sanitization
3. Consider caching for performance
4. Add filters for query customization

---

#### 5. Page-Specific Scripts ⭐
**Destination:** `ferrotec-woocommerce/includes/class-ft-woo-scripts.php`

**Functions to Migrate:**
```php
✓ meivac_scripts()                       // Lines 23-44
  - Conditionally loads JS by page ID
  - Page 398: mak-sputter-listings.js
  - Page 53: vari-q-listings.js
```

**Migration Strategy:**
1. Create script enqueue class
2. **IMPROVE:** Use page slug or template instead of hardcoded IDs
3. Register scripts properly with dependencies
4. Migrate JavaScript files to plugin assets

**JavaScript Files to Migrate:**
```
old-themes/child-meivac/js/
├── mak-sputter-listings.js              → assets/js/mak-sputter-listings.js
└── vari-q-listings.js                   → assets/js/vari-q-listings.js
```

---

## 🎨 PHASE 2B: Additional Product Shortcodes (WooCommerce)

### Source: `old-themes/layers2/functions.php`

### Priority: **HIGH** - WooCommerce Product Listings

#### 1. Ferrofluid Products Shortcode ⭐⭐
**Destination:** `ferrotec-woocommerce/includes/class-ft-woo-shortcodes.php`

**Functions to Migrate:**
```php
✓ show_ferrofluid_products()             // Lines 1027-1079
  - WooCommerce product query by category
  - Custom table output with ACF fields
  - Already using WP_Query (modern approach!)
```

**Shortcode:**
```
[ferrofluid_products family="product-category-slug"]
```

**Custom Table Columns:**
- Ferrofluid Type
- Gauss [CGS]
- mT [SI]
- cP [CGS]
- mPa-s [SI]

**ACF Fields Used:**
```php
'model'      // Ferrofluid model number
'sat_guass'  // Saturation (Gauss)
'sat_mt'     // Saturation (mT)
'vis_cp'     // Viscosity (cP)
'sat_mpa_s'  // Saturation (mPa-s)
```

**Migration Strategy:**
1. Add to shortcode handler class
2. Create template for ferrofluid table layout
3. Verify ACF field names match WooCommerce products
4. Update Bootstrap classes (v3 → v5)
5. Add filters for customization

---

#### 2. Vacuum Feedthrough Shortcode ⭐⭐⭐
**Destination:** `ferrotec-woocommerce/includes/class-ft-woo-shortcodes.php`

**Functions to Rewrite:**
```php
✓ show_vf_feedthroughs()                 // Lines 1083-1105
  - Currently uses fProducts class (legacy)
  - **MUST REWRITE** to use WooCommerce products
  - Complex filtering UI (shaft type, mount, environment, temperature)
  - Uses data attributes for JavaScript filtering
```

**Shortcode:**
```
[show_feedthroughs] (no parameters needed)
```

**Filter Options:**
- Shaft Type: Solid, Hollow
- Mount Type: Cartridge, Flange, Nose, Nut, Compliant
- Environment: Standard, Reactive Gas
- Temperature: Standard, High-Temperature
- Units Toggle: Imperial, Metric, Both

**Table Columns:**
- Appearance (thumbnail)
- Model Number
- Part Number
- Shaft Type
- Shaft Dimension
- Mounting Type
- Fluid

**Migration Strategy:**
1. **Rewrite query** to use WooCommerce products instead of fProducts
2. Convert product attributes to WooCommerce taxonomy terms:
   - `shaft_type` → product attribute
   - `mount_type` → product attribute
   - `environment` → product attribute
   - `temperature` → product attribute
3. Create JavaScript for dynamic filtering
4. Build responsive filter UI with Bootstrap 5
5. Use WooCommerce product images instead of hardcoded paths
6. Create template part for VF product table

**WooCommerce Product Attributes Needed:**
```php
pa_shaft_type     // Solid Shaft, Hollow Shaft
pa_mount_type     // Cartridge, Flange, Nose, Nut, Compliant
pa_environment    // Standard, Reactive Gas
pa_temperature    // Standard, High-Temperature
pa_unit_system    // Imperial, Metric
```

**JavaScript File to Create:**
```
assets/js/vf-feedthrough-filter.js
- Dynamic product filtering
- Unit conversion toggle
- Table row show/hide based on filters
```

---

#### 3. Legacy Shortcodes to REMOVE ❌

**DO NOT MIGRATE - Legacy fProducts-based:**

```php
❌ show_thermalelectric_family()         // Uses fProducts class
   Shortcode: [show_thermalelectric family="14"]
   Reason: Legacy external database, not WooCommerce

❌ show_ferrofluid_family()              // Uses fProducts class
   Shortcode: [show_ferrofluid]
   Reason: Legacy external database, not WooCommerce
```

**Replacement:**
Use WooCommerce-based shortcodes instead:
- `[show_meivac_products]` pattern
- `[ferrofluid_products]`
- `[show_feedthroughs]` (after rewrite)

---

## 📰 PHASE 3A: Custom Post Types & Shortcodes

### Source: `old-themes/layers2/functions.php`

### Priority: **HIGH** - Content Management

#### 1. Custom Post Type Registration ⭐⭐⭐
**Destination:** `layers2025/inc/custom-post-types.php` OR separate plugin `ferrotec-content`

**Custom Post Types to Migrate:**
```php
✓ auc_block                              // Lines 230-251
  - Reusable content blocks
  - Shortcode: [show_block id={post_id}]
  - Supports: author, title, editor, thumbnail, revisions

✓ auc_events                             // Lines 253-273
  - Event management
  - Used with: [show_events_and_webinars]

✓ auc_press                              // Lines 274-294
  - Press releases
  - Rewrite: pr/{post-name}
  - Used with: [show_recent_pr], [show_homepage_pr]

✓ auc_news                               // Lines 296-316
  - News items
  - Used with: [show_recent_news]

✓ auc_resources                          // Lines 317-340
  - Downloadable resources
  - Used with: [show_resource_accordion]
  - Rewrite: resources/{post-name}
```

**Migration Decision:**
- **Option A:** Keep in theme (simpler, all in one place)
- **Option B:** Separate plugin for portability
- **RECOMMENDATION:** Keep in theme for now

**Migration Strategy:**
1. Create inc/custom-post-types.php
2. Register all CPTs with modern syntax
3. Update prefixes: `auc_` → `ft_` (optional, for consistency)
4. Add REST API support for block editor
5. Create custom templates for each CPT

---

#### 2. Content Display Shortcodes ⭐⭐⭐
**Destination:** `layers2025/inc/shortcodes-content.php`

**Shortcodes to Migrate:**

##### [show_block] - Reusable Content Blocks
```php
✓ show_block_function()                  // Lines 396-408
  - Displays auc_block post content
  - Usage: [show_block id="123"]
```

##### [show_menu] - Menu Display
```php
✓ show_menu()                            // Lines 418-429
  - Displays wp_nav_menu via shortcode
  - Usage: [show_menu id="menu-slug" wrapper="div"]
```

##### [show_recent_news] - News Listing
```php
✓ show_recent_news()                     // Lines 442-470
  - Displays recent auc_news posts
  - Usage: [show_recent_news items="5"]
```

##### [show_recent_pr] - Press Release Listing
```php
✓ show_recent_pr()                       // Lines 471-498
  - Displays recent auc_press posts
  - Usage: [show_recent_pr items="5"]
```

##### [show_homepage_pr] - Homepage PR Display
```php
✓ show_homepage_pr()                     // Lines 500-535
  - Featured press releases for homepage
  - Usage: [show_homepage_pr items="3"]
```

##### [show_events_and_webinars] - Events Listing
```php
✓ show_events_webinars()                 // Lines 571-610
  - Complex events display with filtering
  - Usage: [show_events_and_webinars]
```

##### [show_resource_accordion] - Resources Display
```php
✓ show_resource_accordion()              // Lines 650-689
  - Accordion-style resource display
  - Uses ACF fields
  - Usage: [show_resource_accordion]
```

**Migration Strategy:**
1. Create shortcode handler file
2. Modernize output (use template parts instead of string concatenation)
3. Add proper escaping and sanitization
4. Create template files for each shortcode
5. Add filters for customization
6. Consider converting some to Gutenberg blocks

**Note:** Product-related shortcodes ([ferrofluid_products], [show_feedthroughs]) are now in **Phase 2B** as WooCommerce shortcodes.

---

## 🔍 PHASE 3B: Search & SEO Customization

### Source: `old-themes/layers2/functions.php` and `functions-indexing.php`

#### 1. Relevanssi Search Customization ⭐⭐
**Destination:** `layers2025/inc/search-customization.php`

**Functions to Migrate:**
```php
✓ savemyhyphens_1()                      // Lines 14-17
  - Preserve hyphens and slashes in search
  - Filter: relevanssi_remove_punctuation (priority 9)

✓ savemyhyphens_2()                      // Lines 19-23
  - Restore hyphens and slashes after processing
  - Filter: relevanssi_remove_punctuation (priority 11)

✓ postsperpage()                         // Lines 26-33
  - Limit search results to 10 per page
  - Filter: post_limits
```

**Filters:**
```php
add_filter('relevanssi_stemmer', 'relevanssi_simple_english_stemmer');
add_filter('relevanssi_remove_punctuation', 'savemyhyphens_1', 9);
add_filter('relevanssi_remove_punctuation', 'savemyhyphens_2', 11);
add_filter('post_limits', 'postsperpage');
```

**Migration Strategy:**
1. Create search customization file
2. Only load if Relevanssi is active
3. Test search with hyphenated terms
4. Document Relevanssi dependency

---

#### 2. Custom Content Indexing ⭐
**Destination:** `layers2025/inc/search-customization.php`

**Source:** `old-themes/layers2/functions-indexing.php`

**Functions to Migrate:**
```php
✓ add_extra_content()                    // Lines 5-end
  - Adds custom content to search index
  - Specific to page-teproducts.php template
  - Uses ACF fields for thermoelectric product data
  - Generates descriptive text for SEO
```

**Filters:**
```php
add_filter('relevanssi_content_to_index', 'add_extra_content', 10, 2);
add_filter('relevanssi_excerpt_content', 'add_extra_content', 10, 2);
```

**Migration Strategy:**
1. Update template name check for new theme
2. Verify ACF field names still match
3. Test indexing with thermal products
4. Consider if still needed with modern Relevanssi

---

## 🛠️ PHASE 3C: Utility Functions & Filters

### Source: `old-themes/layers2/functions.php`

#### 1. Content Filtering ⭐
**Destination:** `layers2025/inc/theme-setup.php`

**Filters to Migrate:**
```php
✓ Yoast SEO Canonical                    // Line 7
  add_filter('wpseo_canonical', '__return_false');

✓ Disable wpautop                        // Lines 8-10
  remove_filter('the_content', 'wpautop');
  remove_filter('the_excerpt', 'wpautop');
  remove_filter('acf_the_content', 'wpautop');
```

**⚠️ REVIEW NEEDED:**
- Is disabling wpautop still necessary?
- Modern editors handle this better
- May cause formatting issues

---

#### 2. Excerpt & Read More Customization ⭐
**Destination:** `layers2025/inc/template-tags.php`

**Functions to Migrate:**
```php
✓ new_excerpt_more()                     // Lines 346-348
  - Custom excerpt "More" link with Bootstrap button
  - Filter: excerpt_more

✓ new_read_more()                        // Lines 351-353
  - Custom read more link
  - Filter: the_content_more_link
```

**Migration Strategy:**
1. Add to template-tags.php
2. Update Bootstrap classes (v3 → v5)
3. Add filters for customization

---

#### 3. SVG Upload Support ⭐
**Destination:** `layers2025/inc/theme-setup.php`

**Function to Migrate:**
```php
✓ cc_mime_types()                        // Lines 382-386
  - Allow SVG file uploads
  - Filter: upload_mimes
```

**⚠️ SECURITY NOTE:**
- SVG uploads can be security risk
- Add sanitization if migrating
- Consider limiting to admin users only

---

#### 4. Helper Functions ⭐
**Destination:** `layers2025/inc/template-tags.php`

**Functions to Migrate:**
```php
✓ show_block_template()                  // Lines 432-439
  - Get auc_block content by ID
  - Used in templates (not shortcode)

✓ get_the_content_by_id()               // Lines 410-416
  - Get page content by ID
  - Deprecated: Use get_post() instead
```

**Migration Strategy:**
1. Add to template-tags.php
2. Mark as deprecated if not used
3. Update to modern WordPress functions

---

## 📋 PHASE 3D: Widget Areas

### Source: `old-themes/layers2/functions.php`

**Function to Migrate:**
```php
✓ ferrotec_widgets_init()                // Lines 123-145
  - Register widget areas
```

**Widget Areas:**
```php
1. sidebar-blog        → Migrate to layers2025
2. seals_login-sidebar → Review if still needed
```

**Destination:** `layers2025/inc/theme-setup.php`

**Migration Strategy:**
1. Register sidebar-blog (essential)
2. Review seals_login-sidebar necessity
3. Add footer widget areas (already done in new theme)

---

## 🔐 PHASE 3E: User Management (Review Needed)

### Source: `old-themes/layers2/functions.php`

**Function Found:**
```php
✓ pippin_reset_password_form()           // Referenced at line 1361
  - Password reset form shortcode
  - Shortcode: [password_form]
```

**⚠️ INVESTIGATION NEEDED:**
- Full function not in excerpts shown
- May be custom user management
- Check if still in use
- Security review required before migration

**Migration Decision:** DEFER until investigation complete

---

## 📄 PHASE 3F: WooCommerce Template Overrides

### Source: Child themes `woocommerce/` directories

### Priority: **HIGH** - Product Display Customization

All child themes have custom WooCommerce templates that need migration.

### 🎨 **Multi-Layout Architecture Strategy**

**Challenge:** Each product family needs different layouts:
- **Corporate/Thermal:** Custom banners, category tiles
- **MEI VAC:** Spec-focused, technical data tables
- **Thermal Electric:** Performance graphs, module configurations

**Solution: Hybrid Approach** (Multiple options - choose based on complexity)

---

### **Option 1: WooCommerce Template Hierarchy** ⭐⭐⭐ **RECOMMENDED**

**How it works:** WooCommerce supports taxonomy-based template files

**Structure:**
```
ferrotec-woocommerce/woocommerce/
├── archive-product.php                           (fallback/default)
├── taxonomy-product_cat.php                      (all categories fallback)
├── taxonomy-product_cat-meivac.php               (MEI VAC products)
├── taxonomy-product_cat-thermal-modules.php      (Thermal Electric)
├── taxonomy-product_cat-ferrofluid.php           (Ferrofluid)
├── taxonomy-product_cat-vacuum-feedthrough.php   (VF products)
│
├── single-product.php                            (fallback/default)
├── single-product-meivac.php                     (MEI VAC single)
├── single-product-thermal.php                    (Thermal single)
└── content-single-product.php                    (shared content)
```

**Benefits:**
- ✅ Clean separation of layouts
- ✅ WordPress native (no complex conditionals)
- ✅ Easy to maintain per product family
- ✅ Template overrideable by theme if needed
- ✅ Each team can work on their product family independently

**Implementation:**
```php
// Plugin registers custom template locations
add_filter( 'woocommerce_locate_template', 'ft_woo_plugin_templates', 10, 3 );
function ft_woo_plugin_templates( $template, $template_name, $template_path ) {
    // Check if plugin has this template
    $plugin_template = plugin_dir_path( __FILE__ ) . 'woocommerce/' . $template_name;

    if ( file_exists( $plugin_template ) ) {
        return $plugin_template;
    }

    return $template;
}
```

---

### **Option 2: Single Template with Product Category Conditionals** ⭐⭐

**How it works:** One template file with `if/else` logic

**Structure:**
```php
// In single-product.php or archive-product.php
$product_cats = get_the_terms( get_the_ID(), 'product_cat' );
$cat_slugs = wp_list_pluck( $product_cats, 'slug' );

if ( in_array( 'meivac', $cat_slugs ) ) {
    get_template_part( 'template-parts/product/meivac-layout' );
} elseif ( in_array( 'thermal-modules', $cat_slugs ) ) {
    get_template_part( 'template-parts/product/thermal-layout' );
} elseif ( in_array( 'ferrofluid', $cat_slugs ) ) {
    get_template_part( 'template-parts/product/ferrofluid-layout' );
} else {
    get_template_part( 'template-parts/product/default-layout' );
}
```

**Benefits:**
- ✅ Single entry point
- ✅ Template parts still separated
- ✅ Easy to add new product families

**Drawbacks:**
- ❌ More complex main template
- ❌ All template parts must exist

---

### **Option 3: Hook-Based Layout System** ⭐⭐⭐ **MOST FLEXIBLE**

**How it works:** Base template + hooks that inject category-specific content

**Structure:**
```php
// Base template (single-product.php)
do_action( 'ft_woo_before_product_content' );

// Default product layout
woocommerce_template_single_title();
woocommerce_template_single_price();

do_action( 'ft_woo_product_content' ); // Category-specific content here

woocommerce_output_product_data_tabs();

do_action( 'ft_woo_after_product_content' );
```

**Plugin registers category-specific hooks:**
```php
// In plugin class for MEI VAC
add_action( 'ft_woo_product_content', 'ft_meivac_product_content', 10 );
function ft_meivac_product_content() {
    if ( ! ft_is_product_category( 'meivac' ) ) return;

    // MEI VAC specific layout
    include plugin_dir_path( __FILE__ ) . 'templates/meivac-content.php';
}

// In plugin class for Thermal
add_action( 'ft_woo_product_content', 'ft_thermal_product_content', 10 );
function ft_thermal_product_content() {
    if ( ! ft_is_product_category( 'thermal-modules' ) ) return;

    // Thermal specific layout
    include plugin_dir_path( __FILE__ ) . 'templates/thermal-content.php';
}
```

**Benefits:**
- ✅ Extremely flexible
- ✅ No template file duplication
- ✅ Easy to extend
- ✅ Can be combined with Options 1 or 2

---

### **Option 4: ACF Layout Fields** ⭐ **DATABASE-DRIVEN**

**How it works:** Store layout preferences in ACF fields per category

**Structure:**
```php
// Get category layout settings
$term_id = get_queried_object_id();
$layout_type = get_field( 'category_layout_type', 'product_cat_' . $term_id );

switch ( $layout_type ) {
    case 'technical':
        // MEI VAC style - focus on specs
        break;
    case 'marketing':
        // Corporate style - focus on benefits
        break;
    case 'performance':
        // Thermal style - focus on graphs
        break;
}
```

**Benefits:**
- ✅ Non-developers can change layouts
- ✅ Very flexible
- ✅ No code changes for layout switches

**Drawbacks:**
- ❌ More complex setup
- ❌ Database-dependent

---

### **🎯 RECOMMENDED APPROACH: Hybrid (Option 1 + Option 3)**

**Best of both worlds:**

1. **Use WooCommerce template hierarchy** for major layout differences
2. **Use hooks** for fine-tuning within each layout
3. **Use ACF** for content customization (banners, colors, etc.)

**Final Structure:**
```
ferrotec-woocommerce/
├── woocommerce/
│   ├── taxonomy-product_cat-meivac.php           (MEI VAC layout)
│   ├── taxonomy-product_cat-thermal-modules.php  (Thermal layout)
│   ├── taxonomy-product_cat-ferrofluid.php       (Ferrofluid layout)
│   └── archive-product.php                       (default fallback)
│
├── includes/
│   ├── class-ft-woo-meivac.php                   (MEI VAC hooks/functions)
│   ├── class-ft-woo-thermal.php                  (Thermal hooks/functions)
│   └── class-ft-woo-ferrofluid.php               (Ferrofluid hooks/functions)
│
└── templates/
    ├── meivac/
    │   ├── product-header.php
    │   ├── specs-table.php
    │   └── ordering-info.php
    ├── thermal/
    │   ├── product-header.php
    │   ├── performance-graph.php
    │   └── family-selector.php
    └── ferrofluid/
        ├── product-header.php
        └── properties-table.php
```

---

#### 1. Archive Product Templates (Shop Pages) ⭐⭐⭐
**Destination:** `ferrotec-woocommerce/woocommerce/`

**Files to Migrate:**
```
old-themes/child-corporate/woocommerce/archive-product.php    → taxonomy-product_cat-thermal-modules.php
old-themes/child-meivac/woocommerce/archive-product.php       → taxonomy-product_cat-meivac.php
old-themes/child-thermalelectric/woocommerce/archive-product.php → taxonomy-product_cat-thermal-modules.php (merge)
```

**Features:**
- Custom page banners with product line branding (→ ACF fields)
- Custom intro content per product line (→ ACF wysiwyg)
- Product category tiles/links (→ template parts)
- Custom layout with Bootstrap grid

**Migration Strategy:**
1. Create taxonomy-based template files (WordPress native hierarchy)
2. Extract common elements into shared template parts
3. Store banner images/text in ACF category fields
4. Use hooks for product family-specific customizations
5. Test each product category independently

#### 2. Single Product Templates ⭐⭐⭐
**Destination:** `ferrotec-woocommerce/woocommerce/`

**Files to Migrate:**
```
old-themes/child-corporate/woocommerce/single-product.php         → (analyze for thermal layout)
old-themes/child-corporate/woocommerce/content-single-product.php → template-parts/thermal-content.php
old-themes/child-meivac/woocommerce/single-product.php            → (analyze for MEI VAC layout)
old-themes/child-meivac/woocommerce/content-single-product.php    → template-parts/meivac-content.php
old-themes/child-thermalelectric/woocommerce/single-product.php   → (merge with corporate)
old-themes/child-thermalelectric/woocommerce/content-single-product.php → (merge)
```

**Product Family Specific Features:**

**MEI VAC Products:**
- Technical specs emphasis
- Detailed attribute tables (already in Phase 2A-2)
- Custom tabs: Description, Ordering, Downloads (already in Phase 2A-1)
- Part number prominence
- ACF fields for step files

**Thermal Products:**
- Performance data emphasis
- Module configuration details
- Family grouping/navigation
- Temperature/power curves (graphs)
- Dimensional drawings

**Ferrofluid Products:**
- Chemical properties tables
- Saturation/viscosity data (ACF fields)
- Application guidance
- Safety/handling information

**Migration Strategy:**
1. **Option A (Recommended):** Create category-specific single product templates:
   - `single-product-meivac.php`
   - `single-product-thermal.php`
   - `single-product-ferrofluid.php`
   - `single-product.php` (fallback)

2. **Option B:** Single template with hooks:
   ```php
   // In single-product.php
   do_action( 'ft_woo_single_product_before_content' );

   woocommerce_template_single_title();
   woocommerce_template_single_price();

   // Product family-specific content injected here
   do_action( 'ft_woo_single_product_content' );

   woocommerce_output_product_data_tabs(); // Uses Phase 2A-1 tab system

   do_action( 'ft_woo_single_product_after_content' );
   ```

3. Extract shared components:
   - Product title formatting
   - Price display
   - Add to cart button
   - Breadcrumbs

4. Create family-specific template parts:
   - `templates/meivac/single-product-content.php`
   - `templates/thermal/single-product-content.php`
   - `templates/ferrofluid/single-product-content.php`

5. Integrate with existing systems:
   - Custom tabs (Phase 2A-1)
   - Attribute tables (Phase 2A-2)
   - ACF fields per product family

---

## 📄 PHASE 3G: Custom Page Templates

### Priority: **MEDIUM** - Special Pages

#### 1. WooCommerce-Based Page Templates ✅ **MIGRATE**
**Destination:** `layers2025/page-templates/`

**Templates to Migrate:**

##### page-te_all_prods.php ⭐⭐ (Thermal Electric All Products)
```
Source: old-themes/child-thermalelectric/page-te_all_prods.php
Template Name: Thermoelectric All Models Page
```
- **Already uses WooCommerce!** (WP_Query)
- Displays all thermal electric products in sortable table
- Tablesorter.js integration
- 12 columns of product data

**Migration Strategy:**
1. Migrate to new theme page-templates/
2. Update Bootstrap classes (v3 → v5)
3. Verify tablesorter still works
4. Test with actual TE products

---

#### 2. ACF-Based Page Templates ⚠️ **REVIEW**
**May need rewriting or removal**

##### page-teproducts.php (Single TE Product Page)
```
Source: old-themes/layers2/page-teproducts.php
Template Name: Thermoelectric Product Page
```
- Uses ACF fields directly (not WooCommerce)
- Raphael.js graphs for product specs
- Modal popups for expanded graphs
- **QUESTION:** Still needed if using WooCommerce single product template?

**Migration Decision:**
- If TE products are in WooCommerce, use single-product.php instead
- If keeping, need to verify ACF field structure
- Raphael.js dependency (consider Chart.js alternative)

##### page-ferrofluidproducts.php
```
Source: old-themes/layers2/page-ferrofluidproducts.php
Template Name: Ferrofluid Product Page
```
- Uses template part: content-ferrofluidproducts
- **QUESTION:** Is this still used if ferrofluid products are in WooCommerce?

**Migration Decision:** Review if needed

---

#### 3. Legacy fProducts Templates ❌ **DO NOT MIGRATE**

**These use external fProducts database - skip migration:**

```php
❌ page-vfproducts.php           // VF product catalog (uses fProducts)
❌ page-tecatalog.php            // TE catalog (uses fProducts)
❌ page-ferrofluidcatalog.php    // Ferrofluid catalog (uses fProducts)
❌ page-vfcatalog.php            // VF catalog (uses fProducts)
❌ page-terecommend.php          // TE recommender tool (uses fProducts)
```

**Replacement:** Use WooCommerce shop pages and categories instead

---

## 📁 Template Files Migration Summary

### WooCommerce Templates (Plugin)

**Destination:** `ferrotec-woocommerce/templates/` or `ferrotec-woocommerce/woocommerce/`

```
WooCommerce Template Overrides (9 files):
├── woocommerce/
│   ├── archive-product.php              (consolidated from 3 child themes)
│   ├── single-product.php               (consolidated from 3 child themes)
│   └── content-single-product.php       (consolidated from 3 child themes)

Product Tabs (9 files):
├── tabs/
│   ├── description.php
│   ├── description-aqua-lok.php
│   ├── description-mak-sputter.php
│   ├── description-power-supplies.php
│   ├── description-substrate-heaters.php
│   ├── description-vari-q-throttle-valves.php
│   ├── ordering.php
│   ├── ordering-aqua-lok.php
│   └── downloads.php

Product Listings (5 files):
├── listings/
│   ├── default.php
│   ├── e-vap.php
│   ├── mak-sputter.php
│   ├── re-vap.php
│   └── vari-q-throttle-valves.php

Single Product (1 file):
└── single-product/
    └── specs-table.php
```

### Theme Templates

**Destination:** `layers2025/`

```
Page Templates (1 file):
├── page-templates/
│   └── page-te_all_prods.php           (Thermal Electric All Products listing)

Template Parts:
├── template-parts/
│   ├── content/
│   │   └── [already migrated]
│   │
│   └── shortcodes/
│       ├── block-content.php
│       ├── menu-display.php
│       ├── news-listing.php
│       ├── pr-listing.php
│       ├── events-webinars.php
│       └── resource-accordion.php
```

### Legacy Templates - DO NOT MIGRATE ❌

**fProducts-based catalog pages (skip):**
```
❌ page-vfproducts.php           (VF product catalog - uses fProducts)
❌ page-tecatalog.php            (TE catalog - uses fProducts)
❌ page-ferrofluidcatalog.php    (Ferrofluid catalog - uses fProducts)
❌ page-vfcatalog.php            (VF catalog - uses fProducts)
❌ page-terecommend.php          (TE recommender - uses fProducts)
```

**ACF-based product pages (review before migration):**
```
⚠️ page-teproducts.php           (TE product page - uses ACF/Raphael.js)
⚠️ page-ferrofluidproducts.php   (Ferrofluid product - uses template parts)
```

---

## 📊 Migration Priority Matrix

### CRITICAL (Do First)
1. ✅ WooCommerce Product Tabs (Phase 2A-1)
2. ✅ Product Attribute Tables (Phase 2A-2)
3. ✅ MEI VAC Product Listing Shortcodes (Phase 2A-3)
4. ✅ Custom Post Types (Phase 3A-1)

### HIGH (Do Second)
5. ⬜ WooCommerce Single Product Templates (Phase 3F-2)
6. ⬜ WooCommerce Archive Templates (Phase 3F-1)
7. ⬜ Ferrofluid & Feedthrough Shortcodes (Phase 2B-1, 2B-2)
8. ⬜ Content Shortcodes (Phase 3A-2)
9. ⬜ Helper Functions (Phase 2A-4)

### MEDIUM (Do Third)
10. ⬜ page-te_all_prods.php Template (Phase 3G-1)
11. ⬜ Search Customization (Phase 3B)
12. ⬜ Widget Areas (Phase 3D)
13. ⬜ Excerpt/Read More Customization (Phase 3C-2)

### LOW (Do Last / Review)
14. ⬜ ACF-Based Product Pages (Phase 3G-2) - Review if needed
15. ⬜ SVG Upload Support (Phase 3C-3)
16. ⬜ Custom Indexing (Phase 3B-2) - Verify still needed
17. ⬜ Password Reset Form (Phase 3E) - Investigate first

---

## ⚠️ Blockers & Investigations Needed

### 1. Hardcoded Page IDs
**Location:** `meivac_scripts()` - Lines 24, 33
**Pages:** 398, 53
**Action:** Replace with page slugs or template detection

### 2. WooCommerce Product Attributes for Feedthrough Products
**Location:** `show_vf_feedthroughs()` rewrite
**Action:** Verify or create WooCommerce attributes:
- `pa_shaft_type`, `pa_mount_type`, `pa_environment`, `pa_temperature`, `pa_unit_system`

### 3. ACF Fields for Ferrofluid Products
**Location:** `show_ferrofluid_products()`
**Action:** Verify WooCommerce products have ACF fields:
- `model`, `sat_guass`, `sat_mt`, `vis_cp`, `sat_mpa_s`

### 4. Custom Database Queries
**Location:** Multiple shortcodes
**Action:** Review for SQL injection risks, add escaping

### 5. Legacy Bootstrap Classes
**Location:** Throughout shortcode output
**Action:** Update Bootstrap 3 → Bootstrap 5

---

## 🔄 Modern WordPress Improvements

### PHASE 4: Gutenberg Block Conversion (Optional Enhancement)

**Priority:** OPTIONAL - Can be done after main migration

Converting legacy shortcodes to native Gutenberg blocks provides better UX for content editors. Here's how to convert each type:

---

### **Conversion 1: [show_block] → Reusable Block Pattern** ⭐ **EASIEST**

**Current:** Shortcode that displays auc_block post content
```php
[show_block id="123"]
```

**New Approach:** Use WordPress native Reusable Blocks (no code needed!)

**Migration Steps:**

1. **Manual Migration (Immediate):**
   ```
   - No code changes needed
   - Edit page with [show_block id="123"]
   - Copy content from auc_block post #123
   - Paste into page as regular blocks
   - Save as Reusable Block if needed multiple times
   - Delete old auc_block post
   ```

2. **OR Keep Shortcode:** It still works! No migration required.

3. **OR Create Block Pattern (Advanced):**
   ```php
   // In layers2025/inc/block-patterns.php

   function layers2025_register_block_patterns() {
       // Export auc_block posts as block patterns
       $blocks = get_posts( array( 'post_type' => 'auc_block' ) );

       foreach ( $blocks as $block ) {
           register_block_pattern(
               'layers2025/' . sanitize_title( $block->post_title ),
               array(
                   'title'       => $block->post_title,
                   'description' => 'Reusable content: ' . $block->post_title,
                   'content'     => $block->post_content,
                   'categories'  => array( 'text' ),
               )
           );
       }
   }
   add_action( 'init', 'layers2025_register_block_patterns' );
   ```

**Recommendation:** Use native Reusable Blocks - no code needed!

---

### **Conversion 2: [show_recent_pr] → Query Loop Block** ⭐⭐ **MEDIUM**

**Current:** Shortcode that displays recent press releases
```php
[show_recent_pr items="5"]
```

**New Approach:** Use WordPress Core Query Loop block (WordPress 5.8+)

**Migration Steps:**

**Option A: Use Core Query Loop Block (No Code)** ✅ **RECOMMENDED**

1. Remove `[show_recent_pr items="5"]` shortcode
2. Add **Query Loop** block in Gutenberg
3. Configure Query Loop settings:
   ```
   - Post Type: auc_press
   - Posts per page: 5
   - Order by: Date
   - Order: Descending
   ```
4. Customize inner blocks:
   ```
   - Post Title
   - Post Date
   - Post Excerpt (optional)
   - Read More button
   ```
5. Style with theme CSS or add custom classes

**Option B: Create Block Variation (Code)** ⭐ **MORE REUSABLE**

```javascript
// In layers2025/assets/js/block-variations.js

wp.blocks.registerBlockVariation( 'core/query', {
    name: 'recent-press-releases',
    title: 'Recent Press Releases',
    description: 'Display recent press releases',
    icon: 'megaphone',
    attributes: {
        query: {
            postType: 'auc_press',
            perPage: 5,
            orderBy: 'date',
            order: 'desc',
        },
        namespace: 'layers2025/recent-pr',
    },
    scope: [ 'inserter' ],
    innerBlocks: [
        [ 'core/post-template', {}, [
            [ 'core/post-title', { isLink: true } ],
            [ 'core/post-date' ],
            [ 'core/post-excerpt' ],
            [ 'core/separator' ],
        ] ],
    ],
} );
```

```php
// In layers2025/inc/enqueue-scripts.php

function layers2025_enqueue_block_variations() {
    wp_enqueue_script(
        'layers2025-block-variations',
        get_template_directory_uri() . '/assets/js/block-variations.js',
        array( 'wp-blocks', 'wp-dom-ready', 'wp-edit-post' ),
        filemtime( get_template_directory() . '/assets/js/block-variations.js' )
    );
}
add_action( 'enqueue_block_editor_assets', 'layers2025_enqueue_block_variations' );
```

**Benefits:**
- ✅ Appears in block inserter as "Recent Press Releases"
- ✅ Pre-configured settings
- ✅ Editors can still customize
- ✅ No PHP code in theme

**Backward Compatibility:**
Keep shortcode working for old content:
```php
// Keep in layers2025/inc/shortcodes-content.php
function show_recent_pr( $atts ) {
    // Original shortcode code
    // Add note: "Consider using Query Loop block instead"
}
add_shortcode( 'show_recent_pr', 'show_recent_pr' );
```

---

### **Conversion 3: [show_events_and_webinars] → Custom ACF Block** ⭐⭐⭐ **ADVANCED**

**Current:** Complex shortcode with filtering/sorting
```php
[show_events_and_webinars]
```

**New Approach:** Create custom ACF Block

**Why ACF Block:**
- Complex logic needs custom code
- ACF provides great admin UX
- Live preview in editor
- Can expose settings to editors

**Migration Steps:**

**Step 1: Register ACF Block**

```php
// In layers2025/inc/acf-blocks.php OR layers2025/functions.php

function layers2025_register_acf_blocks() {
    if ( ! function_exists( 'acf_register_block_type' ) ) {
        return;
    }

    acf_register_block_type( array(
        'name'              => 'events-webinars',
        'title'             => __( 'Events & Webinars', 'layers2025' ),
        'description'       => __( 'Display upcoming events and webinars', 'layers2025' ),
        'render_template'   => 'blocks/events-webinars/events-webinars.php',
        'category'          => 'widgets',
        'icon'              => 'calendar-alt',
        'keywords'          => array( 'events', 'webinars', 'calendar' ),
        'mode'              => 'preview',
        'supports'          => array(
            'align'           => array( 'wide', 'full' ),
            'anchor'          => true,
            'customClassName' => true,
        ),
        'example'  => array(
            'attributes' => array(
                'mode' => 'preview',
                'data' => array(
                    'is_preview' => true,
                ),
            ),
        ),
    ) );
}
add_action( 'acf/init', 'layers2025_register_acf_blocks' );
```

**Step 2: Create ACF Fields for Block Settings**

```php
// In layers2025/acf-json/group_events_webinars_block.json
// OR create in ACF admin interface

{
    "key": "group_events_webinars_block",
    "title": "Events & Webinars Block",
    "fields": [
        {
            "key": "field_events_count",
            "label": "Number of Events",
            "name": "events_count",
            "type": "number",
            "default_value": 5,
            "min": 1,
            "max": 20
        },
        {
            "key": "field_show_filter",
            "label": "Show Filter Options",
            "name": "show_filter",
            "type": "true_false",
            "default_value": 1,
            "ui": 1
        },
        {
            "key": "field_event_types",
            "label": "Event Types to Display",
            "name": "event_types",
            "type": "checkbox",
            "choices": {
                "webinar": "Webinars",
                "conference": "Conferences",
                "training": "Training Sessions"
            },
            "default_value": ["webinar", "conference"]
        }
    ],
    "location": [
        [
            {
                "param": "block",
                "operator": "==",
                "value": "acf/events-webinars"
            }
        ]
    ]
}
```

**Step 3: Create Block Template**

```php
// In layers2025/blocks/events-webinars/events-webinars.php

<?php
/**
 * Events & Webinars Block Template
 *
 * @param array $block The block settings and attributes.
 * @param string $content The block inner HTML (empty).
 * @param bool $is_preview True during AJAX preview.
 * @param int|string $post_id The post ID this block is saved to.
 */

// Get ACF field values
$events_count = get_field( 'events_count' ) ?: 5;
$show_filter  = get_field( 'show_filter' );
$event_types  = get_field( 'event_types' ) ?: array( 'webinar', 'conference' );

// Preview mode check
$is_preview = isset( $block['data']['is_preview'] ) && $block['data']['is_preview'];

// Block classes
$class_name = 'events-webinars-block';
if ( ! empty( $block['className'] ) ) {
    $class_name .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
    $class_name .= ' align' . $block['align'];
}

// Query events
$args = array(
    'post_type'      => 'auc_events',
    'posts_per_page' => $events_count,
    'orderby'        => 'meta_value',
    'meta_key'       => 'event_date',
    'order'          => 'ASC',
    'meta_query'     => array(
        array(
            'key'     => 'event_date',
            'value'   => date( 'Y-m-d' ),
            'compare' => '>=',
            'type'    => 'DATE',
        ),
    ),
);

// Add event type filtering
if ( ! empty( $event_types ) ) {
    $args['meta_query'][] = array(
        'key'     => 'event_type',
        'value'   => $event_types,
        'compare' => 'IN',
    );
}

$events_query = new WP_Query( $args );
?>

<div class="<?php echo esc_attr( $class_name ); ?>">

    <?php if ( $is_preview ) : ?>
        <div style="padding: 20px; background: #f0f0f1; border: 1px dashed #ccc;">
            <p><strong>Events & Webinars Block Preview</strong></p>
            <p>Showing <?php echo esc_html( $events_count ); ?> upcoming events</p>
        </div>
    <?php endif; ?>

    <?php if ( $show_filter ) : ?>
        <div class="events-filter">
            <!-- Filter UI here -->
            <button data-filter="all">All Events</button>
            <button data-filter="webinar">Webinars</button>
            <button data-filter="conference">Conferences</button>
        </div>
    <?php endif; ?>

    <?php if ( $events_query->have_posts() ) : ?>
        <div class="events-list">
            <?php while ( $events_query->have_posts() ) : $events_query->the_post(); ?>
                <article class="event-item">
                    <h3><?php the_title(); ?></h3>
                    <div class="event-date">
                        <?php
                        $event_date = get_field( 'event_date' );
                        echo $event_date ? date( 'F j, Y', strtotime( $event_date ) ) : '';
                        ?>
                    </div>
                    <div class="event-excerpt">
                        <?php the_excerpt(); ?>
                    </div>
                    <a href="<?php the_permalink(); ?>" class="event-link">
                        Learn More →
                    </a>
                </article>
            <?php endwhile; ?>
        </div>
    <?php else : ?>
        <p>No upcoming events found.</p>
    <?php endif; ?>

    <?php wp_reset_postdata(); ?>

</div>
```

**Step 4: Add Block Styles (Optional)**

```css
/* In layers2025/assets/css/blocks/events-webinars.css */

.events-webinars-block {
    margin: 2rem 0;
}

.events-filter {
    display: flex;
    gap: 1rem;
    margin-bottom: 2rem;
}

.events-filter button {
    padding: 0.5rem 1rem;
    border: 1px solid #ddd;
    background: #fff;
    cursor: pointer;
    transition: all 0.3s;
}

.events-filter button:hover,
.events-filter button.active {
    background: var(--ft-blue);
    color: white;
    border-color: var(--ft-blue);
}

.events-list {
    display: grid;
    gap: 2rem;
}

.event-item {
    padding: 1.5rem;
    border: 1px solid #e0e0e0;
    border-radius: 8px;
}

.event-item h3 {
    margin-top: 0;
}

.event-date {
    color: var(--ft-blue);
    font-weight: 600;
    margin-bottom: 1rem;
}
```

**Enqueue block styles:**
```php
function layers2025_enqueue_block_styles() {
    wp_enqueue_style(
        'layers2025-events-block',
        get_template_directory_uri() . '/assets/css/blocks/events-webinars.css',
        array(),
        filemtime( get_template_directory() . '/assets/css/blocks/events-webinars.css' )
    );
}
add_action( 'wp_enqueue_scripts', 'layers2025_enqueue_block_styles' );
add_action( 'enqueue_block_editor_assets', 'layers2025_enqueue_block_styles' );
```

---

### **Comparison: Shortcode vs Block**

| Feature | Shortcode | Gutenberg Block |
|---------|-----------|-----------------|
| **Editor UX** | Text-based, no preview | Visual, live preview |
| **Settings** | Must remember syntax | GUI with form fields |
| **Flexibility** | Fixed in code | Customizable per instance |
| **Learning Curve** | Low (type shortcode) | Medium (find block) |
| **Future-proof** | Still supported | WordPress direction |
| **SEO** | Content in shortcode | Content in blocks (better) |

---

### **Migration Priority for Block Conversion**

**Now (During Migration):**
- ✅ Keep all shortcodes working (backward compatibility)
- ✅ Already created: Content Section ACF Block (done!)
- ✅ Already created: Page Headers ACF fields (done!)

**Phase 5 (After Launch - Optional):**
- ⬜ Convert [show_recent_pr] → Query Loop variation
- ⬜ Convert [show_events_and_webinars] → ACF block
- ⬜ Create block patterns for common layouts
- ⬜ Add editor guide for block usage

**Don't Convert (Keep as Shortcodes):**
- `[show_meivac_products]` - Complex product queries, shortcode is fine
- `[ferrofluid_products]` - Product-specific, keep as shortcode
- `[show_feedthroughs]` - Filtering logic, shortcode is better
- Product-related shortcodes - These are fine as shortcodes!

---

### **Implementation Checklist: Gutenberg Blocks**

```
Phase 4 (Optional - Post-Launch):
□ Create block variations for Query Loop
  □ Recent PR variation
  □ Recent News variation
  □ Events listing variation

□ Create ACF Blocks for complex shortcodes
  □ Events & Webinars block
  □ Resource Accordion block
  □ Register ACF field groups
  □ Create block templates
  □ Add block styles

□ Create Block Patterns
  □ Export auc_block posts as patterns
  □ Create common page layouts
  □ Hero section patterns
  □ CTA patterns

□ Documentation
  □ Block usage guide for editors
  □ Migration guide from shortcodes
  □ Video tutorials (optional)

□ Backward Compatibility
  □ Keep all shortcodes working
  □ Add deprecation notices (optional)
  □ Gradual content migration plan
```

---

### **Resources & Documentation**

- [Block Editor Handbook](https://developer.wordpress.org/block-editor/)
- [ACF Blocks Documentation](https://www.advancedcustomfields.com/resources/blocks/)
- [Block Patterns](https://developer.wordpress.org/block-editor/reference-guides/block-api/block-patterns/)
- [Query Loop Block](https://developer.wordpress.org/block-editor/reference-guides/core-blocks/#query-loop)

---

### **Other Modern Enhancements**

2. **Replace String Concatenation**
   - Current: `$output .= '<div>...</div>';`
   - Modern: Use template parts with `get_template_part()`

3. **Add REST API Endpoints**
   - For AJAX product filtering
   - For dynamic content loading

4. **Implement Caching**
   - Cache expensive queries (meta_list, product listings)
   - Use transients for query results

5. **Add Unit Tests**
   - Test shortcode output
   - Test attribute filtering
   - Test helper functions

---

## 📝 Implementation Checklist

### Phase 2A: WooCommerce Plugin - Estimated 2-3 weeks

```
Plugin Structure:
□ Create ferrotec-woocommerce/ directory
□ Create main plugin file with header
□ Create includes/ directory structure
□ Create templates/ directory structure
□ Create assets/ directory (CSS, JS)

Product Tabs:
□ Create class-ft-woo-tabs.php
□ Implement tab customization filter
□ Migrate 9 tab template files
□ Test with different product categories
□ Add ACF step_file conditional logic

Product Attributes:
□ Create class-ft-woo-attributes.php
□ Implement custom action hook
□ Create specs table template
□ Add label mapping system
□ Test attribute filtering

Product Listings:
□ Create class-ft-woo-shortcodes.php
□ Register show_meivac_products shortcode
□ Migrate 5 listing template files
□ Test shortcode in pages
□ Add template override system

Helper Functions:
□ Create helpers.php
□ Migrate meta_list() functions
□ Add proper sanitization
□ Implement query caching

Scripts:
□ Migrate JavaScript files
□ Update script enqueue logic
□ Replace hardcoded page IDs
□ Test table sorting functionality
```

### Phase 3A: Custom Post Types - Estimated 1 week

```
CPT Registration:
□ Create inc/custom-post-types.php
□ Register auc_block CPT
□ Register auc_events CPT
□ Register auc_press CPT
□ Register auc_news CPT
□ Register auc_resources CPT
□ Add REST API support

Templates:
□ Create archive-auc_press.php
□ Create single-auc_press.php
□ Create archive-auc_news.php
□ Create archive templates for others
□ Test CPT displays
```

### Phase 3B: Content Shortcodes - Estimated 1-2 weeks

```
Shortcode Implementation:
□ Create inc/shortcodes-content.php
□ Migrate [show_block]
□ Migrate [show_menu]
□ Migrate [show_recent_news]
□ Migrate [show_recent_pr]
□ Migrate [show_homepage_pr]
□ Migrate [show_events_and_webinars]
□ Migrate [show_resource_accordion]
□ Create template files for each
□ Test all shortcodes in content
```

### Phase 3C: Search & Utilities - Estimated 3-5 days

```
Search:
□ Create inc/search-customization.php
□ Migrate Relevanssi filters
□ Migrate custom indexing
□ Test search functionality

Utilities:
□ Migrate excerpt customization
□ Migrate SVG upload support
□ Update helper functions
□ Test all filters
```

---

## 🎯 Success Criteria

### Functionality Parity
- [ ] All WooCommerce customizations working
- [ ] All shortcodes functional
- [ ] All custom post types registered
- [ ] Search working with Relevanssi
- [ ] Product listings displaying correctly

### Code Quality
- [ ] Modern WordPress coding standards
- [ ] Proper sanitization and escaping
- [ ] No security vulnerabilities
- [ ] Template hierarchy respected
- [ ] Hooks and filters documented

### Performance
- [ ] No N+1 query issues
- [ ] Query results cached where appropriate
- [ ] JavaScript optimized and minified
- [ ] CSS consolidated (already done)

### Documentation
- [ ] All shortcodes documented
- [ ] Hook reference created
- [ ] Template override guide written
- [ ] Migration notes for future reference

---

## 📚 Resources Needed

### External Dependencies
- Advanced Custom Fields Pro
- WooCommerce
- Relevanssi (optional)

### Testing Requirements
- Staging environment with:
  - WooCommerce products in all categories
  - Custom post types with content
  - Pages using all shortcodes
  - Thermal electric product data
  - MEI VAC product data

### Documentation to Create
- Plugin README.md
- Shortcode usage guide
- Template override guide
- Developer hooks reference
- Migration completion report

---

**Last Updated:** November 18, 2025
**Status:** Planning Complete - Ready for Phase 2 Implementation
**Next Step:** Begin WooCommerce Plugin Creation (Phase 2A-1)
