<?php
define( 'DIEONDBERROR', true );

class fProducts 
{
  var $pline_arr;
//CONSTRUCTOR
  function fProducts()
  {
  global $wpdb;
  $wpdb->show_errors();

    $this->pline_arr=array();
    //PRODUCT LINE 0
    $this->pline_arr[0]=array();
    $this->pline_arr[0]['table']='ferrofluids';
    $this->pline_arr[0]['table_id']='id';
    $this->pline_arr[0]['fields']=array(
      'id:key:r'=>'FerroFluids ID',
      'model:text:r'=>'Model',
      'description:text:r'=>'Description',
      'fk_seriesID:nselect#select id as value, seriesTitle as text from ferrofluidSeries:r'=>'Series ID',
      'liquidType:text:r'=>'Liquid Type',
      'sat_Gauss:text:r'=>'Sat. guass',
      'sat_mT:text:r'=>'Sat. mT',
      'sat_mPa_s:text:r'=>'Sat. mPa/s ',
      'vis_cP:text:r'=>'Vis. cP',
      'den_g_ml:text:r'=>'Den. g/ml',
      'den_g_cm3:text:r'=>'Den. g/cm3',
      'pour_c1:text:r'=>'Pour C1',
      'pour_c2:text:r'=>'Pour C2',
      'flash_c1:text:r'=>'Flash C1',
      'flash_c2:text:r'=>'Flash C2',
      'cond_mW1:text:r'=>'Cond. mW1',
      'cond_mW2:text:r'=>'Cond. mW2',
      'surf_dynes_cm:text:r'=>'Surf. dynes/cm',
      'surf_mN:text:r'=>'Surf. mN',
      'coef_mN:text:r'=>'Coef. mN',
      'coef_mlC:text:r'=>'Coef. mlC',
      'coef_siUnits:text:r'=>'Coef. SI Units',
      'liveDateTime:date:r'=>'Live',
      'modifiedDate:stamp:r'=>'Modified',
    );
    //PRODUCT LINE 1
    $this->pline_arr[1]=array();
    $this->pline_arr[1]['table']='vfProducts';
    $this->pline_arr[1]['table_id']='id';
    $this->pline_arr[1]['fields']=array(
      'id:key:r'=>'vfProducts ID',
      'mNum:text:r'=>'Model Number',
      'pNum:text:r'=>'Part Number',
      'fk_fluidID:nselect#select id as value, fluidTitle as text from vfFluid:r'=>'Fluid ID',
      'fk_mountingID:nselect#select id as value, mountingTitle as text from vfMounting:r'=>'Mounting ID',
      'fk_shaftID:nselect#select id as value, shaftTitle as text from vfShaft:r'=>'Shaft ID',
      'fk_type:nselect#select id as value, familyTitle as text from vfFamily:r'=>'Type',
      'afsMNum:text:r'=>'AFS Model Number',
      'rigPNum:text:r'=>'Rigaku Part Number',
      'rigMNum:text:r'=>'Rigaku Model Number',
      'listP:text:r'=>'List Price',
      'frjPNum:num:r'=>'FRJ Part Number',
      'src:num:r'=>'Active (searchable)',
      'nS:num:r'=>'Normally in Stock',
      'unit:num:r'=>'Unit Manufactured In',
      'mntOpt:num:r'=>'Mounting nut Included',
      'sa1:num:r'=>'Standard',
      'sa2:num:r'=>'Custome',
      'sa3:num:r'=>'OEM',
      'b1:num:r'=>'simply supported',
      'b2:num:r'=>'cantilevered',
      'b3:num:r'=>'heavy duty',
      'f1:num:r'=>'sleeve',
      'f2:num:r'=>'water-cooled',
      'f3:num:r'=>'shaft clamp',
      'f4:num:r'=>'electrical isolation',
      'f5:num:r'=>'number of union services',
      'f6:num:r'=>'pulley',
      'd1:text:r'=>'Shaft Diameter',
      'd2:text:r'=>'Over / Under',
      'd3:text:r'=>'Shaft Termination',
      'd4:text:r'=>'Shaft Extension',
      'd5:text:r'=>'Overall Length',
      'd6:text:r'=>'Housing Overall Length',
      'd7:text:r'=>'Housing Diameter',
      'd8:text:r'=>'Over/Under',
      'd9:text:r'=>'Body Length',
      'd10:text:r'=>'Thread Diameter',
      'd11:text:r'=>'Thread Pitch',
      'd12:text:r'=>'Thread Length',
      'd13:text:r'=>'Clamp Diameter',
      'd14:text:r'=>'Clamp Thickness',
      'd15:text:r'=>'Recommended Shaft Diameter',
      'd16:text:r'=>'Over/Under',
      'd17:text:r'=>'Recommended Mounting Bore',
      'd18:text:r'=>'Over/Under',
      'd19:text:r'=>'Flange Diameter',
      'd20:text:r'=>'Flange Thickness',
      'd21:text:r'=>'Flange Wrench Flat',
      'd22:text:r'=>'Fitting Locations',
      'd23:text:r'=>'Mounting Holes',
      'd24:text:r'=>'Max Torque',
      'd25:text:r'=>'Bearing Type/Material',
      'd26:text:r'=>'Bearing static load capacity',
      'd27:text:r'=>'Bearing dynamic load capacity',
      'd28:text:r'=>'Dimension, mtg flange to proc. Bearing ',
      'd29:text:r'=>'Dimension, proc. Bearing to atm Bearing',
      'd30:text:r'=>'Max Speed',
      'd31:text:r'=>'MAx Thrust',
      'd32:text:r'=>'Radial Load Capacity',
      'd33:text:r'=>'Max Torque',
      'd34:text:r'=>'Starting Torque',
      'd35:text:r'=>'Running Torque',
      'd36:text:r'=>'Max no-load Speed',
      'd37:text:r'=>'Face seal O-ring',
      'd38:text:r'=>'Flange Type',
      'd39:text:r'=>'Notes',
      'ra1:num:r'=>'RA1',
      'ra2:num:r'=>'RA2',
      'ra3:num:r'=>'RA3',
      'ra4:num:r'=>'RA4',
      'ra5:num:r'=>'RA5',
      'ra6:num:r'=>'RA6',
      'visibility:num:r'=>'Visibility',
      'createDate:stamp:r'=>'Created',
      'liveDateTime:date:r'=>'Live',
      'modifiedDate:stamp:r'=>'Modified',
    );
    //PRODUCT LINE 2
    $this->pline_arr[2]=array();
    $this->pline_arr[2]['table']='teModules';
    $this->pline_arr[2]['table_id']='id';
    $this->pline_arr[2]['fields']=array(
      'id:key:r'=>'Module ID',
      'fk_teFamilyInfoID:nselect#select id as value, title as text from teFamilyInfo:r'=>'Family Info ID',
      'visibility:num:r'=>'Visible',
      'fullPN:text:r'=>'Full Part Number',
      'reqPsw:text:r'=>'Require PSW',
      'product:text:r'=>'Product Name',
      'shape:num:r'=>'Shape',
      'class:num:r'=>'Class',
      'numCouples:text:r'=>'Number of Couples',
      'maxCurrent:text:r'=>'Max Current',
      'substrateType:text:r'=>'Substrate Type',
      'options:text:r'=>'Options',
      'altDescription:text:r'=>'Alternet Description',
      'iMax:text:r'=>'iMax',
      'vMax:text:r'=>'vMax',
      'tMax:text:r'=>'tMax',
      'qcMax:text:r'=>'qcMax',
      'baseW:text:r'=>'Base Width',
      'baseL:text:r'=>'Base Length',
      'topW:text:r'=>'Top Width',
      'topL:text:r'=>'Top Length',
      'w1Dim:text:r'=>'Width 1 Dimension',
      'w2Dim:text:r'=>'Width 2 Dimension',
      'w3Dim:text:r'=>'Width 3 Dimension',
      'l1Dim:text:r'=>'Length 1 Dimension',
      'l2Dim:text:r'=>'Length 2 Dimension',
      'l3Dim:text:r'=>'Length 3 Dimension',
      'tDim:text:r'=>'tDim',
      'hDim:text:r'=>'hDim',
      'oDim:text:r'=>'oDim',
      'voc:text:r'=>'voc',
      'rim:text:r'=>'rim',
      'rLoad:text:r'=>'rLoad',
      'wLoad:text:r'=>'wLoad',
      'vLoad:text:r'=>'vLoad',
      'kmC:text:r'=>'kmC',
      'liveDateTime:date:r'=>'Live',
      'modifiedDate:stamp:r'=>'Modified',

    );
    //PRODUCT LINE JOIN TABLE
    $this->pline_arr[3]=array();
    $this->pline_arr[3]['table']='teFamilyInfo';
    $this->pline_arr[3]['table_id']='id';
    $this->pline_arr[3]['fields']=array(
      'id:key:r'=>'Family ID',
      'familyID:num:r'=>'Family ID',
      'title:text:r'=>'Title',
      'stdDesc:textarea:r'=>'Standard Description',
      'bigDesc:textarea:r'=>'Big Description',
      'photo1:text:r'=>'Photo 1',
      'photo2:text:r'=>'Photo 2',
      'photo3:text:r'=>'Photo 3',
      'dimFile:text:r'=>'Dimension Image',
      'dimDesc:text:r'=>'Dimension Description',
      'dsFooterID:num:r'=>'dsFooterID',
    );

    //PRODUCT LINE JOIN TABLE
    $this->pline_arr[4]=array();
    $this->pline_arr[4]['table']='ferrofluidSeries';
    $this->pline_arr[4]['table_id']='id';
    $this->pline_arr[4]['fields']=array(
      'id:key:r'=>'SeriesID',
      'seriesID:num:r'=>'SeriesID',
      'seriesTitle:text:r'=>'Title',
      'seriesLink:text:r'=>'Link',
      'seriesType:text:r'=>'Type',
      'seriesNote:text:r'=>'Note'
    );

    //PRODUCT LINE JOIN TABLE
    $this->pline_arr[5]=array();
    $this->pline_arr[5]['table']='vfShaft';
    $this->pline_arr[5]['table_id']='id';
    $this->pline_arr[5]['fields']=array(
      'id:key:r'=>'ShaftID',
      'shaftID:num:r'=>'ShaftID',
      'shaftTitle:text:r'=>'Title',
    );

    //PRODUCT LINE JOIN TABLE
    $this->pline_arr[6]=array();
    $this->pline_arr[6]['table']='vfFamily';
    $this->pline_arr[6]['table_id']='id';
    $this->pline_arr[6]['fields']=array(
      'id:key:r'=>'FamilyID',
      'familyID:num:r'=>'FamilyID',
      'familyTitle:text:r'=>'Title',
    );

    //PRODUCT LINE JOIN TABLE
    $this->pline_arr[7]=array();
    $this->pline_arr[7]['table']='vfFluid';
    $this->pline_arr[7]['table_id']='id';
    $this->pline_arr[7]['fields']=array(
      'id:key:r'=>'FluidID',
      'fluidID:num:r'=>'FluidID',
      'fluidTitle:text:r'=>'Title',
    );

    //PRODUCT LINE JOIN TABLE
    $this->pline_arr[8]=array();
    $this->pline_arr[8]['table']='vfMounting';
    $this->pline_arr[8]['table_id']='id';
    $this->pline_arr[8]['fields']=array(
      'id:key:r'=>'MountingID',
      'mountingID:num:r'=>'MountingID',
      'mountingTitle:text:r'=>'Title',
    );

    //PRODUCT LINE JOIN TABLE
    $this->pline_arr[9]=array();
    $this->pline_arr[9]['table']='vfBearing';
    $this->pline_arr[9]['table_id']='id';
    $this->pline_arr[9]['fields']=array(
      'id:key:r'=>'BearingID',
      'bearingID:num:r'=>'BearingID',
      'bearingTitle:text:r'=>'Title',
    );

  }
  function init_product_line($pline_id=0)
  {
    $this->table=$this->pline_arr[$pline_id]['table'];
    $this->table_id=$this->pline_arr[$pline_id]['table_id'];
    $this->fields=$this->pline_arr[$pline_id]['fields'];
  }

