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
require 'vendor/autoload.php';

//load the options framework
require 'includes/codestar-framework/codestar-framework.php';

//automatically require classes
spl_autoload_register( function($classname) {
    $class      = str_replace( '\\', DIRECTORY_SEPARATOR, str_replace( '_', '-', strtolower($classname) ) );
    $classes    = dirname(__FILE__) .  DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . $class . '.php'; 
    
    if( file_exists($classes) ) {
        require_once( $classes );
    }    
} );

//initializing Classes
if(is_admin()){
    $agOptions = new agOptions('ag_frame');
    $agGeneral = new agGeneral();
}
  