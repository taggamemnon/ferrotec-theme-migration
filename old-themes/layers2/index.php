<?php
/*
Template Name: Blog Landing
*/
?>
<?php get_header('blog'); ?>
<?php
global $wp_query;
$current_post = get_post($wp_query->queried_object->ID);
setup_postdata($current_post);
?>
<div class="container">
	<div class="row">
		<div class="span8 posts-container col-sm-9">
			<?php $current_post = $post; // current post ?>

			<?php
			$paged    = get_query_var('paged');
			$paged    = $paged ? $paged : 1;
			$my_query = new WP_Query(array('post_type' => 'post', 'posts_per_page' => 5, 'paged' => $paged));
			$c        = 0;
			?>
			<?php if ($my_query->have_posts()) { ?>

				<?php while ($my_query->have_posts()) {
					$my_query->the_post(); ?>
					<?php $c ++;
					if ($c == 1) : ?>
						<?php $src = (get_the_author_meta('user_image')) ? get_the_author_meta('user_image') : ('http://www.gravatar.com/avatar/' . md5(strtolower(trim(get_the_author_meta('user_email')))) . '?s=60'); ?>
						<div class="top-post row">
							<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
								<div class="col-sm-12">
									<p class="post-date"><?php the_date('F j, Y'); ?></p>

									<h2 class="entry-title"><a href="<?php the_permalink(); ?>"
									                           title="<?php printf(esc_attr__('Permalink to %s', 'violinmemory'), the_title_attribute('echo=0')); ?>"
									                           rel="bookmark"><?php the_title(); ?></a></h2>
									<?php
									if (has_post_thumbnail()) {
										$image = wp_prepare_attachment_for_js(get_post_thumbnail_id())
										?>
										<img class="featured-image" src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>">
										<?php
									}
									?>
								</div>
								<div class="col-xs-10 entry-content">
									<?php the_excerpt(); ?>
								</div>
								<div class="col-xs-2 author">
									<a href="<?php echo get_author_posts_url($item['ID']); ?>"><img class="gravatar"
									                                                                src="<?php echo $src; ?>"
									                                                                width="60"
									                                                                alt=""/></a>
									by <?php the_author_posts_link(); ?>
								</div>
							</div>
							<!-- #post-## -->
						</div>
					<?php else : ?>
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
								<div class="col-xs-2 author">
									<a href="<?php echo get_author_posts_url($item['ID']); ?>"><img class="gravatar"
									                                                                src="<?php echo $src; ?>"
									                                                                width="60"
									                                                                alt=""/></a>
									by <?php the_author_posts_link(); ?></div>
							</div>
							<!-- #post-## -->
						</div>
					<?php endif; ?>
				<?php } ?>

				<div class="navigation">
					<div class="alignleft"><?php next_posts_link('&laquo; Older Entries'); ?></div>
					<div class="alignright"><?php previous_posts_link('Newer Entries &raquo;'); ?></div>
				</div>

				<?php wp_reset_postdata(); ?>

			<?php } ?>

			<?php $post = $current_post; // restore current post ?>
		</div>
		<div class="col-sm-3">
			<?php get_sidebar('blog'); ?>
		</div>
	</div>
</div>
<?php get_footer(); ?>
