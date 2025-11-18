# Ferrotec Theme Migration Project

## Project Overview

Migrating Ferrotec's WordPress theme ecosystem from a legacy parent/child theme structure (layers2 + 5 child themes) to a modern, unified architecture with a new theme (`layers2025`) and a custom WooCommerce plugin (`ferrotec-woocommerce`).

**Project Type:** Theme consolidation and WooCommerce extraction
**Client:** Ferrotec
**Timeline:** Phased approach over 4-6 weeks
**Status:** Phase 0 - Analysis Complete

---

## Current State Assessment

### Legacy Theme Structure
```
old-themes/
├── layers2/                          🔴 Parent theme (1,535 lines functions.php)
│   ├── functions.php                 🔴 Core functionality + WooCommerce
│   ├── functions-indexing.php        ⚠️  Search customization
│   ├── style.css                     🔴 34,608 tokens (Bootstrap 4 grid)
│   ├── css/                          ✅ Bootstrap 4, custom styles
│   ├── js/                           🔴 jQuery dependencies, table sorting
│   ├── page-*.php (14 templates)     🔴 Product catalog templates
│   ├── template-parts/               ⚠️  Content templates
│   ├── woocommerce/                  🔴 WooCommerce overrides
│   └── modals/, layouts/, fonts/     ⚠️  Various components
│
├── child-corporate/                  🔴 Corporate branding site
│   ├── style.css (537 lines)         🔴 Extensive custom styling
│   ├── functions.php                 ⚠️  Style enqueuing only
│   └── woocommerce/                  ⚠️  Custom templates
│
├── child-ferrofluid/                 ⚠️  Ferrofluid products
│   ├── style.css (minimal)
│   └── functions.php (minimal)
│
├── child-meivac/                     🔴 HIGH COMPLEXITY - MEI VAC products
│   ├── functions.php (307 lines)     🔴 Custom WooCommerce tabs & tables
│   ├── style.css                     ⚠️  Custom styling
│   ├── category-templates/           🔴 Product listings
│   ├── page-templates/               🔴 Custom page layouts
│   ├── js/                           ⚠️  Table sorting scripts
│   └── woocommerce/                  🔴 Extensive customizations
│
├── child-seals/                      ⚠️  Ferrofluidic seals
│   ├── style.css (minimal)
│   └── functions.php (minimal)
│
└── child-thermalelectric/            🔴 Thermal electric modules
    ├── functions.php (custom logic)  🔴 TE-specific functionality
    ├── style.css (minimal)
    ├── header-shop.php               ⚠️  Custom shop header
    ├── page-te_all_prods.php         🔴 Product listing page
    ├── teListing*.php                🔴 Product templates
    ├── js/                           ⚠️  Custom scripts
    └── woocommerce/                  🔴 Custom templates
```

### Technical Architecture Identified

**Parent Theme (layers2):**
- Bootstrap 4 grid system (modern, keep)
- 14 custom page templates for product catalogs
- Relevanssi search integration
- ACF (Advanced Custom Fields) dependencies
- Custom navigation menus (Primary, Mobile, Footer)
- 1,535 lines of core functionality

**Child Theme Complexity:**
1. **child-corporate** - Complex styling, market sections, product tiles
2. **child-meivac** - MOST COMPLEX - Custom WooCommerce tabs, attribute tables, shortcodes
3. **child-thermalelectric** - Custom product listings and templates
4. **child-ferrofluid** - Minimal (branding only)
5. **child-seals** - Minimal (branding only)

**WooCommerce Customizations (TO EXTRACT):**
- Custom product tabs (Description, Ordering, Downloads)
- Product attribute table generation with filtering
- Shortcode: `[show_meivac_products category="..."]`
- Custom product listing templates
- Category-specific layouts
- ACF integration for product downloads

---

## Project Goals

### Phase 1: New Theme Foundation (Week 1-2)
**Goal:** Create modern unified theme structure

**Deliverables:**
- [ ] Create `/wp-content/themes/layers2025/` directory structure
- [ ] Set up theme header (style.css) with proper metadata
- [ ] Migrate Bootstrap 4 grid system from parent theme
- [ ] Create base template files (header.php, footer.php, page.php, etc.)
- [ ] Set up navigation menu registration
- [ ] Migrate custom fonts
- [ ] Create assets directory structure (css/, js/, fonts/, images/)
- [ ] Set up SASS/build process (if needed)
- [ ] Theme setup and enqueue scripts

