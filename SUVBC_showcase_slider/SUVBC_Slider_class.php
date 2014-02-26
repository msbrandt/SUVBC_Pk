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
class SUVBC_slider {
	
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
	protected $plugin_slug = 'SUVBC_Slider';

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
		add_action( 'init', array( $this, 'SUVBC_slider_post' ) );


		// Add the options page and menu item.
		add_action( 'wp_enqueue_scripts', array( $this, 'activate_SUVBC_slider_jquery' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_slider_public_scripts' ) );


		// Load style sheet.
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_slider_styles') );

		add_action( 'admin_init', array( $this, 'SUVBC_slider_settings' ) );
		
		
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

	public function enqueue_slider_public_scripts() {
			wp_enqueue_script( $this->plugin_slug . '-public-script', plugins_url( 'js/public.js', __FILE__ ), array( 'jquery' ), $this->version );
			wp_localize_script( $this->plugin_slug . '-public-script', 'SUVBC_Rosters', array( 'ajaxurl' => admin_url('admin-ajax.php')  ) );
			
		}

	
	public function activate_SUVBC_slider_jquery() {
		wp_enqueue_script( 'jquery' );
	}

	public function SUVBC_slider_post(){
		register_post_type( 'suvbc_img',
			array( 'labels' => 
				array(
					'name' => __('Showcase Slider')
			), 
			'public' => true,
			'menu_position' => 5,
			'rewrite' => array( 'slug' => 'suvbc_show_slider'),
			'has_archive' => true
			)
		);
	}


	/**
	 * Register and enqueue style sheet.
	 *
	 * @since    1.0.0
	 */

	public function enqueue_slider_styles() {
		// wp_register_style( 'custom_wp_admin_css', get_template_directory_uri() . '/css/stylesss.css', false, '1.0.0' );
		// wp_enqueue_style( 'custom_wp_admin_css' );
		wp_enqueue_style( $this->plugin_slug . '-plugin-styles', plugins_url( 'css/slider_styles.css', __FILE__ ), array(), $this->version );
	}
	
	/**
	 * Render the settings page for this plugin.
	 *
	 * @since    1.0.0
	 */
	

	public function SUVBC_slider_settings() {
		register_setting( 'suvbc_slider_group', 'slider_set');
	}

	


}
?>