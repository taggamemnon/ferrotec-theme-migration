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
       'meta_query' => array(
           'relation' => 'or',
           'units_info' => array(
               'key' => 'units',
               'compare' => 'EXISTS',
           ),
           'od_info' => array(
               'key' => ' vari-q_o-d',
               'type'    => 'NUMERIC',
               'compare' => 'EXISTS',
           ), 
       ),
       'orderby' => array( 
           'units_info' => 'ASC',
           'od_info' => 'ASC',
           'title' => 'ASC',
       ),

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
            <div class="drop_title">Flange Type</div>
            <div class="drop_content">
               <select name="flange" class="MVformElement" id="flange">
                  <option value="all">Select..</option>
                    <option value="ASA">ASA</option>
                    <option value="ISO">ISO</option>
                    <option value="CF">CF</option>
                    <option value="JIS">JIS</option>
                  </select>
            </div>
         </div>
         <div class="col-sm-3">
            <div class="drop_title">Flange Material</div>
            <div class="drop_content">
               <select name="material" id="material" class="MVformElement">
                  <option value="all">Select…</option>
                  <option value="aluminum">Aluminum</option>
                  <option value="stainless-steel">Stainless Steel</option>
               </select>
            </div>
         </div>
         <div class="col-sm-3">
            <div class="drop_title">Flange Coating</div>
            <div class="drop_content">
               <select name="coating" class="MVformElement" id="coating">
                  <option value="all">Select…</option>
                  <option value="clear-alodine">Clear Alodine</option>
                  <option value="hard-anodized">Hard Anodized</option>                  
               </select>
            </div>
         </div>
         <div class="col-sm-3">
            <div class="drop_title">Actuation</div>
            <div class="drop_content">
               <select name="actuation" id="actuation" class="MVformElement">
                  <option value="all">Select…</option>
                  <option value="pneumatically">Pneumatically</option>
                  <option value="servomotor">Servomotor</option>
                  <option value="on-valve-controller">On-valve controller</option>
               </select>
            </div>
         </div>
      </div>     <?php 
      $output .= '<div class="indent-lightgrey-bkg">';
      $output .= '<div class="table-responsive">';
      $output .= '<table id="listing" class="tablesorter meivac-table table table-striped">';
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
          $flange_type = explode ( ' ' , get_field('vari-q_flange', $pid) );
          $output .= '<tr class="product-listing listing-row" data-units="' . sanitize_title_with_dashes( get_field('units', $pid) ) . '" data-flange="' . $flange_type[1] . '" data-material="' . sanitize_title_with_dashes( get_field('vari-q_material', $pid) ) . '" data-coating="' . sanitize_title_with_dashes( get_field('vari-q_coating', $pid) ) . '" data-actuation="' . sanitize_title_with_dashes ( get_field('vari-q_actuation', $pid) ) . '" >';
          $output .= '    <td>'. get_the_post_thumbnail($pid, 'thumbnail').'</td>';
          $output .= '    <td>'. get_the_title($pid) . '</td>';
          $output .= '    <td>'. get_field('vari-q_o-d', $pid ) . ' ' . get_field('units', $pid ) .  '</td>';
          $output .= '    <td>'. get_field('vari-q_i-d', $pid ) . ' ' . get_field('units', $pid ) . '</td>';
          $output .= '    <td>'. get_field('vari-q_material', $pid ) . '/'. get_field('vari-q_coating', $pid ) . '</td>';
          $output .= '    <td>'. get_field('vari-q_actuation', $pid ) . '</td>';
          $output .= '    <td><a href="'. get_the_permalink( $pid ) . '" class="btn btn-default">View Details</a></td>';
          $output .= '</tr>';
      }
      $output .= '</tbody>';
      $output .= '</table>';
      $output .= '</div></div>';
      $output .= '<script src="' . get_stylesheet_directory_uri() . '/js/vari-q-listings.js"></script>';
    }

  echo $output;
?>
</div>
