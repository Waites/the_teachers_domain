<?php 

// include_once( get_template_directory() . '/lib/init.php' );

require_once(TEMPLATEPATH.'/lib/init.php');
// Add the helper functions.
include_once( get_stylesheet_directory() . '/lib/breadcrumbs.php' );
include_once( get_stylesheet_directory() . '/lib/helper-functions.php' );
include_once( get_stylesheet_directory() . '/lib/sidebar.php' );

// Child theme (do not remove).
define( 'CHILD_THEME_NAME', 'Educator' );
define( 'CHILD_THEME_URL', 'http://www.safyyrephrogg.com/' );
define( 'CHILD_THEME_VERSION', '1.0.0' );

add_action('genesis_site_title', 'ed_custom_image');
add_action( 'wp_enqueue_scripts', 'genesis_sample_enqueue_scripts_styles' );

remove_action( 'genesis_sidebar', 'genesis_do_sidebar' );

add_action('genesis_before_content', 'ed_home_slider', 5);


add_action('genesis_before_content_sidebar_wrap', 'ed_sidebar');


 ?>