**Key Files to Create:**
1. `style.css` - Theme header
2. `functions.php` - Core theme setup
3. `header.php` - Main header template
4. `footer.php` - Footer template
5. `page.php` - Default page template
6. `single.php` - Single post template
7. `archive.php` - Archive template
8. `search.php` - Search results template
9. `inc/theme-setup.php` - Theme configuration
10. `inc/enqueue-scripts.php` - Asset loading

### Phase 2: WooCommerce Plugin Creation (Week 2-3)
**Goal:** Extract all WooCommerce functionality into standalone plugin

**Priority Tasks:**
1. Create plugin structure and main file
2. Extract product tab customizations from child-meivac
3. Extract attribute table generation logic
4. Create product listing shortcodes
5. Set up template override system
6. Migrate ACF field groups for products
7. Create admin settings page (optional)

**Key Files to Create:**
1. `ferrotec-woocommerce.php` - Main plugin file
2. `includes/class-ft-woo-tabs.php` - Product tabs
3. `includes/class-ft-woo-attributes.php` - Attribute tables
4. `includes/class-ft-woo-shortcodes.php` - Shortcodes
5. `includes/helpers.php` - Utility functions
6. `templates/tabs/` - Tab templates
7. `templates/listings/` - Product listings
8. `assets/css/ft-woo-styles.css` - Plugin styles
9. `assets/js/ft-woo-scripts.js` - Plugin scripts

**WooCommerce Functions to Migrate:**
```php
From child-meivac/functions.php:
- ft_woo_custom_description_tabs()       # Custom tab system
- ft_woo_description_tab_content()       # Description tab
- ft_woo_ordering_tab_content()          # Ordering tab
- ft_woo_downloads_tab_content()         # Downloads tab
- ft_woo_custom_attributes_table()       # Spec tables
- show_meivac_products_func()            # Product shortcode
- meta_list() / meta_list_numeric()      # Meta queries for filters
```

### Phase 3: Style Migration & Component System (Week 3-4)
**Goal:** Consolidate child theme styles into unified, configurable system

**Tasks:**
- [ ] Analyze all child theme CSS
- [ ] Identify common patterns (product tiles, banners, market sections)
- [ ] Create component-based CSS architecture
- [ ] Implement class-based customization system
- [ ] Create reusable banner/hero components
- [ ] Build product tile system
- [ ] Implement market section layouts
- [ ] Add news feed components
- [ ] Migrate carousel systems

**Child Theme Styles to Migrate:**
1. **Corporate** (537 lines):
   - Home banners with SVG overlays
   - Product tile grid (hover effects, shadows)
   - Featured product images
   - Market sections (semiconductor, automotive, biomedical, etc.)
   - News feed styling
   - Breadcrumb navigation

2. **MEI VAC**:
   - Product table styling
   - Category template layouts

3. **Thermal Electric**:
   - Shop header styling
   - Product listing layouts

### Phase 4: Page Templates & Content (Week 4-5)
**Goal:** Migrate custom page templates and ensure content compatibility

**Page Templates to Migrate:**
- `page-vfproducts.php` - Vacuum seal products
- `page-teproducts.php` - Thermal electric products
- `page-ferrofluidproducts.php` - Ferrofluid catalog
- `page-tecatalog.php` - TE catalog
- `page-vfcatalog.php` - VF catalog
- `page-resources.php` - Resources page
- `page-press.php` - Press releases
- `page-events.php` - Events page
- `page-terecommend.php` - TE recommendation tool

**Content Verification:**
- [ ] Test all product category pages
- [ ] Verify WooCommerce product displays
- [ ] Test product filtering/sorting
- [ ] Validate search functionality
- [ ] Check ACF field displays

### Phase 5: Testing & Documentation (Week 5-6)
**Goal:** Ensure quality and prepare for deployment

**Tasks:**
- [ ] Cross-browser testing (Chrome, Firefox, Safari, Edge)
- [ ] Mobile responsiveness testing (all breakpoints)
- [ ] WooCommerce checkout flow testing
- [ ] Product catalog functionality testing
- [ ] Performance benchmarking
- [ ] Accessibility audit (WCAG 2.1 AA)
- [ ] Create deployment plan
- [ ] Team training materials
- [ ] Update documentation
- [ ] Code review and optimization

