<?php
$field_key = "field_54d56916f101e";
$field     = get_field_object($field_key);
if ($field) {
	$terms = $field['choices'];
}
$ids       = get_field('resource_links', false, false);
$row_count = 0;
if ($ids) : ?>
	<?php var_dump($ids) ?>
	<div class="container-wrapper" style="background-color:#f7f7f7;">
		<div class="container container-narrow">
			<h2>Resources</h2>

			<div class="panel-group" id="resources-accordion" role="tablist" aria-multiselectable="true">
				<?php foreach ($terms as $k => $v) :
					$resources = new WP_Query(array(
						'post_type'      => 'hillstone_resources',
						'posts_per_page' => - 1,
						'meta_key'       => 'category',
						'meta_value'     => $v,
						'post__in'       => $ids,
					));
					if ($resources->have_posts()) :
						$row_count ++; ?>
						<div class="panel panel-default">
							<div class="panel-heading" role="tab" id="heading-<?php echo sanitize_title_with_dashes($k); ?>">
								<h4 class="panel-title"><a class="<?php echo($row_count == 1 ? '' : 'collapsed'); ?>"
								                           data-toggle="collapse"
								                           data-parent="#resources-accordion"
								                           href="#<?php echo $k ?>"
								                           aria-expanded="<?php echo($row_count == 1 ? 'true' : 'false'); ?>"
								                           aria-controls="<?php echo sanitize_title_with_dashes($k) ?>"><?php echo $v ?></a>
								</h4>
							</div>
							<div id="<?php echo $k ?>"
							     class="panel-collapse collapse <?php echo($row_count == 1 ? 'in' : ''); ?>"
							     role="tabpanel"
							     aria-labeledby="heading-<?php echo sanitize_title_with_dashes($k) ?>">
								<div class="panel-body">
									<ul class="resource-listing">
										<?php while ($resources->have_posts()) : $resources->the_post(); ?>
											<?php $url = get_post_meta(get_the_ID(), 'resource_url'); ?>
											<li><a href="<?php echo $url[0] ?>" target="_blank">
													<?php
													echo get_the_title();
													?>
												</a></li>
										<?php endwhile;
										wp_reset_query(); ?>
									</ul>
								</div>
							</div>
						</div>
					<?php endif; ?>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
<?php endif; ?>
