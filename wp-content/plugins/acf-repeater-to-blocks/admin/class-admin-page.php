<?php
/**
 * Admin Page Class
 *
 * Creates the admin interface for the migration plugin.
 * Provides UI for selecting pages, previewing, migrating, and rolling back.
 *
 * @package ACF_Repeater_To_Blocks
 * @since 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class ACF_R2B_Admin_Page {

    /**
     * Constructor
     */
    public function __construct() {
        add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );
        add_action( 'admin_post_acf_r2b_migrate', array( $this, 'handle_migrate' ) );
        add_action( 'admin_post_acf_r2b_rollback', array( $this, 'handle_rollback' ) );
        add_action( 'admin_post_acf_r2b_preview', array( $this, 'handle_preview' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
    }

    /**
     * Add admin menu page
     */
    public function add_admin_menu() {
        add_management_page(
            __( 'Repeater to Blocks Migration', 'acf-repeater-to-blocks' ),
            __( 'ACF Migration', 'acf-repeater-to-blocks' ),
            'manage_options',
            'acf-repeater-to-blocks',
            array( $this, 'render_admin_page' )
        );
    }

    /**
     * Enqueue admin scripts and styles
     */
    public function enqueue_scripts( $hook ) {
        if ( 'tools_page_acf-repeater-to-blocks' !== $hook ) {
            return;
        }

        // Add inline CSS for better UI
        wp_add_inline_style( 'wp-admin', '
            .acf-r2b-stats { display: flex; gap: 20px; margin: 20px 0; }
            .acf-r2b-stat-box { background: #fff; padding: 20px; border-left: 4px solid #2271b1; flex: 1; }
            .acf-r2b-stat-box h3 { margin: 0 0 10px 0; color: #50575e; font-size: 14px; }
            .acf-r2b-stat-box .stat-number { font-size: 32px; font-weight: 600; color: #2271b1; }
            .acf-r2b-page-list { background: #fff; padding: 20px; margin: 20px 0; }
            .acf-r2b-page-item { padding: 10px; border-bottom: 1px solid #ddd; display: flex; align-items: center; }
            .acf-r2b-page-item:hover { background: #f6f7f7; }
            .acf-r2b-success { color: #00a32a; }
            .acf-r2b-error { color: #d63638; }
            .acf-r2b-pending { color: #dba617; }
        ' );
    }

    /**
     * Render the admin page
     */
    public function render_admin_page() {
        // Check permissions
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( __( 'You do not have sufficient permissions to access this page.', 'acf-repeater-to-blocks' ) );
        }

        // Get data
        $pages_with_repeater = ACF_R2B_Migration_Engine::get_pages_with_repeater();
        $unmigrated_pages = ACF_R2B_Migration_Engine::get_unmigrated_pages();
        $stats = ACF_R2B_Migration_Logger::get_statistics();
        $backup_count = ACF_R2B_Backup_Manager::get_backup_count();

        // Include the view
        include ACF_R2B_DIR . 'admin/views/migration-dashboard.php';
    }

    /**
     * Handle migration request
     */
    public function handle_migrate() {
        check_admin_referer( 'acf_r2b_migrate' );

        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( __( 'You do not have sufficient permissions.', 'acf-repeater-to-blocks' ) );
        }

        $post_ids = isset( $_POST['post_ids'] ) ? array_map( 'intval', (array) $_POST['post_ids'] ) : array();

        if ( empty( $post_ids ) ) {
            wp_redirect( add_query_arg( 'error', 'no_posts', admin_url( 'tools.php?page=acf-repeater-to-blocks' ) ) );
            exit;
        }

        $engine = new ACF_R2B_Migration_Engine();
        $results = $engine->batch_migrate( $post_ids );

        $success_count = 0;
        $error_count = 0;

        foreach ( $results as $result ) {
            if ( $result['success'] ) {
                $success_count++;
            } else {
                $error_count++;
            }
        }

        $redirect_args = array(
            'page'    => 'acf-repeater-to-blocks',
            'migrated' => $success_count,
        );

        if ( $error_count > 0 ) {
            $redirect_args['errors'] = $error_count;
        }

        wp_redirect( add_query_arg( $redirect_args, admin_url( 'tools.php' ) ) );
        exit;
    }

    /**
     * Handle rollback request
     */
    public function handle_rollback() {
        check_admin_referer( 'acf_r2b_rollback' );

        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( __( 'You do not have sufficient permissions.', 'acf-repeater-to-blocks' ) );
        }

        $post_id = isset( $_POST['post_id'] ) ? intval( $_POST['post_id'] ) : 0;

        if ( ! $post_id ) {
            wp_redirect( add_query_arg( 'error', 'no_post', admin_url( 'tools.php?page=acf-repeater-to-blocks' ) ) );
            exit;
        }

        $result = ACF_R2B_Backup_Manager::restore_post( $post_id );

        if ( $result ) {
            ACF_R2B_Migration_Logger::log_migration_error( $post_id, 'Rolled back to backup' );
            wp_redirect( add_query_arg( array( 'page' => 'acf-repeater-to-blocks', 'rolledback' => 1 ), admin_url( 'tools.php' ) ) );
        } else {
            wp_redirect( add_query_arg( array( 'page' => 'acf-repeater-to-blocks', 'error' => 'rollback_failed' ), admin_url( 'tools.php' ) ) );
        }

        exit;
    }

    /**
     * Handle preview request
     */
    public function handle_preview() {
        check_admin_referer( 'acf_r2b_preview' );

        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( __( 'You do not have sufficient permissions.', 'acf-repeater-to-blocks' ) );
        }

        $post_id = isset( $_GET['post_id'] ) ? intval( $_GET['post_id'] ) : 0;

        if ( ! $post_id ) {
            wp_die( __( 'Invalid post ID.', 'acf-repeater-to-blocks' ) );
        }

        $engine = new ACF_R2B_Migration_Engine();
        $preview = $engine->migrate_page( $post_id, true );

        // Display preview
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title><?php esc_html_e( 'Migration Preview', 'acf-repeater-to-blocks' ); ?></title>
            <style>
                body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; padding: 20px; }
                pre { background: #f0f0f0; padding: 15px; overflow-x: auto; }
                .info { background: #e7f3ff; padding: 15px; margin: 20px 0; border-left: 4px solid #2271b1; }
            </style>
        </head>
        <body>
            <h1><?php esc_html_e( 'Migration Preview', 'acf-repeater-to-blocks' ); ?></h1>

            <?php if ( $preview['success'] ) : ?>
                <div class="info">
                    <p><strong><?php esc_html_e( 'Post:', 'acf-repeater-to-blocks' ); ?></strong> <?php echo esc_html( $preview['post_title'] ); ?></p>
                    <p><strong><?php esc_html_e( 'Rows Found:', 'acf-repeater-to-blocks' ); ?></strong> <?php echo esc_html( $preview['rows_found'] ); ?></p>
                </div>

                <h2><?php esc_html_e( 'Generated Blocks:', 'acf-repeater-to-blocks' ); ?></h2>
                <pre><?php echo esc_html( $preview['blocks'] ); ?></pre>
            <?php else : ?>
                <div class="info" style="background: #ffebe9; border-color: #d63638;">
                    <p><strong><?php esc_html_e( 'Error:', 'acf-repeater-to-blocks' ); ?></strong> <?php echo esc_html( $preview['error'] ); ?></p>
                </div>
            <?php endif; ?>

            <p><a href="<?php echo esc_url( admin_url( 'tools.php?page=acf-repeater-to-blocks' ) ); ?>">&larr; <?php esc_html_e( 'Back to Migration Dashboard', 'acf-repeater-to-blocks' ); ?></a></p>
        </body>
        </html>
        <?php
        exit;
    }
}
