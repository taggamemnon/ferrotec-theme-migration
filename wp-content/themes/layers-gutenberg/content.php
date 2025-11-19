<?php
/**
 * @package Hillstone
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php $src = (get_the_author_meta('user_image')) ? get_the_author_meta('user_image') : ('http://www.gravatar.com/avatar/' . md5(strtolower(trim(get_the_author_meta('user_email')))) . '?s=60'); ?>
	<div class="secondary-post">
		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<div class="col-sm-12">
				<p class="post-date"><?php the_date('F j, Y'); ?></p>

				<h2 class="entry-title"><a href="<?php the_permalink(); ?>"
				                           title="<?php printf(esc_attr__('Permalink to %s', 'violinmemory'), the_title_attribute('echo=0')); ?>"
				                           rel="bookmark"><?php the_title(); ?></a></h2>
			</div>
			<div class="col-xs-10 entry-content">
				<?php
				if (has_post_thumbnail()) {
					$image = wp_prepare_attachment_for_js(get_post_thumbnail_id())
					?>
					<img class="featured-image" src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>">
					<?php
				}
				?>
				<?php the_excerpt(); ?>
			</div>
			<!-- .entry-content -->
			<div class="col-xs-2 author"><a href="<?php echo get_author_posts_url($item['ID']); ?>">
					<img class="gravatar" src="<?php echo $src; ?>" width="60" alt=""/></a> by <?php the_author_posts_link(); ?>
			</div>
		</div>
		<!-- #post-## -->
	</div>
</article><!-- #post-## -->
