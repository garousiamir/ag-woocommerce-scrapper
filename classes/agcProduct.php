<?php

class agcProduct{

    public function __construct(){

    }
   
    public static function ag_create_variable_product( $title , $image_id ) {
  
        $product = new WC_Product_Variable();
        $product->set_name( $title );
        $product->set_status( 'publish' ); 
        $product->set_catalog_visibility( 'visible' );
        $product->set_image_id( $image_id );
        $product->set_category_ids( array( 20 ) );
     
        $attribute = new WC_Product_Attribute();
        $attribute->set_id( wc_attribute_taxonomy_id_by_name( 'pa_color' ) );
        $attribute->set_name( 'pa_color' );
        $attribute->set_options( array( 29, 30 ) ); // color att terms
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

    public static function ag_create_simple_product() {

        $product = new WC_Product(); // Create a new WC_Product instance
        $product->set_name('Sample Product'); // Product name
        $product->set_status('publish'); // Product status (publish, draft, etc.)
        $product->set_catalog_visibility('visible'); // Product visibility on the catalog (visible, hidden, etc.)
        $product->set_description('This is a sample product description.'); // Product description
        $product->set_short_description('Short description for the sample product.'); // Short description
        $product->set_regular_price(19.99); // Regular price
        $product->set_manage_stock(true); // Manage stock (true or false)
        $product->set_stock_quantity(10); // Stock quantity
        $product->set_stock_status('instock'); // Stock status (instock, outofstock)
        $product->set_backorders('no'); // Allow backorders (yes, no, notify)
        $product->set_sku('SAMPLESKU001'); // Product SKU

        // $product->set_category_ids(array(12)); // Array of category IDs
        // $product->set_tag_ids(array(34)); // Array of tag IDs

        // $image_url = 'https://example.com/sample-product-image.jpg'; // URL of the product image
        // $image_id = media_sideload_image($image_url, 0, '', 'id'); // Download and attach the image
        // if (!is_wp_error($image_id)) {
        //     $product->set_image_id($image_id); // Set the image ID for the product
        // }

        // Save the product
        $product_id = $product->save(); // Save the product and get the product ID

    }


}

