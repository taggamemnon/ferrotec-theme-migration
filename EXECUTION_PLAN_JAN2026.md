# Ferrotec Multisite Migration - 6-Week Execution Plan
## Target Go-Live: January 1, 2026

**Status:** Architecture Confirmed | Timeline: 6 weeks | Baseline: Thermal

---

## ✅ Confirmed Architecture

### **WP Engine Multisite Structure**

**9 Active Subsites (10th coming):**

| # | Subdomain | WooCommerce Products? | Child Theme | Priority |
|---|-----------|----------------------|-------------|----------|
| 1 | www.ferrotec.com | Info pages only | child-corporate | HIGH |
| 2 | seals.ferrotec.com | ✅ Yes - Selling | child-seals | HIGH |
| 3 | thermal.ferrotec.com | ✅ Yes - Selling | child-thermalelectric | **BASELINE** |
| 4 | ferrofluid.ferrotec.com | ✅ Yes - Selling | child-ferrofluid | HIGH |
| 5 | quartz.ferrotec.com | Info pages only | (none found) | MEDIUM |
| 6 | ceramics.ferrotec.com | Info pages only | (none found) | MEDIUM |
| 7 | e-beam.ferrotec.com | ✅ Yes - Selling | (none found) | HIGH |
| 8 | temescal.ferrotec.com | Info pages only | (none found) | MEDIUM |
| 9 | meivac.ferrotec.com | ✅ Yes - Selling | child-meivac | HIGH |
| 10 | thinfilm.ferrotec.com | Future | N/A | LOW |

**Note:** meivac, e-beam, and temescal will merge (separate project - not part of this migration)

### **WooCommerce Configuration**

- **Network-wide enabled:** Yes (all subsites)
- **Actively selling products on:** seals, thermal, ferrofluid, e-beam, meivac (5 sites)
- **Info-only "products" on:** www (corporate), quartz, ceramics, temescal (4 sites)

**Product Complexity:**
- Some WooCommerce products are orderable (e-commerce)
- Some WooCommerce products are info pages only (no cart/checkout)
- Layouts are complex regardless of orderable status

---

## 🎯 Plugin Strategy

### **Plugin Name Decision**

**Chosen:** `ftc-product-ui` (matches original brief, emphasizes UI components)

**Alternative considered:** `ferrotec-woocommerce` (both acceptable)

### **Plugin Scope**

✅ **Should Handle:**
- WooCommerce product display customization
- Product tabs (Specs, Features, Ordering, Modeling, Downloads, etc.)
- Product attribute tables
- Print view with Chart.js rendering
- Feature flags for per-site tab configuration
- Complex product layouts (orderable + info-only)

❌ **Should NOT Handle:**
- Non-WooCommerce content (handled by theme)
- Theme styling (brand-specific CSS stays in child themes)
- Non-product pages

### **Network Activation**

✅ Plugin will be **network-activated** across all subsites

Per-site customization via:
- Feature flags (admin UI for each subsite)
- ACF field groups with conditional logic
- Template hierarchy (category-specific layouts)

---

## ⏱️ 6-Week Timeline Breakdown

**Today:** November 18, 2025
**Go-Live:** January 1, 2026
**Available Time:** 6 weeks, 2 days (44 days)

### **Week 1: Nov 18-24 (Foundation & ACF Audit)**

**Theme (layers2025):**
- [x] Theme structure created (95% done)
- [x] Bootstrap 5 CDN integration (done)
- [x] CSS consolidated (done)
- [ ] Complete front-page.php
- [ ] Add fonts migration
- [ ] Create screenshot.png
- [ ] Test theme activation on Thermal staging

**Plugin (ftc-product-ui):**
- [ ] Create plugin structure
- [ ] Set up network activation hooks
- [ ] Create feature flag system foundation
- [ ] Add conditional loading (WooCommerce check)

**ACF Audit:**
- [ ] Export all ACF field groups from production
- [ ] Document field name variations across subsites
- [ ] Identify which fields are shared vs. site-specific
- [ ] Create unified naming convention

**Deliverable:** Theme 100% ready, plugin scaffolded, ACF audit complete

---

### **Week 2: Nov 25-Dec 1 (Baseline: Thermal Site)**

