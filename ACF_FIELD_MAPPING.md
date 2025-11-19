# ACF Field Mapping - Ferrotec Theme Migration

**Generated:** 2025-11-19
**Source:** Analysis of old-themes directory

This document catalogs all Advanced Custom Fields (ACF) used across the legacy Ferrotec WordPress multisite themes.

---

## Table of Contents
- [Thermal Electric Products (child-thermalelectric)](#thermal-electric-products)
- [Vacuum Seals/Feedthrough Products (child-seals/layers2)](#vacuum-sealsfeedthrough-products)
- [MEI VAC Products (child-meivac)](#mei-vac-products)
- [Ferrofluid Products (child-ferrofluid/layers2)](#ferrofluid-products)
- [Corporate Site (child-corporate)](#corporate-site)
- [Shared Fields (All Sites)](#shared-fields-all-sites)
- [Resources, Events & News](#resources-events--news)
- [User Meta Fields](#user-meta-fields)

---

## Thermal Electric Products

**Site:** child-thermalelectric (thermal products)
**Product Type:** Peltier Coolers / Thermoelectric Modules

### Performance Specifications

| Field Name | Type | Context | Used In |
|------------|------|---------|---------|
| `iMax` | Number | Maximum Current (Amps) | teListing.php, teListing-type.php, page-te_all_prods.php, content-single-product.php |
| `vMax` | Number | Maximum Voltage (Volts) | teListing.php, teListing-type.php, page-te_all_prods.php, content-single-product.php |
| `tMax` | Number | Maximum Temperature Difference (Delta T) | teListing.php, teListing-type.php, page-te_all_prods.php, content-single-product.php |
| `qcMax` | Number | Maximum Cooling Capacity (Qc Max) | teListing.php, teListing-type.php, page-te_all_prods.php, content-single-product.php |

### Dimensions - Standard Modules

| Field Name | Type | Context | Used In |
|------------|------|---------|---------|
| `baseW` | Number | Base Width (mm) | teListing.php, teListing-type.php, page-te_all_prods.php, content-single-product.php |
| `baseL` | Number | Base Length (mm) | teListing.php, teListing-type.php, page-te_all_prods.php, content-single-product.php |
| `topW` | Number | Top Width (mm) | teListing.php, teListing-type.php, page-te_all_prods.php, content-single-product.php |
| `topL` | Number | Top Length (mm) | teListing.php, teListing-type.php, page-te_all_prods.php, content-single-product.php |
| `hDim` | Number | Height/Thickness (mm) | teListing.php, teListing-type.php, page-te_all_prods.php, content-single-product.php |

### Dimensions - Alternative Formats

| Field Name | Type | Context | Used In |
|------------|------|---------|---------|
| `w1Dim` | Number | W1 Dimension (mm) | content-single-product.php |
| `l1Dim` | Number | L1 Dimension (mm) | content-single-product.php |
| `w2Dim` | Number | W2 Dimension (mm) | content-single-product.php |
| `l2Dim` | Number | L2 Dimension (mm) | content-single-product.php |
| `w3Dim` | Number | W3 Dimension (mm) | content-single-product.php |
| `l3Dim` | Number | L3 Dimension (mm) | content-single-product.php |
| `idDim` | Number | Inner Diameter (mm) - for circular modules | content-single-product.php |
| `oDim` | Number | Outer Diameter (mm) - for circular modules | content-single-product.php |

### Product Information

| Field Name | Type | Context | Used In |
|------------|------|---------|---------|
| `fullPN` | Text | Full Part Number (e.g., "9501/127/060B") | content-single-product.php |
| `altDescription` | Text | Alternative description for product listing | teListing.php, teListing-type.php, page-te_all_prods.php, content-single-product.php |
| `description` | Text | Detailed product description | content-single-product.php |
| `numCouples` | Number | Number of thermoelectric couples | content-single-product.php |
| `substrateType` | Text | Substrate type code (M=metalized, B=bare) | content-single-product.php |
| `image_url` | Text | Product image filename | content-single-product.php |
| `fk_tefamilyinfoid` | Number | Foreign key to TE family (1,2,5,6,7,8,10,12,14,15,16,17) | content-single-product.php |
| `graph_flag` | Boolean/Text | Enable/disable thermal modeling graphs | content-single-product.php |
| `module_id` | Number | Module ID for graph generation | content-single-product.php |
| `woo_prod_id` | Number | WooCommerce product ID reference | page-teproducts.php, content-teproducts.php |

### Files & Downloads

| Field Name | Type | Context | Used In |
|------------|------|---------|---------|
| `pdf_filename` | URL/Text | URL to product specification PDF | content-single-product.php |

### Product Category Fields

| Field Name | Type | Context | Used In |
|------------|------|---------|---------|
| `dimFile` | Text | Dimension diagram filename (stored on category) | content-single-product.php, page-teproducts.php |
| `stdDesc` | Text | Standard family description (stored on category) | content-single-product.php, page-teproducts.php |
| `bigDesc` | Text | Extended family description (stored on category) | content-single-product.php, page-teproducts.php |

---

## Vacuum Seals/Feedthrough Products

**Site:** child-seals / layers2
**Product Type:** Ferrofluidic Vacuum Rotary Feedthroughs

### Product Identification

| Field Name | Type | Context | Used In |
|------------|------|---------|---------|
| `mNum` | Text | Model Number (e.g., "MF-1000") | header-vfproduct.php, content-vfproducts.php |
| `pNum` | Text | Part Number (e.g., "MF1000001AA") | header-vfproduct.php, content-vfproducts.php, woocommerce/archive-product.php |
| `familyTitle` | Text | Product family title | content-vfproducts.php |
| `unit` | Number | Unit system (0=metric/mm, 1=imperial/in) | content-vfproducts.php, woocommerce/archive-product.php |

### Foreign Keys / Product Classifications

| Field Name | Type | Context | Used In |
|------------|------|---------|---------|
| `fk_shaftID` | Number | Shaft type ID (1=solid, 2=hollow) | woocommerce/archive-product.php, content-vfproducts.php |
| `fk_mountingID` | Number | Mounting type ID | woocommerce/archive-product.php |
| `fk_fluidID` | Number | Ferrofluid type (1=fluorocarbon, 2=hydrocarbon) | woocommerce/archive-product.php, content-vfproducts.php |

### Boolean Feature Flags

**Shaft Support Types:**
| Field Name | Type | Context | Used In |
|------------|------|---------|---------|
| `b1` | Boolean | Simply Supported (vac+atm sides) | content-vfproducts.php |
| `b2` | Boolean | Cantilevered (both on atm side) | content-vfproducts.php |
| `b3` | Boolean | Heavy Duty | content-vfproducts.php |

**Product Features:**
| Field Name | Type | Context | Used In |
|------------|------|---------|---------|
| `f1` | Boolean | Sleeve feature | content-vfproducts.php |
| `f2` | Boolean | Water-cooled | woocommerce/archive-product.php, content-vfproducts.php |
| `f3` | Boolean | Shaft Clamp | content-vfproducts.php |
| `f4` | Boolean | Electrical Isolation (Sleeved Bore) | content-vfproducts.php |
| `f5` | Boolean | Number of Union Services | content-vfproducts.php |
| `mntOpt` | Boolean | Mounting Nut and Washer Included | content-vfproducts.php |
| `nS` | Boolean | Normally in Stock availability flag | content-vfproducts.php |

### Dimensions (d1-d45)

**Shaft Dimensions:**
| Field Name | Type | Context | Used In |
|------------|------|---------|---------|
| `d1` | Number | Primary shaft dimension | woocommerce/archive-product.php |
| `d2` | Number | Shaft diameter tolerance/alternative | content-vfproducts.php |
| `d3` | Number | Shaft termination | content-vfproducts.php |
| `d4` | Number | Shaft extension (Vacuum side) | content-vfproducts.php |
| `d45` | Number | Shaft (or bore) Diameter with tolerance | content-vfproducts.php |

**Housing Dimensions:**
| Field Name | Type | Context | Used In |
|------------|------|---------|---------|
| `d5` | Number | Overall length | content-vfproducts.php |
| `d6` | Number | Housing overall length | content-vfproducts.php |
| `d7` | Number | Housing diameter | content-vfproducts.php |
| `d8` | Number | Housing diameter tolerance/alternative | content-vfproducts.php |
| `d9` | Number | Body length | content-vfproducts.php |

**Thread & Mounting Dimensions:**
| Field Name | Type | Context | Used In |
|------------|------|---------|---------|
| `d10` | Number | Thread diameter | content-vfproducts.php |
| `d11` | Number | Thread pitch [tps] or [mm/thd] | content-vfproducts.php |
| `d12` | Number | Thread length | content-vfproducts.php |
| `d13` | Number | Clamp diameter | content-vfproducts.php |
| `d14` | Number | Clamp thickness | content-vfproducts.php |

**Recommended Dimensions:**
| Field Name | Type | Context | Used In |
|------------|------|---------|---------|
| `d15` | Number | Recommended shaft diameter | content-vfproducts.php |
| `d16` | Number | Recommended shaft diameter tolerance | content-vfproducts.php |
| `d17` | Number | Recommended mounting bore | content-vfproducts.php |
| `d18` | Number | Recommended mounting bore tolerance | content-vfproducts.php |

**Flange Dimensions:**
| Field Name | Type | Context | Used In |
|------------|------|---------|---------|
| `d19` | Number | Flange diameter | content-vfproducts.php |
| `d20` | Number | Flange thickness | content-vfproducts.php |
| `d21` | Number | Flange wrench flat | content-vfproducts.php |
| `d22` | Number | Fitting locations | content-vfproducts.php |
| `d23` | Number | Mounting holes | content-vfproducts.php |
| `d37` | Text | Face seal O-ring specification | content-vfproducts.php |
| `d38` | Text | Flange Type | content-vfproducts.php |

**Bearing Specifications:**
| Field Name | Type | Context | Used In |
|------------|------|---------|---------|
| `d24` | Number | Shaft Torque Capacity | content-vfproducts.php |
| `d25` | Text | Bearing type/material | content-vfproducts.php |
| `d26` | Number | Bearing load capacity | content-vfproducts.php |
| `d27` | Number | Bearing dynamic load capacity | content-vfproducts.php |
| `d28` | Number | Bearing Dimension A | content-vfproducts.php |
| `d29` | Number | Bearing Dimension B | content-vfproducts.php |

**Performance Characteristics:**
| Field Name | Type | Context | Used In |
|------------|------|---------|---------|
| `d30` | Number | Max Speed | content-vfproducts.php |
| `d31` | Number | Max Thrust (Axial Load Limit) | content-vfproducts.php |
| `d32` | Number | Radial Load Capacity | content-vfproducts.php |
| `d34` | Number | Starting Torque | content-vfproducts.php |
| `d35` | Number | Running Torque | content-vfproducts.php |
| `d36` | Number | Limiting Speed [rpm] | content-vfproducts.php |
| `d39` | Text | Notes | content-vfproducts.php |
| `d40` | Number | Starting Torque @ 100rpm | content-vfproducts.php |
| `d41` | Number | Running Torque @ 100rpm | content-vfproducts.php |
| `d42` | Number | Starting Torque @ 1000rpm | content-vfproducts.php |
| `d43` | Number | Running Torque @ 1000rpm | content-vfproducts.php |

---

## MEI VAC Products

**Site:** child-meivac
**Product Types:** Vacuum Equipment (Vari-Q Valves, E-Vap, Re-Vap, MAK Sputter, etc.)

### CAD Files

| Field Name | Type | Context | Used In |
|------------|------|---------|---------|
| `step_file` | Text | STEP file filename for CAD downloads | functions.php, tab-downloads.php |

### Vari-Q Throttle Valve Specifications

| Field Name | Type | Context | Used In |
|------------|------|---------|---------|
| `vari-q_flange` | Text | Flange type (ASA, ISO, CF, JIS) | listing-vari-q-throttle-valves.php |
| `vari-q_o-d` | Number | Outer Diameter | listing-vari-q-throttle-valves.php |
| `vari-q_i-d` | Number | Inner Diameter | listing-vari-q-throttle-valves.php |
| `vari-q_material` | Text | Flange material (Aluminum, Stainless Steel) | listing-vari-q-throttle-valves.php |
| `vari-q_coating` | Text | Flange coating (Clear Alodine, Hard Anodized) | listing-vari-q-throttle-valves.php |
| `vari-q_actuation` | Text | Actuation type (Pneumatically, Servomotor, On-valve controller) | listing-vari-q-throttle-valves.php |
| `units` | Text | Unit specification | listing-vari-q-throttle-valves.php |

### Product Information

| Field Name | Type | Context | Used In |
|------------|------|---------|---------|
| `mNum` | Text | Model Number (used in Gravity Forms) | tab-ordering.php |

### Category/Archive Display

| Field Name | Type | Context | Used In |
|------------|------|---------|---------|
| `category_image` | Image | Category listing image | listing-e-vap.php |

---

## Ferrofluid Products

**Site:** child-ferrofluid / layers2
**Product Type:** Ferrofluids and Magnetic Nanoparticles

### Product Identification

| Field Name | Type | Context | Used In |
|------------|------|---------|---------|
| `woo_prod_id` | Number | WooCommerce product ID reference | content-ferrofluidproducts.php |
| `model` | Text | Ferrofluid model number | content-ferrofluidproducts.php, functions.php |
| `fk_seriesID` | Number | Series ID (13=EMG Water, 14=EMG Oil, 15=Dry Particles, 16=Educational, 17=PBG) | content-ferrofluidproducts.php |
| `seriesType` | Text | Series type description | content-ferrofluidproducts.php |

### Physical Description

| Field Name | Type | Context | Used In |
|------------|------|---------|---------|
| `description` | Text | Appearance/visual description | content-ferrofluidproducts.php |
| `liquidType` | Text | Carrier liquid type | content-ferrofluidproducts.php |
| `surf_type` | Text | Type of surfactant | content-ferrofluidproducts.php |
| `surf_nature` | Text | Nature of surfactant (ionic, nonionic, etc.) | content-ferrofluidproducts.php |

### Magnetic Properties (CGS & SI Units)

| Field Name | Type | Context | Used In |
|------------|------|---------|---------|
| `sat_guass` | Number | Saturation Magnetization (Gauss) - CGS | content-ferrofluidproducts.php, functions.php |
| `sat_mt` | Number | Saturation Magnetization (mT) - SI | content-ferrofluidproducts.php, functions.php |
| `sat_emuG` | Number | Saturation Magnetization (emu/g) | content-ferrofluidproducts.php |
| `gauss_oe` | Number | Initial Magnetic Susceptibility (CGS) | content-ferrofluidproducts.php |
| `emug_oe` | Number | Initial Magnetic Susceptibility (SI) | content-ferrofluidproducts.php |

### Physical Properties

| Field Name | Type | Context | Used In |
|------------|------|---------|---------|
| `vis_cp` | Number | Viscosity @27°C (cP) - CGS | content-ferrofluidproducts.php, functions.php |
| `sat_mpa_s` | Number | Viscosity @27°C (mPa·s) - SI | content-ferrofluidproducts.php, functions.php |
| `den_g_ml` | Number | Density @25°C (g/cc) - CGS | content-ferrofluidproducts.php |
| `den_g_cm3` | Number | Density @25°C (10³ kg/m³) - SI | content-ferrofluidproducts.php |
| `nominal_diam_nm` | Number | Nominal Particle Diameter (nm) | content-ferrofluidproducts.php |

### Thermal Properties

| Field Name | Type | Context | Used In |
|------------|------|---------|---------|
| `pour_c1` | Number | Pour Point (°C) - value 1 | content-ferrofluidproducts.php |
| `pour_c2` | Number | Pour Point (°C) - value 2 | content-ferrofluidproducts.php |
| `flash_c1` | Number | Flash Point (°C) - value 1 | content-ferrofluidproducts.php |
| `flash_c2` | Number | Flash Point (°C) - value 2 | content-ferrofluidproducts.php |
| `cond_mw1` | Number | Thermal Conductivity @38°C (mW/(m·K)) - value 1 | content-ferrofluidproducts.php |
| `cond_mw2` | Number | Thermal Conductivity @38°C (mW/(m·K)) - value 2 | content-ferrofluidproducts.php |
| `coef_mlc` | Number | Coefficient of Thermal Expansion | content-ferrofluidproducts.php |

### Surface & Chemical Properties

| Field Name | Type | Context | Used In |
|------------|------|---------|---------|
| `surf_dynes_cm` | Number | Surface Tension @25°C (dynes/cm) - CGS | content-ferrofluidproducts.php |
| `surf_mn` | Number | Surface Tension @25°C (mN/m) - SI | content-ferrofluidproducts.php |
| `pH` | Number | pH value | content-ferrofluidproducts.php |
| `volatility_hour` | Text | Volatility specification | content-ferrofluidproducts.php |

### Particle Properties

| Field Name | Type | Context | Used In |
|------------|------|---------|---------|
| `part_conc_weight` | Number | Magnetic Particle Concentration (% vol.) | content-ferrofluidproducts.php |
| `fe_ox` | Number | Iron Oxide Content (wt%) | content-ferrofluidproducts.php |

### Solubility

| Field Name | Type | Context | Used In |
|------------|------|---------|---------|
| `sol_y` | Text | Tested soluble in (comma-separated liquids) | content-ferrofluidproducts.php |
| `sol_n` | Text | Not soluble in (comma-separated liquids) | content-ferrofluidproducts.php |

### Documentation

| Field Name | Type | Context | Used In |
|------------|------|---------|---------|
| `msds` | Text | MSDS/SDS filename prefix | content-ferrofluidproducts.php |

---

## Corporate Site

**Site:** child-corporate
**Shares fields with Thermal Electric products**

### Thermal Electric Fields (Reused)

The corporate site reuses thermal electric product fields in its WooCommerce templates:
- `fullPN`, `dimFile`, `stdDesc`, `bigDesc` (see Thermal Electric section above)

**Files:** woocommerce/content-single-product.php

---

## Shared Fields (All Sites)

These fields are used across multiple sites for page layout and UI elements.

### Page Banner Configuration

| Field Name | Type | Context | Used In |
|------------|------|---------|---------|
| `disable_page_banner` | Boolean | Toggle to disable page banner | banner-page.php, archive-product.php (meivac) |
| `banner_image` | Image | Desktop banner background image | banner-page.php, archive-product.php (meivac) |
| `mobile_banner_image` | Image | Mobile banner background image | banner-page.php, archive-product.php (meivac) |
| `banner_color` | Color | Banner background color | banner-page.php, archive-product.php (meivac) |
| `text_color` | Color | Banner text color | banner-page.php, archive-product.php (meivac) |
| `banner_text` | Text/WYSIWYG | Custom banner text content | banner-page.php, archive-product.php (meivac) |

### Flexible Content / Page Builder

| Field Name | Type | Context | Used In |
|------------|------|---------|---------|
| `rows` | Repeater | Flexible content rows for page layout | content-page.php, archive-product.php (meivac) |
| `rows > content` | WYSIWYG | Content for each row | content-page.php (sub_field) |
| `rows > background-color` | Color | Background color for row | content-page.php (sub_field) |
| `rows > background-class` | Text | CSS class for row background | content-page.php (sub_field) |

---

## Resources, Events & News

**Sites:** All sites (layers2 parent theme)
**Post Types:** hillstone_resources, auc_press, auc_news, auc_events

### News & Press Releases

| Field Name | Type | Context | Used In |
|------------|------|---------|---------|
| `news_url` | URL | External news article URL | functions.php |

### Events

| Field Name | Type | Context | Used In |
|------------|------|---------|---------|
| `start_date` | Date | Event start date | functions.php, page-events.php |
| `end_date` | Date | Event end date | functions.php, page-events.php |
| `promotional_url` | URL | Event promotional website | functions.php, page-events.php |
| `registration_url` | URL | Event registration link | page-events.php |
| `event_image` | Image | Event thumbnail/featured image | page-events.php, page-resources.php |

### Resources (Whitepapers, Webinars, Videos)

| Field Name | Type | Context | Used In |
|------------|------|---------|---------|
| `category` | Select | Resource category (whitepaper, video, webinar, etc.) | content-single_resource.php, page-resources.php |
| `resource_url` | URL | URL to resource file or video | functions.php, page-resources.php, content-single_resource.php |
| `resource_links` | Relationship | Related resource posts | functions.php, resources-page.php |
| `gated` | Boolean | Whether resource requires registration | functions.php, page-resources.php |
| `featured` | Boolean/Text | Mark resource as featured ("true") | page-resources.php |
| `video_thumbnail` | Image | Custom video thumbnail image | page-resources.php |

---

## User Meta Fields

**Applied to:** WordPress users
**Context:** Download tracking and access control

| Field Name | Type | Context | Used In |
|------------|------|---------|---------|
| `disable_download` | Boolean | Flag to disable user's download access if excessive | content-single-product.php (TE, VF), tab-downloads.php (MEI) |

**Usage:** Checked with `get_field('disable_download', 'user_' . get_current_user_id())` to show warning message instead of download links.

---

## Field Implementation Notes

### Common Patterns

1. **Product ID References:**
   - `woo_prod_id` - Used to link legacy pages to WooCommerce products
   - Often retrieved and used to get all other fields via `get_fields($prod_id)`

2. **Foreign Keys:**
   - `fk_*` prefix indicates foreign key relationships to taxonomy/lookup tables
   - Examples: `fk_tefamilyinfoid`, `fk_shaftID`, `fk_mountingID`, `fk_fluidID`, `fk_seriesID`

3. **Dimension Fields:**
   - Vacuum feedthrough products use `d1` through `d45` (47+ dimensional fields)
   - Often conditionally displayed: `<?php if (get_field('d10') != 0) : ?>`
   - Context provided by table labels in template

4. **Boolean Flags:**
   - Often checked with `== '1'` comparison
   - Used for features, availability, and conditional displays

5. **Unit Systems:**
   - `unit` field: 0=metric (mm), 1=imperial (in)
   - Affects display labels and conversions

6. **Taxonomy vs ACF:**
   - Some fields stored on **product categories** (taxonomy terms), not products
   - Examples: `dimFile`, `stdDesc`, `bigDesc`, `category_image`
   - Retrieved with `get_field('field_name', $term)` or `the_field('field_name', $term)`

### Migration Considerations

1. **Database Schema:**
   - ACF stores data in `wp_postmeta` with keys like `field_name` and `_field_name`
   - Foreign key fields need corresponding lookup tables/taxonomies

2. **Field Groups:**
   - Need to reconstruct ACF field groups from usage patterns
   - Location rules: Product post type, specific categories, user roles

3. **Repeater Fields:**
   - `rows` is a repeater with sub-fields: `content`, `background-color`, `background-class`
   - Need to preserve repeater structure in migration

4. **Image Fields:**
   - Return format may be: URL, ID, or Array
   - Check usage context to determine return type

5. **Conditional Logic:**
   - Many fields have conditional display logic in templates
   - May need to replicate in new theme or UI

6. **Data Validation:**
   - Numeric fields often checked for `!= 0` or `!= ''` before display
   - Boolean fields checked for `== '1'`

---

## Summary Statistics

- **Total Unique Fields:** 150+
- **Product-Specific Fields:** 120+
- **Shared UI/Layout Fields:** 10+
- **Resource/Event Fields:** 12+
- **User Meta Fields:** 1

### By Product Line:
- **Thermal Electric:** 30+ fields
- **Vacuum Feedthrough:** 75+ fields (mostly dimensions)
- **MEI VAC:** 10+ fields
- **Ferrofluid:** 40+ fields

---

## Next Steps for Migration

1. **Export ACF Field Groups** from production sites (if accessible)
2. **Create ACF JSON** definitions for version control
3. **Map to new data structure** (Custom Post Types, Taxonomies, or Plugin)
4. **Build migration scripts** to transfer data
5. **Create UI templates** using new field structure
6. **Validate data integrity** after migration

---

**Document Maintenance:**
- Update as new fields are discovered
- Track field usage changes during migration
- Document any field deprecations or consolidations
