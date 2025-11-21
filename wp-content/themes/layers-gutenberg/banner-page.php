<?php
$banner_styles = "";
$banner_class = ".bnr-" . get_post_field( 'post_name' );
if ( !get_field('disable_page_banner') ) : 
	if (get_field('mobile_banner_image')){
		$banner_styles .= $banner_class ." { background-image:url( " . get_field('mobile_banner_image') . " ); }";
		$banner_styles .= "@media(min-width:768px){";
	}
	if (get_field('banner_image'))
		$banner_styles .= $banner_class ." { background-image:url( " . get_field('banner_image') . " ); }";
	if (get_field('mobile_banner_image'))
		$banner_styles .= "}";

	if (get_field('banner_color'))
		$banner_styles .= $banner_class ." { background-color: " . get_field('banner_color') . "; }";
	if (get_field('text_color')) {
		$banner_styles .= $banner_class ." { color: " . get_field('text_color') . "; }";
		$banner_styles .= $banner_class ." h1 { color: " . get_field('text_color') . "; }";
	}
	?>
	<style>
	<?php echo $banner_styles; ?>
	</style>

	<header class="page-header bnr-<?php echo get_post_field( 'post_name' ) ?>">
			<div class="page-banner" >
				<div class="container">
					<div class="background-product"></div>
					<div class="flex-area-center">
						<?php if (get_field('banner_text') ): ?>
							<?php the_field('banner_text'); ?>
						<?php else : ?>
							<h1><?php the_title() ?></h1>				
						<?php endif ?>
					</div>
				</div>
			</div>
	</header>
	<?php
endif;