<?php
      global $vfp_data;

   session_start();
        /*
        Template Name: Ferrofluidic Seal Product Page
        */
   
     ?>
<?php
   require_once('includes/ferrotec_products.php');
   $results = new fProducts;
   $vfp_id = get_query_var( 'id', 'not found' ); 
   $vfp_data = $results->get_vfproduct_detail_data($vfp_id);
     get_header('vfproduct'); 
   ?>
<?php
   if($_REQUEST['act']=="logout")
   {
    $_SESSION['userid']='';
    $_SESSION['username']='';
    session_destroy();
   }
   ?>

  <?php
   if(isset($_REQUEST['changesubmit']))
   {
     $email = sanitize_email($_REQUEST['email']);
     $password = $_REQUEST['password'];
     $sql = "update wp_customers set password='".md5($password)."',login='yes' where email='".$email."'";
     mysql_query($sql);
     ?>
     <script>window.location.href="?action=download#changesuccess"</script>
     <?php 
   }
   ?>
   
   <?php
   if($_REQUEST['action']=="download")
   {
     $action = "download";
   }
   ?>
   
  <?php
   if(isset($_REQUEST['forgotsubmit']))
   {
    
  $email = sanitize_email($_REQUEST['femail']);
  
    $sql="select * from wp_customers where email='".$email."'";   
    $value=mysql_query($sql);
    $fetch=mysql_fetch_array($value);
    $temppass=rand();
     $sql = "update wp_customers set password='".md5($temppass)."',login='' where email='".$email."'";
     mysql_query($sql);
  
  $to = $email;
      
    if($to) {
    
    $html  = "<table width='100%' cellspacing='0' cellpadding='0' border='0' bgcolor='#f6f5f1' align='center'>
    <tbody>
    <tr>
    <td align='center'>
    <table width='668' cellspacing='0' cellpadding='0' border='0' bgcolor='#f6f5f1' align='center'>
    <tbody>
    <tr>
    <td width='650' bgcolor='#ffffff' align='left'>
    <table width='668' cellspacing='0' cellpadding='0' border='0'>
    <tbody>
    <tr>
    <td>&nbsp;</td>
    </tr>
    <tr>
    <td width='668' align='center' ></td>
    </tr>
    </tbody>
    </table>
   
    <table width='570' cellspacing='0' cellpadding='0' border='0' bgcolor='#ffffff' align='center' style='font-size:13px; color:#852927; font-family:arial; '>
    <tbody>
    <tr>
       <td height='10' colspan='3' align='left'><b>Ferrotec - Account Information</b></td>
       </tr>
    
    <tr>
       <td height='10' colspan='3'></td>
       </tr>
   
    <tr>
       <td  colspan='3'><hr></td>
       </tr>
    
        <tr>
       <td height='10' colspan='3'></td>
       </tr>
    
    <tr>
       <td colspan='3'>Hi&nbsp;".$fetch['firstName']." ".$fetch['lastName'].",</td>
       </tr>
          
    <tr>
       <td height='15' colspan='3'></td>
       </tr>
    

       <tr>
       <td  colspan='3'><b>Please find below your account login Info :</b></td>
       </tr>
    
    <tr>
       <td height='15' colspan='3'></td>
       </tr>
    
    <tr>
       <td align='left' width='100'>Login URL</td>
       <td width='20'>:</td>
       <td align='left'><a href='https://seals.ferrotec.com/' target='blank'>Click Here</a></td>
       </tr>
       
       <tr>
       <td height='15' colspan='3'></td>
       </tr>
    
    <tr>
       <td align='left' width='100'>Username</td>
       <td width='20'>:</td>
       <td align='left'>".$fetch['email']."</td>
       </tr>
      
       <tr>
       <td height='15' colspan='3'></td>
       </tr>
       
       <tr>
       <td align='left'>Password</td>
        <td>:</td>
       <td align='left'>".$temppass."</td>
       </tr>
    
    <tr>
       <td height='10' colspan='3'></td>
       </tr>
       
    <tr>
    <td>&nbsp;</td>
    </tr>
    
       </tbody>
    </table>
   </td>
   </tr>
   </tbody>
   </table>
   
   </td>
   </tr>
   </tbody>
   </table>";
    
    $subject = "Request Download Access";
    $reply = "tmckee@ferrotec.com";
           
        //$headers = 'From: '.$_POST['email'].'\r\n'.'X-Mailer: PHP/' . phpversion();
      $headers  = "From: FERROTEC <".strip_tags($reply).">\r\n";
      $headers .= "Reply-To: ".strip_tags($reply). "\r\n";
      $headers .= "MIME-Version: 1.0\r\n";
      $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
          // $headers.= "Content-Type: text/html; charset=ISO-8859-1\r\n";
    
   
    $html = utf8_decode($html);
       mail($to, $subject, $html, $headers);
   }
?>
<script>window.location.href="#forgotsuccess"</script>
<?php   
   }
?>
   
<?php
   if(isset($_REQUEST['loginsubmit']))
   {
   extract($_POST);
   $sql="select * from wp_customers where email='".$username."' and password='".md5($password)."'";   
   $value=mysql_query($sql);
   $fetch=mysql_fetch_array($value);
   $num = mysql_num_rows($value);
   
   if($fetch['status']=="")
   {
   ?>
   <script>window.location.href="#activate"</script>
   <?php
   }
   
    if($num>0 && $fetch['status']!="")
    {
    $_SESSION['userid']=$fetch['id'];  
    $_SESSION['username']=$fetch['firstName'];
    $_SESSION['email']=$fetch['email'];
    $action = "download";
  if($fetch['login']=="")
  {
  ?>
  <script>window.location.href="?action=download#changepassword"</script>
  <?php 
  }
    }
    
    if($num==0)
    {
    $action = "failed";
    }
   }
   ?> 
