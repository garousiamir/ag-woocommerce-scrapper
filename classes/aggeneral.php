<?php
if ( ! defined( 'ABSPATH' ) ) { die; }  // Cannot access directly.

class agGeneral {

    public function __construct() {
        // Save custom input field value
        add_action('woocommerce_process_product_meta', [$this , 'save_custom_product_field']);
        // Add custom input field to product data meta box
        add_action('woocommerce_product_options_general_product_data', [$this ,'add_custom_product_field']);

    }

    public function add_custom_product_field() {
        global $post;
        // Get the existing value of the custom field
        $ag_scrap_url = get_post_meta($post->ID, 'ag_scrap_url', true);
        $ag_pr_update = get_post_meta($post->ID, 'ag_pr_update', true);
        $ag_pr_cargo = get_post_meta($post->ID, 'ag_pr_cargo', true);

        echo '<div class="options_group">';

        // Text input field
        woocommerce_wp_text_input(
            array(
                'id'          => 'ag_scrap_url',
                'label'       => __('نشانی مقصد محصول', 'your-text-domain'),
                'placeholder' => __('', 'your-text-domain'),
                'desc_tip'    => 'true',
                'description' => __('Enter the Scrap URL if it exists.', 'your-text-domain'),
                'value'       => $ag_scrap_url,
            )
        );
         // Text input field
         woocommerce_wp_text_input(
            array(
                'id'          => 'ag_pr_update',
                'label'       => __('بازه زمانی بروزرسانی', 'your-text-domain'),
                'placeholder' => __('', 'your-text-domain'),
                'desc_tip'    => 'true',
                'description' => __('', 'your-text-domain'),
                'value'       => $ag_pr_update,
            )
        );
         // Text input field
         woocommerce_wp_text_input(
            array(
                'id'          => 'ag_pr_cargo',
                'label'       => __('قیمت باربری', 'your-text-domain'),
                'placeholder' => __('', 'your-text-domain'),
                'desc_tip'    => 'true',
                'description' => __('', 'your-text-domain'),
                'value'       => $ag_pr_cargo,
            )
        );

        echo '</div>';
    }


    public function save_custom_product_field($post_id) {

        // Save the value of the custom field
        $ag_scrap_url = isset($_POST['ag_scrap_url']) ? sanitize_text_field($_POST['ag_scrap_url']) : '';
        $ag_pr_update = isset($_POST['ag_pr_update']) ? sanitize_text_field($_POST['ag_pr_update']) : '';
        $ag_pr_cargo = isset($_POST['ag_pr_cargo']) ? sanitize_text_field($_POST['ag_pr_cargo']) : '';
        
        // Save the value of the custom field
        update_post_meta($post_id, 'ag_scrap_url', $ag_scrap_url);
        update_post_meta($post_id, 'ag_pr_update', $ag_scrap_url);
        update_post_meta($post_id, 'ag_pr_cargo', $ag_scrap_url);
        
    }

}
