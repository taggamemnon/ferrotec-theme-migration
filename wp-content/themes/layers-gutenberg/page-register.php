<?php

/*
Template Name: Resources Page
*/
/**
 * The template for the registration page for resources
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package Violin
 */

get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

		<?php while (have_posts()) :
		the_post(); ?>
		<?php if ( ! is_front_page()) : ?>
			<?php get_template_part('banner', 'page'); ?>
		<?php endif; ?>
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<div class="content-padding">
				<div class="container">
					<div class="row">
						<div class="col-sm-8">
							<div class="entry-content">
								<?php
								$res_type = sanitize_text_field($_REQUEST['res_type']);
								$html     = '';
								switch ($res_type) {
									case 'video':
									case 'webinar':
										$html .= '<h4>Software Defined Security for Today’s Cloud</h4><p>' . get_the_title($_REQUEST['res_id']) . '</p>';
										break;
									case 'analyst':
										$html .= '<p class="warning-highlight"><b>Note:</b> This item must be sent to you by email to be in accordance with our agreement with the author. After registration, you&rsquo;ll receive an email with the paper attached.</p>';
										$html .= '<h4>' . get_the_title($_REQUEST['res_id']) . '</h4><p>' . get_the_content_by_id($_REQUEST['res_id']) . '<p>';
										break;
									default:
										$html .= '<h4>' . get_the_title($_REQUEST['res_id']) . '</h4><p>' . get_the_content_by_id($_REQUEST['res_id']) . '<p>';
										break;
								};
								?>
								<?php echo $html; ?>
							</div>
							<!-- .entry-content -->
						</div>
						<div class="col-sm-4">
							<?php gravity_form(7, true, true); ?>
						</div>
					</div>
				</div>
				<footer class="entry-footer">
					<?php hillstone_entry_footer(); ?>
				</footer>
				<!-- .entry-footer -->
		</article>
		<!-- #post-## -->
</div>
<?php endwhile; // end of the loop. ?>

</main><!-- #main -->
</div><!-- #primary -->

<?php get_footer(); ?>