  function get_ferrofluid_data($series_id,$id='')
  {
    if($id!='')
      $sql_detail=" ff left join ferrofluidSeries ffS on ffS.seriesID=ff.fk_seriesID where ff.model={$id}";
    else
      $sql_detail=" where fk_seriesID={$series_id}";
    return $this->get_product_line_data(0,"{$sql_detail}");
  }  

  function get_module_data($family_id)
  {
    return $this->get_product_line_data(2," where visibility = 1 and fk_teFamilyInfoID={$family_id} order by iMax ASC");
  }  

  function get_custom_listing($family_id,$custom)
  {
    global $wpdb;
    //$this->init_product_line($pline_id);
    //$sql= "select ". $select ." from ". $this->table ." ".$filter;
    // sets up translation 
    $trans = array(
      'ambTemp'=>'ta',
      'coldTemp'=>'tc',
      'thermRes'=>'theta',
      'heatTrans'=>'qc',
      'multMod'=>'multi_modules'
    );

    foreach ($trans as $key => $value)
      $cust[$value] = $custom[$key];

    $thermal_data=array();

    $query_allProd = "SELECT *,m.id as id FROM teModules m 
      LEFT JOIN teCoeff c on c.id = m.tecoeff_id 
      WHERE m.visibility = 1 AND m.recommendable = 1 AND m.fk_teFamilyInfoID = $family_id ORDER BY m.iMax ASC";
    $allProd=$wpdb->get_results($query_allProd, OBJECT );
    $totalRows_allProd = count($allProd);
    $z=0;
    for($i=0;$i<$totalRows_allProd;$i++)
    {
      $row_allProd[$i] = $allProd[$i];

      $display=true;
      $thermal_data['s1']=$row_allProd[$i]->s1;
      $thermal_data['s2']=$row_allProd[$i]->s2;
      $thermal_data['s3']=$row_allProd[$i]->s3;
      $thermal_data['s4']=$row_allProd[$i]->s4;
      $thermal_data['ig']=0.01;
      $thermal_data['r1']=$row_allProd[$i]->r1;
      $thermal_data['r2']=$row_allProd[$i]->r2;
      $thermal_data['r3']=$row_allProd[$i]->r3;
      $thermal_data['r4']=$row_allProd[$i]->r4;
      $thermal_data['th']=50;
      $thermal_data['k1']=$row_allProd[$i]->k1;
      $thermal_data['k2']=$row_allProd[$i]->k2;
      $thermal_data['k3']=$row_allProd[$i]->k3;
      $thermal_data['k4']=$row_allProd[$i]->k4;
      $thermal_data['tmax']=70;
      $thermal_data['tg']=10;
      $thermal_data['imax']=$row_allProd[$i]->iMax;
      $thermal_data['vmax']=$row_allProd[$i]->vMax;
      $thermal_data['cpl']=$row_allProd[$i]->numCouples;
      $thermal_data['hs']=$cust['theta']*1.0;
      $thermal_data['amb']=$cust['ta']*1.0;
      $thermal_data['tc']=$cust['tc']*1.0;
      $thermal_data['qcmax']=$row_allProd[$i]->qcMax;
      $thermal_data['Base_N']=$row_allProd[$i]->Base_N;
      $thermal_data['Base_I']=$row_allProd[$i]->Base_I;
      $thermal_data['qcmax_offset']=$row_allProd[$i]->qcmax_offset;
      $thermal_data['vmax_offset']=$row_allProd[$i]->vmax_offset;

      //CALUCLATE QC FOR THIS PRODUCT
      $item=new TherHs_Calc(
      $thermal_data['s1']*1.0,$thermal_data['s2']*1.0,$thermal_data['s3']*1.0,$thermal_data['s4']*1.0,
      $thermal_data['r1']*1.0,$thermal_data['r2']*1.0,$thermal_data['r3']*1.0,$thermal_data['r4']*1.0,
      $thermal_data['k1']*1.0,$thermal_data['k2']*1.0,$thermal_data['k3']*1.0,$thermal_data['k4']*1.0,
      $thermal_data['cpl']*1.0,$thermal_data['imax']*1.0,$thermal_data['vmax']*1.0,$thermal_data['tmax']*1.0,
      $thermal_data['qcmax']*1.0,$thermal_data['hs']*1.0,
      $thermal_data['Base_N']*1.0,$thermal_data['Base_I']*1.0,$thermal_data['qcmax_offset']*1.0,$thermal_data['vmax_offset']*1.0);

      $item->setIg($thermal_data['ig']);
      $item->setTh($thermal_data['amb']+273.15);
      $item->setTc($thermal_data['tc']+273.15);
      $item->setAmbient($thermal_data['amb']+273.15);
      $IR=$thermal_data['imax'];

      if($thermal_data['hs']>0)
      {
        $item->hs=0;
        $QC=$item->calc_qc($thermal_data['imax']);
        $item->hs=$thermal_data['hs'];
        if($QC>$cust['qc'])
        {
          $arr=$item->calc_qc_vs_i();
          $QC=0;
          foreach($arr as $data)
            if($data[1]>$QC)
            {
              $QC=$data[1];
              $IR=$data[0]*$thermal_data['imax'];
            }
        }
      }
      else
        $QC=$item->calc_qc($thermal_data['imax']);

      $VIN=$item->calc_v($IR);
  
      if($QC<$cust['qc']*1.0)
      {
        $display=false;
      }
      else
        $num_mod=1.0;

      if($cust['multi_modules']=='1')
      {
        $mult_arr=array(2.0,3.0,4.0,5.0,6.0,7.0,8.0,9.0,10.0);
        if(!$display&&$thermal_data['hs']>0)
        {
          foreach($mult_arr as $multiplier)
            if($QC*$multiplier>=$cust['qc']*1.0&&!$display)
            {
              //CALUCLATE QC FOR THIS PRODUCT
              $item=new TherHs_Calc(
              $thermal_data['s1']*1.0,$thermal_data['s2']*1.0,$thermal_data['s3']*1.0,$thermal_data['s4']*1.0,
              $thermal_data['r1']*1.0,$thermal_data['r2']*1.0,$thermal_data['r3']*1.0,$thermal_data['r4']*1.0,
              $thermal_data['k1']*1.0,$thermal_data['k2']*1.0,$thermal_data['k3']*1.0,$thermal_data['k4']*1.0,  
              $thermal_data['cpl']*1.0,$thermal_data['imax']*1.0,$thermal_data['vmax']*1.0,$thermal_data['tmax']*1.0,
              $thermal_data['qcmax']*1.0,$thermal_data['hs']*$multiplier,
              $thermal_data['Base_N']*1.0,$thermal_data['Base_I']*1.0,$thermal_data['qcmax_offset']*1.0,$thermal_data['vmax_offset']*1.0);

              $item->setIg($thermal_data['ig']);
              $item->setTh($thermal_data['amb']+273.15);
              $item->setTc($thermal_data['tc']+273.15);
              $item->setAmbient($thermal_data['amb']+273.15);
              $IR=$thermal_data['imax'];

              $item->hs=0;
              $QC=$item->calc_qc($thermal_data['imax']);
              $item->hs=$thermal_data['hs']*$multiplier;
              if($QC>$cust['qc']/$multiplier)
              {
                $arr=$item->calc_qc_vs_i();
                $QC=0;
                foreach($arr as $data)
                  if($data[1]>$QC)
                  {
                    $QC=$data[1];
                    $IR=$data[0]*$thermal_data['imax'];
                  }
              }
              if($QC*$multiplier>=$cust['qc']*1.0)
              {
                 $display=true;
                 $num_mod=$multiplier;
              }
            }
          $VIN=$item->calc_v($IR);
        }
        else if(!$display)
        {
          $mult_arr=array(2.0,3.0,4.0,5.0,6.0,7.0,8.0,9.0,10.0);
          foreach($mult_arr as $multiplier)
            if($QC*$multiplier>=$cust['qc']*1.0&&!$display)
            {
              $display=true;
              $num_mod=$multiplier;
            }
        }
      }
      if(is_nan($QC))
        $display=false;

      if($display)
      {
        foreach($row_allProd[$i] as $key => $value)
          if(is_numeric($value)&&$key!='hDim')
            $output[$z][$key]=round($value,1);
          else
            $output[$z][$key]=$value;
        $output[$z]['n']=$num_mod;
        $output[$z]['ir']=round($IR,1);
        $output[$z]['vin']=round($VIN,1);
        $output[$z]['cop']=round($QC/($VIN*$IR),2);
        $QC=$QC*$output[$z]['n'];
        $output[$z]['qc']=round($QC,1);
        $z++;
      }
    }

    return $output;
  }


