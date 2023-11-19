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



// Add custom menu item to the admin dashboard
function custom_dashboard_menu_item() {
    add_menu_page(
        'اسکراپر', // Page title
        'اسکراپر', // Menu title
        'manage_options', // Capability required to access this menu item
        'scrapper', // Menu slug (should be unique)
        'scrapper_page_content', // Callback function to display the page content
        'dashicons-admin-page', // Icon for the menu item - You can choose from dashicons (https://developer.wordpress.org/resource/dashicons/)
        999 // Position of the menu item
    );
}
add_action('admin_menu', 'custom_dashboard_menu_item');

// Callback function to display content for the custom page
function scrapper_page_content() {
    // Add your custom page content here
    echo '<div class="wrap"><h1>Custom Page</h1><p>This is your custom page content.</p></div>';
}
