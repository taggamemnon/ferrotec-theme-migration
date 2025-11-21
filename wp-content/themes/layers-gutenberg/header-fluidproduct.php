<?php
   /**
    * The header for our theme.
    *
    * Displays all of the <head> section and everything up till <div id="content">
    *
    * @package Ferrotec
    */
      global $vfp_data;
      remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
      remove_action( 'wp_head', 'rel_canonical',10,0 );
      remove_action( 'template_redirect','wp_shortlink_header',11,0 );
      remove_action( 'wp_head','wlwmanifest_link');

   ?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
   <head>
<script data-termly-config>
   window.TERMLY_CUSTOM_BLOCKING_MAP = {
      "www.ferrotec.com": "essential"
   }
</script>
<script type="text/javascript" src="https://app.termly.io/resource-blocker/12418560-14af-4db4-bfce-b381fea3c99a?autoBlock=on&masterConsentsOrigin=https://www.ferrotec.com"> </script>
      <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;1,100;1,300;1,400;1,500&display=swap" rel="stylesheet">
      <!--script src="https://kit.fontawesome.com/8ba2395e94.js" crossorigin="anonymous"></script-->
<?php remove_theme_support( 'title-tag' ); ?>
<?php 
$page_title = "";
foreach ($vfp_data as $product ): ?>
<?php 
  switch ($product->seriesID) {
    case 1:
      $page_title .= $product->seriesTitle .' Audio Ferrofluid | Type: '. $product->model;
      $canonical_url="https://ferrofluid.ferrotec.com/products/ferrofluid-audio/apg-2100-series/".makeurls($product->model);
      break;
    case 2:
      $page_title .= $product->seriesTitle .' Audio Ferrofluid | Type: '. $product->model;
      $canonical_url="https://ferrofluid.ferrotec.com/products/ferrofluid-audio/apg-300-series/".makeurls($product->model);
      break;
    case 3:
      $page_title .= $product->seriesTitle .' Audio Ferrofluid | Type: '. $product->model;
      $canonical_url="https://ferrofluid.ferrotec.com/products/ferrofluid-audio/apg-800-series/".makeurls($product->model);
      break;
    case 5:
      $page_title .= $product->seriesTitle .' Audio Ferrofluid | Type: '. $product->model;
      $canonical_url="https://ferrofluid.ferrotec.com/products/ferrofluid-audio/apg-e/".makeurls($product->model);
      break;
    case 7:
      $page_title .= $product->seriesTitle .' Audio Ferrofluid | Type: '. $product->model;
      $canonical_url="https://ferrofluid.ferrotec.com/products/ferrofluid-audio/apg-l/".makeurls($product->model);
      break;
    case 8:
      $page_title .= $product->seriesTitle .' Audio Ferrofluid | Type: '. $product->model;
      $canonical_url="https://ferrofluid.ferrotec.com/products/ferrofluid-audio/apg-o/".makeurls($product->model);
      break;
    case 9:
      $page_title .= $product->seriesTitle .' Audio Ferrofluid | Type: '. $product->model;
      $canonical_url="https://ferrofluid.ferrotec.com/products/ferrofluid-audio/apg-s/".makeurls($product->model);
      break;
    case 10:
      $page_title .= $product->seriesTitle .' Audio Ferrofluid | Type: '. $product->model;
      $canonical_url="https://ferrofluid.ferrotec.com/products/ferrofluid-audio/apg-1100-series/".makeurls($product->model);
      break;
    case 11:
      $page_title .= $product->seriesTitle .' Audio Ferrofluid | Type: '. $product->model;
      $canonical_url="https://ferrofluid.ferrotec.com/products/ferrofluid-audio/apg-cd/".makeurls($product->model);
      break;
    case 12:
      $page_title .= $product->seriesTitle .' Audio Ferrofluid | Type: '. $product->model;
      $canonical_url="https://ferrofluid.ferrotec.com/products/ferrofluid-audio/apg-w/".makeurls($product->model);
      break;

    case 13:
      $page_title .= $product->seriesTitle .' Ferrofluid | Type: '. $product->model;
      $canonical_url="https://ferrofluid.ferrotec.com/products/ferrofluid-emg/water/".makeurls($product->model);
      break;
    case 14:
      $page_title .= $product->seriesTitle .' Ferrofluid | Type: '. $product->model;
      $canonical_url="https://ferrofluid.ferrotec.com/products/ferrofluid-emg/oil/".makeurls($product->model);
      break;
    case 15:
      $page_title .= $product->seriesTitle .' | Type: '. $product->model;
      $canonical_url="https://ferrofluid.ferrotec.com/products/ferrofluid-emg/powder/".makeurls($product->model);
      break;
    case 16:
      $page_title .= $product->seriesTitle .' Educational Ferrofluid | Type: '. $product->model;
      $canonical_url="https://ferrofluid.ferrotec.com/products/ferrofluid-educational-fluid/efh/".makeurls($product->model);
      break;
    default:
      $page_title .= $product->seriesTitle .' Audio Ferrofluid | Type: '. $product->model;
      break;
  }
  ?>
<?php endforeach ?>
<?php if (!current_theme_supports('title-tag')) : ?>
  <title><?php echo $page_title ?></title>
<?php endif ?>
      <?php wp_head(); ?>
      <meta charset="<?php bloginfo('charset'); ?>">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <?php if ($canonical_url) {
        echo '<link rel="canonical" href="' . $canonical_url . '/">';

      }else{
        echo '<link rel="canonical" href="' . get_the_permalink() . '">';

      }?>
      <META NAME="robots" CONTENT="INDEX, FOLLOW">
      <link rel="profile" href="http://gmpg.org/xfn/11">
      <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
      <link rel="icon" type="image/x-icon" href="<?php echo get_stylesheet_directory_uri() ?>/favicon.ico"/>
   <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
 		<script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

		  ga('create', 'UA-361875-1', 'auto');
		  ga('send', 'pageview');

		</script>

<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-VSHYGNJ605"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-VSHYGNJ605');
</script>
   </head>
   <body <?php body_class(); ?>>
      <div id="page" class="hfeed site">
      <a class="skip-link screen-reader-text" href="#content"><?php _e('Skip to content', 'hillstone'); ?></a>
      <!-- #masthead -->
      <header class="masthead float-panel" data-top="0" data-scroll="150" style="animation-direction: normal; animation-duration: 0.3s;">
        <?php get_template_part('template', 'masthead'); ?>
      </header>