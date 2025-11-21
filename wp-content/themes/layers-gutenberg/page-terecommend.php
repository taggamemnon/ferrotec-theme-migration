<?php
/*
   Template Name: Thermoelectric Part recommendation

   */
//ini_set("display_errors","yes");
//error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT);
//error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);

  require_once('includes/ferrotec_products.php');
  require_once('includes/therhs_calc.php');
  $results = new fProducts;
  $cust_arr = array('ambTemp','coldTemp','thermRes','heatTrans','multMod');
  foreach ($cust_arr as $value)
    $cust[$value]= get_query_var($value);
  $family_id=14;
  $pline_set_data = $results->get_custom_listing($family_id,$cust);

$retval = '<table id="listing" class="tablesorter table table-striped" width="100%" border="0" cellpadding="0" cellspacing="0">' ;
$retval .= '<thead>';
$header=array('Model Number');
$header=array_merge($header,array('N','Qc','CoP','I','V'));
switch($family_id)
{
  case 3:
  case 11:
    $header=array_merge($header,array('W1 Dim','W2 Dim','L1 Dim','L2 Dim','Height'));
    break;
  case 1:
  case 2:
  case 8:
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
    $header=array_merge($header,array('W1 Dim','L1 Dim','L2 Dim','Height'));
    break;
  case 12:
  case 13:
  case 14:
    $header=array_merge($header,array('Base W','Base L','Top W','Top L','Height'));
    break;
  case 15:
  default:
  break;
}
$retval .= '<tr>';
foreach($header as $th)
  if($th=='CoP')
    $retval .= '<th class="header">'.$th.'</th>';
  else
    $retval .= '<th class="header">'.$th.'</th>';
  
$retval .= '</tr>';
$retval .= '</thead>';
$retval .= '<tbody>';
  if(count($pline_set_data)==0)
    $retval .=  '<tr><td colspan=20>We were not able to match a specific module to the value that you entered. <br />To increase the number of results, you can try: <br /> - Selecting the "Consider Multiple Modules" checkbox. <br /> - Increasing the efficiency of your heat sink by reducing the thermal resistance. <br /> - Reducing the amount of heat that you are attempting to transfer. <br /> - Reducing your &Delta;T. Try increasing the cold side temperature.</td></tr>';
  else {
  foreach ($pline_set_data as $product) {
    $retval .= '<tr>';
    $retval .= '<td><a href="'. makeurls($product['fullPN']) .'">'. $product['fullPN'] .'</a></td>';
    //$retval .=  '<td><a target="_blank" href="/index.php?id=module_detail&mod_id=' . $product['id'] . '&amb=' . $request_var['ambTemp'] . '&th=' . $request_var['ambTemp'] . '&hs=' . $request_var['thermRes'] . '&num_mod=' . $product['n'] . '.0&mode=1#tmodel">' . $product['fullPN'] . '</a></td>';
    $retval .=  '<td width=30 nowrap>' . $product['n'] . '</td><td width=40 nowrap>' . $product['qc'] . '</td><td>' . $product['cop'] . '</td><td width=30 nowrap>' . $product['ir'] . '</td><td width=40>' . $product['vin'] . '</td>';
    if ($family_id == 2 || $family_id == 1 || $family_id == 8 || $family_id == 9 || $family_id == 10)
      $retval .= '<td>' . $product['w1Dim'] . '</td><td>' . $product['l1Dim'] . '</td><td>' . $product['l2Dim'] . '</td><td>' . $product['hDim'] . '</td>';
    if ($family_id == 3 || $family_id == 11)
      $retval .=   '<td>' . $product['w1Dim'] . '</td><td>' . $product['w2Dim'] . '</td><td>' . $product['l1Dim'] . '</td><td>' . $product['l2Dim'] .'</td><td>' . $product['hDim'] . '</td>';
    if ($family_id == 4) {
      $retval .=   '<td>' . $product['w1Dim'] . '</td><td>' . $product['w2Dim'] . '</td><td>' . $product['w3Dim'] . '</td>';
      $retval .=   '<td>' . $product['l1Dim'] . '</td><td>' . $product['l2Dim'] . '</td><td>' . $product['l3Dim'] . '</td><td>' . $product['hDim'] . '</td>';
    }
    if ($family_id == 5)
      $retval .=  '<td>' . $product['w1Dim'] . '</td><td>' . $product['l1Dim'] . '</td><td>' . $product['hDim'] . '</td><td>' . $product['idDim'] . '</td>';
    if ($family_id == 6)
      $retval .=  '<td>' . $product['hDim'] . '</td><td>' . $product['idDim'] . '</td><td>' . $product['oDim'] . '</td>';
    if ($family_id == 7)
      $retval .=  '<td>' . $product['w1Dim'] . '</td><td>' . $product['l1Dim'] . '</td><td>' . $product['hDim'] . '</td>';
    if ($family_id == 14)
      $retval .= '<td>' . $product['baseW'] . '</td><td>' . $product['baseL'] . '</td><td>' . $product['topW'] . '</td><td>' . $product['topL'] . '</td><td>' . $product['hDim'] . '</td>';
    $retval .= '</tr>';
  }
  $retval .= '</tbody>';
  $retval .= '</table>';
}
header('Content-Type: application/javascript');
echo "ferroData='" . $retval . "';src_loaded=true;";

function make_js_safe($s)
{
  $s=str_replace("\\'","'",$s);
  $s=str_replace("'","\\'",$s);
  $s=str_replace("\n","\\n",$s);
  $s=str_replace("\r","\\r",$s);
  return $s;
}
