<?php
      global $product;
        /*
        Template part: Content of Ferrotec Seals products
        */
   
     ?>
<?php 
   if (get_field('unit') == 1) $displayUnit="in";
   else $displayUnit="mm"; ?>
<div id="primary" class="content-area seals-product">
<main id="main" class="site-main" role="main">
   <header class="page-header">
      <div class="page-banner" >
         <div class="container">
            <div class="background-product"></div>
            <div class="flex-area-center">
               <h1>Ferrofluidic Seals</h1>
            </div>
         </div>
      </div>
   </header>
   <article class="page">
      <div class="entry-content">
      </div>
      <!-- .entry-content -->
      <div class="container-wrapper content-padding ">
      <div class="container">
         <div class="col-sm-12">
            <h2>Feedthrough Model: <?php the_field('mNum'); ?><br> Part Number: <?php the_field('pNum'); ?></h2>
            <p>&nbsp;</p>
         </div>
         <div class="col-sm-12">
            <ul class="nav nav-tabs nav-product-tabs" role="tablist">
               <li role="presentation" <?php if($action=="")
                  { ?> class="active" <?php } ?>  >
                  <a href="#description" aria-controls="description" role="tab" data-toggle="tab">
                     <div class="visible-xs-inline-block tabicon icn-features"></div>
                     <div class="hidden-xs">Description</div>
                  </a>
               </li>
               <li role="presentation">
                  <a href="#specifications" aria-controls="specifications" role="tab" data-toggle="tab">
                     <div class="visible-xs-inline-block tabicon icn-specs"></div>
                     <div class="hidden-xs">Specifications</div>
                  </a>
               </li>
               <li role="presentation">
                  <a href="#ordering-info" aria-controls="ordering-info" role="tab" data-toggle="tab">
                     <div class="visible-xs-inline-block tabicon icn-ordering"></div>
                     <div class="hidden-xs">Ordering Info</div>
                  </a>
               </li>
               <li role="presentation" <?php if($action!="")
                  { ?> class="active" <?php } ?>>
                  <a href="#downloads" aria-controls="downloads" role="tab" data-toggle="tab">
                     <div class="visible-xs tabicon icn-downloads"></div>
                     <div class="hidden-xs">Downloads</div>
                  </a>
               </li>
            </ul>
            <div class="tab-content">
               <div role="tabpanel" class="tab-pane<?php if($action=="")
                  { ?> active <?php } ?>" id="description">
                  <h3>Product Description</h3>
                  <div class="row">
                     <div class="col-sm-6">
                        <p>Ferrotec&rsquo;s Ferrofluidic seal Feedthrough Model <?php the_field('mNum'); ?> (part number <?php the_field('pNum');  ?>) is a member of Ferrotec&rsquo;s <?php the_field('familyTitle'); $categories = get_the_terms($product->get_id(), 'product_cat' );                     
