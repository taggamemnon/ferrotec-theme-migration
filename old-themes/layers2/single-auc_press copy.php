<?php
/**
 * The template for displaying all single press releases.
 *
 */

get_header(); ?>
	<div class="row full-release-page">
		<div class="col-sm-12">

			<div id="primary" class="content-area">
				<main id="main" class="site-main" role="main">
<header class="page-header">
		<div class="page-banner">
			<div class="container">
			<div class="flex-area-center">
									<h1>Press Releases</h1>
									</div>
							</div>
		</div>
</header>
<div class="container">
					<?php while (have_posts()) : the_post(); ?>

						<?php get_template_part('content', 'single_press'); ?>

						<?php
						// If comments are open or we have at least one comment, load up the comment template
						if (comments_open() || get_comments_number()) :
							comments_template();
						endif;
						?>

					<?php endwhile; // end of the loop. ?>
				</div>

				</main>
				<!-- #main -->
			</div>
			<!-- #primary -->
		</div>
	</div>
<?php get_footer(); ?>
