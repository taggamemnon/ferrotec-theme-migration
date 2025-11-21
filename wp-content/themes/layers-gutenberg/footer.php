<?php
         /**
          * The template for displaying the footer.
          *
          * Contains the closing of the #content div and all content after
          *
          * @package Hillstone
          */
         ?>
      <div class="container-wrapper footer">
         <div class="container">
            <div class="row bottom-rule">
               <div class="col-xs-12 col-sm-4">
                  <h2>Ferrotec USA</h2>
               </div>
               <div class="col-xs-12 col-sm-8">
                  <div class="search_wrapper">
                     <form role="search" method="get" id="searchform" class="searchform" action="<?php echo get_home_url(); ?>">
                        <div>
                           <label class="screen-reader-text" for="s">Search for:</label>
                           <input type="text" value="" name="s" id="s" >
                           <button type="submit" id="searchsubmit" class="icon-search btn btn-default btn-sm"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-sm-2">
                  <h3>COMPANY</h3>
                  <p><a href="https://www.ferrotec.com/about/">Overview</a></p>
                  <p><a href="https://www.ferrotec.com/investors/">Investor Information</a></p>
                  <p><a href="https://www.ferrotec.com/careers/">Working at Ferrotec Locations</a></p>
                  <p><a href="https://www.ferrotec.com/sales-offices/">Sales Offices</a></p>
               </div>
               <div class="col-sm-2">
                  <h3>PRODUCTS</h3>
                  <p><a href="https://seals.ferrotec.com/">Ferrofluidic Seal Solutions</a></p>
                  <p><a href="https://thermal.ferrotec.com/">Thermal Solutions</a></p>
                  <p><a href="https://e-beam.ferrotec.com/">E-Beam Components Solutions</a></p>
                  <p><a href="https://temescal.ferrotec.com/">Temescal Systems</a></p>
                  <p><a href="https://meivac.ferrotec.com/">MeiVac Components</a></p>
                  <p><a href="https://meivac.ferrotec.com/">MeiVac Systems</a></p>
               </div>
               <div class="col-sm-2">
                  <h3 class="hidden-xs">&nbsp;</h3>
                  <p><a href="https://ceramics.ferrotec.com/">Advanced Ceramics</a></p>
                  <p><a href="https://ceramics.ferrotec.com/">Machinable Ceramics</a></p>
                  <p><a href="https://ferrofluid.ferrotec.com/">Ferrofluid</a></p>
                  <p><a href="https://quartz.ferrotec.com/">Fabricated Quartz</a></p>
                  <p><a href="https://www.ferrotec.com/products-technologies/cvd_sic/">CVD-SiC Parts</a></p>
                  <p><a href="https://www.ferrotec.com/products-technologies/contract-manufacturing/">Contract Manufacturing</a></p>
               </div>
               <div class="col-sm-3">
                  <h3>MARKETS</h3>
                  <p><a href="https://www.ferrotec.com/markets/">Semiconductor Manufacturing</a></p>
                  <p><a href="https://www.ferrotec.com/markets/">Electronic Devices</a></p>
                  <p><a href="https://www.ferrotec.com/markets/">Automotive</a></p>
                  <p><a href="https://www.ferrotec.com/markets/">Bio-medical Applications and Industries</a></p>
                  <p><a href="https://www.ferrotec.com/markets/">Opto-electronics, Laser, and Infrared Applications</a></p>
               </div>
               <div class="col-sm-2">
                  <h3>NEWS & EVENTS</h3>
                  <p><a href="https://www.ferrotec.com/company/news">Press Releases</a></p>
               </div>
            </div>
      <div class="row">
         <div class="col-sm-12 mt-3">
            <p>All contents &copy; 2001-<?php echo date("Y") ?> Copyright Ferrotec (USA) Corporation.</p>
            <p>All rights reserved.&nbsp;&nbsp;<a href="https://www.ferrotec.com/legal/" class="legal-link">Legal Information</a>  <a href="#" onclick="window.displayPreferenceModal();return false;" id="termly-consent-preferences">Consent Preferences</a>
</p>
         </div>
      </div>
         </div>
      </div>
      </div>
      <?php wp_footer(); ?>
 <iframe
   src="https://www.ferrotec.com/termly-consent-sync.html"
   style="display: none"
 ></iframe>
<!-- Google Code for Remarketing Tag -->
<!--------------------------------------------------
Remarketing tags may not be associated with personally identifiable information or placed on pages related to sensitive categories. See more information and instructions on how to setup the tag on: https://google.com/ads/remarketingsetup
--------------------------------------------------->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 1066189208;
var google_custom_params = window.google_tag_params;
var google_remarketing_only = true;
/* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/1066189208/?guid=ON&amp;script=0"/>
</div>
</noscript>
<script type="text/javascript">
function setCookie(name, value, days){
    var date = new Date();
    date.setTime(date.getTime() + (days*24*60*60*1000)); 
    var expires = "; expires=" + date.toGMTString();
    document.cookie = name + "=" + value + expires+";domain=ferrotec.com;path=/"
}
function getParam(p){
    var match = RegExp('[?&]' + p + '=([^&]*)').exec(window.location.search);
    return match && decodeURIComponent(match[1].replace(/\+/g, ' '));
}
var gclid = getParam('gclid');
if(gclid){
    var gclsrc = getParam('gclsrc');
    if(!gclsrc || gclsrc.indexOf('aw') !== -1){
        setCookie('gclid', gclid, 90);
    }
}
</script>
</body>
</html>