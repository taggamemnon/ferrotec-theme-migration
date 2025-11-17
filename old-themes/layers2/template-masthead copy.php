        <nav class="navbar nav-bkg">
          <div class="container-xx">
            <!--div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed navbar-open">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="/"><img src="/wp-content/uploads/logo_ferrotec.png"></a>
            </div-->
            <div class="nav-mobile-slide"><!-- this is the mobile nav -->
              <div class="navbar-collapse" id="mobile-nav">
                <div class="visible-xs menu-head mobile-head-<?php echo sanitize_title_with_dashes(get_bloginfo()); ?>">
                  <a class="navbar-close" href="#" type="button">
                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a><div class="text-center"><?php echo get_bloginfo(); ?></div>
                </div>
              <?php
                wp_nav_menu(
                 array( 
                   'container' => false, 
                   'menu_class'    => 'nav navbar-nav navbar-right site-navigation', 
                   'theme_location'  => 'primary',
                   /*'theme_location'  => 'mobile_menu',*/
                   /*'walker' => new head_walker_nav_menu*/
                   'walker' => new walker_mobile_nav_menu
                 )
                );
              ?>
<ul class="nav navbar-nav">
  <?php
if ( is_user_logged_in() ) { // If logged in:
  echo "<li class='nav-logout'>";
    wp_loginout( get_the_permalink() ); // Display "Log Out" link.
  echo "</li>";

}
?>                

               <li class="dropdown open">
                  <a href="#" id="mobile-sites-nav" class="dropdown-toggle bkg-lr-penny2" data-toggle="dropdown" role="button"><div class="inner">Select a solution… <span class="caret"></span></div></a> 
                  <ul class="dropdown-menu" aria-labelledby="mobile-sites-nav">
                     <li><a class="" href="<?php echo get_site_url(1); ?>">Corporate!</a>   </li>
                     <li><a class="" href="<?php echo get_site_url(3); ?>">Ferrofluid</a>   </li>
                     <li><a class="" href="<?php echo get_site_url(2); ?>">Ferrofluidic Seals</a>   </li>
                     <li><a class="" href="<?php echo get_site_url(4); ?>">Thermoelectric</a>   </li>
                     <li><a class="" href="<?php echo get_site_url(5); ?>">Fabricated Quartz</a>   </li>
                     <li><a class="" href="<?php echo get_site_url(6); ?>">Advanced Ceramics</a>   </li>
                     <li><a class="" href="<?php echo get_site_url(7); ?>">E-Beam Components</a>   </li>
                     <li><a class="" href="<?php echo get_site_url(8); ?>">SiFusion</a>   </li>
                     <li><a class="" href="<?php echo get_site_url(9); ?>">Temescal Systems</a>   </li>
                  </ul>
               </li>
            </ul>
                          </div><!-- /.navbar-collapse -->
            </div><!-- /end mobile nagigation -->
            <div id="primary-nav" class="hidden-xs">
              <?php
                wp_nav_menu(
                 array( 
                   'container' => false, 
                   'menu_class'    => 'nav navbar-nav navbar-right site-navigation', 
                   'theme_location'  => 'primary',
                   //'walker' => new head_walker_nav_menu
                 )
                );
              ?>
              <ul class="nav navbar-right" id="site-nav">
<?php if ( is_user_logged_in() ) : ?>
  <li class='nav-logout'>
    <?php wp_loginout( get_the_permalink() ); // Display "Log Out" link. ?>
  </li>
  <li><a href="/change-password/">Change Password</a></li>

<?php endif ?>                
                          <li role="presentation" class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                              sites <span class="caret"></span>
                            </a>
                  <ul class="dropdown-menu">
                     <li><a class="" href="<?php echo get_site_url(1); ?>">Corporate</a>   </li>
                     <li><a class="" href="<?php echo get_site_url(3); ?>">Ferrofluid</a>   </li>
                     <li><a class="" href="<?php echo get_site_url(2); ?>">Ferrofluidic Seals</a>   </li>
                     <li><a class="" href="<?php echo get_site_url(4); ?>">Thermoelectric</a>   </li>
                     <li><a class="" href="<?php echo get_site_url(5); ?>">Fabricated Quartz</a>   </li>
                     <li><a class="" href="<?php echo get_site_url(6); ?>">Advanced Ceramics</a>   </li>
                     <li><a class="" href="<?php echo get_site_url(7); ?>">E-Beam Components</a>   </li>
                     <li><a class="" href="<?php echo get_site_url(8); ?>">SiFusion</a>   </li>
                     <li><a class="" href="<?php echo get_site_url(9); ?>">Temescal Systems</a>   </li>
                  </ul>
                </li>
              </ul>
              </div><!-- /#primary-nav -->
          </div><!-- /.container-fluid -->
        </nav>
