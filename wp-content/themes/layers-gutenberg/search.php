<?php
/**
 * The template for displaying search results pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package ferrotec
 */

get_header(); ?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main container" role="main">
			<header class="search-header">
				<h1 class="search-title"><?php printf( esc_html__( 'You searched for: %s', 'ferrotec' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
			</header><!-- .search-header -->
			<div class="s-results">
		<?php
		if (function_exists('relevanssi_didyoumean')) {
		    relevanssi_didyoumean(get_search_query(), "<p>Did you mean: ", "</p>", 5);
		}		
		if ( have_posts() ) : ?>
			<div class="s-results-info"><?php echo $wp_query->found_posts.' results found.'; ?></div>

			<?php
			/* Start the Loop */
			while ( have_posts() ) : the_post();
				switch_to_blog($post->blog_id);

				/**
				 * Run the loop for the search to output the results.
				 * If you want to overload this in a child theme then include a file
				 * called content-search.php and that will be used instead.
				 */
				get_template_part( 'template-parts/content', 'search' );
				restore_current_blog();

			endwhile;

			the_posts_pagination();

		else :?>

			<p><?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'ferrotec' ); ?></p>
			<?php
				get_search_form();

		endif;
		?>
</div>
		</main><!-- #main -->
	</section><!-- #primary -->

<?php
get_footer();