**Focus:** Get Thermal site working perfectly (baseline for others)

**Plugin Features (Thermal-specific):**
- [ ] Product tabs system (Specs, Features, Modeling, Ordering)
- [ ] Modeling tab with Chart.js integration
- [ ] ACF fields for thermal products (`thermal_performance_data`, `thermal_modeling_content`)
- [ ] Product attribute tables
- [ ] Template hierarchy for thermal products

**Chart.js Integration:**
- [ ] Chart.js enqueue system
- [ ] Performance graph rendering
- [ ] Responsive chart sizing
- [ ] Data structure for thermal product charts

**Feature Flags (Thermal):**
- [ ] Admin UI for tab toggles
- [ ] Enable: Specs ✓ Features ✓ Modeling ✓ Ordering ✓
- [ ] Test tab visibility per product category

**Testing:**
- [ ] Test 5-10 thermal products
- [ ] Verify charts render correctly
- [ ] Check responsive layouts
- [ ] Test print view (basic)

**Deliverable:** Thermal site fully functional with charts, tabs, and feature flags

---

### **Week 3: Dec 2-8 (High-Priority Sites: Seals, Ferrofluid, MEI VAC)**

**Site-by-Site Migration:**

**Seals (seals.ferrotec.com):**
- [ ] ACF fields: `seal_shaft_type`, `seal_mount_type`, `seal_environment`, `seal_temperature`
- [ ] Tabs: Specs, Features, Ordering, Downloads, Spare Parts
- [ ] VF feedthrough filtering (from child-seals templates)
- [ ] Product attribute tables for seals

**Ferrofluid (ferrofluid.ferrotec.com):**
- [ ] ACF fields: `ferrofluid_saturation_gauss`, `ferrofluid_saturation_mt`, `ferrofluid_viscosity_cp`, `ferrofluid_viscosity_mpa`
- [ ] Tabs: Specs, Features, Ordering, Downloads
- [ ] Chemical properties table template
- [ ] Shortcode: `[ferrofluid_products family="..."]`

**MEI VAC (meivac.ferrotec.com):**
- [ ] Migrate custom WooCommerce tabs from child-meivac
- [ ] Product listing shortcode: `[show_meivac_products category="..."]`
- [ ] Category-specific tab templates
- [ ] Product spec tables with filtering
- [ ] JavaScript table sorting

**Shared Work:**
- [ ] Standardize ACF field names across these 3 sites
- [ ] Create migration scripts (if field names differ)
- [ ] Test feature flags per site

**Deliverable:** 4 sites working (Thermal, Seals, Ferrofluid, MEI VAC)

---

### **Week 4: Dec 9-15 (E-Beam + Print View + Info-Only Sites)**

**E-Beam (e-beam.ferrotec.com):**
- [ ] Identify current templates/functionality
- [ ] Apply product tab system
- [ ] Configure feature flags
- [ ] Test e-beam products

**Info-Only Product Sites:**

**Corporate (www.ferrotec.com):**
- [ ] Product tiles/grids from child-corporate
- [ ] Market sections styling
- [ ] Home banner system
- [ ] Info-only product display (no add-to-cart)

**Quartz, Ceramics, Temescal:**
- [ ] Basic product display templates
- [ ] Info-only layouts
- [ ] Minimal feature flags
- [ ] Navigation/breadcrumbs

**Print View Implementation:** ⭐ **CRITICAL**

**Requirements:**
- Print URL: `?print=1`
- Render Chart.js charts in print
- Handle tabbed content in print layout
- Clean pagination for multi-page products

**Implementation:**
```php
// Detect print mode
FTC_Print_View::is_print_mode() // checks ?print=1

// Print template
templates/print/product-print.php

// Print stylesheet
assets/css/ftc-print.css

// Chart.js print handling
- Render charts as static images for print OR
- Use Chart.js canvas-to-image conversion OR
- Pre-render SVG versions
```

**Chart.js Print Strategy:**
```javascript
// Before print, convert charts to static images
window.onbeforeprint = function() {
    document.querySelectorAll('canvas').forEach(canvas => {
        const img = document.createElement('img');
        img.src = canvas.toDataURL('image/png');
        canvas.style.display = 'none';
        canvas.parentNode.insertBefore(img, canvas);
    });
};

// After print, restore charts
window.onafterprint = function() {
    // Restore canvases
};
```

