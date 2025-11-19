<?php
/*
   Template Name: Ferrofluid Product Page
   */
get_header('fluidproduct'); ?>

<?php if ( have_posts() ) : ?>
 <?php while ( have_posts() ) : the_post(); ?>
    <?php get_template_part('template-parts/content','ferrofluidproducts'); ?>
            <?php endwhile; // end of the loop. ?>
<?php endif; ?>

<?php get_footer();
