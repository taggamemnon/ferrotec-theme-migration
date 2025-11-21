<div class="container">
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
</div>
<?php
/*
    <nav id="site-navigation" class="main-navigation" aria-label="<?php esc_attr_e( 'Top Menu', 'twentynineteen' ); ?>">
      <?php
      wp_nav_menu(
        array(
          'theme_location' => 'primary',
          'menu_class'     => 'main-menu',
          'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
        )
      );
      ?>
    </nav><!-- #site-navigation -->
*/