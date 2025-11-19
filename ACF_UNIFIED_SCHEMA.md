# ACF Unified Field Schema - Ferrotec Multisite

**Generated:** 2025-11-19
**Purpose:** Standardized ACF field naming convention for new ftc-product-ui plugin

This document defines the unified ACF field schema to be used across all Ferrotec subsites. Fields follow a consistent naming pattern: `{site_prefix}_{category}_{property}` or `product_{category}_{property}` for shared fields.

---

## Table of Contents

- [Naming Conventions](#naming-conventions)
- [Shared Product Fields (All Sites)](#shared-product-fields-all-sites)
- [Thermal Electric Fields](#thermal-electric-fields)
- [Vacuum Seal/Feedthrough Fields](#vacuum-sealfeedthrough-fields)
- [Ferrofluid Fields](#ferrofluid-fields)
- [MEI VAC Fields](#mei-vac-fields)
- [Page/Content Fields (Shared)](#pagecontent-fields-shared)

---

## Naming Conventions

### Field Prefixes

- `product_` - Shared across all product types
- `thermal_` - Thermal electric products only
- `seal_` - Vacuum feedthrough/seal products only
- `ferrofluid_` - Ferrofluid products only
- `meivac_` - MEI VAC products only
- `page_` - Page-level fields (banners, layout)
- `resource_` - Resources/events/news

### Field Groups

Fields are organized into ACF Field Groups by:
1. **Shared Product Fields** - Common to all WooCommerce products
2. **Site-Specific Product Fields** - Conditional based on product category
3. **Page Fields** - For pages and archives
4. **Resource Fields** - For custom post types

### Data Types

- **Text** - Short text (255 chars)
- **Number** - Integer or decimal
- **File** - File upload (PDF, CAD, images)
- **True/False** - Boolean checkbox
- **Select** - Dropdown selection
- **Repeater** - Repeating field group
- **WYSIWYG** - Rich text editor

---

## Shared Product Fields (All Sites)

These fields are available on ALL WooCommerce products across all subsites.

### Product Identification

| Field Name | Old Name(s) | Type | Description | ACF Key |
|------------|-------------|------|-------------|---------|
| `product_model` | `fullPN`, `model`, `pNum` | Text | Product model/part number | `field_product_model` |
| `product_alt_description` | `altDescription` | Text | Alternative description for listings | `field_product_alt_description` |

### Files & Downloads

| Field Name | Old Name(s) | Type | Description | ACF Key |
|------------|-------------|------|-------------|---------|
| `product_cad_file` | `step_file`, various CAD | File | CAD file (STEP, DXF) | `field_product_cad_file` |
| `product_datasheet` | `pdf_filename` | File | Product datasheet PDF | `field_product_datasheet` |
| `product_spec_drawing` | Various image refs | File | Specification drawing/diagram | `field_product_spec_drawing` |

### Performance Modeling

| Field Name | Old Name(s) | Type | Description | ACF Key |
|------------|-------------|------|-------------|---------|
| `product_enable_modeling` | `graph_flag` | True/False | Enable performance modeling tab | `field_product_enable_modeling` |
| `product_modeling_content` | New | WYSIWYG | Modeling tab custom content | `field_product_modeling_content` |

---

## Thermal Electric Fields

**Product Category:** Thermoelectric modules, Peltier coolers
**Location Rule:** `product_cat == 'thermal-modules'` OR `product_cat == 'peltier-coolers'`

### Group: `group_thermal_product_fields`

### Performance Specifications

| Field Name | Old Name | Type | Description | Unit | ACF Key |
|------------|----------|------|-------------|------|---------|
| `thermal_current_max` | `iMax` | Number | Maximum Current | Amps | `field_thermal_current_max` |
| `thermal_voltage_max` | `vMax` | Number | Maximum Voltage | Volts | `field_thermal_voltage_max` |
| `thermal_delta_t_max` | `tMax` | Number | Maximum Temperature Difference | °C | `field_thermal_delta_t_max` |
| `thermal_cooling_capacity_max` | `qcMax` | Number | Maximum Cooling Capacity | Watts | `field_thermal_cooling_capacity_max` |
| `thermal_couples_count` | `numCouples` | Number | Number of thermoelectric couples | - | `field_thermal_couples_count` |

### Dimensions - Standard Modules

| Field Name | Old Name | Type | Description | Unit | ACF Key |
|------------|----------|------|-------------|------|---------|
| `thermal_base_width` | `baseW` | Number | Base Width | mm | `field_thermal_base_width` |
| `thermal_base_length` | `baseL` | Number | Base Length | mm | `field_thermal_base_length` |
| `thermal_top_width` | `topW` | Number | Top Width | mm | `field_thermal_top_width` |
| `thermal_top_length` | `topL` | Number | Top Length | mm | `field_thermal_top_length` |
| `thermal_height` | `hDim` | Number | Module Height/Thickness | mm | `field_thermal_height` |

### Dimensions - Circular Modules

| Field Name | Old Name | Type | Description | Unit | ACF Key |
|------------|----------|------|-------------|------|---------|
| `thermal_inner_diameter` | `idDim` | Number | Inner Diameter | mm | `field_thermal_inner_diameter` |
| `thermal_outer_diameter` | `oDim` | Number | Outer Diameter | mm | `field_thermal_outer_diameter` |

### Dimensions - Alternative Format

| Field Name | Old Name | Type | Description | Unit | ACF Key |
|------------|----------|------|-------------|------|---------|
| `thermal_w1_dimension` | `w1Dim` | Number | W1 Dimension | mm | `field_thermal_w1_dimension` |
| `thermal_l1_dimension` | `l1Dim` | Number | L1 Dimension | mm | `field_thermal_l1_dimension` |
| `thermal_w2_dimension` | `w2Dim` | Number | W2 Dimension | mm | `field_thermal_w2_dimension` |
| `thermal_l2_dimension` | `l2Dim` | Number | L2 Dimension | mm | `field_thermal_l2_dimension` |
| `thermal_w3_dimension` | `w3Dim` | Number | W3 Dimension | mm | `field_thermal_w3_dimension` |
| `thermal_l3_dimension` | `l3Dim` | Number | L3 Dimension | mm | `field_thermal_l3_dimension` |

### Product Classification

| Field Name | Old Name | Type | Description | ACF Key |
|------------|----------|------|-------------|---------|
| `thermal_substrate_type` | `substrateType` | Select | Substrate type (M=metalized, B=bare, etc.) | `field_thermal_substrate_type` |
| `thermal_family_id` | `fk_tefamilyinfoid` | Select | TE product family (1,2,5,6,7,8,10,12,14,15,16,17) | `field_thermal_family_id` |

### Performance Modeling Data

| Field Name | Old Name | Type | Description | ACF Key |
|------------|----------|------|-------------|---------|
| `thermal_performance_data` | New | Repeater | Performance curve data for Chart.js | `field_thermal_performance_data` |

**Repeater Subfields:**
- `dataset_label` (Text) - Chart dataset label (e.g., "Hot Side Temperature")
- `x_values` (Text) - Comma-separated X-axis values
- `y_values` (Text) - Comma-separated Y-axis values
- `chart_type` (Select) - line, scatter, bar
- `x_axis_label` (Text) - X-axis label with unit
- `y_axis_label` (Text) - Y-axis label with unit

---

## Vacuum Seal/Feedthrough Fields

**Product Category:** Ferrofluidic vacuum rotary feedthroughs
**Location Rule:** `product_cat == 'vacuum-feedthrough'` OR `product_cat == 'ferrofluidic-seals'`

### Group: `group_seal_product_fields`

### Product Identification

| Field Name | Old Name | Type | Description | ACF Key |
|------------|----------|------|-------------|---------|
| `seal_model_number` | `mNum` | Text | Feedthrough model number (e.g., MF-1000) | `field_seal_model_number` |
| `seal_part_number` | `pNum` | Text | Full part number (e.g., MF1000001AA) | `field_seal_part_number` |
| `seal_family_title` | `familyTitle` | Text | Product family title | `field_seal_family_title` |
| `seal_unit_system` | `unit` | Select | 0 = Metric (mm), 1 = Imperial (in) | `field_seal_unit_system` |

### Product Classifications

| Field Name | Old Name | Type | Description | ACF Key |
|------------|----------|------|-------------|---------|
| `seal_shaft_type` | `fk_shaftID` | Select | 1 = Solid, 2 = Hollow | `field_seal_shaft_type` |
| `seal_mount_type` | `fk_mountingID` | Select | Mounting type | `field_seal_mount_type` |
| `seal_fluid_type` | `fk_fluidID` | Select | 1 = Fluorocarbon, 2 = Hydrocarbon | `field_seal_fluid_type` |

### Shaft Support Features

| Field Name | Old Name | Type | Description | ACF Key |
|------------|----------|------|-------------|---------|
| `seal_support_simply` | `b1` | True/False | Simply Supported (vac+atm sides) | `field_seal_support_simply` |
| `seal_support_cantilevered` | `b2` | True/False | Cantilevered (both on atm side) | `field_seal_support_cantilevered` |
| `seal_support_heavy_duty` | `b3` | True/False | Heavy Duty | `field_seal_support_heavy_duty` |

### Product Features

| Field Name | Old Name | Type | Description | ACF Key |
|------------|----------|------|-------------|---------|
| `seal_feature_sleeve` | `f1` | True/False | Sleeve feature | `field_seal_feature_sleeve` |
| `seal_feature_water_cooled` | `f2` | True/False | Water-cooled for high-temp | `field_seal_feature_water_cooled` |
| `seal_feature_shaft_clamp` | `f3` | True/False | Shaft Clamp | `field_seal_feature_shaft_clamp` |
| `seal_feature_electrical_isolation` | `f4` | True/False | Electrical Isolation (Sleeved Bore) | `field_seal_feature_electrical_isolation` |
| `seal_feature_union_services` | `f5` | True/False | Union Services | `field_seal_feature_union_services` |
| `seal_mounting_kit_included` | `mntOpt` | True/False | Mounting Nut and Washer Included | `field_seal_mounting_kit_included` |
| `seal_normally_in_stock` | `nS` | True/False | Normally in Stock | `field_seal_normally_in_stock` |

### Dimensions

**Note:** Vacuum feedthrough products have 45 dimension fields (d1-d45). To keep the schema manageable, we'll group them logically.

| Field Name | Old Name | Type | Description | ACF Key |
|------------|----------|------|-------------|---------|
| `seal_shaft_diameter` | `d45`, `d1` | Number | Shaft/bore diameter | `field_seal_shaft_diameter` |
| `seal_shaft_diameter_tolerance` | `d2` | Number | Diameter tolerance | `field_seal_shaft_diameter_tolerance` |
| `seal_shaft_termination` | `d3` | Number | Shaft termination | `field_seal_shaft_termination` |
| `seal_shaft_extension_vacuum` | `d4` | Number | Shaft extension (vacuum side) | `field_seal_shaft_extension_vacuum` |
| `seal_overall_length` | `d5` | Number | Overall length | `field_seal_overall_length` |
| `seal_housing_length` | `d6` | Number | Housing overall length | `field_seal_housing_length` |
| `seal_housing_diameter` | `d7` | Number | Housing diameter | `field_seal_housing_diameter` |
| `seal_housing_diameter_tolerance` | `d8` | Number | Housing diameter tolerance | `field_seal_housing_diameter_tolerance` |
| `seal_body_length` | `d9` | Number | Body length | `field_seal_body_length` |
| `seal_thread_diameter` | `d10` | Number | Thread diameter | `field_seal_thread_diameter` |
| `seal_thread_pitch` | `d11` | Number | Thread pitch [tps] or [mm/thd] | `field_seal_thread_pitch` |
| `seal_thread_length` | `d12` | Number | Thread length | `field_seal_thread_length` |
| `seal_clamp_diameter` | `d13` | Number | Clamp diameter | `field_seal_clamp_diameter` |
| `seal_clamp_thickness` | `d14` | Number | Clamp thickness | `field_seal_clamp_thickness` |
| `seal_recommended_shaft_diameter` | `d15` | Number | Recommended shaft diameter | `field_seal_recommended_shaft_diameter` |
| `seal_recommended_shaft_tolerance` | `d16` | Number | Recommended shaft tolerance | `field_seal_recommended_shaft_tolerance` |
| `seal_recommended_bore` | `d17` | Number | Recommended mounting bore | `field_seal_recommended_bore` |
| `seal_recommended_bore_tolerance` | `d18` | Number | Recommended bore tolerance | `field_seal_recommended_bore_tolerance` |
| `seal_flange_diameter` | `d19` | Number | Flange diameter | `field_seal_flange_diameter` |
| `seal_flange_thickness` | `d20` | Number | Flange thickness | `field_seal_flange_thickness` |
| `seal_flange_wrench_flat` | `d21` | Number | Flange wrench flat | `field_seal_flange_wrench_flat` |
| `seal_fitting_locations` | `d22` | Number | Fitting locations | `field_seal_fitting_locations` |
| `seal_mounting_holes` | `d23` | Number | Mounting holes | `field_seal_mounting_holes` |
| `seal_shaft_torque_capacity` | `d24` | Number | Shaft torque capacity | `field_seal_shaft_torque_capacity` |
| `seal_bearing_type` | `d25` | Text | Bearing type/material | `field_seal_bearing_type` |
| `seal_bearing_load_capacity` | `d26` | Number | Bearing load capacity | `field_seal_bearing_load_capacity` |
| `seal_bearing_dynamic_load` | `d27` | Number | Bearing dynamic load capacity | `field_seal_bearing_dynamic_load` |
| `seal_bearing_dim_a` | `d28` | Number | Bearing dimension A | `field_seal_bearing_dim_a` |
| `seal_bearing_dim_b` | `d29` | Number | Bearing dimension B | `field_seal_bearing_dim_b` |
| `seal_max_speed` | `d30` | Number | Maximum speed (RPM) | `field_seal_max_speed` |
| `seal_max_thrust` | `d31` | Number | Max thrust (axial load limit) | `field_seal_max_thrust` |
| `seal_radial_load_capacity` | `d32` | Number | Radial load capacity | `field_seal_radial_load_capacity` |
| `seal_starting_torque` | `d34` | Number | Starting torque | `field_seal_starting_torque` |
| `seal_running_torque` | `d35` | Number | Running torque | `field_seal_running_torque` |
| `seal_limiting_speed` | `d36` | Number | Limiting speed [rpm] | `field_seal_limiting_speed` |
| `seal_face_seal_oring` | `d37` | Text | Face seal O-ring specification | `field_seal_face_seal_oring` |
| `seal_flange_type` | `d38` | Text | Flange type | `field_seal_flange_type` |
| `seal_notes` | `d39` | Text | Additional notes | `field_seal_notes` |
| `seal_starting_torque_100rpm` | `d40` | Number | Starting torque @ 100rpm | `field_seal_starting_torque_100rpm` |
| `seal_running_torque_100rpm` | `d41` | Number | Running torque @ 100rpm | `field_seal_running_torque_100rpm` |
| `seal_starting_torque_1000rpm` | `d42` | Number | Starting torque @ 1000rpm | `field_seal_starting_torque_1000rpm` |
| `seal_running_torque_1000rpm` | `d43` | Number | Running torque @ 1000rpm | `field_seal_running_torque_1000rpm` |

---

## Ferrofluid Fields

**Product Category:** Ferrofluids and magnetic nanoparticles
**Location Rule:** `product_cat == 'ferrofluid'`

### Group: `group_ferrofluid_product_fields`

### Product Identification

| Field Name | Old Name | Type | Description | ACF Key |
|------------|----------|------|-------------|---------|
| `ferrofluid_series_id` | `fk_seriesID` | Select | 13=EMG Water, 14=EMG Oil, 15=Dry Particles, 16=Educational, 17=PBG | `field_ferrofluid_series_id` |
| `ferrofluid_series_type` | `seriesType` | Text | Series type description | `field_ferrofluid_series_type` |

### Physical Description

| Field Name | Old Name | Type | Description | ACF Key |
|------------|----------|------|-------------|---------|
| `ferrofluid_appearance` | `description` | Text | Visual appearance/description | `field_ferrofluid_appearance` |
| `ferrofluid_liquid_type` | `liquidType` | Text | Carrier liquid type | `field_ferrofluid_liquid_type` |
| `ferrofluid_surfactant_type` | `surf_type` | Text | Type of surfactant | `field_ferrofluid_surfactant_type` |
| `ferrofluid_surfactant_nature` | `surf_nature` | Text | Nature of surfactant (ionic, nonionic) | `field_ferrofluid_surfactant_nature` |

### Magnetic Properties

| Field Name | Old Name | Type | Description | Unit | ACF Key |
|------------|----------|------|-------------|------|---------|
| `ferrofluid_saturation_gauss` | `sat_guass` (typo) | Number | Saturation Magnetization | Gauss | `field_ferrofluid_saturation_gauss` |
| `ferrofluid_saturation_mt` | `sat_mt` | Number | Saturation Magnetization | mT | `field_ferrofluid_saturation_mt` |
| `ferrofluid_saturation_emug` | `sat_emuG` | Number | Saturation Magnetization | emu/g | `field_ferrofluid_saturation_emug` |
| `ferrofluid_susceptibility_cgs` | `gauss_oe` | Number | Initial Magnetic Susceptibility (CGS) | Gauss/Oe | `field_ferrofluid_susceptibility_cgs` |
| `ferrofluid_susceptibility_si` | `emug_oe` | Number | Initial Magnetic Susceptibility (SI) | emu/g/Oe | `field_ferrofluid_susceptibility_si` |

### Physical Properties

| Field Name | Old Name | Type | Description | Unit | ACF Key |
|------------|----------|------|-------------|------|---------|
| `ferrofluid_viscosity_cp` | `vis_cp` | Number | Viscosity @27°C | cP | `field_ferrofluid_viscosity_cp` |
| `ferrofluid_viscosity_mpa` | `sat_mpa_s` | Number | Viscosity @27°C | mPa·s | `field_ferrofluid_viscosity_mpa` |
| `ferrofluid_density_gml` | `den_g_ml` | Number | Density @25°C | g/cc | `field_ferrofluid_density_gml` |
| `ferrofluid_density_gcm3` | `den_g_cm3` | Number | Density @25°C | 10³ kg/m³ | `field_ferrofluid_density_gcm3` |
| `ferrofluid_particle_diameter` | `nominal_diam_nm` | Number | Nominal Particle Diameter | nm | `field_ferrofluid_particle_diameter` |

### Thermal Properties

| Field Name | Old Name | Type | Description | Unit | ACF Key |
|------------|----------|------|-------------|------|---------|
| `ferrofluid_pour_point_min` | `pour_c1` | Number | Pour Point (min) | °C | `field_ferrofluid_pour_point_min` |
| `ferrofluid_pour_point_max` | `pour_c2` | Number | Pour Point (max) | °C | `field_ferrofluid_pour_point_max` |
| `ferrofluid_flash_point_min` | `flash_c1` | Number | Flash Point (min) | °C | `field_ferrofluid_flash_point_min` |
| `ferrofluid_flash_point_max` | `flash_c2` | Number | Flash Point (max) | °C | `field_ferrofluid_flash_point_max` |
| `ferrofluid_thermal_conductivity_min` | `cond_mw1` | Number | Thermal Conductivity @38°C (min) | mW/(m·K) | `field_ferrofluid_thermal_conductivity_min` |
| `ferrofluid_thermal_conductivity_max` | `cond_mw2` | Number | Thermal Conductivity @38°C (max) | mW/(m·K) | `field_ferrofluid_thermal_conductivity_max` |
| `ferrofluid_thermal_expansion_coef` | `coef_mlc` | Number | Coefficient of Thermal Expansion | mL/(°C·L) | `field_ferrofluid_thermal_expansion_coef` |

### Chemical Properties

| Field Name | Old Name | Type | Description | ACF Key |
|------------|----------|------|-------------|---------|
| `ferrofluid_ph` | `pH` | Number | pH value | `field_ferrofluid_ph` |
| `ferrofluid_solubility_yes` | `sol_y` | Text | Soluble in (list) | `field_ferrofluid_solubility_yes` |
| `ferrofluid_solubility_no` | `sol_n` | Text | Not soluble in (list) | `field_ferrofluid_solubility_no` |

---

## MEI VAC Fields

**Product Category:** MEI VAC vacuum equipment
**Location Rule:** `product_cat IN ('vari-q-valves', 'e-vap', 're-vap', 'mak-sputter')`

### Group: `group_meivac_product_fields`

### Vari-Q Throttle Valve Specifications

| Field Name | Old Name | Type | Description | ACF Key |
|------------|----------|------|-------------|---------|
| `meivac_vari_q_flange` | `vari-q_flange` | Text | Flange type (ASA, ISO, CF, JIS) | `field_meivac_vari_q_flange` |
| `meivac_vari_q_outer_diameter` | `vari-q_o-d` | Number | Outer Diameter | `field_meivac_vari_q_outer_diameter` |
| `meivac_vari_q_inner_diameter` | `vari-q_i-d` | Number | Inner Diameter | `field_meivac_vari_q_inner_diameter` |
| `meivac_vari_q_material` | `vari-q_material` | Text | Flange material (Aluminum, Stainless Steel) | `field_meivac_vari_q_material` |
| `meivac_vari_q_coating` | `vari-q_coating` | Text | Flange coating (Clear Alodine, Hard Anodized) | `field_meivac_vari_q_coating` |
| `meivac_vari_q_actuation` | `vari-q_actuation` | Text | Actuation type (Pneumatically, Servomotor, On-valve controller) | `field_meivac_vari_q_actuation` |
| `meivac_units` | `units` | Select | Unit specification (Metric/Imperial) | `field_meivac_units` |

---

## Page/Content Fields (Shared)

**Location Rule:** `post_type == 'page'` OR `post_type == 'product'` (archive pages)

### Group: `group_page_banner_fields`

### Page Banners

| Field Name | Old Name | Type | Description | ACF Key |
|------------|----------|------|-------------|---------|
| `page_disable_banner` | `disable_page_banner` | True/False | Disable page banner | `field_page_disable_banner` |
| `page_banner_image` | `banner_image` | Image | Desktop banner image | `field_page_banner_image` |
| `page_banner_mobile_image` | `mobile_banner_image` | Image | Mobile banner image | `field_page_banner_mobile_image` |
| `page_banner_color` | `banner_color` | Color Picker | Banner background color | `field_page_banner_color` |
| `page_banner_text_color` | `text_color` | Color Picker | Banner text color | `field_page_banner_text_color` |
| `page_banner_text` | `banner_text` | WYSIWYG | Banner text content | `field_page_banner_text` |

### Flexible Content Rows

| Field Name | Old Name | Type | Description | ACF Key |
|------------|----------|------|-------------|---------|
| `page_content_rows` | `rows` | Repeater | Flexible content rows | `field_page_content_rows` |

**Repeater Subfields:**
- `content` (WYSIWYG) - Row content
- `background_color` (Color Picker) - Background color
- `background_class` (Text) - CSS class for background

### Product Category Fields

| Field Name | Old Name | Type | Description | ACF Key |
|------------|----------|------|-------------|---------|
| `category_dimension_file` | `dimFile` | Text | Dimension diagram filename | `field_category_dimension_file` |
| `category_standard_description` | `stdDesc` | WYSIWYG | Standard family description | `field_category_standard_description` |
| `category_extended_description` | `bigDesc` | WYSIWYG | Extended family description | `field_category_extended_description` |
| `category_image` | `category_image` | Image | Category listing image | `field_category_image` |

---

## Resource/Event/News Fields

**Location Rule:** `post_type IN ('resource', 'event', 'press')`

### Group: `group_resource_fields`

### Resources

| Field Name | Old Name | Type | Description | ACF Key |
|------------|----------|------|-------------|---------|
| `resource_url` | `resource_url` | URL | Resource download URL | `field_resource_url` |
| `resource_category` | `category` | Select | Resource type (whitepaper, case study, video, etc.) | `field_resource_category` |
| `resource_gated` | `gated` | True/False | Require form fill before download | `field_resource_gated` |
| `resource_image` | `event_image` | Image | Resource thumbnail image | `field_resource_image` |
| `resource_video_thumbnail` | `video_thumbnail` | Image | Video thumbnail preview | `field_resource_video_thumbnail` |

### Events

| Field Name | Old Name | Type | Description | ACF Key |
|------------|----------|------|-------------|---------|
| `event_start_date` | `start_date` | Date Picker | Event start date | `field_event_start_date` |
| `event_end_date` | `end_date` | Date Picker | Event end date | `field_event_end_date` |
| `event_promotional_url` | `promotional_url` | URL | Event website link | `field_event_promotional_url` |
| `event_registration_url` | `registration_url` | URL | Event registration link | `field_event_registration_url` |
| `event_image` | `event_image` | Image | Event image | `field_event_image` |

### Press/News

| Field Name | Old Name | Type | Description | ACF Key |
|------------|----------|------|-------------|---------|
| `news_publication_name` | `publication_name` | Text | Publication name | `field_news_publication_name` |
| `news_subhead` | `subhead` | Text | Article subheading | `field_news_subhead` |
| `news_url` | `news_url` | URL | External article URL | `field_news_url` |
| `news_publication_image` | `publication_image` | Image | Publication logo | `field_news_publication_image` |

---

## Implementation Notes

### ACF JSON Location

All field groups will be stored in: `/wp-content/plugins/ftc-product-ui/acf-json/`

### Field Group Structure

- `group_shared_product_fields.json` - Applied to ALL products
- `group_thermal_product_fields.json` - Thermal products only
- `group_seal_product_fields.json` - Vacuum feedthrough products only
- `group_ferrofluid_product_fields.json` - Ferrofluid products only
- `group_meivac_product_fields.json` - MEI VAC products only
- `group_page_banner_fields.json` - Page banners
- `group_page_content_rows.json` - Flexible content
- `group_resource_fields.json` - Resources/events/news

### Location Rules

Use ACF conditional logic to show field groups based on:
- **Product Category** - Show thermal fields only for thermal product categories
- **Site/Subsite** - Use multisite conditions if needed
- **Post Type** - Resources, events, pages

### Migration Priority

**Phase 1 (Week 2):** Thermal fields only
**Phase 2 (Week 3):** Seals, Ferrofluid, MEI VAC
**Phase 3 (Week 5):** Page fields, Resources

---

**Next Steps:**
1. Generate ACF JSON files for each field group
2. Create migration mapping (old field → new field)
3. Build WP-CLI migration scripts
4. Test on staging environment

**Last Updated:** 2025-11-19
