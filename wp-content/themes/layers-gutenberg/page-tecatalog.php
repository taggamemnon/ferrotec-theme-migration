<?php
/*
   Template Name: Thermoelectric Catalog Page
   */
get_header(); 
require_once('includes/ferrotec_products.php');
$results = new fProducts;
$vfp_id = get_query_var( 'id', 'not found' ); 

  $pline_set_data = $results->get_ferrofluid_data( $vfp_id );
/* this template not in use currently look in functions for thermal shortcode */