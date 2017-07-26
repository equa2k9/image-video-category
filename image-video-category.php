<?php
/**
* Plugin Name: Extra image/video category
* Plugin URI: 
* Description: Extra image/video category
* Version: 1.0
* Author: Oleksandr Chopenko
* Author URI: 
* License: 
*/

if ( ! defined( 'WPINC' ) ) {
	die;
}

function activate_image_video() {
	require_once plugin_dir_path( __FILE__ ) . 'inc/image-video-activation.php';
	Image_Video_Activation::activate();
}

function deactivate_image_video() {
	require_once plugin_dir_path( __FILE__ ) . 'inc/image-video-activation.php';
	Image_Video_Activation::deactivate();
}

register_activation_hook( __FILE__, 'activate_image_video' );
register_deactivation_hook( __FILE__, 'deactivate_image_video' );


require plugin_dir_path( __FILE__ ) . 'inc/image-video-main.php';
require plugin_dir_path( __FILE__ ) . 'inc/image-video-form.php';
require plugin_dir_path( __FILE__ ) . 'inc/image-video-front.php';

function run_image_video() {

	$plugin = new Image_Video();
}
run_image_video();