**Tabbed Content in Print:**
- Show all tab content sequentially (not hidden tabs)
- Page breaks between major sections
- Table of contents for multi-tab products

**Deliverable:** All 9 sites functional, print view working with charts

---

### **Week 5: Dec 16-22 (ACF Migration, Testing, Optimization)**

**ACF Field Migration:** ⚠️ **DATA-CRITICAL**

**Step 1: Backup**
- [ ] Full database backup of all subsites
- [ ] Export all products to CSV (safety net)
- [ ] Document current field usage

**Step 2: Migration Scripts**
```bash
# Run on staging first!
wp ftc migrate-fields --url=thermal.ferrotec.com --dry-run
wp ftc migrate-fields --url=thermal.ferrotec.com --execute
wp ftc validate-migration --url=thermal.ferrotec.com
```

**Step 3: Field Standardization**
- [ ] Rename fields to unified schema
- [ ] Update ACF JSON field groups
- [ ] Sync field groups across subsites
- [ ] Validate data integrity

**Example Field Migrations:**
| Old Field | New Field | Sites Affected |
|-----------|-----------|----------------|
| `step_file` | `product_cad_file` | thermal, seals |
| `sat_guass` (typo) | `ferrofluid_saturation_gauss` | ferrofluid |
| `model` | `product_model` | all |
| `shaft_type` | `seal_shaft_type` | seals |

**Cross-Browser Testing:**
- [ ] Chrome (Windows + Mac)
- [ ] Firefox (Windows + Mac)
- [ ] Safari (Mac + iOS)
- [ ] Edge (Windows)
- [ ] Mobile Chrome (Android)

**Responsive Testing:**
- [ ] Mobile: 375px, 414px (iPhone, Android)
- [ ] Tablet: 768px, 1024px (iPad)
- [ ] Desktop: 1280px, 1440px, 1920px

**Performance Optimization:**
- [ ] Minify CSS/JS
- [ ] Optimize Chart.js loading (only on product pages)
- [ ] Test page load times < 3 seconds
- [ ] Implement conditional plugin loading
- [ ] Cache product queries

**Print Testing:**
- [ ] Test print view on each site
- [ ] Verify charts render in print
- [ ] Check pagination
- [ ] Test multi-tab products

**Deliverable:** All sites tested, optimized, ACF fields migrated safely

---

### **Week 6: Dec 23-29 (Final QA, Documentation, Staging Approval)**

**Holiday Week - Light Development, Heavy Testing**

**Final QA Checklist (Per Subsite):**

**Thermal:**
- [ ] All product tabs working (Specs, Features, Modeling, Ordering)
- [ ] Chart.js graphs render correctly
- [ ] Print view works with charts
- [ ] Feature flags configured correctly
- [ ] ACF fields display correct data
- [ ] Mobile responsive
- [ ] Performance acceptable

**Seals:**
- [ ] VF feedthrough filtering works
- [ ] Product attributes display correctly
- [ ] Downloads tab conditional logic
- [ ] Print view clean

**Ferrofluid:**
- [ ] Chemical properties table accurate
- [ ] Saturation/viscosity data displays
- [ ] Shortcode works: `[ferrofluid_products]`

**MEI VAC:**
- [ ] Custom product listings work
- [ ] Table sorting JavaScript functional
- [ ] Category-specific tabs load

**E-Beam:**
- [ ] Products display correctly
- [ ] E-commerce flow works

**Info Sites (Corporate, Quartz, Ceramics, Temescal):**
- [ ] Info-only products display
- [ ] No cart/checkout shown inappropriately
- [ ] Navigation works
- [ ] Print view acceptable

**Documentation:**
- [ ] **USER_GUIDE.md** - For content editors
  - How to add/edit products
  - How to configure feature flags per site
  - Tab content guidelines
  - Print view tips
- [ ] **DEVELOPER_GUIDE.md** - For future developers
  - Plugin architecture
  - ACF field reference
  - Feature flag system
  - Template hierarchy
  - Hook reference
- [ ] **DEPLOYMENT_GUIDE.md** - For go-live
  - Pre-deployment checklist
  - Deployment steps
  - Rollback procedure
  - Post-deployment verification
