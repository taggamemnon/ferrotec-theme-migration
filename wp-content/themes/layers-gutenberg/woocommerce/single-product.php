<?php
/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see      https://docs.woocommerce.com/document/template-structure/
 * @author     WooThemes
 * @package    WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
   exit; // Exit if accessed directly
}
$site_id = get_current_blog_id();
if ($site_id == 2) : ?>
<?php global $vfp_data;
   session_start();
   ?>

  <?php      get_header('vfproduct');  ?>
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
    $reply = "noreply@ferrotec.com";
           
        //$headers = 'From: '.$_POST['email'].'\r\n'.'X-Mailer: PHP/' . phpversion();
      $headers  = "From: FERROTEC <".strip_tags($reply).">\r\n";
      $headers .= "Reply-To: ".strip_tags($reply). "\r\n";
      $headers .= "MIME-Version: 1.0\r\n";
      $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
          // $headers.= "Content-Type: text/html; charset=ISO-8859-1\r\n";
    
   
    $html = utf8_decode($html);
       wp_mail($to, $subject, $html);
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
      wp_mail($to, $subject, $html, $headers);
   
      if(!$competitor){
          $to_cust = $email;        
          $html_cust  = "<table border=0 cellpadding=0 cellspacing=0 width=100% align=center bgcolor=#f6f5f1><tr><td align=center><table border=0 cellpadding=0 cellspacing=0 width=668 align=center bgcolor=#f6f5f1><tr><td align=left width=650 bgcolor=#ffffff><table border=0 cellpadding=0 cellspacing=0 width=668><tr><td><tr><td align=center width=668></table><table border=0 cellpadding=0 cellspacing=0 width=570 align=center bgcolor=#ffffff style=font-size:13px;color:#852927;font-family:arial><tr><td colspan=3 height=10 align=left><b>Ferrotec - Account Activation</b><tr><td colspan=3 height=10><tr><td colspan=3><hr><tr><td colspan=3 height=10><tr><td colspan=3>Hi ".$firstName." ".$lastName.",<tr><td colspan=3 height=15><tr><td colspan=3>Your account has been activated on Ferrotec.<br><br>Now you can login the site.<br><br>Please find below your account login Info :<tr><td colspan=3 height=15><tr><td align=left width=100>Login URL<td width=20>:<td align=left><a href=http://seals.ferrotec.com/products/ferrofluidic-vacuum-rotary-feedthroughs/ target=blank>Click Here</a><br><br>Navigate to any of the Standard Feedthroughs to download a DXF or STP file.<tr><td colspan=3 height=15><tr><td align=left width=100>Username<td width=20>:<td align=left>".$email."<tr><td colspan=3 height=15><tr><td align=left>Password<td>:<td align=left>".$password."<tr><td colspan=3 height=10><tr><td></table></table></table>";
          $subject_cust="Ferrotec Feedthrough Resources Account Activation";
          $headers_cust  = "From: Ferrotec Account Activation <".strip_tags($reply).">\r\n";
          $headers_cust .= "Reply-To: ".strip_tags($reply). "\r\n";
          $headers_cust .= "MIME-Version: 1.0\r\n";
          $headers_cust .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
          $html_cust = utf8_decode($html_cust);
          wp_mail($to_cust, $subject_cust, $html_cust, $headers_cust);      
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
<?php if ( have_posts() ) : ?>
 <?php while ( have_posts() ) : the_post(); ?>
  <?php get_template_part('template-parts/content','vfproducts'); ?>
  <?php endwhile; // end of the loop. ?>
<?php endif; ?>
<?php //get_template_part('script'); ?>
<?php get_footer('vfproduct');
else : ?>
<?php get_header( 'shop' ); ?>

   <?php
      /**
       * woocommerce_before_main_content hook.
       *
       * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
       * @hooked woocommerce_breadcrumb - 20
       */
      do_action( 'woocommerce_before_main_content' );
   ?>

      <?php while ( have_posts() ) : the_post(); ?>

         <?php wc_get_template_part( 'content', 'single-product' ); ?>
      <?php endwhile; // end of the loop. ?>

   <?php
      /**
       * woocommerce_after_main_content hook.
       *
       * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
       */
      do_action( 'woocommerce_after_main_content' );
   ?>

   <?php
      /**
       * woocommerce_sidebar hook.
       *
       * @hooked woocommerce_get_sidebar - 10
       */
      do_action( 'woocommerce_sidebar' );
   ?>

<?php get_footer( 'shop' );

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
 endif;
