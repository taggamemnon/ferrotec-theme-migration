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
        'order'   => 'desc',     
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
      <?php echo get_the_post_thumbnail($pid, 'medium') ?>
   </div>
   <div class="col-sm-9">
      <div class=" evap_product">
        <div class="row">
          <div class="col-12 evap_title">
            <?php echo get_the_title( $pid ); ?>
          </div>
        </div>
        <div class="row">
          <div class="col-2"><div class="evap_head">Part Number</div>
          </div>
          <div class="col-7"><div class="evap_head">Description</div>
          </div>
          <div class="col-3"><div class="evap_head">Specifications</div>
          </div>
        </div>
        <div class="row">
          <div class="col-2"><div class="evap_spec"><?php echo $_product->get_sku() ?></div>
          </div>
          <div class="col-7"><div class="evap_spec"><?php echo get_the_content( false, false, $pid ) ?></div>
          </div>
          <div class="col-3"><div class="evap_spec"><a href="<?php echo get_the_permalink( $pid ) ?>" class="btn btn-default">View Details</a></div>
          </div>
        </div>
      </div>
    </div>
   </div>

<?php 
      }
    }

  echo $output;
