<?php
/**
 * Roster Plugin
 *
 * @package   SUVBC mcm
 * @author    Mikey Brandt 
 * @license   GPL-2.0+
 */
/**
 * Plugin class.
 */
class SUVBC_mcm {
	
	/**
	 * Plugin version, used for cache-busting of style and script file references.
	 *
	 * @since   1.0.0
	 *
	 * @var     string
	 */
	protected $version = '1.0.0';

	/**
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_slug = 'SUVBC_mcm';

	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Slug of the plugin screen.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_screen_hook_suffix = null;

	/**
	 * Initialize the plugin by setting localization, filters, and administration functions.
	 *
	 * @since     1.0.0
	 */
	private function __construct() {

		// Load plugin text domain
		add_action( 'init', array( $this, 'load_mcm_plugin_textdomain' ) );
		add_action( 'admin_menu', array( $this, 'add_SUVBC_mcm_admin_menu' ) );



		// Add the options page and menu item.
		add_action( 'wp_enqueue_scripts', array( $this, 'activate_SUVBC_mcm_jquery' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_mcm_admin_scripts') );
		add_action( 'admin_enqueue_scripts', array( $this, 'suvbc_mcm_custom_media') );

		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_mcm_public_scripts' ) );


		// Load style sheet.
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_mcm_styles') );

		add_action( 'admin_init', array( $this, 'SUVBC_mcm_settings' ) );
		add_action( 'wp_ajax_mcm_slider_fet', array( $this, 'mcm_slider_fet_handler') );
		add_action( 'wp_ajax_mcm_slider_delete', array( $this, 'mcm_slider_delete_handler') );

		
		
	}
	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Fired when the plugin is activated.
	 *
	 * @since    1.0.0
	 *
	 * @param    boolean    $network_wide    True if WPMU superadmin uses "Network Activate" action, false if WPMU is disabled or plugin is activated on an individual blog.
	 */
	public static function activate() {
		include_once('views/public.php');
	}

	/**
	 * Fired when the plugin is deactivated.
	 *
	 * @since    1.0.0
	 *
	 * @param    boolean    $network_wide    True if WPMU superadmin uses "Network Deactivate" action, false if WPMU is disabled or plugin is deactivated on an individual blog.
	 */
	public static function deactivate( $network_wide ) {
		// Remove suvbc_featured_players table from db
		global $wpdb;
		$table_name = $wpdb->prefix . 'suvbc_featured_players';

		$wpdb->query("DROP TABLE IF EXISTS $table_name");



	}
	/**
	 * Fired when the plugin is deactivated.
	 *
	 * @since    1.0.0
	 *
	 * @param    boolean    $network_wide    True if WPMU superadmin uses "Network Deactivate" action, false if WPMU is disabled or plugin is deactivated on an individual blog.
	 */

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_mcm_plugin_textdomain() {

		$domain = $this->plugin_slug;
		$locale = apply_filters( 'plugin_locale', get_locale(), $domain );

		load_textdomain( $domain, WP_LANG_DIR . '/' . $domain . '/' . $domain . '-' . $locale . '.mo' );
		load_plugin_textdomain( $domain, FALSE, dirname( plugin_basename( __FILE__ ) ) . '/lang/' );
	}

	/**
	 * Register and enqueue admin-specific JavaScript.
	 *
	 * @since     1.0.0
	 *
	 * @return    null    Return early if no settings page is registered.
	 */

	public function enqueue_mcm_public_scripts() {
			wp_enqueue_script( $this->plugin_slug . '-public-script', plugins_url( 'js/public.js', __FILE__ ), array( 'jquery' ), $this->version );
			wp_localize_script( $this->plugin_slug . '-public-script', 'SUVBC_Rosters', array( 'ajaxurl' => admin_url('admin-ajax.php')  ) );
			
		}

	//include jQuery
	public function activate_SUVBC_mcm_jquery() {
		wp_enqueue_script( 'jquery' );
	}
	//include admin scrips
	public function enqueue_mcm_admin_scripts() {
			wp_enqueue_script( $this->plugin_slug . '-admin-script', plugins_url( 'js/admin.js', __FILE__ ), array( 'jquery' ), $this->version );
	}
	//include media libery from forms  
	public function suvbc_mcm_custom_media(){
		wp_enqueue_media();
		
	}
	//add menu button to dashboard panal  
	public function add_SUVBC_mcm_admin_menu(){
		add_menu_page(
			__( 'SUVBC Weekly Player'),
			__( 'SUVBC Weekly Player' ),
			'manage_options',
			$this->plugin_slug,
			array( $this, 'display_SUVBC_mcm_admin_page')
			);
	}
	//view for dashboard panal
	public function display_SUVBC_mcm_admin_page() {
		include_once( 'views/admin.php' );

	}


	/**
	 * Register and enqueue style sheet.
	 *
	 * @since    1.0.0
	 */

	public function enqueue_mcm_styles() {
		// wp_register_style( 'custom_wp_admin_css', get_template_directory_uri() . '/css/stylesss.css', false, '1.0.0' );
		// wp_enqueue_style( 'custom_wp_admin_css' );
		wp_enqueue_style( $this->plugin_slug . '-plugin-styles', plugins_url( 'css/mcm_styles.css', __FILE__ ), array(), $this->version );
	}
	
	/**
	 * Render the settings page for this plugin.
	 *
	 * @since    1.0.0
	 */
	

	public function SUVBC_mcm_settings() {
		register_setting( 'suvbc_mcm_group', 'mcm_set');
	}

	//install suvbc_featured_players table 
	public function mcm_table_install(){
		global $wpdb;

		$table_name = $wpdb->prefix . 'suvbc_featured_players';

		$sql = "CREATE TABLE " . $table_name . "(
			mcm_id MEDIUMINT NOT NULL AUTO_INCREMENT,
			mcm_image TINYTEXT NOT NULL,
			mcm_name TINYTEXT NOT NULL,
			mcm_dec TINYTEXT NOT NULL,
			PRIMARY KEY  mcm_id (mcm_id)
			);";
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
	}

	//insert new players to suvbc_featured_players table 
	public function mcm_slider_fet_handler(){
		global $wpdb;
		$table_name = $wpdb->prefix . 'suvbc_featured_players';
		
		$m_image = stripslashes( $_REQUEST['mcm_img'] );
		$m_name  = stripslashes( $_REQUEST['mcm_name'] );
		$m_decs  = stripslashes( $_REQUEST['mcm_dec'] );

		$wpdb->insert( 
			$table_name, 
			array(
				'mcm_id' => '',
				'mcm_image' => $m_image,
				'mcm_name' => $m_name,
				'mcm_dec' => $m_decs,
			),
			array(
				'%d',
				'%s',
				'%s',
				'%s'
				)
			);
		$getPlayers = $wpdb->get_results("SELECT * FROM " . $table_name . " ");

		foreach ($getPlayers as $k) {
			 $mcm_ID   = $k->mcm_id;
			 $mcm_NAME = $k->mcm_name;
		}		
		echo '<tr id="' . $mcm_ID . '"><td>' . $mcm_NAME . '</td></tr>';


		exit();
	}
	//delete players from suvbc_featured_players table
	public function mcm_slider_delete_handler(){
		global $wpdb;
		
		$table_name = $wpdb->prefix . 'suvbc_featured_players';

		$clicked_id = $_REQUEST['mcm_clicked'];
		
		$deleteQuery = $wpdb->get_results("SELECT * FROM " . $table_name . " WHERE mcm_id= ".$clicked_id." ");

		foreach ($deleteQuery as $nName) {
			$selectedID = $nName->mcm_id;
		}
		$wpdb->delete( $table_name, array( 'mcm_id' => $selectedID ) );
		
		exit();
	}

	


}
?>