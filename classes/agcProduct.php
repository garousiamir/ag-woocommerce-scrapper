<?php
if ( ! defined( 'ABSPATH' ) ) { die; }  // Cannot access directly.

class agcProduct{

    public function __construct(){

    }
   
    // $product_price
    // $product_vars
    // $product_images
    // $product_attributes
    
    public static function ag_create_variable_product($product_title,$product_price,$product_desc,$product_vars,$product_images,$product_attributes) {
  
        $product = new WC_Product_Variable();
        $product->set_name($product_title);
        $product->set_status( 'publish' ); 
        $product->set_catalog_visibility( 'visible' );
        $product->set_description($product_desc);
        $product->set_image_id( $image_id );
        $product->set_category_ids( array( 20 ) );
     
        $attribute = new WC_Product_Attribute();
        $attribute->set_id( wc_attribute_taxonomy_id_by_name( 'pa_color' ) );
        $attribute->set_name( 'pa_color' );
        $attribute->set_options( array( 29, 30 ) );
        $attribute->set_position( 1 );
        $attribute->set_visible( 1 );
        $attribute->set_variation( 1 );
        $attributes[] = $attribute;
        $product->set_attributes( $attributes );
        $product->save();
     
        $variation1 = new WC_Product_Variation();
        $variation1->set_parent_id( $product->get_id() );
        $variation1->set_attributes( array( 'pa_color' => '29' ) );
        $variation1->set_regular_price( 99.99 );
        $variation1->save();
     
        $variation2 = new WC_Product_Variation();
        $variation2->set_parent_id( $product->get_id() );
        $variation2->set_attributes( array( 'pa_color' => '30' ) );
        $variation2->set_regular_price( 197.99 );
        $variation2->save();
     
    }


 
    // $product_vars
    // $product_images
    // $product_attributes

    public static function ag_create_simple_product($product_title,$product_price,$product_desc,$product_vars,$product_images,$product_attributes) {

        $product = new WC_Product(); 
        $product->set_name($product_title); 
        $product->set_status('publish'); 
        $product->set_catalog_visibility('visible'); 
        $product->set_description($product_desc);
        $product->set_regular_price($product_price); 
        $product->set_manage_stock(true); 
        $product->set_stock_status('instock'); 
        $product->set_backorders('no'); 
        // $product->set_sku('SAMPLESKU001');
        // $product->set_category_ids(array(12));
        // $product->set_tag_ids(array(34)); 
        // $image_url = 'https://example.com/sample-product-image.jpg'; 
        // $image_id = media_sideload_image($image_url, 0, '', 'id');
        // if (!is_wp_error($image_id)) {
        //     $product->set_image_id($image_id); 
        // }
        // Save the product
        $product_id = $product->save(); 

    }


}



