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
       foreach ($q as $pid ){
          $_product = $_pf->get_product($pid); ?>
          <div class="col-sm-12">
                <div class="row offerWrapper constrain display-flex-center" style="background-image:url( <?php echo get_the_post_thumbnail_url($pid, 'medium'); ?>); margin-bottom:40px;">
                   <div class="col-sm-10 ">
                      <h3 class="nu-name"><?php echo get_the_title($pid); ?></h3>
                      <p class="nu-descriptor">Part Number: <?php echo $_product->get_sku(); ?></p>
                   </div>
                   <div class="col-sm-2 ">
                      <p>
                         <a href="<?php echo get_the_permalink($pid) ?>" class="btn btn-default">Product Details</a>
                      </p>
                   </div>
                </div>
             </div>

          <?php
      } 

    }
