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
                $this->push(new WP_Batch_Item($pr_link, array(
					'pr_link' => $pr_link,
					'pr_update' => $pr_update,
					'pr_cargo' => $pr_cargo,
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
        );

        $url = $datas['pr_link'];
        $url = strval($url);
        $title = agFetch::ag_get_title_from_url($url);
        $title = strip_tags($title);

        if(!empty($title)){
            agcProduct::ag_create_variable_product($title);
        }
        else{
            return new WP_Error( 302, "title does not exist" );
        }

        // Return true if the item processing is successful.
        return true;
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