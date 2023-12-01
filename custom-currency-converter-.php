<?php
/*
Plugin Name: Custom Currency Converter
Description: This is a simple custom currency converter where users can convert currencies with precision.
Version: 1.0.0
Author: Palash Kumer
Author URI: https://github.com/palashkumer
*/

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Enqueue styles and scripts
 */
function currency_converter_enqueue_scripts() {
	wp_enqueue_style( 'currency-converter-style', plugins_url( 'assets/css/style.css', __FILE__ ) );
	wp_enqueue_script( 'currency-converter-script', plugins_url( 'assets/js/script.js', __FILE__ ), array( 'jquery' ), null, true );

	// Localize the script with nonce.
	wp_localize_script(
		'currency-converter-script',
		'cc_ajax_object',
		array(
			'ajax_url' => admin_url( 'admin-ajax.php' ),
		)
	);
}
add_action( 'wp_enqueue_scripts', 'currency_converter_enqueue_scripts' );

/**
 * Add AJAX action for currency conversion
 */
add_action( 'wp_ajax_convert_currency', 'convert_currency' );
add_action( 'wp_ajax_nopriv_convert_currency', 'convert_currency' );


/**
 * Include AJAX functions
 */
require plugin_dir_path( __FILE__ ) . 'includes/ajax-function.php';


/**
 * Add shortcode for displaying the currency converter
 */
function currency_converter_shortcode() {
	ob_start();
	include 'templates/currency-converter-template.php';
	return ob_get_clean();
}
add_shortcode( 'currency_converter', 'currency_converter_shortcode' );
