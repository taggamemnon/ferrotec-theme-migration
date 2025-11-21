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
		<!--h3>Specifications</h3-->
</h3>
<?php 
$specs = array(
'size-category',
'stage',
'wafer-size',
'maximum-temperature',
'tc-position',
'dcrf-bias',
'oxygen-compatible',
'uhv-compatible'
);
//do_action( 'ft_display_product_specs', array( 'product' => $product , 'attribute_list' => $specs, 'table_head' => '//Dimensional Specifications' ) );
?>
		<!h3>Dimensional Specifications</h3>

<?php
$dim = array(
'dimension',
'a',
'b',
'c',
'd',
'e'
);
do_action( 'ft_display_product_specs', array( 'product' => $product , 'attribute_list' => $dim, 'table_head' => '//Dimensional Specifications' ) );
?>
		<h3>Operating Specifications (example at 1 atm pressure)</h3>

<?php
$op = array(
'temperature-uniformity',
'temperature-repeatability',
'ramp-time-to-600%cb%9ac',
'ramp-time-to-950%cb%9ac',
'cool-down-time-to-room-temp',
'max-current',
'max-voltage',
'heater-resistance-typical',
'power-supply'
);
do_action( 'ft_display_product_specs', array( 'product' => $product , 'attribute_list' => $op, 'table_head' => '//Dimensional Specifications' ) );


 ?>

<?php //do_action( 'woocommerce_product_additional_information', $product ); ?>

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
