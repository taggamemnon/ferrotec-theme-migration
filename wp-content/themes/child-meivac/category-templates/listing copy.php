<?php
if ( $args['category'] ) {
  $cat = $args['category'];
}
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
        ?>
<?php 
      foreach ($q as $pid ){
          $_product = $_pf->get_product($pid);
       ?>
<div class="row evap-listing">
   <div class="col-sm-3">
      <?php echo get_the_post_thumbnail($pid, 'thumbnail') ?>
   </div>
   <div class="col-sm-9">
      <table class="meivac-specs">
         <thead>
            <tr>
               <td colspan="3"><?php echo get_the_title( $pid ); ?></td>
            </tr>
         </thead>
         <tbody>
            <tr class="col-heads">
               <td>Part Number</td>
               <td>Description </td>
               <td>Specifications </td>
            </tr>
            <tr>
               <td><?php echo $_product->get_sku() ?></td>
               <td><?php echo get_the_content( $pid ) ?></td>
               <td><a href="<?php echo get_the_permalink( $pid ) ?>" class="btn btn-default">View Details</a></td>
            </tr>
         </tbody>
      </table>
   </div>
</div>
<?php 
      }
    }

  echo $output;
