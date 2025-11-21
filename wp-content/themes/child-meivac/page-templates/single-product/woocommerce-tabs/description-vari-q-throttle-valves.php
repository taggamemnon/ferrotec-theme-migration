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
<?php if ( $heading ) : ?>
  <h3><?php echo esc_html( $heading ); ?></h3>
<?php endif; ?>
            <div class="row">
               <div class="col-sm-8">
                  <p>Ferrotec’s MeiVac Vari-Q throttle valve model <?php echo $pid; ?> is part of the <?php echo $product->get_attribute('pa_flange'); ?> series. The <?php echo $pid ?> features <?php echo preg_match('/^[aeiou]/i', $product->get_attribute('pa_material') ) ? 'an ': 'a '; echo $product->get_attribute('pa_material'); ?> flange<?php if ( $product->get_attribute('pa_coating') != 'N/A' ): ?>  with <?php echo preg_match('/^[aeiou]/i', $product->get_attribute('pa_coating') ) ? 'an ': 'a '; echo $product->get_attribute('pa_coating'); ?> finish <?php endif; ?>.
                     <?php
                        switch ( $product->get_attribute('pa_actuation') ) {
                            case 'Pneumatically':
                                echo "The " . $pid . " is Pneumatically Actuated.";
                                break;
                            case 'Servomotor':
                                echo "The " . $pid . " is configured for servo-motor control.";
                                break;
                            case 'On-valve controller':
                                echo "The " . $pid . " features an on-valve controller.";
                                break;
                        }
                        ?>
                      <?php 

                      $vq_general = array( 'pa_flange', 'pa_material', 'pa_coating', 'pa_actuation' );

                      do_action( 'ft_display_product_specs', array( 'product' => $product , 'attribute_list' => $vq_general, 'table_head' => 'General Specifications' ) );

                       ?>
               </div>
                <div class="col-sm-4">
                  <img src="<?php echo wp_get_attachment_image_url( $product->get_image_id() ); ?>" alt="<?php echo get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true ); ?>" />
                </div>
            </div>
            <div class="row py-5">
              <div class="col" style="display: flex; align-items: center; justify-content: center;">
                <?php
                    $attachment_ids = $product->get_gallery_image_ids();

                    foreach( $attachment_ids as $attachment_id ) {
                      ?>
                      <img src="<?php echo $image_link = wp_get_attachment_image_url( $attachment_id ); ?>" />
                      <?php
                        
                    }

                   ?>
              </div>
            </div>
            <div class="row space-above-block">
               <div class="col-sm-12">
<?php 

$vq_specifications = array( 'o-d', 'i-d', 't', 'a', 'n', 'h', 'd','o-ring' );

do_action( 'ft_display_product_specs', array( 'product' => $product , 'attribute_list' => $vq_specifications, 'table_head' => $pid . ' Specifications' ) );

 ?>
               </div>
            </div>
         









