<?php
/*
   Template Name: Ferrofluid Catalog Page
   */
get_header(); ?>
<?php
require_once('includes/ferrotec_products.php');
$results = new fProducts;
$vfp_id = get_query_var( 'id', 'not found' ); 

  $pline_set_data = $results->get_ferrofluid_data( $vfp_id );
?>
<div class="container">
<table>
<thead>
<tr id="prodTableHead">
  <th>Ferrofluid Type</th> 
  <th>Gauss [CGS]</th> 
  <th>mT [SI]</th> 
  <th>cP [CGS]</th> 
  <th>mPa-s [SI]</th> 
</tr>
</thead>
<tbody>
<?php foreach ($pline_set_data as $product ): ?>
  <tr class="ferrofluid-listing">
      <td><a href=""><?php echo $product->model ?></a></td>
      <td ><?php echo $product->sat_Gauss ?></td>
      <td><?php echo $product->sat_mT ?></td>
      <td><?php echo $product->vis_cP ?></td>
      <td><?php echo $product->sat_mPa_s ?></td>
  </tr>
<?php endforeach ?>
</tbody>
</table>
</div>
<?php get_footer();
