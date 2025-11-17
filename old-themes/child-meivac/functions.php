<?php
/**
 * ferrotec functions and definitions
 *
 * @package meivac_layers
 */

function meivac_enqueue_styles() {

    $parent_style = 'layers-style'; // This is 'twentyfifteen-style' for the Twenty Fifteen theme.

    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'meivac-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style ),
        '.1'
    );
}
add_action( 'wp_enqueue_scripts', 'meivac_enqueue_styles' );



   function meivac_scripts() {
    if ( is_page( '398' ) ){
            wp_enqueue_script(
              'meivac-table-sort',
              get_stylesheet_directory_uri() . '/js/mak-sputter-listings.js',
              array('jquery'),
              '',
              false
            );
          }
    if ( is_page( '53' ) ){
        wp_enqueue_script(
          'meivac-table-sort',
          get_stylesheet_directory_uri() . '/js/vari-q-listings.js',
          array('jquery'),
          '',
          false
        );
      }
    }
  
  add_action('wp_enqueue_scripts', 'meivac_scripts');



/**
 * Customize product data tabs
 */
add_filter( 'woocommerce_product_tabs', 'ft_woo_custom_description_tabs', 98 );
function ft_woo_custom_description_tabs( $tabs ) {

    unset( $tabs['reviews'] );      // Remove the reviews tab
    unset( $tabs['additional_information'] );   // Remove the additional information tab
  
  $tabs['description']['callback']= 'ft_woo_description_tab_content';
  $tabs['description']['title']='Description';  
  $tabs['ordering'] = array(
    'title'   => __( 'Ordering', 'ferrotec' ),
    'priority'  => 20,
    'callback'  => 'ft_woo_ordering_tab_content'
  );

  global $product;
  $pid = $product->get_ID();
  if ( get_field("step_file" , $pid ) ){
      $tabs['downloads'] = array(
        'title'   => __( 'Downloads', 'ferrotec' ),
        'priority'  => 30,
        'callback'  => 'ft_woo_downloads_tab_content'
      );
  }
  return $tabs;

}

function ft_woo_description_tab_content() {
  global $post;
  $terms = get_the_terms( $post->ID, 'product_cat' );
  foreach ($terms as $term) {
      $product_cat = $term->slug;
      break;
  }  
  get_template_part('page-templates/single-product/woocommerce-tabs/tab-description', $product_cat );
}

function ft_woo_ordering_tab_content() {
  global $post;
  $terms = get_the_terms( $post->ID, 'product_cat' );
  foreach ($terms as $term) {
      $product_cat = $term->slug;
      break;
  }  
  get_template_part('page-templates/single-product/woocommerce-tabs/tab-ordering', $product_cat );
}

function ft_woo_downloads_tab_content() {
  // The new tab content
  get_template_part('page-templates/single-product/woocommerce-tabs/tab-downloads');  
}


/* add action for custom display hook for product specs tables */

add_action('ft_display_product_specs', 'ft_woo_custom_attributes_table', 10, 1 );

/* custom woocommerce get attributes to filter by a list for each table */
/* $args :
*  product : the woocommerce product object from page
*  attribute_list will be an array of attribute names ['pa_...' ] etc. if not supplied the table uses all visible attributes set by woocommerce 
*  table_head : the header for the table output
 */
function ft_woo_custom_attributes_table( $args ){
  $product = $args['product'];
  $attribute_list = $args['attribute_list'];
  $table_head = ( isset( $args['table_head'] ) ) ? $args['table_head'] : "Specifications";
  $product_attributes = array();

  // Display weight and dimensions before attribute list.
  $display_dimensions = apply_filters( 'wc_product_enable_dimensions_display', $product->has_weight() || $product->has_dimensions() );

  if ( $display_dimensions && $product->has_weight() ) {
    $product_attributes['weight'] = array(
      'label' => __( 'Weight', 'woocommerce' ),
      'value' => wc_format_weight( $product->get_weight() ),
    );
  }

  if ( $display_dimensions && $product->has_dimensions() ) {
    $product_attributes['dimensions'] = array(
      'label' => __( 'Dimensions', 'woocommerce' ),
      'value' => wc_format_dimensions( $product->get_dimensions( false ) ),
    );
  }

  // Add product attributes to list, filtering by the array passed to if it exists otherwise show all visible attributes
  
  if ( is_array($attribute_list) ){
    $attributes = array_intersect_key( $product->get_attributes() , array_flip( $attribute_list ) );
  }else{
    $attributes = array_filter( $product->get_attributes(), 'wc_attributes_array_filter_visible' );
  }
  foreach ( $attributes as $attribute ) {
    $values = array();

    if ( $attribute->is_taxonomy() ) {
      $attribute_taxonomy = $attribute->get_taxonomy_object();
      $attribute_values   = wc_get_product_terms( $product->get_id(), $attribute->get_name(), array( 'fields' => 'all' ) );

      foreach ( $attribute_values as $attribute_value ) {
        $value_name = esc_html( $attribute_value->name );

          $values[] = $value_name;
      }
    } else {
      $values = $attribute->get_options();

      foreach ( $values as &$value ) {
        $value = make_clickable( esc_html( $value ) );
      }
    }
    $titles = array(
      'mc2inputpower' => 'Input Power',
      'mc2dimensions' => 'Dimensions',
      'mc2ioconnections' => 'I/O Connections',
      'at3dimensions' => 'Dimensions',
      'at3cooling' => 'Cooling',
      'at3tuningrange' => 'Tuning Range',
      'at3rfconn' => 'RF Conn.'
    );
    if ( !empty ( $titles[$attribute->get_name()] ) ){
    $product_attributes[ 'attribute_' . sanitize_title_with_dashes( $attribute->get_name() ) ] = array(
      'label' => wc_attribute_label( $titles[$attribute->get_name()] ),
      'value' => apply_filters( 'woocommerce_attribute', wpautop( wptexturize( implode( ', ', $values ) ) ), $attribute, $values ),
    );

    }else{
    $product_attributes[ 'attribute_' . sanitize_title_with_dashes( $attribute->get_name() ) ] = array(
      'label' => wc_attribute_label( $attribute->get_name() ),
      'value' => apply_filters( 'woocommerce_attribute', wpautop( wptexturize( implode( ', ', $values ) ) ), $attribute, $values ),
    );

    }
  }

  /**
   * Hook: woocommerce_display_product_attributes.
   * Hook:  REPLACE woo version with different hook for this function ft_woo_display_product_attributes not using this filter so comment out for now
   * @since 3.6.0.
   * @param array $product_attributes Array of atributes to display; label, value.
   * @param WC_Product $product Showing attributes for this product.
   */
  //$product_attributes = apply_filters( 'woocommerce_display_product_attributes', $product_attributes, $product );
  //$product_attributes = apply_filters( 'ft_woo_display_product_attributes', $product_attributes, $product );

  get_template_part(
    'page-templates/single-product/product-specs-tables', null,
    array(
      'product_attributes' => $product_attributes,
      'table_head' => $args['table_head']
    )
  );  
}


