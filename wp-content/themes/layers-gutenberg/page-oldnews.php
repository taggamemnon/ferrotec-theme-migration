<?php
/*
   Template Name: News Page
   */
get_header(); ?>
<?php get_template_part('banner', 'page'); ?>
	<!-- .entry-header -->
	<div class="container news-coverage">
		<div class="col-sm-12">
			<?php $loop = new WP_Query(array(
				'post_type'      => 'hillstone_news',
				'orderby'        => 'date',
				'order'          => 'DSC',
				'posts_per_page' => - 1,
			)); ?>
			<?php if ($loop->have_posts()) : ?>
				<div class="featured-news-section">
					<?php while ($loop->have_posts()) : $loop->the_post(); ?>
						<?php $url        = get_post_meta(get_the_ID(), 'press_url');
						$dateformatstring = "M d, Y";
						?>
						<div class="news-tile">
							<div class="row">

								<div class="col-sm-2">
									<h5 style="margin-top: 10px;"><?php the_field('publication_name'); ?></h5>

									<div class="date"><?php echo get_the_date(); ?></div>
								</div>
								<div class="col-sm-8">
									<h4 style="margin-top: 10px;"><?php echo the_title(); ?></h4>
									<?php
									if (get_field('subhead')) { ?>
										<p><b><?php the_field('subhead') ?></b></p>
									<?php }
									?>
									<p><?php the_excerpt(); ?><br>
										<a target="_blank" href="<?php the_field('news_url') ?>">Read More &raquo; </a></p>
								</div>
								<div class="col-sm-2">
									<?php
									if (get_field('publication_image')) { ?>
										<img src="<?php the_field('publication_image') ?>" class="pub news" alt="">
									<?php }
									?>
								</div>

							</div>
						</div>
					<?php endwhile;
					wp_reset_query(); ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
<?php get_footer();
