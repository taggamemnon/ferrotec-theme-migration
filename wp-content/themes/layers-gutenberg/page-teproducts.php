<?php
  /*
     Template Name: Thermoelectric Product Page
     */
// global $tetitle , $te_url; 
/*    $tetitle = 'Ferrotec Thermoelectric Modules - Peltier Cooler Model '.$fields['fullPN']; 
  switch ($te_family) {
    case 8:
      $te_url="https://thermal.ferrotec.com/products/peltier-thermoelectric-cooler-modules/high-power/".makeurls($fields['fullPN']);
      break;
    case 10:
      $te_url="https://thermal.ferrotec.com/products/peltier-thermoelectric-cooler-modules/longlife/".makeurls($fields['fullPN']);
      break;
    case 12:
      $te_url="https://thermal.ferrotec.com/products/peltier-thermoelectric-cooler-modules/telecom/".makeurls($fields['fullPN']);
      break;
    case 14:
      $te_url="https://thermal.ferrotec.com/products/peltier-thermoelectric-cooler-modules/general-purpose/".makeurls($fields['fullPN']);
      break;
    case 15:
      $te_url="https://thermal.ferrotec.com/products/peltier-thermoelectric-cooler-modules/deep-cooling/".makeurls($fields['fullPN']);
      break;
    case 16:
      $te_url="https://thermal.ferrotec.com/products/peltier-thermoelectric-cooler-modules/special-design/".makeurls($fields['fullPN']);
      break;

  }
*/
  get_header('teproduct') ?>

<div id="popup1" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button> 
        <div id="graph_expand1" class="chart"></div>
      </div>
      <!--div class="modal-footer"> <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> <button type="button" class="btn btn-primary">Save changes</button> </div-->
    </div>
  </div>
</div>

<?php
/*    $mod_id = "'".unmakeurls(get_query_var( 'id', 'not found' ))."'"; */

 /* moved this into loop to get post ID  $idFromURL= get_field('fullPN', $post->ID ); //$mod_id; */
    $request_var['settings']='adv';
    //$mode    = $request_var['mode'];
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
  
  
  
      $prod = get_field('woo_prod_id');

      $fields = get_fields($prod);
    $title = 'Ferrotec Thermoelectric Modules - Peltier Cooler Model '.$fields['fullPN']; ?>

<div id=disable_screen style="z-index:0;visibility:hidden;display:none;height:100%;width:100%;position:absolute;top:0;left:0;opacity:.50;background-color:#888888;filter:alpha(opacity=50)"></div>
<div id=loading style="z-index:1;visibility:hidden;display:none;border-style:solid;opacity:1.0;padding:15px;position:absolute;text-align:center;background-color:#FFFFFF;width:200;height:60;font-size:24px;font-weight:700;line-height:24px">
  Updating<br>
  Graphs
</div>
    <?php if ( have_posts() ) : ?>
     <?php while ( have_posts() ) : the_post(); ?>
