<?php
/**
 * The admin page class
 *
 * @package TrackYourWriting
 */

namespace TrackYourWriting;

/**
 * Class Admin
 *
 * @package TrackYourWriting
 */
class Admin {

	/**
	 * Instance of the plugin.
	 *
	 * @var object
	 */
	public $plugin;

	/**
	 * Track Your Writing slug.
	 *
	 * @var string
	 */
	const SLUG = 'track-your-writing';

	/**
	 * The nonce name.
	 *
	 * @var string
	 */
	const NONCE_NAME = 'track-you-writing-user-nonce';

	/**
	 * The nonce action
	 *
	 * @var string
	 */
	const NONCE_ACTION = 'track-your-writing-update';

	/**
	 * Instantiate this class.
	 *
	 * @param object $plugin Instance of the plugin.
	 */
	public function __construct( $plugin ) {
		$this->plugin = $plugin;
	}

	/**
	 * Admin initializer.
	 */
	public function init() {
		add_action( 'admin_menu', array( $this, 'admin_menus' ) );
		add_action( 'admin_post_track-your-writing-update', array( $this, 'save' ) );
		add_action( 'admin_head', array( $this, 'add_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'add_scripts' ) );
		add_action( 'init', array( $this, 'textdomain' ) );
	}

	/**
	 * Creates the admin menus for the plugin.
	 */
	public function admin_menus() {
		add_menu_page(
			__( 'Track your writing', 'track-your-writing' ),
			__( 'Track your writing', 'track-your-writing' ),
			'manage_options',
			'wp-trackyw',
			array( $this, 'render_admin_page' )
		);
	}

	/**
	 * Loads the plugin textdomain, enables plugin translation.
	 */
	public function textdomain() {
		load_plugin_textdomain( self::SLUG );
	}

	/**
	 * Enqueues the CSS styles.
	 */
	public function add_styles() {
		wp_enqueue_style( 'track_your_writing_css', plugins_url( '../css/track-your-writing.css', __FILE__ ), array(), Plugin::VERSION );
	}

	/**
	 * Enqueues JS scripts
	 */
	public function add_scripts() {
		wp_enqueue_script( 'd3-scripts', plugins_url( '../vendor/d3/d3.min.js', __FILE__ ) );
		wp_enqueue_script( 'tyw-scripts', plugins_url( '../js/tyw-scripts.js', __FILE__ ), array( 'jquery' ), Plugin::VERSION, true );
		wp_localize_script( 'tyw-scripts', 'tyw_month_chart_data', $this->plugin->components->user_writing_data->month_chart_post_data() );
	}

	/**
	 * Renders the whole admin page.
	 */
	public function render_admin_page() {
		include( dirname( __FILE__ ) . '/../templates/single-mode-page.php' );
	}

	/**
	 * Process update profile form
	 */
	public function save() {
		$verify = (
			isset( $_POST[ self::NONCE_NAME ] )
			&&
			wp_verify_nonce( sanitize_key( wp_unslash( $_POST[ self::NONCE_NAME ] ) ), self::NONCE_ACTION )
		);

		if ( $verify ) {
			update_option( 'tyw_user_profile_id', sanitize_text_field( wp_unslash( $_POST['tyw_user_profile_id'] ) ) );
			wp_redirect( $this->admin_url() . '&updated=true' );
			exit;
		}
	}

	/**
	 * Returns the admin url of the Plugin.
	 *
	 * @return string
	 */
	public function admin_url() {
		return admin_url( '/admin.php?page=wp-trackyw' );
	}
}
