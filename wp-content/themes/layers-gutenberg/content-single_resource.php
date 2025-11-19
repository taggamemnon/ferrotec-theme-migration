<?php
/**
 * @package Hillstone
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title('<h3 class="entry-title">', '</h3>'); ?>
	</header>
	<!-- .entry-header -->

	<div class="entry-content">
		<?php
		$html = '';
		switch (get_field('category')) {
		case 'video':
		case 'webinar':
			the_content();
			break;
		case 'analyst': ?>
		<h4>We&rsquo;ve received your request</h4><p>An email will be sent with your requested resources in accordance with the authors
		                                             request within the next 48 hours.<p>
			<?php break;
			default:
				$html .= '<p>' . get_the_content() . '</p>';
				$html .= '<p><a class="btn btn-primary" target="_blank" href="' . get_field('resource_url') . '">Start Download</a></p>';
				break;
			};
			?>
			<?php echo $html; ?>
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