<?php /*get_template_part('template-parts/content','teproducts'); */ ?>
<?php
global $product;
  /*
     Template part: content of Thermoelectric Product Page
     */
     ?>
      <?php 
      $prod = get_field('woo_prod_id');

      $fields = get_fields($prod);

      $terms = get_the_terms( $prod, 'product_cat' );
      foreach ($terms as $term) {
          $product_cat_id = $term->term_id;
          break;
      }
      $product_cat = get_term($product_cat_id);

      //$pagetitle = 'Ferrotec Thermoelectric Modules - <br />Peltier Cooler Model '.$fields['fullPN'];
      $pagetitle = 'Thermoelectric Modules';
      $bodytitle = 'Peltier Cooler Model '.$fields['fullPN'];
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
                  <div id="ferograph1" class="graph"></div>
                </div>
                <div class="col-sm-6 col-lg-3">
                  <div id="ferograph2" class="graph"></div>
                </div>
                <div class="visible-sm-block visible-md-block clearfix"></div>
                <div class="col-sm-6 col-lg-3">
                  <div id="ferograph3" class="graph"></div>
                </div>
                <div class="col-sm-6 col-lg-3">
                  <div id="ferograph4" class="graph"></div>
                </div>
              </div>
              <script>
                var graph=new Array();
                var graphWidth, expandedWidth;
                jQuery(function($){

                graphWidth = jQuery("#ferograph1").width();   

//document.getElementById('ferograph1').offsetWidth;         
                execute_graphs(<?php echo $module_ID ?>,<?php echo $th ?>,<?php echo $tg ?>,<?php echo $tmax ?>,<?php echo $tmin ?>,<?php echo $hs ?>,<?php echo $amb ?>,'qc','ferograph1',['#popup1','graph_expand1']);
                execute_graphs(<?php echo $module_ID ?>,<?php echo $th ?>,<?php echo $tg ?>,<?php echo $tmax ?>,<?php echo $tmin ?>,<?php echo $hs ?>,<?php echo $amb ?>,'v','ferograph2',['#popup1','graph_expand1']);
                execute_graphs(<?php echo $module_ID ?>,<?php echo $th ?>,<?php echo $tg ?>,<?php echo $tmax ?>,<?php echo $tmin ?>,<?php echo $hs ?>,<?php echo $amb ?>,'qh','ferograph3',['#popup1','graph_expand1']);
                execute_graphs(<?php echo $module_ID ?>,<?php echo $th ?>,<?php echo $tg ?>,<?php echo $tmax ?>,<?php echo $tmin ?>,<?php echo $hs ?>,<?php echo $amb ?>,'cop','ferograph4',['#popup1','graph_expand1']);
                
                jQuery('#tab2').on('shown.bs.tab', function (e) {
                  open_tab2();
                });
                });
                function execute_graphs(id,th,tg,tmax,tmin,hs,amb,curve,con,big) {
                jQuery.getJSON('/wp-content/themes/layers2/includes/phpimages/therhs_json.php?id='+id+'&th='+th+'&tg='+tg+'&tmax='+tmax+'&tmin='+tmin+'&hs='+hs+'&amb='+amb+'&curve='+curve, function(data) {
                if(graph[con] != undefined)
                  graph[con].remove();
                jQuery('#'+con).html(" ");
                graph[con] = new Raphael(con).thermal_graph(graphWidth,graphWidth,curve,data);
                jQuery('#'+con).unbind('click');
                jQuery('#'+con).bind('click',function() {
                  expand_graph(id,th,tg,tmax,tmin,hs,amb,curve,big[1],big[0]);
                });
                });
                }
                function expand_graph(id,th,tg,tmax,tmin,hs,amb,curve,con,big) {
                jQuery(big).modal('show');
                jQuery.getJSON('/wp-content/themes/layers2/includes/phpimages/therhs_json.php?id='+id+'&th='+th+'&tg='+tg+'&tmax='+tmax+'&tmin='+tmin+'&hs='+hs+'&amb='+amb+'&curve='+curve, function(data) {
                if(graph[con] != undefined)
                  graph[con].remove();
                jQuery('#'+con).html(" ");
                expandedWidth = jQuery('#graph_expand1').width();
                console.log(expandedWidth);
                graph[con] = new Raphael(con).thermal_graph(expandedWidth,expandedWidth,curve,data);
                });


                }

              </script>
              <style>
                .graph {
                /*width:300px;*/
                /*height:300px;*/
                /*border:1px solid #CCC;*/
                background-color:#EEE;
                /*margin:2px;*/
                /*padding-left:1px;*/
                min-height:1px;
                position:relative;
                width:100%;
                }
                .popup-bkg { position:absolute; z-index:-1000; top:0px; left:0px; width:615px; height:655px; background-color:#FFF; display:block; overflow:hidden; }
                .popup { position:absolute; z-index:-2000; top:0px; left:0px; width:615px; height:655px; background-color:#FFF; display:block; overflow:hidden; }
                .popup .close { float:right; height:30px; margin-top:15px; margin-right:15px; }
                .popup .close a { font-size:14px; line-height:15px; background-image:url('/wp-content/uploads/icon_close_off.png'); background-position:right; background-repeat:no-repeat; padding:5px 35px 5px; 0px; }
                .popup .close a:hover { background-image:url('/wp-content/uploads/icon_close_active.png');  }
                .popup .chart { float:left;  width:600px; height:600px; background-color:#eee; border:1px solid #ccc;}
              </style>
              <?php endif ?>
              <h2>&nbsp;</h2>
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
                  <div id="ferograph5" class="graph"></div>
                </div>
                <div class="col-sm-6 col-lg-3">
                  <div id="ferograph6" class="graph"></div>
                </div>
                <div class="visible-sm-block visible-md-block clearfix"></div>
                <div class="col-sm-6 col-lg-3">
                  <div id="ferograph7" class="graph"></div>
                </div>
                <div class="col-sm-6 col-lg-3">
                  <div id="ferograph8" class="graph"></div>
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
            <?php 
              //$this->assign('sf_next','sf_get_tsi_form');
              //echo fetch($this,'db:sfengine');
              ?>
          </div>
        </div>
      </div>
    </div>
  </main>
</div>


<?php // end of included file ?>
              <?php endwhile; // end of the loop. ?>
<?php endif; ?>

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
<script>
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
    setTimeout('enable_screen()', 2000);
  
    execute_graphs(<?php echo $module_ID ?>,th,tg,tmax,tmin,hs,amb,'qc','ferograph5',['#popup1','graph_expand1']);
    execute_graphs(<?php echo $module_ID ?>,th,tg,tmax,tmin,hs,amb,'v','ferograph6',['#popup1','graph_expand1']);
    execute_graphs(<?php echo $module_ID ?>,th,tg,tmax,tmin,hs,amb,'qh','ferograph7',['#popup1','graph_expand1']);
    execute_graphs(<?php echo $module_ID ?>,th,tg,tmax,tmin,hs,amb,'cop','ferograph8',['#popup1','graph_expand1']);
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
    execute_graphs(<?php echo $module_ID ?>,th,tg,tmax,tmin,hs,amb,'qc','ferograph5',['#popup1','graph_expand1']);
    execute_graphs(<?php echo $module_ID ?>,th,tg,tmax,tmin,hs,amb,'v','ferograph6',['#popup1','graph_expand1']);
    execute_graphs(<?php echo $module_ID ?>,th,tg,tmax,tmin,hs,amb,'qh','ferograph7',['#popup1','graph_expand1']);
    execute_graphs(<?php echo $module_ID ?>,th,tg,tmax,tmin,hs,amb,'cop','ferograph8',['#popup1','graph_expand1']);
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
<?php get_footer(); ?>