<?php
/**
* @package   SUVBC mcm
* @author    Mike Brandt 
* @license   GPL-2.0+
*
*Plugin Name: SUVBC mcm
*Description: featured 
*Version: v1.0
*Author: Mikey b
*Author URI: 
*/
if ( ! defined( 'WPINC' ) ) {
	die;
}

register_activation_hook( __FILE__, array( 'SUVBC_mcm', 'activate' ) );
require_once( plugin_dir_path( __FILE__ ) . 'SUVBC_mcm_class.php' );


register_deactivation_hook( __FILE__, array( 'SUVBC_mcm', 'deactivate' ) );
include( 'views/public.php' );


SUVBC_mcm::get_instance();
register_activation_hook( __FILE__, array( SUVBC_mcm, 'mcm_table_install' ) );



?>