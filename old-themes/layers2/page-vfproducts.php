<?php
      global $vfp_data;
        /*
        Template Name: Ferrofluidic Seal Product Page
        */
   
     ?>
<?php
   require_once('includes/ferrotec_products.php');
   $results = new fProducts;
   $vfp_id = get_query_var( 'id', 'not found' ); 
   $vfp_data = $results->get_vfproduct_detail_data($vfp_id);
     get_header('shop'); 
   ?>

<?php foreach ($vfp_data as $product ): ?>
<?php 
   if ($product->unit == 1) $displayUnit="in";
   else $displayUnit="mm"; ?>
<div id="primary" class="content-area">
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
   <article class="page type-page status-publish hentry">
      <div class="entry-content">
      </div>
      <!-- .entry-content -->
      <div class="container-wrapper content-padding ">
      <div class="container">
         <div class="col-sm-12">
            <h2>Feedthrough Model: <?php echo $product->mNum ?><br> Part Number: <?php echo $product->pNum ?></h2>
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
                  <h3>Product Description lalal</h3>

                  <div class="row">
                     <div class="col-sm-6">
                        <p>Ferrotec&rsquo;s Ferrofluidic seal Feedthrough Model <?php echo $product->mNum?> (part number <?php echo $product->pNum ?>) is a member of Ferrotec&rsquo;s <?php echo $product->familyTitle ?>s. The <?php echo $product->mNum ?> vacuum rotary feedthrough uses Ferrotec&rsquo;s <?php if ($product->fk_fluidID == '2') : ?>standard hydrocarbon-based<?php endif ?><?php if ($product->fk_fluidID == '1') : ?>fluorocarbon-based<?php endif ?> ferrofluid, specifically optimized for introducing rotary motion with a magnetic liquid hermetic seal in most <?php echo $product->fluidTitle ?> environments.</p>
                        <p>The <?php echo $product->mNum ?> vacuum rotary feedthrough features a <?php echo $product->shaftTitle ?> shaft with <?php echo $product->mountingTitle ?> mounting. Dimensional details are specified below. <?php if ($product->f2 == '1') : ?>This vacuum seal is also water-cooled for high-temperature applications.<?php endif ?> For precision measurement specifications, refer to the Spec Control Drawing.</p>
                        <p><strong>Ferrotec Part Number <?php echo $product->pNum ?> Dimension Specification Drawing</strong></p>
                        <a href="/wp-content/uploads/sites/2/diag-vf-<?php echo $product->pNum ?>.jpg" title="Feedthrough Model SS-188-SLAA (part number <?php echo $product->pNum ?>) dimensional specifications drawing"><img src="/wp-content/uploads/sites/2/diag-vf-<?php echo $product->pNum ?>.jpg" alt="Feedthrough Model SS-188-SLAA (part number 103971) dimensional specifications drawing" width="386" height="306" border="0"></a> 
                     </div>
                     <div class="col-sm-6">
                        <p class="text-center"><img class="center-block" src="/wp-content/uploads/sites/2/img-vf-<?php echo $product->pNum ?>.jpg" alt="Feedthrough Model <?php echo $product->mNum ?> (part number <?php echo $product->pNum ?>) image" style="width:60%;" border="0">  
                     </div>
                  </div>
               </div>
               <div role="tabpanel" class="tab-pane" id="specifications">
                  <h3>Product Specifications</h3>
                  <p><strong>Specifications for Ferrotec Part Number <?php echo $product->pNum ?></strong><br></p>
                  <div class="row">
                     <div class="col-sm-6">
                        <table class="table" width="100%" border="0" cellspacing="0" cellpadding="0">
                           <tbody>
                              <tr>
                                 <td width="40%">Shaft</td>
                                 <td width="60%"><?php echo $product->shaftTitle ?>&nbsp;Shaft</td>
                              </tr>
                              <tr>
                                 <td>Shaft Support:</td>
                                 <td>
                                    <?php if ($product->b1 == '1') : ?>Simply Supported (vac+atm sides) <br><?php endif ?>
                                    <?php if ($product->b2 == '1') : ?>Cantilevered (both on atm side) <br><?php endif ?>
                                    <?php if ($product->b3 == '1') : ?>Heavy Duty <br><?php endif ?>
                                 </td>
                              </tr>
                              <tr>
                                 <td>Ferrofluid</td>
                                 <td><?php echo $product->fluidTitle ?></td>
                              </tr>
                              <tr>
                                 <td>Mounting</td>
                                 <td>
                                    <?php echo $product->mountingTitle ?>
                                    <?php if ($product->mntOpt == '1') : ?><br>Mounting Nut and Washer Included <br><?php endif ?>
                                 </td>
                              </tr>
                              <?php if ( $product->f1 == '1' || $product->f2 == '1' || $product->f3 == '1' || $product->f4 == '1' || $product->f5 == '1' ) : ?>
                              <tr>
                                 <td>Features:</td>
                                 <td>
                                    <?php if ($product->f1 == '1') : ?>Sleeve <br><?php endif ?>
                                    <?php if ($product->f2 == '1') : ?>Water-cooled <br><?php endif ?>
                                    <?php if ($product->f3 == '1') : ?>Shaft Clamp <br><?php endif ?>
                                    <?php if ($product->f4 == '1') : ?>Electrical Isolation (Sleeved Bore)" <br><?php endif ?>
                                    <?php if ($product->f5 == '1') : ?>Number of Union Services <br><?php endif ?>
                                 </td>
                              </tr>
                              <?php endif ?>
                              <tr>
                                 <td colspan="2"><br>
                                    <strong>Dimensions:</strong>
                                 </td>
                              </tr>
                              <?php if ($product->d45 != 0) : ?>
                              <tr>
                                 <td>Shaft (or bore) Diameter with tolerance</td>
                                 <td><?php echo $product->d45 ?>&nbsp;<?php if ($product->d2 != 0) : ?>(<?php echo $product->d2 ?>)<?php endif ?> <?php echo $displayUnit ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($product->d3 != 0) : ?>
                              <tr>
                                 <td>Shaft termination</td>
                                 <td><?php echo $product->d3 ?>&nbsp;<?php echo $displayUnit ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($product->d4 != 0) : ?>
                              <tr>
                                 <td>Shaft extension (Vac)</td>
                                 <td><?php echo $product->d4?>&nbsp;<?php echo $displayUnit ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($product->d5 >= '1') : ?>
                              <tr>
                                 <td>Overall length</td>
                                 <td><?php echo $product->d5?>&nbsp;<?php echo $displayUnit ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($product->d6 != 0) : ?>
                              <tr>
                                 <td>Housing overall length</td>
                                 <td><?php echo $product->d6?>&nbsp;<?php echo $displayUnit ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($product->d7 != 0) : ?>
                              <tr>
                                 <td>Housing diameter</td>
                                 <td><?php echo $product->d7?>&nbsp;<?php if ($product->d8 != 0) : ?>(<?php echo $product->d8 ?>)<?php endif ?> <?php echo $displayUnit ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($product->d9 != 0) : ?>
                              <tr>
                                 <td>Body length</td>
                                 <td><?php echo $product->d9?>&nbsp;<?php echo $displayUnit ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($product->d10 != 0) : ?>
                              <tr>
                                 <td>Thread diameter</td>
                                 <td><?php echo $product->d10?>&nbsp;<?php echo $displayUnit ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($product->d11 != 0) : ?>
                              <tr>
                                 <td>Thread pitch [tps] or [mm/thd] (metric)</td>
                                 <td><?php echo $product->d11?>&nbsp;<?php if ($product->unit == '1'): ?>[tps]<?php else : ?>[mm/thd]<?php endif ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($product->d12 != 0) : ?>
                              <tr>
                                 <td>Thread length</td>
                                 <td><?php echo $product->d12?>&nbsp;<?php echo $displayUnit ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($product->d13 != 0) : ?>
                              <tr>
                                 <td>Clamp diameter</td>
                                 <td><?php echo $product->d13?>&nbsp;<?php echo $displayUnit ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($product->d14 != 0) : ?>
                              <tr>
                                 <td>Clamp thickness</td>
                                 <td><?php echo $product->d14?>&nbsp;<?php echo $displayUnit ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($product->d15 != 0) : ?>
                              <tr>
                                 <td>Recommended shaft diameter</td>
                                 <td><?php echo $product->d15?>&nbsp;<?php if ($product->d16 != 0) : ?>(<?php echo $product->d16 ?>) <?php echo $displayUnit ?><?php endif ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($product->d17 != 0) : ?>
                              <tr>
                                 <td>Recommended mounting bore</td>
                                 <td><?php echo $product->d17?>&nbsp;<?php if ($product->d18 != 0) : ?>(<?php echo $product->d18 ?>) <?php echo $displayUnit ?><?php endif ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($product->d19 != 0) : ?>
                              <tr>
                                 <td>Flange diameter</td>
                                 <td><?php echo $product->d19?>&nbsp;<?php echo $displayUnit ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($product->d20 != 0) : ?>
                              <tr>
                                 <td>Flange thickness</td>
                                 <td><?php echo $product->d20?>&nbsp;<?php echo $displayUnit ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($product->d21 != 0) : ?>
                              <tr>
                                 <td>Flange wrench flat</td>
                                 <td><?php echo $product->d21?>&nbsp;<?php echo $displayUnit ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($product->d22 != 0) : ?>
                              <tr>
                                 <td>Fitting locations</td>
                                 <td><?php echo $product->d22?>&nbsp;<?php echo $displayUnit ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($product->d23 != 0) : ?>
                              <tr>
                                 <td>Mounting holes</td>
                                 <td><?php echo $product->d23?>&nbsp;<?php echo $displayUnit ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($product->d38 != '') : ?>
                              <tr>
                                 <td>Flange Type</td>
                                 <td><?php echo $product->d38 ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($product->d37 != 0) : ?>
                              <tr>
                                 <td>Face seal O-ring</td>
                                 <td><?php echo $product->d37 ?></td>
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
                              <?php if ($product->d25 != '') : ?>
                              <tr>
                                 <td>Bearing type/material</td>
                                 <td><?php echo $product->d25 ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($product->d26 != 0) : ?>
                              <tr>
                                 <td>Bearing load cap</td>
                                 <td><?php echo $product->d26 ?> <?php if ($product->unit == '1') : ?>Pounds<?php else : ?>Kilograms<?php endif ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($product->d27 != 0) : ?>
                              <tr>
                                 <td>Bearing dynamic load capacity</td>
                                 <td><?php echo $product->d27 ?> <?php if ($product->unit == '1') : ?>Pounds<?php else : ?>Kilograms<?php endif ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($product->d28 != 0) : ?>
                              <tr>
                                 <td>Bearing Dim A</td>
                                 <td><?php echo $product->d28 ?>&nbsp;<?php echo $displayUnit ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($product->d29 != 0) : ?>
                              <tr>
                                 <td>Bearing Dim B</td>
                                 <td><?php echo $product->d29 ?>&nbsp;<?php echo $displayUnit ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($product->fk_shaftID == '1') : ?>
                              <tr>
                                 <td colspan="2"><a href="/wp-content/uploads/sites/2/sldBearingDim.jpg" title="Solid Shaft bearing dimensional specifications reference drawing"><img src="/wp-content/uploads/sites/2/sldBearingDim.jpg" alt="Solid Shaft bearing dimensional specifications reference drawing" width="210" height="167" border="0" /></a> <br></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($product->fk_shaftID == '2') : ?>
                              <tr>
                                 <td colspan="2"><a href="/wp-content/uploads/sites/2/hlwBearingDim.jpg" title="Hollow Shaft bearing dimensional specifications reference drawing"><img src="/wp-content/uploads/sites/2/hlwBearingDim.jpg" alt="Hollow Shaft bearing dimensional specifications reference drawing" width="210" height="167" border="0" /></a> <br></td>
                              </tr>
                              <?php endif ?>
                              <tr>
                                 <td colspan="2"><br>
                                    <strong>Performance Characteristics:</strong>
                                 </td>
                              </tr>
                              <?php if ($product->d30 != 0) : ?>
                              <tr>
                                 <td>Max Speed</td>
                                 <td><?php echo $product->d30 ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($product->d31 != 0) : ?>
                              <tr>
                                 <td>Max Thrust (Axial Load Limit)</td>
                                 <td><?php echo $product->d31 ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($product->d32 != 0) : ?>
                              <tr>
                                 <td>Radial Load Capacity</td>
                                 <td><?php echo $product->d32 ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($product->d24 != 0) : ?>
                              <tr>
                                 <td>Shaft Torque Capacity</td>
                                 <td><?php echo $product->d24 ?> <?php if ($product->unit == '1') : ?>in-lb<?php else : ?>N-m<?php endif ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($product->d40 != 0) : ?>
                              <tr>
                                 <td>Starting Torque 100rpm</td>
                                 <td><?php echo $product->d40 ?>&nbsp;<?php if ($product->unit == '1') : ?>in-oz<?php else : ?>N-mm<?php endif ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($product->d41 != 0) : ?>
                              <tr>
                                 <td>Running Torque 100rpm</td>
                                 <td><?php echo $product->d41 ?>&nbsp;<?php if ($product->unit == '1') : ?>in-oz<?php else : ?>N-mm<?php endif ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($product->d42 != 0) : ?>
                              <tr>
                                 <td>Starting Torque 1000rpm</td>
                                 <td><?php echo $product->d42 ?>&nbsp;<?php if ($product->unit == '1') : ?>in-oz<?php else : ?>N-mm<?php endif ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($product->d43 != 0) : ?>
                              <tr>
                                 <td>Running Torque 1000rpm</td>
                                 <td><?php echo $product->d43 ?>&nbsp;<?php if ($product->unit == '1') : ?>in-oz<?php else : ?>N-mm<?php endif ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($product->d34 != 0) : ?>
                              <tr>
                                 <td>Starting Torque</td>
                                 <td><?php echo $product->d34 ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($product->d35 != 0) : ?>
                              <tr>
                                 <td>Running Torque</td>
                                 <td><?php echo $product->d35 ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($product->d36 != 0) : ?>
                              <tr>
                                 <td>Limiting Speed [rpm]</td>
                                 <td><?php echo $product->d36 ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($product->d39 != '') : ?>
                              <tr>
                                 <td>Notes</td>
                                 <td><?php echo $product->d39 ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($product->nS == '1') : ?>
                              <tr>
                                 <td>Availability:</td>
                                 <td>Normally in stock.</td>
                              </tr>
                              <?php endif ?>
                              <tr>
                                 <td colspan="2"> </td>
                              </tr>
                              <tr>
                                 <td colspan="2"><strong>Note: </strong><br>
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
                        <p><strong>Ordering Information for Model <?php echo $product->mNum ?>, Part Number <?php echo $product->pNum ?></strong></p>
                        <p>If you have questions about pricing and availability, need more information about Ferrotec's <?php echo $product->mNum ?> rotary feedthroughs, or if you have other Ferrofluidic seal requirements, you can submit your request using the form below or <a href="/contact/sales/salesFerrofluidic/"><strong>contact your Ferrotec representative directly&nbsp;&raquo;</strong></a></p>
                        <p><strong>Special Orders, Modifications, and Customized Solutions for Unique Applications</strong></p>
                        <p>Model <?php echo $product->mNum ?>, Part Number <?php echo $product->pNum ?> is a standard model vacuum rotary feedthrough. Ferrotec can also customize a <?php echo $product->shaftTitle ?> shaft vacuum rotary feedthrough to match your specific application requirements. Please contact Ferrotec for more information.</p>
                        <p><strong>Please Contact Me Regarding Ferrotec Model Number <?php echo $product->mNum ?></strong></p>
                        <p>Use this form to submit your <?php echo $product->mNum ?> (part number <?php echo $product->pNum ?>) inquiry directly to Ferrotec. If you have special requirements or need specific customizations, please include the details in your description. </p>
                     </div>
                     <div class="col-sm-6">
                        <?php
                           gravity_form( 'vf-inquiry', false, false, false, array( 'ferrotec_model_number' => $product->mNum ), false, true );
                            ?>
                     </div>
                  </div>
               </div>
               <div role="tabpanel" class="tab-pane" id="downloads">

                  <h3>Available CAD Files</h3><?php// echo $product->pNum ?>
                  <div class="row" style="float:left; text-align:center; width:500px; padding:20px; margin-left:5px; height:150px; background-color:#efefef;">
                     <div class="col-sm-12">
                        <p style="text-align:left;">Feedthrough Model: <?php echo $product->mNum ?><br> Part Number: <?php echo $product->pNum ?></p>
                     </div>
                     <a href="/seals-site/product/drawing/2d_drawings/<?php echo $product->pNum ?>.dxf">
                        <div style="width:100px; margin-left:15px; float:left; height:30px; line-height:30px; background-color:#ffffff; border:1px solid #cccccc;">
                           DXF Format
                        </div>
                     </a>
                     <a href="/seals-site/product/drawing/step_assemblies/<?php echo $product->pNum ?>.stp">
                        <div style="width:100px; margin-left:20px; float:left; height:30px; line-height:30px; background-color:#ffffff; border:1px solid #cccccc;">
                           STP Format
                        </div>
                     </a>
                  </div>
                  
                  <?php
                     if($_SESSION['userid']=="")
                     {
                      //echo "id=".$_SESSION['userid'];
                     ?>
                  <h3>Available CAD Files</h3>
                  <div style="float:left; text-align:center; width:270px; padding:20px; height:330px; background-color:#1c75bc;">
                     <h4 style="color:#ffffff;">Login to Download Files</h4>
                     <?php
                        if($action=="failed")
                        {
                        ?>
                     <div style="height:25px; border:1px solid #ff0000; line-height:25px; background-color:#ffffff; margin-bottom:10px; color:#ff0000;">
                        Invalid login info.
                     </div>
                     <?php
                        }
                        ?>
                     <div id="addresserr" class="alert_box error" style="display:none; color:#ff0000;"></div>
                     <form name="login" method="post" action="">
                        <table cellpadding="0" width="100%" cellspacing="0" border="0">
                           <tr>
                              <td>&nbsp;</td>
                           </tr>
                           <tr>
                              <td align="center"><input type="text" name="username" id="username" placeholder="Email"></td>
                           </tr>
                           <tr>
                              <td height="10"></td>
                           </tr>
                           <tr>
                              <td align="center"><input type="password" name="password" id="password" placeholder="Password"></td>
                           </tr>
                           <tr>
                              <td height="10"></td>
                           </tr>
                           <tr>
                              <td align="center"><input type="submit" name="loginsubmit" value="Login" class="button" onClick="return loginValidate();"></td>
                           </tr>
                           <tr>
                              <td height="10"></td>
                           </tr>
                           <tr>
                              <td height="10" style="color:#ffffff;"><a href="#forgot" style="text-decoration:none; color:#ffffff;">Forgot Password</a></td>
                           </tr>
                        </table>
                     </form>
                  </div>
                  <?php if($action=="" || $action=="available" || $action=="failed")
                     { 
                        ?>
                  <div style="float:left; margin-left:20px; text-align:center; width:700px; padding:20px; min-height:330px; background-color:#e6e7e8;">
                     <h4>Create a New Ferrotec Download Account</h4>
                     <?php
                        if($action=="available")
                        {
                        ?>
                     <div style="height:25px; border:1px solid #ff0000; line-height:25px; background-color:#ffffff; margin-bottom:10px; color:#ff0000;">
                        A user already exists with this email address. Please use different email address to register or login.
                     </div>
                     <?php
                        }
                        ?>
                     <p style="text-align:left;">After registering, you will receive a temporary password via email to the address you specify. That email address will be your user name. Normally, it takes approximately one or two business days to approve accounts and send you your temporary password.</p>
                     <div id="addresserr2" class="alert_box error" style="display:none; color:#ff0000;"></div>
                     <form name="register" method="post" action="">
                        <input type="hidden" id="00N30000008eN2Z" name="00N30000008eN2Z" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>">
                        <input type="hidden" id="00N1400000BP8F8" name="00N1400000BP8F8" >
                        <input type="hidden" id="00N300000025GPN" name="00N300000025GPN" value="Registration">

                        <table cellpadding="0" width="100%" cellspacing="0" border="0">
                           <tr>
                              <td height="10"></td>
                           </tr>
                           <tr>
                              <td align="right">
                                 <select name="sign" id="sign">
                                    <option value="">Select... </option>
                                    <option value="Mr">Mr</option>
                                    <option value="Ms">Ms</option>
                                    <option value="Mrs">Mrs</option>
                                 </select>
                              </td>
                              <td>&nbsp;</td>
                              <td align="center"><input type="text" name="firstName" id="firstName" placeholder="First Name"></td>
                              <td>&nbsp;</td>
                              <td align="center"><input type="text" name="lastName" id="lastName" placeholder="Last Name"></td>
                           </tr>
                           <tr>
                              <td colspan="5" height="5px"></td>
                           </tr>
                           <tr>
                              <td align="center"><input type="text" name="city" id="city" placeholder="City"></td>
                              <td>&nbsp;</td>
                              <td align="center"><input type="text" name="state" id="state" placeholder="State"></td>
                              <td>&nbsp;</td>
                              <td align="center"><input type="text" name="country" id="country" placeholder="Country"></td>
                           </tr>
                           <tr>
                              <td colspan="5" height="5px"></td>
                           </tr>
                           <tr>
                              <td align="center"><input type="text" name="phone" id="phone" placeholder="Phone"></td>
                              <td>&nbsp;</td>
                              <td align="center"><input type="text" name="email" id="email" placeholder="Email Address"></td>
                              <td>&nbsp;</td>
                              <td align="center"><input type="text" name="companyName" id="companyName" placeholder="Company Name"></td>
                           </tr>
                           <tr>
                              <td colspan="5" height="5px"></td>
                           </tr>
                           <tr>
                              <td colspan="5" align="center">Please use your business email address not a personal address.</td>
                           </tr>
                           <tr>
                              <td colspan="5" height="10px"></td>
                           </tr>
                           <tr>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td align="center"><input type="submit" name="regsubmit" value="Register" class="button2" onClick="return regValidate();"></td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                           </tr>
                        </table>
                     </form>
                  </div>
                  <?php
                     }
                     ?>
                  <?php if($action!="" && $action!="available" && $action!="failed")
                     { 
                        ?>
                  <div style="float:left; margin-left:20px; text-align:center; width:700px; padding:20px; height:330px; background-color:#e6e7e8;">
                     <h4 style="text-align:left;">Success!</h4>
                     <br>
                     <p style="text-align:left;">
                        <b style="font-weight:bold;">Your request was received and is being processed now.</b> <br>
                        In one or two business days you will receive an email from Ferrotec with a link
                        to login where you’ll use to download the CAD files you've requested. On your first login, you’ll be asked to set a permanent password.
                     </p>
                  </div>
                  <?php
                     }
                     ?>   
                  <?php
                     }
                     ?>
               </div>
            </div>
         </div>
   </article>
</main>
<!-- #main -->
</div>
<?php endforeach ?>
<?php get_footer();
