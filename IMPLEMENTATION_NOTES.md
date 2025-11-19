# Implementation Notes - ACF vs WooCommerce Attributes

**Date:** 2025-11-19
**Topic:** Product Data Architecture Decision
**Priority:** CRITICAL - Review before implementing product tabs

---

## 🎯 Key Decision: ACF Fields vs WooCommerce Attributes

### Summary

**DO NOT DUPLICATE DATA** between ACF and WooCommerce attributes. Use each for its specific purpose.

### Architecture Rules

#### ✅ Use ACF Custom Fields For:

**Technical specifications that need to:**
- Generate graphs/charts (thermal performance data)
- Perform calculations
- Store as proper data types (numbers, not text)
- Be used in complex templates
- Display with units and precision

**Examples:**
```php
// ACF Fields (plugin/acf-json/) - SINGLE SOURCE OF TRUTH
thermal_current_max              => 3.5 (number)
thermal_voltage_max              => 15.4 (number)
thermal_delta_t_max              => 67 (number)
thermal_cooling_capacity_max     => 50 (number)
thermal_base_width               => 40 (number)
thermal_base_length              => 40 (number)
thermal_height                   => 3.4 (number)

// Used for:
✓ Displaying in specs table
✓ Generating Chart.js graphs (modeling tab)
✓ Calculations in modeling tab
✓ Print view
✓ Technical documentation
```

#### ✅ Use WooCommerce Attributes For:

**Product characteristics that need to:**
- Filter/search on shop pages
- Create product variations
- Enable layered navigation (WooCommerce widgets)
- Be user-facing selectable options
- Group products by family/type

**Examples:**
```php
// WooCommerce Attributes - USER-FACING FILTERING
pa_shaft_type       => "Solid" or "Hollow"
pa_mounting         => "Cartridge", "Flange", "Nose", "Nut"
pa_fluid            => "Hydrocarbon" or "Fluorocarbon"
pa_substrate        => "Metalized" or "Bare"
pa_product_family   => "9500 Series", "Multicascade", "Hi-Temperature"
pa_environment      => "Standard", "Reactive Gas", "High Temperature"

// Used for:
✓ Shop page filtering (layered nav)
✓ Product search/filtering
✓ Product family grouping
✓ Archive page organization
```

---

## 📊 Decision Matrix

| Data Type | Store As | Display From | Use Case | Example |
|-----------|----------|--------------|----------|---------|
| **Numeric specs** | ACF Fields (number) | ACF | Calculations, graphs, precise display | `thermal_current_max = 3.5` |
| **Dimensions** | ACF Fields (number) | ACF | Technical specs, calculations | `thermal_base_width = 40` |
| **Performance data** | ACF Repeater | ACF | Chart.js graphs, modeling | `thermal_performance_data[]` |
| **Product family** | WooCommerce Attribute | Attribute | Shop filtering, navigation | `pa_product_family = "9500 Series"` |
| **Shaft type** | WooCommerce Attribute | Attribute | Shop filtering, search | `pa_shaft_type = "Solid"` |
| **Mounting type** | WooCommerce Attribute | Attribute | Shop filtering, variations | `pa_mounting = "Cartridge"` |
| **Material** | WooCommerce Attribute | Attribute | Shop filtering | `pa_material = "Aluminum"` |

---

## ⚠️ AVOID Data Duplication

### ❌ DON'T DO THIS:
```php
// BAD: Storing same data in both places
ACF Field:     thermal_current_max = 3.5
WC Attribute:  pa_imax = "3.5 A"  // ❌ DUPLICATE!

// This creates:
- Maintenance burden (update in 2 places)
- Data inconsistency risk
- Confusion about source of truth
```

### ✅ DO THIS:
```php
// GOOD: Single source of truth for each data type
ACF Field:     thermal_current_max = 3.5  // For specs, calculations, graphs
WC Attribute:  pa_product_family = "9500 Series"  // For filtering only

// Benefits:
- Single update point
- Clear data ownership
- No inconsistency
```

---

## 🛠️ Implementation Guide

