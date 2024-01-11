<?php
if (!defined('ABSPATH')) {
    die; // Cannot access directly.
}

class agcProduct
{

    public function __construct()
    {
        // Constructor logic if needed
    }

    private static function get_product_id_by_title($product_title) {
        $args = array(
            'post_type'      => 'product',
            'post_status'    => 'publish',
            'posts_per_page' => 1,
            'title'          => $product_title,
        );
    
        $products = new WP_Query($args);
    
        if ($products->have_posts()) {
            $product = $products->posts[0];
            return $product->ID;
        }
        return false;
    }

    private static function create_attributes($product, $product_attributes)
    {
        if (!is_a($product, 'WC_Product')) {
            return;
        }

        $attributes = [];
        $numbers = count($product_attributes[0]);
        for ($i = 0; $i < $numbers; $i++) {
            $attribute = new WC_Product_Attribute();
            $attribute->set_id(wc_attribute_taxonomy_id_by_name($product_attributes[0][$i]));
            $attribute->set_name($product_attributes[0][$i]);
            $attribute->set_options(array($product_attributes[1][$i]));
            $attribute->set_position(1);
            $attribute->set_visible(1);
            $attribute->set_variation(1);
            $attributes[] = $attribute;
        }
        $product->set_attributes($attributes);
    }

    private static function create_variations($product, $product_vars, $product_price)
    {
        if (!is_a($product, 'WC_Product_Variable')) {
            return;
        }

        $attributes = [];
        $attribute = new WC_Product_Attribute();
        $attribute->set_id(wc_attribute_taxonomy_id_by_name($product_vars[0]));
        $attribute->set_name($product_vars[0]);
        $attribute->set_options($product_vars[1]);
        $attribute->set_visible(0);
        $attribute->set_variation(1);
        $attributes[] = $attribute;
        $product->set_attributes($attributes);

        foreach ($product_vars[1] as $product_var) {
            $variation = new WC_Product_Variation();
            $variation->set_parent_id($product->get_id());
            $variation->set_attributes(array($product_vars[0] => $product_var));
            $variation->set_regular_price($product_price);
            $variation->save();
        }
    }

    public static function ag_create_variable_product($product_title, $product_price, $product_desc, $product_vars, $product_images, $product_attributes, $product_cat)
    {
        $product_id = self::get_product_id_by_title($product_title);
    
        if ($product_id) {
            $product = wc_get_product($product_id);
        } else {
            $product = new WC_Product_Variable();
        }
        $product->set_name($product_title);
        $product->set_status('publish');
        $product->set_catalog_visibility('visible');
        $product->set_description($product_desc);
        
        $image_ids = [];
        $images_count = count($product_images);
        for ($i = 1; $i < $images_count; $i++) {
            $image_ids[] = agPicupload::ag_download_image_to_media_library($product_images[$i]);
        }
        $product->set_image_id($image_ids[0]);
        // Remove the first image from the gallery if it's present
        if ($images_count > 1) {
            array_shift($image_ids);
        }
        // Set the remaining images as gallery images
        $product->set_gallery_image_ids($image_ids);
        $product->set_category_ids($product_cat);

        if ($product_attributes) {
            self::create_attributes($product, $product_attributes);
        }
        if ($product_vars) {
            self::create_variations($product, $product_vars, $product_price);
        }
        $product->save();

        return $product->get_id();
    }

    public static function ag_create_simple_product($product_title, $product_price, $product_desc, $product_images, $product_attributes, $product_cat)
    {

        $product_id = self::get_product_id_by_title($product_title);
        
        if ($product_id) {
            $product = wc_get_product($product_id);
        } else {
            $product = new WC_Product();
        }
        $product->set_name($product_title);
        $product->set_status('publish');
        $product->set_catalog_visibility('visible');
        $product->set_description($product_desc);
        $product->set_regular_price($product_price);


        if ($product_attributes) {
            self::create_attributes($product, $product_attributes);
        }
        $product->set_category_ids($product_cat);

        $image_ids = [];
        $images_count = count($product_images);
        for ($i = 1; $i < $images_count; $i++) {
            $image_ids[] = agPicupload::ag_download_image_to_media_library($product_images[$i]);
        }
        $product->set_image_id($image_ids[0]);
        // Remove the first image from the gallery if it's present
        if ($images_count > 1) {
            array_shift($image_ids);
        }
        // Set the remaining images as gallery images
        $product->set_gallery_image_ids($image_ids);

        $product->save();

        return $product->get_id();
    }
}
?>
