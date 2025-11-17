<?php
/**
 * The footer for our theme
 *
 * @package Layers2025
 * @since 1.0.0
 */
?>
            </div><!-- .row -->
        </div><!-- .container -->
    </div><!-- #content -->

    <footer id="colophon" class="site-footer">
        <?php if ( is_active_sidebar( 'footer-1' ) || is_active_sidebar( 'footer-2' ) || is_active_sidebar( 'footer-3' ) ) : ?>
            <div class="footer-widgets">
                <div class="container">
                    <div class="row">
                        <?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
                            <div class="col-md-4 footer-widget-area">
                                <?php dynamic_sidebar( 'footer-1' ); ?>
                            </div>
                        <?php endif; ?>

                        <?php if ( is_active_sidebar( 'footer-2' ) ) : ?>
                            <div class="col-md-4 footer-widget-area">
                                <?php dynamic_sidebar( 'footer-2' ); ?>
                            </div>
                        <?php endif; ?>

                        <?php if ( is_active_sidebar( 'footer-3' ) ) : ?>
                            <div class="col-md-4 footer-widget-area">
                                <?php dynamic_sidebar( 'footer-3' ); ?>
                            </div>
                        <?php endif; ?>
                    </div><!-- .row -->
                </div><!-- .container -->
            </div><!-- .footer-widgets -->
        <?php endif; ?>

        <div class="site-info">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="copyright">
                            <?php
                            /* translators: %s: Current year */
                            printf( esc_html__( '&copy; %s Ferrotec. All rights reserved.', 'layers2025' ), esc_html( date( 'Y' ) ) );
                            ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <?php layers2025_footer_navigation(); ?>
                    </div>
                </div><!-- .row -->
            </div><!-- .container -->
        </div><!-- .site-info -->
    </footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
