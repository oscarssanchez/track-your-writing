<?php
/**
 * The main plugin class.
 *
 * @package TrackYourWriting
 */

namespace TrackYourWriting;

/**
 * Instantiates and initializes the plugin.
 *
 * @package TrackYourWriting
 */
class Plugin {

	/**
	 * The plugin instance.
	 *
	 * @var object
	 */
	public static $instance;

	/**
	 * Instantiated plugin classes.
	 *
	 * @var object
	 */
	public $components;

	/**
	 * Plugin initializer.
	 */
	public function init() {
		$this->load_files();
		$this->load_classes();
	}

	/**
	 * Initialize the main plugin class.
	 *
	 * @return Plugin
	 */
	public static function get_instance() {
		if ( ! self::$instance instanceof Plugin ) {
			self::$instance = new Plugin();
		}
		return self::$instance;
	}

	/**
	 * Instantiates and loads the plugin classes.
	 */
	public function load_classes() {
		$this->components        = new \stdClass();
		$this->components->admin = new Admin( $this );
		$this->components->admin->init();
		$this->components->profile_manager   = new Profile_Manager();
		$this->components->user_writing_data = new User_Writing_Data();
	}

	/**
	 * Loads the plugin files.
	 */
	public function load_files() {
		require_once dirname( __FILE__ ) . '/class-admin.php';
		require_once dirname( __FILE__ ) . '/class-user-profile-manager.php';
		require_once dirname( __FILE__ ) . '/class-user-writing-data.php';
	}
}
