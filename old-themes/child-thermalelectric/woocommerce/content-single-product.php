<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;
$fields = get_fields($product->ID);
$primary_cat = get_primary_taxonomy_term($product->ID, 'product_cat');
$product_cat = get_term( $primary_cat['term_id'] );
      $pagetitle = 'Thermoelectric Modules';
      $bodytitle = 'Peltier Cooler Model '.$fields['fullPN'];


/*    $mod_id = "'".unmakeurls(get_query_var( 'id', 'not found' ))."'"; */

 /* moved this into loop to get post ID  $idFromURL= get_field('fullPN', $post->ID ); //$mod_id; */
    $request_var['settings']='adv';
    $mode    = $request_var['mode'];
    $th=50;
    $amb=50;
    $hs=0;
    $num_mod=1.0;
    $start_dt=0;
    //DEFAULTS
    $th_def=50;
    $amb_def=50;
    $hs_def=0;
    $num_mod_def=1.0;
    $start_dt_def=0;
  
  
  // FOR ADVANCED MODE
  if(isset($request_var['mode'])&&$request_var['mode']==1)
  {
    $th = $request_var['th']*1.0;
    $amb= $request_var['amb']*1.0;
    $hs= $request_var['hs']*1.0;
    $start_dt= $request_var['start_dt']*1.0;
    $num_mod= $request_var['num_mod']!=''?$request_var['num_mod']*1.0:1.0;
    //$th = 0;
    //$amb= 20;
  }
  else
  {
    if(isset($request_var['settings']))
    {
      if(isset($request_var['th']))
        $th = $request_var['th'];
      if($request_var['settings']='adv')
      {
        if(isset($request_var['amb']))
          $amb = $request_var['amb'];
        if(isset($request_var['hs']))
          $hs = $request_var['hs'];
          $th = $amb;
      }
    }
  }
  
    $setTab = "std";
    $familyIncludes = array(1,2,5,6,7,8,10,12,14);
  
     //SET DEFAULT TAB
     if(isset($request_var['t']))
       $setTab = $request_var['t'];
     else
       $setTab = "std";
  
     $visible    = "style='display:inline; visibility:visible;'";
     $invisible  = "style='display:none; visibility:hidden;'";
  
  
  
    $title = 'Ferrotec Thermoelectric Modules - Peltier Cooler Model '.$fields['fullPN']; 

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked wc_print_notices - 10
 */
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
  echo get_the_password_form(); // WPCS: XSS ok.
  return;
}
?>
<div id="popup1" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button> 
        <div id="graph_expand1" class="chart"></div>
      </div>
    </div>
  </div>
</div>


<div id=disable_screen style="z-index:1000;visibility:hidden;display:none;height:100%;width:100%;position:absolute;top:0;left:0;opacity:.50;background-color:#888888;filter:alpha(opacity=50)"></div>
<div id=loading style="z-index:1;visibility:hidden;display:none;border-style:solid;opacity:1.0;padding:15px;position:absolute;text-align:center;background-color:#FFFFFF;width:200;height:60;font-size:24px;font-weight:700;line-height:24px">
  Updating<br>
  Graphs
</div>

