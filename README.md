# Ferrotec Theme Migration Project

## Project Overview

This project migrates the Ferrotec WordPress theme ecosystem from a legacy parent/child theme structure to a modern, maintainable architecture with a new theme (`layers2025`) and a custom WooCommerce plugin (`ferrotec-woocommerce`).

## Project Structure

```
ferrotec-theme-migration/
├── old-themes/                          # Legacy themes (reference only)
│   ├── layers2/                         # Parent theme
│   ├── child-corporate/                 # Corporate site child theme
│   ├── child-ferrofluid/                # Ferrofluid products child theme
│   ├── child-meivac/                    # MEI VAC products child theme
│   ├── child-seals/                     # Seals products child theme
│   └── child-thermalelectric/           # Thermal electric products child theme
├── wp-content/
│   ├── themes/
│   │   └── layers2025/                  # New unified theme (to be created)
│   └── plugins/
│       └── ferrotec-woocommerce/        # Custom WooCommerce plugin (to be created)
└── README.md                            # This file
```

## Old Theme Architecture Analysis

### Parent Theme: `layers2`

**Theme Information:**
- **Theme Name:** Layers
- **Version:** 1.0.0
- **Author:** AUC
- **License:** GPL v2+

**Key Features:**
- Bootstrap 4 grid system integration
- Custom flexbox utilities
- WooCommerce support
- Custom page templates for product catalogs
- Advanced Custom Fields (ACF) integration
- Relevanssi search customization
- Custom navigation menus (Primary, Mobile, Footer)

**Major Components:**
1. **Custom Page Templates** (~14 templates):
   - `page-vfproducts.php` - Vacuum seal/ferrofluid products
   - `page-teproducts.php` - Thermal electric products
   - `page-ferrofluidproducts.php` - Ferrofluid catalog
   - `page-tecatalog.php` - TE catalog
   - `page-vfcatalog.php` - VF catalog
   - `page-resources.php` - Resources page
   - `page-press.php` - Press releases
   - `page-events.php` - Events page
   - `page-register.php` - Registration page
   - `page-terecommend.php` - TE recommendation tool

2. **WooCommerce Customizations:**
   - Custom single product template
   - Custom archive product template
   - Product display modifications

3. **JavaScript Libraries:**
   - Bootstrap 4
   - jQuery Table Sorter
   - Raphael.js
   - Flip Counter
   - Custom scripts for product filtering/recommendation

4. **CSS Structure:**
   - Bootstrap theme styles
   - Custom counter styles
   - BigPie nonprofit integration styles
   - Custom fonts
   - Layout options (sidebar-content, content-sidebar)

5. **Functions:**
   - Search customization (Relevanssi integration)
   - Content width management
   - Custom post types support
   - Navigation menu registration
   - HTML5 theme support

### Child Themes

#### 1. `child-ferrofluid`
- **Purpose:** Ferrofluid products branding
- **Template Parent:** layers2
- **Files:**
  - `style.css` - Basic child theme stylesheet
  - `functions.php` - Parent style enqueuing

#### 2. `child-corporate`
- **Purpose:** Corporate site with custom branding
- **Key Features:**
  - Custom home banner with SVG graphics
  - Product tile grid system
  - Featured product images
  - Market-specific sections (semiconductor, automotive, biomedical, etc.)
  - News feed styling
  - Carousel integration
  - Corporate breadcrumb navigation
- **WooCommerce Folder:** Contains custom templates
- **Custom Styling:**
  - Product tiles with hover effects
  - Market wrapper sections
  - Featured product image backgrounds
  - Responsive banner designs

#### 3. `child-meivac`
- **Purpose:** MEI VAC products (vacuum seals/sputter targets)
- **Key Features:**
  - Custom WooCommerce product tabs (Description, Ordering, Downloads)
  - Custom product attribute tables with filtering
  - Custom shortcode: `[show_meivac_products category="..."]`
  - Page-specific JavaScript loading (table sorting)
  - Custom product listing templates
