<?php
/**
 * ACF Field Migration Validation Script
 *
 * Validates that field migration completed successfully
 *
 * Usage:
 * - Single site: wp ftc validate-migration
 * - Multisite (specific site): wp ftc validate-migration --url=thermal.ferrotec.com
 * - Export report: wp ftc validate-migration --format=csv > migration-report.csv
 *
 * @package FTC_Product_UI
 * @since 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Load migration map
require_once dirname( __FILE__ ) . '/field-migration-map.php';

/**
 * Validate ACF field migration
 *
 * @param array $args Command arguments.
 * @param array $assoc_args Command flags.
 */
function ftc_validate_migration( $args, $assoc_args ) {
	global $wpdb;

	$format = isset( $assoc_args['format'] ) ? $assoc_args['format'] : 'table';
	$verbose = isset( $assoc_args['verbose'] );

	// Get migration map
	$migration_map = ftc_get_field_migration_map();

	WP_CLI::log( '========================================' );
	WP_CLI::log( 'ACF Field Migration Validation Report' );
	WP_CLI::log( '========================================' );
	WP_CLI::log( sprintf( 'Site: %s', get_site_url() ) );
	WP_CLI::log( sprintf( 'Date: %s', date( 'Y-m-d H:i:s' ) ) );
	WP_CLI::log( '' );

	$validation_results = array();
	$total_issues = 0;
	$total_success = 0;

	// Check each field mapping
	foreach ( $migration_map as $old_name => $data ) {
		$new_name = $data['new_name'];

		// Count old field occurrences (should be 0 after migration)
		$old_count = $wpdb->get_var( $wpdb->prepare(
			"SELECT COUNT(*) FROM {$wpdb->postmeta}
			 WHERE meta_key = %s",
			$old_name
		) );

		// Count new field occurrences
		$new_count = $wpdb->get_var( $wpdb->prepare(
			"SELECT COUNT(*) FROM {$wpdb->postmeta}
			 WHERE meta_key = %s",
			$new_name
		) );

		// Determine status
		$status = 'Unknown';
		$issue = false;

		if ( $old_count == 0 && $new_count == 0 ) {
			$status = 'Not Used';
		} elseif ( $old_count == 0 && $new_count > 0 ) {
			$status = 'Success';
			$total_success++;
		} elseif ( $old_count > 0 && $new_count == 0 ) {
			$status = 'Not Migrated';
			$issue = true;
			$total_issues++;
		} elseif ( $old_count > 0 && $new_count > 0 ) {
			$status = 'Partial Migration';
			$issue = true;
			$total_issues++;
		}

		$validation_results[] = array(
			'old_field'  => $old_name,
			'new_field'  => $new_name,
			'old_count'  => $old_count,
			'new_count'  => $new_count,
			'status'     => $status,
			'site'       => $data['sites'][0] ?? 'all',
			'categories' => implode( ', ', $data['product_cats'] ),
		);

		if ( $verbose || $issue ) {
			$color = $issue ? '%R' : '%G';
			WP_CLI::log( WP_CLI::colorize( sprintf(
				'%s%s → %s: %s (old: %d, new: %d)%%n',
				$color,
				$old_name,
				$new_name,
				$status,
				$old_count,
				$new_count
			) ) );
		}
	}

	// Display results based on format
	if ( $format === 'table' ) {
		WP_CLI::log( '' );
		WP_CLI::log( '========================================' );
		WP_CLI::log( 'Detailed Results:' );
		WP_CLI::log( '========================================' );
		WP_CLI\Utils\format_items( 'table', $validation_results, array(
			'old_field',
			'new_field',
			'old_count',
			'new_count',
			'status',
		) );
	} elseif ( $format === 'csv' ) {
		WP_CLI\Utils\format_items( 'csv', $validation_results, array(
			'old_field',
			'new_field',
			'old_count',
			'new_count',
			'status',
			'site',
			'categories',
		) );
	} elseif ( $format === 'json' ) {
		WP_CLI::log( json_encode( $validation_results, JSON_PRETTY_PRINT ) );
	}

	// Check for orphaned old fields (fields not in migration map)
	WP_CLI::log( '' );
	WP_CLI::log( '========================================' );
	WP_CLI::log( 'Checking for orphaned old fields...' );
	WP_CLI::log( '========================================' );

	$old_field_names = array_keys( $migration_map );
	$old_field_names_sql = "'" . implode( "','", array_map( 'esc_sql', $old_field_names ) ) . "'";

	$orphaned_fields = $wpdb->get_results(
		"SELECT DISTINCT meta_key, COUNT(*) as count
		 FROM {$wpdb->postmeta}
		 WHERE meta_key IN ( {$old_field_names_sql} )
		 GROUP BY meta_key
		 HAVING count > 0"
	);

	if ( empty( $orphaned_fields ) ) {
		WP_CLI::success( 'No orphaned old fields found.' );
	} else {
		WP_CLI::warning( sprintf( 'Found %d orphaned old fields:', count( $orphaned_fields ) ) );
		foreach ( $orphaned_fields as $field ) {
			WP_CLI::log( sprintf( '  - %s (%d records)', $field->meta_key, $field->count ) );
			$total_issues++;
		}
	}

	// Check for data integrity (sample random products)
	WP_CLI::log( '' );
	WP_CLI::log( '========================================' );
	WP_CLI::log( 'Data Integrity Check (Sample):' );
	WP_CLI::log( '========================================' );

	$sample_products = $wpdb->get_col(
		"SELECT ID FROM {$wpdb->posts}
		 WHERE post_type = 'product'
		 AND post_status = 'publish'
		 ORDER BY RAND()
		 LIMIT 5"
	);

	foreach ( $sample_products as $product_id ) {
		$product = wc_get_product( $product_id );
		if ( ! $product ) {
			continue;
		}

		WP_CLI::log( sprintf( 'Product #%d: %s', $product_id, $product->get_name() ) );

		// Check for new fields
		$new_field_count = 0;
		foreach ( $migration_map as $old_name => $data ) {
			$value = get_field( $data['new_name'], $product_id );
			if ( ! empty( $value ) ) {
				$new_field_count++;
			}
		}

		WP_CLI::log( sprintf( '  Found %d migrated fields', $new_field_count ) );
	}

	// Final summary
	WP_CLI::log( '' );
	WP_CLI::log( '========================================' );
	WP_CLI::log( 'Validation Summary:' );
	WP_CLI::log( '========================================' );
	WP_CLI::log( sprintf( 'Total field mappings:     %d', count( $migration_map ) ) );
	WP_CLI::log( sprintf( 'Successfully migrated:    %d', $total_success ) );
	WP_CLI::log( sprintf( 'Issues found:             %d', $total_issues ) );

	if ( $total_issues == 0 ) {
		WP_CLI::success( 'Migration validation passed! All fields migrated successfully.' );
	} else {
		WP_CLI::warning( sprintf( 'Migration validation found %d issues. Review the report above.', $total_issues ) );
	}
}

