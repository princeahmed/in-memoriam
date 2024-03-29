<?php
/*
Plugin Name: In Memoriam (Light a Candle)
Plugin URI: https://www.setthings.com/en/in-memoriam-light-a-candle-wordpress-plugin/
Description: Allows you to easily and quickly add candles to your WordPress website
Version: 2.0
Author: Nicolae Sfetcu
Author URI: https://www.setthings.com/
License: GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Domain Path: /languages
Text Domain: in-memoriam-light-a-candle
*/

// Ensure WordPress has been bootstrapped
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$path = trailingslashit( dirname( __FILE__ ) );

// Ensure our class dependencies class has been defined
if ( ! class_exists( 'Candles_Widget' ) ) {
	require_once( $path . 'class.candles-widget.php' );
}

if ( ! class_exists( 'Plugify_Light_Candles' ) ) {
	require_once( $path . 'class.in-memoriam-light-a-candle.php' );
}

if ( ! class_exists( 'WP_Candle' ) ) {
	require_once( $path . 'class.wp-candle.php' );
}

// option to support email notification
// of users when candles are published.
// Default value: true
add_option( 'imlac_candle_publish_notification', true );
add_option( 'imlac_candle_publish_notification', true );

add_filter( 'ct_disable_captcha', '__return_true' );

require_once( $path . 'lib/functions.php' );
require_once( $path . 'lib/shortcodes.php' );

// Boot Light Candles
new Plugify_Light_Candles();

?>