<?php
   if(isset($_REQUEST['regsubmit']))
   {
    $userName = sanitize_text_field($_REQUEST['email']);
    $firstName = sanitize_text_field($_REQUEST['firstName']);
    $lastName = sanitize_text_field($_REQUEST['lastName']);
    $email = sanitize_email($_REQUEST['email']);
    $company = sanitize_text_field($_REQUEST['companyName']);
    $city = sanitize_text_field($_REQUEST['city']);
    $state = sanitize_text_field($_REQUEST['state']);
    $country = sanitize_text_field($_REQUEST['country']);
    $phone = sanitize_text_field($_REQUEST['phone']);
    $password = rand();
    $pass=md5($password);
    
       $sql = mysql_fetch_assoc(mysql_query("select count(id) as cnt from wp_customers where email='" . $email . "'"));
    if($sql['cnt']==0){
        $competitor=false;
        $comp_email_array=array(
         'rigaku.com','vacsol.com','beamtec.com','alma-driving.de',
         'jk-nano.com','ants-inc.com','anzcorp.co.kr','brilliant-glory.com.tw',
         'ferrolabs.com','gat-america.com','163.com','vigortec.cn',
         'chinesefitting.com','koreamultitec.com','moretec-inc.com','rliquidsystems.ru',
         'solmics-usa.com','taehanglobal.com','magneticfluidics.com','zzvic.com'
        );
        foreach($comp_email_array as $cdomain)
        {
          if(!(stristr($email,$cdomain)===FALSE))
          {
            $competitor=true;
            break;
          }
        }
        if($competitor)
            $status='';
        else
            $status='Approved';

        $sql="insert into wp_customers (userName,password,firstName,lastName,email,company,status) values ('".$userName."','".$pass."','".$firstName."','".$lastName."','".$email."','".$company."','".$status."')";
    mysql_query($sql);
    $action="success";
    $url='https://www.salesforce.com/servlet/servlet.WebToLead?encoding=UTF-8';
    $sfdata = array(
        'oid' => '00D300000006arv',
        'lead_source' => 'Web',
        'recordType' => '012300000009ecy',
        'Campaign_ID' => '70114000002Rcsq',
        'sf_inquiry_source' => 'registration',
        'first_name' => $firstName,
        'last_name' => $lastName,
        'email' => $email,
        'company' => $company,
        'city' => $city,
        'state' => $state,
        'country' => $country,
        'phone' => $phone
      );

        if(!$competitor){
          $response = wp_remote_post( $url, array(
            'method' => 'POST',
            'timeout' => 45,
            'redirection' => 5,
            'httpversion' => '1.0',
            'blocking' => true,
            'headers' => array(),
            'body' => $sfdata,
            'cookies' => array()
              )
          );
          
          /*if ( is_wp_error( $response ) ) {
             $error_message = $response->get_error_message();
             echo "Something went wrong: $error_message";
          } else {
             echo 'Response:<pre>';
             print_r( $response );
             echo '</pre>';
          }*/
      }
    
    $reply = 'tmckee@ferrotec.com'; 

    $to = $reply;       
    if($email) {
    $html  = "<table border=0 cellpadding=0 cellspacing=0 width=100% align=center bgcolor=#f6f5f1><tr><td align=center><table border=0 cellpadding=0 cellspacing=0 width=668 align=center bgcolor=#f6f5f1><tr><td align=left width=650 bgcolor=#ffffff><table border=0 cellpadding=0 cellspacing=0 width=668><tr><td><tr><td align=center width=668></table><table border=0 cellpadding=0 cellspacing=0 width=570 align=center bgcolor=#ffffff style=font-size:13px;color:#852927;font-family:arial><tr><td colspan=3 height=10 align=left><b>Ferrotec - Thank You</b><tr><td colspan=3 height=10><tr><td colspan=3><hr><tr><td colspan=3 height=10><tr><td colspan=3>Hi ".$firstName.",<tr><td colspan=3 height=15><tr><td colspan=3>Thank you for creating your account at Ferrotec<br><tr><td colspan=3 height=15><tr><td></table></table></table>";
    if(!$competitor)
      $subject="Request for Download Access Has Occured from " . $firstName . " " . $lastName;
    else
      $subject="Request for Download Access from a Competitor Has Occured from " . $firstName . " " .$lastName;

      $headers  = "From: <" . $email . ">\r\n";
      $headers .= "MIME-Version: 1.0\r\n";
      $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
      $html = utf8_decode($html);
      mail($to, $subject, $html, $headers);
   
      if(!$competitor){
          $to_cust = $email;        
          $html_cust  = "<table border=0 cellpadding=0 cellspacing=0 width=100% align=center bgcolor=#f6f5f1><tr><td align=center><table border=0 cellpadding=0 cellspacing=0 width=668 align=center bgcolor=#f6f5f1><tr><td align=left width=650 bgcolor=#ffffff><table border=0 cellpadding=0 cellspacing=0 width=668><tr><td><tr><td align=center width=668></table><table border=0 cellpadding=0 cellspacing=0 width=570 align=center bgcolor=#ffffff style=font-size:13px;color:#852927;font-family:arial><tr><td colspan=3 height=10 align=left><b>Ferrotec - Account Activation</b><tr><td colspan=3 height=10><tr><td colspan=3><hr><tr><td colspan=3 height=10><tr><td colspan=3>Hi ".$firstName." ".$lastName.",<tr><td colspan=3 height=15><tr><td colspan=3>Your account has been activated on Ferrotec.<br><br>Now you can login the site.<br><br>Please find below your account login Info :<tr><td colspan=3 height=15><tr><td align=left width=100>Login URL<td width=20>:<td align=left><a href=http://seals.ferrotec.com/products/ferrofluidic-vacuum-rotary-feedthroughs/ target=blank>Click Here</a><br><br>Navigate to any of the Standard Feedthroughs to download a DXF or STP file.<tr><td colspan=3 height=15><tr><td align=left width=100>Username<td width=20>:<td align=left>".$email."<tr><td colspan=3 height=15><tr><td align=left>Password<td>:<td align=left>".$password."<tr><td colspan=3 height=10><tr><td></table></table></table>";
          $subject_cust="Ferrotec Feedthrough Resources Account Activation";
          $headers_cust  = "From: Ferrotec Account Activation <".strip_tags($reply).">\r\n";
          $headers_cust .= "Reply-To: ".strip_tags($reply). "\r\n";
          $headers_cust .= "MIME-Version: 1.0\r\n";
          $headers_cust .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
          $html_cust = utf8_decode($html_cust);
          mail($to_cust, $subject_cust, $html_cust, $headers_cust);      
        }
    }
  }

      else
    {
    $action="available";  
    }
    
    $current_url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; 
       $current_url = $current_url."#success";  
   }
   ?>
