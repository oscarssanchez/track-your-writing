<?php
/**
 * Plugin Name: Track Your Writing
 * Description: TYW in development
 * Plugin URI:
 * Version: 1.0
 * Author: Oscar Sańchez
 * Author URI: http://oscarssanchez.com
 * License: GPL2
 *
 * @package track-your-writing
 */

namespace TrackYourWriting;

/** Prevent direct access to the file */
defined( 'ABSPATH' ) or die( 'Access denied' );

	require_once dirname( __FILE__ ) . '/php/class-track-your-writing.php';
	require_once dirname( __FILE__ ) . '/php/class-track-your-writing-admin.php';
  require_once dirname( __FILE__ ) . '/php/class-tyw-db.php';
	require_once dirname( __FILE__ ) . '/php/class-user-profile-manager.php';
	require_once dirname( __FILE__ ) . '/php/class-tyw-user-writing-data.php';

Track_Your_Writing::get_instance();
