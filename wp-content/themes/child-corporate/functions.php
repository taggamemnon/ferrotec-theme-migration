<?php
/**
 * ferrotec functions and definitions
 *
 * @package thermalelectric
 */

function child_theme_enqueue_styles() {


    wp_enqueue_style( 'corporate-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( 'layers-style', 'pa-style' ),
        filemtime( get_stylesheet_directory() . '/style.css' )
    );
}
add_action( 'wp_enqueue_scripts', 'child_theme_enqueue_styles' );



   function raphael2_scripts () {
   	if ( is_page_template( 'template-thermal-graph-product-page.php' ) ) {
   	    wp_enqueue_script(
   	      'raphael',
   	      get_template_directory_uri() . '/js/raphael-min.js',
   	      array('jquery'),
   	      '',
   	      false
   	    );
   	    wp_enqueue_script(
   	      'graphs',
   	      get_template_directory_uri() . '/js/g.ferrotec.js',
   	      array('raphael', 'jquery'),
   	      '',
   	      false
   	    );  
   	}
  }
  
  add_action('wp_enqueue_scripts', 'raphael2_scripts');

