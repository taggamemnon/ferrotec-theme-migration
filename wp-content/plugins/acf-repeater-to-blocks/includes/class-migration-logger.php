<?php
/**
 * Migration Logger Class
 *
 * Logs all migration operations for tracking and debugging.
 * Tracks success, failures, and detailed information about each migration.
 *
 * @package ACF_Repeater_To_Blocks
 * @since 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class ACF_R2B_Migration_Logger {

    /**
     * Log migration start
     *
     * @param int $post_id The post ID
     * @return int|false Log ID on success, false on failure
     */
    public static function log_migration_start( $post_id ) {
        global $wpdb;

        $log_table = $wpdb->prefix . 'acf_migration_log';

        $result = $wpdb->insert(
            $log_table,
            array(
                'post_id'        => $post_id,
                'status'         => 'started',
                'rows_migrated'  => 0,
                'message'        => 'Migration started',
                'created_at'     => current_time( 'mysql' ),
            ),
            array( '%d', '%s', '%d', '%s', '%s' )
        );

        return $result ? $wpdb->insert_id : false;
    }

    /**
     * Log successful migration
     *
     * @param int $post_id The post ID
     * @param array $data Additional data (rows_migrated, etc.)
     * @return int|false Log ID on success, false on failure
     */
    public static function log_migration_success( $post_id, $data = array() ) {
        global $wpdb;

        $log_table = $wpdb->prefix . 'acf_migration_log';

        $rows_migrated = isset( $data['rows_migrated'] ) ? (int) $data['rows_migrated'] : 0;
        $message = isset( $data['message'] ) ? $data['message'] : sprintf(
            'Successfully migrated %d rows to Gutenberg blocks',
            $rows_migrated
        );

        $result = $wpdb->insert(
            $log_table,
            array(
                'post_id'        => $post_id,
                'status'         => 'success',
                'rows_migrated'  => $rows_migrated,
                'message'        => $message,
                'created_at'     => current_time( 'mysql' ),
            ),
            array( '%d', '%s', '%d', '%s', '%s' )
        );

        return $result ? $wpdb->insert_id : false;
    }

    /**
     * Log migration error
     *
     * @param int $post_id The post ID
     * @param string $error Error message
     * @return int|false Log ID on success, false on failure
     */
    public static function log_migration_error( $post_id, $error ) {
        global $wpdb;

        $log_table = $wpdb->prefix . 'acf_migration_log';

        $result = $wpdb->insert(
            $log_table,
            array(
                'post_id'        => $post_id,
                'status'         => 'error',
                'rows_migrated'  => 0,
                'message'        => $error,
                'created_at'     => current_time( 'mysql' ),
            ),
            array( '%d', '%s', '%d', '%s', '%s' )
        );

        return $result ? $wpdb->insert_id : false;
    }

    /**
     * Get migration log for a specific post
     *
     * @param int $post_id The post ID
     * @return array Array of log entries
     */
    public static function get_migration_log( $post_id ) {
        global $wpdb;

        $log_table = $wpdb->prefix . 'acf_migration_log';

        return $wpdb->get_results( $wpdb->prepare(
            "SELECT * FROM $log_table WHERE post_id = %d ORDER BY created_at DESC",
            $post_id
        ) );
    }

    /**
     * Get all migration logs
     *
     * @param array $args Optional arguments (status, limit, offset)
     * @return array Array of log entries
     */
    public static function get_all_logs( $args = array() ) {
        global $wpdb;

        $log_table = $wpdb->prefix . 'acf_migration_log';

        $defaults = array(
            'status' => '',
            'limit'  => 100,
            'offset' => 0,
        );

        $args = wp_parse_args( $args, $defaults );

        $where = '';
        if ( ! empty( $args['status'] ) ) {
            $where = $wpdb->prepare( "WHERE status = %s", $args['status'] );
        }

        $sql = "SELECT * FROM $log_table $where ORDER BY created_at DESC LIMIT %d OFFSET %d";

        return $wpdb->get_results( $wpdb->prepare(
            $sql,
            $args['limit'],
            $args['offset']
        ) );
    }

    /**
     * Get migration statistics
     *
     * @return array Statistics array
     */
    public static function get_statistics() {
        global $wpdb;

        $log_table = $wpdb->prefix . 'acf_migration_log';

        $total = $wpdb->get_var( "SELECT COUNT(DISTINCT post_id) FROM $log_table" );
        $success = $wpdb->get_var( "SELECT COUNT(DISTINCT post_id) FROM $log_table WHERE status = 'success'" );
        $errors = $wpdb->get_var( "SELECT COUNT(DISTINCT post_id) FROM $log_table WHERE status = 'error'" );
        $total_rows = $wpdb->get_var( "SELECT SUM(rows_migrated) FROM $log_table WHERE status = 'success'" );

        return array(
            'total_migrations' => (int) $total,
            'successful'       => (int) $success,
            'errors'           => (int) $errors,
            'total_rows'       => (int) $total_rows,
        );
    }

    /**
     * Get latest migration status for a post
     *
     * @param int $post_id The post ID
     * @return string|null Status or null if not found
     */
    public static function get_latest_status( $post_id ) {
        global $wpdb;

        $log_table = $wpdb->prefix . 'acf_migration_log';

        return $wpdb->get_var( $wpdb->prepare(
            "SELECT status FROM $log_table WHERE post_id = %d ORDER BY created_at DESC LIMIT 1",
            $post_id
        ) );
    }

    /**
     * Export logs as CSV
     *
     * @return string CSV content
     */
    public static function export_log_csv() {
        $logs = self::get_all_logs( array( 'limit' => 999999 ) );

        $csv = "ID,Post ID,Post Title,Status,Rows Migrated,Message,Date\n";

        foreach ( $logs as $log ) {
            $post = get_post( $log->post_id );
            $title = $post ? $post->post_title : 'Unknown';

            $csv .= sprintf(
                "%d,%d,\"%s\",%s,%d,\"%s\",%s\n",
                $log->id,
                $log->post_id,
                str_replace( '"', '""', $title ),
                $log->status,
                $log->rows_migrated,
                str_replace( '"', '""', $log->message ),
                $log->created_at
            );
        }

        return $csv;
    }

    /**
     * Clear old logs (older than specified days)
     *
     * @param int $days Number of days to keep
     * @return int Number of logs deleted
     */
    public static function clear_old_logs( $days = 30 ) {
        global $wpdb;

        $log_table = $wpdb->prefix . 'acf_migration_log';

        $result = $wpdb->query( $wpdb->prepare(
            "DELETE FROM $log_table WHERE created_at < DATE_SUB(NOW(), INTERVAL %d DAY)",
            $days
        ) );

        return $result !== false ? $result : 0;
    }
}