  function get_family_detail_data($family_id)
  {
    return $this->get_product_line_data(3," where familyID={$family_id}");
  }  

  function get_module_detail_data($mod_id)
  {
    return $this->get_product_line_data(2," where visibility=1 and fullPN={$mod_id}");
  }  

  function get_vfproduct_data($unit,$mounting,$shaftdim,$shaft,$temp,$env)
  {
    global $wpdb;
    return $this->get_product_line_data(1,"vfp".
      " left join vfFluid vff on vff.fluidID=vfp.fk_fluidID".
      " left join vfMounting vfm on vfm.mountingID=vfp.fk_mountingID".
      " left join vfShaft vfs on vfs.shaftID=vfp.fk_shaftID".
      " left join vfFamily vff1 on vff1.familyID=vfp.fk_type".
      " where vfp.src = 1 and vfp.visibility = 1".
      ($unit=='all'?"":" and vfp.unit={$unit}").
      ($temp=='all'?"":" and vfp.f2={$temp}").
      ($env=='all'?"":" and vfp.fk_fluidID={$env}").
      ($shaftdim=='all-all'?"":($shaftdim=='all-in'?" and vfp.d1<=3":($shaftdim=='all-mm'?" and vfp.d1>=4":" and vfp.d1={$shaftdim}"))). 
      ($mounting=='all'?"":" and vfp.fk_mountingID in ({$mounting})"). 
      ($shaft=='all'?"":" and vfp.fk_shaftID={$shaft}"). 
      " order by vfp.d1","vfp.*,vff.fluidTitle,vfm.mountingTitle,vfs.shaftTitle,vff1.familyTitle");
  }  
  function get_vfproduct_detail_data($vfp_id)
  {
    global $wpdb;
    $filter= $wpdb->prepare("
      vfp
      left join vfFluid vff on vff.fluidID=vfp.fk_fluidID
      left join vfMounting vfm on vfm.mountingID=vfp.fk_mountingID
      left join vfShaft vfs on vfs.shaftID=vfp.fk_shaftID
      left join vfFamily vff1 on vff1.familyID=vfp.fk_type
      where vfp.pNum=%s and vfp.visibility = 1
      ",
      $vfp_id
      );
    $data=$this->get_product_line_data(1, $filter,
      "vfp.*,vff.fluidTitle,vfm.mountingTitle,vfs.shaftTitle,vff1.familyTitle");
    foreach($data as $key => $value)
    {  
       if($value==NULL)
         $value='0';
       if(is_array($value))
       {
         foreach($value as $key1 => $value1)
         {  
           if($value1==NULL)
           {
             $i++;
             $value1='0';
           }
           $data[$key][$key1]=$value1;
         }
       }
       else
         $data[$key]=$value;
    }
    return $data;
  }  

  function get_product_line_data($pline_id=0,$filter='',$select='*')
  {
    global $wpdb;
    $this->init_product_line($pline_id);
    $sql= "select ". $select ." from ". $this->table ." ".$filter;
    $data=$wpdb->get_results($sql, OBJECT );
    return $data;
  }
}

?>