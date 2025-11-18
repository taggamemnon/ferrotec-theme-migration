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

## 📁 Template Files Migration Summary

### WooCommerce Templates (Plugin)

**Destination:** `ferrotec-woocommerce/templates/`

```
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

### Theme Template Parts

**Destination:** `layers2025/template-parts/`

```
Thermal Electric (2 files):
├── thermal/
│   ├── listing.php
│   └── listing-type.php

Content Types (varies):
├── content/
│   ├── [already migrated]
│
├── shortcodes/
│   ├── block-content.php
│   ├── menu-display.php
│   ├── news-listing.php
│   ├── pr-listing.php
│   ├── events-webinars.php
│   └── resource-accordion.php
```

---

## 📊 Migration Priority Matrix

### CRITICAL (Do First)
1. ✅ WooCommerce Product Tabs (Phase 2A-1)
2. ✅ Product Attribute Tables (Phase 2A-2)
3. ✅ MEI VAC Product Listing Shortcodes (Phase 2A-3)
4. ✅ Custom Post Types (Phase 3A-1)

### HIGH (Do Second)
5. ⬜ Ferrofluid & Feedthrough Shortcodes (Phase 2B-1, 2B-2)
6. ⬜ Content Shortcodes (Phase 3A-2)
7. ⬜ Search Customization (Phase 3B)
8. ⬜ Helper Functions (Phase 2A-4)

### MEDIUM (Do Third)
9. ⬜ Widget Areas (Phase 3D)
10. ⬜ Excerpt/Read More Customization (Phase 3C-2)
11. ⬜ SVG Upload Support (Phase 3C-3)

### LOW (Do Last / Review)
12. ⬜ Custom Indexing (Phase 3B-2) - Verify still needed
13. ⬜ Password Reset Form (Phase 3E) - Investigate first

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

### Opportunities for Enhancement:

1. **Convert Shortcodes to Blocks**
   - [ ] [show_block] → Reusable Block pattern
   - [ ] [show_recent_pr] → Query Loop block
   - [ ] [show_events_and_webinars] → Custom ACF block

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
