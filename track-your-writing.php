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
 *
 * Copyright (c) 2018 Oscar Sánchez (https://oscarssanchez.com/)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2 or, at
 * your discretion, any later version, as published by the Free
 * Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
 *
 * @package TrackYourWriting
 *
 */

namespace TrackYourWriting;

/** Prevent direct access to the file */
defined( 'ABSPATH' ) or die( 'Access denied' );

if ( version_compare( phpversion(),'5.2','<=' ) ) {
	add_action( 'admin_notices', 'track_your_writing_php_version_error()' );
}

/**
 * Admin notice for incompatible versions of PHP.
 */
function track_your_writing_php_version_error() {
	printf( '<div class="error"><p>%s</p></div>', esc_html( track_your_writing_php_version_text() ) );
}
/**
 * Error text when PHP version is too old.
 *
 * @return string
 */
function  track_your_writing_php_version_text() {
	return __( 'Track Your Writing plugin error: Your version of PHP is too old to run this plugin. You must be running PHP 5.3 or higher.', 'track-your-writing' );
}

require_once dirname( __FILE__ ) . '/php/class-plugin.php';
$plugin = Plugin::get_instance();
$plugin->init();
