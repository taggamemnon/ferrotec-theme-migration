<?php
global $product;
/*
   Template Part: ferrofluid products page content
   */
?>
  <div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">
<?php 

$prod = get_field('woo_prod_id');

$fields = get_fields($prod);
$terms = get_the_terms( $prod, 'product_cat' );
foreach ($terms as $term) {
    $product_cat_id = $term->term_id;
    break;
}
$product_cat = get_term($product_cat_id);
?>
<?php 
  switch ( $fields['fk_seriesID']) {
    case 13:
      $fluid_type = 'EMG Water-based Ferrofluid';
      $page_title = $product_cat->name .' Ferrofluid <br>Type: '. $fields['model'];
      $page_description = 'Ferrotec&rsquo;s  '. $fields['model'] .' Ferrofluid is a member of Ferrotec&rsquo;s family of '. $product_cat->name .' ferrofluids. Unlike Ferrotec&rsquo;s APG series of ferrofluids that have been optimized for audio speaker applications, Ferrotec&rsquo;s EMG Series ferrofluids address a broad range of application requirements and can be used for experimentation and application development. Ferrotec&rsquo;s water-based EMG Series are typically used in applications where rapid evaporation or the ability to mix ferrofluid into a water-based system is required. '. $fields['model'] .' ferrofluid is '. $fields['description'] .' and uses '. $fields['surf_nature'] .' surfactant.';
      $page_more_info = 'Ferrotec '. $product_cat->name .' Ferrofluid Additional Information';
      break;
    case 14:
      $fluid_type = 'EMG Oil-based Ferrofluid';
      $page_title = $product_cat->name .' Ferrofluid <br>Type: '. $fields['model'];
      $page_description = 'Ferrotec&rsquo;s '. $fields['model'] .' Ferrofluid is a member of Ferrotec&rsquo;s family of '. $product_cat->name .' ferrofluids. Unlike Ferrotec&rsquo;s APG series of ferrofluids that have been optimized for audio speaker applications, Ferrotec&rsquo;s EMG Series ferrofluids address a broad range of application requirements and can be used for experimentation and application development. Ferrotec&rsquo;s oil-based EMG Series are typically used in applications where you don&rsquo;t want evaporation or you don&rsquo;t want the ferrofluid to mix the other elements. '. $fields['model'] .' ferrofluid is '. $fields['description'] .'.';
      $page_more_info = 'Ferrotec '. $product_cat->name .' Ferrofluid Additional Information';
      break;
    case 15:
      $fluid_type = 'EMG Dry Magnetic Nanoparticles';
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
    case 17:
      $fluid_type = 'PBG Series Ferrofluids';
      $page_title = $product_cat->name .' Series - PEG-based Ferrofluid<br>Type: '. $fields['model'];
      $page_description = 'Ferrotec&rsquo;s '. $fields['model'] .' Ferrofluid is a member of Ferrotec&rsquo;s family of PBG Series - Polyethylene Glycol (PEG) based ferrofluids. Ferrotec’s PBG Series ferrofluids offer high magnetization, high colloidal stability, low nonspecific binding, biocompatible and superparamagnetic properties needed for a broad range of experimentation and application development. PBG series ferrofluids have longer life than our EMG series water-based ferrofluids. Ferrotec&rsquo;s '. $fields['model'] .' ferrofluid is Black-brown fluid and uses nonionic surfactant.';
      $page_more_info = 'Ferrotec '. $product_cat->name .' Ferrofluid Additional Information';
      break;
    default:
      $fluid_type = 'Ferrofluid';
      $page_title = $product_cat->name .' Ferrofluid<br>Type: '. $fields['model'];
      $page_description = 'Ferrotec&rsquo;s '. $fields['model'] .' '. $fields['seriesType'] .' Ferrofluid is a member of Ferrotec&rsquo;s family of '. $product_cat->name .' ferrofluids for speaker applications. The '. $product_cat->name .' is '. $fields['description'] .' and uses a '. $fields['liquidType'] .' carrier liquid.';
      $page_more_info = 'Ferrotec '. $product_cat->name .' Ferrofluid Additional Information';
      break;
  }
     ?>
   <header class="page-header">
         <div class="page-banner" >
            <div class="container">
              <span style="display:none"><?php echo $fields['seriesID'] ?></span>
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
<div class="container-wrapper content-padding bkg-lr-penny2 cta-with-image">
        <div class="container">

<?php
$queried_post=get_post(530);
echo $queried_post->post_content;

?>
</div>
</div>

</article>
</main>

</div>
