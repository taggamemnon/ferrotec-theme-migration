# layers2 Theme - File Purpose Analysis

## ✅ CORE WORDPRESS TEMPLATE FILES (NEED)

### 404.php - Custom 404 error page
- **Status:** NEED
- **Purpose:** Custom branded 404 error page with Ferrotec styling
- **Features:** Bootstrap layout, links to homepage, error reporting email

### archive.php - Archive listing template
- **Status:** NEED
- **Purpose:** Displays category, tag, and date archives
- **Layout:** 9-column content + 3-column sidebar-blog

### index.php - Blog landing page
- **Status:** NEED
- **Purpose:** Custom blog homepage (Template Name: Blog Landing)
- **Features:** Shows 5 posts/page, featured styling for first post, author gravatars

### page.php - Default page template
- **Status:** NEED
- **Purpose:** Core template for all standard pages
- **Features:** Supports ACF "rows" repeater for flexible content sections

### single.php - Blog post single view
- **Status:** NEED
- **Purpose:** Displays individual blog posts
- **Uses:** header-blog, sidebar-blog, content-single

### front-page.php - Homepage template
- **Status:** NEED
- **Purpose:** Homepage (Template Name: Home Page)
- **Uses:** header-front, content-page

### search.php - Search results page
- **Status:** NEED
- **Purpose:** Displays search results
- **Features:** Relevanssi integration with "did you mean", result count display

---

## ✅ CONTENT TEMPLATE PARTS (NEED)

### content.php - Blog post excerpt display
- **Status:** NEED
- **Purpose:** Used in archive loops
- **Features:** Excerpt, featured image, author gravatar

### content-page.php - Page content display
- **Status:** NEED
- **Purpose:** Renders page content
- **Features:** ACF flexible content rows, Yoast breadcrumbs, banner conditional logic

### content-single.php - Single blog post content
- **Status:** NEED
- **Purpose:** Full post display
- **Features:** Featured image, post meta, entry footer

### content-none.php - No results message
- **Status:** NEED
- **Purpose:** Fallback for empty search/archive results
- **Features:** Different messages for search vs. general "not found"

### content-search.php - Search result item
- **Status:** NEED
- **Purpose:** Individual search result display
- **Features:** Title, excerpt, post meta

---

## ✅ LAYOUT COMPONENTS (NEED)

### header.php - Main site header
- **Status:** NEED
- **Purpose:** Standard site header
- **Features:**
  - Termly consent management
  - Google Analytics (UA-361875-1) + GTM (G-VSHYGNJ605)
  - Roboto font from Google Fonts
  - Floating masthead navigation
  - IE9 polyfills

### footer.php - Site footer
- **Status:** NEED
- **Purpose:** Site footer
- **Features:**
  - Multi-column footer (Company, Products, Markets, News & Events)
  - Footer search form
  - Copyright with dynamic year
  - Google remarketing tag
  - GCLID cookie tracking for ads
  - Termly consent sync iframe
  - Legal links

### template-masthead.php - Navigation menu
- **Status:** NEED
- **Purpose:** Primary navigation component
- **Features:** wp_nav_menu for 'primary' location with Bootstrap classes

### banner-page.php - Page banner/hero
- **Status:** NEED
- **Purpose:** ACF-powered page banners
- **Features:**
  - Custom banner image (desktop + mobile)
  - Custom background color
  - Custom text color
  - Can be disabled per page via ACF field
  - Responsive image handling

### sidebar.php - Default sidebar
- **Status:** MAYBE
- **Purpose:** Generic sidebar widget area
- **Widget Area:** sidebar-1
- **Note:** May not be used if all pages use sidebar-blog instead

### sidebar-blog.php - Blog sidebar
- **Status:** NEED
- **Purpose:** Blog-specific sidebar
- **Widget Area:** sidebar-blog

### comments.php - Comments template
- **Status:** MAYBE
- **Purpose:** Standard WordPress comments display
- **Note:** Only needed if you allow comments on posts/pages

### searchform.php - Search form
- **Status:** NEED
- **Purpose:** Site search form
- **Features:** Bootstrap-styled with glyphicon search icon

---

## ✅ SPECIALIZED HEADERS (REVIEW BASED ON NEEDS)

