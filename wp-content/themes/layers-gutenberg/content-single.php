<?php
/**
 * @package Hillstone
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title('<h1 class="entry-title">', '</h1>'); ?>
		<?php
		if (has_post_thumbnail()) {
			$image = wp_prepare_attachment_for_js(get_post_thumbnail_id())
			?>
			<img class="featured-image" src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>">
			<?php
		}
		?>

		<div class="entry-meta">
			<?php hillstone_posted_on(); ?>
		</div>
		<!-- .entry-meta -->
	</header>
	<!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
		<?php
		wp_link_pages(array(
			'before' => '<div class="page-links">' . __('Pages:', 'hillstone'),
			'after'  => '</div>',
		));
		?>
	</div>
	<!-- .entry-content -->

	<footer class="entry-footer">
		<?php hillstone_entry_footer(); ?>
	</footer>
	<!-- .entry-footer -->
</article><!-- #post-## -->
