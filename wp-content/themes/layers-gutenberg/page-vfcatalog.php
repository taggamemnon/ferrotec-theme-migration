<?php
   /*
      Template Name: Ferrofluidic Seal Catalog Page
      */
   get_header(); ?>
<?php
//   require_once('includes/ferrotec_products.php');
   //$results = new fProducts;
     //$pline_set_data = $results->get_vfproduct_data('all','all','all-all','all','all','all');
   ?>
<?php while (have_posts()) : the_post(); ?>
<?php get_template_part('content', 'page'); ?>
<?php
   // If comments are open or we have at least one comment, load up the comment template
   if (comments_open() || get_comments_number()) :
   	comments_template();
   endif;
   ?>
<?php endwhile; // end of the loop. ?>
<div class="container">
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

<?php  /* products loop */
$args = array(
   'post_type' => 'product',
   'nopaging' => TRUE,
   'tax_query' => array(
       array(
           'taxonomy' => 'product_visibility',
           'field'    => 'name',
           'terms'    => 'exclude-from-catalog',
           'operator' => 'NOT IN',
       ),
   ),
   'meta_key'        => 'pNum',
   'orderby'         => 'meta_value',
   'order'           => 'ASC'

);
$pline_set_data = new WP_Query( $args );
echo '<tr><td>'; 
echo count($pline_set_data->posts);
echo '</td></tr>';

if ( $pline_set_data->have_posts() ) {
   // The 2nd Loop
   while ( $pline_set_data->have_posts() ) {
      $pline_set_data->the_post(); ?>
   <tr class="product-listing" style="background-color:white;" data-units="<?php the_field('unit'); ?>" data-shaft="<?php the_field('fk_shaftID') ?>" data-mounting="<?php the_field('fk_mountingID') ?>" data-environment="<?php the_field('fk_fluidID') ?>" data-temperature="<?php the_field('f2') ?>">
   <td><a href="/products/ferrofluidic-vacuum-rotary-feedthroughs/<?php the_field('pNum') ?>"><img src="/wp-content/uploads/sites/2/tmb-vf-<?php echo strtolower(get_field('pNum')) ?>.png" alt="Feedthrough Model <?php the_field('mNum') ?> (part number <?php the_field('pNum') ?>) image" width="72" height="72" border="0" /></a></td>
   <td class="vf-cat-row link"><a href="/products/ferrofluidic-vacuum-rotary-feedthroughs/<?php the_field('pNum') ?>"><?php the_field('mNum') ?></a></td>
   <td class="vf-cat-row"><?php  the_field('pNum'); ?></td>
   <td class="vf-cat-row"><?php echo $product->get_attribute( 'pa_shaft' ); ?></td>
   <td class="vf-cat-row"><?php the_field('d1') ?> <?php if ( get_field('unit') == 0) : ?>mm<?php else : ?>in<?php endif ?></td>
   <td class="vf-cat-row"><?php echo $product->get_attribute( 'pa_mounting' ); ?></td>
   <td class="vf-cat-row"><?php echo $product->get_attribute( 'pa_fluid' ); ?></td>
   </tr>
<?php   }

   // Restore original Post Data
   wp_reset_postdata();
}


?>


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
<?php get_footer();