<?php
/*
    Plugin Name: ag woocommerce scrapper
    Plugin URI: https://agarousi.ir
    Version: 1.0
    description: Simple Woocommerce Scrapper
    text-domain: ag-woocommerce-scrapper
    Author: Amirhossein Garousi
    Author URI: https://agarousi.ir
*/
if ( ! defined( 'ABSPATH' ) ) { die; }  // Cannot access directly.

//load from composer
require __DIR__ . '/vendor/autoload.php';

//load the options framework
require 'includes/codestar-framework/codestar-framework.php';
require 'includes/wp-batch-processing/wp-batch-processing.php';

//automatically require classes
spl_autoload_register( function($classname) {
    $class      = str_replace( '\\', DIRECTORY_SEPARATOR, str_replace( '_', '-', strtolower($classname) ) );
    $classes    = dirname(__FILE__) .  DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . $class . '.php'; 
    
    if( file_exists($classes) ) {
        require_once( $classes );
    }    
} );

/**
 * Initialize the classes.
 */
if(is_admin()){
    $agOptions = new agOptions('ag_frame');
    $agGeneral = new agGeneral();
    $agGeneral = new agScrap('ag_scrap');
    add_action( 'wp_batch_processing_init', 'wp_batch_processing_init', 15, 1 );
}

/**
 * Initialize the batches.
 */
function wp_batch_processing_init() {
    $batch = new agBatch();
    WP_Batch_Processor::get_instance()->register( $batch );
}



$product_url= 'https://www.trendyol.com/stanley/klasik-trigger-action-seyahat-bardagi-0-47-lt-p-34050838';
$response = wp_remote_get($product_url);

if (is_wp_error($response)) {
    // Handle error if failed to fetch URL
    return false;
}

$body = wp_remote_retrieve_body($response);

// Use DOMDocument or other methods to parse the HTML and extract required information like title, thumbnail, price, etc.
$doc = new DOMDocument();
libxml_use_internal_errors(true); // Suppress HTML errors
$doc->loadHTML($body);
libxml_clear_errors();

