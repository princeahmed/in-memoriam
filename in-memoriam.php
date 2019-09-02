<?php
/*
 Plugin Name: In Memoriam
 Plugin URI: bikersconnection.com
 Description: The customized version of In Memoriam
 Author: Richard Wing
 Version: 1.0
 Author URI: bikersconnection.com
 Text Domain: memoriam
 */

defined( 'ABSPATH' ) || exit();

class Customized_Memoriam {

	function __construct() {
		require_once dirname( __FILE__ ) . '/in-memoriam-light-a-candle/in-memoriam-light-a-candle.php';
		require_once dirname( __FILE__ ) . '/includes/hook-functions.php';
		require_once dirname( __FILE__ ) . '/includes/core-functions.php';

		add_action( 'after_setup_theme', [ $this, 'register_image_sizes' ] );
		add_action( 'candle_extra_fields', 'submission_extra_fields' );
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
		add_action( 'candle_option_fields', [ $this, 'options' ] );
		add_action( 'save_post_candle', [ $this, 'save_post' ] );
	}

	function register_image_sizes() {
		add_image_size( 'candle_select', '50', '50', false );
	}

	function enqueue_scripts() {
		wp_enqueue_script( 'memoriam_image_select', plugins_url( '/assets/image-select.js', __FILE__ ), [ 'jquery' ], false, true );
	}


	function options() {
		wp_enqueue_media();

		register_setting( 'imlac_option_group', 'candle_images' );
		register_setting( 'imlac_option_group', 'candle_images_width' );
		register_setting( 'imlac_option_group', 'candle_images_height' );

		add_settings_field(
			'candle_images',
			'Images for Submission Selection.',
			'memoriam_image_uploader',
			'imlac_section_page_type',
			'imlac_section_id'
		);

		add_settings_field(
			'candle_images_width',
			'Candle Image Width (PX):',
			'print_input_field_cb',
			'imlac_section_page_type',
			'imlac_section_id',
			[
				'id'   => 'candle_images_width',
				'name' => 'candle_images_width',
				'type' => 'number',
			]
		);

		add_settings_field(
			'candle_images_height',
			'Candle Image Height (PX):',
			'print_input_field_cb',
			'imlac_section_page_type',
			'imlac_section_id',
			[
				'id'   => 'candle_images_height',
				'name' => 'candle_images_height',
				'type' => 'number',
			]
		);
	}

	function save_post( $post_id ) {
		if ( ! empty( $_REQUEST['candle_image'] ) ) {
			update_post_meta( $post_id, '_thumbnail_id', intval( $_REQUEST['candle_image'] ) );
		}
	}

}

new Customized_Memoriam();