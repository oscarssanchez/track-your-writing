<?php
/**
 * The main plugin class.
 *
 * @package track-your-writing
 */

namespace TrackYourWriting;
/**
 * Instantiates and initializes the plugin.
 *
 * @package TrackYourWriting
 */
class Track_Your_Writing {
	/**
	 * The instantiated admin page class.
	 *
	 * @var object
	 */
	public $admin_page;
	/**
	 * Track_your_writing constructor.
	 */
	public function __construct() {
		$this->load_classes();
	}
	/**
	 * Initialize the main plugin class.
	 *
	 * @return null|Track_Your_Writing
	 */
	public static function get_instance() {
		static $instance = null;
		if ( ! $instance ) {
			$instance = new self();
		}
		return $instance;
	}
	/**
	 * Instantiates and loads the plugin classes.
	 */
	public function load_classes() {
		$this->admin_page = new TYW_Admin();
	}

	public static function activate() {
	    \TYW_Db::db_install();
    }

}
