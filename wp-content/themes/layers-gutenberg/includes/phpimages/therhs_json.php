<?php
 $path = $_SERVER['DOCUMENT_ROOT'];
 $path .= "/wp-blog-header.php";
require( $path );

if (!function_exists('json_encode')) {
    function json_encode($data) {
        switch ($type = gettype($data)) {
            case 'NULL':
                return 'null';
            case 'boolean':
                return ($data ? 'true' : 'false');
            case 'integer':
            case 'double':
            case 'float':
                return $data;
            case 'string':
                return '"' . addslashes($data) . '"';
            case 'object':
                $data = get_object_vars($data);
            case 'array':
                $output_index_count = 0;
                $output_indexed = array();
                $output_associative = array();
                foreach ($data as $key => $value) {
                    $output_indexed[] = json_encode($value);
                    $output_associative[] = json_encode($key) . ':' . json_encode($value);
                    if ($output_index_count !== NULL && $output_index_count++ !== $key) {
                        $output_index_count = NULL;
                    }
                }
                if ($output_index_count !== NULL) {
                    return '[' . implode(',', $output_indexed) . ']';
                } else {
                    return '{' . implode(',', $output_associative) . '}';
                }
            default:
                return ''; // Not supported
        }
    }
}
error_reporting(0);

ini_set("track_errors","Off");
//require_once("../include/globals.php");
 $path = $_SERVER['DOCUMENT_ROOT'];
 $path .= "/wp-content/themes/layers2/includes/phpimages/therhs_calc.php";
require_once( $path );
ini_set("memory_limit","50M");
//MAKE VARIABLES SENT TO CLIENT AVIALABLE
switch($_SERVER['REQUEST_METHOD'])
{
  case "POST":
    $request_var = $_POST;
    break;
  case "GET":
    $request_var = $_GET;
    break;
}
  //KILL OFF ALL HTML/JS INJECTION
  if(is_array($request_var))
    foreach($request_var as $key=>$value)
    {
      if(strip_tags($value)!=$value)
        $request_var[$key]=strip_tags($value);
    }
$maxx=null;

$id = $request_var['id'] * 1;
$sql = "select tm.*,tc.* from teModules tm,teCoeff tc where tm.id = {$id} and tm.tecoeff_id=tc.id";
//$rst = $db_con->execute($sql);
$rst = $wpdb->get_results($sql, OBJECT );

//CURRENT STEPPING
$ig=isset($request_var['ig'])?$request_var['ig']:0.025;

//THERMAL STEPPING
$tg = isset($request_var['tg'])?$request_var['tg']*1.0:10;

//THERMAL HEAT
$th = isset($request_var['th'])?$request_var['th']:0;

//AMBIENT TEMP
$amb = isset($request_var['amb'])?$request_var['amb']:0;

//THERMAL RESISTANCE -- FROM USER
$hs = isset($request_var['hs'])?$request_var['hs']:0;

//THERMAL RESISTANCE -- FROM USER
$tmin = isset($request_var['tmin'])?$request_var['tmin']*1.0:0;

//THERMAL RESISTANCE -- FROM USER
$tmax = isset($request_var['tmax'])?$request_var['tmax']*1.0:70;

//GRAPH TYPE
$graph = $request_var['curve'];

