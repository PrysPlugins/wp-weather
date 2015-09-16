<?php
/**
 * Plugin Name: WP Weather
 * Plugin URI:  http://jeremypry.com/
 * Description: A simple weather plugin utilizing the Forecast.io service
 * Version:     0.1.0
 * Author:      Jeremy Pry
 * Author URI:  http://jeremypry.com/
 * Donate link: http://jeremypry.com/
 * License:     GPLv2
 * Text Domain: wp-weather
 * Domain Path: /languages
 */

/**
 * Copyright (c) 2015 Jeremy Pry (email : support@jpry.com)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2 or, at
 * your discretion, any later version, as published by the Free
 * Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

/**
 * Built using generator-plugin-wp
 */


/**
 * Autoloads files with classes when needed.
 *
 * @since 0.1.0
 *
 * @param string $class_name Name of the class being requested.
 */
function wp_weather_autoload_classes( $class_name ) {
	if ( 0 !== strpos( $class_name, 'JPry_' ) ) {
		return;
	}

	$file = __DIR__ . '/includes/class-' . strtolower( str_replace( '_', '-', $class_name ) );
	if ( file_exists( $file ) ) {
		require_once( $file );
	}
}
spl_autoload_register( 'wp_weather_autoload_classes' );

// Load the main plugin class
$jpry_weather = JPry_WP_Weather::get_instance( __FILE__ );
add_action( 'plugins_loaded', array( $jpry_weather, 'hooks' ) );