---

## Technical Approach

### Namespace Convention
- **Code/Internal:** `ft_` prefix for functions, `Ferrotec\` for classes
- **Database:** `ft_` or `ferrotec_` prefix for meta keys
- **CSS:** `.ft-` or `.ferrotec-` prefix for classes
- **Plugin Text Domain:** `ferrotec-woocommerce`
- **Theme Text Domain:** `layers2025`

### Migration Strategy
**Clean Break Approach:**
- Old themes remain in `/old-themes/` for reference only
- New theme is built from scratch based on analysis
- WooCommerce plugin is standalone and portable
- No backward compatibility required (fresh start)
- Test on staging before production deployment

### Directory Structure

**New Theme:**
```
layers2025/
├── style.css                    # Theme header
├── functions.php                # Core setup
├── header.php
├── footer.php
├── sidebar.php
├── page.php
├── single.php
├── archive.php
├── search.php
├── comments.php
├── assets/
│   ├── css/
│   │   ├── bootstrap-grid.css   # Keep Bootstrap 4 grid
│   │   ├── main.css             # Main theme styles
│   │   ├── components/          # Reusable components
│   │   └── utilities/           # Utility classes
│   ├── js/
│   │   ├── navigation.js
│   │   ├── scripts.js
│   │   └── vendor/              # Third-party libraries
│   ├── fonts/
│   └── images/
├── template-parts/
│   ├── content/
│   ├── navigation/
│   └── components/
├── page-templates/
│   ├── products/
│   │   ├── page-vfproducts.php
│   │   ├── page-teproducts.php
│   │   └── page-ferrofluidproducts.php
│   └── resources/
└── inc/
    ├── theme-setup.php
    ├── enqueue-scripts.php
    ├── navigation.php
    ├── template-tags.php
    └── customizer.php
```

**New Plugin:**
```
ferrotec-woocommerce/
├── ferrotec-woocommerce.php     # Main plugin file
├── readme.txt
├── includes/
│   ├── class-ft-woo-tabs.php
│   ├── class-ft-woo-attributes.php
│   ├── class-ft-woo-shortcodes.php
│   ├── class-ft-woo-template-loader.php
│   └── helpers.php
├── templates/
│   ├── tabs/
│   │   ├── description.php
│   │   ├── ordering.php
│   │   └── downloads.php
│   ├── listings/
│   │   ├── product-table.php
│   │   └── category-listing.php
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

---

## Key Decisions & Patterns

### 1. Why Not Update Existing Theme?
**Decision:** Create new unified theme instead of updating parent theme

**Rationale:**
- 5 child themes need consolidation
- Opportunity for cleaner architecture
- Easier to maintain single theme vs parent + 5 children
- Can deprecate old themes cleanly
- WooCommerce functionality better suited to plugin

### 2. WooCommerce Plugin vs Theme Functions
**Decision:** Extract ALL WooCommerce customizations to plugin

**Rationale:**
- Portability - can use with other themes
- Separation of concerns - e-commerce vs presentation
- Easier testing and updates
- Child theme (meivac) already has extensive WooCommerce logic
- Follows WordPress best practices

### 3. Bootstrap 4 - Keep or Replace?
**Decision:** KEEP Bootstrap 4 grid system

**Rationale:**
- Already modern (not EOL like Bootstrap 3)
- Extensive use throughout existing theme
- Grid system is solid and well-tested
- Migration risk reduction
- Team familiarity

**Approach:**
- Extract ONLY grid system (not full Bootstrap)
- Use custom CSS for components
- Modern flexbox/grid where appropriate

### 4. Child Theme Style Consolidation
**Decision:** Merge into single theme with class-based variants

**Approach:**
- Create component library in theme
- Use body classes or custom classes for variations
- Example: `.ft-corporate`, `.ft-meivac`, `.ft-te`
- Or use WordPress Customizer for brand options

### 5. ACF Dependencies
**Decision:** Maintain ACF dependency

**Known ACF Fields:**
- Product downloads (`step_file`)
- Product specifications
- Custom page content blocks

