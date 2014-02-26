<?php
/**
* @package   Spider Gallery
* @author    Mike Brandt 
* @license   GPL-2.0+
*
*Plugin Name: SUVBC Roster plugin
*Description: Add and remove players to players section of page 
*Version: v1.0
*Author: Mikey b
*Author URI: 
*/
if ( ! defined( 'WPINC' ) ) {
	die;
}

register_activation_hook( __FILE__, array( 'SUVBC_ROSTER', 'activate' ) );
require_once( plugin_dir_path( __FILE__ ) . 'SUVBC_Roster_class.php' );


register_deactivation_hook( __FILE__, array( 'SUVBC_ROSTER', 'deactivate' ) );
include( 'views/public.php' );


SUVBC_ROSTER::get_instance();

register_activation_hook( __FILE__, array( SUVBC_ROSTER, 'SUVBC_roster_install' ) );

?>