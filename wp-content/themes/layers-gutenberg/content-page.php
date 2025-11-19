<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package Hillstone
 */

// remove wpautop from ACF field, this is also in the main functions file but does not correctly apply to the fields for some reason
remove_filter( 'acf_the_content', 'wpautop' );

?>
<?php if ( ! is_front_page()) : ?>
	<?php get_template_part('banner', 'page'); ?>
<?php endif; ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry-content">
		<?php if ( ! is_front_page()) : ?>
			<div class="container-wrapper content-padding">
				<div class="container">
					<?php
					//echo get_site_url();
					if ( function_exists('yoast_breadcrumb') ) {
					  yoast_breadcrumb( '<p id="breadcrumbs" class="text-right">','</p>' );
					}
					?>

		<?php endif; ?>
		<?php the_content(); ?>
		<?php if ( ! is_front_page()) : ?>
				</div>
			</div>
		<?php endif; ?>
		<?php
		wp_link_pages(array(
			'before' => '<div class="page-links">' . __('Pages:', 'hillstone'),
			'after'  => '</div>',
		));
		//remove_filter('acf_the_content', 'wpautop');
		?>
	</div>
	<!-- .entry-content -->
	<?php if (have_rows('rows')): ?>
 
		<?php while (have_rows('rows')): the_row();
			// vars
			$content  = get_sub_field( 'content' );
			$bk_color = get_sub_field('background-color');
			$bk_class = get_sub_field('background-class');
			?>
			<div class="container-wrapper content-padding <?php echo $bk_class ?>" <?php if ($bk_color) {
				echo 'style="background-color:' . $bk_color . '"';
			} ?> >
				<div class="container">
					<?php echo $content; ?>
				</div>
			</div>
		<?php endwhile; ?>

		</ul>

	<?php endif; ?>

</article>