- **WooCommerce Customizations:**
  - Removed reviews and additional information tabs
  - Custom tab content callbacks
  - ACF integration for step files/downloads
  - Dynamic product spec tables
- **Functions:**
  - `ft_woo_custom_description_tabs()` - Tab customization
  - `ft_woo_custom_attributes_table()` - Spec table generation
  - `show_meivac_products_func()` - Product listing shortcode
  - `meta_list()` - Meta field term extraction for filters
- **Category Templates:** Custom product listing layouts
- **JavaScript:** Table sorting for product listings

#### 4. `child-thermalelectric`
- **Purpose:** Thermal electric modules
- **Key Features:**
  - Custom shop header
  - TE-specific product listing templates
  - Product table templates
  - Custom page templates for all TE products
- **Files:**
  - `header-shop.php` - Custom shop header
  - `page-te_all_prods.php` - All TE products page
  - `teListing.php` / `teListing-type.php` - Product listing templates
  - `te_prod_table.php` - Product table template
- **WooCommerce Folder:** Custom templates

#### 5. `child-seals`
- **Purpose:** Ferrofluidic seals products
- **Files:** Minimal child theme (style.css, functions.php)

## WooCommerce Functionality to Extract

The following WooCommerce customizations should be moved to the `ferrotec-woocommerce` plugin:

### 1. **Product Tab Customization**
- Remove default reviews and additional information tabs
- Add custom "Ordering" tab
- Add conditional "Downloads" tab (based on ACF fields)
- Custom tab content callbacks with template part loading

### 2. **Product Attribute Display**
- Custom attribute table generation
- Filtered attribute lists per product category
- Weight and dimensions display
- Custom attribute label mapping

### 3. **Product Listing Shortcodes**
- `[show_meivac_products category="..."]` - Category-based product listings
- Support for custom templates via category slug
- Table-based product displays with custom columns

### 4. **Helper Functions**
- `meta_list()` - Extract unique meta values for filtering
- `meta_list_numeric()` - Numeric meta value sorting
- Custom attribute filtering logic

### 5. **Template Overrides**
- Single product templates
- Archive product templates
- Product listing templates
- Product tab templates

### 6. **Custom Product Data Display**
- Specs tables with filterable attributes
- Product image grids
- Category-specific layouts

## Current Status

**Phase 1: Theme Foundation - 95% Complete**
- ✅ Modern WordPress theme structure created
- ✅ Upgraded to Bootstrap 5.3.3 from CDN (no jQuery dependency)
- ✅ All core templates implemented (11 files)
- ✅ CSS consolidated: 93% size reduction (285KB → 20KB gzipped)
- ✅ ACF Blocks implemented (replaces repeater fields)
- ✅ Production-ready minified CSS with smart dev/prod loading
- ⏳ Remaining: front-page.php, fonts migration, screenshot.png

**Latest Updates (Nov 18, 2025):**
- Bootstrap 5 CDN integration
- Single consolidated CSS file (ferrotec-custom.css)
- Content Section ACF block with live preview
- ACF JSON for version control

## Migration Strategy

### Phase 1: New Theme Setup (`layers2025`) - 95% COMPLETE
1. ✅ Create modern WordPress theme structure
2. ✅ Migrate to Bootstrap 5 from CDN (replaced Bootstrap 4 local)
3. ✅ Implement responsive design patterns
4. ✅ Set up navigation menus
5. ✅ Create base page templates
6. ⏳ Migrate custom fonts and base styling (partial)

### Phase 2: WooCommerce Plugin (`ferrotec-woocommerce`)
1. Extract all WooCommerce-specific functions
2. Create plugin structure with proper namespacing
3. Register custom product tabs
4. Implement attribute table generation
5. Create shortcodes for product listings
6. Add template override system
7. Implement ACF integration for downloads
8. Add admin settings page (optional)