/**
 * Get field statistics
 *
 * @param array $args Command arguments.
 * @param array $assoc_args Command flags.
 */
function ftc_field_statistics( $args, $assoc_args ) {
	global $wpdb;

	WP_CLI::log( '========================================' );
	WP_CLI::log( 'ACF Field Usage Statistics' );
	WP_CLI::log( '========================================' );
	WP_CLI::log( sprintf( 'Site: %s', get_site_url() ) );
	WP_CLI::log( '' );

	// Get all ACF fields (old and new)
	$all_fields = $wpdb->get_results(
		"SELECT meta_key, COUNT(*) as count, COUNT(DISTINCT post_id) as products
		 FROM {$wpdb->postmeta}
		 WHERE meta_key LIKE '%\_%'
		 AND meta_key NOT LIKE '\_%'
		 GROUP BY meta_key
		 ORDER BY count DESC"
	);

	// Categorize fields
	$thermal_fields = array();
	$seal_fields = array();
	$ferrofluid_fields = array();
	$meivac_fields = array();
	$shared_fields = array();
	$other_fields = array();

	foreach ( $all_fields as $field ) {
		$key = $field->meta_key;

		if ( strpos( $key, 'thermal_' ) === 0 ) {
			$thermal_fields[] = $field;
		} elseif ( strpos( $key, 'seal_' ) === 0 ) {
			$seal_fields[] = $field;
		} elseif ( strpos( $key, 'ferrofluid_' ) === 0 ) {
			$ferrofluid_fields[] = $field;
		} elseif ( strpos( $key, 'meivac_' ) === 0 ) {
			$meivac_fields[] = $field;
		} elseif ( strpos( $key, 'product_' ) === 0 || strpos( $key, 'page_' ) === 0 ) {
			$shared_fields[] = $field;
		} else {
			$other_fields[] = $field;
		}
	}

	// Display statistics
	WP_CLI::log( sprintf( 'Thermal fields:     %d', count( $thermal_fields ) ) );
	WP_CLI::log( sprintf( 'Seal fields:        %d', count( $seal_fields ) ) );
	WP_CLI::log( sprintf( 'Ferrofluid fields:  %d', count( $ferrofluid_fields ) ) );
	WP_CLI::log( sprintf( 'MEI VAC fields:     %d', count( $meivac_fields ) ) );
	WP_CLI::log( sprintf( 'Shared fields:      %d', count( $shared_fields ) ) );
	WP_CLI::log( sprintf( 'Other fields:       %d', count( $other_fields ) ) );
	WP_CLI::log( sprintf( 'Total fields:       %d', count( $all_fields ) ) );
}

/**
 * Register WP-CLI commands
 */
if ( defined( 'WP_CLI' ) && WP_CLI ) {
	WP_CLI::add_command( 'ftc validate-migration', 'ftc_validate_migration', array(
		'shortdesc' => 'Validate ACF field migration',
		'synopsis'  => array(
			array(
				'type'        => 'flag',
				'name'        => 'verbose',
				'description' => 'Show detailed output',
				'optional'    => true,
			),
			array(
				'type'        => 'assoc',
				'name'        => 'format',
				'description' => 'Output format (table, csv, json)',
				'optional'    => true,
				'default'     => 'table',
			),
		),
	) );

	WP_CLI::add_command( 'ftc field-stats', 'ftc_field_statistics', array(
		'shortdesc' => 'Show ACF field usage statistics',
	) );
}