**Action Items:**
- [ ] Audit all ACF field groups
- [ ] Export ACF JSON to new theme
- [ ] Document required fields
- [ ] Consider ACF blocks for future (not this phase)

---

## Implementation Checklist

### Phase 1: Theme Foundation
```
Theme Structure:
□ Create /wp-content/themes/layers2025/ directory
□ Create style.css with theme header
□ Create screenshot.png (1200x900)
□ Create functions.php with theme setup
□ Create inc/theme-setup.php
□ Create inc/enqueue-scripts.php

Base Templates:
□ Create header.php (from layers2/header.php)
□ Create footer.php (from layers2/footer.php)
□ Create sidebar.php
□ Create page.php
□ Create single.php
□ Create archive.php
□ Create search.php (from layers2/search.php)
□ Create 404.php
□ Create comments.php

Assets:
□ Create assets/css/ directory
□ Extract Bootstrap 4 grid from layers2/style.css
□ Create assets/css/main.css
□ Create assets/js/ directory
□ Copy necessary JS from layers2/js/
□ Create assets/fonts/ directory
□ Copy fonts from layers2/fonts/
□ Create assets/images/ directory

Navigation:
□ Register Primary Menu
□ Register Mobile Menu
□ Register Footer Menu
□ Create navigation.php in inc/

Testing:
□ Activate theme on staging
□ Test basic page display
□ Test navigation menus
□ Test responsive layout
```

### Phase 2: WooCommerce Plugin
```
Plugin Structure:
□ Create /wp-content/plugins/ferrotec-woocommerce/ directory
□ Create ferrotec-woocommerce.php main file
□ Add plugin header (Name, Description, Version, Author, etc.)
□ Create readme.txt
□ Create includes/ directory
□ Create templates/ directory
□ Create assets/ directory

Core Functionality:
□ Create class-ft-woo-tabs.php
  □ Migrate ft_woo_custom_description_tabs()
  □ Migrate tab content callbacks
  □ Remove reviews tab
  □ Remove additional_info tab
  □ Add Ordering tab
  □ Add conditional Downloads tab

□ Create class-ft-woo-attributes.php
  □ Migrate ft_woo_custom_attributes_table()
  □ Add ft_display_product_specs action hook
  □ Create attribute filtering logic
  □ Custom label mapping

□ Create class-ft-woo-shortcodes.php
  □ Migrate show_meivac_products_func()
  □ Register [show_meivac_products] shortcode
  □ Add template loading system

□ Create helpers.php
  □ Migrate meta_list() function
  □ Migrate meta_list_numeric() function
  □ Add utility functions

Templates:
□ Create templates/tabs/description.php
□ Create templates/tabs/ordering.php
□ Create templates/tabs/downloads.php
□ Create templates/listings/product-table.php
□ Create templates/single-product/specs-table.php

Assets:
□ Create assets/css/ft-woo-styles.css
□ Create assets/js/ft-woo-scripts.js
□ Enqueue assets properly

Testing:
□ Activate plugin on staging
□ Test product tabs display
□ Test attribute tables
□ Test product listing shortcode
□ Test downloads tab (with ACF field)
```

### Phase 3: Style Migration
```
CSS Analysis:
□ Document all child-corporate styles
□ Document all child-meivac styles
□ Document all child-thermalelectric styles
□ Identify common patterns
□ Create component list

Component Creation:
□ Product tiles (.ft-product-tile)
□ Hero banners (.ft-banner)
□ Market sections (.ft-market-section)
□ News feeds (.ft-news-feed)
□ Breadcrumbs (.ft-breadcrumb)
□ Product tables (.ft-product-table)

CSS Files:
□ Create assets/css/components/tiles.css
□ Create assets/css/components/banners.css
□ Create assets/css/components/market-sections.css
□ Create assets/css/components/news-feed.css
□ Create assets/css/components/breadcrumbs.css
□ Create assets/css/components/product-tables.css

Variants:
□ Corporate variant styles
□ MEI VAC variant styles
□ TE variant styles
□ Implement body class system or customizer options
```

