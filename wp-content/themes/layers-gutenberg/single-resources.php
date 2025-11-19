<?php
/**
 * The template for displaying all single posts.
 *
 * @package Hillstone
 */

get_header(); ?>
<div class="page-banner">
	<div class="container">
		<h1>Resource Library</h1>
	</div>
</div>
<div class="container">
	<div class="row full-release-page">
		<div class="col-sm-12">

			<div id="primary" class="content-area">
				<main id="main" class="site-main" role="main">

					<?php while (have_posts()) : the_post(); ?>

						<?php get_template_part('content', 'single_resource'); ?>

						<?php
						// If comments are open or we have at least one comment, load up the comment template
						if (comments_open() || get_comments_number()) :
							comments_template();
						endif;
						?>

					<?php endwhile; // end of the loop. ?>

				</main>
				<!-- #main -->
			</div>
			<!-- #primary -->
		</div>
	</div>
</div>
<?php get_footer(); ?>
