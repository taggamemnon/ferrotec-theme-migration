<?php
/*
Template Name: Press release Page
*/
get_header(); ?>
<?php get_template_part('banner', 'page'); ?>
	<div class="container press-releases">
		<div class="row">
			<div class="col-sm-12">
				<?php
				$today = date('Ymd');
				$loop  = new WP_Query(array(
					'post_type'      => 'hillstone_press',
					'orderby'        => 'meta_value_num',
					'order'          => 'DESC',
					'posts_per_page' => - 1,
				)); ?>
				<?php if ($loop->have_posts()) : ?>
					<div class="featured-press-section" id="press-releases">
						<h2>Press Releases</h2>
						<?php while ($loop->have_posts()) : $loop->the_post(); ?>
							<div class="press-release-tile">
								<div class="row">
									<div class="col-sm-2 date">
										<?php the_date(); ?>
									</div>
									<div class="col-sm-10">
										<?php the_title('<h3>', '</h3>'); ?>
										<?php the_excerpt(); ?>
									</div>
								</div>
							</div>
						<?php endwhile;
						wp_reset_query(); ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>

<?php get_footer();
