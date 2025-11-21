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

$heading = apply_filters( 'woocommerce_product_ordering_heading', __( 'Ordering', 'woocommerce' ) );
?>
<?php if ( $heading ) : ?>
   <h3><?php echo esc_html( $heading ); ?></h3>
<?php endif; ?>
                        
                  <div class="row">
					<div class="col-sm-6">
		               <p><strong>Ordering Information for Model <?php echo $product->get_sku(); ?></strong></p>
		               <p>If you have questions about pricing and availability, need more information about Ferrotec’s MeiVac Vari-Q throttle valve model <?php echo $product->get_sku(); ?>, or if you have other requirements, you can submit your request using the form or <a href="/contact-us/component-sales/"><strong>contact your Ferrotec representative directly</strong></a>.</p>
		               
		               <p><strong>Please Contact Me Regarding Ferrotec Model Number <?php echo $product->get_sku(); ?></strong></p>
		               <p>Use this form to submit your <?php echo $product->get_sku(); ?> inquiry directly to Ferrotec. If you have special requirements or need specific customizations, please include the details in your description. </p>
		            </div>

                     <div class="col-sm-6">
                        <?php
                           gravity_form( 'meivac-inquiry', false, false, false, array( 'ferrotec_model_number' => get_field('mNum') ), false, true );
                            ?>
                     </div>
                  </div>
               
