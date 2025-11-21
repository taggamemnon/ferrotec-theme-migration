<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

$p = get_post( get_option( 'woocommerce_shop_page_id' ) );
$content = $p->post_content;
$content = apply_filters('the_content', $content);

$banner_styles = "";
$banner_class = ".bnr-" . get_post_field( 'post_name', $p );
if ( !get_field('disable_page_banner', $p ) ) : 
   if (get_field('mobile_banner_image', $p )){
      $banner_styles .= $banner_class ." { background-image:url( " . get_field('mobile_banner_image', $p) . " ); }";
      $banner_styles .= "@media(min-width:768px){";
   }
   if (get_field('banner_image', $p))
      $banner_styles .= $banner_class ." { background-image:url( " . get_field('banner_image', $p) . " ); }";
   if (get_field('mobile_banner_image', $p))
      $banner_styles .= "}";

   if (get_field('banner_color', $p))
      $banner_styles .= $banner_class ." { background-color: " . get_field('banner_color', $p) . "; }";
   if (get_field('text_color')) {
      $banner_styles .= $banner_class ." { color: " . get_field('text_color', $p) . "; }";
      $banner_styles .= $banner_class ." h1 { color: " . get_field('text_color', $p) . "; }";
   }
   ?>
   <style>
   <?php echo $banner_styles; ?>
   </style>

   <header class="page-header bnr-<?php echo get_post_field( 'post_name' ) ?>">
         <div class="page-banner" >
            <div class="container">
               <div class="background-product"></div>
               <div class="flex-area-center">
                  <?php if (get_field('banner_text', $p ) ): ?>
                     <?php the_field('banner_text', $p ); ?>
                  <?php else : ?>
                     <h1><?php echo get_the_title( $p ) ?></h1>          
                  <?php endif ?>
               </div>
            </div>
         </div>
   </header>
   <?php
endif;
//get_template_part('banner', 'page'); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
   <div class="entry-content">
         <div class="container-wrapper content-padding">
            <div class="container">
               <?php
               if ( function_exists('yoast_breadcrumb') ) {
                 yoast_breadcrumb( '<p id="breadcrumbs" class="text-right">','</p>' );
               }
               ?>

      <?php echo $content;
      ?>
            </div>
         </div>
   </div>
   <!-- .entry-content -->
   <?php if (have_rows('rows', $p)): ?>
 
      <?php while (have_rows('rows', $p)): the_row($p);
         // vars
         $content  = get_sub_field( 'content' );
         $bk_color = get_sub_field('background-color');
         $bk_class = get_sub_field('background-class');
         ?>
         <div class="container-wrapper content-padding <?php echo $bk_class ?>" <?php if ($bk_color) {
            echo 'style="background-color:' . $bk_color . '"';
         } ?> >
            <div class="container">
               <?php echo $content; ?>
            </div>
         </div>
      <?php endwhile; ?>

      </ul>

   <?php endif; ?>

</article>
<?php



get_footer( 'shop' );
