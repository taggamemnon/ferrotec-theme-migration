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
$fields = get_fields();
?>
<?php if ( $heading ) : ?>
  <h3><?php echo esc_html( $heading ); ?></h3>
<?php endif; ?>
            <div class="row">
               <div class="col-sm-8">
                  <p>Ferrotec’s MeiVac Vari-Q throttle valve model <?php echo $pid; ?> is part of the <?php echo $fields['vari-q_flange']; ?> series. The <?php echo $pid ?> features <?php echo preg_match('/^[aeiou]/i', $fields['vari-q_material'] ) ? 'an ': 'a '; echo strtolower( $fields['vari-q_material'] ); ?> flange<?php if ( $fields['vari-q_coating'] != 'N/A' ): ?>  with <?php echo preg_match('/^[aeiou]/i', $fields['vari-q_coating'] ) ? 'an ': 'a '; echo strtolower( $fields['vari-q_coating'] ); ?> finish<?php endif; ?>.</p>
                     <?php
                        switch ( $fields['vari-q_actuation'] ) {
                            case 'Pneumatically':
                                echo "The " . $pid . " is pneumatically actuated.";
                                break;
                            case 'Servomotor':
                                echo "The " . $pid . " is configured for servomotor control.";
                                break;
                            case 'On-valve controller':
                                echo "The " . $pid . " features an on-valve controller.";
                                break;
                        }
                        ?>
                        <?php //do_action( 'woocommerce_product_additional_information', $product ); ?>
                        <h3>General Specifications</h3>
                    <table class="woocommerce-product-attributes shop_attributes">
                        <tbody>

                    <?php
                    $specs = array(
                        'vari-q_flange',
                        'vari-q_o-d',
                        'vari-q_i-d',
                        'vari-q_material',
                        'vari-q_coating',
                        'vari-q_actuation'
                    );
                        foreach( $specs as $spec){
                            $fo = get_field_object($spec); ?>
                        <tr class="woocommerce-product-attributes-item woocommerce-product-attributes-item--<?php echo $fo['name']?>">
                            <th class="woocommerce-product-attributes-item__label"><?php echo $fo['label']; ?></th>
                            <td class="woocommerce-product-attributes-item__value"><?php echo $fo['value']; ?></td>
                        </tr>
                            <?php
                        }
                    ?>
                    </tbody></table>
               </div>
                <div class="col-sm-4">
                  <?php the_post_thumbnail( 'full' ); ?>
                </div>
            </div>
            <div class="row py-5">
                <div class="col-sm-4">
                    <h3>Specifications</h3>
                    <table class="woocommerce-product-attributes shop_attributes">
                        <tbody>

                    <?php 
                    $specs = array(
                        'units',
                        'vari-q_t',
                        'vari-q_a',
                        'vari-q_n',
                        'vari-q_h',
                        'vari-q_d',
                        'vari-q_o-ring'
                    );
                        foreach( $specs as $spec){
                            $fo = get_field_object($spec); ?>
                        <tr class="woocommerce-product-attributes-item woocommerce-product-attributes-item--<?php echo $fo['name']?>">
                            <th class="woocommerce-product-attributes-item__label"><?php echo $fo['label']; ?></th>
                            <td class="woocommerce-product-attributes-item__value"><?php echo $fo['value']; ?></td>
                        </tr>
                            <?php
                        }
                    ?>
                    </tbody></table>
                </div>
              <div class="col-sm-8" style="display: flex; align-items: center; justify-content: center;">
            <?php 
                    $attachment_ids = $product->get_gallery_image_ids();
                    if ($attachment_ids ){
                    foreach( $attachment_ids as $attachment_id ) {
                      ?>
                      <img src="<?php echo $image_link = wp_get_attachment_image_url( $attachment_id ); ?>" />
                      <?php
                        
                    }

                    }

                   ?>

              </div>
            </div>