- [ ] **CHANGELOG.md** - Version history
- [ ] Update README.md with final architecture

**Staging Approval:**
- [ ] Demo to stakeholders
- [ ] Get sign-off on each subsite
- [ ] Address any last-minute feedback
- [ ] Final backup before production

**Deliverable:** Production-ready plugin and theme, all docs complete

---

### **Week 7: Dec 30-Jan 1 (Deployment)**

**Pre-Deployment (Dec 30):**
- [ ] Final staging tests
- [ ] Database backup (all subsites)
- [ ] File backup (themes, plugins, uploads)
- [ ] Document current ACF field groups
- [ ] Performance baseline snapshot

**Deployment Day (Dec 31):**

**Morning (9 AM - 12 PM):**
- [ ] Maintenance mode ON (all subsites)
- [ ] Upload ftc-product-ui plugin to `/wp-content/plugins/`
- [ ] Upload layers2025 theme to `/wp-content/themes/`
- [ ] Network-activate ftc-product-ui plugin

**Afternoon (12 PM - 3 PM):**
- [ ] Switch Thermal to layers2025 theme
- [ ] Test Thermal thoroughly
- [ ] If successful, switch remaining 8 subsites
- [ ] Configure feature flags per subsite
- [ ] Verify ACF fields display correctly

**Evening (3 PM - 6 PM):**
- [ ] Final smoke tests (all subsites)
- [ ] Test checkout flow (5 e-commerce sites)
- [ ] Test print view (all sites)
- [ ] Check responsive on mobile
- [ ] Maintenance mode OFF

**Post-Deployment (6 PM - 9 PM):**
- [ ] Monitor error logs
- [ ] Check Google Analytics for traffic
- [ ] Test contact forms
- [ ] Verify search works
- [ ] Check for broken links

**Go-Live (Jan 1, 2026):**
- [ ] Announce launch
- [ ] Monitor for 24 hours
- [ ] Address any critical issues
- [ ] Celebrate! 🎉

**Rollback Plan (if needed):**
```bash
# Deactivate new plugin
wp plugin deactivate ftc-product-ui --network

# Reactivate old child themes per subsite
wp theme activate child-thermalelectric --url=thermal.ferrotec.com
wp theme activate child-seals --url=seals.ferrotec.com
# etc.

# Restore database from backup (last resort)
wp db import backup-2025-12-31.sql
```

---

## 🎨 Feature Flag Configuration Per Subsite

**Admin UI Location:** Network Admin → FTC Product UI → Feature Flags

### **Thermal (thermal.ferrotec.com)**
```
✅ Specs Tab
✅ Features Tab
✅ Modeling Tab (UNIQUE TO THERMAL)
✅ Ordering Tab (form)
✅ Downloads Tab
✅ Print View
```

### **Seals (seals.ferrotec.com)**
```
✅ Specs Tab
✅ Features Tab
❌ Modeling Tab
✅ Ordering Tab
✅ Downloads Tab
✅ Spare Parts Tab
✅ Print View
```

### **Ferrofluid (ferrofluid.ferrotec.com)**
```
✅ Specs Tab
✅ Features Tab
❌ Modeling Tab
✅ Ordering Tab
✅ Downloads Tab
❌ Spare Parts Tab
✅ Print View
```

### **MEI VAC (meivac.ferrotec.com)**
```
✅ Specs Tab (custom layout)
✅ Features Tab
❌ Modeling Tab
✅ Ordering Tab
✅ Downloads Tab (conditional on ACF field)
❌ Spare Parts Tab
✅ Print View
```

### **E-Beam (e-beam.ferrotec.com)**
```
✅ Specs Tab
✅ Features Tab
❌ Modeling Tab
✅ Ordering Tab
✅ Downloads Tab
❌ Spare Parts Tab
✅ Print View
```

### **Info-Only Sites (Corporate, Quartz, Ceramics, Temescal)**
```
✅ Specs Tab
✅ Features Tab
❌ Modeling Tab
❌ Ordering Tab (no e-commerce)
✅ Downloads Tab
❌ Spare Parts Tab
❌ Print View (optional)
```

---

## 📊 Chart.js Implementation Strategy

### **Thermal Site Chart Requirements**

