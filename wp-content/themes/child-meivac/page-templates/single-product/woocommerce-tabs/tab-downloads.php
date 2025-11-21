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

?>

<?php if ( $heading ) : ?>
	<h2><?php echo esc_html( $heading ); ?></h2>
<?php endif; ?>

<?php   if ( is_user_logged_in() ) { 
			$uid = "user_" . get_current_user_id();
			if ( get_field('disable_download', $uid ) ) {
?>
			<div class="col-xs-12"><p>We noticed you’re downloading a lot of files. Please send an email to <a href="mailto:webmaster@ferrotec.com">webmaster@ferrotec.com</a> to restore access to the downloads.</p></div>
<?php
			}else{
	?>
   <div class="row">
               <div class="col-sm-12">
                  <h3>Available CAD Files</h3>
                  <div class="row">
                  <div class="col-md-6">
                  <div class="vf-downloads_wrapper">
                        <p style="text-align:left;">Part Number: <?php echo $product->get_sku() ?></p>
                     <a href="/meivac-site/drawings/<?php the_field('step_file'); ?>" download target="_blank">
                        <div style="width:100px; margin-left:15px; float:left; height:30px; line-height:30px; background-color:#ffffff; border:1px solid #cccccc;">
                           STP Format
                        </div>
                     </a>
                  </div>
                  </div>
                  </div>
                  </div>
   </div>

   
<?php }
  } else { ?>
   <div class="row">
                     <div class="col-sm-3">

                     <div class="vf-login_wrapper">
                     <h4>Login to Download Files</h4>

                      <?php wp_login_form( array('form_id' => 'vf-custom-login') ); ?>
                     </div>
                     </div>
                     <div class="col-sm-9">
                        <?php gravity_form( 2, true, true, false, '', true ); ?>
                     </div>
   </div>
<?php
} ?>
