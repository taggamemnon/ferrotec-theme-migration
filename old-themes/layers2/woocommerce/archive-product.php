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
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header( 'shop' );
$site_id = get_current_blog_id();
if ($site_id == 2){
//   get_header(); 
//   require_once('includes/ferrotec_products.php');
   //$results = new fProducts;
     //$pline_set_data = $results->get_vfproduct_data('all','all','all-all','all','all','all');
   ?>
<?php if ( have_posts() ) : ?>
<header class="page-header"><div class="page-banner"><div class="container"><div class="background-product"></div><div class="flex-area-center"><h1>Standard Ferrofluidic<br> Feedthroughs</h1></div></div></div></header>
<div class="container">
   <div class="row">
   <div class="col-sm-12">
      <h2>Select a Ferrofluidic Vacuum Rotary Feedthrough Matching Your Requirements</h2>
      <p>Ferrotec's Ferrofluidic&reg; vacuum rotary feedthroughs are the ultimate rotary sealing solution for vacuum environments. Choose from our complete line of standard parts. Click the graphic that best represents the type of feedthrough or seal you&rsquo;re looking for or use the filters to narrow your options and select from solid or hollow shaft, standard or water-cooled, and standard or reactive gas options. </p>
   </div>
</div>

   <form>
      <div class="indent-lightgrey-bkg">
         <div class="feedthrough-sort">
            <div class="vf-catalog-rowhead">
               <h3>Select Imperial, metric, or both</h3>
            </div>
            <a href="#in" class="btn btn-default listingbutton" data-vals=1>
            Inches
            </a>
            <a href="#mm" class="btn btn-default listingbutton" data-vals=0>
            Metric
            </a>
            <a href="#both" class="btn btn-default listingbutton active" data-vals="all">
            Both
            </a>
         </div>
         <div class="row vf-catalog-colheads">
            <div class="col-sm-3">
               <div class="drop_title">Shaft Type</div>
               <div class="drop_content">
                  <select name="shaftType" class="formElement" id="shaftType">
                     <option value="all">Select Shaft Type...</option>
                     <option value="1,6">Solid Shaft</option>
                     <option value="2">Hollow Shaft</option>
                     <option value="all">Show All Solid and Hollow options</option>
                  </select>
               </div>
            </div>
            <div class="col-sm-3">
               <div class="drop_title">Mount Type</div>
               <div class="drop_content">
                  <select name="mount" id="mount" class="formElement">
                     <option value="all">Select Mounting Type...</option>
                     <option value="8">Cartridge mount</option>
                     <option value="3,4,5,6,7,10">Flange mount</option>
                     <option value="1">Nose mount</option>
                     <option value="2">Nut mount</option>
                     <option value="9">Compliant</option>
                     <option value="all">Show All Mount options</option>
                  </select>
               </div>
            </div>
            <div class="col-sm-3">
               <div class="drop_title">Environment</div>
               <div class="drop_content">
                  <select name="environment" class="formElement" id="environment">
                     <option value="all">Filter by Environment</option>
                     <option value="2">Standard</option>
                     <option value="1">Reactive Gas</option>
                     <option value="all">Show All</option>
                  </select>
               </div>
            </div>
            <div class="col-sm-3">
               <div class="drop_title">Temperature</div>
               <div class="drop_content">
                  <select name="temperature" id="temperature" class="formElement">
                     <option value="all">Filter by Temperature</option>
                     <option value="0">Standard</option>
                     <option value="1">High-Temperature</option>
                     <option value="all">Show All</option>
                  </select>
               </div>
            </div>
         </div>
   </form>
   <div class="table-responsive">
   <table id="listing" class="tablesorter table" width="100%" border="0" cellpadding="0" cellspacing="0">
   <thead>
   <tr id="prodTableHead">
   <th>Appearance</th> 
   <th>Model Number</th> 
   <th>Part Number</th> 
   <th>Shaft Type</th> 
   <th>Shaft Dimension</th> 
   <th>Mounting Type</th> 
   <th>Fluid</th> 
   </tr>
   </thead>
   <tbody>
				<?php
$i = 0;

				 while ( have_posts() ) : the_post(); ?>
   <tr class="product-listing" style="background-color:white;" data-units="<?php the_field('unit'); ?>" data-shaft="<?php the_field('fk_shaftID') ?>" data-mounting="<?php the_field('fk_mountingID') ?>" data-environment="<?php the_field('fk_fluidID') ?>" data-temperature="<?php the_field('f2') ?>">
   <td><a href="/products/ferrofluidic-vacuum-rotary-feedthroughs/<?php the_field('pNum') ?>"><img src="/wp-content/uploads/sites/2/tmb-vf-<?php echo strtolower(get_field('pNum')) ?>.png" alt="Feedthrough Model <?php the_field('mNum') ?> (part number <?php the_field('pNum') ?>) image" width="72" height="72" border="0" /></a></td>
   <td class="vf-cat-row link"><a href="/products/ferrofluidic-vacuum-rotary-feedthroughs/<?php the_field('pNum') ?>"><?php the_field('mNum') ?></a></td>
   <td class="vf-cat-row"><?php  the_field('pNum'); ?></td>
   <td class="vf-cat-row"><?php echo $product->get_attribute( 'pa_shaft' ); ?></td>
   <td class="vf-cat-row"><?php the_field('d1') ?> <?php if ( get_field('unit') == 0) : ?>mm<?php else : ?>in<?php endif ?></td>
   <td class="vf-cat-row"><?php echo $product->get_attribute( 'pa_mounting' ); ?></td>
   <td class="vf-cat-row"><?php echo $product->get_attribute( 'pa_fluid' ); ?></td>
   </tr>

				<?php endwhile; // end of the loop. ?>


   </tbody>
   </table>
   </div>
   </div>
   <p class="hide">If you did not find the Feedthrough you were looking for you can either:</p>
   <ul class="hide">
      <li>Return to the standard feedthrough page and look for another <a href="/products/ferrofluidic-vacuum-rotary-feedthroughs/">Standard Feedthrough &raquo;</a></li>
      <li>Request a Quotation for a <a href="https://ferrotec.com/products/ferrofluidic/rfq/">Custom Product &raquo;</a></li>
   </ul>
</div>
<div class="bkg-lr-penny2">
   <div class="container">
      <?php
         $post_object = get_post( 389 );
         echo $post_object->post_content;
         ?>
   </div>
</div>
<?php endif; ?>

<?php get_footer( 'shop' ); 
}
else{
 ?>

	<?php
		/**
		 * woocommerce_before_main_content hook.
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 * @hooked WC_Structured_Data::generate_website_data() - 30
		 */
		do_action( 'woocommerce_before_main_content' );
	?>

    <header class="woocommerce-products-header">

		<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>

			<h1 class="woocommerce-products-header__title page-title"><?php woocommerce_page_title(); ?></h1>

		<?php endif; ?>

		<?php
			/**
			 * woocommerce_archive_description hook.
			 *
			 * @hooked woocommerce_taxonomy_archive_description - 10
			 * @hooked woocommerce_product_archive_description - 10
			 */
			do_action( 'woocommerce_archive_description' );
		?>

    </header>

		<?php if ( have_posts() ) : ?>

			<?php
				/**
				 * woocommerce_before_shop_loop hook.
				 *
				 * @hooked wc_print_notices - 10
				 * @hooked woocommerce_result_count - 20
				 * @hooked woocommerce_catalog_ordering - 30
				 */
				do_action( 'woocommerce_before_shop_loop' );
			?>

			<?php woocommerce_product_loop_start(); ?>

				<?php woocommerce_product_subcategories(); ?>

				<?php while ( have_posts() ) : the_post(); ?>

					<?php
						/**
						 * woocommerce_shop_loop hook.
						 *
						 * @hooked WC_Structured_Data::generate_product_data() - 10
						 */
						do_action( 'woocommerce_shop_loop' );
					?>

					<?php wc_get_template_part( 'content', 'product' ); ?>

				<?php endwhile; // end of the loop. ?>

			<?php woocommerce_product_loop_end(); ?>

			<?php
				/**
				 * woocommerce_after_shop_loop hook.
				 *
				 * @hooked woocommerce_pagination - 10
				 */
				do_action( 'woocommerce_after_shop_loop' );
			?>

		<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>

			<?php
				/**
				 * woocommerce_no_products_found hook.
				 *
				 * @hooked wc_no_products_found - 10
				 */
				do_action( 'woocommerce_no_products_found' );
			?>

		<?php endif; ?>

	<?php
		/**
		 * woocommerce_after_main_content hook.
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action( 'woocommerce_after_main_content' );
	?>

	<?php
		/**
		 * woocommerce_sidebar hook.
		 *
		 * @hooked woocommerce_get_sidebar - 10
		 */
		do_action( 'woocommerce_sidebar' );
	?>

<?php get_footer( 'shop' ); }?>
