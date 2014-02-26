<?php
/**
 * Roster Plugin
 *
 * @package   SUVBC roster
 * @author    Mikey Brandt 
 * @license   GPL-2.0+
 */
/**
 * Plugin class.
 */
class SUVBC_ROSTER {
	
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
	protected $plugin_slug = 'SUVBC_Rosters';

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
		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );

		// Add the options page and menu item.
		add_action( 'admin_menu', array( $this, 'add_SUVBC_Roster_admin_menu' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'activate_SUVBC_roster_jquery' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_public_scripts' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'suvbc_custom_media') );

		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scriptsZ') );

		// Load style sheet.
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_stylesX') );

		add_action( 'admin_init', array( $this, 'SUVBC_settings' ) );
		add_action( 'wp_ajax_suvbc_save_player', array( $this, 'suvbc_save_player_handler') );
		add_action( 'wp_ajax_suvbc_edit_player', array( $this, 'suvbc_edit_player_handler') );
		add_action( 'wp_ajax_suvbc_delete_player', array( $this, 'suvbc_delete_player_handler') );
		// add_action( 'wp_head', array( $this, 'suvbc_public_select_handler') );
		// add_action( 'wp_ajax_suvbc_public_select', array( $this, 'suvbc_public_select_handler') );
		// add_action( 'wp_ajax_nopriv_suvbc_public_select', array( $this, 'suvbc_public_select_handler') );
		
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
		// TODO: Define activation functionality here
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
		// TODO: Define deactivation functionality here
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
	public function load_plugin_textdomain() {

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
	public function enqueue_admin_scriptsZ() {
			wp_enqueue_script( $this->plugin_slug . '-admin-script', plugins_url( 'js/admin.js', __FILE__ ), array( 'jquery' ), $this->version );
		}
	public function enqueue_public_scripts() {
			wp_enqueue_script( $this->plugin_slug . '-public-script', plugins_url( 'js/public.js', __FILE__ ), array( 'jquery' ), $this->version );
			wp_localize_script( $this->plugin_slug . '-public-script', 'SUVBC_Rosters', array( 'ajaxurl' => admin_url('admin-ajax.php')  ) );
			
		}

	
	public function activate_SUVBC_roster_jquery() {
		wp_enqueue_script( 'jquery' );
	}

	public function suvbc_custom_media() {
		wp_enqueue_media();

	}


	/**
	 * Register and enqueue style sheet.
	 *
	 * @since    1.0.0
	 */

	public function enqueue_stylesX() {
		// wp_register_style( 'custom_wp_admin_css', get_template_directory_uri() . '/css/stylesss.css', false, '1.0.0' );
		// wp_enqueue_style( 'custom_wp_admin_css' );
		wp_enqueue_style( $this->plugin_slug . '-plugin-styles', plugins_url( 'css/stylesss.css', __FILE__ ), array(), $this->version );
	}
	


	/**
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 *
	 * @since    1.0.0
	 */
	
	public function add_SUVBC_Roster_admin_menu() {
		add_menu_page(
			__( 'SUVBC Roster'),
			__( 'SUVBC Roster' ),
			'manage_options',
			$this->plugin_slug,
			array( $this, 'display_SUVBC_admin_page')
			);

	}
	


	/**
	 * Render the settings page for this plugin.
	 *
	 * @since    1.0.0
	 */
	
	public function display_SUVBC_admin_page() {
		include_once( 'views/admin.php' );

	}

	public function SUVBC_settings() {
		register_setting( 'suvbc_rotster_group', 'roster_set');
	}

	public function SUVBC_roster_install(){
		global $wpdb;

		$table_name = $wpdb->prefix . 'suvbc_Roster';
		
		$sql = "CREATE TABLE " . $table_name . "(
			player_id MEDIUMINT NOT NULL AUTO_INCREMENT,
			player_number int(3) NOT NULL,
			player_name tinytext NOT NULL,
			player_position varchar(2) NOT NULL,
			player_year varchar(2) NOT NULL,
			player_hometown tinytext NOT NULL,
			player_img tinytext NOT NULL,
			player_bio tinytext NOT NULL,
			PRIMARY KEY  player_id (player_id)
			);";
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
	}

	public function suvbc_save_player_handler(){
		global $wpdb;

		$table_name = $wpdb->prefix . 'suvbc_Roster';
			$f_num = strip_tags($_REQUEST['form_num']);
			$f_name = strip_tags($_REQUEST['form_name']);
			$f_pos = strip_tags($_REQUEST['form_pos']);
			$f_class = strip_tags($_REQUEST['form_class']);
			$f_ht = strip_tags($_REQUEST['form_ht']);
			$f_img = strip_tags($_REQUEST['form_img']);
			$f_bio = strip_tags($_REQUEST['form_bio']);
	

		$wpdb->insert(
			$table_name,
			array(
				'player_id' => '',
				'player_number' => $f_num, 
				'player_name' => $f_name, 
				'player_position' => $f_pos, 
				'player_year' => $f_class, 
				'player_hometown' => $f_ht, 
				'player_img' => $f_img, 
				'player_bio' => $f_bio, 
				),
			array(
				'%d',
				'%d',
				'%s',
				'%s',
				'%s',
				'%s',
				'%s',
				'%s'
				)
			);
		
		$idQuery = $wpdb->get_results("SELECT player_id FROM " . $table_name . " WHERE player_name = '".$f_name."'");

		foreach( $idQuery as $g){
			$p_ID = $g->player_id;
		}

		echo '<tr class="player_suvbc" id="'.$f_num.'">';
		echo '<td>'.$f_num.'</td>';
		echo '<td>'.$f_name.'</td>';
		echo '<td>'.$f_pos.'</td>';
		echo '<td>'.$f_class.'</td>';
		echo '<td>'.$f_ht.'</td>';
		echo '<td class="not_there">'.$f_img.'</td>';
		echo '<td class="not_there">'.$f_bio.'</td>';
		echo '<td class="eqid">'.$p_ID.'</td>';

		echo '</tr>';

		exit();
	}

	public function suvbc_edit_player_handler(){
		global $wpdb;
		$table_name = $wpdb->prefix . 'suvbc_Roster';

		$player_ID = stripcslashes($_REQUEST['pl_ID']);
		// echo $player_ID;

		//Data from user input 
		$playerInfo = array(
			'player_number' => stripcslashes($_REQUEST['plyNum']),
			'player_name' => stripcslashes($_REQUEST['plyName']),
			'player_position' => stripcslashes($_REQUEST['plyPos']),
			'player_year' => stripcslashes($_REQUEST['plyClass']),
			'player_hometown' => stripcslashes($_REQUEST['plyHt']),
			'player_img' => stripcslashes($_REQUEST['plyImg']),
			'player_bio' => stripcslashes($_REQUEST['plyBio'])
		);



		$editQuery = $wpdb->get_results("SELECT * FROM " . $table_name . " WHERE player_id = '".$player_ID."'");

		foreach ($editQuery as $k) {
			$pID   = $k->player_id;
			$nNum  = $k->player_number;
			$nName = $k->player_name;
			$nPos  = $k->player_position;
			$nYear = $k->player_year;
			$nHt   = $k->player_hometown;
			$nImg  = $k->player_img;
			$nBio  = $k->player_bio;
		}
		//Data from MY SQL query
		$neweditArray = array(
			'player_number' => $nNum,
			'player_name' => $nName,
			'player_position' => $nPos,
			'player_year' => $nYear,
			'player_hometown' => $nHt,
			'player_img' => $nImg,
			'player_bio' => $nBio 
			);
		
		$results = array_diff_assoc( $playerInfo, $neweditArray );

		// print_r($neweditArray );
		// print_r( $playerInfo );
		
		if ( !$results ){
			echo 'Nothing has changed. Try again later';
		} else {
			$wpdb->update( $table_name, $results, array( 'player_id' => $pID) );
			echo $nName . ' has been updated';

		}
		// for( $w=0;)

		// print_r( $results );

		unset($results);
		unset($neweditArray);
		unset( $playerInfo );

		exit();

	}
	public function suvbc_delete_player_handler(){
		global $wpdb;

		$table_name = $wpdb->prefix . 'suvbc_Roster';

		$deleteID = strip_tags($_REQUEST['deleteID']);

		$deleteQuery = $wpdb->get_results("SELECT * FROM " . $table_name . " WHERE player_id = ".$deleteID." ");
		
		foreach ( $deleteQuery as $y ) {
			$useID = $y->player_id;
			$name = $y->player_name;
			$useNumber = $y->player_number;

		}

		$wpdb->delete( $table_name, array( 'player_id' => $useID) );
		echo $useNumber;
		exit();
	}


}
?>