**Performance Graphs:**
- Temperature vs. Power curves
- Voltage vs. Current characteristics
- Efficiency curves
- Heat pump vs. cooling capacity

**Chart Types Needed:**
- Line charts (performance curves)
- Scatter plots (data points)
- Multi-axis charts (temperature + power)

**Chart.js Configuration:**
```javascript
// Enqueue Chart.js only on product pages
if ( is_product() || is_product_category() ) {
    wp_enqueue_script(
        'chartjs',
        'https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js',
        [],
        '4.4.0',
        true
    );
}

// Custom chart initialization
wp_enqueue_script(
    'ftc-charts',
    plugins_url( 'assets/js/ftc-charts.js', __FILE__ ),
    ['chartjs'],
    '1.0.0',
    true
);
```

**ACF Field Structure for Charts:**
```php
// Thermal Performance Data (ACF Repeater)
$chart_data = get_field( 'thermal_performance_data' );

// Expected structure:
[
    [
        'label' => 'Hot Side Temperature (°C)',
        'data_points' => '0,10,20,30,40,50',
        'values' => '0,5,15,30,50,75',
        'chart_type' => 'line',
    ],
    [
        'label' => 'Cooling Capacity (W)',
        'data_points' => '0,10,20,30,40,50',
        'values' => '100,90,75,55,30,10',
        'chart_type' => 'line',
    ],
]
```

**Rendering Charts:**
```javascript
// assets/js/ftc-charts.js

document.addEventListener('DOMContentLoaded', function() {
    const chartContainers = document.querySelectorAll('.ftc-chart');

    chartContainers.forEach(container => {
        const chartData = JSON.parse(container.dataset.chartData);
        const ctx = container.querySelector('canvas').getContext('2d');

        new Chart(ctx, {
            type: chartData.type || 'line',
            data: {
                labels: chartData.labels,
                datasets: chartData.datasets
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                    },
                    title: {
                        display: true,
                        text: chartData.title
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: chartData.yAxisLabel
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: chartData.xAxisLabel
                        }
                    }
                }
            }
        });
    });
});
```

**Print View Chart Handling:**
```javascript
// Convert Chart.js canvas to static image for print
window.addEventListener('beforeprint', function() {
    document.querySelectorAll('.ftc-chart canvas').forEach(canvas => {
        // Create image from canvas
        const img = new Image();
        img.src = canvas.toDataURL('image/png', 1.0); // High quality
        img.style.maxWidth = '100%';
        img.className = 'print-chart-image';

        // Hide canvas, show image
        canvas.style.display = 'none';
        canvas.parentNode.insertBefore(img, canvas);
    });
});

window.addEventListener('afterprint', function() {
    // Restore charts
    document.querySelectorAll('.print-chart-image').forEach(img => {
        img.nextSibling.style.display = 'block';
        img.remove();
    });
});
```

---

## 🔧 Plugin Architecture

### **Directory Structure**