### Specs Tab Template Structure

**File:** `wp-content/plugins/ftc-product-ui/templates/tabs/specs.php`

```php
<?php
/**
 * Specifications Tab
 *
 * Displays:
 * 1. Technical specs from ACF (primary)
 * 2. Product characteristics from WooCommerce attributes (secondary)
 */

global $product;

// Detect product type
$is_thermal = has_term( array( 'thermal-modules', 'peltier-coolers' ), 'product_cat', $product->get_id() );
$is_seal = has_term( array( 'vacuum-feedthrough', 'ferrofluidic-seals' ), 'product_cat', $product->get_id() );
?>

<div class="ftc-specs-tab">

    <?php if ( $is_thermal ) : ?>
        <!-- Section 1: Technical Performance (from ACF) -->
        <h3>Electrical & Thermal Performance</h3>
        <table class="ftc-specs-table">
            <tbody>
                <?php if ( $imax = get_field( 'thermal_current_max' ) ) : ?>
                <tr>
                    <th>Maximum Current (Imax)</th>
                    <td><?php echo esc_html( $imax ); ?> A</td>
                </tr>
                <?php endif; ?>

                <?php if ( $vmax = get_field( 'thermal_voltage_max' ) ) : ?>
                <tr>
                    <th>Maximum Voltage (Vmax)</th>
                    <td><?php echo esc_html( $vmax ); ?> V</td>
                </tr>
                <?php endif; ?>

                <?php if ( $tmax = get_field( 'thermal_delta_t_max' ) ) : ?>
                <tr>
                    <th>Maximum Temperature Difference (ΔTmax)</th>
                    <td><?php echo esc_html( $tmax ); ?> °C</td>
                </tr>
                <?php endif; ?>

                <?php if ( $qcmax = get_field( 'thermal_cooling_capacity_max' ) ) : ?>
                <tr>
                    <th>Maximum Cooling Capacity (Qcmax)</th>
                    <td><?php echo esc_html( $qcmax ); ?> W</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Section 2: Dimensions (from ACF) -->
        <h3>Dimensions</h3>
        <table class="ftc-specs-table">
            <tbody>
                <?php if ( $base_w = get_field( 'thermal_base_width' ) ) : ?>
                <tr>
                    <th>Base Width</th>
                    <td><?php echo esc_html( $base_w ); ?> mm</td>
                </tr>
                <?php endif; ?>

                <?php if ( $base_l = get_field( 'thermal_base_length' ) ) : ?>
                <tr>
                    <th>Base Length</th>
                    <td><?php echo esc_html( $base_l ); ?> mm</td>
                </tr>
                <?php endif; ?>

                <?php if ( $height = get_field( 'thermal_height' ) ) : ?>
                <tr>
                    <th>Height</th>
                    <td><?php echo esc_html( $height ); ?> mm</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <!-- Section 3: Product Characteristics (from WooCommerce Attributes) -->
    <?php
    $attributes = $product->get_attributes();
    if ( ! empty( $attributes ) ) :
    ?>
        <h3>Product Characteristics</h3>
        <table class="ftc-specs-table">
            <tbody>
                <?php foreach ( $attributes as $attribute ) : ?>
                    <?php if ( ! $attribute->get_visible() ) continue; ?>
                    <tr>
                        <th><?php echo wc_attribute_label( $attribute->get_name() ); ?></th>
                        <td><?php echo $product->get_attribute( $attribute->get_name() ); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

</div>
```

### Modeling Tab - Chart.js from ACF Data

**File:** `wp-content/plugins/ftc-product-ui/templates/tabs/modeling.php`