/* shortcode [ show_meivac_products category="*slug of product_cat*" ] */


function show_meivac_products_func($atts, $content = null){
    $a = shortcode_atts( array(
        'category' => '',
    ), $atts );
      $cat = $a['category'];

$output = '';
  $q = get_posts(
    array(
      'post_type' => 'product',
      'tax_query' => array(
        array(
          'taxonomy' => 'product_cat',
          'field' => 'slug',
          'terms' => $cat,
        )
      ),
      'fields' => 'ids',
      'nopaging' => true,
        'orderby' => 'menu_order title',
        'order'   => 'ASC',     
    )
  );
    if ($q){
      $_pf = new WC_Product_Factory();  
      $output .= '<div class="indent-lightgrey-bkg">';
      $output .= '<div class="table-responsive">';
      $output .= '<table class="ferrofluid-table table table-striped">';
      $output .= '<thead>';
      $output .= '<tr id="prodTableHead">';
      $output .= '  <th>Image</th> ';
      $output .= '  <th>Product</th> ';
      $output .= '  <th>O.D.</th> ';
      $output .= '  <th>I.D.</th> ';
      $output .= '  <th>Material/Coating</th> ';
      $output .= '  <th>Actuation</th> ';
      $output .= '</tr>';
      $output .= '</thead>';
      $output .= '<tbody>';
      foreach ($q as $pid ){
          $_product = $_pf->get_product($pid);
          $output .= '<tr class="listing-row">';
          $output .= '    <td>'. get_the_post_thumbnail($pid, 'thumbnail').'</td>';
          $output .= '    <td><a href="'. get_the_permalink($pid). '">'. get_the_title($pid) . '</a></td>';
          $output .= '    <td>'. $_product->get_attribute('o-d') . '</td>';
          $output .= '    <td>'. $_product->get_attribute('i-d') . '</td>';
          $output .= '    <td>'. $_product->get_attribute('material') . '/'. $_product->get_attribute('coating') . '</td>';
          $output .= '    <td>'. $_product->get_attribute('actuation') . '</td>';
          $output .= '</tr>';
      }
      $output .= '</tbody>';
      $output .= '</table>';
      $output .= '</div></div>';
    }

  return $output;

}


function show_meivac_template($atts, $content = null){
    $a = shortcode_atts( array(
        'category' => '',
    ), $atts );
    ob_start();
    get_template_part( "category-templates/listing", $a['category'] , $a  );
    $output = ob_get_clean();
    return $output;

}
//add_shortcode('show_meivac_products', 'show_meivac_products_func');
add_shortcode('show_meivac_products', 'show_meivac_template');

/* get the terms from a post meta field to make dropdown select ( used on vari-q listings ) */
 function meta_list($key = '', $type = '', $status = 'publish'){
 global $wpdb;
    $r = $wpdb->get_col($wpdb->prepare( "
    SELECT DISTINCT pm.meta_value FROM {$wpdb->postmeta} pm
    LEFT JOIN {$wpdb->posts} p ON p.ID = pm.post_id
    WHERE pm.meta_key = '%s'
    AND p.post_status = '%s'
    AND p.post_type = '%s'
    ORDER BY pm.meta_value ASC", $key, $status, $type));
    return $r;
}
/* get the terms from a post meta field to make dropdown select ( used on vari-q listings ) */
 function meta_list_numeric($key = '', $type = '', $status = 'publish'){
 global $wpdb;
    $r = $wpdb->get_col($wpdb->prepare( "
    SELECT DISTINCT pm.meta_value FROM {$wpdb->postmeta} pm
    LEFT JOIN {$wpdb->posts} p ON p.ID = pm.post_id
    WHERE pm.meta_key = '%s'
    AND p.post_status = '%s'
    AND p.post_type = '%s'
    ORDER BY CAST(pm.meta_value as unsigned)", $key, $status, $type));
    return $r;
}
