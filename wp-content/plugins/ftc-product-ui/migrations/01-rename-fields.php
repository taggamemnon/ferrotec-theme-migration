<?php
/**
 * ACF Field Rename Migration Script
 *
 * Migrates old field names to new unified schema field names
 *
 * Usage:
 * - Single site: wp ftc migrate-fields
 * - Multisite (all sites): wp ftc migrate-fields --network
 * - Multisite (specific site): wp ftc migrate-fields --url=thermal.ferrotec.com
 * - Dry run: wp ftc migrate-fields --dry-run
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
 * Migrate ACF field names
 *
 * @param array $args Command arguments.
 * @param array $assoc_args Command flags.
 */
function ftc_migrate_fields( $args, $assoc_args ) {
	global $wpdb;

	$dry_run = isset( $assoc_args['dry-run'] );
	$network = isset( $assoc_args['network'] );
	$verbose = isset( $assoc_args['verbose'] );

	if ( $dry_run ) {
		WP_CLI::warning( 'DRY RUN MODE - No changes will be made to database' );
	}

	// Get migration map
	$migration_map = ftc_get_field_migration_map();

	WP_CLI::log( sprintf( 'Found %d field mappings to process', count( $migration_map ) ) );

	// Initialize counters
	$stats = array(
		'total_fields'    => count( $migration_map ),
		'fields_migrated' => 0,
		'records_updated' => 0,
		'errors'          => 0,
		'skipped'         => 0,
	);

	// Start transaction
	if ( ! $dry_run ) {
		$wpdb->query( 'START TRANSACTION' );
	}

	// Process each field mapping
	foreach ( $migration_map as $old_name => $data ) {
		$new_name = $data['new_name'];

		if ( $verbose ) {
			WP_CLI::log( sprintf( 'Processing: %s → %s', $old_name, $new_name ) );
		}

		// Check if old field exists
		$old_count = $wpdb->get_var( $wpdb->prepare(
			"SELECT COUNT(*) FROM {$wpdb->postmeta}
			 WHERE meta_key = %s",
			$old_name
		) );

		if ( $old_count == 0 ) {
			if ( $verbose ) {
				WP_CLI::log( sprintf( '  No records found for %s, skipping', $old_name ) );
			}
			$stats['skipped']++;
			continue;
		}

		// Check if new field already exists (potential conflict)
		$new_count = $wpdb->get_var( $wpdb->prepare(
			"SELECT COUNT(*) FROM {$wpdb->postmeta}
			 WHERE meta_key = %s",
			$new_name
		) );

		if ( $new_count > 0 ) {
			WP_CLI::warning( sprintf(
				'Field %s already exists (%d records). Skipping %s → %s migration.',
				$new_name,
				$new_count,
				$old_name,
				$new_name
			) );
			$stats['skipped']++;
			continue;
		}

		// Perform migration
		if ( ! $dry_run ) {
			// Apply transform function if specified
			if ( isset( $data['transform'] ) && is_callable( $data['transform'] ) ) {
				// Get all records
				$records = $wpdb->get_results( $wpdb->prepare(
					"SELECT meta_id, meta_value FROM {$wpdb->postmeta}
					 WHERE meta_key = %s",
					$old_name
				) );

				// Transform and update each record
				foreach ( $records as $record ) {
					$transformed_value = call_user_func( $data['transform'], $record->meta_value );

					$wpdb->update(
						$wpdb->postmeta,
						array(
							'meta_key'   => $new_name,
							'meta_value' => $transformed_value,
						),
						array( 'meta_id' => $record->meta_id ),
						array( '%s', '%s' ),
						array( '%d' )
					);
				}

				$updated = count( $records );
			} else {
				// Simple rename without transformation
				$updated = $wpdb->query( $wpdb->prepare(
					"UPDATE {$wpdb->postmeta}
					 SET meta_key = %s
					 WHERE meta_key = %s",
					$new_name,
					$old_name
				) );
			}

			if ( $updated === false ) {
				WP_CLI::error( sprintf( 'Failed to migrate %s → %s', $old_name, $new_name ), false );
				$stats['errors']++;
			} else {
				WP_CLI::success( sprintf( 'Migrated %d records: %s → %s', $updated, $old_name, $new_name ) );
				$stats['fields_migrated']++;
				$stats['records_updated'] += $updated;
			}
		} else {
			// Dry run - just report what would happen
			WP_CLI::log( sprintf( 'Would migrate %d records: %s → %s', $old_count, $old_name, $new_name ) );
			$stats['fields_migrated']++;
			$stats['records_updated'] += $old_count;
		}
	}

	// Commit or rollback
	if ( ! $dry_run ) {
		if ( $stats['errors'] > 0 ) {
			$wpdb->query( 'ROLLBACK' );
			WP_CLI::error( sprintf( 'Migration failed with %d errors. Database rolled back.', $stats['errors'] ) );
		} else {
			$wpdb->query( 'COMMIT' );
			WP_CLI::success( 'Migration committed successfully!' );
		}
	}

	// Display stats
	WP_CLI::log( '' );
	WP_CLI::log( '========================================' );
	WP_CLI::log( 'Migration Statistics:' );
	WP_CLI::log( '========================================' );
	WP_CLI::log( sprintf( 'Total fields in map:  %d', $stats['total_fields'] ) );
	WP_CLI::log( sprintf( 'Fields migrated:      %d', $stats['fields_migrated'] ) );
	WP_CLI::log( sprintf( 'Records updated:      %d', $stats['records_updated'] ) );
	WP_CLI::log( sprintf( 'Fields skipped:       %d', $stats['skipped'] ) );
	WP_CLI::log( sprintf( 'Errors:               %d', $stats['errors'] ) );
	WP_CLI::log( '========================================' );

	if ( $dry_run ) {
		WP_CLI::warning( 'This was a DRY RUN. No changes were made. Run without --dry-run to execute.' );
	}
}

/**
 * Register WP-CLI command
 */
if ( defined( 'WP_CLI' ) && WP_CLI ) {
	WP_CLI::add_command( 'ftc migrate-fields', 'ftc_migrate_fields', array(
		'shortdesc' => 'Migrate old ACF field names to new unified schema',
		'synopsis'  => array(
			array(
				'type'        => 'flag',
				'name'        => 'dry-run',
				'description' => 'Run without making changes (preview mode)',
				'optional'    => true,
			),
			array(
				'type'        => 'flag',
				'name'        => 'verbose',
				'description' => 'Show detailed output',
				'optional'    => true,
			),
			array(
				'type'        => 'flag',
				'name'        => 'network',
				'description' => 'Run on all sites in network (multisite only)',
				'optional'    => true,
			),
		),
	) );
}