```
wp-content/plugins/ftc-product-ui/
├── ftc-product-ui.php                  # Main plugin file (network-activated)
├── readme.txt                          # WordPress.org readme
├── LICENSE                             # GPL v2+
│
├── includes/
│   ├── class-ftc-plugin.php            # Main plugin class
│   ├── class-ftc-tabs.php              # Product tabs system
│   ├── class-ftc-attributes.php        # Attribute tables
│   ├── class-ftc-shortcodes.php        # Shortcodes
│   ├── class-ftc-feature-flags.php     # Per-site feature toggles
│   ├── class-ftc-print-view.php        # Print functionality
│   ├── class-ftc-charts.php            # Chart.js integration
│   ├── class-ftc-template-loader.php   # Template hierarchy
│   └── helpers.php                     # Utility functions
│
├── admin/
│   ├── class-ftc-admin.php             # Admin settings
│   ├── views/
│   │   ├── feature-flags.php           # Feature flag UI
│   │   └── dashboard.php               # Plugin dashboard
│   └── assets/
│       ├── css/admin.css
│       └── js/admin.js
│
├── templates/
│   ├── tabs/
│   │   ├── specs.php                   # Specifications tab
│   │   ├── features.php                # Features tab
│   │   ├── modeling.php                # Modeling tab (Thermal only)
│   │   ├── ordering.php                # Ordering form tab
│   │   ├── downloads.php               # Downloads tab
│   │   ├── spare-parts.php             # Spare parts tab
│   │   └── quote.php                   # Quote request tab
│   │
│   ├── listings/
│   │   ├── product-table.php           # Product table shortcode
│   │   ├── ferrofluid-table.php        # Ferrofluid products
│   │   └── meivac-listing.php          # MEI VAC products
│   │
│   ├── single-product/
│   │   ├── specs-table.php             # Specs table template
│   │   └── chart-container.php         # Chart wrapper
│   │
│   └── print/
│       ├── product-print.php           # Print view template
│       ├── print-header.php            # Print header
│       └── print-footer.php            # Print footer
│
├── assets/
│   ├── css/
│   │   ├── ftc-tabs.css                # Tab styles
│   │   ├── ftc-charts.css              # Chart styles
│   │   ├── ftc-print.css               # Print stylesheet
│   │   └── ftc-main.min.css            # Combined/minified
│   │
│   └── js/
│       ├── ftc-tabs.js                 # Tab interactions
│       ├── ftc-charts.js               # Chart rendering
│       ├── ftc-print.js                # Print preparation
│       └── ftc-main.min.js             # Combined/minified
│
├── migrations/
│   ├── 01-rename-fields.php            # ACF field renaming
│   ├── 02-validate-migration.php       # Data validation
│   └── README.md                       # Migration instructions
│
└── acf-json/
    ├── group_shared_product.json       # Shared product fields
    ├── group_thermal_product.json      # Thermal-specific
    ├── group_ferrofluid_product.json   # Ferrofluid-specific
    └── group_seal_product.json         # Seal-specific
```

### **Main Plugin File**

```php
<?php
/**
 * Plugin Name: FTC Product UI
 * Plugin URI: https://ferrotec.com
 * Description: Network-activated product display system for Ferrotec multisite with tabs, charts, and print views
 * Version: 1.0.0
 * Author: Tagg Swift
 * Author URI: https://auc.com
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Network: true
 * Requires PHP: 8.0
 * Requires at least: 6.0
 * Text Domain: ftc-product-ui
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Define plugin constants
define( 'FTC_PRODUCT_UI_VERSION', '1.0.0' );
define( 'FTC_PRODUCT_UI_FILE', __FILE__ );
define( 'FTC_PRODUCT_UI_PATH', plugin_dir_path( __FILE__ ) );
define( 'FTC_PRODUCT_UI_URL', plugin_dir_url( __FILE__ ) );

// Require WooCommerce
if ( ! class_exists( 'WooCommerce' ) ) {
    add_action( 'admin_notices', function() {
        echo '<div class="error"><p>';
        echo '<strong>FTC Product UI</strong> requires WooCommerce to be installed and active.';
        echo '</p></div>';
    });
    return;
}

// Autoloader
spl_autoload_register( function( $class ) {
    if ( strpos( $class, 'FTC_' ) !== 0 ) {
        return;
    }

    $file = FTC_PRODUCT_UI_PATH . 'includes/class-' . strtolower( str_replace( '_', '-', $class ) ) . '.php';
    if ( file_exists( $file ) ) {
        require_once $file;
    }
});

// Initialize plugin
add_action( 'plugins_loaded', function() {
    FTC_Plugin::instance();
});

// Activation hook
register_activation_hook( __FILE__, [ 'FTC_Plugin', 'activate' ] );

// Deactivation hook
register_deactivation_hook( __FILE__, [ 'FTC_Plugin', 'deactivate' ] );
```

---

## 📋 Critical Success Factors

### **Must-Haves for Go-Live**

✅ **Thermal site working perfectly** (baseline)
- All tabs functional (Specs, Features, Modeling, Ordering)
- Chart.js graphs rendering correctly
- Print view working with charts
- ACF fields displaying correct data

✅ **E-commerce sites functional** (5 sites)
- Thermal, Seals, Ferrofluid, E-Beam, MEI VAC
- Product display correct
- Add to cart working
- Checkout flow tested

✅ **Print view working**
- Charts render in print (all sites with charts)
- Tabbed content displays sequentially
- Clean pagination
- No broken layouts

✅ **Feature flags configurable**
- Admin UI accessible per subsite
- Tabs toggle correctly
- Settings persist