<div id="product-<?php the_ID(); ?>" <?php wc_product_class( '', $product ); ?>>

  <?php
  /**
   * Hook: woocommerce_before_single_product_summary.
   *
   * @hooked woocommerce_show_product_sale_flash - 10
   * @hooked woocommerce_show_product_images - 20
   */
  do_action( 'woocommerce_before_single_product_summary' );
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
          <?php if (get_field('pdf_filename')): ?>
               <li role="presentation" <?php if($action!="")
                  { ?> class="active" <?php } ?>>
                  <a href="#downloads" aria-controls="downloads" role="tab" data-toggle="tab">
                     <div class="visible-xs tabicon icn-downloads"></div>
                     <div class="hidden-xs">Downloads</div>
                  </a>
               </li>
             <?php endif; ?>
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
              <img src="/wp-content/uploads/sites/4/thermal/<?php the_field('dimFile', $product_cat ); ?>" >
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
              <?php if( $fields['graph_flag'] != 'false' && $fields['graph_flag'] != '' && $fields['graph_flag'] != '0' ) : ?>
              <h3><br />Standard Performance Curves</h3>
              <?php
                $graph_tg   = 10;
                $graph_tmax = 70;
                //$te_id      = $request_var['mod_id'];
                $th         = $th_def;
                $tg         = $graph_tg;
                $tmax       = $graph_tmax+$start_dt_def;
                $tmin       = $start_dt_def;
                $hs         = $hs_def*$num_mod_def;
                $amb        = $amb_def;
                $module_ID  = $fields['module_id'];
                ?>
              <div style="overflow:visible; clear:both; position:relative;">
                <div class="col-sm-6 col-lg-3">
                  <div id="ferograph0" class="graph"></div>
                </div>
                <div class="col-sm-6 col-lg-3">
                  <div id="ferograph1" class="graph"></div>
                </div>
                <div class="visible-sm-block visible-md-block clearfix"></div>
                <div class="col-sm-6 col-lg-3">
                  <div id="ferograph2" class="graph"></div>
                </div>
                <div class="col-sm-6 col-lg-3">
                  <div id="ferograph3" class="graph"></div>
                </div>
              </div>

              <?php endif ?>
              <h3>Custom Options</h3>
              <p>Ferrotec can also customize a <?php echo displayFamily($fields['fk_tefamilyinfoid']) ?> Module for you based on the <?php echo $fields['fullPN'] ?>. <br />Note: minimum quantity custom order limitations apply. </p>
              <h3>About Ferrotec&rsquo;s <?php echo displayFamily($fields['fk_tefamilyinfoid']) ?> Module Family</h3>
              <?php if  ( get_field('stdDesc', $product_cat ) && get_field('stdDesc', $product_cat ) != 'NULL' ) : ?>
                <p><?php the_field('stdDesc', $product_cat );?></p>
              <?php endif ?>
              <?php if  ( get_field('bigDesc', $product_cat ) && get_field('bigDesc', $product_cat ) != 'NULL' ) : ?>
                <p><?php the_field('bigDesc', $product_cat );  ?></p>
              <?php endif ?>
            </div>
          </div>
        </div>
        <?php //----------------- Tab: Thermal Modeling ------------------//
          if( $fields['graph_flag'] != 'false' && $fields['graph_flag'] !='' && $fields['graph_flag'] != '0' ) : ?>

        <div role="tabpanel" class="tab-pane" id="tmodel">
          <!-- thermal modeling tab -->
          <div id=tabBodyLeft>
            <form id="form1" name="advanced_form" method="post" action="index.php?t=adv&id=module_detail&mod_id=<?php echo $fields['fullPN'] ?>">
              <div class="table-responsive">
                <table class="table table-striped">
                  <tr>
                    <td rowspan="4"><img src="/wp-content/uploads/sites/4/thermal-site/illust_te_heatsink.jpg"></td>
                    <td>Ambient Temperature </td>
                    <td><input name="amb" type="text" value="<?php echo $amb ?>" size="5" />&deg;C</td>
                    <td rowspan="3" valign="top">
                      <b>Step 1</b><br>
                      Input modeling variables<br><br>
                      <b>Step 2</b><br>
                      Click &ldquo;Recalculate&rdquo;
                    </td>
                  </tr>
                  <tr>
                    <td>Thermal Resistance (Heat Sink) </td>
                    <td><input name="hs" type="text" value="<?php echo $hs ?>" size="5" />&deg;C / Watt
                      <input type="hidden" name="settings" value="adv" />
                    </td>
                  </tr>
                  <tr>
                    <td>Number of Modules </td>
                    <td><input name="num_mod" type="text" value="<?php echo $num_mod ?>" size="5" /></td>
                  </tr>
                  <tr>
                    <td>Starting dT </td>
                    <td><input name="start_dt" type="text" value="<?php echo $start_dt ?>" size="5" />&deg;C</td>
                    <td align="center">
                      <input type="button" onClick="ga('send', 'event', 'TE Detail', 'Recalculate', '<?php echo $fields['fullPN'] ?>'); execute_calc(1);" value="Recalculate" />
                    </td>
                  </tr>
                </table>
              </div>
              <h2><?php echo $fields['fullPN'] . " &mdash; " ; ?>Performance Curves</h2>
              <p>Note: Curves shown are calculated on a 'per module' basis.</p>
              <div >
                <div class="col-sm-6 col-lg-3">
                  <div id="ferograph4" class="graph"></div>
                </div>
                <div class="col-sm-6 col-lg-3">
                  <div id="ferograph5" class="graph"></div>
                </div>
                <div class="visible-sm-block visible-md-block clearfix"></div>
                <div class="col-sm-6 col-lg-3">
                  <div id="ferograph6" class="graph"></div>
                </div>
                <div class="col-sm-6 col-lg-3">
                  <div id="ferograph7" class="graph"></div>
                </div>
              </div>
            </form>
          </div>
        </div>
        <?php endif ?>
        <div role="tabpanel" class="tab-pane" id="order">
          <!-- ordering tab -->
          <div id="tabBodyLeft">
            <h2>Ordering Information</h2>
            <?php
              gravity_form( 'te-inquiry', false, false, false );
               ?>
          </div>
        </div>
          <?php if (get_field('pdf_filename')): ?>

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
                  <h3>Available Files</h3>
                  <div class="row">
                  <div class="col-md-6">
                  <div class="vf-downloads_wrapper">
                        <p style="text-align:left;"> Model: <?php the_field('fullPN'); ?></p>
                     <a target="_blank" href="<?php the_field('pdf_filename'); ?>">
                        <div style="width:100px; margin-left:15px; float:left; height:30px; line-height:30px; background-color:#ffffff; border:1px solid #cccccc;">
                           PDF
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
      <?php endif; ?>
        <!-- *************************************** -->
      </div>
    </div>
  </main>