<?php
   if($action=="success")
   {
   ?>
<style type="text/css">
   #downloads
   {
   display:block !important;
   }
</style>
<?php
   }
   ?>
<?php foreach ($vfp_data as $product ): ?>
<?php 
   if ($product->unit == 1) $displayUnit="in";
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
            <h2>Feedthrough Model: <?php echo $product->mNum ?><br> Part Number: <?php echo $product->pNum ?></h2>
            <p>&nbsp;</p>
         </div>
         <div class="col-sm-12">
            <ul class="nav nav-tabs nav-product-tabs" role="tablist">
               <li role="presentation" <?php if($action=="")
                  { ?> class="active" <?php } ?>  >
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
               <li role="presentation" <?php if($action!="")
                  { ?> class="active" <?php } ?>>
                  <a href="#downloads" aria-controls="downloads" role="tab" data-toggle="tab">
                     <div class="visible-xs tabicon icn-downloads"></div>
                     <div class="hidden-xs">Downloads</div>
                  </a>
               </li>
            </ul>
            <div class="tab-content">
               <div role="tabpanel" class="tab-pane<?php if($action=="")
                  { ?> active <?php } ?>" id="description">
                  <h3>Product Description</h3>
                  <div class="row">
                     <div class="col-sm-6">
                        <p>Ferrotec&rsquo;s Ferrofluidic seal Feedthrough Model <?php echo $product->mNum?> (part number <?php echo $product->pNum ?>) is a member of Ferrotec&rsquo;s <?php echo $product->familyTitle ?>s. The <?php echo $product->mNum ?> vacuum rotary feedthrough uses Ferrotec&rsquo;s <?php if ($product->fk_fluidID == '2') : ?>standard hydrocarbon-based<?php endif ?><?php if ($product->fk_fluidID == '1') : ?>fluorocarbon-based<?php endif ?> ferrofluid, specifically optimized for introducing rotary motion with a magnetic liquid hermetic seal in most <?php echo $product->fluidTitle ?> environments.</p>
                        <p>The <?php echo $product->mNum ?> vacuum rotary feedthrough features a <?php echo $product->shaftTitle ?> shaft with <?php echo $product->mountingTitle ?> mounting. Dimensional details are specified below. <?php if ($product->f2 == '1') : ?>This vacuum seal is also water-cooled for high-temperature applications.<?php endif ?> For precision measurement specifications, refer to the Spec Control Drawing.</p>
                        <p><strong>Ferrotec Part Number <?php echo $product->pNum ?> Dimension Specification Drawing</strong></p>
                        <a href="/wp-content/uploads/sites/2/diag-vf-<?php echo $product->pNum ?>.jpg" title="Feedthrough Model SS-188-SLAA (part number <?php echo $product->pNum ?>) dimensional specifications drawing"><img src="/wp-content/uploads/sites/2/diag-vf-<?php echo $product->pNum ?>.jpg" alt="Feedthrough Model SS-188-SLAA (part number 103971) dimensional specifications drawing" width="386" height="306" border="0"></a> 
                     </div>
                     <div class="col-sm-6">
                        <p class="text-center"><img class="center-block" src="/wp-content/uploads/sites/2/img-vf-<?php echo $product->pNum ?>.jpg" alt="Feedthrough Model <?php echo $product->mNum ?> (part number <?php echo $product->pNum ?>) image" style="width:60%;" border="0">  
                     </div>
                  </div>
               </div>
               <div role="tabpanel" class="tab-pane" id="specifications">
                  <h3>Product Specifications</h3>
                  <p><strong>Specifications for Ferrotec Part Number <?php echo $product->pNum ?></strong><br></p>
                  <div class="row">
                     <div class="col-sm-6">
                        <table class="table" width="100%" border="0" cellspacing="0" cellpadding="0">
                           <tbody>
                              <tr>
                                 <td width="40%">Shaft</td>
                                 <td width="60%"><?php echo $product->shaftTitle ?>&nbsp;Shaft</td>
                              </tr>
                              <tr>
                                 <td>Shaft Support:</td>
                                 <td>
                                    <?php if ($product->b1 == '1') : ?>Simply Supported (vac+atm sides) <br><?php endif ?>
                                    <?php if ($product->b2 == '1') : ?>Cantilevered (both on atm side) <br><?php endif ?>
                                    <?php if ($product->b3 == '1') : ?>Heavy Duty <br><?php endif ?>
                                 </td>
                              </tr>
                              <tr>
                                 <td>Ferrofluid</td>
                                 <td><?php echo $product->fluidTitle ?></td>
                              </tr>
                              <tr>
                                 <td>Mounting</td>
                                 <td>
                                    <?php echo $product->mountingTitle ?>
                                    <?php if ($product->mntOpt == '1') : ?><br>Mounting Nut and Washer Included <br><?php endif ?>
                                 </td>
                              </tr>
                              <?php if ( $product->f1 == '1' || $product->f2 == '1' || $product->f3 == '1' || $product->f4 == '1' || $product->f5 == '1' ) : ?>
                              <tr>
                                 <td>Features:</td>
                                 <td>
                                    <?php if ($product->f1 == '1') : ?>Sleeve <br><?php endif ?>
                                    <?php if ($product->f2 == '1') : ?>Water-cooled <br><?php endif ?>
                                    <?php if ($product->f3 == '1') : ?>Shaft Clamp <br><?php endif ?>
                                    <?php if ($product->f4 == '1') : ?>Electrical Isolation (Sleeved Bore)" <br><?php endif ?>
                                    <?php if ($product->f5 == '1') : ?>Number of Union Services <br><?php endif ?>
                                 </td>
                              </tr>
                              <?php endif ?>
                              <tr>
                                 <td colspan="2"><br>
                                    <strong>Dimensions:</strong>
                                 </td>
                              </tr>
                              <?php if ($product->d45 != 0) : ?>
                              <tr>
                                 <td>Shaft (or bore) Diameter with tolerance</td>
                                 <td><?php echo $product->d45 ?>&nbsp;<?php if ($product->d2 != 0) : ?>(<?php echo $product->d2 ?>)<?php endif ?> <?php echo $displayUnit ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($product->d3 != 0) : ?>
                              <tr>
                                 <td>Shaft termination</td>
                                 <td><?php echo $product->d3 ?>&nbsp;<?php echo $displayUnit ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($product->d4 != 0) : ?>
                              <tr>
                                 <td>Shaft extension (Vac)</td>
                                 <td><?php echo $product->d4?>&nbsp;<?php echo $displayUnit ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($product->d5 >= '1') : ?>
                              <tr>
                                 <td>Overall length</td>
                                 <td><?php echo $product->d5?>&nbsp;<?php echo $displayUnit ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($product->d6 != 0) : ?>
                              <tr>
                                 <td>Housing overall length</td>
                                 <td><?php echo $product->d6?>&nbsp;<?php echo $displayUnit ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($product->d7 != 0) : ?>
                              <tr>
                                 <td>Housing diameter</td>
                                 <td><?php echo $product->d7?>&nbsp;<?php if ($product->d8 != 0) : ?>(<?php echo $product->d8 ?>)<?php endif ?> <?php echo $displayUnit ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($product->d9 != 0) : ?>
                              <tr>
                                 <td>Body length</td>
                                 <td><?php echo $product->d9?>&nbsp;<?php echo $displayUnit ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($product->d10 != 0) : ?>
                              <tr>
                                 <td>Thread diameter</td>
                                 <td><?php echo $product->d10?>&nbsp;<?php echo $displayUnit ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($product->d11 != 0) : ?>
                              <tr>
                                 <td>Thread pitch [tps] or [mm/thd] (metric)</td>
                                 <td><?php echo $product->d11?>&nbsp;<?php if ($product->unit == '1'): ?>[tps]<?php else : ?>[mm/thd]<?php endif ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($product->d12 != 0) : ?>
                              <tr>
                                 <td>Thread length</td>
                                 <td><?php echo $product->d12?>&nbsp;<?php echo $displayUnit ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($product->d13 != 0) : ?>
                              <tr>
                                 <td>Clamp diameter</td>
                                 <td><?php echo $product->d13?>&nbsp;<?php echo $displayUnit ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($product->d14 != 0) : ?>
                              <tr>
                                 <td>Clamp thickness</td>
                                 <td><?php echo $product->d14?>&nbsp;<?php echo $displayUnit ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($product->d15 != 0) : ?>
                              <tr>
                                 <td>Recommended shaft diameter</td>
                                 <td><?php echo $product->d15?>&nbsp;<?php if ($product->d16 != 0) : ?>(<?php echo $product->d16 ?>) <?php echo $displayUnit ?><?php endif ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($product->d17 != 0) : ?>
                              <tr>
                                 <td>Recommended mounting bore</td>
                                 <td><?php echo $product->d17?>&nbsp;<?php if ($product->d18 != 0) : ?>(<?php echo $product->d18 ?>) <?php echo $displayUnit ?><?php endif ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($product->d19 != 0) : ?>
                              <tr>
                                 <td>Flange diameter</td>
                                 <td><?php echo $product->d19?>&nbsp;<?php echo $displayUnit ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($product->d20 != 0) : ?>
                              <tr>
                                 <td>Flange thickness</td>
                                 <td><?php echo $product->d20?>&nbsp;<?php echo $displayUnit ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($product->d21 != 0) : ?>
                              <tr>
                                 <td>Flange wrench flat</td>
                                 <td><?php echo $product->d21?>&nbsp;<?php echo $displayUnit ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($product->d22 != 0) : ?>
                              <tr>
                                 <td>Fitting locations</td>
                                 <td><?php echo $product->d22?>&nbsp;<?php echo $displayUnit ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($product->d23 != 0) : ?>
                              <tr>
                                 <td>Mounting holes</td>
                                 <td><?php echo $product->d23?>&nbsp;<?php echo $displayUnit ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($product->d38 != '') : ?>
                              <tr>
                                 <td>Flange Type</td>
                                 <td><?php echo $product->d38 ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($product->d37 != 0) : ?>
                              <tr>
                                 <td>Face seal O-ring</td>
                                 <td><?php echo $product->d37 ?></td>
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
                              <?php if ($product->d25 != '') : ?>
                              <tr>
                                 <td>Bearing type/material</td>
                                 <td><?php echo $product->d25 ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($product->d26 != 0) : ?>
                              <tr>
                                 <td>Bearing load cap</td>
                                 <td><?php echo $product->d26 ?> <?php if ($product->unit == '1') : ?>Pounds<?php else : ?>Kilograms<?php endif ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($product->d27 != 0) : ?>
                              <tr>
                                 <td>Bearing dynamic load capacity</td>
                                 <td><?php echo $product->d27 ?> <?php if ($product->unit == '1') : ?>Pounds<?php else : ?>Kilograms<?php endif ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($product->d28 != 0) : ?>
                              <tr>
                                 <td>Bearing Dim A</td>
                                 <td><?php echo $product->d28 ?>&nbsp;<?php echo $displayUnit ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($product->d29 != 0) : ?>
                              <tr>
                                 <td>Bearing Dim B</td>
                                 <td><?php echo $product->d29 ?>&nbsp;<?php echo $displayUnit ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($product->fk_shaftID == '1') : ?>
                              <tr>
                                 <td colspan="2"><a href="/wp-content/uploads/sites/2/sldBearingDim.jpg" title="Solid Shaft bearing dimensional specifications reference drawing"><img src="/wp-content/uploads/sites/2/sldBearingDim.jpg" alt="Solid Shaft bearing dimensional specifications reference drawing" width="210" height="167" border="0" /></a> <br></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($product->fk_shaftID == '2') : ?>
                              <tr>
                                 <td colspan="2"><a href="/wp-content/uploads/sites/2/hlwBearingDim.jpg" title="Hollow Shaft bearing dimensional specifications reference drawing"><img src="/wp-content/uploads/sites/2/hlwBearingDim.jpg" alt="Hollow Shaft bearing dimensional specifications reference drawing" width="210" height="167" border="0" /></a> <br></td>
                              </tr>
                              <?php endif ?>
                              <tr>
                                 <td colspan="2"><br>
                                    <strong>Performance Characteristics:</strong>
                                 </td>
                              </tr>
                              <?php if ($product->d30 != 0) : ?>
                              <tr>
                                 <td>Max Speed</td>
                                 <td><?php echo $product->d30 ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($product->d31 != 0) : ?>
                              <tr>
                                 <td>Max Thrust (Axial Load Limit)</td>
                                 <td><?php echo $product->d31 ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($product->d32 != 0) : ?>
                              <tr>
                                 <td>Radial Load Capacity</td>
                                 <td><?php echo $product->d32 ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($product->d24 != 0) : ?>
                              <tr>
                                 <td>Shaft Torque Capacity</td>
                                 <td><?php echo $product->d24 ?> <?php if ($product->unit == '1') : ?>in-lb<?php else : ?>N-m<?php endif ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($product->d40 != 0) : ?>
                              <tr>
                                 <td>Starting Torque 100rpm</td>
                                 <td><?php echo $product->d40 ?>&nbsp;<?php if ($product->unit == '1') : ?>in-oz<?php else : ?>N-mm<?php endif ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($product->d41 != 0) : ?>
                              <tr>
                                 <td>Running Torque 100rpm</td>
                                 <td><?php echo $product->d41 ?>&nbsp;<?php if ($product->unit == '1') : ?>in-oz<?php else : ?>N-mm<?php endif ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($product->d42 != 0) : ?>
                              <tr>
                                 <td>Starting Torque 1000rpm</td>
                                 <td><?php echo $product->d42 ?>&nbsp;<?php if ($product->unit == '1') : ?>in-oz<?php else : ?>N-mm<?php endif ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($product->d43 != 0) : ?>
                              <tr>
                                 <td>Running Torque 1000rpm</td>
                                 <td><?php echo $product->d43 ?>&nbsp;<?php if ($product->unit == '1') : ?>in-oz<?php else : ?>N-mm<?php endif ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($product->d34 != 0) : ?>
                              <tr>
                                 <td>Starting Torque</td>
                                 <td><?php echo $product->d34 ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($product->d35 != 0) : ?>
                              <tr>
                                 <td>Running Torque</td>
                                 <td><?php echo $product->d35 ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($product->d36 != 0) : ?>
                              <tr>
                                 <td>Limiting Speed [rpm]</td>
                                 <td><?php echo $product->d36 ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($product->d39 != '') : ?>
                              <tr>
                                 <td>Notes</td>
                                 <td><?php echo $product->d39 ?></td>
                              </tr>
                              <?php endif ?>
                              <?php if ($product->nS == '1') : ?>
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
                                    General vacuum seal specifications can be found on <a href="https://seals.ferrotec.com/products/ferrofluidic/seals/vfSpecsCommon/">Ferrotec’s Standard Feedthrough Common Specifications page.</a><br>
                                    For an explanation of Ferrotec’s flange mounting terminology, consult <a href="https://seals.ferrotec.com/products/ferrofluidic/seals/flangeOptions/">Ferrotec’s Flange Mount Options page.</a>
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
                        <p><strong>Ordering Information for Model <?php echo $product->mNum ?>, Part Number <?php echo $product->pNum ?></strong></p>
                        <p>If you have questions about pricing and availability, need more information about Ferrotec's <?php echo $product->mNum ?> rotary feedthroughs, or if you have other Ferrofluidic seal requirements, you can submit your request using the form below or <a href="/contact/sales/salesFerrofluidic/"><strong>contact your Ferrotec representative directly&nbsp;&raquo;</strong></a></p>
                        <p><strong>Special Orders, Modifications, and Customized Solutions for Unique Applications</strong></p>
                        <p>Model <?php echo $product->mNum ?>, Part Number <?php echo $product->pNum ?> is a standard model vacuum rotary feedthrough. Ferrotec can also customize a <?php echo $product->shaftTitle ?> shaft vacuum rotary feedthrough to match your specific application requirements. Please contact Ferrotec for more information.</p>
                        <p><strong>Please Contact Me Regarding Ferrotec Model Number <?php echo $product->mNum ?></strong></p>
                        <p>Use this form to submit your <?php echo $product->mNum ?> (part number <?php echo $product->pNum ?>) inquiry directly to Ferrotec. If you have special requirements or need specific customizations, please include the details in your description. </p>
                     </div>
                     <div class="col-sm-6">
                        <?php
                           gravity_form( 'vf-inquiry', false, false, false, array( 'ferrotec_model_number' => $product->mNum ), false, true );
                            ?>
                     </div>
                  </div>
               </div>
               <div role="tabpanel" class="tab-pane<?php if($action!="")
                  { ?> active <?php } ?>" id="downloads">
                  <style type="text/css">
                     input
                     {
                     -moz-border-radius: 15px;
                     border-radius: 5px;
                     border:solid 1px #cccccc;
                     padding:0px;
                     padding-left:10px;
                     height:27px;
                     }
                     .button
                     {
                     width:100px;
                     padding-left:0;
                     background-color:#00a790;
                     color:#ffffff;
                     }
                     .button2
                     {
                     width:100px;
                     padding-left:0;
                     background-color:#1c75bc;
                     color:#ffffff;
                     }
                     form [class*="alert_box"] {
                     margin-top: 10px;
                     -webkit-backface-visibility: hidden;
                     }
                     .error, .out_of_stock, .alert_box_error {
                     color: #ff0000;
                     }
                     [class*="alert_box"] {
                     position: relative;
                     border-width: 1px;
                     border-style: solid;
                     background: #fff;
                     padding: 3px;
                     }
                     select
                     {
                     -moz-border-radius: 15px;
                     border-radius: 5px;
                     border:solid 1px #cccccc;
                     padding:0px;
                     padding-left:10px;
                     height:27px;
                     width:80px;
                     }
                  </style>
                  <script type="text/javascript">
                     function loginValidate(){
                     
                     document.getElementById('addresserr').innerHTML = '';
                           
           username=document.getElementById('username').value;
                     if(username=="")
                     {
                     document.getElementById('addresserr').innerHTML='Enter email address';
                     document.getElementById('username').focus();
                     document.getElementById('addresserr').style.display = "block";
                     return false;
                     }
                     
                     else if(document.getElementById('username').value!="") 
                        {              
                            EA=document.getElementById('username').value; 
                            EA = EA.toLowerCase();                 
                            if((EA.substring(0,1)<"a" || EA.substring(0,1)>"z") && (EA.substring(0,1)<"A" || EA.substring(0,1)>"Z"))
                            { 
                            document.getElementById('addresserr').innerHTML='Invalid email!'; 
                            document.getElementById('username').focus();
                            document.getElementById('addresserr').style.display = "block";        
                            return false;              
                            }
                            else 
                            {              
                            if(!checkemail(EA)) 
                            {  
                            document.getElementById('addresserr').innerHTML='Invalid email!'; 
                            document.getElementById('username').focus(); 
                            document.getElementById('addresserr').style.display = "block";           
                            return false;  
                            }
                            }  
                        }
           
           
                        
                     password=document.getElementById('password').value;
                     if(password=="")
                     {
                     document.getElementById('addresserr').innerHTML='Enter password'; 
                     document.getElementById('password').focus();
                     document.getElementById('addresserr').style.display = "block"; 
                     return false;
                     }
                     
                     return true;
                     
                     }
           
        function forgotValidate(){
                     
                   document.getElementById('addresserr3').innerHTML = '';
                           
           femail=document.getElementById('femail').value;
                     if(femail=="")
                     {
                     document.getElementById('addresserr3').innerHTML='Enter email address';
                     document.getElementById('femail').focus();
                     document.getElementById('addresserr3').style.display = "block";
                     return false;
                     }
                     
                     else if(document.getElementById('femail').value!="") 
                        {              
                            EA=document.getElementById('femail').value; 
                            EA = EA.toLowerCase();                 
                            if((EA.substring(0,1)<"a" || EA.substring(0,1)>"z") && (EA.substring(0,1)<"A" || EA.substring(0,1)>"Z"))
                            { 
                            document.getElementById('addresserr3').innerHTML='Invalid email!'; 
                            document.getElementById('femail').focus();
                            document.getElementById('addresserr3').style.display = "block";        
                            return false;              
                            }
                            else 
                            {              
                            if(!checkemail(EA)) 
                            {  
                            document.getElementById('addresserr3').innerHTML='Invalid email!'; 
                            document.getElementById('femail').focus(); 
                            document.getElementById('addresserr3').style.display = "block";           
                            return false;  
                            }
                            }  
                        }
          
                     
                     return true;
                     
                     }
                     
                     function regValidate(){
                     
                     document.getElementById('addresserr2').innerHTML = '';
                     
                     firstName=document.getElementById('firstName').value;
                     if(firstName=="")
                     {
                     document.getElementById('addresserr2').innerHTML='Enter first name'; 
                     document.getElementById('firstName').focus();
                     document.getElementById('addresserr2').style.display = "block"; 
                     return false;
                     }
                     
                     lastName=document.getElementById('lastName').value;
                     if(lastName=="")
                     {
                     document.getElementById('addresserr2').innerHTML='Enter last name'; 
                     document.getElementById('lastName').focus();
                     document.getElementById('addresserr2').style.display = "block"; 
                     return false;
                     }
                     
                     email=document.getElementById('email').value;
                     if(email=="")
                     {
                     document.getElementById('addresserr2').innerHTML='Enter email address';
                     document.getElementById('email').focus();
                     document.getElementById('addresserr2').style.display = "block";
                     return false;
                     }
                     
                     else if(document.getElementById('email').value!="") 
                        {              
                            EA=document.getElementById('email').value; 
                            EA = EA.toLowerCase();                 
                            if((EA.substring(0,1)<"a" || EA.substring(0,1)>"z") && (EA.substring(0,1)<"A" || EA.substring(0,1)>"Z"))
                            { 
                            document.getElementById('addresserr2').innerHTML='Invalid email, please use a business email address'; 
                            document.getElementById('email').focus();
                            document.getElementById('addresserr2').style.display = "block";        
                            return false;              
                            }
                            else 
                            {              
                            if(!checkemail(EA)) 
                            {  
                            document.getElementById('addresserr2').innerHTML='Invalid email, please use a business email address'; 
                            document.getElementById('email').focus(); 
                            document.getElementById('addresserr2').style.display = "block";           
                            return false;  
                            }
                            }  
                        }
                        
                     companyName=document.getElementById('companyName').value;
                     if(companyName=="")
                     {
                     document.getElementById('addresserr2').innerHTML='Enter company name'; 
                     document.getElementById('companyName').focus();
                     document.getElementById('addresserr2').style.display = "block"; 
                     return false;
                     }
                     
                     return true;
                     
                     }
                     
                           var testresults
                           function checkemail(str) 
                           {
                             var str;
                             //var filter=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i
                              var eblack_list = Array('yahoo.com','gmail.com','hotmail.com','naver.com','msn.com','freenet.de');
                             //var filter=/^[a-z][a-z|0-9|]*([_][a-z|0-9]+)*([.][a-z|0-9]+([_][a-z|0-9]+)*)?@[a-z][a-z|0-9|]*\.([a-z][a-z|0-9]*(\.[a-z][a-z|0-9]*)?)$/
                     
                             //var filter = /%u([0-9A-Za-z]{4})/g;
                             /*var filter=new RegExp("^[a-zA-Z0-9_.\\-]+@[a-zA-Z0-9\\-]+\.(co.in|in|in.com|in.it|com|org|net|biz|info|bussinessname|aero|biz|info|jobs|museum|CO.IN|IN|IN.COM|IN.IT|COM|ORG|NET|BIZ|INFO|BUSSINESSNAME|AERO|BIZ|INFO|JOBS|MUSEUM)$");*/
                             var filter=new RegExp(/^[-a-z0-9~!$%^&*_=+}{\'?]+(\.[-a-z0-9~!$%^&*_=+}{\'?]+)*@([a-z0-9_][-a-z0-9_]*(\.[-a-z0-9_]+)*\.(aero|arpa|biz|com|coop|edu|gov|info|int|mil|museum|name|net|org|pro|travel|mobi|[a-z][a-z])|([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}))(:[0-9]{1,5})?$/i);
                             
                             if (filter.test(str))
                                 testresults=true
                             else 
                             {
                                 // alert("Please input a valid email address!")
                                 testresults=false
                             }
                              x=str.toLowerCase();
                              for(i=0;i<eblack_list.length;i++)
                              {
                                 if(x.search(eblack_list[i])>0)
                                   testresults=false
                              }
                             return (testresults)
                           }
                     
                  </script>
                  <?php
                     if($_SESSION['userid']!="")
                     {
                      //echo "id=".$_SESSION['userid'];
                     ?>
                  <h3>Available CAD Files</h3>
                  <div class="row" style="float:left; text-align:center; width:500px; padding:20px; margin-left:5px; height:150px; background-color:#efefef;">
                     <div class="col-sm-12">
                        <p style="text-align:left;">Feedthrough Model: <?php echo $product->mNum ?><br> Part Number: <?php echo $product->pNum ?></p>
                     </div>
                     <a href="/seals-site/product/drawing/2d_drawings/<?php echo $product->pNum ?>.dxf">
                        <div style="width:100px; margin-left:15px; float:left; height:30px; line-height:30px; background-color:#ffffff; border:1px solid #cccccc;">
                           DXF Format
                        </div>
                     </a>
                     <a href="/seals-site/product/drawing/step_assemblies/<?php echo $product->pNum ?>.stp">
                        <div style="width:100px; margin-left:20px; float:left; height:30px; line-height:30px; background-color:#ffffff; border:1px solid #cccccc;">
                           STP Format
                        </div>
                     </a>
                  </div>
                  <?php
                     }
                     ?>
                  <?php
                     if($_SESSION['userid']=="")
                     {
                      //echo "id=".$_SESSION['userid'];
                     ?>
                  <h3>Available CAD Files</h3>
                  <div style="float:left; text-align:center; width:270px; padding:20px; height:330px; background-color:#1c75bc;">
                     <h4 style="color:#ffffff;">Login to Download Files</h4>
                     <?php
                        if($action=="failed")
                        {
                        ?>
                     <div style="height:25px; border:1px solid #ff0000; line-height:25px; background-color:#ffffff; margin-bottom:10px; color:#ff0000;">
                        Invalid login info.
                     </div>
                     <?php
                        }
                        ?>
                     <div id="addresserr" class="alert_box error" style="display:none; color:#ff0000;"></div>
                     <form name="login" method="post" action="">
                        <table cellpadding="0" width="100%" cellspacing="0" border="0">
                           <tr>
                              <td>&nbsp;</td>
                           </tr>
                           <tr>
                              <td align="center"><input type="text" name="username" id="username" placeholder="Email"></td>
                           </tr>
                           <tr>
                              <td height="10"></td>
                           </tr>
                           <tr>
                              <td align="center"><input type="password" name="password" id="password" placeholder="Password"></td>
                           </tr>
                           <tr>
                              <td height="10"></td>
                           </tr>
                           <tr>
                              <td align="center"><input type="submit" name="loginsubmit" value="Login" class="button" onClick="return loginValidate();"></td>
                           </tr>
                           <tr>
                              <td height="10"></td>
                           </tr>
                           <tr>
                              <td height="10" style="color:#ffffff;"><a href="#forgot" style="text-decoration:none; color:#ffffff;">Forgot Password</a></td>
                           </tr>
                        </table>
                     </form>
                  </div>
                  <?php if($action=="" || $action=="available" || $action=="failed")
                     { 
                        ?>
                  <div style="float:left; margin-left:20px; text-align:center; width:700px; padding:20px; min-height:330px; background-color:#e6e7e8;">
                     <h4>Create a New Ferrotec Download Account</h4>
                     <?php
                        if($action=="available")
                        {
                        ?>
                     <div style="height:25px; border:1px solid #ff0000; line-height:25px; background-color:#ffffff; margin-bottom:10px; color:#ff0000;">
                        A user already exists with this email address. Please use different email address to register or login.
                     </div>
                     <?php
                        }
                        ?>
                     <p style="text-align:left;">After registering, you will receive a temporary password via email to the address you specify. That email address will be your user name. Normally, it takes approximately one or two business days to approve accounts and send you your temporary password.</p>
                     <div id="addresserr2" class="alert_box error" style="display:none; color:#ff0000;"></div>
                     <form name="register" method="post" action="">
                        <input type="hidden" id="00N30000008eN2Z" name="00N30000008eN2Z" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>">
                        <input type="hidden" id="00N1400000BP8F8" name="00N1400000BP8F8" >
                        <input type="hidden" id="00N300000025GPN" name="00N300000025GPN" value="Registration">

                        <table cellpadding="0" width="100%" cellspacing="0" border="0">
                           <tr>
                              <td height="10"></td>
                           </tr>
                           <tr>
                              <td align="right">
                                 <select name="sign" id="sign">
                                    <option value="">Select... </option>
                                    <option value="Mr">Mr</option>
                                    <option value="Ms">Ms</option>
                                    <option value="Mrs">Mrs</option>
                                 </select>
                              </td>
                              <td>&nbsp;</td>
                              <td align="center"><input type="text" name="firstName" id="firstName" placeholder="First Name"></td>
                              <td>&nbsp;</td>
                              <td align="center"><input type="text" name="lastName" id="lastName" placeholder="Last Name"></td>
                           </tr>
                           <tr>
                              <td colspan="5" height="5px"></td>
                           </tr>
                           <tr>
                              <td align="center"><input type="text" name="city" id="city" placeholder="City"></td>
                              <td>&nbsp;</td>
                              <td align="center"><input type="text" name="state" id="state" placeholder="State"></td>
                              <td>&nbsp;</td>
                              <td align="center"><input type="text" name="country" id="country" placeholder="Country"></td>
                           </tr>
                           <tr>
                              <td colspan="5" height="5px"></td>
                           </tr>
                           <tr>
                              <td align="center"><input type="text" name="phone" id="phone" placeholder="Phone"></td>
                              <td>&nbsp;</td>
                              <td align="center"><input type="text" name="email" id="email" placeholder="Email Address"></td>
                              <td>&nbsp;</td>
                              <td align="center"><input type="text" name="companyName" id="companyName" placeholder="Company Name"></td>
                           </tr>
                           <tr>
                              <td colspan="5" height="5px"></td>
                           </tr>
                           <tr>
                              <td colspan="5" align="center">Please use your business email address not a personal address.</td>
                           </tr>
                           <tr>
                              <td colspan="5" height="10px"></td>
                           </tr>
                           <tr>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td align="center"><input type="submit" name="regsubmit" value="Register" class="button2" onClick="return regValidate();"></td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                           </tr>
                        </table>
                     </form>
                  </div>
                  <?php
                     }
                     ?>
                  <?php if($action!="" && $action!="available" && $action!="failed")
                     { 
                        ?>
                  <div style="float:left; margin-left:20px; text-align:center; width:700px; padding:20px; height:330px; background-color:#e6e7e8;">
                     <h4 style="text-align:left;">Success!</h4>
                     <br>
                     <p style="text-align:left;">
                        <b style="font-weight:bold;">Your request was received and is being processed now.</b> <br>
                        In one or two business days you will receive an email from Ferrotec with a link
                        to login where you’ll use to download the CAD files you've requested. On your first login, you’ll be asked to set a permanent password.
                     </p>
                  </div>
                  <?php
                     }
                     ?>   
                  <?php
                     }
                     ?>
               </div>
            </div>
         </div>
   </article>
</main>
<!-- #main -->
</div>
<?php endforeach ?>

<div class="remodal" data-remodal-id="forgot" role="dialog" style="max-width:550px !important;" aria-labelledby="modal1Title" aria-describedby="modal1Desc">
<a data-remodal-action="close" class="remodal-close"></a>
  <form class="type_2" method="post" action="#" name="forgot">
  <div>
    <h2 class="seeking">Forgot Password</h2>
  </div>
  
   <div id="addresserr3" class="alert_box error" style="display:none; color:#ff0000;"></div>
  
   <p style="font-size:16px; font-color:#ff0000 !important;">
  
  Enter the email address of your account here.
  
  <form name="addcustomer" method="post" action="">
  
  <table cellpadding="0" cellspacing="0" border="0">
  
  <tr>
  <td width="35%" align="left"><b>Email</b> </td>
  <td width="2%">:</td>
  <td><input type="text" name="femail" id="femail" required class="textbox"></td>
  </tr>
  
  <tr>
  <td height="10"></td>
  </tr>
  
  <tr>
  <td align="left">&nbsp;</td>
  <td>&nbsp;</td>
  <td align="left"><input type="submit" name="forgotsubmit" value="Submit" onClick="return forgotValidate();" style="width:90px; padding-left:0px;"></td>
  </tr>
  
  </table>
  
  </form>
  
  </p>

  <div class="clear"></div>
  
  </form>
</div>

<div class="remodal" data-remodal-id="changepassword" role="dialog" style="max-width:550px !important;" aria-labelledby="modal1Title" aria-describedby="modal1Desc">
<a data-remodal-action="close" class="remodal-close"></a>
  <form class="type_2" method="post" action="#" name="forgot">
  <div>
    <h2 class="seeking">Change Password</h2>
  </div>
   <p style="font-size:16px; font-color:#ff0000 !important;">
  
  Enter the new password of your account here.
  
  <form name="addcustomer" method="post" action="">
  
  <table cellpadding="0" cellspacing="0" border="0">
  <input type="hidden" name="email" id="email" value="<?php echo $_SESSION['email']; ?>" required class="textbox">
  <tr>
  <td width="35%" align="left"><b>Password</b> </td>
  <td width="2%">:</td>
  <td><input type="password" name="password" id="password" required class="textbox"></td>
  </tr>
  
  <tr>
  <td height="10"></td>
  </tr>
  
  <tr>
  <td align="left">&nbsp;</td>
  <td>&nbsp;</td>
  <td align="left"><input type="submit" name="changesubmit" value="Submit" style="width:90px; padding-left:0px;"></td>
  </tr>
  
  </table>
  
  </form>
  
  </p>

  <div class="clear"></div>
  
  </form>
</div>

<div class="remodal" data-remodal-id="changesuccess" role="dialog" style="max-width:550px !important;" aria-labelledby="modal1Title" aria-describedby="modal1Desc">
<a data-remodal-action="close" class="remodal-close"></a>
  <form class="type_2" method="post" action="#" name="register<?=$i?>">
  <div>
    <h2 class="seeking">Change Password</h2>
  </div>
   <p style="font-size:16px; font-color:#ff0000 !important;">
  
   Password has been updated successfully!.
   

  </p>

  <div class="clear"></div>
  
  </form>
</div>

<div class="remodal" data-remodal-id="forgotsuccess" role="dialog" style="max-width:550px !important;" aria-labelledby="modal1Title" aria-describedby="modal1Desc">
<a data-remodal-action="close" class="remodal-close"></a>
  <form class="type_2" method="post" action="#" name="register<?=$i?>">
  <div>
    <h2 class="seeking">Forgot Password</h2>
  </div>
   <p style="font-size:16px; font-color:#ff0000 !important;">
  
   Password has been sent to your email address.
   

  </p>

  <div class="clear"></div>
  
  </form>
</div>

<div class="remodal" data-remodal-id="activate" role="dialog" style="max-width:550px !important;" aria-labelledby="modal1Title" aria-describedby="modal1Desc">
<a data-remodal-action="close" class="remodal-close"></a>
  <form class="type_2" method="post" action="#" name="register<?=$i?>">
  <div>
    <h2 class="seeking">Account activation</h2>
  </div>
   <p style="font-size:16px; font-color:#ff0000 !important;">
  
  You account has not been activated by admin. <br>
  
  Please contact administrator.
   
  </p>

  <div class="clear"></div>
  
  </form>
</div>


<?php include("script.php"); ?>
<?php get_footer();
