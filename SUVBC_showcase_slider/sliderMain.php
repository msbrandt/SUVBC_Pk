<?php
/**
* @package   SUVBC Slider
* @author    Mike Brandt 
*
*Plugin Name: SUVBC Showcase slider plugin
*Description: Showcase slider on main screen 
*Version: v1.0
*Author: Mikey b
*Author URI: 
*/
if ( ! defined( 'WPINC' ) ) {
	die;
}

register_activation_hook( __FILE__, array( 'SUVBC_slider', 'activate' ) );
require_once( plugin_dir_path( __FILE__ ) . 'SUVBC_Slider_class.php' );


register_deactivation_hook( __FILE__, array( 'SUVBC_slider', 'deactivate' ) );
include( 'views/public.php' );


SUVBC_slider::get_instance();

// register_activation_hook( __FILE__, array( SUVBC_slider, 'SUVBC_roster_install' ) );

?>