### Phase 3: Content Migration
1. Merge child theme styles into unified theme with class-based customization
2. Convert child-specific features to configurable options
3. Create reusable components for:
   - Product tiles
   - Market sections
   - Banner systems
   - News feeds
   - Carousels

### Phase 4: Testing & Optimization
1. Test WooCommerce functionality across all product types
2. Verify template hierarchy
3. Test shortcodes and custom displays
4. Performance optimization
5. Cross-browser testing
6. Mobile responsiveness verification

## Technology Stack

### WordPress Requirements
- WordPress 5.0+
- PHP 7.4+
- WooCommerce 4.0+

### Dependencies
- **Bootstrap 4** - Grid system and utilities
- **Advanced Custom Fields (ACF)** - Custom field management
- **Relevanssi** - Enhanced search functionality
- **jQuery** - JavaScript interactions
- **Table Sorter** - Product table sorting

### JavaScript Libraries
- Bootstrap 4 JS
- jQuery (WordPress bundled)
- TableSorter
- Raphael.js (for graphics)
- Flip Counter
- Custom product filtering scripts

## Custom Features Inventory

### Search Customization
- Relevanssi integration with custom stemmer
- Hyphen and slash preservation in search terms
- Custom posts per page for search results (10)

### Navigation
- **Primary Menu** - Main site navigation
- **Mobile Menu** - Mobile-optimized navigation
- **Footer Menu** - Footer links

### Content Features
- Custom page templates for multiple product categories
- Product recommendation tools
- Resource download systems
- Event management pages
- Press release templates
- Registration pages

### Styling Features
- Hover shadow effects on product tiles
- Responsive banner systems with SVG overlays
- Market-specific background images
- Custom breadcrumb navigation
- Striped table styling
- Product carousel integration

## File Organization Recommendations

### Theme (`layers2025/`)
```
layers2025/
├── style.css
├── functions.php
├── header.php
├── footer.php
├── sidebar.php
├── page.php
├── single.php
├── archive.php
├── search.php
├── assets/
│   ├── css/
│   │   ├── bootstrap-grid.css
│   │   ├── components/
│   │   └── utilities/
│   ├── js/
│   │   ├── navigation.js
│   │   ├── scripts.js
│   │   └── vendor/
│   ├── fonts/
│   └── images/
├── template-parts/
│   ├── content/
│   ├── navigation/
│   └── components/
├── page-templates/
│   ├── products/
│   ├── resources/
│   └── events/
└── inc/
    ├── theme-setup.php
    ├── enqueue-scripts.php
    ├── navigation.php
    └── customizer.php
```

### Plugin (`ferrotec-woocommerce/`)
```
ferrotec-woocommerce/
├── ferrotec-woocommerce.php
├── includes/
│   ├── class-ft-woo-tabs.php
│   ├── class-ft-woo-attributes.php
│   ├── class-ft-woo-shortcodes.php
│   └── helpers.php
├── templates/
│   ├── tabs/
│   │   ├── description.php
│   │   ├── ordering.php
│   │   └── downloads.php
│   ├── listings/
│   │   └── product-table.php
│   └── single-product/
│       └── specs-table.php
├── assets/
│   ├── css/
│   │   └── ft-woo-styles.css
│   └── js/
│       └── ft-woo-scripts.js
└── admin/
    └── settings.php
```

## Important Notes

### ACF Dependencies
Several features rely on Advanced Custom Fields:
- Download files (`step_file` field)
- Product specifications
- Custom page content blocks

### Image Paths
Many child themes use hardcoded image paths:
- `/wp-content/uploads/...`
These should be updated to use theme/plugin asset functions.

### Product Categories
The system uses custom product category slugs:
- Ferrofluid products
- Thermal electric modules
- Vacuum seals
- Sputter targets
- Fabricated quartzware
- CVD SiC products
- Advanced ceramics
- Silicon wafers
- Power semiconductor substrates
- Process tool parts
- E-beam evaporation products
- Temescal vacuum coating systems

