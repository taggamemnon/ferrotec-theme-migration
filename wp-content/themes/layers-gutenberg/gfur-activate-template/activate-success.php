<?php

global $gw_activate_template;

extract( $gw_activate_template->result );

$url = is_multisite() ? get_blogaddress_by_id( (int) $blog_id ) : home_url('', 'http');
$user = new WP_User( (int) $user_id );
$goto = "";
if ( get_query_var('page_id') ){
	$goto= "?redirect_to=" . urlencode( get_the_permalink( get_query_var('page_id') ) ); 
}

?>

<h2><?php _e('Your account is now active!'); ?></h2>
<div id="signup-welcome">
    <p><span class="h3"><?php _e('Username:'); ?></span> <?php echo $user->user_login ?></p>
    <p><span class="h3"><?php _e('Password:'); ?></span> <strong><?php echo $password; ?></strong></p>
    <p>Please save your password and then log in</p>
</div>

<?php if ( $url != network_home_url('', 'http') ) : ?>
    <p class="view"><?php printf( __('Your account is now activated. Log in <a href="%2$s">here</a> or go back to the <a href="%1$s">homepage</a>.'), $url, $url . 'wp-login.php' ); ?></p>
<?php else: ?>
    <p class="view"><?php printf( __('Your account is now activated. Log in <a href="%1$s">here</a> or go back to the <a href="%2$s">homepage</a>.' ), network_site_url('wp-login.php', 'login') . $goto, home_url() ); ?></p>
<?php endif; ?>