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

$requires = new agRequired();

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


// $product_title = agFetch::ag_get_title_from_url();
// $product_price = agFetch::ag_get_price_from_url();
// $product_desc  = agFetch::ag_get_desc_from_url();
// $product_images= agFetch::ag_get_gallery_from_url();
// $product_attributes = agFetch::ag_attr_from_url();
// $product_vars = agFetch::ag_get_vars_from_url();
// $product_cat = '';



function amir(){
    $options = get_option( 'ag_scrap' );
    $reps = $options['product_opt_repeater'];
    $pr_link = $reps[0]['product_rep_link'];

    $url = $pr_link;
    
    $product_title = agFetch::ag_get_title_from_url($url);
    $product_price = agFetch::ag_get_price_from_url($url);
    $product_desc  = agFetch::ag_get_desc_from_url($url);
    $product_images= agFetch::ag_get_gallery_from_url($url);
    $product_attributes = agFetch::ag_attr_from_url($url);
    $product_vars = agFetch::ag_get_vars_from_url($url);
    // $product_cat = '';

    var_dump($product_title);
    echo '<br>';
    var_dump($product_price);
    echo '<br>';
    var_dump($product_desc);
    echo '<br>';
    var_dump($product_images);
    echo '<br>';
    var_dump($product_attributes);
    echo '<br>';
    var_dump($product_vars);
    echo '<br>';
    
    // if($product_vars !== false){
    //     agcProduct::ag_create_variable_product($product_title,$product_price,$product_desc,$product_vars,$product_images,$product_attributes,$product_cat);
    // }else{
    //     agcProduct::ag_create_simple_product($product_title,$product_price,$product_desc,$product_images,$product_attributes,$product_cat);
    // }
}
add_action( 'init', 'amir' );