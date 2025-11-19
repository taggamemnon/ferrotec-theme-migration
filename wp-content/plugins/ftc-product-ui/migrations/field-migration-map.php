<?php
/**
 * ACF Field Migration Mapping
 *
 * Maps old field names to new unified schema field names
 *
 * @package FTC_Product_UI
 * @since 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Get field migration map
 *
 * Returns an array mapping old field names to new unified field names
 *
 * Structure:
 * 'old_field_name' => array(
 *     'new_name'     => 'new_field_name',
 *     'sites'        => array( 'thermal', 'seals', 'ferrofluid', 'meivac', 'corporate' ),
 *     'product_cats' => array( 'thermal-modules', 'vacuum-feedthrough', etc. ),
 *     'description'  => 'Field description',
 *     'transform'    => callable (optional) - function to transform data
 * )
 *
 * @return array
 */
function ftc_get_field_migration_map() {
	return array(

		// ===================================================================
		// SHARED PRODUCT FIELDS
		// ===================================================================

		// Product Identification - Multiple old names map to single new name
		'fullPN' => array(
			'new_name'     => 'product_model',
			'sites'        => array( 'thermal' ),
			'product_cats' => array( 'thermal-modules', 'peltier-coolers' ),
			'description'  => 'Product model/part number (Thermal)',
		),
		'model' => array(
			'new_name'     => 'product_model',
			'sites'        => array( 'ferrofluid' ),
			'product_cats' => array( 'ferrofluid' ),
			'description'  => 'Product model/part number (Ferrofluid)',
		),
		'pNum' => array(
			'new_name'     => 'product_model',
			'sites'        => array( 'seals' ),
			'product_cats' => array( 'vacuum-feedthrough', 'ferrofluidic-seals' ),
			'description'  => 'Product part number (Seals)',
		),

		// Alternative descriptions
		'altDescription' => array(
			'new_name'     => 'product_alt_description',
			'sites'        => array( 'thermal' ),
			'product_cats' => array( 'thermal-modules' ),
			'description'  => 'Alternative description for product listings',
		),

		// CAD Files - Consolidate various names
		'step_file' => array(
			'new_name'     => 'product_cad_file',
			'sites'        => array( 'meivac' ),
			'product_cats' => array( 'all' ),
			'description'  => 'STEP CAD file',
		),

		// Datasheets
		'pdf_filename' => array(
			'new_name'     => 'product_datasheet',
			'sites'        => array( 'thermal' ),
			'product_cats' => array( 'thermal-modules' ),
			'description'  => 'Product datasheet PDF',
		),

		// Performance Modeling
		'graph_flag' => array(
			'new_name'     => 'product_enable_modeling',
			'sites'        => array( 'thermal' ),
			'product_cats' => array( 'thermal-modules' ),
			'description'  => 'Enable performance modeling tab',
			'transform'    => 'ftc_transform_graph_flag',
		),

		// ===================================================================
		// THERMAL ELECTRIC FIELDS
		// ===================================================================

		// Performance Specifications
		'iMax' => array(
			'new_name'     => 'thermal_current_max',
			'sites'        => array( 'thermal' ),
			'product_cats' => array( 'thermal-modules', 'peltier-coolers' ),
			'description'  => 'Maximum Current (Amps)',
		),
		'vMax' => array(
			'new_name'     => 'thermal_voltage_max',
			'sites'        => array( 'thermal' ),
			'product_cats' => array( 'thermal-modules', 'peltier-coolers' ),
			'description'  => 'Maximum Voltage (Volts)',
		),
		'tMax' => array(
			'new_name'     => 'thermal_delta_t_max',
			'sites'        => array( 'thermal' ),
			'product_cats' => array( 'thermal-modules', 'peltier-coolers' ),
			'description'  => 'Maximum Temperature Difference (°C)',
		),
		'qcMax' => array(
			'new_name'     => 'thermal_cooling_capacity_max',
			'sites'        => array( 'thermal' ),
			'product_cats' => array( 'thermal-modules', 'peltier-coolers' ),
			'description'  => 'Maximum Cooling Capacity (Watts)',
		),
		'numCouples' => array(
			'new_name'     => 'thermal_couples_count',
			'sites'        => array( 'thermal' ),
			'product_cats' => array( 'thermal-modules' ),
			'description'  => 'Number of thermoelectric couples',
		),

		// Dimensions - Standard Modules
		'baseW' => array(
			'new_name'     => 'thermal_base_width',
			'sites'        => array( 'thermal' ),
			'product_cats' => array( 'thermal-modules' ),
			'description'  => 'Base Width (mm)',
		),
		'baseL' => array(
			'new_name'     => 'thermal_base_length',
			'sites'        => array( 'thermal' ),
			'product_cats' => array( 'thermal-modules' ),
			'description'  => 'Base Length (mm)',
		),
		'topW' => array(
			'new_name'     => 'thermal_top_width',
			'sites'        => array( 'thermal' ),
			'product_cats' => array( 'thermal-modules' ),
			'description'  => 'Top Width (mm)',
		),
		'topL' => array(
			'new_name'     => 'thermal_top_length',
			'sites'        => array( 'thermal' ),
			'product_cats' => array( 'thermal-modules' ),
			'description'  => 'Top Length (mm)',
		),
		'hDim' => array(
			'new_name'     => 'thermal_height',
			'sites'        => array( 'thermal' ),
			'product_cats' => array( 'thermal-modules' ),
			'description'  => 'Module Height/Thickness (mm)',
		),

		// Dimensions - Circular Modules
		'idDim' => array(
			'new_name'     => 'thermal_inner_diameter',
			'sites'        => array( 'thermal' ),
			'product_cats' => array( 'thermal-modules' ),
			'description'  => 'Inner Diameter (mm)',
		),
		'oDim' => array(
			'new_name'     => 'thermal_outer_diameter',
			'sites'        => array( 'thermal' ),
			'product_cats' => array( 'thermal-modules' ),
			'description'  => 'Outer Diameter (mm)',
		),

		// Dimensions - Alternative Format
		'w1Dim' => array(
			'new_name'     => 'thermal_w1_dimension',
			'sites'        => array( 'thermal' ),
			'product_cats' => array( 'thermal-modules' ),
			'description'  => 'W1 Dimension (mm)',
		),
		'l1Dim' => array(
			'new_name'     => 'thermal_l1_dimension',
			'sites'        => array( 'thermal' ),
			'product_cats' => array( 'thermal-modules' ),
			'description'  => 'L1 Dimension (mm)',
		),
		'w2Dim' => array(
			'new_name'     => 'thermal_w2_dimension',
			'sites'        => array( 'thermal' ),
			'product_cats' => array( 'thermal-modules' ),
			'description'  => 'W2 Dimension (mm)',
		),
		'l2Dim' => array(
			'new_name'     => 'thermal_l2_dimension',
			'sites'        => array( 'thermal' ),
			'product_cats' => array( 'thermal-modules' ),
			'description'  => 'L2 Dimension (mm)',
		),
		'w3Dim' => array(
			'new_name'     => 'thermal_w3_dimension',
			'sites'        => array( 'thermal' ),
			'product_cats' => array( 'thermal-modules' ),
			'description'  => 'W3 Dimension (mm)',
		),
		'l3Dim' => array(
			'new_name'     => 'thermal_l3_dimension',
			'sites'        => array( 'thermal' ),
			'product_cats' => array( 'thermal-modules' ),
			'description'  => 'L3 Dimension (mm)',
		),

		// Product Classification
		'substrateType' => array(
			'new_name'     => 'thermal_substrate_type',
			'sites'        => array( 'thermal' ),
			'product_cats' => array( 'thermal-modules' ),
			'description'  => 'Substrate type (M=metalized, B=bare)',
		),
		'fk_tefamilyinfoid' => array(
			'new_name'     => 'thermal_family_id',
			'sites'        => array( 'thermal' ),
			'product_cats' => array( 'thermal-modules' ),
			'description'  => 'TE product family ID',
		),

		// ===================================================================
		// VACUUM SEAL / FEEDTHROUGH FIELDS
		// ===================================================================

		// Product Identification
		'mNum' => array(
			'new_name'     => 'seal_model_number',
			'sites'        => array( 'seals', 'meivac' ),
			'product_cats' => array( 'vacuum-feedthrough', 'ferrofluidic-seals' ),
			'description'  => 'Feedthrough model number',
		),
		'familyTitle' => array(
			'new_name'     => 'seal_family_title',
			'sites'        => array( 'seals' ),
			'product_cats' => array( 'vacuum-feedthrough' ),
			'description'  => 'Product family title',
		),
		'unit' => array(
			'new_name'     => 'seal_unit_system',
			'sites'        => array( 'seals' ),
			'product_cats' => array( 'vacuum-feedthrough' ),
			'description'  => 'Unit system (0=mm, 1=in)',
		),

		// Product Classifications
		'fk_shaftID' => array(
			'new_name'     => 'seal_shaft_type',
			'sites'        => array( 'seals' ),
			'product_cats' => array( 'vacuum-feedthrough' ),
			'description'  => 'Shaft type (1=Solid, 2=Hollow)',
		),
		'fk_mountingID' => array(
			'new_name'     => 'seal_mount_type',
			'sites'        => array( 'seals' ),
			'product_cats' => array( 'vacuum-feedthrough' ),
			'description'  => 'Mounting type ID',
		),
		'fk_fluidID' => array(
			'new_name'     => 'seal_fluid_type',
			'sites'        => array( 'seals' ),
			'product_cats' => array( 'vacuum-feedthrough' ),
			'description'  => 'Ferrofluid type (1=Fluorocarbon, 2=Hydrocarbon)',
		),

		// Boolean Features - Shaft Support
		'b1' => array(
			'new_name'     => 'seal_support_simply',
			'sites'        => array( 'seals' ),
			'product_cats' => array( 'vacuum-feedthrough' ),
			'description'  => 'Simply Supported (vac+atm sides)',
		),
		'b2' => array(
			'new_name'     => 'seal_support_cantilevered',
			'sites'        => array( 'seals' ),
			'product_cats' => array( 'vacuum-feedthrough' ),
			'description'  => 'Cantilevered (both on atm side)',
		),
		'b3' => array(
			'new_name'     => 'seal_support_heavy_duty',
			'sites'        => array( 'seals' ),
			'product_cats' => array( 'vacuum-feedthrough' ),
			'description'  => 'Heavy Duty',
		),

		// Boolean Features - Product Features
		'f1' => array(
			'new_name'     => 'seal_feature_sleeve',
			'sites'        => array( 'seals' ),
			'product_cats' => array( 'vacuum-feedthrough' ),
			'description'  => 'Sleeve feature',
		),
		'f2' => array(
			'new_name'     => 'seal_feature_water_cooled',
			'sites'        => array( 'seals' ),
			'product_cats' => array( 'vacuum-feedthrough' ),
			'description'  => 'Water-cooled',
		),
		'f3' => array(
			'new_name'     => 'seal_feature_shaft_clamp',
			'sites'        => array( 'seals' ),
			'product_cats' => array( 'vacuum-feedthrough' ),
			'description'  => 'Shaft Clamp',
		),
		'f4' => array(
			'new_name'     => 'seal_feature_electrical_isolation',
			'sites'        => array( 'seals' ),
			'product_cats' => array( 'vacuum-feedthrough' ),
			'description'  => 'Electrical Isolation (Sleeved Bore)',
		),
		'f5' => array(
			'new_name'     => 'seal_feature_union_services',
			'sites'        => array( 'seals' ),
			'product_cats' => array( 'vacuum-feedthrough' ),
			'description'  => 'Union Services',
		),
		'mntOpt' => array(
			'new_name'     => 'seal_mounting_kit_included',
			'sites'        => array( 'seals' ),
			'product_cats' => array( 'vacuum-feedthrough' ),
			'description'  => 'Mounting Nut and Washer Included',
		),
		'nS' => array(
			'new_name'     => 'seal_normally_in_stock',
			'sites'        => array( 'seals' ),
			'product_cats' => array( 'vacuum-feedthrough' ),
			'description'  => 'Normally in Stock',
		),

		// Dimensions (d1-d45) - Sample, add all 45
		'd45' => array(
			'new_name'     => 'seal_shaft_diameter',
			'sites'        => array( 'seals' ),
			'product_cats' => array( 'vacuum-feedthrough' ),
			'description'  => 'Shaft/bore diameter',
		),
		'd2' => array(
			'new_name'     => 'seal_shaft_diameter_tolerance',
			'sites'        => array( 'seals' ),
			'product_cats' => array( 'vacuum-feedthrough' ),
			'description'  => 'Diameter tolerance',
		),
		// ... (add remaining d3-d43)

		// ===================================================================
		// FERROFLUID FIELDS
		// ===================================================================

		// Product Identification
		'fk_seriesID' => array(
			'new_name'     => 'ferrofluid_series_id',
			'sites'        => array( 'ferrofluid' ),
			'product_cats' => array( 'ferrofluid' ),
			'description'  => 'Series ID',
		),
		'seriesType' => array(
			'new_name'     => 'ferrofluid_series_type',
			'sites'        => array( 'ferrofluid' ),
			'product_cats' => array( 'ferrofluid' ),
			'description'  => 'Series type description',
		),

		// Physical Description
		'description' => array(
			'new_name'     => 'ferrofluid_appearance',
			'sites'        => array( 'ferrofluid' ),
			'product_cats' => array( 'ferrofluid' ),
			'description'  => 'Visual appearance/description',
		),
		'liquidType' => array(
			'new_name'     => 'ferrofluid_liquid_type',
			'sites'        => array( 'ferrofluid' ),
			'product_cats' => array( 'ferrofluid' ),
			'description'  => 'Carrier liquid type',
		),
		'surf_type' => array(
			'new_name'     => 'ferrofluid_surfactant_type',
			'sites'        => array( 'ferrofluid' ),
			'product_cats' => array( 'ferrofluid' ),
			'description'  => 'Type of surfactant',
		),
		'surf_nature' => array(
			'new_name'     => 'ferrofluid_surfactant_nature',
			'sites'        => array( 'ferrofluid' ),
			'product_cats' => array( 'ferrofluid' ),
			'description'  => 'Nature of surfactant',
		),

		// Magnetic Properties (fix typo)
		'sat_guass' => array(
			'new_name'     => 'ferrofluid_saturation_gauss',
			'sites'        => array( 'ferrofluid' ),
			'product_cats' => array( 'ferrofluid' ),
			'description'  => 'Saturation Magnetization (Gauss) - TYPO FIX',
		),
		'sat_mt' => array(
			'new_name'     => 'ferrofluid_saturation_mt',
			'sites'        => array( 'ferrofluid' ),
			'product_cats' => array( 'ferrofluid' ),
			'description'  => 'Saturation Magnetization (mT)',
		),
		'sat_emuG' => array(
			'new_name'     => 'ferrofluid_saturation_emug',
			'sites'        => array( 'ferrofluid' ),
			'product_cats' => array( 'ferrofluid' ),
			'description'  => 'Saturation Magnetization (emu/g)',
		),

		// Physical Properties
		'vis_cp' => array(
			'new_name'     => 'ferrofluid_viscosity_cp',
			'sites'        => array( 'ferrofluid' ),
			'product_cats' => array( 'ferrofluid' ),
			'description'  => 'Viscosity @27°C (cP)',
		),
		'sat_mpa_s' => array(
			'new_name'     => 'ferrofluid_viscosity_mpa',
			'sites'        => array( 'ferrofluid' ),
			'product_cats' => array( 'ferrofluid' ),
			'description'  => 'Viscosity @27°C (mPa·s)',
		),
		'den_g_ml' => array(
			'new_name'     => 'ferrofluid_density_gml',
			'sites'        => array( 'ferrofluid' ),
			'product_cats' => array( 'ferrofluid' ),
			'description'  => 'Density @25°C (g/cc)',
		),
		'nominal_diam_nm' => array(
			'new_name'     => 'ferrofluid_particle_diameter',
			'sites'        => array( 'ferrofluid' ),
			'product_cats' => array( 'ferrofluid' ),
			'description'  => 'Nominal Particle Diameter (nm)',
		),

		// ===================================================================
		// MEI VAC FIELDS
		// ===================================================================

		// Vari-Q Specifications
		'vari-q_flange' => array(
			'new_name'     => 'meivac_vari_q_flange',
			'sites'        => array( 'meivac' ),
			'product_cats' => array( 'vari-q-valves' ),
			'description'  => 'Flange type (ASA, ISO, CF, JIS)',
		),
		'vari-q_o-d' => array(
			'new_name'     => 'meivac_vari_q_outer_diameter',
			'sites'        => array( 'meivac' ),
			'product_cats' => array( 'vari-q-valves' ),
			'description'  => 'Outer Diameter',
		),
		'vari-q_i-d' => array(
			'new_name'     => 'meivac_vari_q_inner_diameter',
			'sites'        => array( 'meivac' ),
			'product_cats' => array( 'vari-q-valves' ),
			'description'  => 'Inner Diameter',
		),
		'vari-q_material' => array(
			'new_name'     => 'meivac_vari_q_material',
			'sites'        => array( 'meivac' ),
			'product_cats' => array( 'vari-q-valves' ),
			'description'  => 'Flange material',
		),
		'vari-q_coating' => array(
			'new_name'     => 'meivac_vari_q_coating',
			'sites'        => array( 'meivac' ),
			'product_cats' => array( 'vari-q-valves' ),
			'description'  => 'Flange coating',
		),
		'vari-q_actuation' => array(
			'new_name'     => 'meivac_vari_q_actuation',
			'sites'        => array( 'meivac' ),
			'product_cats' => array( 'vari-q-valves' ),
			'description'  => 'Actuation type',
		),

		// ===================================================================
		// PAGE / CONTENT FIELDS
		// ===================================================================

		// Page Banners
		'disable_page_banner' => array(
			'new_name'     => 'page_disable_banner',
			'sites'        => array( 'all' ),
			'product_cats' => array(),
			'description'  => 'Disable page banner',
		),
		'banner_image' => array(
			'new_name'     => 'page_banner_image',
			'sites'        => array( 'all' ),
			'product_cats' => array(),
			'description'  => 'Desktop banner image',
		),
		'mobile_banner_image' => array(
			'new_name'     => 'page_banner_mobile_image',
			'sites'        => array( 'all' ),
			'product_cats' => array(),
			'description'  => 'Mobile banner image',
		),
		'banner_color' => array(
			'new_name'     => 'page_banner_color',
			'sites'        => array( 'all' ),
			'product_cats' => array(),
			'description'  => 'Banner background color',
		),
		'text_color' => array(
			'new_name'     => 'page_banner_text_color',
			'sites'        => array( 'all' ),
			'product_cats' => array(),
			'description'  => 'Banner text color',
		),
		'banner_text' => array(
			'new_name'     => 'page_banner_text',
			'sites'        => array( 'all' ),
			'product_cats' => array(),
			'description'  => 'Banner text content',
		),

		// Flexible Content
		'rows' => array(
			'new_name'     => 'page_content_rows',
			'sites'        => array( 'all' ),
			'product_cats' => array(),
			'description'  => 'Flexible content rows',
		),

		// Product Category Fields
		'dimFile' => array(
			'new_name'     => 'category_dimension_file',
			'sites'        => array( 'thermal' ),
			'product_cats' => array(),
			'description'  => 'Dimension diagram filename (category field)',
		),
		'stdDesc' => array(
			'new_name'     => 'category_standard_description',
			'sites'        => array( 'thermal' ),
			'product_cats' => array(),
			'description'  => 'Standard family description (category field)',
		),
		'bigDesc' => array(
			'new_name'     => 'category_extended_description',
			'sites'        => array( 'thermal' ),
			'product_cats' => array(),
			'description'  => 'Extended family description (category field)',
		),
		'category_image' => array(
			'new_name'     => 'category_image',
			'sites'        => array( 'meivac' ),
			'product_cats' => array(),
			'description'  => 'Category listing image',
		),

		// ===================================================================
		// RESOURCE / EVENT / NEWS FIELDS
		// ===================================================================

		'resource_url' => array(
			'new_name'     => 'resource_url',
			'sites'        => array( 'all' ),
			'product_cats' => array(),
			'description'  => 'Resource download URL (no change)',
		),
		'start_date' => array(
			'new_name'     => 'event_start_date',
			'sites'        => array( 'all' ),
			'product_cats' => array(),
			'description'  => 'Event start date',
		),
		'end_date' => array(
			'new_name'     => 'event_end_date',
			'sites'        => array( 'all' ),
			'product_cats' => array(),
			'description'  => 'Event end date',
		),
		'promotional_url' => array(
			'new_name'     => 'event_promotional_url',
			'sites'        => array( 'all' ),
			'product_cats' => array(),
			'description'  => 'Event website link',
		),
		'registration_url' => array(
			'new_name'     => 'event_registration_url',
			'sites'        => array( 'all' ),
			'product_cats' => array(),
			'description'  => 'Event registration link',
		),
		'event_image' => array(
			'new_name'     => 'event_image',
			'sites'        => array( 'all' ),
			'product_cats' => array(),
			'description'  => 'Event/resource image (no change)',
		),
		'publication_name' => array(
			'new_name'     => 'news_publication_name',
			'sites'        => array( 'all' ),
			'product_cats' => array(),
			'description'  => 'Publication name',
		),
		'subhead' => array(
			'new_name'     => 'news_subhead',
			'sites'        => array( 'all' ),
			'product_cats' => array(),
			'description'  => 'Article subheading',
		),
		'news_url' => array(
			'new_name'     => 'news_url',
			'sites'        => array( 'all' ),
			'product_cats' => array(),
			'description'  => 'External article URL (no change)',
		),
		'publication_image' => array(
			'new_name'     => 'news_publication_image',
			'sites'        => array( 'all' ),
			'product_cats' => array(),
			'description'  => 'Publication logo',
		),
	);
}

/**
 * Transform function for graph_flag
 *
 * Converts various values to boolean
 *
 * @param mixed $value The old value.
 * @return bool
 */
function ftc_transform_graph_flag( $value ) {
	// Convert to boolean
	return in_array( $value, array( '1', 1, 'true', 'yes', true ), true );
}

/**
 * Get reverse migration map (new field name => old field name)
 *
 * Useful for rollback scenarios
 *
 * @return array
 */
function ftc_get_reverse_migration_map() {
	$forward_map = ftc_get_field_migration_map();
	$reverse_map = array();

	foreach ( $forward_map as $old_name => $data ) {
		$new_name = $data['new_name'];

		// Handle multiple old names mapping to one new name
		if ( ! isset( $reverse_map[ $new_name ] ) ) {
			$reverse_map[ $new_name ] = array();
		}

		$reverse_map[ $new_name ][] = $old_name;
	}

	return $reverse_map;
}
