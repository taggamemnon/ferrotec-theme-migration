<?php
/**
 * ferrotec functions and definitions
 *
 * @package thermalelectric
 */

function thermalelectric_enqueue_styles() {

    $parent_style = 'layers-style'; // This is 'twentyfifteen-style' for the Twenty Fifteen theme.

    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'thermal-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style ),
        wp_get_theme()->get('Version')
    );
    wp_enqueue_script(
      'thermal-scripts',
      get_stylesheet_directory_uri() . '/js/therm_scripts.js',
      array('jquery'),
      '',
      true
    );
}
add_action( 'wp_enqueue_scripts', 'thermalelectric_enqueue_styles' );



   function raphael2_scripts () {
   	if ( is_page_template( 'template-thermal-graph-product-page.php' ) ) {
   	    wp_enqueue_script(
   	      'raphael',
   	      get_template_directory_uri() . '/js/raphael-min.js',
   	      array('jquery'),
   	      '',
   	      false
   	    );
   	    wp_enqueue_script(
   	      'graphs',
   	      get_template_directory_uri() . '/js/g.ferrotec.js',
   	      array('raphael', 'jquery'),
   	      '',
   	      false
   	    );  
   	}
  }
  
  add_action('wp_enqueue_scripts', 'raphael2_scripts');

function show_thermalelectric_family($atts, $content = null){
    $a = shortcode_atts( array(
        'family' => '',
    ), $atts );
    $output = '';
    $results = new fProducts;
    $pline_set_data = $results->get_module_data( $a['family'] );
    $family_detail = $results->get_family_detail_data( $a['family'] );
        foreach ($family_detail as $family ){
            /*$output .= '<div style="overflow:auto">';
            if ($a['family'] != 14){
            $output .= '<img align=right valign=bottom src="/thermal-site/'. $family->photo1 .'">';
            $output .= '<div id=text_block_c>';
                $output .= '<p>';
                $output .= $family->stdDesc;
                $output .= '</p>';
                $output .= `<p>For questions about specific peltier coolers or to place an order, contact your Ferrotec thermal solutions representative or use the <a href="/products/thermal/modules/teInquiry/"><b>Thermal Solutions Inquiry Form.</b></a></p>`;
                $output .= '</div>';
            }
            $output .= '</div>';*/
            $output .= '<div id="list_display" class="table-responsive">';
            $output .= '<table id=listing class="tablesorter table table-striped" width="100%" border="0" cellpadding="0" cellspacing="0">';
            $output .= '<thead>';
            $header=array('Model Number','I Max','V Max','&Delta;T Max','Qc Max');
            switch($a['family'])
            {
              case 3:
              case 11:
                $header=array_merge($header,array('W1 Dim','W2 Dim','L1 Dim','L2 Dim','Height'));
                break;
              case 1:
              case 2:
              case 8:
                $header=array_merge($header,array('Base W','Base L','Top W','Top L','Height'));
                break;
              case 9:
                $header=array_merge($header,array('W1 Dim','L1 Dim','L2 Dim','Height'));
                break;
              case 4:
                $header=array_merge($header,array('W1 Dim','W2 Dim','W3 Dim','L1 Dim','L2 Dim','L3 Dim','Height'));
                break;
              case 5:
                $header=array_merge($header,array('W1 Dim','L1 Dim','Height','Inner Diam'));
                break;
              case 6:
                $header=array_merge($header,array('Height','Inner Diam','Outer Diam'));
                break;
              case 7:
                $header=array_merge($header,array('W1 Dim','L1 Dim','Height'));
                break;
              case 10:
                $header=array_merge($header,array('Base W','Base L','Top W','Top L','Height'));
                break;
              case 12:
                $header=array_merge($header,array('Base W','Base L','Top W','Top L','Height'));
                break;
             case 13:
                $header=array_merge($header,array('Base W','Base L','Top W','Top L','Height'));
                break;
              case 14:
                $header=array_merge($header,array('Base W','Base L','Top W','Top L','Height'));
                break;
              case 15:
                $header=array_merge($header,array('Base W','Base L','Top W','Top L','Height','Type'));
                break;
              case 16:
                $header=array_merge($header,array('Base W','Base L','Top W','Top L','Height','Type'));
                break;
              case 17:
                $header=array_merge($header,array('Base W','Base L','Top W','Top L','Height'));
                break;
              default:
              break;
            }
            $output .= '<tr>';
            foreach($header as $th){
                $output .= '<th>'.$th.'</th>';
            }
            $output .= '</tr>';
            $output .= '</thead>';
            $output .= '<tbody>';
            foreach ($pline_set_data as $product ){
                $output .= '<tr>';

                $output .= '  <td class="te-cat-row link"><a href="/products/peltier-thermoelectric-cooler-modules/'. makeurls($product->fullPN) .'">'. $product->fullPN .'</a></td>';
                $output .= '  <td>'. $product->iMax .'</td><td>'. $product->vMax .'</td><td>'. $product->tMax .'</td><td>'. $product->qcMax .'</td>';
                if ($a['family'] == 2 || $a['family'] == 1 || $a['family'] == 9) {
                  $output .= '<td>'. $product->w1Dim .'</td><td>'. $product->l1Dim .'</td><td>'. $product->l2Dim .'</td><td>'. $product->hDim .'</td>';
                }
                if ($a['family'] == 3 || $a['family'] == 11) {
                  $output .= '<td>'. $product->w1Dim .'</td><td>'. $product->w2Dim .'</td><td>'. $product->l1Dim .'</td><td>'. $product->l2Dim .'</td><td>'. $product->hDim .'</td>';
                }
                if ($a['family'] == 4) {
                  $output .= '<td>'. $product->w1Dim .'</td><td>'. $product->w2Dim .'</td><td>'. $product->w3Dim .'</td>';
                  $output .= '<td>'. $product->l1Dim .'</td><td>'. $product->l2Dim .'</td><td>'. $product->l3Dim .'</td><td>'. $product->hDim .'</td>';
                }
                if ($a['family'] == 5) {
                  $output .= '<td>'. $product->w1Dim .'</td><td>'. $product->l1Dim .'</td><td>'. $product->hDim .'</td><td>'. $product->idDim .'</td>';
                }
                if ($a['family'] == 6) {
                  $output .= '<td>'. $product->hDim .'</td><td>'. $product->idDim .'</td><td>'. $product->oDim .'</td>';
                }
                if ($a['family'] == 7) {
                  $output .= '<td>'. $product->w1Dim .'</td><td>'. $product->l1Dim .'</td><td>'. $product->hDim .'</td>';
                }
                if ($a['family'] == 8) {
                  $output .= '<td>'. $product->baseW .'</td><td>'. $product->baseL .'</td><td>'. $product->topW .'</td><td>'. $product->topL .'</td><td>'. $product->hDim .'</td>';
                }
                if ($a['family'] == 10) {
                  $output .= '<td>'. $product->baseW .'</td><td>'. $product->baseL .'</td><td>'. $product->topW .'</td><td>'. $product->topL .'</td><td>'. $product->hDim .'</td>';
                }
                if ($a['family'] == 12) {
                  $output .= '<td>'. $product->baseW .'</td><td>'. $product->baseL .'</td><td>'. $product->topW .'</td><td>'. $product->topL .'</td><td>'. $product->hDim .'</td>';
                }
                if ($a['family'] == 13) {
                  $output .= '<td>'. $product->baseW .'</td><td>'. $product->baseL .'</td><td>'. $product->topW .'</td><td>'. $product->topL .'</td><td>'. $product->hDim .'</td>';
                }
                if ($a['family'] == 14) {
                  $output .= '<td>'. $product->baseW .'</td><td>'. $product->baseL .'</td><td>'. $product->topW .'</td><td>'. $product->topL .'</td><td>'. $product->hDim .'</td>';
                }
                if ($a['family'] == 15) {
                  $output .= '<td>'. $product->baseW .'</td><td>'. $product->baseL .'</td><td>'. $product->topW .'</td><td>'. $product->topL .'</td><td>'. $product->hDim .'</td><td>'. $product->altDescription .'</td>';
                }
                if ($a['family'] == 16) {
                  $output .= '<td>'. $product->baseW .'</td><td>'. $product->baseL .'</td><td>'. $product->topW .'</td><td>'. $product->topL .'</td><td>'. $product->hDim .'</td><td>'. $product->altDescription .'</td>';
                }
                if ($a['family'] == 17) {
                  $output .= '<td>'. $product->baseW .'</td><td>'. $product->baseL .'</td><td>'. $product->topW .'</td><td>'. $product->topL .'</td><td>'. $product->hDim .'</td>';
                }
                $output .= '</tr>';
            }
            $output .= '</tbody>';
            $output .= '</table>';
            $output .= '</div>';
        }
        $output .= '<div id=disable_screen style="z-index:0;visibility:hidden;display:none;height:100%;width:100%;position:absolute;top:0;left:0;opacity:.50;background-color:#888888;filter:alpha(opacity=50)">';
        $output .= '</div>';
        $output .= '<div id=loading style="z-index:1;visibility:hidden;display:none;border-style:solid;opacity:1.0;padding:15px;position:absolute;text-align:center;background-color:#FFFFFF;width:250;height:60;font-size:24px;font-weight:700;line-height:24px">';
        $output .= 'Updating<br>';
        $output .= 'Recommendation';
        $output .= '</div>';        
    return $output;
}
add_shortcode('show_thermalelectric', 'show_thermalelectric_family');