### Phase 4: Page Templates
```
Product Templates:
□ Create page-templates/products/page-vfproducts.php
□ Create page-templates/products/page-teproducts.php
□ Create page-templates/products/page-ferrofluidproducts.php
□ Create page-templates/products/page-tecatalog.php
□ Create page-templates/products/page-vfcatalog.php
□ Create page-templates/products/page-terecommend.php

Resource Templates:
□ Create page-templates/resources/page-resources.php
□ Create page-templates/resources/page-press.php
□ Create page-templates/resources/page-events.php

Template Parts:
□ Create template-parts for reusable sections
□ Extract banner logic to template part
□ Extract product grid logic to template part

Testing:
□ Test each page template
□ Verify ACF field displays
□ Check responsive layouts
□ Compare to old theme visually
```

### Phase 5: Final Testing
```
Functionality Testing:
□ All navigation menus work
□ All page templates display correctly
□ All WooCommerce features work
□ Product tabs display correctly
□ Product attributes display correctly
□ Shortcodes work correctly
□ Search functionality works
□ ACF fields display correctly

Browser Testing:
□ Chrome (Windows/Mac)
□ Firefox (Windows/Mac)
□ Safari (Mac/iOS)
□ Edge (Windows)
□ Mobile browsers (iOS Safari, Chrome Android)

Responsive Testing:
□ Mobile (320px, 375px, 414px)
□ Tablet (768px, 1024px)
□ Desktop (1280px, 1440px, 1920px)

Performance Testing:
□ Page load times < 3 seconds
□ Optimize images
□ Minify CSS/JS
□ Test on slow connections

Accessibility Testing:
□ Keyboard navigation
□ Screen reader compatibility
□ Color contrast ratios
□ ARIA labels where needed

Documentation:
□ Theme README
□ Plugin README
□ ACF field documentation
□ Shortcode documentation
□ Template documentation
□ Deployment guide
```

---

## Files Requiring Migration

### Priority Order

**Critical (Must Have):**
1. ✅ README.md - Project documentation (DONE)
2. `layers2/functions.php` - Core theme functionality (1,535 lines)
3. `layers2/style.css` - Bootstrap 4 grid + base styles
4. `child-meivac/functions.php` - WooCommerce customizations (307 lines)
5. `layers2/header.php` - Main header template
6. `layers2/footer.php` - Footer template

**High Priority:**
7. `layers2/page-vfproducts.php` - VF product catalog
8. `layers2/page-teproducts.php` - TE product catalog (large file)
9. `layers2/search.php` - Custom search template
10. `child-corporate/style.css` - Corporate branding (537 lines)
11. `child-meivac/category-templates/` - Product listings
12. `child-thermalelectric/page-te_all_prods.php` - TE products

**Medium Priority:**
13. `layers2/js/` - JavaScript files
14. `layers2/css/` - Additional CSS files
15. `layers2/template-parts/` - Content templates
16. `layers2/woocommerce/` - WooCommerce overrides
17. All remaining page templates

**Low Priority:**
18. `layers2/modals/` - Modal templates
19. `layers2/layouts/` - Layout variations
20. Minimal child themes (ferrofluid, seals)

---

## Product Categories & Structure

### Product Lines Identified
Based on child themes and page templates:

1. **Ferrofluids** (child-ferrofluid)
   - Ferrofluid products
   - Page: `page-ferrofluidproducts.php`
   - Catalog: `page-ferrofluidcatalog.php` (not found but referenced)

2. **Ferrofluidic Vacuum Seals** (child-seals, VF = Vacuum Ferrofluidic)
   - Vacuum seal products
   - Page: `page-vfproducts.php`
   - Catalog: `page-vfcatalog.php`

3. **Thermal Electric Modules** (child-thermalelectric, TE)
   - Thermoelectric products
   - Page: `page-teproducts.php`
   - Catalog: `page-tecatalog.php`
   - Recommendation: `page-terecommend.php`
   - All products: `page-te_all_prods.php`

4. **MEI VAC Products** (child-meivac)
   - Sputter targets
   - Vacuum components
   - Multiple product categories via shortcode system

5. **Corporate Products** (child-corporate)
   - Fabricated quartzware
   - Photovoltaic manufacturing
   - Silicon carbide parts (CVD SiC)
   - Advanced ceramics
   - Machinable ceramics
   - Silicon wafers
   - Power semiconductor substrates
   - Process tool parts cleaning
   - Electron beam evaporation products
   - Temescal vacuum coating systems
   - Silicon parts
   - Contract manufacturing

