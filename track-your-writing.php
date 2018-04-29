<?php
/**
 * Plugin Name: Track Your Writing
 * Description: Track your and your site authors productivity with accurate and stunning visual data. Compare your progress and beat your past marks!
 * Text Domain: track-your-writing
 * Plugin URI:
 * Version: 1.0
 * Author: Oscar Sańchez
 * Author URI: http://oscarssanchez.com
 * License: GPL2
 *
 * @package TrackYourWriting
 */

namespace TrackYourWriting;

/** Prevent direct access to the file */
defined( 'ABSPATH' ) or die( 'Access denied' );

	require_once dirname( __FILE__ ) . '/php/class-plugin.php';
	require_once dirname( __FILE__ ) . '/php/class-admin.php';
	require_once dirname( __FILE__ ) . '/php/class-user-profile-manager.php';
	require_once dirname( __FILE__ ) . '/php/class-user-writing-data.php';

Plugin::get_instance();
