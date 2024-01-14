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
        $existing_value = get_post_meta($post->ID, 'ag_scrap_url', true);

        echo '<div class="options_group">';

        // Text input field
        woocommerce_wp_text_input(
            array(
                'id'          => 'ag_scrap_url',
                'label'       => __('Scrap URL', 'your-text-domain'),
                'placeholder' => __('Enter Scrap URL', 'your-text-domain'),
                'desc_tip'    => 'true',
                'description' => __('Enter the Scrap URL if it exists.', 'your-text-domain'),
                'value'       => $existing_value,
            )
        );

        echo '</div>';
    }


    public function save_custom_product_field($post_id) {
        // Save the value of the custom field
        $scrap_url = isset($_POST['ag_scrap_url']) ? sanitize_text_field($_POST['ag_scrap_url']) : '';

        update_post_meta($post_id, 'ag_scrap_url', $scrap_url);
    }

}