### Custom Hooks
The old themes use custom action hooks:
- `ft_display_product_specs` - For displaying product specification tables

### WooCommerce Filters
Customized WooCommerce filters:
- `woocommerce_product_tabs` - Tab modification
- `wpseo_canonical` - SEO customization
- `relevanssi_stemmer` - Search customization
- `post_limits` - Search results limitation

## Development Guidelines

1. **Maintain GPL Compatibility** - All code must remain GPL v2+ licensed
2. **Use WordPress Coding Standards** - Follow WordPress PHP, JS, and CSS standards
3. **Sanitize and Validate** - All user inputs and database queries must be sanitized
4. **Escape Output** - Use appropriate escaping functions for all output
5. **Prefix Everything** - Use `ft_` prefix for functions and `ft-` for CSS classes
6. **Document Code** - Add inline documentation for complex logic
7. **Test Thoroughly** - Test across all product categories and use cases
8. **Performance First** - Optimize queries, minimize file sizes, use caching
9. **Mobile Responsive** - Ensure all features work on mobile devices
10. **Accessibility** - Follow WCAG 2.1 AA standards where possible

## Migration Checklist

- [ ] Create `layers2025` theme structure
- [ ] Migrate Bootstrap grid system
- [ ] Set up navigation menus
- [ ] Create base page templates
- [ ] Migrate custom fonts
- [ ] Create `ferrotec-woocommerce` plugin
- [ ] Migrate product tab customizations
- [ ] Migrate attribute table generation
- [ ] Create product listing shortcodes
- [ ] Set up WooCommerce template overrides
- [ ] Migrate custom styling from child themes
- [ ] Create component system for reusable elements
- [ ] Test all product categories
- [ ] Test custom page templates
- [ ] Verify search functionality
- [ ] Mobile responsiveness testing
- [ ] Cross-browser testing
- [ ] Performance optimization
- [ ] Documentation updates
- [ ] User acceptance testing

## Support & Resources

### Documentation
- [WordPress Theme Development](https://developer.wordpress.org/themes/)
- [WooCommerce Theme Development](https://woocommerce.com/document/woocommerce-theme-developer-handbook/)
- [Bootstrap 4 Documentation](https://getbootstrap.com/docs/4.6/)
- [Advanced Custom Fields](https://www.advancedcustomfields.com/resources/)

### Original Theme Information
- **Original Author:** AUC
- **License:** GPL v2 or later
- **Original Parent Theme:** Layers (layers2)
- **Child Themes:** 5 active child themes for different product lines

## License

This theme and plugin, like WordPress, is licensed under the GPL v2 or later.

Use it to make something cool, have fun, and share what you've learned with others.

---

## Performance Metrics

### CSS Optimization Results
- **Old Theme:** 285KB (4+ files, Bootstrap 3 + Bootstrap 4 conflict)
- **New Theme:** 20KB gzipped (2 files: Bootstrap 5 CDN + ferrotec-custom.min.css)
- **Improvement:** 93% size reduction, 50% fewer HTTP requests

### File Sizes
- `ferrotec-custom.css`: 22KB (development, human-readable)
- `ferrotec-custom.min.css`: 15KB (production, minified)
- Expected gzipped: ~5-6KB

### Load Order (Production)
1. Bootstrap 5.3.3 CSS (CDN) - ~25KB gzipped
2. ferrotec-custom.min.css - ~6KB gzipped
3. style.css - minimal (WordPress requirement)

**Total CSS:** ~31KB vs 285KB (old theme)

---

**Last Updated:** November 18, 2025
**Project Status:** Phase 1 95% Complete - CSS Optimized, ACF Blocks Implemented
**Next Steps:** Test ACF blocks, complete Phase 1, begin WooCommerce plugin