```php
<?php
/**
 * Modeling Tab (Thermal products only)
 *
 * Uses ACF repeater field 'thermal_performance_data' for Chart.js graphs
 */

// Get performance data from ACF repeater
$performance_data = get_field( 'thermal_performance_data' );

if ( $performance_data ) :
?>
    <div class="ftc-modeling-tab">
        <h3>Performance Curves</h3>

        <div class="ftc-chart-container">
            <canvas id="thermal-performance-chart"></canvas>
        </div>

        <script>
        // Chart.js initialization using ACF data
        const chartData = {
            labels: [<?php echo esc_js( $performance_data[0]['x_values'] ?? '' ); ?>],
            datasets: [
                <?php foreach ( $performance_data as $dataset ) : ?>
                {
                    label: '<?php echo esc_js( $dataset['dataset_label'] ); ?>',
                    data: [<?php echo esc_js( $dataset['y_values'] ); ?>],
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.1
                },
                <?php endforeach; ?>
            ]
        };

        // Initialize chart
        new Chart(
            document.getElementById('thermal-performance-chart'),
            {
                type: 'line',
                data: chartData,
                options: { /* chart options */ }
            }
        );
        </script>
    </div>
<?php
endif;
```

---

## 🔍 Dev Site Inspection Checklist

### When Inspecting Existing Products Tomorrow:

#### 1. Check ACF Fields (via WordPress Admin)
- [ ] Go to Custom Fields → Field Groups
- [ ] Identify which fields are currently used for specs
- [ ] Note field names (old naming convention)
- [ ] Check field types (text vs number vs repeater)
- [ ] Look for graph/chart data fields
- [ ] Document any calculated fields

#### 2. Check WooCommerce Attributes (via Products)
- [ ] Edit a thermal product
- [ ] Check "Attributes" tab
- [ ] Note which attributes exist (pa_*)
- [ ] Check if used for variations
- [ ] Check if "Visible on product page" is checked
- [ ] Test filtering on shop page

#### 3. Check for Data Duplication
- [ ] Compare ACF field values to attribute values
- [ ] Look for same data in both places
- [ ] Document any duplicates found
- [ ] Plan to remove duplicates during migration

#### 4. Check Old Theme Templates
- [ ] Review `old-themes/child-thermalelectric/woocommerce/content-single-product.php`
- [ ] See how specs are currently displayed
- [ ] Note which data source is used (ACF vs attributes)
- [ ] Check for any calculations or graph generation
- [ ] Document template structure

#### 5. Document Current State
Create a quick inventory:
```
Product: [Product Name]
Site: thermal.ferrotec.com

ACF Fields Found:
- iMax: [value] (used for: specs table, graph)
- vMax: [value] (used for: specs table, graph)
- tMax: [value] (used for: specs table)
- baseW: [value] (used for: specs table)

WooCommerce Attributes Found:
- pa_product_family: [value] (used for: filtering)
- pa_substrate: [value] (used for: filtering)

Duplicates Found:
- [none] or [list any]

Current Template Logic:
- [notes on how data is displayed]
```

---

## 📝 Migration Notes

### Field Migration Priority

**Week 2 (Thermal Baseline):**
1. Create ACF field groups for thermal specs (plugin)
2. Migrate numeric specs: iMax → thermal_current_max
3. Keep existing WooCommerce attributes (don't migrate)
4. Build specs tab template (ACF primary, attributes secondary)
5. Build modeling tab template (ACF repeater for graphs)

**What NOT to Migrate:**
- Don't create new WooCommerce attributes for ACF fields
- Don't migrate WooCommerce attributes to ACF
- Keep them separate as per architecture decision

---

## 🎯 Key Takeaways for Tomorrow

1. **Inspect before building** - Check what currently exists
2. **No duplication** - Data lives in ONE place only
3. **ACF = Technical data** - Numbers, calculations, graphs
4. **Attributes = User-facing** - Filtering, navigation, grouping
5. **Templates use both** - ACF for specs, attributes for characteristics

---

## 📚 Reference Documents

- `ACF_FIELD_MAPPING.md` - Complete catalog of old ACF fields
- `ACF_UNIFIED_SCHEMA.md` - New standardized field schema
- `EXECUTION_PLAN_JAN2026.md` - Week-by-week timeline
- `migrations/field-migration-map.php` - Field name mappings

---

**Last Updated:** 2025-11-19
**Next Review:** 2025-11-20 (before starting tab implementation)
