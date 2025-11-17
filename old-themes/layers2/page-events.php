<?php
/*
   Template Name: Events Page
   */
get_header(); ?>
<?php get_template_part('banner', 'page'); ?>
	<!-- .entry-header -->
	<div class="container events">
		<div class="row">
			<div class="col-sm-12">
				<?php
				$today = date('Ymd');
				$loop  = new WP_Query(array(
					'post_type'      => 'hillstone_events',
					'meta_key'       => 'start_date',
					'orderby'        => 'meta_value_num',
					'order'          => 'ASC',
					'posts_per_page' => - 1,
					'meta_query'     => array(
						array(
							'key'     => 'end_date',
							'compare' => '>=',
							'value'   => $today,
						)
					),

				)); ?>
				<?php if ($loop->have_posts()) : ?>
					<div class="featured-event-section" id="events">

						<?php while ($loop->have_posts()) : $loop->the_post(); ?>
							<?php
							$startdateformatstring = "M d";
							$enddateformatstring   = "d, Y";
							$starttimestamp        = strtotime(get_field('start_date'));
							$endtimestamp          = strtotime(get_field('end_date'));
							if (date('m', $starttimestamp) != date('m', $endtimestamp)) {
								$startdateformatstring = " M d";
								$enddateformatstring   = "M d, Y";
							}
							if (date('Y', $starttimestamp) != date('Y', $endtimestamp)) {
								$startdateformatstring = "M d, Y";
								$enddateformatstring   = "M d, Y";
							}
							if ($starttimestamp == $endtimestamp) {
								$eventdateformatted = date_i18n("M d, Y", $endtimestamp);
							} else {
								$eventdateformatted = date_i18n($startdateformatstring, $starttimestamp) . " - " . date_i18n($enddateformatstring, $endtimestamp);
							}
							?>
							<div class="event-tile">
								<div class="row">
									<div class="col-sm-2">
										<div class="date cc"><?php echo $eventdateformatted ?></div>
									</div>
									<div class="col-sm-8">
										<h4 style="margin-top:20px;"><?php the_title(); ?></h4>
										<p><?php the_excerpt(); ?></p>
										<p>Event links: <a href="<?php the_field('promotional_url') ?>" target="_blank">Event Site</a> | <a
												href="<?php the_field('registration_url') ?>"
												target="_blank">Registration</a></p>
									</div>
									<div class="col-sm-2" style="padding-top:20px;">
										<?php
										if (get_field('event_image')) { ?>
											<img src="<?php the_field('event_image') ?>" alt="">
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
	</div>
<?php get_footer();