echo $categories[0]->name; 
 ?>s. The <?php the_field('mNum');  ?> vacuum rotary feedthrough uses Ferrotec&rsquo;s <?php if (get_field('fk_fluidID') == '2') : ?>standard hydrocarbon-based<?php endif ?><?php if (get_field('fk_fluidID') == '1') : ?>fluorocarbon-based<?php endif ?> ferrofluid, specifically optimized for introducing rotary motion with a magnetic liquid hermetic seal in most <?php echo $product->get_attribute( 'pa_fluid' );  ?> environments.</p>
                        <p>The <?php the_field('mNum');  ?> vacuum rotary feedthrough features a <?php echo $product->get_attribute( 'pa_shaft' );  ?> shaft with <?php echo $product->get_attribute( 'pa_mounting' );  ?> mounting. Dimensional details are specified below. <?php if (get_field('f2') == '1') : ?>This vacuum seal is also water-cooled for high-temperature applications.<?php endif ?> For precision measurement specifications, refer to the Spec Control Drawing.</p>
                        <p><strong>Ferrotec Part Number <?php the_field('pNum');  ?> Dimension Specification Drawing</strong></p>
                        <a href="/wp-content/uploads/sites/2/diag-vf-<?php the_field('pNum'); ?>.jpg" title="Feedthrough Model <?php the_field('mNum')?> (part number <?php the_field('pNum');  ?>) dimensional specifications drawing"><img src="/wp-content/uploads/sites/2/diag-vf-<?php the_field('pNum'); ?>.jpg" alt="Feedthrough Model <?php the_field('mNum')?> (part number <?php the_field('pNum')?>) dimensional specifications drawing" width="386" height="306" border="0"></a> 
                     </div>
                     <div class="col-sm-6">
                        <p class="text-center"><img class="center-block" src="/wp-content/uploads/sites/2/img-vf-<?php the_field('pNum');  ?>.jpg" alt="Feedthrough Model <?php the_field('mNum');  ?> (part number <?php the_field('pNum');  ?>) image" style="width:60%;" border="0">  </p>
                     </div>
                  </div>
               </div>
               <div role="tabpanel" class="tab-pane" id="specifications">
                  <h3>Product Specifications</h3>
                  <p><strong>Specifications for Ferrotec Part Number <?php the_field('pNum');  ?></strong><br></p>
                  <div class="row">
                     <div class="col-sm-6">
                        <table class="table" width="100%" border="0" cellspacing="0" cellpadding="0">
                           <tbody>
                              <tr>
                                 <td width="40%">Shaft</td>
                                 <td width="60%"><?php echo $product->get_attribute( 'pa_shaft' );  ?>&nbsp;Shaft</td>
                              </tr>
                              <tr>
                                 <td>Shaft Support:</td>
                                 <td>
                                    <?php if (get_field('b1') == '1') : ?>Simply Supported (vac+atm sides) <br><?php endif ?>
                                    <?php if (get_field('b2') == '1') : ?>Cantilevered (both on atm side) <br><?php endif ?>
                                    <?php if (get_field('b3') == '1') : ?>Heavy Duty <br><?php endif ?>
                                 </td>
                              </tr>
                              <tr>
                                 <td>Ferrofluid</td>
                                 <td><?php echo $product->get_attribute( 'pa_fluid' );  ?></td>
                              </tr>
                              <tr>
                                 <td>Mounting</td>
                                 <td>
                                    <?php echo $product->get_attribute( 'pa_mounting' );  ?>
                                    <?php if (get_field('mntOpt') == '1') : ?><br>Mounting Nut and Washer Included <br><?php endif ?>
                                 </td>
                              </tr>
                              <?php if ( get_field('f1') == '1' || get_field('f2') == '1' || get_field('f3') == '1' || get_field('f4') == '1' || get_field('f5') == '1' ) : ?>
                              <tr>
                                 <td>Features:</td>
                                 <td>
                                    <?php if (get_field('f1') == '1') : ?>Sleeve <br><?php endif ?>
                                    <?php if (get_field('f2') == '1') : ?>Water-cooled <br><?php endif ?>
                                    <?php if (get_field('f3') == '1') : ?>Shaft Clamp <br><?php endif ?>
                                    <?php if (get_field('f4') == '1') : ?>Electrical Isolation (Sleeved Bore)" <br><?php endif ?>
                                    <?php if (get_field('f5') == '1') : ?>Number of Union Services <br><?php endif ?>
                                 </td>
                              </tr>
                              <?php endif ?>
                              <tr>
                                 <td colspan="2"><br>
                                    <strong>Dimensions:</strong>
                                 </td>
                              </tr>
                              <?php if (get_field('d45') != 0) : ?>
                              <tr>
                                 <td>Shaft (or bore) Diameter with tolerance</td>
                                 <td><?php the_field('d45');  ?>&nbsp;<?php if (get_field('d2') != 0) : ?>(<?php the_field('d2');  ?>)<?php endif ?> <?php echo $displayUnit ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if (get_field('d3') != 0) : ?>
                              <tr>
                                 <td>Shaft termination</td>
                                 <td><?php the_field('d3');  ?>&nbsp;<?php echo $displayUnit ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if (get_field('d4') != 0) : ?>
                              <tr>
                                 <td>Shaft extension (Vac)</td>
                                 <td><?php the_field('d4'); ?>&nbsp;<?php echo $displayUnit ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if (get_field('d5') >= '1') : ?>
                              <tr>
                                 <td>Overall length</td>
                                 <td><?php the_field('d5'); ?>&nbsp;<?php echo $displayUnit ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if (get_field('d6') != 0) : ?>
                              <tr>
                                 <td>Housing overall length</td>
                                 <td><?php the_field('d6'); ?>&nbsp;<?php echo $displayUnit ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if (get_field('d7') != 0) : ?>
                              <tr>
                                 <td>Housing diameter</td>
                                 <td><?php the_field('d7'); ?>&nbsp;<?php if (get_field('d8') != 0) : ?>(<?php the_field('d8');  ?>)<?php endif ?> <?php echo $displayUnit ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if (get_field('d9') != 0) : ?>
                              <tr>
                                 <td>Body length</td>
                                 <td><?php the_field('d9'); ?>&nbsp;<?php echo $displayUnit ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if (get_field('d10') != 0) : ?>
                              <tr>
                                 <td>Thread diameter</td>
                                 <td><?php the_field('d10'); ?>&nbsp;<?php echo $displayUnit ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if (get_field('d11') != 0) : ?>
                              <tr>
                                 <td>Thread pitch [tps] or [mm/thd] (metric)</td>
                                 <td><?php the_field('d11'); ?>&nbsp;<?php if (get_field('unit') == '1'): ?>[tps]<?php else : ?>[mm/thd]<?php endif ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if (get_field('d12') != 0) : ?>
                              <tr>
                                 <td>Thread length</td>
                                 <td><?php the_field('d12'); ?>&nbsp;<?php echo $displayUnit ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if (get_field('d13') != 0) : ?>
                              <tr>
                                 <td>Clamp diameter</td>
                                 <td><?php the_field('d13'); ?>&nbsp;<?php echo $displayUnit ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if (get_field('d14') != 0) : ?>
                              <tr>
                                 <td>Clamp thickness</td>
                                 <td><?php the_field('d14'); ?>&nbsp;<?php echo $displayUnit ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if (get_field('d15') != 0) : ?>
                              <tr>
                                 <td>Recommended shaft diameter</td>
                                 <td><?php the_field('d15'); ?>&nbsp;<?php if (get_field('d16') != 0) : ?>(<?php the_field('d16');  ?>) <?php echo $displayUnit ?><?php endif ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if (get_field('d17') != 0) : ?>
                              <tr>
                                 <td>Recommended mounting bore</td>
                                 <td><?php the_field('d17'); ?>&nbsp;<?php if (get_field('d18') != 0) : ?>(<?php the_field('d18');  ?>) <?php echo $displayUnit ?><?php endif ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if (get_field('d19') != 0) : ?>
                              <tr>
                                 <td>Flange diameter</td>
                                 <td><?php the_field('d19'); ?>&nbsp;<?php echo $displayUnit ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if (get_field('d20') != 0) : ?>
                              <tr>
                                 <td>Flange thickness</td>
                                 <td><?php the_field('d20'); ?>&nbsp;<?php echo $displayUnit ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if (get_field('d21') != 0) : ?>
                              <tr>
                                 <td>Flange wrench flat</td>
                                 <td><?php the_field('d21'); ?>&nbsp;<?php echo $displayUnit ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if (get_field('d22') != 0) : ?>
                              <tr>
                                 <td>Fitting locations</td>
                                 <td><?php the_field('d22'); ?>&nbsp;<?php echo $displayUnit ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if (get_field('d23') != 0) : ?>
                              <tr>
                                 <td>Mounting holes</td>
                                 <td><?php the_field('d23'); ?>&nbsp;<?php echo $displayUnit ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if (get_field('d38') != '') : ?>
                              <tr>
                                 <td>Flange Type</td>
                                 <td><?php the_field('d38');  ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if (get_field('d37') != 0) : ?>
                              <tr>
                                 <td>Face seal O-ring</td>
                                 <td><?php the_field('d37');  ?></td>
                              </tr>
                              <?php endif ?>
                           </tbody>
                        </table>
                     </div>
                     <div class="col-sm-6">
                        <table class="table" width="100%" border="0" cellspacing="0" cellpadding="0">
                           <tbody>
                              <tr>
                                 <td colspan="2"><br>
                                    <strong>Bearing Specifications:</strong>
                                 </td>
                              </tr>
                              <?php if (get_field('d25') != '') : ?>
                              <tr>
                                 <td>Bearing type/material</td>
                                 <td><?php the_field('d25');  ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if (get_field('d26') != 0) : ?>
                              <tr>
                                 <td>Bearing load cap</td>
                                 <td><?php the_field('d26');  ?> <?php if (get_field('unit') == '1') : ?>Pounds<?php else : ?>Kilograms<?php endif ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if (get_field('d27') != 0) : ?>
                              <tr>
                                 <td>Bearing dynamic load capacity</td>
                                 <td><?php the_field('d27');  ?> <?php if (get_field('unit') == '1') : ?>Pounds<?php else : ?>Kilograms<?php endif ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if (get_field('d28') != 0) : ?>
                              <tr>
                                 <td>Bearing Dim A</td>
                                 <td><?php the_field('d28');  ?>&nbsp;<?php echo $displayUnit ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if (get_field('d29') != 0) : ?>
                              <tr>
                                 <td>Bearing Dim B</td>
                                 <td><?php the_field('d29');  ?>&nbsp;<?php echo $displayUnit ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if (get_field('fk_shaftID') == '1') : ?>
                              <tr>
                                 <td colspan="2"><a href="/wp-content/uploads/sites/2/sldBearingDim.jpg" title="Solid Shaft bearing dimensional specifications reference drawing"><img src="/wp-content/uploads/sites/2/sldBearingDim.jpg" alt="Solid Shaft bearing dimensional specifications reference drawing" width="210" height="167" border="0" /></a> <br></td>
                              </tr>
                              <?php endif ?>
                              <?php if (get_field('fk_shaftID') == '2') : ?>
                              <tr>
                                 <td colspan="2"><a href="/wp-content/uploads/sites/2/hlwBearingDim.jpg" title="Hollow Shaft bearing dimensional specifications reference drawing"><img src="/wp-content/uploads/sites/2/hlwBearingDim.jpg" alt="Hollow Shaft bearing dimensional specifications reference drawing" width="210" height="167" border="0" /></a> <br></td>
                              </tr>
                              <?php endif ?>
                              <tr>
                                 <td colspan="2"><br>
                                    <strong>Performance Characteristics:</strong>
                                 </td>
                              </tr>
                              <?php if (get_field('d30') != 0) : ?>
                              <tr>
                                 <td>Max Speed</td>
                                 <td><?php the_field('d30');  ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if (get_field('d31') != 0) : ?>
                              <tr>
                                 <td>Max Thrust (Axial Load Limit)</td>
                                 <td><?php the_field('d31');  ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if (get_field('d32') != 0) : ?>
                              <tr>
                                 <td>Radial Load Capacity</td>
                                 <td><?php the_field('d32');  ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if (get_field('d24') != 0) : ?>
                              <tr>
                                 <td>Shaft Torque Capacity</td>
                                 <td><?php the_field('d24');  ?> <?php if (get_field('unit') == '1') : ?>in-lb<?php else : ?>N-m<?php endif ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if (get_field('d40') != 0) : ?>
                              <tr>
                                 <td>Starting Torque 100rpm <sup>*</sup></td>
                                 <td><?php the_field('d40');  ?>&nbsp;<?php if (get_field('unit') == '1') : ?>in-oz<?php else : ?>N-mm<?php endif ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if (get_field('d41') != 0) : ?>
                              <tr>
                                 <td>Running Torque 100rpm <sup>**</sup></td>
                                 <td><?php the_field('d41');  ?>&nbsp;<?php if (get_field('unit') == '1') : ?>in-oz<?php else : ?>N-mm<?php endif ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if (get_field('d42') != 0) : ?>
                              <tr>
                                 <td>Starting Torque 1000rpm <sup>*</sup></td>
                                 <td><?php the_field('d42');  ?>&nbsp;<?php if (get_field('unit') == '1') : ?>in-oz<?php else : ?>N-mm<?php endif ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if (get_field('d43') != 0) : ?>
                              <tr>
                                 <td>Running Torque 1000rpm <sup>**</sup></td>
                                 <td><?php the_field('d43');  ?>&nbsp;<?php if (get_field('unit') == '1') : ?>in-oz<?php else : ?>N-mm<?php endif ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if (get_field('d34') != 0) : ?>
                              <tr>
                                 <td>Starting Torque</td>
                                 <td><?php the_field('d34');  ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if (get_field('d35') != 0) : ?>
                              <tr>
                                 <td>Running Torque</td>
                                 <td><?php the_field('d35');  ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if (get_field('d36') != 0) : ?>
                              <tr>
                                 <td>Limiting Speed [rpm]<?php if (get_field('f2') == '1') : ?> <sup>***</sup><?php endif ?></td>
                                 <td><?php the_field('d36');  ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if (get_field('d39') != '') : ?>
                              <tr>
                                 <td>Notes</td>
                                 <td><?php the_field('d39');  ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if (get_field('nS') == '1') : ?>
                              <tr>
                                 <td>Availability:</td>
                                 <td>Normally in stock.</td>
                              </tr>
                              <?php endif ?>
                              <tr>
                                 <td colspan="2"><strong>Note: </strong><br>
                              <?php if ( get_field('d40') != 0 || get_field('d41') != 0 || get_field('d42') != 0 || get_field('d43') != 0) : ?>
                                       <?php if ( get_field('d40') != 0 || get_field('d42') != 0 ) : ?>
                                          <p class="note" id=><sup>*</sup> See the Drag Torque section of the <a href="https://seals.ferrotec.com/ordering-guide/seal-requirements/#drag-torque">Determining your Requirements</a> page for the definition of starting torque</p>
                                       <?php endif ?>
                                       <?php if ( get_field('d41') != 0 || get_field('d43') != 0 ) : ?>
                                          <p class="note" id="note2"><sup>**</sup> Values are for a feedthrough at room temperature. Under continuous rotation the unit will warm-up, and the running torque will decrease.</p>
                                       <?php endif ?>
                              <?php endif ?>
                              <?php if (get_field('f2') == '1') : ?><p class="note" id="note3"><sup>***</sup> Water cooling may permit significantly higher speed. Consult your Field Engineer.</p><?php endif ?>
                                    General vacuum seal specifications can be found on <a href="https://seals.ferrotec.com/ordering-guide/common-specifications/">Ferrotec’s Standard Feedthrough Common Specifications page.</a><br>
                                    For an explanation of Ferrotec’s flange mounting terminology, consult <a href="https://seals.ferrotec.com/ordering-guide/flange-options/">Ferrotec’s Flange Mount Options page.</a>
                                 </td>
                              </tr>
                           </tbody>
                        </table>
                     </div>
                  </div>
               </div>
               <div role="tabpanel" class="tab-pane" id="ordering-info">
                  <div class="row">
                     <div class="col-sm-6">
                        <p><strong>Ordering Information for Model <?php the_field('mNum');  ?>, Part Number <?php the_field('pNum');  ?></strong></p>
                        <p>If you have questions about pricing and availability, need more information about Ferrotec's <?php the_field('mNum'); ?> rotary feedthroughs, or if you have other Ferrofluidic seal requirements, you can submit your request using the form below or <a href="/contact/sales/salesFerrofluidic/"><strong>contact your Ferrotec representative directly&nbsp;&raquo;</strong></a></p>
                        <p><strong>Special Orders, Modifications, and Customized Solutions for Unique Applications</strong></p>
                        <p>Model <?php the_field('mNum');  ?>, Part Number <?php the_field('pNum');  ?> is a standard model vacuum rotary feedthrough. Ferrotec can also customize a <?php echo $product->get_attribute( 'pa_shaft' );  ?> shaft vacuum rotary feedthrough to match your specific application requirements. Please contact Ferrotec for more information.</p>
                        <p><strong>Please Contact Me Regarding Ferrotec Model Number <?php the_field('mNum');  ?></strong></p>
                        <p>Use this form to submit your <?php the_field('mNum');  ?> (part number <?php the_field('pNum');  ?>) inquiry directly to Ferrotec. If you have special requirements or need specific customizations, please include the details in your description. </p>
                     </div>
                     <div class="col-sm-6">
                        <?php
                           gravity_form( 'vf-inquiry', false, false, false, array( 'ferrotec_model_number' => get_field('mNum') ), false, true );
                            ?>
                     </div>
                  </div>
               </div>
               <div role="tabpanel" class="tab-pane" id="downloads">
                  <div class="row">
                        