</div>
  <div class="summary entry-summary">
    <?php
    /**
     * Hook: woocommerce_single_product_summary.
     *
     * @hooked woocommerce_template_single_title - 5
     * @hooked woocommerce_template_single_rating - 10
     * @hooked woocommerce_template_single_price - 10
     * @hooked woocommerce_template_single_excerpt - 20
     * @hooked woocommerce_template_single_add_to_cart - 30
     * @hooked woocommerce_template_single_meta - 40
     * @hooked woocommerce_template_single_sharing - 50
     * @hooked WC_Structured_Data::generate_product_data() - 60
     */
    //do_action( 'woocommerce_single_product_summary' );
    ?>
  </div>

  <?php
  /**
   * Hook: woocommerce_after_single_product_summary.
   *
   * @hooked woocommerce_output_product_data_tabs - 10
   * @hooked woocommerce_upsell_display - 15
   * @hooked woocommerce_output_related_products - 20
   */
  //do_action( 'woocommerce_after_single_product_summary' );
  ?>
</div>
              <script>
                var graph=new Array();
                var graphWidth, expandedWidth, graph_expand1, bigWidth;
                function drawCharts( name, index ) {
                  execute_graphs(<?php echo $module_ID ?>,<?php echo $th ?>,<?php echo $tg ?>,<?php echo $tmax ?>,<?php echo $tmin ?>,<?php echo $hs ?>,<?php echo $amb ?>, name ,'ferograph' + index ,['#popup1','graph_expand1'], index);

                }

                google.charts.setOnLoadCallback( 
                	function(){                 
                	var graph_setup = Array( 'qc', 'v', 'qh', 'cop' );
                	graph_setup.forEach( drawCharts );
                	graph_expand1 = new google.visualization.LineChart(document.getElementById('graph_expand1'));
                 });
                jQuery(function($){

                graphWidth = $("#ferograph1").width();   
                bigWidth = 568;   
                
                jQuery('#tab2').on('shown.bs.tab', function (e) {
                  open_tab2();
                });
                jQuery('#popup1').on('shown.bs.modal', function (e) {
                  showBigChart();
                });
                });
                var chartData = []; var charts = []; var charts_tab2 = []; var bigOptions = [];

                function execute_graphs(id,th,tg,tmax,tmin,hs,amb,curve,con,big, i) {
                jQuery.getJSON('/wp-content/themes/layers2/includes/phpimages/therhs_json_google_chart.php?id='+id+'&th='+th+'&tg='+tg+'&tmax='+tmax+'&tmin='+tmin+'&hs='+hs+'&amb='+amb+'&curve='+curve, function(data) {
                  bigOptions[i] = {
                    title: data.title,
                    titleTextStyle: {
                      fontSize:20
                    },
                    curveType: 'function',
                    legend: { position: 'right', alignment:'center' },
                    height: bigWidth,
                    width: bigWidth,
                    hAxis: {
                      title:data.xtitle,
                      viewWindow :{
                        min:0,
                        max:data.imax
                      },
                      gridlines:{
                        count:8,
                      },
                      maxAlternation: 1,
                    },
                    vAxis:{
                      title:data.ytitle,
                      viewWindow:{
                        min:0,
                        max:data.maxy
                      },
                      gridlines:{
                        count:5
                      }
                    },
                    chartArea: {
                        left:'12%',
                        top:'12%',
                        width:'70%',
                        height:'70%',
                        backgroundColor: {
                            //strokeWidth: 1,
                        }
                    },
                  };
                  var chartOptions = {
                    title: data.title,
                    titleTextStyle: {
                      fontSize:12
                    },
                    curveType: 'function',
                    legend: { position: 'right', alignment:'center' },
                    height: graphWidth,
                    width: graphWidth,
                    hAxis: {
                      title:data.xtitle,
                      viewWindow :{
                        min:0,
                        max:data.imax
                      },
                      gridlines:{
                        count:8,
                      },
                      maxAlternation: 1,
                      slantedText:true,
                      slantedTextAngle:75
                    },
                    vAxis:{
                      title:data.ytitle,
                      viewWindow:{
                        min:0,
                        max:data.maxy
                      },
                      gridlines:{
                        count:5
                      }
                    },
                    chartArea: {
                        left:'14%',
                        width:'55%',
                        backgroundColor: {
                            //strokeWidth: 1,
                        }
                    }

                  };


                  chartData[i] = new google.visualization.arrayToDataTable(Object.values(data.dataTable), false);

                  charts[i] = new google.visualization.LineChart(document.getElementById(con));

                  charts[i].draw(chartData[i], chartOptions);

                  google.visualization.events.addListener(charts[i], 'click', function() {

                      jQuery('#popup1').modal('show');
                      bigChart=i;

                  });

                });
                }
                function expand_graph(id,th,tg,tmax,tmin,hs,amb,curve,con,big) {
                jQuery('#popup1').modal('show');
                jQuery.getJSON('/wp-content/themes/layers2/includes/phpimages/therhs_json_google_chart.php?id='+id+'&th='+th+'&tg='+tg+'&tmax='+tmax+'&tmin='+tmin+'&hs='+hs+'&amb='+amb+'&curve='+curve, function(data) {
                if(graph[con] != undefined)
                  graph[con].remove();
                jQuery('#'+con).html(" ");
                expandedWidth = jQuery('#graph_expand1').width();
                });


                }

  var tg  = <?php echo $graph_tg ?>;
  var amb = <?php echo $amb ?>;
  var tmax;
  var tmin;
  var th;
  var hs;
  
  var maxtab=2;
  var curtab=0;
  
  function execute_calc(mode)
  {
    //SIMPLE
    if (mode=='0')
    {
      th = document.standard_form.th.value;
      amb = document.standard_form.th.value;
      tmax = <?php echo $graph_tmax ?>;
      tmin = 0;
      hs = 0;
    }
    //ADVANCED
    else
    {
      hs = (document.advanced_form.hs.value*document.advanced_form.num_mod.value);
      th = document.advanced_form.amb.value;
      amb = document.advanced_form.amb.value;
      tmax = (<?php echo $graph_tmax;?>+document.advanced_form.start_dt.value*1);
      tmin = document.advanced_form.start_dt.value;
    }
    disable_screen();
    setTimeout('enable_screen()', 1000);
     
    execute_graphs(<?php echo $module_ID ?>,th,tg,tmax,tmin,hs,amb,'qc','ferograph4',['#popup1','graph_expand1'], 4);
    execute_graphs(<?php echo $module_ID ?>,th,tg,tmax,tmin,hs,amb,'v','ferograph5',['#popup1','graph_expand1'], 5);
    execute_graphs(<?php echo $module_ID ?>,th,tg,tmax,tmin,hs,amb,'qh','ferograph6',['#popup1','graph_expand1'], 6);
    execute_graphs(<?php echo $module_ID ?>,th,tg,tmax,tmin,hs,amb,'cop','ferograph7',['#popup1','graph_expand1'], 7);

  }
  
  function open_tab2(mode)
  {
    //SIMPLE
    if (mode=='0')
    {
      th = document.standard_form.th.value;
      amb = document.standard_form.th.value;
      tmax = <?php echo $graph_tmax ?>;
      tmin = 0;
      hs = 0;
    }
    //ADVANCED
    else
    {
      hs = (document.advanced_form.hs.value*document.advanced_form.num_mod.value);
      th = document.advanced_form.amb.value;
      amb = document.advanced_form.amb.value;
      tmax = (<?php echo $graph_tmax;?>+document.advanced_form.start_dt.value*1);
      tmin = document.advanced_form.start_dt.value;
    }
    execute_graphs(<?php echo $module_ID ?>,th,tg,tmax,tmin,hs,amb,'qc','ferograph4',['#popup1','graph_expand1'], 4);
    execute_graphs(<?php echo $module_ID ?>,th,tg,tmax,tmin,hs,amb,'v','ferograph5',['#popup1','graph_expand1'], 5);
    execute_graphs(<?php echo $module_ID ?>,th,tg,tmax,tmin,hs,amb,'qh','ferograph6',['#popup1','graph_expand1'], 6);
    execute_graphs(<?php echo $module_ID ?>,th,tg,tmax,tmin,hs,amb,'cop','ferograph7',['#popup1','graph_expand1'], 7);
  }
  
  function showBigChart(){
      graph_expand1.draw( chartData[bigChart], bigOptions[bigChart] )
  }
  function disable_screen()
  {
    var x,y,t,l;
    if (self.innerHeight) // all except Explorer
    {
          x = self.innerWidth;
          y = self.innerHeight;
          t = window.pageYOffset;
    }
    else if (document.documentElement && document.documentElement.clientHeight)
          // Explorer 6 Strict Mode
    {
          x = document.documentElement.clientWidth;
          y = document.documentElement.clientHeight;
          t = document.documentElement.scrollTop;
    }
    else if (document.body) // other Explorers
    {
          x = document.body.clientWidth;
          y = document.body.clientHeight;
          t = document.body.scrollTop;
    }
  
    var a=document.getElementById('disable_screen');
  
    a.style.visibility='visible';
    a.style.display='block';
    a.style.top=t+'px';
    a.style.height=y+'px';
    a.style.width=x+'px';
    var b=document.getElementById('loading');
    b.style.visibility='visible';
    b.style.display='block';
    b.style.top=t+Math.round(y/2-100/2)+'px';
    b.style.left=Math.round(x/2-150/2)+'px';
  }
  
  function enable_screen()
  {
    var x=document.getElementById('disable_screen');
    x.style.visbility='hidden';
    x.style.display='none';
    var y=document.getElementById('loading');
    y.style.visbility='hidden';
    y.style.display='none';
  }
  
  function popWin(url,title,w,h)
  {
    var obj_lkupwindow = window.open(url,title,'status=1,resizable=1,scrollbars=0,top=200,left=200,dependent=1,alwaysRaised=1,width='+w+',height='+h);
    obj_lkupwindow.opener = window;
    obj_lkupwindow.focus();
  }
  jQuery('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    ga('send', 'event', 'TE Detail', 'Tab', '<?php echo $fields['fullPN'] ?>');
  })

</script>
<?php //do_action( 'woocommerce_after_single_product' ); ?>
