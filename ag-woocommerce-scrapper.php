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

//load the options framework
require 'includes/codestar-framework/codestar-framework.php';
require 'includes/wp-batch-processing/wp-batch-processing.php';
require 'includes/simple_html_dom.php';

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


add_action( 'init', 'amir' );

function amir(){
    $url ='https://www.trendyol.com/collagen-life/5-tip-kolajen-tip-1-tip-2-tip-3-tip-5-tip-10-selenyum-c-vitamini-ve-cinko-90-tablet-p-661983701?boutiqueId=621707&merchantId=783518&sav=true';
    $amir = agFetch::ag_attr_from_url($url);
}   
