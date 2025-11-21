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
	<h3><?php echo esc_html( $heading ); ?></h3>
<?php endif; ?>
<div class="row py-5">
	<div class="col-sm-8">
		<?php the_content(); ?>

	</div>
                <div class="col-sm-4">
                  <?php the_post_thumbnail( 'full' ); ?>
                </div>
</div>

<?php 

/* hook: ft_display_product_specs provide array of args to make the specs table
*
* product:  product ID
* attribute_list array of desired attribute slugs, will use all visible attributes if not supplied
* table_head : the title of the table output
  */
//do_action( 'ft_display_product_specs', array( 'product' => $product , 'table_head' => 'General Specifications' ) );

?>
<div class="row py-5">
	<div class="col-sm-4">
		<h3>Specifications</h3>
<?php
 	
// Get the product attribute value(s)
$tables = $product->get_attribute('at-3');

// if product has attribute 'pa_color' value(s)
if( ! empty( $tables ) ){

/* hook: ft_display_product_specs provide array of args to make the specs table
*
* product:  product ID
* attribute_list array of desired attribute slugs, will use all visible attributes if not supplied
* table_head : the title of the table output 
  */
$pnum = $product->get_sku();

$general = array( 
	'frequency',
	'output-power',
	'forward-power-metering',
	'output-power-stability',
	'harmonics',
	'input-power',
	'output-connector',
	'interface-connectors',
	'metering',
	'cooling',
	'dimensions',
	'weight'
);

$mc2 = array( 
	'mc2inputpower',
	'mc2dimensions',
	'mc2ioconnections'
);

$at3 = array( 
	'at-3',
	'at3dimensions',
	'at3cooling',
	'at3tuningrange',
	'at3rfconn'
);

do_action( 'ft_display_product_specs', array( 'product' => $product , 'attribute_list' => $general, 'table_head' => $pnum . ' RF Generator Specifications' ) );
echo "<h3>MC-2 Control Panel Specifications</h3>";

do_action( 'ft_display_product_specs', array( 'product' => $product , 'attribute_list' => $mc2, 'table_head' => 'MC-2 Control Panel Specifications' ) );
echo "<h3>AT Match Network Specifications</h3>";

do_action( 'ft_display_product_specs', array( 'product' => $product , 'attribute_list' => $at3, 'table_head' => 'AT Match Network Specifications' ) );

} else {
 do_action( 'woocommerce_product_additional_information', $product ); 

}
    // No product attribute is set for this product


?>

	</div>
                <div class="col-sm-8">
		<?php
		    $attachment_ids = $product->get_gallery_image_ids();

		    foreach( $attachment_ids as $attachment_id ) {
		    	?>
		    	<img src="<?php echo $image_link = wp_get_attachment_image_url( $attachment_id ,'full' ); ?>" />
		    	<?php
		        
		    }

			 ?>
                </div>
</div>
