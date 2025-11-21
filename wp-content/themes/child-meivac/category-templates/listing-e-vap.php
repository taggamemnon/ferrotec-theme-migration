<?php
if ( $args['category'] ) {
  $cat = $args['category'];
}
$terms = get_terms( array(
    'taxonomy' => 'product_tag',
    'orderby' => 'slug',
    'hide_empty' => true,
) );
?>
<?php 
  foreach ($terms as $term){
    $prods = new WP_Query (
      array(
        'post_type' => 'product',
        'tax_query' => array(
          'relation' => 'AND',
          array(
            'taxonomy' => 'product_tag',
            'field' => 'slug',
            'terms' => $term->slug,
          ),
          array(
            'taxonomy' => 'product_cat',
            'field' => 'slug',
            'terms' => $cat,
          )
        ),
        'nopaging' => 1,
        'meta_key' => '_sku',
          'orderby' => 'meta_value',
          'order'   => 'ASC',     
      )
    );
    if ( $prods->have_posts() ){ ?>
<div class="row evap-listing">
   <div class="col-sm-3">
    <img src="<?php the_field('category_image', $term) ?>" >
   </div>

   <div class="col-sm-9">
      <div class=" evap_product">
        <div class="row">
          <div class="col-12 evap_title">
            <?php echo $term->name; ?>
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

            <?php 
             
            // The Loop
            while ( $prods->have_posts() ) {
                $prods->the_post();
                    $pr = wc_get_product( get_the_id() );
                   ?>
                    <div class="row">
                      <div class="col-2"><div class="evap_spec"><?php echo $pr->get_sku() ?></div>
                      </div>
                      <div class="col-7"><div class="evap_spec"><?php the_title(); ?></div>
                      </div>
                      <div class="col-3"><div class="evap_spec"><a href="<?php the_permalink() ?>" class="btn btn-default">View Details</a></div>
                      </div>
                    </div>
            <?
            }
            wp_reset_query();
            ?>

       </div>
    </div>
</div>
<?php 
    }
}

