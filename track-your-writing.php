<?php
/**
 * Plugin Name: Track Your Writing
 * Description: Track your and your site author's productivity with accurate and stunning visual data. Compare your progress and beat your past score!
 * Text Domain: track-your-writing
 * Plugin URI: https://github.com/oscarssanchez/track-your-writing/
 * Version: 0.1
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
$plugin = Plugin::get_instance();
$plugin->init();
