<?php
/**
 * The header for our theme
 *
 * @package Layers2025
 * @since 1.0.0
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'layers2025' ); ?></a>

    <header id="masthead" class="site-header">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="site-branding">
                        <?php
                        if ( has_custom_logo() ) :
                            the_custom_logo();
                        else :
                            ?>
                            <h1 class="site-title">
                                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                                    <?php bloginfo( 'name' ); ?>
                                </a>
                            </h1>
                            <?php
                            $description = get_bloginfo( 'description', 'display' );
                            if ( $description || is_customize_preview() ) :
                                ?>
                                <p class="site-description"><?php echo $description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div><!-- .site-branding -->

                    <?php layers2025_primary_navigation(); ?>

                    <!-- Mobile menu toggle -->
                    <button class="mobile-menu-toggle" aria-controls="mobile-navigation" aria-expanded="false">
                        <span class="screen-reader-text"><?php esc_html_e( 'Menu', 'layers2025' ); ?></span>
                        <span class="menu-icon" aria-hidden="true">
                            <span></span>
                            <span></span>
                            <span></span>
                        </span>
                    </button>

                    <?php layers2025_mobile_navigation(); ?>
                </div>
            </div>
        </div><!-- .container -->
    </header><!-- #masthead -->

    <div id="content" class="site-content">
        <div class="container">
            <div class="row">