### Product Category Taxonomy
To be determined from WooCommerce `product_cat` taxonomy in database.

---

## Questions to Answer

### Technical Questions
1. **ACF Field Groups:** What ACF fields exist? Need full audit
2. **Custom Post Types:** Any custom post types besides products?
3. **Database Tables:** Any custom database tables?
4. **Third-party Plugins:** What plugins are required? (ACF Pro, Relevanssi, WooCommerce, others?)
5. **JavaScript Dependencies:** Which JS libraries are actually needed vs legacy?
6. **Image Paths:** Should hardcoded `/wp-content/uploads/...` paths be updated?

### Architecture Questions
1. **Site Structure:** Single site or multisite?
2. **Product Organization:** How should products be organized in new theme?
3. **Brand Variants:** Should corporate/meivac/TE be different "skins" or separate configurations?
4. **Header Consolidation:** Can the 7+ header files be consolidated? Why do they exist?

### Content Questions
1. **Page Count:** How many pages actually exist? (~2000 estimated in modernization project)
2. **Product Count:** How many WooCommerce products?
3. **ACF Usage:** Which pages use ACF fields heavily?
4. **Migration Priority:** Which sections of site are most important?

### Design Questions
1. **Visual Changes:** Should design stay identical or can it be refreshed?
2. **Responsive Behavior:** Are there known mobile issues to fix?
3. **Brand Guidelines:** Are there brand guidelines to follow?
4. **Component Variations:** How different should corporate/meivac/TE look from each other?

### Deployment Questions
1. **Staging Environment:** Is staging available? URL?
2. **Production URL:** What's the production URL?
3. **Deployment Process:** How are updates deployed?
4. **Rollback Plan:** What's the rollback strategy if issues occur?
5. **Downtime Acceptable:** Can site have maintenance mode during migration?

---

## Key WordPress Hooks & Filters

### Hooks from Old Themes

**Filters:**
```php
// SEO
add_filter('wpseo_canonical', '__return_false');

// Content formatting
remove_filter('the_content', 'wpautop');
remove_filter('the_excerpt', 'wpautop');
remove_filter('acf_the_content', 'wpautop');

// Search
add_filter('relevanssi_stemmer', 'relevanssi_simple_english_stemmer');
add_filter('relevanssi_remove_punctuation', 'savemyhyphens_1', 9);
add_filter('relevanssi_remove_punctuation', 'savemyhyphens_2', 11);
add_filter('post_limits', 'postsperpage');

// WooCommerce
add_filter('woocommerce_product_tabs', 'ft_woo_custom_description_tabs', 98);
```

**Actions:**
```php
// Custom action for product specs
add_action('ft_display_product_specs', 'ft_woo_custom_attributes_table', 10, 1);

// WooCommerce support
add_theme_support('woocommerce');
```

### New Hooks to Create

**Theme Actions:**
```php
do_action('ft_before_header');
do_action('ft_after_header');
do_action('ft_before_content');
do_action('ft_after_content');
do_action('ft_before_footer');
do_action('ft_after_footer');
```

**Plugin Actions:**
```php
do_action('ft_woo_before_product_tabs');
do_action('ft_woo_after_product_tabs');
do_action('ft_woo_before_specs_table');
do_action('ft_woo_after_specs_table');
```

---

## Development Workflow

### Recommended Approach
1. **Analysis Chat (This Chat):** Strategic planning, progress tracking
2. **Implementation Chats:** Focused on specific files/features
   - "Create layers2025 theme foundation"
   - "Build ferrotec-woocommerce plugin"
   - "Migrate product page templates"
   - "Consolidate child theme styles"

### Version Control Strategy
- Commit frequently with descriptive messages
- Tag major milestones
- Use feature branches if needed
- Push to GitHub after each major change

### Testing Approach
1. **Local Development:** Build and test locally first
2. **Staging Deployment:** Test on staging environment
3. **Visual Comparison:** Compare old vs new theme screenshots
4. **Functional Testing:** Test all features systematically
5. **Production Deployment:** Only after full testing complete

