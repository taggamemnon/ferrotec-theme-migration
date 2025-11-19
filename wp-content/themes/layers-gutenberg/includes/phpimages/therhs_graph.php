<?php
ini_set("track_errors","Off");
//require_once("../include/globals.php");
require_once("../therhs_calc.php");
ini_set("memory_limit","50M");
$image_format="gif";
require_once("../jpgraph/src/jpg-config.inc");
require_once("../jpgraph/src/jpgraph.php");
require_once("../jpgraph/src/jpgraph_line.php");
require_once("../jpgraph/src/jpgraph_regstat.php");
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
if($config_admin_on!='true')
{
  //KILL OFF ALL HTML/JS INJECTION
  if(is_array($request_var))
    foreach($request_var as $key=>$value)
    {
      if(strip_tags($value)!=$value)
        $request_var[$key]=strip_tags($value);
    }
}
$colors=array('red','blue','green','orange','black','yellow','purple','brown');

$sizex=isset($_GET['sizex'])?$_GET['sizex']:200;
$sizey=isset($_GET['sizey'])?$_GET['sizey']:200;

$graph= new Graph($sizex,$sizey,'auto');
$domax=true;

$_GET['ig']=isset($_GET['ig'])?$_GET['ig']:0.025;
//S CONSTANTS
$_GET['s1']=isset($_GET['s1'])?$_GET['s1']:0.013345;
$_GET['s2']=isset($_GET['s2'])?$_GET['s2']:-0.0000537574;
$_GET['s3']=isset($_GET['s3'])?$_GET['s3']:0.000000742731;
$_GET['s4']=isset($_GET['s4'])?$_GET['s4']:-0.00000000127141;
//R CONSTANTS
$_GET['r1']=isset($_GET['r1'])?$_GET['r1']:2.08317;
$_GET['r2']=isset($_GET['r2'])?$_GET['r2']:-0.0198763;
$_GET['r3']=isset($_GET['r3'])?$_GET['r3']:0.0000853832;
$_GET['r4']=isset($_GET['r4'])?$_GET['r4']:-0.0000000903143;
//K CONSTANTS
$_GET['k1']=isset($_GET['k1'])?$_GET['k1']:0.476218;
$_GET['k2']=isset($_GET['k2'])?$_GET['k2']:-0.00000389821;
$_GET['k3']=isset($_GET['k3'])?$_GET['k3']:-0.00000864864;
$_GET['k4']=isset($_GET['k4'])?$_GET['k4']:0.0000000220868;

if(count($_GET)>16)
{
  $item=new TherHs_Calc(
  $_GET['s1']*1.0,$_GET['s2']*1.0,$_GET['s3']*1.0,$_GET['s4']*1.0,
  $_GET['r1']*1.0,$_GET['r2']*1.0,$_GET['r3']*1.0,$_GET['r4']*1.0,
  $_GET['k1']*1.0,$_GET['k2']*1.0,$_GET['k3']*1.0,$_GET['k4']*1.0,
  $_GET['cpl']*1.0,$_GET['imax']*1.0,$_GET['vmax']*1.0,$_GET['tmax']*1.0,$_GET['qcmax']*1.0,$_GET['hs']*1.0);


  $item->setIg($_GET['ig']);
  $item->setTh($_GET['th']+273.15);
  $item->setAmbient($_GET['amb']+273.15);
  for($j=0;$j<=($_GET['tmax']-$_GET['tmin'])/$_GET['tg'];$j++)
  {
    $item->setTc(($_GET['th']-($j*$_GET['tg']+$_GET['tmin']))+273.15);
    switch($_GET['curve'])
    {
      case 'qc':
        $curve[$j]=$item->calc_qc_vs_i();
        $title="Heat Pumped vs. Current";
        $ytitle="Qc (W)";
        $xtitle="I (A)";
        break;
      case 'v':
        $curve[$j]=$item->calc_v_vs_i();
        $title="Voltage vs. Current";
        $ytitle="V (V)";
        $xtitle="I (A)";
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
        $graph->SetScale('linlin',0,4);
        $title="Performance vs. Current";
        $ytitle="COP";
        $xtitle="I (A)";
        break;
    }
  }
  for($k=0.0;$k<=1.0+$item->ig;$k+=$item->ig)
    $xdata[]=$k*$item->imax;

  $plot=Array();
  $ymax=0;
  for($j=0;$j<=($_GET['tmax']-$_GET['tmin'])/$_GET['tg'];$j++)
  {
    $data=Array();
    foreach($curve[$j] as $xydata)
    {  $data[]=$xydata[1]; if($xydata[1]>$ymax)  $ymax=$xydata[1];   }
    $plot[$j] = new LinePlot($data);
    $plot[$j]->SetColor($colors[$j%count($colors)]);
    $plot[$j]->SetWeight(3);
    $plot[$j]->SetLegend("dT=".($j*$_GET['tg']+$_GET['tmin']));
  }
}
if($domax)
  $graph->SetScale('linlin',0,$ymax);


$graph->xaxis->SetTickLabels($xdata);
$graph->title->Set($title);
$graph->yaxis->title->Set($ytitle);
$graph->yaxis->title->SetFont(FF_FONT2,FS_BOLD);
$graph->xaxis->title->Set($xtitle);
$graph->xaxis->title->SetFont(FF_FONT2,FS_BOLD);
$graph->SetClipping();
$graph->ygrid->Show(true,false);
$graph->xgrid->Show(true,false);
$graph->legend->Pos(0.009,0.5,"right","center");
$graph->legend->SetFillColor("lightgray");
$graph->SetMarginColor("lightgray");
$graph->legend->SetColor("black","lightgray");
$graph->legend->SetShadow(false);
$graph->img->SetMargin(50,62,30,50);

for($j=0;$j<=($_GET['tmax']-$_GET['tmin'])/$_GET['tg'];$j++)
{
  $graph->Add($plot[$j]);
}

$graph->Stroke();

?>