✅ **ACF fields migrated**
- No data loss
- Field names standardized
- Data displays correctly

✅ **Performance acceptable**
- Page load < 3 seconds
- Charts load smoothly
- Mobile responsive

### **Nice-to-Haves (Post-Launch)**

⬜ Spare Parts tab (initially optional)
⬜ Quote request tab (can use Ordering tab initially)
⬜ CAD viewer tab (future enhancement)
⬜ Advanced chart interactivity (zoom, pan)
⬜ CSV export of product data
⬜ Product comparison tool

---

## ⚠️ Risk Mitigation

### **Timeline Risks**

**Risk:** 6 weeks is aggressive for 9 subsites
**Mitigation:**
- Focus on Thermal first (baseline)
- Prioritize e-commerce sites (5) over info sites (4)
- Nice-to-have features deferred to post-launch
- Work in parallel where possible (theme + plugin simultaneously)

**Risk:** Holiday week (Dec 23-29) slows progress
**Mitigation:**
- Front-load development (Weeks 1-4)
- Use Week 6 for testing/docs only
- Deploy Dec 31 (before holiday ends)

### **Technical Risks**

**Risk:** Chart.js print rendering fails
**Mitigation:**
- Test print early (Week 4)
- Fallback: Server-side chart rendering or static images
- Worst case: Print shows "View charts online at [URL]"

**Risk:** ACF field migration causes data loss
**Mitigation:**
- Full database backup before migration
- Dry-run mode for migration scripts
- Validation scripts to check data integrity
- CSV export of all products (safety net)

**Risk:** Multisite plugin conflicts
**Mitigation:**
- Test network activation on staging first
- Conditional loading (only on product pages)
- Namespace all functions (`ftc_` prefix)
- Use WooCommerce hooks properly (no core modifications)

### **Deployment Risks**

**Risk:** Production deployment breaks site
**Mitigation:**
- Thorough staging testing (Week 6)
- Maintenance mode during deployment
- Rollback plan ready (reactivate old themes)
- Deploy Dec 31 (lower traffic than Jan 2)

---

## 📞 Communication Plan

### **Weekly Check-ins**

**Every Monday 10 AM:**
- Review previous week progress
- Identify blockers
- Adjust timeline if needed
- Demo completed features

### **Critical Milestones**

- **Nov 24:** Theme complete, plugin scaffolded, ACF audit done
- **Dec 1:** Thermal site working (BASELINE APPROVAL)
- **Dec 8:** 4 sites working (Thermal, Seals, Ferrofluid, MEI VAC)
- **Dec 15:** All 9 sites working, print view functional
- **Dec 22:** Testing complete, staging approval
- **Dec 31:** Production deployment
- **Jan 1:** GO-LIVE 🎉

### **Escalation Plan**

**If timeline slips:**
1. Identify what can be deferred to post-launch
2. Focus on Thermal + 4 e-commerce sites only for Jan 1
3. Info sites (Corporate, Quartz, Ceramics, Temescal) launch in January
4. Nice-to-have features (Spare Parts, Quote tabs) launch in January

**If critical blocker:**
1. Document issue immediately
2. Explore workarounds
3. Adjust scope if needed
4. Consider extending go-live (last resort)

---

## 🎯 Next Immediate Actions

### **This Week (Nov 18-24):**

**Today (Nov 18):**
- [ ] Review and approve this execution plan
- [ ] Set up WP Engine staging access
- [ ] Export ACF field groups from production (all subsites)

**Tomorrow (Nov 19):**
- [ ] Complete theme (front-page.php, fonts, screenshot)
- [ ] Test theme activation on Thermal staging
- [ ] Create ftc-product-ui plugin structure

**Nov 20-21:**
- [ ] ACF field audit across all subsites
- [ ] Document field name variations
- [ ] Create unified ACF schema

**Nov 22-24:**
- [ ] Build feature flag system
- [ ] Create admin UI for feature flags
- [ ] Set up network activation hooks

**Deliverable by Nov 24:** Theme 100% ready, plugin foundation complete, ACF standardized

---

**Document Version:** 1.0
**Last Updated:** November 18, 2025
**Status:** Ready for Approval
**Next Review:** November 25, 2025 (after Week 1 complete)
