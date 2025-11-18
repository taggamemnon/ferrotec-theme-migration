<?php
/**
 * The front page template file
 *
 * Template Name: Home Page
 *
 * @package Layers2025
 * @since 1.0.0
 */

get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

		<?php
		while ( have_posts() ) :
			the_post();

			// Get page content with ACF blocks support
			get_template_part( 'template-parts/content/content', 'page' );

			// Comments (if enabled)
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile;
		?>

	</main><!-- #main -->
</div><!-- #primary -->

<?php
get_footer();
