<?php
/**
 * Template part for displaying results in search pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package ferrotec
 */

?>

<a href="<?php echo the_permalink()?>" id="post-<?php the_ID(); ?>" class="s-results-post" rel="bookmark">
	<header class="entry-header">
		<?php the_title( '<h2 class="entry-title">', '</h2>' ); ?>
		<p><?php echo the_permalink()?></p>
	</header><!-- .entry-header -->

	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->
</a><!-- #post-## -->
