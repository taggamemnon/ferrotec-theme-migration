<?php
/**
 * Migration Dashboard View
 *
 * Admin interface for the ACF Repeater to Blocks migration plugin.
 * Displays statistics, page lists, and migration controls.
 *
 * @package ACF_Repeater_To_Blocks
 * @since 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>

<div class="wrap">
    <h1><?php esc_html_e( 'ACF Repeater to Blocks Migration', 'acf-repeater-to-blocks' ); ?></h1>

    <?php
    // Display success/error messages
    if ( isset( $_GET['migrated'] ) ) {
        $count = intval( $_GET['migrated'] );
        ?>
        <div class="notice notice-success is-dismissible">
            <p>
                <?php
                printf(
                    _n(
                        '%d page successfully migrated to Gutenberg blocks!',
                        '%d pages successfully migrated to Gutenberg blocks!',
                        $count,
                        'acf-repeater-to-blocks'
                    ),
                    $count
                );
                ?>
            </p>
        </div>
        <?php
    }

    if ( isset( $_GET['errors'] ) ) {
        $count = intval( $_GET['errors'] );
        ?>
        <div class="notice notice-error is-dismissible">
            <p>
                <?php
                printf(
                    _n(
                        '%d page failed to migrate. Check the logs below for details.',
                        '%d pages failed to migrate. Check the logs below for details.',
                        $count,
                        'acf-repeater-to-blocks'
                    ),
                    $count
                );
                ?>
            </p>
        </div>
        <?php
    }

    if ( isset( $_GET['rolledback'] ) ) {
        ?>
        <div class="notice notice-success is-dismissible">
            <p><?php esc_html_e( 'Page successfully rolled back to backup.', 'acf-repeater-to-blocks' ); ?></p>
        </div>
        <?php
    }

    if ( isset( $_GET['error'] ) ) {
        $error = sanitize_text_field( $_GET['error'] );
        $message = '';

        switch ( $error ) {
            case 'no_posts':
                $message = __( 'Please select at least one page to migrate.', 'acf-repeater-to-blocks' );
                break;
            case 'no_post':
                $message = __( 'Invalid post ID.', 'acf-repeater-to-blocks' );
                break;
            case 'rollback_failed':
                $message = __( 'Rollback failed. No backup found for this post.', 'acf-repeater-to-blocks' );
                break;
            default:
                $message = __( 'An error occurred.', 'acf-repeater-to-blocks' );
        }
        ?>
        <div class="notice notice-error is-dismissible">
            <p><?php echo esc_html( $message ); ?></p>
        </div>
        <?php
    }
    ?>

    <div class="acf-r2b-stats">
        <div class="acf-r2b-stat-box">
            <h3><?php esc_html_e( 'Total Pages with Repeater', 'acf-repeater-to-blocks' ); ?></h3>
            <div class="stat-number"><?php echo count( $pages_with_repeater ); ?></div>
        </div>

        <div class="acf-r2b-stat-box">
            <h3><?php esc_html_e( 'Unmigrated Pages', 'acf-repeater-to-blocks' ); ?></h3>
            <div class="stat-number"><?php echo count( $unmigrated_pages ); ?></div>
        </div>

        <div class="acf-r2b-stat-box">
            <h3><?php esc_html_e( 'Successful Migrations', 'acf-repeater-to-blocks' ); ?></h3>
            <div class="stat-number acf-r2b-success"><?php echo $stats['successful']; ?></div>
        </div>

        <div class="acf-r2b-stat-box">
            <h3><?php esc_html_e( 'Errors', 'acf-repeater-to-blocks' ); ?></h3>
            <div class="stat-number acf-r2b-error"><?php echo $stats['errors']; ?></div>
        </div>

        <div class="acf-r2b-stat-box">
            <h3><?php esc_html_e( 'Backups Available', 'acf-repeater-to-blocks' ); ?></h3>
            <div class="stat-number"><?php echo $backup_count; ?></div>
        </div>
    </div>

    <?php if ( ! empty( $unmigrated_pages ) ) : ?>
        <div class="acf-r2b-page-list">
            <h2><?php esc_html_e( 'Pages Ready for Migration', 'acf-repeater-to-blocks' ); ?></h2>
            <p><?php esc_html_e( 'Select pages to migrate from ACF repeater fields to Gutenberg blocks:', 'acf-repeater-to-blocks' ); ?></p>

            <form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
                <?php wp_nonce_field( 'acf_r2b_migrate' ); ?>
                <input type="hidden" name="action" value="acf_r2b_migrate">

                <table class="wp-list-table widefat fixed striped">
                    <thead>
                        <tr>
                            <td class="manage-column column-cb check-column">
                                <input type="checkbox" id="select-all-pages">
                            </td>
                            <th><?php esc_html_e( 'Post Title', 'acf-repeater-to-blocks' ); ?></th>
                            <th><?php esc_html_e( 'Rows Count', 'acf-repeater-to-blocks' ); ?></th>
                            <th><?php esc_html_e( 'Status', 'acf-repeater-to-blocks' ); ?></th>
                            <th><?php esc_html_e( 'Actions', 'acf-repeater-to-blocks' ); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ( $unmigrated_pages as $post_id ) : ?>
                            <?php
                            $post = get_post( $post_id );
                            if ( ! $post ) {
                                continue;
                            }

                            $rows_count = get_post_meta( $post_id, 'rows', true );
                            $rows_count = is_numeric( $rows_count ) ? intval( $rows_count ) : 0;
                            $status = ACF_R2B_Migration_Logger::get_latest_status( $post_id );
                            $has_backup = ACF_R2B_Backup_Manager::has_backup( $post_id );

                            $status_class = '';
                            $status_text = __( 'Not Migrated', 'acf-repeater-to-blocks' );

                            if ( $status === 'error' ) {
                                $status_class = 'acf-r2b-error';
                                $status_text = __( 'Error', 'acf-repeater-to-blocks' );
                            } elseif ( $status === 'started' ) {
                                $status_class = 'acf-r2b-pending';
                                $status_text = __( 'In Progress', 'acf-repeater-to-blocks' );
                            }
                            ?>
                            <tr>
                                <th scope="row" class="check-column">
                                    <input type="checkbox" name="post_ids[]" value="<?php echo esc_attr( $post_id ); ?>" class="page-checkbox">
                                </th>
                                <td>
                                    <strong>
                                        <a href="<?php echo esc_url( get_edit_post_link( $post_id ) ); ?>" target="_blank">
                                            <?php echo esc_html( $post->post_title ); ?>
                                        </a>
                                    </strong>
                                    <br>
                                    <small><?php echo esc_html( get_permalink( $post_id ) ); ?></small>
                                </td>
                                <td><?php echo esc_html( $rows_count ); ?> rows</td>
                                <td>
                                    <span class="<?php echo esc_attr( $status_class ); ?>">
                                        <?php echo esc_html( $status_text ); ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="<?php echo esc_url( wp_nonce_url( admin_url( 'admin-post.php?action=acf_r2b_preview&post_id=' . $post_id ), 'acf_r2b_preview' ) ); ?>"
                                       class="button button-small"
                                       target="_blank">
                                        <?php esc_html_e( 'Preview', 'acf-repeater-to-blocks' ); ?>
                                    </a>

                                    <?php if ( $has_backup ) : ?>
                                        <form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" style="display: inline;">
                                            <?php wp_nonce_field( 'acf_r2b_rollback' ); ?>
                                            <input type="hidden" name="action" value="acf_r2b_rollback">
                                            <input type="hidden" name="post_id" value="<?php echo esc_attr( $post_id ); ?>">
                                            <button type="submit"
                                                    class="button button-small"
                                                    onclick="return confirm('<?php esc_attr_e( 'Are you sure you want to rollback this page? This will restore it to its pre-migration state.', 'acf-repeater-to-blocks' ); ?>');">
                                                <?php esc_html_e( 'Rollback', 'acf-repeater-to-blocks' ); ?>
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <p class="submit">
                    <button type="submit" class="button button-primary button-large">
                        <?php esc_html_e( 'Migrate Selected Pages', 'acf-repeater-to-blocks' ); ?>
                    </button>
                </p>
            </form>
        </div>
    <?php else : ?>
        <div class="notice notice-info">
            <p>
                <?php
                if ( empty( $pages_with_repeater ) ) {
                    esc_html_e( 'No pages with ACF repeater data found.', 'acf-repeater-to-blocks' );
                } else {
                    esc_html_e( 'All pages have been successfully migrated!', 'acf-repeater-to-blocks' );
                }
                ?>
            </p>
        </div>
    <?php endif; ?>

    <?php
    // Display recent migration logs
    $recent_logs = ACF_R2B_Migration_Logger::get_all_logs( array( 'limit' => 10 ) );
    if ( ! empty( $recent_logs ) ) :
    ?>
        <div class="acf-r2b-page-list" style="margin-top: 30px;">
            <h2><?php esc_html_e( 'Recent Migration Log', 'acf-repeater-to-blocks' ); ?></h2>

            <table class="wp-list-table widefat fixed striped">
                <thead>
                    <tr>
                        <th><?php esc_html_e( 'Date', 'acf-repeater-to-blocks' ); ?></th>
                        <th><?php esc_html_e( 'Post', 'acf-repeater-to-blocks' ); ?></th>
                        <th><?php esc_html_e( 'Status', 'acf-repeater-to-blocks' ); ?></th>
                        <th><?php esc_html_e( 'Rows Migrated', 'acf-repeater-to-blocks' ); ?></th>
                        <th><?php esc_html_e( 'Message', 'acf-repeater-to-blocks' ); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ( $recent_logs as $log ) : ?>
                        <?php
                        $post = get_post( $log->post_id );
                        $post_title = $post ? $post->post_title : __( 'Unknown Post', 'acf-repeater-to-blocks' );

                        $status_class = '';
                        switch ( $log->status ) {
                            case 'success':
                                $status_class = 'acf-r2b-success';
                                break;
                            case 'error':
                                $status_class = 'acf-r2b-error';
                                break;
                            case 'started':
                                $status_class = 'acf-r2b-pending';
                                break;
                        }
                        ?>
                        <tr>
                            <td><?php echo esc_html( $log->created_at ); ?></td>
                            <td>
                                <?php if ( $post ) : ?>
                                    <a href="<?php echo esc_url( get_edit_post_link( $log->post_id ) ); ?>" target="_blank">
                                        <?php echo esc_html( $post_title ); ?>
                                    </a>
                                <?php else : ?>
                                    <?php echo esc_html( $post_title ); ?>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="<?php echo esc_attr( $status_class ); ?>">
                                    <?php echo esc_html( ucfirst( $log->status ) ); ?>
                                </span>
                            </td>
                            <td><?php echo esc_html( $log->rows_migrated ); ?></td>
                            <td><?php echo esc_html( $log->message ); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

    <script>
        jQuery(document).ready(function($) {
            // Select all checkbox functionality
            $('#select-all-pages').on('change', function() {
                $('.page-checkbox').prop('checked', $(this).prop('checked'));
            });

            // Update select all when individual checkboxes change
            $('.page-checkbox').on('change', function() {
                var allChecked = $('.page-checkbox:checked').length === $('.page-checkbox').length;
                $('#select-all-pages').prop('checked', allChecked);
            });
        });
    </script>
</div>
