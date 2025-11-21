<div id="sidebar">
	<ul class="widget-area">
		<?php if (function_exists('dynamic_sidebar')) {
			dynamic_sidebar('sidebar-blog');
		} ?>
	</ul>

	<?php
	$sidebar_query = new WP_Query(array('post_type' => 'post', 'posts_per_page' => 5));
	?>
	<?php if ($sidebar_query->have_posts()) { ?>

	<?php } ?>
	<?php wp_reset_postdata(); ?>

</div>