//AVAILABLE COLORS
$colors=array('red','blue','green','orange','black','#f2e409','purple','brown');
if($rst && count($rst) > 0)
{
   $item=new TherHs_Calc(
     $rst[0]->s1*1.0,$rst[0]->s2*1.0,$rst[0]->s3*1.0,$rst[0]->s4*1.0,
     $rst[0]->r1*1.0,$rst[0]->r2*1.0,$rst[0]->r3*1.0,$rst[0]->r4*1.0,
     $rst[0]->k1*1.0,$rst[0]->k2*1.0,$rst[0]->k3*1.0,$rst[0]->k4*1.0,
     $rst[0]->numCouples*1.0,
     $rst[0]->iMax*1.0,
     $rst[0]->vMax*1.0,
     $rst[0]->tMax*1.0,
     $rst[0]->qcMax*1.0,
     $hs*1.0,
     $rst[0]->Base_N*1.0,
     $rst[0]->Base_I*1.0,
     $rst[0]->qcmax_offset*1.0,
     $rst[0]->vmax_offset*1.0
   );

  //THERMAL RESISTANCE -- FROM USER
  $tmax = isset($request_var['tmax'])?$request_var['tmax']*1.0:$rst[0]->tMax;
  $tg = ($tmax-$tmin) / 7;

  $item->setIg($ig);
  $item->setTh($th+273.15);
  $item->setAmbient($amb+273.15);
  for($j=0;$j<=($tmax-$tmin)/$tg;$j++)
  {
    $item->setTc(($th-($j*$tg+$tmin))+273.15);
    switch($graph)
    {
      case 'qc':
        $curve[$j]=$item->calc_qc_vs_i();
        $title="Heat Pumped vs. Current";
        $ytitle="Qc (W)";
        $xtitle="I (A)";
	$maxy = $rst[0]->qcMax * 1.0 * $rst[0]->qcmax_offset * 1.0;
        break;
      case 'v':
        $curve[$j]=$item->calc_v_vs_i();
        $title="Voltage vs. Current";
        $ytitle="V (V)";
        $xtitle="I (A)";
	$maxy = $rst[0]->vMax * 1.0 * $rst[0]->vmax_offset * 1.0;
        break;
      case 'qh':
        $curve[$j]=$item->calc_qh_vs_i();
        $title="Heat Rejected vs. Current";
        $ytitle="Qh (W)";
        $xtitle="I (A)";
        break;
      case 'cop':
        $curve[$j]=$item->calc_cop_vs_i();
        $domax=false;
        $title="Performance vs. Current";
        $ytitle="COP";
        $xtitle="I (A)";
        $maxy=4.0;
        break;
    }
  }
  for($k=0.0;$k<=1.0+$item->ig;$k+=$item->ig)
    $xdata[]=$k*$item->imax;

  $plot=Array();
  $ymax = 0;
  for($j=0;$j<=($tmax-$tmin)/$tg;$j++)
  {
    $data=Array();
    foreach($curve[$j] as $xydata)
    {  $data[]=$xydata[1]; if($xydata[1]>$ymax)  $ymax=$xydata[1];   }
    $plot[$j]['datay'] = $data;
    $plot[$j]['datax'] = $xdata;
    $plot[$j]['color'] = $colors[$j%count($colors)];
    $plot[$j]['legend'] = ("dT=".($j*$tg+$tmin));
  }
  
  $info = Array();
  $info['data'] = $plot;
  $info['title'] = $title;
  $info['xtitle'] = $xtitle;
  $info['ytitle'] = $ytitle;
  $info['maxy'] = $maxy;
  $info['maxx'] = $maxx;
  $info['tmax'] = $tmax;
  $info['tmin'] = $tmin;
  $info['tg'] = $tg;
  $info['s1'] = $rst[0]->s1*1.0;
  $info['s2'] = $rst[0]->s2*1.0;
  $info['s3'] = $rst[0]->s3*1.0;
  $info['s4'] = $rst[0]->s4*1.0;
  $info['r1'] = $rst[0]->r1*1.0;
  $info['r2'] = $rst[0]->r2*1.0;
  $info['r3'] = $rst[0]->r3*1.0;
  $info['r4'] = $rst[0]->r4*1.0;
  $info['k1'] = $rst[0]->k1*1.0; 
  $info['k2'] = $rst[0]->k2*1.0;   
  $info['k3'] = $rst[0]->k3*1.0;       
  $info['k4'] = $rst[0]->k4*1.0;
  $info['numcouples'] = $rst[0]->numCouples*1.0;
  $info['imax'] = $rst[0]->iMax*1.0;
  $info['vmax'] = $rst[0]->vMax*1.0;
  $info['qcmax'] = $rst[0]->qcMax*1.0;
  $info['hs'] = $hs*1.0;
  $info['base_n'] = $rst[0]->Base_N*1.0;
  $info['base_i'] = $rst[0]->Base_I*1.0;
  $info['qcmax_offset'] = $rst[0]->qcmax_offset*1.0;
  $info['vmax_offset'] = $rst[0]->vmax_offset*1.0;

  echo json_encode($info);

  exit;
}
?>