function show_thermal_family($atts, $content = null){
    $a = shortcode_atts( array(
        'cat' => '',
    ), $atts );
    $args = array(
        'post_type' => 'product',
        'nopaging' => TRUE,
        'tax_query' => array(
          array(
            'taxonomy' => 'product_cat',                //(string) - Taxonomy.
            'field' => 'slug',                    //(string) - Select taxonomy term by ('id' or 'slug')
            'terms' => $a['cat'],              //(int/string/array) - Taxonomy term(s).
            'include_children' => false,           //(bool) - Whether or not to include children for hierarchical taxonomies. Defaults to true.
          )
      )
    );
    $results = new WP_Query( $args );
    ob_start();

    if ( $results->have_posts() ) : 
?>
        <div id="list_display" class="table-responsive">
          <table id=listing class="tablesorter table table-striped {sortlist: [[1,0],[2,0]]}" width="100%" border="0" cellpadding="0" cellspacing="0">
            <thead>
              <tr id="prodTableHead">
                <th>Model Number</th><th>I Max</th><th>V Max</th><th>&Delta;T Max</th><th>Qc Max</th><th>Base W</th><th>Base L</th><th>Top W</th><th>Top L</th><th>Height</th>
                <?php if ( $a['cat'] == 'special-design-peltier-coolers' || $a['cat'] == 'deep-cooling-multi-stage-peltier-coolers' ) : 
                  $template = "type";
                  ?>
                  <th>Type</th>
                <?php endif; ?>
              </tr>
            </thead>
            <tbody>
              <?php
                  while ( $results->have_posts() ) : $results->the_post();
                      get_template_part( 'teListing', $template );
                  endwhile;
              ?>
            </tbody>
          </table>
        </div>
        <?php
    endif;
    
    $content = ob_get_clean();
    
    return $content;    

}
add_shortcode('show_thermal_family', 'show_thermal_family');
