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
if ( ! defined( 'ABSPATH' ) ) { die; } 

require_once 'includes/codestar-framework/codestar-framework.php';
require_once 'includes/wp-batch-processing/wp-batch-processing.php';
require_once 'includes/simple_html_dom.php';

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



function amir(){
    $product_id = '14305';
    $product = wc_get_product($product_id);
    $url = 'https://www.trendyol.com/egemoda/kadin-houston-baskili-oversize-t-shirt-p-747098552';
    $product_vars = agFetch::ag_get_vars_from_url($url);
    $product_price = agFetch::ag_get_price_from_url($url);
    agcProduct::create_variations($product, $product_vars, $product_price);
}
// add_action('init','amir');