<?php   if ( is_user_logged_in() ) { 
			$uid = "user_" . get_current_user_id();
			if ( get_field('disable_download', $uid ) ) {
?>
			<div class="col-xs-12"><p>We noticed you’re downloading a lot of files. Please send an email to <a href="mailto:webmaster@ferrotec.com">webmaster@ferrotec.com</a> to restore access to the downloads.</p></div>
<?php
			}else{
	?>
               <div class="col-sm-12">
                  <h3>Available CAD Files</h3>
                  <div class="row">
                  <div class="col-md-6">
                  <div class="vf-downloads_wrapper">
                        <p style="text-align:left;">Feedthrough Model: <?php the_field('mNum'); ?><br> Part Number: <?php the_field('pNum'); ?></p>
                     <a href="/seals-site/product/drawing/2d_drawings/<?php the_field('pNum'); ?>.dxf">
                        <div style="width:100px; margin-left:15px; float:left; height:30px; line-height:30px; background-color:#ffffff; border:1px solid #cccccc;">
                           DXF Format
                        </div>
                     </a>
                     <a href="/seals-site/product/drawing/step_assemblies/<?php the_field('pNum'); ?>.stp">
                        <div style="width:100px; margin-left:20px; float:left; height:30px; line-height:30px; background-color:#ffffff; border:1px solid #cccccc;">
                           STP Format
                        </div>
                     </a>
                  </div>
                  </div>
                  </div>
                  </div>

   
<?php }
  } else { ?>
                     <div class="col-sm-3">

                     <div class="vf-login_wrapper">
                     <h4>Login to Download Files</h4>

                      <?php wp_login_form( array('form_id' => 'vf-custom-login') ); ?>
                     </div>
                     </div>
                     <div class="col-sm-9">
                        <?php gravity_form( 4, true, true, false, '', true ); ?>
                     </div>
<?php
} ?>

                     </div>
                  </div>
<!-- ******************************************************************** -->

<!-- ******************************************************************** -->
               

               </div>
               </div>
            </div>
         </div>
   </article>
</main>
<!-- #main -->
</div>