### Code Standards
- Follow WordPress Coding Standards
- Use WordPress core functions (never reinvent the wheel)
- Sanitize all inputs, escape all outputs
- Prefix all functions, classes, and global variables
- Document complex logic with inline comments
- Use meaningful variable and function names

---

## Success Metrics

### Technical Goals
- [ ] Single unified theme (vs parent + 5 children)
- [ ] Portable WooCommerce plugin
- [ ] Clean, maintainable code structure
- [ ] No PHP errors or warnings
- [ ] Page load times maintained or improved
- [ ] All functionality preserved
- [ ] Modern WordPress best practices followed

### Migration Goals
- [ ] 100% feature parity with old themes
- [ ] All product categories working
- [ ] All WooCommerce customizations working
- [ ] All page templates working
- [ ] Visual appearance maintained (or approved changes)
- [ ] Zero data loss

### Maintainability Goals
- [ ] Well-documented code
- [ ] Logical file organization
- [ ] Reusable components
- [ ] Easy to customize
- [ ] Future-proof architecture

---

## Resources & References

### Documentation Created
- ✅ **README.md** - Comprehensive project documentation and old theme analysis
- 🔄 **claude.md** - This project guide (you are here)
- ⏳ **DEPLOYMENT.md** - To be created
- ⏳ **CHANGELOG.md** - To be created

