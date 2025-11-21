<?php
class TherHs_Calc
{
  //SEEBECK COEFFIECIENTS
  var $s1,$s2,$s3,$s4;
  //MODULE RESISTANCE COEFFICENTS
  var $r1,$r2,$r3,$r4;
  //CONDUCTANCE COEFFICENTS
  var $k1,$k2,$k3,$k4;
  //NUMBER OF COUPLINGS
  var $cpl;
  //IMAX
  var $imax;
  //VMAX
  var $vmax;
  //DTMAX
  var $dtmax;
  //QCMAX
  var $qcmax;
  //TH & TC
  var $th,$tc;
  //I GRANULARITY
  var $ig;
  //BASE I
  var $bi;
  //BASE N
  var $bn;
  //QCMAX_OFFSET
  var $qcmax_offset;
  //VMAX_OFFSET
  var $vmax_offset;


  //HEATSINK THERMAL RESISTANCE
  var $hs;

  var $PREC;
  var $LIMIT;
 
  function setTh($th) { $this->th=$th; }
  function setTc($tc) { $this->tc=$tc; }
  function setIg($ig) { $this->ig=$ig;  }
  function setAmbient($ta) { $this->ta=$ta; }
  function calcAmbientTh($ir) { $this->th=$this->ta+$this->hs*$this->Qh($this->th,$this->tc,$ir); }
  function TherHs_Calc(
     $s1,$s2,$s3,$s4,
     $r1,$r2,$r3,$r4,
     $k1,$k2,$k3,$k4,
     $cpl,
     $imax,$vmax,
     $dtmax,
     $qcmax,
     $hs,
     $bn,$bi,
     $qcmax_offset,$vmax_offset
  )
  {
    //SETUP INITIAL CONDITIONS ON SEEBECK COEFFICIENTS
    $this->s1=$s1; $this->s2=$s2; $this->s3=$s3; $this->s4=$s4; 
    //SETUP INTIAL CONDITIONS ON MODULAR RESISTANCE COEFFICENTS
    $this->r1=$r1; $this->r2=$r2; $this->r3=$r3; $this->r4=$r4; 
    //SETUP INITAL CONDITONS ON CONDUCTANCE COEFFICENTS
    $this->k1=$k1; $this->k2=$k2; $this->k3=$k3; $this->k4=$k4; 
    //SET UP OTHER VARIOUS INITAL CONDITONS
    $this->cpl=$cpl; 
    $this->imax=$imax; 
    $this->vmax=$vmax; 
    $this->dtmax=$dtmax; 
    $this->qcmax=$qcmax; 
    $this->hs=$hs;
    $this->PREC=0.000001;
    $this->LIMIT=50;
    $this->bn=$bn; if($this->bn == 0) $this->bn = 71;
    $this->bi=$bi; if($this->bi == 0) $this->bi = 6; 
    $this->qcmax_offset = $qcmax_offset;
    $this->vmax_offset = $vmax_offset;
  }
  function Poly($x,$a0,$a1,$a2,$a3,$a4)
  {
    return $a0+$a1*$x+$a2*pow($x,2.0)+$a3*pow($x,3.0)+$a4*pow($x,4.0);
  }
  function SS($t)
  {
    return $this->Poly($t,0.0,$this->s1,$this->s2/2.0, $this->s3/3.0, $this->s4/4.0);
  }
  function Sm($th,$tc)
  {
    $dt=$th-$tc;
    if($dt==0)
    {
      return $this->Poly($th,$this->s1,$this->s2,$this->s3,$this->s4,0.0);
    }
    else
    {
      return ($this->SS($th)-$this->SS($tc))/$dt;
    }
  }
  function RR($t)
  {
    return $this->Poly($t,0.0,$this->r1,$this->r2/2.0, $this->r3/3.0, $this->r4/4.0);
  }
  function Rm($th,$tc)
  {
    $dt=$th-$tc;
    if($dt==0)
    {
      return $this->Poly($th,$this->r1,$this->r2,$this->r3,$this->r4,0.0);
    }
    else
    {
      return ($this->RR($th)-$this->RR($tc))/$dt;
    }
    
  }
  function KK($t)
  {
    return $this->Poly($t,0.0,$this->k1,$this->k2/2.0, $this->k3/3.0, $this->k4/4.0);
  }
  function Km($th,$tc)
  {
    $dt=$th-$tc;
    if($dt==0)
    {
      return $this->Poly($th,$this->k1,$this->k2,$this->k3,$this->k4,0.0);
    }
    else
    {
      return ($this->KK($th)-$this->KK($tc))/$dt;
    }
  }
  function Qc($th,$tc,$ir)
  {
    return ($this->Sm($th,$tc)*$tc*$ir-0.5*$this->bi*$this->Rm($th,$tc)*pow($ir,2.0)-$this->Km($th,$tc)*($th-$tc)/$this->bi)/$this->bn*$this->cpl*$this->imax*$this->qcmax_offset;
  }
  function Vin($th,$tc,$ir)
  {
    return ($this->Sm($th,$tc)*($th-$tc)+$this->bi*$ir*$this->Rm($th,$tc))/$this->bn*$this->cpl*$this->vmax_offset;;
  }
  function Qh($th,$tc,$ir)
  {
    return $this->Qc($th,$tc,$ir)+$this->Vin($th,$tc,$ir)*$ir*$this->imax;
  }
  function COP($th,$tc,$ir)
  {
    return  $ir==0?0:$this->Qc($th,$tc,$ir)/($this->Vin($th,$tc,$ir)*$ir*$this->imax);
  }
  function calc_qc_vs_i()
  {
    $calc=Array();
    $oldth=$this->th;
    for($ir=0;$ir<=1.0+$this->ig;$ir+=$this->ig)
    {
      $curth=$this->th;
      $this->calcAmbientTh($ir);
      $iter=0;
      while(abs($curth-$this->th)>$this->PREC&&$iter<$this->LIMIT)
      {
        $curth=$this->th;
        $this->calcAmbientTh($ir);
        $iter++;
      }
      $calc[]=array($ir,$this->Qc($this->th,$this->tc,$ir));
      $this->th=$oldth;
    }
    return $calc;
  }
  function calc_qc($i)
  {
    $oldth=$this->th;
    $curth=$this->th;
    $this->calcAmbientTh($i/$this->imax);
    $iter=0;
    while(abs($curth-$this->th)>$this->PREC&&$iter<$this->LIMIT)
    {
      $curth=$this->th;
      $this->calcAmbientTh($i/$this->imax);
      $iter++;
    }
    $retqc=$this->Qc($this->th,$this->tc,$i/$this->imax);
    $this->th=$oldth;
    return $retqc;
  }
  function calc_v_vs_i()
  {
    $calc=Array();
    $oldth=$this->th;
    $curth=$this->th;
    for($ir=0;$ir<=1.0+$this->ig;$ir+=$this->ig)
    {
      $this->calcAmbientTh($ir);
      $iter=0;
      while(abs($curth-$this->th)>$this->PREC&&$iter<$this->LIMIT)
      {
        $curth=$this->th;
        $this->calcAmbientTh($ir);
        $iter++;
      }
      $calc[]=array($ir,$this->Vin($this->th,$this->tc,$ir));
      $this->th=$oldth;
    }
    return $calc;
  }
  function calc_v($i)
  {
    $oldth=$this->th;
    $curth=$this->th;
    $this->calcAmbientTh($i/$this->imax);
    $iter=0;
    while(abs($curth-$this->th)>$this->PREC&&$iter<$this->LIMIT)
    {
      $curth=$this->th;
      $this->calcAmbientTh($i/$this->imax);
      $iter++;
    }
    $retvin=$this->Vin($this->th,$this->tc,$i/$this->imax);
    $this->th=$oldth;
    return $retvin;
  }

  function calc_qh_vs_i()
  {
    $calc=Array();
    $oldth=$this->th;
    $curth=$this->th;
    for($ir=0;$ir<=1.0+$this->ig;$ir+=$this->ig)
    {
      $this->calcAmbientTh($ir);
      $iter=0;
      while(abs($curth-$this->th)>$this->PREC&&$iter<$this->LIMIT)
      {
        $curth=$this->th;
        $this->calcAmbientTh($ir);
        $iter++;
      }
      $calc[]=array($ir,$this->Qh($this->th,$this->tc,$ir));
      $this->th=$oldth;
    }
    return $calc;
  }
  function calc_cop_vs_i()
  {
    $calc=Array();
    $oldth=$this->th;
    $curth=$this->th;
    for($ir=0;$ir<=1.0+$this->ig;$ir+=$this->ig)
    {
      $this->calcAmbientTh($ir);
      $iter=0;
      while(abs($curth-$this->th)>$this->PREC&&$iter<$this->LIMIT)
      {
        $curth=$this->th;
        $this->calcAmbientTh($ir);
        $iter++;
      }
      $calc[]=array($ir,$this->COP($this->th,$this->tc,$ir));
      $this->th=$oldth;
    }
    return $calc;
  }
}
?>
