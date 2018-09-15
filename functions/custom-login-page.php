<?php
// Customise WordPress login.php
function hgnm_login_css() { ?>
  <style type="text/css">
  body.login {
    background: #333;
  }
  body.login div#login h1 a {
    background-image: url(<?php echo get_bloginfo( 'template_directory' ) ?>/img/login-logo.png);
    background-size: 200px 75px;
    width: 200px;
  }
  body.login p#backtoblog, body.login p#nav {
    text-align: center;
  }
  </style>
  <link rel="shortcut icon" href="<?php echo home_url(); ?>/favico.ico"/>
  <?php }
add_action( 'login_enqueue_scripts', 'hgnm_login_css' );

// Use website URL for admin log-in logo link
function hgnm_url_login(){
  return home_url();
}
add_filter('login_headerurl', 'hgnm_url_login');

// Replace ‘Powered by WordPress’ logo alt text with site title
function hgnm_login_logo_title() {
  return get_bloginfo();
}
add_filter( 'login_headertitle', 'hgnm_login_logo_title' );
?>