### header-blog.php - Blog header
- **Status:** REVIEW
- **Purpose:** Blog post header with noindex robots meta
- **Note:** Same as header.php but sets `<meta name="robots" content="noindex">` - determine if blog should be noindexed

### header-front.php - Homepage header
- **Status:** NEED
- **Purpose:** Front page header
- **Note:** Nearly identical to header.php, used by front-page.php

### header-shop.php - Shop/E-commerce header
- **Status:** REVIEW
- **Purpose:** Header for shop/e-commerce pages
- **Note:** Only needed if you have WooCommerce or shop functionality

### header-teproduct.php - Thermoelectric product header
- **Status:** NEED IF YOU HAVE TE PRODUCTS
- **Purpose:** Special header for thermoelectric product pages
- **Features:** Custom $tetitle variable handling for dynamic product titles

### header-fluidproduct.php - Ferrofluid product header
- **Status:** NEED IF YOU HAVE FERROFLUID PRODUCTS
- **Purpose:** Header for ferrofluid product detail pages

### header-vfproduct.php - Vacuum feedthrough product header
- **Status:** NEED IF YOU HAVE VF PRODUCTS
- **Purpose:** Header for vacuum feedthrough product detail pages

---

## 🚫 HILLSTONE CLIENT FILES (DO NOT MIGRATE - FROM ANOTHER CLIENT)

### ❌ archive-resources.php - Resources archive
- **Status:** DO NOT MIGRATE
- **Reason:** Hillstone client custom post type 'hillstone_resources'
- **Features:** Tabbed interface for resources with gated downloads

### ❌ single-resources.php - Single resource view
- **Status:** DO NOT MIGRATE
- **Reason:** Hillstone client CPT

### ❌ content-single_resource.php - Resource content
- **Status:** DO NOT MIGRATE
- **Reason:** Hillstone client CPT

### ❌ single-auc_press.php - Press release single
- **Status:** DO NOT MIGRATE
- **Reason:** Hillstone client CPT 'hillstone_press' (also 'auc_press')

### ❌ content-single_press.php - Press release content
- **Status:** DO NOT MIGRATE
- **Reason:** Hillstone client CPT

### ❌ page-press.php - Press releases listing
- **Status:** DO NOT MIGRATE
- **Template Name:** Press release Page
- **Reason:** Hillstone client CPT 'hillstone_press'

### ❌ page-events.php - Events listing
- **Status:** DO NOT MIGRATE
- **Template Name:** Events Page
- **Reason:** Hillstone client CPT 'hillstone_events'

### ❌ page-register.php - Resource registration form
- **Status:** DO NOT MIGRATE
- **Template Name:** Resources Page
- **Reason:** Hillstone client gated resource functionality

### ❌ page-resources.php - Resources page
- **Status:** DO NOT MIGRATE
- **Template Name:** Resources Page
- **Reason:** Duplicate of archive-resources.php, Hillstone client

### ❌ resources-page.php - Resources accordion component
- **Status:** DO NOT MIGRATE
- **Reason:** Hillstone client ACF resources widget

---

## ⚠️ FERROTEC PRODUCT TEMPLATES (REVIEW CAREFULLY)

### page-teproducts.php - Thermoelectric products
- **Status:** REVIEW - NEED IF ACTIVE
- **Template Name:** Thermoelectric Product Page
- **Purpose:** Individual TE product display with performance graphs
- **Domain:** thermal.ferrotec.com
- **Features:** Product specs, graphs, modal popups

### page-tecatalog.php - TE product catalog
- **Status:** REVIEW - NEED IF ACTIVE
- **Purpose:** Thermoelectric product catalog listing

### page-terecommend.php - TE product recommender
- **Status:** REVIEW - NEED IF ACTIVE
- **Purpose:** Product recommendation tool for thermoelectric modules

### page-ferrofluidproducts.php - Ferrofluid products
- **Status:** REVIEW - NEED IF ACTIVE
- **Purpose:** Ferrofluid product listings
- **Domain:** ferrofluid.ferrotec.com

### page-ferrofluidcatalog.php - Ferrofluid catalog
- **Status:** REVIEW - NEED IF ACTIVE
- **Purpose:** Ferrofluid product catalog

