<?php
/**
 * Plugin Name: ACF Repeater to Blocks Migration
 * Plugin URI: https://ferrotec.com
 * Description: Migrates ACF repeater field data ('rows') to Gutenberg blocks (acf/content-section). Includes backup, rollback, and logging capabilities.
 * Version: 1.0.0
 * Author: AUC
 * Author URI: https://ferrotec.com
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: acf-repeater-to-blocks
 * Requires at least: 5.0
 * Requires PHP: 7.4
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Define plugin constants
define( 'ACF_R2B_VERSION', '1.0.0' );
define( 'ACF_R2B_DIR', plugin_dir_path( __FILE__ ) );
define( 'ACF_R2B_URL', plugin_dir_url( __FILE__ ) );
define( 'ACF_R2B_BASENAME', plugin_basename( __FILE__ ) );

/**
 * Check requirements before loading plugin
 */
function acf_r2b_check_requirements() {
    $errors = array();

    // Check if ACF is active
    if ( ! function_exists( 'acf_register_block_type' ) ) {
        $errors[] = __( 'Advanced Custom Fields PRO plugin is required.', 'acf-repeater-to-blocks' );
    }

    // Check PHP version
    if ( version_compare( PHP_VERSION, '7.4', '<' ) ) {
        $errors[] = sprintf(
            __( 'PHP version 7.4 or higher is required. You are running version %s.', 'acf-repeater-to-blocks' ),
            PHP_VERSION
        );
    }

    // Check WordPress version
    global $wp_version;
    if ( version_compare( $wp_version, '5.0', '<' ) ) {
        $errors[] = sprintf(
            __( 'WordPress version 5.0 or higher is required. You are running version %s.', 'acf-repeater-to-blocks' ),
            $wp_version
        );
    }

    return $errors;
}

/**
 * Display admin notice for missing requirements
 */
function acf_r2b_requirements_notice() {
    $errors = acf_r2b_check_requirements();

    if ( ! empty( $errors ) ) {
        ?>
        <div class="notice notice-error">
            <p><strong><?php esc_html_e( 'ACF Repeater to Blocks Migration', 'acf-repeater-to-blocks' ); ?></strong></p>
            <ul>
                <?php foreach ( $errors as $error ) : ?>
                    <li><?php echo esc_html( $error ); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php

        // Deactivate plugin
        deactivate_plugins( ACF_R2B_BASENAME );
    }
}
add_action( 'admin_notices', 'acf_r2b_requirements_notice' );

/**
 * Initialize plugin if requirements are met
 */
function acf_r2b_init() {
    $errors = acf_r2b_check_requirements();

    if ( ! empty( $errors ) ) {
        return; // Don't load if requirements not met
    }

    // Load dependencies
    require_once ACF_R2B_DIR . 'includes/class-backup-manager.php';
    require_once ACF_R2B_DIR . 'includes/class-migration-logger.php';
    require_once ACF_R2B_DIR . 'includes/class-migration-engine.php';

    // Load admin interface if in admin
    if ( is_admin() ) {
        require_once ACF_R2B_DIR . 'admin/class-admin-page.php';
        new ACF_R2B_Admin_Page();
    }
}
add_action( 'plugins_loaded', 'acf_r2b_init' );

/**
 * Activation hook - Create database tables
 */
function acf_r2b_activate() {
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();

    // Backup table
    $backup_table = $wpdb->prefix . 'acf_migration_backups';
    $backup_sql = "CREATE TABLE IF NOT EXISTS $backup_table (
        id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
        post_id BIGINT(20) UNSIGNED NOT NULL,
        post_content_backup LONGTEXT NOT NULL,
        postmeta_backup LONGTEXT NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        KEY post_id (post_id)
    ) $charset_collate;";

    // Log table
    $log_table = $wpdb->prefix . 'acf_migration_log';
    $log_sql = "CREATE TABLE IF NOT EXISTS $log_table (
        id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
        post_id BIGINT(20) UNSIGNED NOT NULL,
        status VARCHAR(20) NOT NULL,
        rows_migrated INT DEFAULT 0,
        message TEXT,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        KEY post_id (post_id),
        KEY status (status)
    ) $charset_collate;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $backup_sql );
    dbDelta( $log_sql );
}
register_activation_hook( __FILE__, 'acf_r2b_activate' );

/**
 * Deactivation hook - Cleanup (optional)
 */
function acf_r2b_deactivate() {
    // Tables are kept for safety - can be manually removed if needed
    // This prevents accidental data loss if plugin is temporarily deactivated
}
register_deactivation_hook( __FILE__, 'acf_r2b_deactivate' );
