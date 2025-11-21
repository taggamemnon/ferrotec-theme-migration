<?php
/*
Template Name: Resources Page
*/
 get_header(); ?>
<?php
$field_key = "field_54d56916f101e";
$field = get_field_object($field_key);
if( $field )
{
	$terms = $field['choices'];
}

?>
	<?php get_template_part( 'banner', 'page' ); ?>
	<div class="container resources">
		<div class="row">
			<div class="col-sm-12">
				<ul class="nav nav-tabs js-tabCollapse-sm" role="tablist" id="resources-tabs">
					<?php
					$row_count = 0;
						foreach( $terms as $k => $v ) : 
							$resources = new WP_Query( array( 
								'post_type'      	=> 'hillstone_resources',
								'posts_per_page'	=> -1,
								'meta_key' 			=> 'category',
								'meta_value' 		=> $k,

						    	) );
							if ( $resources->have_posts() ) : 
							$row_count++; ?>
								  <li class="<?php echo ( $row_count == 1 ? 'active' : ''); ?>"><a href="<?php echo '#'.sanitize_title_with_dashes($k);?>" role="tab" data-toggle="tab"><?php echo $v.'s'; ?></a></li>
							<?php endif; ?>
					<?php endforeach;?>
				</ul>
				<div class="tab-content">
					<?php
					$row_count = 0;
						foreach( $terms as $k => $v ) : 
							$resources = new WP_Query( array( 
								'post_type'      	=> 'hillstone_resources',
								'posts_per_page'	=> -1,
								'meta_key' 			=> 'category',
								'meta_value' 		=> $k,

						    	)
						    );
							if ( $resources->have_posts() ) : 
							$row_count++; ?>
								<div class="tab-pane <?php echo ( $row_count == 1 ? 'active' : ''); ?>" id="<?php echo sanitize_title_with_dashes($k);?>">
<!-- make featured section -->
								<?php $featured = new WP_Query( array(
									'post_type'      	=> 'hillstone_resources',
									'posts_per_page'	=> -1,
									'meta_query' => array(
										'relation' => 'AND',
										array(
											'key' => 'category',
											'value' => $k,
											'compare' => '='
										),
										array(
											'key' => 'featured',
											'value' => 'true',
											'compare' => '='
										)
									)
								) );
								if ( $featured->have_posts() ) : ?>
									<!--h2><?php echo $v;?></h2-->
									<div class="featured-resource-section">
										<?php while ( $featured->have_posts() ) : $featured->the_post(); ?>
											<div class="resource-tile <?php echo $v;?>-tile">
											  	<?php
													if (get_field('event_image')) { ?>
															<img src="<?php the_field('event_image') ?>" alt="">
														<?php }
												?>
												<div class="date"><?php the_date(); ?></div>
												<h3><?php the_title(); ?></h3>
												<p><?php the_excerpt(); ?></p>
												<?php if (get_field('gated')) : ?>
													<form action="<?php echo site_url('/resources/register') ?>" method="post">
														<input type="hidden" name="res_id" value="<?php the_ID()?>">
														<input type="hidden" name="res_name" value="<?php the_title();?>">
														<input type="hidden" name="res_type" value="<?php echo $k; ?>">
														<button type="submit">Gated Download</button>
													</form>
												<?php else : ?>
													<a href="<?php the_field('resource_url'); ?>"target="_blank">Download</a>
												<?php endif ?>
											</div>
										<?php endwhile; wp_reset_query(); ?>
									</div>
								<?php endif; ?>
<!-- end featured section -->
<!-- start resources section -->								
								<?php $query = new WP_Query( array(
									'post_type'      	=> 'hillstone_resources',
									'posts_per_page'	=> -1,
									'meta_query' => array(
										array(
											'key' => 'category',
											'value' => $k,
											'compare' => '='
										),
									)
								) );
								if ( $query->have_posts() ) : ?>
										<div class="resource-section">
										<?php while ( $query->have_posts() ) : $query->the_post(); ?>
											<div class="resource-tile <?php echo $v;?>-tile">
											  	<?php
													if (get_field('event_image')) { ?>
															<img src="<?php the_field('event_image') ?>" alt="">
														<?php }
												?>
												<div class="date"><?php the_date(); ?></div>
												<h3><?php the_title(); ?></h3>
												<p><?php the_excerpt(); ?></p>
												<?php if (get_field('gated')) : ?>
													<form action="<?php echo site_url('/resources/register') ?>" method="post">
														<input type="hidden" name="res_id" value="<?php the_ID()?>">
														<input type="hidden" name="res_name" value="<?php the_title();?>">
														<input type="hidden" name="res_type" value="<?php echo $k; ?>">
														<button type="submit">Gated Download</button>
													</form>
												<?php else : ?>
													<a href="<?php the_field('resource_url'); ?>"target="_blank">Download</a>
												<?php endif ?>
											</div>
										<?php endwhile; wp_reset_query(); ?>
									</div>
								<?php endif; ?>
<!-- end resources section -->								
							</div>
						<?php endif; ?>
					<?php endforeach; wp_reset_query();?>
				</div>
			</div>
		</div>
	</div>
 <?php get_footer(); 
