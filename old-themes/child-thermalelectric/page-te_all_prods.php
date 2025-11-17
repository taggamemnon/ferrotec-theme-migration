<?php
/*
 *   Template Name: Thermoelectric All Models Page
 *
 * @package thermal
 */

get_header(); ?>

<div id="primary" class="content-area">
  <main id="main" class="site-main" role="main">

    <?php while (have_posts()) : the_post(); ?>
      <?php get_template_part('content', 'page'); ?>

    <?php endwhile; // end of the loop. ?>
<?php
  $query   = new WP_Query(
    array(
      'post_type'      => 'product',
      //'orderby'        => 'title',
      //'order'          => 'ASC',
      'posts_per_page' => -1
    )
  );
  if ($query->have_posts()) : 
    ?>
    <div class="container">
       <div class="table-responsive">
         <table id="listing" class="tablesorter table table-striped {sortlist: [[1,0],[2,0]]}" width="100%" border="0" cellpadding="0" cellspacing="0">
           <thead>
             <tr id="prodTableHead">
               <th>Model Number</th> 
               <th>I Max</th> 
               <th>V Max</th> 
               <th>&Delta;T Max</th> 
               <th>Qc Max</th> 
               <th>Base W</th> 
               <th>Base L</th> 
               <th>Top W</th> 
               <th>Top L</th> 
               <th>Height</th> 
               <th>Type</th> 
               <th>Category</th> 
             </tr>
           </thead>
           <tbody>
    <?php
    while ($query->have_posts()) : $query->the_post(); ?>

             <tr class="product-listing">
               <td><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></td>
               <td><?php the_field('iMax') ?></td>
               <td><?php the_field('vMax') ?></td>
               <td><?php the_field('tMax') ?></td>
               <td><?php the_field('qcMax') ?></td>
               <td><?php the_field('baseW') ?></td>
               <td><?php the_field('baseL') ?></td>
               <td><?php the_field('topW') ?></td>
               <td><?php the_field('topL') ?></td>
               <td><?php the_field('hDim') ?></td>
               <td><?php the_field('altDescription') ?></td>
               <td><?php the_terms( get_the_ID(), 'product_cat') ?></td>
             </tr>
   <?php
    endwhile; ?>
           </tbody>
         </table>
       </div>
    </div>

    <?php
  endif;
  wp_reset_postdata();
?>
<div class="container">
                <p><img decoding="async" src="/wp-content/uploads/sites/4/te-miniDimBTLW.png" mce_src="/wp-content/uploads/sites/4/te-miniDimBTLW.png"></p>       </div>
                <div class="container-wrapper content-padding ">
        <div class="container">
          <div class="indent-lightgrey-bkg">
   <div class="row">
      <div class="col-sm-12">
        <h3>Technical Terms</h3>
        <p>The terms below are used in tables at THot=50°C:</p>
      </div>
   </div>
<div class="row">
</div>
<div class="row">
   <div class="col-sm-2">
      <p><strong>I Max</strong></p>
      <p>Maximum input current in amperes at Qc=0 and ΔT Max</p>
   </div>
   <div class="col-sm-2">
      <p><strong>VMax</strong></p>
      <p> Maximum DC input voltage in volts at Qc=0 and IMax</p>
   </div>
   <div class="col-sm-2">
      <p><strong>ΔT Max</strong></p>
      <p>Maximum temperature differential in °C at Qc=0 and Imax</p>
   </div>
   <div class="col-sm-2">
      <p><strong>QcMax</strong></p>
      <p>Maximum heat pumping capacity in watts at IMax and ΔT=0</p>
   </div>
   <div class="col-sm-2">
      <p><strong>THot</strong></p>
      <p>Temperature of the TEC hot side during operation</p>
   </div>
   <div class="col-sm-2">
      <p><strong>View the Thermoelelectric Resource Guide</strong></p>
      <a href="/technology/thermoelectric-reference-guide/" class="btn btn-default btn-sm">View<span class="glyphicon glyphicon-arrow-right"></span></a>
   </div>
</div>
        </div>
      </div>
      </div>
<div class="container-wrapper content-padding bkg-lr-paper">
        <div class="container">
             <div class="row">
                <div class="col-sm-9">
                   <h3>Technical Questions?</h3>
                <p>Ferrotec’s Thermoelectric Reference Guide is a helpful resource.</p>
                   <p><a href="/technology/thermoelectric-reference-guide/" class="btn btn-default">Contact Sales</a></p>
                </div>
                <div class="col-sm-3 img-education"><img src="/wp-content/uploads/sites/4/icon-thermal-ref-guide.png" height="150"></div>
             </div>
        </div>
</div>
<div class="container-wrapper content-padding bkg-lr-penny2 cta-with-image">
        <div class="container">
          <div class="cta-full-height-img white">
   <h3>Do You Need More Information?</h3>
   <p>Contact your local Ferrotec thermal solutions representative.</p>
   <div class="row">
      <div class="col-sm-3"><a href="/contact-sales/" class="btn btn-default">Contact Sales</a></div>
   </div>
   <div class="cta-image" style="background-image:url(/wp-content/uploads/img-contact-sales-guy-min.png);"></div>
</div>
        </div>
      </div>
  </main>
  <!-- #main -->
</div><!-- #primary -->

<?php get_footer(); ?>
