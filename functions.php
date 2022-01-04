<?php
/**
 *	StoreVilla WordPress Theme
 *
 *	accesspressthemes.com
 *	http://accesspressthemes.com/theme-demos/?theme=storevilla
 *  @package Store_Villa
 */
namespace Core;

// Useful global constants

define( 'CORE_URL', get_stylesheet_directory_uri() );
define( 'CORE_TEMPLATE_URL', get_template_directory_uri() . '-child' ); 
define( 'CORE_PATH', dirname( __FILE__ ). '/' ); 
define( 'CORE_INC', CORE_PATH . 'includes/' );
define( 'CORE_PLUGINS_PATH', plugins_url() );
define( 'CORE_WIDGET', CORE_INC . 'widgets/' );
define( 'CORE_SHORTCODE', CORE_INC . 'shortcodes/' );
define( 'CORE_VENDOR', CORE_PATH . 'vendor/' );
define( 'MAILCHIMP_API_KEY', '964bd85c38d43a5e0a32bf48b87e3619-us4' );

//require_once CORE_INC . 'images.php';
//require_once CORE_INC . 'woocommerce.php';
require_once CORE_INC . 'sidebars.php';

//require_once CORE_INC . 'siteorigin.php';
//require_once CORE_INC . 'enqueue.php';
require_once CORE_INC . 'custom-posts.php';
require_once CORE_INC . 'creators.php';
require_once CORE_INC . 'post2post.php';
require_once CORE_INC . 'wcextension.php';
//require_once CORE_INC . 'calendar-functions.php';
//require_once CORE_INC . 'widgets.php';
//require_once CORE_INC . 'hooks.php';
require_once CORE_INC . 'shortcodes.php';

if( isset( $_GET['nobar'] ) )
{
	?>
	<style>
		#wpadminbar { display: none; }
	</style>
	<?php 
}

add_action( 'wp_enqueue_scripts', '\Core\storevilla_spp_enqueue_styles' );
function storevilla_spp_enqueue_styles() 
{	
	wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
    wp_enqueue_style( 'child-style', CORE_TEMPLATE_URL . '/style.css' ); 
} 

add_action( 'wp_enqueue_scripts', '\Core\storevilla_spp_enqueue_scripts', 999 );
function storevilla_spp_enqueue_scripts()
{	
	wp_register_script( 'sppress_js',  CORE_TEMPLATE_URL . '/js/sppress.js', array('jquery') );
    wp_enqueue_script( 'sppress_js' );
}