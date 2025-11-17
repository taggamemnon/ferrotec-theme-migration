<?php
if ( $args['category'] ) {
  $cat = $args['category'];
}
  $output = '';
  $q = get_posts(
    array(
      'post_type' => 'product',
      'posts_per_page' => -1,
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
      $_pf = new WC_Product_Factory();  ?>
<div class="indent-lightgrey-bkg">
         <div class="vf-catalog-rowhead">
            <h3>Select Configuration Filters</h3>
         </div>

<div class="row vf-catalog-colheads">
         <div class="col-sm-3">
            <div class="drop_title">Target Diameter</div>
            <div class="drop_content">
               <select name="size" class="MVformElement" id="size">
                  <option value="all">Select..</option>
                  <option value="1.3">1.3"</option>
                  <option value="2.0">2"</option>
                  <option value="3.0">3"</option>
                  <option value="4.0">4"</option>
                  <option value="6.0">6"</option>
                  </select>
            </div>
         </div>
         <div class="col-sm-3">
            <div class="drop_title">Mount Type</div>
            <div class="drop_content">
               <select name="type" id="type" class="MVformElement">
                  <option value="all">Select…</option>
                  <option value="flange">Flange</option>
                  <option value="flexmount">Flexmount</option>
                  <option value="horizontal">Horizontal</option>
                  <option value="vertical">Vertical</option>
               </select>
            </div>
         </div>
      </div>  

      <?php

      $output .= '<div class="indent-lightgrey-bkg">';
      $output .= '<div class="table-responsive">';
      $output .= '<table class="ferrofluid-table table table-striped">';
      $output .= '<thead>';
      $output .= '<tr id="prodTableHead">';
      $output .= '  <th>Image</th> ';
      $output .= '  <th>Part No</th> ';
      /*$output .= '  <th>Description</th> ';*/
      $output .= '  <th>Target Diameter</th> ';
      $output .= '  <th>Mount</th> ';
      $output .= '  <th>Specification</th> ';
      $output .= '</tr>';
      $output .= '</thead>';
      $output .= '<tbody>';
      foreach ($q as $pid ){
          $_product = $_pf->get_product($pid);
          $target_size = explode('"', $_product->get_attribute('target-diameter') );
          $mount = $_product->get_attribute('mount');
          $output .= '<tr class="product-listing listing-row" data-mount="' . sanitize_title_with_dashes( $mount ) . '" data-size="' . $target_size[0] . '">';
          $output .= '    <td>' . get_the_post_thumbnail($pid, 'thumbnail') . '</td>';
          $output .= '    <td>' . $_product->get_sku() . '</td>';
          /*$output .= '    <td>' . get_the_title($pid) . '</td>';*/
          $output .= '    <td>' . $_product->get_attribute('target-diameter') . '</td>';
          $output .= '    <td>' . $mount . '</td>';
          $output .= '    <td><a href="' . get_the_permalink($pid) . '" class="btn btn-default">View Details</a> </td>';
          $output .= '</tr>';
      }
      $output .= '</tbody>';
      $output .= '</table>';
      $output .= '</div></div>';
    }

  echo $output;
  ?>
</div>
