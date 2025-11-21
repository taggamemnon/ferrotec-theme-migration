<?php
/**
 * Backup Manager Class
 *
 * Handles creating and restoring backups of post content and metadata
 * before migration. Enables safe rollback if needed.
 *
 * @package ACF_Repeater_To_Blocks
 * @since 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class ACF_R2B_Backup_Manager {

    /**
     * Create a backup of a post before migration
     *
     * @param int $post_id The post ID to backup
     * @return int|false Backup ID on success, false on failure
     */
    public static function backup_post( $post_id ) {
        global $wpdb;

        $post = get_post( $post_id );
        if ( ! $post ) {
            return false;
        }

        // Get all postmeta for this post
        $postmeta = get_post_meta( $post_id );

        // Filter to only rows-related meta
        $rows_meta = array();
        foreach ( $postmeta as $key => $value ) {
            if ( strpos( $key, 'rows' ) === 0 || $key === '_rows' ) {
                $rows_meta[ $key ] = $value;
            }
        }

        // Prepare backup data
        $backup_table = $wpdb->prefix . 'acf_migration_backups';
        $data = array(
            'post_id'               => $post_id,
            'post_content_backup'   => $post->post_content,
            'postmeta_backup'       => wp_json_encode( $rows_meta ),
            'created_at'            => current_time( 'mysql' ),
        );

        // Check if backup already exists
        $existing = $wpdb->get_var( $wpdb->prepare(
            "SELECT id FROM $backup_table WHERE post_id = %d ORDER BY created_at DESC LIMIT 1",
            $post_id
        ) );

        if ( $existing ) {
            // Update existing backup
            $result = $wpdb->update(
                $backup_table,
                $data,
                array( 'id' => $existing ),
                array( '%d', '%s', '%s', '%s' ),
                array( '%d' )
            );
            return $result !== false ? $existing : false;
        } else {
            // Insert new backup
            $result = $wpdb->insert(
                $backup_table,
                $data,
                array( '%d', '%s', '%s', '%s' )
            );
            return $result ? $wpdb->insert_id : false;
        }
    }

    /**
     * Restore a post from backup
     *
     * @param int $post_id The post ID to restore
     * @return bool True on success, false on failure
     */
    public static function restore_post( $post_id ) {
        global $wpdb;

        $backup_table = $wpdb->prefix . 'acf_migration_backups';

        // Get the latest backup
        $backup = $wpdb->get_row( $wpdb->prepare(
            "SELECT * FROM $backup_table WHERE post_id = %d ORDER BY created_at DESC LIMIT 1",
            $post_id
        ) );

        if ( ! $backup ) {
            return false;
        }

        // Restore post content
        $result = wp_update_post( array(
            'ID'           => $post_id,
            'post_content' => $backup->post_content_backup,
        ), true );

        if ( is_wp_error( $result ) ) {
            return false;
        }

        // Restore postmeta
        $postmeta = json_decode( $backup->postmeta_backup, true );
        if ( $postmeta && is_array( $postmeta ) ) {
            foreach ( $postmeta as $key => $values ) {
                // Delete existing meta
                delete_post_meta( $post_id, $key );

                // Restore meta (handle arrays)
                if ( is_array( $values ) ) {
                    foreach ( $values as $value ) {
                        add_post_meta( $post_id, $key, maybe_unserialize( $value ) );
                    }
                } else {
                    add_post_meta( $post_id, $key, maybe_unserialize( $values ) );
                }
            }
        }

        return true;
    }

    /**
     * Delete backup for a post
     *
     * @param int $post_id The post ID
     * @return bool True on success, false on failure
     */
    public static function delete_backup( $post_id ) {
        global $wpdb;

        $backup_table = $wpdb->prefix . 'acf_migration_backups';

        $result = $wpdb->delete(
            $backup_table,
            array( 'post_id' => $post_id ),
            array( '%d' )
        );

        return $result !== false;
    }

    /**
     * Get backup information for a post
     *
     * @param int $post_id The post ID
     * @return object|null Backup data or null if not found
     */
    public static function get_backup_info( $post_id ) {
        global $wpdb;

        $backup_table = $wpdb->prefix . 'acf_migration_backups';

        return $wpdb->get_row( $wpdb->prepare(
            "SELECT * FROM $backup_table WHERE post_id = %d ORDER BY created_at DESC LIMIT 1",
            $post_id
        ) );
    }

    /**
     * Check if a post has a backup
     *
     * @param int $post_id The post ID
     * @return bool True if backup exists, false otherwise
     */
    public static function has_backup( $post_id ) {
        return self::get_backup_info( $post_id ) !== null;
    }

    /**
     * Get all backups (for admin display)
     *
     * @return array Array of backup objects
     */
    public static function get_all_backups() {
        global $wpdb;

        $backup_table = $wpdb->prefix . 'acf_migration_backups';

        return $wpdb->get_results(
            "SELECT * FROM $backup_table ORDER BY created_at DESC"
        );
    }

    /**
     * Get backup count
     *
     * @return int Number of backups
     */
    public static function get_backup_count() {
        global $wpdb;

        $backup_table = $wpdb->prefix . 'acf_migration_backups';

        return (int) $wpdb->get_var( "SELECT COUNT(*) FROM $backup_table" );
    }
}
