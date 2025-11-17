<?php
/**
 * The sidebar containing the main widget area
 *
 * @package Layers2025
 * @since 1.0.0
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
    return;
}
?>

<aside id="secondary" class="widget-area col-md-4">
    <?php dynamic_sidebar( 'sidebar-1' ); ?>
</aside><!-- #secondary -->