### External References
- [WordPress Theme Handbook](https://developer.wordpress.org/themes/)
- [WooCommerce Theme Development](https://woocommerce.com/document/woocommerce-theme-developer-handbook/)
- [Plugin Handbook](https://developer.wordpress.org/plugins/)
- [Bootstrap 4 Grid Documentation](https://getbootstrap.com/docs/4.6/layout/grid/)
- [ACF Blocks Documentation](https://www.advancedcustomfields.com/resources/blocks/)

### Tools & Dependencies
- **WordPress** 5.0+
- **PHP** 7.4+
- **WooCommerce** 4.0+
- **Advanced Custom Fields Pro**
- **Relevanssi** (search enhancement)
- **Bootstrap 4** (grid only)

---

## Risk Assessment

### High Risk Areas
**Risk:** Breaking WooCommerce checkout/payment flow
**Impact:** CRITICAL - Could prevent sales
**Mitigation:** Extensive testing, staging environment, rollback plan

**Risk:** Product catalog display issues
**Impact:** HIGH - Core business functionality
**Mitigation:** Thorough testing of all product categories, visual comparison

**Risk:** ACF field data loss or display issues
**Impact:** HIGH - Content could be lost or not display
**Mitigation:** Database backup, field group export, testing

### Medium Risk Areas
**Risk:** Search functionality degradation
**Impact:** MEDIUM - User experience affected
**Mitigation:** Test Relevanssi integration, verify search results

**Risk:** Navigation menu issues
**Impact:** MEDIUM - Site usability
**Mitigation:** Test all menu locations, mobile navigation

**Risk:** Performance regression
**Impact:** MEDIUM - User experience and SEO
**Mitigation:** Benchmark current performance, optimize new theme

### Low Risk Areas
**Risk:** Minor visual inconsistencies
**Impact:** LOW - Cosmetic issues
**Mitigation:** Visual regression testing, client approval

**Risk:** JavaScript conflicts
**Impact:** LOW - Some features may not work
**Mitigation:** Test all interactive elements, update jQuery code

---

## Next Steps

### Immediate Actions (Before Next Session)
1. ✅ Complete README.md analysis (DONE)
2. ✅ Create claude.md project guide (DONE)
3. ⏳ Set up local development environment
4. ⏳ Create staging site (if not exists)
5. ⏳ Backup production database and files
6. ⏳ Export ACF field groups
7. ⏳ Take screenshots of current site for comparison

### Phase 1 Kickoff Preparation
**Questions to Have Ready:**
1. What's the staging environment URL?
2. Are there any brand guidelines or design specs?
3. Which product line is highest priority? (Corporate, MEI VAC, TE?)
4. Are there any upcoming deadlines or blackout dates?
5. Who needs to approve design/functionality changes?
6. What's the deployment process to production?

**Files to Have Available:**
1. Database export (for local dev)
2. wp-config.php (for local dev setup)
3. ACF field group exports (JSON or XML)
4. Any brand assets (logos, fonts, etc.)
5. List of required plugins

### First Implementation Session Goals
1. Create `/wp-content/themes/layers2025/` structure
2. Set up `style.css` and `functions.php`
3. Create basic template files
4. Activate theme on staging
5. Verify basic functionality

---

## Project Timeline Estimate

### Week 1-2: Foundation
- Theme structure creation
- Basic templates
- Asset setup
- Navigation menus
- Initial staging deployment

### Week 2-3: WooCommerce Plugin
- Plugin structure
- Tab customization
- Attribute tables
- Shortcodes
- Template system

### Week 3-4: Styles & Components
- Child theme style consolidation
- Component library creation
- Corporate branding
- MEI VAC styling
- TE styling

### Week 4-5: Page Templates & Content
- Product page templates
- Resource templates
- Template parts
- ACF integration
- Content verification

### Week 5-6: Testing & Launch
- Functionality testing
- Browser testing
- Responsive testing
- Performance optimization
- Documentation
- Production deployment

**Total Estimated Time:** 5-6 weeks
**Contingency Buffer:** +1 week for unexpected issues

---

## Contact & Context

**Developer:** Tagg
**Client:** Ferrotec
**Project Type:** Theme consolidation + WooCommerce extraction
**Current Status:** Analysis complete, ready for Phase 1
**Repository:** GitHub - ferrotec-theme-migration
**Branch:** claude/create-layers2025-theme-01VbQjf8sACrrdQUNBq4omTW

---

## Session Notes

### Session 1 - November 17, 2025
- Analyzed old theme structure in `/old-themes/`
- Created comprehensive README.md with architecture analysis
- Created claude.md project guide
- Identified 5 child themes and their purposes
- Documented WooCommerce customizations to extract
- Ready to begin Phase 1 implementation

**Key Findings:**
- Parent theme (layers2) has 1,535 lines in functions.php
- child-meivac is most complex (307 lines, custom WooCommerce)
- child-corporate has extensive custom styling (537 lines CSS)
- Bootstrap 4 already in use (modern, can keep grid)
- ACF heavily used throughout
- 14 custom page templates for product catalogs

**Next Session:**
- Begin Phase 1: Theme foundation creation
- Set up directory structure
- Create base template files
- Migrate Bootstrap 4 grid
- Set up asset enqueuing

---

### Session 2 - November 18, 2025
- **Upgraded to Bootstrap 5.3.3** from CDN (replaced conflicting Bootstrap 3/4)
- **Consolidated all CSS** from 4+ files into single `ferrotec-custom.css` (22KB)
  - Merged: layers2/style.css (83KB), pa.css (69KB), child-corporate (12KB), child-meivac styles
  - Created minified production version (15KB, 32% reduction)
  - Implemented smart dev/prod loading via SCRIPT_DEBUG
  - **Performance: 93% CSS size reduction** (285KB → 20KB gzipped)
- **Implemented ACF Blocks** to replace ACF repeater fields
  - Created Content Section block (replaces 'rows' repeater)
  - Added block registration in functions.php
  - Set up ACF JSON save/load points for version control
  - Created field groups: Content Section Block, Page Headers
- **Theme Foundation**: ~95% complete
  - All core templates created
  - CSS fully consolidated and optimized
  - ACF blocks foundation ready for testing

**Key Achievements:**
- Only 2 CSS files load (Bootstrap 5 CDN + ferrotec-custom.min.css)
- Modern Gutenberg editing experience with live preview blocks
- No jQuery dependency (Bootstrap 5 is vanilla JS)
- ACF field groups in version control (acf-json)
- Smart loading: dev uses full CSS, production uses minified

**Technical Decisions:**
- Chose Bootstrap 5 CDN over local for global caching and smaller size
- Single consolidated CSS file for fastest loading performance
- ACF Blocks over repeater fields for better UX and future-proofing
- Hybrid support: new blocks + legacy repeater backward compatibility

**Next Session:**
- Test ACF blocks in dev environment
- Complete remaining Phase 1 items (front-page.php, fonts, screenshot)
- Begin Phase 2: WooCommerce plugin creation

---

**Last Updated:** November 18, 2025
**Project Status:** Phase 1 ~95% Complete, CSS Optimized, ACF Blocks Implemented
**Next Milestone:** Complete Phase 1, begin WooCommerce plugin extraction
