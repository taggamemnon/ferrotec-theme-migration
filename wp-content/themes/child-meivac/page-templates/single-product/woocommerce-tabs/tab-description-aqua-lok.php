<?php
/**
 * Description tab
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/description.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 2.0.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

$heading = apply_filters( 'woocommerce_product_description_heading', __( 'Description', 'woocommerce' ) );

$pid = $product->get_sku();
?>
<!--div class="container-fluid"-->
<?php if ( $heading ) : ?>
  <h3><?php echo esc_html( $heading ); ?></h3>
<?php endif; ?>
            <div class="row">
               <div class="col-sm-8">
                <p>The AQUA-LOK Cryogenic Water Pump <?php echo $pid ?> is both energy & cost efficient, requiring less energy to cool down the head which translates into lower operational costs. The regen cycle is short and efficient with a built-in regeneration system controlled through rack mount controller with touchscreen.</p>


                        <?php //do_action( 'woocommerce_product_additional_information', $product ); ?>


<?php 

$general = array( 'flange' );

do_action( 'ft_display_product_specs', array( 'product' => $product , 'attribute_list' => $general, 'table_head' => 'General Specifications' ) );


 ?>
               </div>
                <div class="col-sm-4">
                  <?php the_post_thumbnail( 'full' ); ?>
                </div>
            </div>
            <div class="row py-5">
                <div class="col-12">

                    <h3 class="header_top-rule">Specifications</h3>
                </div>
                <div class="col-sm-4">
<?php 

$specifications = array( 'dimension', 'o-d', 'i-d', 't', 'a', 'n', 'h','d' );

do_action( 'ft_display_product_specs', array( 'product' => $product , 'attribute_list' => $specifications, 'table_head' => $pid . ' Specifications' ) );

 ?>
                </div>
              <div class="col-sm-8" style="display: flex; align-items: center; justify-content: center;">
            <?php 
                    $attachment_ids = $product->get_gallery_image_ids();
                    if ($attachment_ids ):
            ?>            

                <?php
                    foreach( $attachment_ids as $attachment_id ) {
                      ?>
                      <!--img src="<?php echo $image_link = wp_get_attachment_image_url( $attachment_id ); ?>" /-->
                      <?php
                                  echo wp_get_attachment_image($attachment_id, 'full');
                    }

                   ?>
              </div>
            </div>
            <?php 
              endif;
            ?>









<!--/div-->