<?php
/**
 * Migration Engine Class
 *
 * Core migration logic for converting ACF repeater fields to Gutenberg blocks.
 * Handles single page migration, batch processing, and data conversion.
 *
 * @package ACF_Repeater_To_Blocks
 * @since 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class ACF_R2B_Migration_Engine {

    /**
     * Migrate a single page from repeater to blocks
     *
     * @param int $post_id The post ID to migrate
     * @param bool $dry_run If true, only preview without making changes
     * @return array Result with success/error information
     */
    public function migrate_page( $post_id, $dry_run = false ) {
        // Validate post
        $post = get_post( $post_id );
        if ( ! $post ) {
            return array(
                'success' => false,
                'error'   => __( 'Post not found.', 'acf-repeater-to-blocks' ),
            );
        }

        // Check if post has 'rows' repeater data
        if ( ! have_rows( 'rows', $post_id ) ) {
            return array(
                'success' => false,
                'error'   => __( 'No repeater data found for this post.', 'acf-repeater-to-blocks' ),
            );
        }

        // Get repeater rows
        $rows = $this->get_repeater_rows( $post_id );

        if ( empty( $rows ) ) {
            return array(
                'success' => false,
                'error'   => __( 'No repeater rows to migrate.', 'acf-repeater-to-blocks' ),
            );
        }

        if ( $dry_run ) {
            // Preview mode - don't make changes
            return array(
                'success'      => true,
                'dry_run'      => true,
                'rows_found'   => count( $rows ),
                'blocks'       => $this->convert_rows_to_blocks( $rows ),
                'post_id'      => $post_id,
                'post_title'   => $post->post_title,
            );
        }

        // Create backup before migration
        ACF_R2B_Migration_Logger::log_migration_start( $post_id );
        $backup_id = ACF_R2B_Backup_Manager::backup_post( $post_id );

        if ( ! $backup_id ) {
            ACF_R2B_Migration_Logger::log_migration_error(
                $post_id,
                __( 'Failed to create backup.', 'acf-repeater-to-blocks' )
            );
            return array(
                'success' => false,
                'error'   => __( 'Failed to create backup. Migration aborted.', 'acf-repeater-to-blocks' ),
            );
        }

        // Convert rows to Gutenberg blocks
        $blocks_html = $this->convert_rows_to_blocks( $rows );

        // Update post content
        $new_content = $post->post_content . "\n\n" . $blocks_html;

        $result = wp_update_post( array(
            'ID'           => $post_id,
            'post_content' => $new_content,
        ), true );

        if ( is_wp_error( $result ) ) {
            ACF_R2B_Migration_Logger::log_migration_error(
                $post_id,
                $result->get_error_message()
            );
            return array(
                'success' => false,
                'error'   => $result->get_error_message(),
            );
        }

        // Log success
        ACF_R2B_Migration_Logger::log_migration_success( $post_id, array(
            'rows_migrated' => count( $rows ),
        ) );

        return array(
            'success'       => true,
            'post_id'       => $post_id,
            'post_title'    => $post->post_title,
            'rows_migrated' => count( $rows ),
            'backup_id'     => $backup_id,
        );
    }

    /**
     * Get all repeater rows for a post
     *
     * @param int $post_id The post ID
     * @return array Array of repeater row data
     */
    private function get_repeater_rows( $post_id ) {
        $rows = array();

        if ( have_rows( 'rows', $post_id ) ) {
            while ( have_rows( 'rows', $post_id ) ) {
                the_row();

                $rows[] = array(
                    'content'           => get_sub_field( 'content' ),
                    'background_color'  => get_sub_field( 'background-color' ),
                    'background_class'  => get_sub_field( 'background-class' ),
                );
            }
        }

        return $rows;
    }

    /**
     * Convert repeater rows to Gutenberg block HTML
     *
     * @param array $rows Array of repeater row data
     * @return string Gutenberg blocks HTML
     */
    private function convert_rows_to_blocks( $rows ) {
        $blocks = array();

        foreach ( $rows as $row ) {
            $blocks[] = $this->convert_row_to_block( $row );
        }

        return implode( "\n\n", $blocks );
    }

    /**
     * Convert a single repeater row to Gutenberg block
     *
     * @param array $row The repeater row data
     * @return string The Gutenberg block HTML comment
     */
    private function convert_row_to_block( $row ) {
        // Extract data
        $content     = $row['content'] ?? '';
        $bg_class    = $row['background_class'] ?? '';
        $bg_color    = $row['background_color'] ?? '';

        // Create block attributes
        $block_id = 'block_' . wp_generate_uuid4();

        // Build the data array for the block
        $block_data = array(
            'content'           => $content,
            '_content'          => 'field_content_section_content',
            'background_class'  => $bg_class,
            '_background_class' => 'field_content_section_bg_class',
            'background_color'  => $bg_color,
            '_background_color' => 'field_content_section_bg_color',
        );

        $attrs = array(
            'id'    => $block_id,
            'name'  => 'acf/content-section',
            'data'  => $block_data,
            'mode'  => 'preview',
        );

        // Generate block comment in Gutenberg format
        $attrs_json = wp_json_encode( $attrs, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );

        return '<!-- wp:acf/content-section ' . $attrs_json . ' /-->';
    }

    /**
     * Batch migrate multiple pages
     *
     * @param array $post_ids Array of post IDs
     * @param int $batch_size Number of posts per batch (for progress tracking)
     * @return array Results for each post
     */
    public function batch_migrate( $post_ids, $batch_size = 10 ) {
        $results = array();
        $processed = 0;

        foreach ( $post_ids as $post_id ) {
            $results[ $post_id ] = $this->migrate_page( $post_id );
            $processed++;

            // Allow for progress tracking
            if ( $processed % $batch_size === 0 ) {
                // Could add hook here for AJAX progress updates
                do_action( 'acf_r2b_batch_progress', $processed, count( $post_ids ) );
            }
        }

        return $results;
    }

    /**
     * Get all pages with 'rows' repeater data
     *
     * @return array Array of post IDs
     */
    public static function get_pages_with_repeater() {
        global $wpdb;

        // Find all posts that have 'rows' meta key
        $post_ids = $wpdb->get_col(
            "SELECT DISTINCT post_id FROM {$wpdb->postmeta}
             WHERE meta_key = 'rows'
             ORDER BY post_id ASC"
        );

        return array_map( 'intval', $post_ids );
    }

    /**
     * Get pages with repeater data that haven't been migrated yet
     *
     * @return array Array of post IDs
     */
    public static function get_unmigrated_pages() {
        $all_pages = self::get_pages_with_repeater();
        $unmigrated = array();

        foreach ( $all_pages as $post_id ) {
            $status = ACF_R2B_Migration_Logger::get_latest_status( $post_id );
            if ( $status !== 'success' ) {
                $unmigrated[] = $post_id;
            }
        }

        return $unmigrated;
    }

    /**
     * Get count of pages with repeater data
     *
     * @return int Count of pages
     */
    public static function get_pages_count() {
        return count( self::get_pages_with_repeater() );
    }
}