### page-vfproducts.php - Vacuum feedthrough products
- **Status:** REVIEW - NEED IF ACTIVE
- **Purpose:** VF seal product display
- **Domain:** seals.ferrotec.com

### page-vfcatalog.php - VF product catalog
- **Status:** REVIEW - NEED IF ACTIVE
- **Purpose:** Vacuum feedthrough product catalog

### page-oldnews.php - Old news archive
- **Status:** REVIEW
- **Purpose:** Legacy news/blog archive
- **Note:** May be deprecated, check if still in use

---

## ❌ BACKUP/DUPLICATE FILES (DELETE)

### functions copy.php
- **Status:** DELETE
- **Reason:** Backup of functions.php

### page-press copy.php
- **Status:** DELETE
- **Reason:** Backup file

### page-vfproducts copy.php
- **Status:** DELETE
- **Reason:** Backup file

### search copy.php
- **Status:** DELETE
- **Reason:** Backup file

### searchform copy.php
- **Status:** DELETE
- **Reason:** Backup file

### single-auc_press copy.php
- **Status:** DELETE
- **Reason:** Backup file

### template-masthead copy.php
- **Status:** DELETE
- **Reason:** Backup file

---

## 🚫 BIGPIE NONPROFIT FILES (DO NOT MIGRATE - UNRELATED TO FERROTEC)

### ❌ claim-form-received.php
- **Status:** DO NOT MIGRATE
- **Template Name:** Claim Form Received
- **Reason:** BigPie nonprofit directory feature, unrelated to Ferrotec business

### ❌ nonprofit-info.php
- **Status:** DO NOT MIGRATE
- **Template Name:** Nonprofit public info
- **Reason:** BigPie nonprofit directory public profile

### ❌ nonprofit-public-directory.php
- **Status:** DO NOT MIGRATE
- **Purpose:** BigPie nonprofit directory listing
- **Reason:** Unrelated third-party feature

---

## ⚠️ SPECIAL PURPOSE FILES (REVIEW)

### product_redirects.php - URL redirects
- **Status:** REVIEW - LIKELY NEED
- **Purpose:** Maps old product URLs to new structure
- **Importance:** SEO - Preserves inbound links from old ferrofluid audio product URLs
- **Note:** Contains ~100+ redirect rules for audio ferrofluid products (APG series)

### script.php - Modal plugin includes
- **Status:** REVIEW
- **Purpose:** Loads Remodal plugin CSS/JS for Customer Accounts plugin
- **Note:** Only needed if Customer Accounts plugin is still in use

### functions-indexing.php
- **Status:** SEPARATE REVIEW NEEDED
- **Purpose:** SEO/indexing customization
- **Note:** Included by functions.php, needs separate analysis

---

## Summary Statistics

**DEFINITELY NEED:** 18 files
- Core WordPress templates: 7
- Content templates: 5
- Layout components: 6

**REVIEW/CONDITIONAL:** 15 files
- Product-specific headers: 3
- Product page templates: 7
- Special purpose: 3
- Conditional: 2 (sidebar.php, comments.php)

**DO NOT MIGRATE:** 18 files
- Hillstone client files: 10
- BigPie nonprofit files: 3
- Backup/duplicate files: 7

**TOTAL FILES ANALYZED:** 51

---

## Migration Recommendations

### Phase 1: Core Migration
Migrate these essential files first:
- All core WordPress templates (404, archive, index, page, single, front-page, search)
- All content templates (content*.php)
- Layout components (header, footer, masthead, banner, sidebars, searchform)

### Phase 2: Conditional Migration
Determine which product lines are active and migrate only those:
- TE products → page-teproducts.php, page-tecatalog.php, page-terecommend.php, header-teproduct.php
- Ferrofluid → page-ferrofluidproducts.php, page-ferrofluidcatalog.php, header-fluidproduct.php
- VF/Seals → page-vfproducts.php, page-vfcatalog.php, header-vfproduct.php

### Phase 3: SEO & Redirects
Review and migrate if needed:
- product_redirects.php (important for preserving SEO)

### Do NOT Migrate
- Any file with "copy.php" in the name
- Any file containing "hillstone_" custom post types
- Any nonprofit/BigPie related files
