<?php
add_filter('relevanssi_content_to_index', 'add_extra_content', 10, 2);
add_filter('relevanssi_excerpt_content', 'add_extra_content', 10, 2);

function add_extra_content($content, $post) {
    if ( get_page_template_slug( $post ) == 'page-teproducts.php' ){
        global $product;
          $prod = get_field('woo_prod_id', $post);

        $fields = get_fields($prod);

        $terms = get_the_terms( $prod, 'product_cat' );
        foreach ($terms as $term) {
          $product_cat_id = $term->term_id;
          break;
        }
        $product_cat = get_term($product_cat_id);
        $pagetitle = 'Thermoelectric Modules';
        $bodytitle = 'Peltier Cooler Model '.$fields['fullPN'];
ob_start();
      ?>

<div id="primary" class="content-area">
  <main id="main" class="site-main" role="main">
   <header class="page-header">
         <div class="page-banner" >
            <div class="container">
               <div class="background-product"></div>
               <div class="flex-area-center">
                     <h1><?php echo $pagetitle;?></h1>
               </div>
            </div>
         </div>
   </header>
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <h2><?php echo $bodytitle ?></h2>
        </div>
      </div>
      <table>
        <tr>
          <td>
            <p class="main">
              Peltier cooler model <?php echo $fields['fullPN'] ?> is a member of Ferrotec&rsquo;s family of 
              <?php echo displayFamily($fields['fk_tefamilyinfoid']) ?> modules. The <?php echo $fields['fullPN'] ?> peltier cooler is a <?php echo $fields['altDescription'] ?>, <?php echo $fields['numCouples'] ?>-couple, <?php echo $fields['iMax'] ?>-amp module.
              <?php if ( $fields['substrateType'] == "M") : ?>
              The 'M' code indicates that this standard thermoelectric cooler features a solderable, metalized ceramic substrate on both hot and cold side external surfaces 
              <?php endif ?>
              <?php if ( $fields['substrateType'] == "B") : ?>
              The 'B' code indicates that this standard TEC features a lapped type, plain ceramic surface.
              <?php endif ?>
              <?php if ( $fields['description'] != '') : ?>
              <br /><br /><?php echo $fields['description'] ?>
              <?php endif ?>
            </p>
            <p class="main">&nbsp;</p>
          </td>
          <td>
            <a href=""><img src="/wp-content/uploads/sites/4/thermal-site/<?php echo $fields['image_url'] ?>" border="0" /></a>
          </td>
        </tr>
      </table>
      <div id="module_detail_tab">
        <ul class="nav nav-tabs" role="tablist">
          <li role="presentation" class="active"><a href="#specs" aria-controls="specs" role="tab" data-toggle="tab">
             <div class="visible-xs-inline-block tabicon icn-specs"></div>
             <div class="hidden-xs">Specifications</div>
          </a></li>
          <?php if( $fields['graph_flag'] !='false' && $fields['graph_flag'] !='' && $fields['graph_flag'] != '0') : ?>
          <li role="presentation"><a id="tab2" href="#tmodel" aria-controls="tmodel" role="tab" data-toggle="tab">
             <div class="visible-xs-inline-block tabicon icn-control"></div>
             <div class="hidden-xs">Thermal Modeling</div>
          </a></li>
          <?php endif ?>
          <li role="presentation"><a href="#order" aria-controls="order" role="tab" data-toggle="tab">
             <div class="visible-xs-inline-block tabicon icn-ordering"></div>
             <div class="hidden-xs">Ordering</div>
          </a></li>
        </ul>
      </div>
      <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="specs">
          <!-- specs tab -->
          <div id="tabBodyLeft">
            <div class="table-responsive">
              <?php if ($fields['fk_tefamilyinfoid'] == 12 || 14 || 15 || 16 || 17) : ?>
              <h3><?php echo $fields['fullPN'] . " &mdash; "  ?>Mechanical Characteristics</h3>
              <div class="table-responsive">
                <table class="table table-striped">
                  <?php if( $fields['baseW'] != 0) : ?>
                  <tr>
                    <td>Base W (mm)</td>
                    <td><?php echo $fields['baseW'] ?></td>
                  </tr>
                  <?php endif ?>
                  <?php if( $fields['baseL'] != 0) : ?>
                  <tr>
                    <td>Base L (mm)</td>
                    <td><?php echo $fields['baseL'] ?></td>
                  </tr>
                  <?php endif ?>
                  <?php if( $fields['topW'] != 0) : ?>
                  <tr>
                    <td>Top W (mm)</td>
                    <td><?php echo $fields['topW'] ?></td>
                  </tr>
                  <?php endif ?>
                  <?php if( $fields['topL'] != 0) : ?>
                  <tr>
                    <td>Top L (mm)</td>
                    <td><?php echo $fields['topL'] ?></td>
                  </tr>
                  <?php endif ?>
                  <?php if( $fields['idDim'] != 0) : ?>
                  <tr>
                    <td>Inner Diameter (mm)</td>
                    <td><?php echo $fields['idDim'] ?></td>
                  </tr>
                  <?php endif ?>
                  <?php if( $fields['oDim'] != 0) : ?>
                  <tr>
                    <td>Outer Diameter (mm)</td>
                    <td><?php echo $fields['oDim'] ?></td>
                  </tr>
                  <?php endif ?>
                  <?php if( $fields['hDim'] != 0) : ?>
                  <tr>
                    <td>Height (mm)</td>
                    <td><?php echo $fields['hDim'] ?></td>
                  </tr>
                  <?php endif ?>
                </table>
              </div>
              <?php else : ?>
              <h3><?php echo $fields['fullPN'] ?> &mdash; Mechanical Characteristics</h3>
              <div class="table-responsive">
                <table class="table table-striped">
                  <?php if( $fields['w1Dim'] != 0) : ?>
                  <tr>
                    <td>W1 Dimension (mm)</td>
                    <td><?php echo $fields['w1Dim'] ?></td>
                  </tr>
                  <?php endif ?>
                  <?php if( $fields['l1Dim'] != 0) : ?>
                  <tr>
                    <td>L1 Dimension (mm)</td>
                    <td><?php echo $fields['l1Dim'] ?></td>
                  </tr>
                  <?php endif ?>
                  <?php if( $fields['w2Dim'] != 0) : ?>
                  <tr>
                    <td>W2 Dimension (mm)</td>
                    <td><?php echo $fields['w2Dim'] ?></td>
                  </tr>
                  <?php endif ?>
                  <?php if( $fields['l2Dim'] != 0) : ?>
                  <tr>
                    <td>L2 Dimension (mm)</td>
                    <td><?php echo $fields['l2Dim'] ?></td>
                  </tr>
                  <?php endif ?>
                  <?php if( $fields['w3Dim'] != 0) : ?>
                  <tr>
                    <td>W2 Dimension (mm)</td>
                    <td><?php echo $fields['w3Dim'] ?></td>
                  </tr>
                  <?php endif ?>
                  <?php if( $fields['l3Dim'] != 0) : ?>
                  <tr>
                    <td>L3 Dimension (mm)</td>
                    <td><?php echo $fields['l3Dim'] ?></td>
                  </tr>
                  <?php endif ?>
                  <?php if( $fields['idDim'] != 0) : ?>
                  <tr>
                    <td>Inner Diameter (mm)</td>
                    <td><?php echo $fields['idDim'] ?></td>
                  </tr>
                  <?php endif ?>
                  <?php if( $fields['oDim'] != 0) : ?>
                  <tr>
                    <td>Outer Diameter (mm)</td>
                    <td><?php echo $fields['oDim'] ?></td>
                  </tr>
                  <?php endif ?>
                  <?php if( $fields['hDim'] != 0) : ?>
                  <tr>
                    <td>Height (mm)</td>
                    <td><?php echo $fields['hDim'] ?></td>
                  </tr>
                  <?php endif ?>
                </table>
              </div>
              <?php endif ?>
              <img src="/wp-content/uploads/sites/4/thermal/<?php echo get_field('dimFile', $product_cat ); ?>" >
              <h3>Performance Values</h3>
              <div class="table-responsive">
                <table class="table table-striped">
                  <tr>
                    <td>Values calculated at 50&deg;C.</td>
                    <td>I Max</td>
                    <td><?php echo $fields['iMax'] ?></td>
                    <td>&Delta;T Max</td>
                    <td><?php echo $fields['tMax'] ?></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>V Max</td>
                    <td><?php echo $fields['vMax'] ?></td>
                    <td>Qc Max</td>
                    <td><?php echo $fields['qcMax'] ?></td>
                  </tr>
                </table>
              </div>
              
              <h3>Custom Options</h3>
              <p>Ferrotec can also customize a <?php echo displayFamily($fields['fk_tefamilyinfoid']) ?> Module for you based on the <?php echo $fields['fullPN'] ?>. <br />Note: minimum quantity custom order limitations apply. </p>
              <h3>About Ferrotec&rsquo;s <?php echo displayFamily($fields['fk_tefamilyinfoid']) ?> Module Family</h3>
              <p><?php echo $family_detail[0]->stdDesc ?></p>
              <p><?php echo $family_detail[0]->bigDesc ?></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
</div>
<?php
$output = ob_get_contents();
ob_end_clean();
$content .= " " .$output;
return $content;
}
    if ( get_page_template_slug( $post ) == 'page-ferrofluidproducts.php' ){
        global $product;
          $prod = get_field('woo_prod_id', $post);

        $fields = get_fields($prod);

        $terms = get_the_terms( $prod, 'product_cat' );
        foreach ($terms as $term) {
          $product_cat_id = $term->term_id;
          break;
        }
        $product_cat = get_term($product_cat_id);
  switch ( $fields['seriesID']) {
    case 13:
      $fluid_type = 'Ferrofluid';
      $page_title = $product_cat->name .' Ferrofluid <br>Type: '. $fields['model'];
      $page_description = 'Ferrotec&rsquo;s  '. $fields['model'] .' Ferrofluid is a member of Ferrotec&rsquo;s family of '. $product_cat->name .' ferrofluids. Unlike Ferrotec&rsquo;s APG series of ferrofluids that have been optimized for audio speaker applications, Ferrotec&rsquo;s EMG Series ferrofluids address a broad range of application requirements and can be used for experimentation and application development. Ferrotec&rsquo;s water-based EMG Series are typically used in applications where rapid evaporation or the ability to mix ferrofluid into a water-based system is required. '. $fields['model'] .' ferrofluid is '. $fields['description'] .' and uses '. $fields['surf_nature'] .' surfactant.';
      $page_more_info = 'Ferrotec '. $product_cat->name .' Ferrofluid Additional Information';
      break;
    case 14:
      $fluid_type = 'Ferrofluid';
      $page_title = $product_cat->name .' Ferrofluid <br>Type: '. $fields['model'];
      $page_description = 'Ferrotec&rsquo;s '. $fields['model'] .' Ferrofluid is a member of Ferrotec&rsquo;s family of '. $product_cat->name .' ferrofluids. Unlike Ferrotec&rsquo;s APG series of ferrofluids that have been optimized for audio speaker applications, Ferrotec&rsquo;s EMG Series ferrofluids address a broad range of application requirements and can be used for experimentation and application development. Ferrotec&rsquo;s oil-based EMG Series are typically used in applications where you don&rsquo;t want evaporation or you don&rsquo;t want the ferrofluid to mix the other elements. '. $fields['model'] .' ferrofluid is '. $fields['description'] .'.';
      $page_more_info = 'Ferrotec '. $product_cat->name .' Ferrofluid Additional Information';
      break;
    case 15:
      $fluid_type = 'Ferrofluid';
      $page_title = $product_cat->name .' <br>Type: '. $fields['model'];
      $page_description = 'Ferrotec&rsquo;s '. $fields['model'] .' Ferrofluid is a member of Ferrotec&rsquo;s family of '. $product_cat->name .'. Unlike Ferrotec&rsquo;s APG series of ferrofluids that have been optimized for audio speaker applications, Ferrotec&rsquo;s EMG Series ferrofluids address a broad range of application requirements and can be used for experimentation and application development. Ferrotec&rsquo;s dry magnetic nanoparticle EMG Series are typically used when you want to create your own concentrations and suspensions, or when you want to use a carrier liquid that Ferrotec doesn&rsquo;t currently offer. '. $fields['model'] .' ferrofluid is '. $fields['description'] .' and uses a '. $fields['surf_type'] .' surfactant. '. $fields['model'] .' has been tested and shown to be soluble in '. $fields['sol_y'] .', but is not soluble in '. $fields['sol_n'] .'.';
      $page_more_info = 'Ferrotec '. $product_cat->name .' Additional Information';
      break;
    case 16:
      $fluid_type = 'Educational Ferrofluid';
      $page_title = $product_cat->name .' Educational Ferrofluid<br>Type: '. $fields['model'];
      $page_description = 'Ferrotec&rsquo;s '. $fields['model'] .' Ferrofluid is a member of Ferrotec&rsquo;s family of '. $product_cat->name .' ferrofluids for educational markets. Ferrotec&rsquo;s EFH Series offers educators, schools, and museums a unique and fascinating new way to explore the world of magnetism. '. $fields['model'] .' ferrofluid is '. $fields['description'] .' and uses a '. $fields['liquidType'] .' carrier liquid.';
      $page_more_info = 'Ferrotec '. $product_cat->name .' Educational Ferrofluid Additional Information';
      break;
    default:
      $fluid_type = 'Audio Ferrofluid';
      $page_title = $product_cat->name .' Audio Ferrofluid<br>Type: '. $fields['model'];
      $page_description = 'Ferrotec&rsquo;s '. $fields['model'] .' '. $fields['seriesType'] .' Ferrofluid is a member of Ferrotec&rsquo;s family of '. $product_cat->name .' ferrofluids for audio speaker applications. The '. $product_cat->name .' is '. $fields['description'] .' and uses a '. $fields['liquidType'] .' carrier liquid.';
      $page_more_info = 'Ferrotec '. $product_cat->name .' Audio Ferrofluid Additional Information';
      break;
  }
  ob_start();
     ?>
   <header class="page-header">
         <div class="page-banner" >
            <div class="container">
               <div class="background-product"></div>
               <div class="flex-area-center">
                     <h1><?php echo $fluid_type ?></h1>
               </div>
            </div>
         </div>
   </header>
<article id="" class="page type-page">

  <div class="container-wrapper content-padding ">
    <div class="container">

  <div class="entry-content">
<h2><?php echo  $page_title; ?></h2>
<p class="main"><?php echo $page_description ?></p>
<div class="indent-lightgrey-bkg">
<h3><?php echo $fields['model'] ?> Specifications and Physical Properties</h3>
<div class="table-responsive">
<table class="table">
<tbody>
    <tr>
      <td><strong>Appearance</strong></td>
      <td colspan="2"><?php echo $fields['description'] ?></td>
    </tr>
<?php if ( $fields['surf_type'] != '') : ?>
    <tr>
      <td><strong>Type of Surfactant</strong></td>
      <td colspan="2"><?php echo $fields['surf_type'] ?></td>
    </tr>
<?php endif ?>
<?php if ( $fields['sat_guass'] != '') : ?>
    <tr>
      <td><strong>Carrier Liquid</strong></td>
      <td colspan="2"><?php echo $fields['liquidType'] ?></td>
    </tr>
<?php endif ?>
<?php if ( $fields['nominal_diam_nm'] != '') : ?>
<tr>
      <td><strong>Nominal Particle Diameter</strong></td>
      <td colspan="2"><?php echo $fields['nominal_diam_nm'] ?> nm</td>
    </tr>
<?php endif ?>
</tbody>
</table>

<table class="table table-striped">
<tbody>
<?php if ( $fields['sat_guass'] != '') : ?>
<tr></tr>
<tr></tr>
    <tr>
      <td width="40%">&nbsp;</td>
      <td><strong>CGS Units</strong></td>
      <td><strong>SI Units</strong></td>
    </tr>   
    <tr>
      <td><strong>Saturation Magnetization (Ms)</strong></td>
      <td><?php echo $fields['sat_guass'] ?> Gauss</td>
      <td><?php echo $fields['sat_mt'] ?> mT</td>
    </tr>
    <tr>
      <td><strong>Viscosity @27&deg;C</strong></td>
      <td><?php echo $fields['vis_cp'] ?> cP</td>
      <td><?php echo $fields['sat_mpa_s'] ?> mPa&#183;s</td>
    </tr>
    <tr>
      <td><strong>Density @25&deg;C</strong></td>
      <td><?php echo $fields['den_g_ml'] ?> g/cc</td>
      <td><?php echo $fields['den_g_cm3'] ?> 10<sup>3</sup> kg/m<sup>3</sup></td>
    </tr>
<?php endif ?>
<?php if ( $fields['pour_c1'] != '') : ?>
    <tr>
      <td><strong>Pour Point</strong></td>
      <td><?php echo $fields['pour_c1'] ?> &deg;C</td>
      <td><?php echo $fields['pour_c2'] ?> &deg;C</td>
    </tr>
<?php endif ?>
<?php if ( $fields['flash_c1'] != '') : ?>
<tr>
      <td><strong>Flash Point</strong></td>
      <td><?php echo $fields['flash_c1'] ?> &deg;C</td>
      <td><?php echo $fields['flash_c2'] ?> &deg;C</td>
    </tr>
<?php endif ?>
<?php if ( $fields['cond_mw1'] != '') : ?>
    <tr>
      <td><strong>Thermal Conductivity @38&deg;C</strong></td>
      <td><?php echo $fields['cond_mw1'] ?> mW/(m&#183;K)</td>
      <td><?php echo $fields['cond_mw2'] ?> mW/(m&#183;K)</td>
    </tr>
<?php endif ?>
<?php if ( $fields['surf_dynes_cm'] != '') : ?>
    <tr>
      <td><strong>Surface Tension @25&deg;C</strong></td>
      <td><?php echo $fields['surf_dynes_cm'] ?> dynes/cm</td>
      <td><?php echo $fields['surf_mn'] ?> mN/m</td>
    </tr>
<?php endif ?>
<?php if ( $fields['coef_mlc'] != '') : ?>
    <tr>
      <td><strong>Coefficient of Thermal Expansion</strong></td>
      <td><?php echo $fields['coef_mlc'] ?> x 10<sup>-4</sup> ml/ml&deg;C</td>
      <td><?php echo $fields['coef_mlc'] ?> x 10<sup>-4</sup> /K</td>
    </tr>
<?php endif ?>
<?php if ( $fields['gauss_oe'] != '') : ?>
    <tr>
      <td><strong>Initial Magnetic Susceptibility</strong></td>
      <td><?php echo $fields['gauss_oe'] ?></td>
      <td><?php echo $fields['emug_oe'] ?></td>
    </tr>
<?php endif ?>
<?php if ( $fields['part_conc_weight'] != '') : ?>
    <tr>
      <td><strong>Magnetic Particle Concentration</strong></td>
      <td colspan="2"><?php echo $fields['part_conc_weight'] ?> % vol.</td>
    </tr>
<?php endif ?>
<?php if ( $fields['pH'] != '') : ?>
    <tr>
      <td><strong>pH</strong></td>
      <td colspan="2"><?php echo $fields['pH'] ?></td>
    </tr>
<?php endif ?>
<?php if ( $fields['surf_nature'] != '') : ?>
    <tr>
      <td><strong>Nature of Surfactant</strong></td>
      <td colspan="2"><?php echo $fields['surf_nature'] ?></td>
    </tr>
<?php endif ?>
<?php if ( $fields['volatility_hour'] != '') : ?>
    <tr>
      <td><strong>Volatility</strong></td>
      <td colspan="2"><?php echo $fields['volatility_hour'] ?></td>
    </tr>
<?php endif ?>
<?php if ( $fields['fe_ox'] != '') : ?>
    <tr>
      <td><strong>Iron Oxide Content (wt%)</strong></td>
      <td colspan="2"><?php echo $fields['fe_ox'] ?></td>
    </tr>
<?php endif ?>
<?php if ( $fields['sat_emuG'] != '') : ?>
    <tr>
      <td><strong>Saturation Magnetization</strong></td>
      <td colspan="2"><?php echo $fields['sat_emuG'] ?> emu/g</td>
    </tr>
<?php endif ?>
<?php if ( $fields['fe_ox'] != '') : ?>
    <tr>
      <td><strong>Tested Solubilities:</strong></td>
      <td colspan="2"><?php echo $fields['sol_y'] ?></td>
    </tr>
<?php endif ?>
<?php if ( $fields['fe_ox'] != '') : ?>
    <tr>
      <td><strong>Not Soluble in:</strong></td>
      <td colspan="2"><i><?php echo $fields['sol_n'] ?></i></td>
    </tr>
<?php endif ?>

</tbody>
  </table>
  </div>
  </div>
  </div>
  </div>
</div>

<div class="container-wrapper content-padding bkg-gradient-red narrow">
        <div class="container">
          <div class="row">
   <div class="col-sm-9">
      <h3><strong><?php echo $page_more_info ?></strong></h3>
      <p>For more information about material handling, refer to the MSDS (Material Safety Datasheet) for the <?php echo $product_cat->name ?> family of products.&nbsp;</p>
   </div>
   <div class="col-sm-3">
      <h3><a href="/wp-content/uploads/sites/3/<?php echo $fields['msds'] ?>sds.pdf" class="btn btn-default">Download PDF <span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span></a></h3>
   </div>
</div>        </div>
      </div>
fer
</article>
</main>



<?php
$output = ob_get_contents();
ob_end_clean();
$content .= " ". $output;
return $content;
    }
    if ( get_current_blog_id() == 2 && $post->post_type == "product" ){
        global $product;
        $product = wc_get_product( $post->ID );
        $fields = get_fields($prod);

    ob_start();
   if ($fields['unit'] == 1) $displayUnit="in";
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
            <h2>Feedthrough Model: <?php echo $fields['mNum']; ?><br> Part Number: <?php echo $fields['pNum']; ?></h2>
            <p>&nbsp;</p>
         </div>
         <div class="col-sm-12">
            <ul class="nav nav-tabs nav-product-tabs" role="tablist">
               <li role="presentation">
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
               <li role="presentation">
                  <a href="#downloads" aria-controls="downloads" role="tab" data-toggle="tab">
                     <div class="visible-xs tabicon icn-downloads"></div>
                     <div class="hidden-xs">Downloads</div>
                  </a>
               </li>
            </ul>
            <div class="tab-content">
               <div role="tabpanel" class="tab-pane" id="description">
                  <h3>Product Description</h3>
                  <div class="row">
                     <div class="col-sm-6">
                        <p>Ferrotec&rsquo;s Ferrofluidic seal Feedthrough Model <?php echo $fields['mNum']; ?> (part number <?php echo $fields['pNum'];  ?>) is a member of Ferrotec&rsquo;s <?php echo $fields['familyTitle'];  ?>s. The <?php echo $fields['mNum'];  ?> vacuum rotary feedthrough uses Ferrotec&rsquo;s <?php if ($fields['fk_fluidID'] == '2') : ?>standard hydrocarbon-based<?php endif ?><?php if ($fields['fk_fluidID'] == '1') : ?>fluorocarbon-based<?php endif ?> ferrofluid, specifically optimized for introducing rotary motion with a magnetic liquid hermetic seal in most <?php echo $product->get_attribute( 'pa_fluid' );  ?> environments.</p>
                        <p>The <?php echo $fields['mNum'];  ?> vacuum rotary feedthrough features a <?php echo $product->get_attribute( 'pa_shaft' );  ?> shaft with <?php echo $product->get_attribute( 'pa_mounting' );  ?> mounting. Dimensional details are specified below. <?php if ($fields['f2'] == '1') : ?>This vacuum seal is also water-cooled for high-temperature applications.<?php endif ?> For precision measurement specifications, refer to the Spec Control Drawing.</p>
                        <p><strong>Ferrotec Part Number <?php echo $fields['pNum'];  ?> Dimension Specification Drawing</strong></p>
                        <a href="/wp-content/uploads/sites/2/diag-vf-<?php echo $fields['pNum'];  ?>.jpg" title="Feedthrough Model SS-188-SLAA (part number <?php echo $fields['pNum'];  ?>) dimensional specifications drawing"><img src="/wp-content/uploads/sites/2/diag-vf-<?php echo $fields['pNum'];  ?>.jpg" alt="Feedthrough Model SS-188-SLAA (part number 103971) dimensional specifications drawing" width="386" height="306" border="0"></a> 
                     </div>
                     <div class="col-sm-6">
                        <p class="text-center"><img class="center-block" src="/wp-content/uploads/sites/2/img-vf-<?php echo $fields['pNum'];  ?>.jpg" alt="Feedthrough Model <?php echo $fields['mNum'];  ?> (part number <?php echo $fields['pNum'];  ?>) image" style="width:60%;" border="0">  
                     </div>
                  </div>
               </div>
               <div role="tabpanel" class="tab-pane" id="specifications">
                  <h3>Product Specifications</h3>
                  <p><strong>Specifications for Ferrotec Part Number <?php echo $fields['pNum'];  ?></strong><br></p>
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
                                    <?php if ($fields['b1'] == '1') : ?>Simply Supported (vac+atm sides) <br><?php endif ?>
                                    <?php if ($fields['b2'] == '1') : ?>Cantilevered (both on atm side) <br><?php endif ?>
                                    <?php if ($fields['b3'] == '1') : ?>Heavy Duty <br><?php endif ?>
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
                                    <?php if ($fields['mntOpt'] == '1') : ?><br>Mounting Nut and Washer Included <br><?php endif ?>
                                 </td>
                              </tr>
                              <?php if ( $fields['f1'] == '1' || $fields['f2'] == '1' || $fields['f3'] == '1' || $fields['f4'] == '1' || $fields['f5'] == '1' ) : ?>
                              <tr>
                                 <td>Features:</td>
                                 <td>
                                    <?php if ($fields['f1'] == '1') : ?>Sleeve <br><?php endif ?>
                                    <?php if ($fields['f2'] == '1') : ?>Water-cooled <br><?php endif ?>
                                    <?php if ($fields['f3'] == '1') : ?>Shaft Clamp <br><?php endif ?>
                                    <?php if ($fields['f4'] == '1') : ?>Electrical Isolation (Sleeved Bore)" <br><?php endif ?>
                                    <?php if ($fields['f5'] == '1') : ?>Number of Union Services <br><?php endif ?>
                                 </td>
                              </tr>
                              <?php endif ?>
                              <tr>
                                 <td colspan="2"><br>
                                    <strong>Dimensions:</strong>
                                 </td>
                              </tr>
                              <?php if ($fields['d45'] != 0) : ?>
                              <tr>
                                 <td>Shaft (or bore) Diameter with tolerance</td>
                                 <td><?php echo $fields['d45'];  ?>&nbsp;<?php if ($fields['d2'] != 0) : ?>(<?php echo $fields['d2'];  ?>)<?php endif ?> <?php echo $displayUnit ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($fields['d3'] != 0) : ?>
                              <tr>
                                 <td>Shaft termination</td>
                                 <td><?php echo $fields['d3'];  ?>&nbsp;<?php echo $displayUnit ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($fields['d4'] != 0) : ?>
                              <tr>
                                 <td>Shaft extension (Vac)</td>
                                 <td><?php echo $fields['d4']; ?>&nbsp;<?php echo $displayUnit ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($fields['d5'] >= '1') : ?>
                              <tr>
                                 <td>Overall length</td>
                                 <td><?php echo $fields['d5']; ?>&nbsp;<?php echo $displayUnit ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($fields['d6'] != 0) : ?>
                              <tr>
                                 <td>Housing overall length</td>
                                 <td><?php echo $fields['d6']; ?>&nbsp;<?php echo $displayUnit ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($fields['d7'] != 0) : ?>
                              <tr>
                                 <td>Housing diameter</td>
                                 <td><?php echo $fields['d7']; ?>&nbsp;<?php if ($fields['d8'] != 0) : ?>(<?php echo $fields['d8'];  ?>)<?php endif ?> <?php echo $displayUnit ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($fields['d9'] != 0) : ?>
                              <tr>
                                 <td>Body length</td>
                                 <td><?php echo $fields['d9']; ?>&nbsp;<?php echo $displayUnit ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($fields['d10'] != 0) : ?>
                              <tr>
                                 <td>Thread diameter</td>
                                 <td><?php echo $fields['d10']; ?>&nbsp;<?php echo $displayUnit ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($fields['d11'] != 0) : ?>
                              <tr>
                                 <td>Thread pitch [tps] or [mm/thd] (metric)</td>
                                 <td><?php echo $fields['d11']; ?>&nbsp;<?php if ($fields['unit'] == '1'): ?>[tps]<?php else : ?>[mm/thd]<?php endif ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($fields['d12'] != 0) : ?>
                              <tr>
                                 <td>Thread length</td>
                                 <td><?php echo $fields['d12']; ?>&nbsp;<?php echo $displayUnit ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($fields['d13'] != 0) : ?>
                              <tr>
                                 <td>Clamp diameter</td>
                                 <td><?php echo $fields['d13']; ?>&nbsp;<?php echo $displayUnit ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($fields['d14'] != 0) : ?>
                              <tr>
                                 <td>Clamp thickness</td>
                                 <td><?php echo $fields['d14']; ?>&nbsp;<?php echo $displayUnit ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($fields['d15'] != 0) : ?>
                              <tr>
                                 <td>Recommended shaft diameter</td>
                                 <td><?php echo $fields['d15']; ?>&nbsp;<?php if ($fields['d16'] != 0) : ?>(<?php echo $fields['d16'];  ?>) <?php echo $displayUnit ?><?php endif ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($fields['d17'] != 0) : ?>
                              <tr>
                                 <td>Recommended mounting bore</td>
                                 <td><?php echo $fields['d17']; ?>&nbsp;<?php if ($fields['d18'] != 0) : ?>(<?php echo $fields['d18'];  ?>) <?php echo $displayUnit ?><?php endif ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($fields['d19'] != 0) : ?>
                              <tr>
                                 <td>Flange diameter</td>
                                 <td><?php echo $fields['d19']; ?>&nbsp;<?php echo $displayUnit ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($fields['d20'] != 0) : ?>
                              <tr>
                                 <td>Flange thickness</td>
                                 <td><?php echo $fields['d20']; ?>&nbsp;<?php echo $displayUnit ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($fields['d21'] != 0) : ?>
                              <tr>
                                 <td>Flange wrench flat</td>
                                 <td><?php echo $fields['d21']; ?>&nbsp;<?php echo $displayUnit ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($fields['d22'] != 0) : ?>
                              <tr>
                                 <td>Fitting locations</td>
                                 <td><?php echo $fields['d22']; ?>&nbsp;<?php echo $displayUnit ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($fields['d23'] != 0) : ?>
                              <tr>
                                 <td>Mounting holes</td>
                                 <td><?php echo $fields['d23']; ?>&nbsp;<?php echo $displayUnit ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($fields['d38'] != '') : ?>
                              <tr>
                                 <td>Flange Type</td>
                                 <td><?php echo $fields['d38'];  ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($fields['d37'] != 0) : ?>
                              <tr>
                                 <td>Face seal O-ring</td>
                                 <td><?php echo $fields['d37'];  ?></td>
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
                              <?php if ($fields['d25'] != '') : ?>
                              <tr>
                                 <td>Bearing type/material</td>
                                 <td><?php echo $fields['d25'];  ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($fields['d26'] != 0) : ?>
                              <tr>
                                 <td>Bearing load cap</td>
                                 <td><?php echo $fields['d26'];  ?> <?php if ($fields['unit'] == '1') : ?>Pounds<?php else : ?>Kilograms<?php endif ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($fields['d27'] != 0) : ?>
                              <tr>
                                 <td>Bearing dynamic load capacity</td>
                                 <td><?php echo $fields['d27'];  ?> <?php if ($fields['unit'] == '1') : ?>Pounds<?php else : ?>Kilograms<?php endif ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($fields['d28'] != 0) : ?>
                              <tr>
                                 <td>Bearing Dim A</td>
                                 <td><?php echo $fields['d28'];  ?>&nbsp;<?php echo $displayUnit ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($fields['d29'] != 0) : ?>
                              <tr>
                                 <td>Bearing Dim B</td>
                                 <td><?php echo $fields['d29'];  ?>&nbsp;<?php echo $displayUnit ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($fields['fk_shaftID'] == '1') : ?>
                              <tr>
                                 <td colspan="2"><a href="/wp-content/uploads/sites/2/sldBearingDim.jpg" title="Solid Shaft bearing dimensional specifications reference drawing"><img src="/wp-content/uploads/sites/2/sldBearingDim.jpg" alt="Solid Shaft bearing dimensional specifications reference drawing" width="210" height="167" border="0" /></a> <br></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($fields['fk_shaftID'] == '2') : ?>
                              <tr>
                                 <td colspan="2"><a href="/wp-content/uploads/sites/2/hlwBearingDim.jpg" title="Hollow Shaft bearing dimensional specifications reference drawing"><img src="/wp-content/uploads/sites/2/hlwBearingDim.jpg" alt="Hollow Shaft bearing dimensional specifications reference drawing" width="210" height="167" border="0" /></a> <br></td>
                              </tr>
                              <?php endif ?>
                              <tr>
                                 <td colspan="2"><br>
                                    <strong>Performance Characteristics:</strong>
                                 </td>
                              </tr>
                              <?php if ($fields['d30'] != 0) : ?>
                              <tr>
                                 <td>Max Speed</td>
                                 <td><?php echo $fields['d30'];  ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($fields['d31'] != 0) : ?>
                              <tr>
                                 <td>Max Thrust (Axial Load Limit)</td>
                                 <td><?php echo $fields['d31'];  ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($fields['d32'] != 0) : ?>
                              <tr>
                                 <td>Radial Load Capacity</td>
                                 <td><?php echo $fields['d32'];  ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($fields['d24'] != 0) : ?>
                              <tr>
                                 <td>Shaft Torque Capacity</td>
                                 <td><?php echo $fields['d24'];  ?> <?php if ($fields['unit'] == '1') : ?>in-lb<?php else : ?>N-m<?php endif ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($fields['d40'] != 0) : ?>
                              <tr>
                                 <td>Starting Torque 100rpm</td>
                                 <td><?php echo $fields['d40'];  ?>&nbsp;<?php if ($fields['unit'] == '1') : ?>in-oz<?php else : ?>N-mm<?php endif ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($fields['d41'] != 0) : ?>
                              <tr>
                                 <td>Running Torque 100rpm</td>
                                 <td><?php echo $fields['d41'];  ?>&nbsp;<?php if ($fields['unit'] == '1') : ?>in-oz<?php else : ?>N-mm<?php endif ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($fields['d42'] != 0) : ?>
                              <tr>
                                 <td>Starting Torque 1000rpm</td>
                                 <td><?php echo $fields['d42'];  ?>&nbsp;<?php if ($fields['unit'] == '1') : ?>in-oz<?php else : ?>N-mm<?php endif ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($fields['d43'] != 0) : ?>
                              <tr>
                                 <td>Running Torque 1000rpm</td>
                                 <td><?php echo $fields['d43'];  ?>&nbsp;<?php if ($fields['unit'] == '1') : ?>in-oz<?php else : ?>N-mm<?php endif ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($fields['d34'] != 0) : ?>
                              <tr>
                                 <td>Starting Torque</td>
                                 <td><?php echo $fields['d34'];  ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($fields['d35'] != 0) : ?>
                              <tr>
                                 <td>Running Torque</td>
                                 <td><?php echo $fields['d35'];  ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($fields['d36'] != 0) : ?>
                              <tr>
                                 <td>Limiting Speed [rpm]</td>
                                 <td><?php echo $fields['d36'];  ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($fields['d39'] != '') : ?>
                              <tr>
                                 <td>Notes</td>
                                 <td><?php echo $fields['d39'];  ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($fields['nS'] == '1') : ?>
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
                        <p><strong>Ordering Information for Model <?php echo $fields['mNum'];  ?>, Part Number <?php echo $fields['pNum'];  ?></strong></p>
                        <p>If you have questions about pricing and availability, need more information about Ferrotec's <?php echo $fields['mNum']; ?> rotary feedthroughs, or if you have other Ferrofluidic seal requirements, you can submit your request using the form below or <a href="/contact/sales/salesFerrofluidic/"><strong>contact your Ferrotec representative directly&nbsp;&raquo;</strong></a></p>
                        <p><strong>Special Orders, Modifications, and Customized Solutions for Unique Applications</strong></p>
                        <p>Model <?php echo $fields['mNum'];  ?>, Part Number <?php echo $fields['pNum'];  ?> is a standard model vacuum rotary feedthrough. Ferrotec can also customize a <?php echo $product->get_attribute( 'pa_shaft' );  ?> shaft vacuum rotary feedthrough to match your specific application requirements. Please contact Ferrotec for more information.</p>
                        <p><strong>Please Contact Me Regarding Ferrotec Model Number <?php echo $fields['mNum'];  ?></strong></p>
                        <p>Use this form to submit your <?php echo $fields['mNum'];  ?> (part number <?php echo $fields['pNum'];  ?>) inquiry directly to Ferrotec. If you have special requirements or need specific customizations, please include the details in your description. </p>
                     </div>
                     <div class="col-sm-6"></div>
                  </div>
               </div>
               <div role="tabpanel" class="tab-pane" id="downloads">
                  <h3>Available CAD Files</h3>
                  <div style="float:left; text-align:center; width:270px; padding:20px; height:330px; background-color:#1c75bc;">
                     <h4 style="color:#ffffff;">Login to Download Files</h4>
                    
                  </div>
                                         ?>
               </div>
            </div>
         </div>
   </article>
</main>
<!-- #main -->
</div>
      <?php
      $output = ob_get_contents();
      ob_end_clean();
      $content .= " " . $output;
      return $content;

    } 
    if ( $post->post_type == "page" ){
   if (have_rows('rows', $post)){
   
       while (have_rows('rows', $post)): the_row( );
          $content .= " " . get_sub_field('content');
       endwhile;
           return $content;

     }
}
}