<?php
if ( ! defined( 'ABSPATH' ) ) { die; }  // Cannot access directly.

/**
 * Class MY_Example_Batch
 */
class agBatch extends WP_Batch {

    /**
     * Unique identifier of each batch
     * @var string
     */
    public $id = 'scrap_products';

    /**
     * Describe the batch
     * @var string
     */
    public $title = 'اجرای اسکراپ ها';

    /**
     * To setup the batch data use the push() method to add WP_Batch_Item instances to the queue.
     *
     * Note: If the operation of obtaining data is expensive, cache it to avoid slowdowns.
     *
     * @return void
     */
    public function setup() {

        
        $options = get_option( 'ag_scrap' );
        if(!empty($options['product_opt_repeater'])):
            $reps = $options['product_opt_repeater'];
            foreach ($reps as $rep):
                $pr_link = $rep['product_rep_link'];
                $pr_update = $rep['product_rep_update'];
                $pr_cargo = $rep['product_rep_cargo'];
                $pr_catgo = $rep['product_rep_catgo'];
                $this->push(new WP_Batch_Item($pr_link, array(
					'pr_link' => $pr_link,
					'pr_update' => $pr_update,
					'pr_cargo' => $pr_cargo,
					'pr_catgo' => $pr_catgo,
				)));
            endforeach;    
        endif;    

    }

    /**
     * Handles processing of batch item. One at a time.
     *
     * In order to work it correctly you must return values as follows:
     *
     * - TRUE - If the item was processed successfully.
     * - WP_Error instance - If there was an error. Add message to display it in the admin area.
     *
     * @param WP_Batch_Item $item
     *
     * @return bool|\WP_Error
     */
    public function process( $item ) {

        $datas = array(
            'pr_link'  => $item->get_value('pr_link'),
            'pr_update'=> $item->get_value('pr_update'),
            'pr_cargo' => $item->get_value('pr_cargo'),
            'pr_catgo' => $item->get_value('pr_catgo'),
        );

        $all_options = get_option('ag_frame');
        $all_catgo = $all_options['scrapper_default_category'];
        $C1 = $all_options['office_price'];
        $C2 = $all_options['cargo_price'];
        $TL = $all_options['lira_price'];
        $W = $all_options['comission_price'];
        $K = $all_options['times_factor'];

        $url = $datas['pr_link'];
        $product_title = agFetch::ag_get_title_from_url($url);
        $product_price = agFetch::ag_get_price_from_url($url);
        $product_desc  = agFetch::ag_get_desc_from_url($url);
        $product_images= agFetch::ag_get_gallery_from_url($url);
        $product_attributes = agFetch::ag_attr_from_url($url);
        $product_vars = agFetch::ag_get_vars_from_url($url);
        $product_cat = [];
        
        if(!empty($datas['pr_catgo'])){
            $product_cat[] = $datas['pr_catgo'];
            if(intval($datas['pr_cargo']) > 0){
                $F= $datas['pr_cargo'];
            }else{
                $cargoname = 'cargo_price_' . $datas['pr_catgo'][0]; 
                $F= $all_options[$cargoname];
            }
        }elseif(!empty($all_catgo)){
            $product_cat[] = $all_catgo;
            if(intval($datas['pr_cargo']) > 0){
                $F= $datas['pr_cargo'];
            }else{
                $cargoname = 'cargo_price_' . $all_catgo[0]; 
                $F= $all_options[$cargoname];
            }
        }else{

        }

    

        if($product_title && $product_price && $product_images){
            if($product_vars){
                $product_id = agcProduct::ag_create_variable_product($product_title,$product_price,$product_desc,$product_vars,$product_images,$product_attributes,$product_cat);
                $product = wc_get_product($product_id);
                agcProduct::create_attributes($product, $product_attributes);
                agcProduct::create_variations($product, $product_vars, $product_price);
                update_post_meta($product_id, 'ag_scrap_url', $url);
                update_post_meta($product_id, 'ag_pr_update', $datas['pr_update']);
                update_post_meta($product_id, 'ag_pr_cargo', $datas['pr_cargo']);
                // Return true if the item processing is successful.
                return true;
            }else{
                $product_id = agcProduct::ag_create_simple_product($product_title,$product_price,$product_desc,$product_images,$product_attributes,$product_cat);
                $product = wc_get_product($product_id);
                agcProduct::create_attributes($product, $product_attributes);
                update_post_meta($product_id, 'ag_scrap_url', $url);
                update_post_meta($product_id, 'ag_pr_update', $datas['pr_update']);
                update_post_meta($product_id, 'ag_pr_cargo', $datas['pr_cargo']);
                // Return true if the item processing is successful.
                return true;
            }
        }

        return false;
    }
    
    /**
     * Called when specific process is finished (all items were processed).
     * This method can be overriden in the process class.
     * @return void
     */
    public function finish() {
        // Do something after process is finished.
        // You have $this->items, etc.
    }
}