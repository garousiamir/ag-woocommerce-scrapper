<?php
class agOptions {

    private $prefix;

    public function __construct($prefix) {
        $this->prefix = $prefix;
        $this->create_options();
    }

    public function create_options() {
        if (class_exists('CSF')) {
            CSF::createOptions($this->prefix, 
            array(
                'menu_title' => __( 'تنظیمات اسکراپر' ),
                'menu_slug'  => 'scrapper_options',
            ));

            $sections = array(
                array(
                    'id'    => 'tab_one', // Set a unique slug-like ID
                    'title' => 'تنظیمات عمومی',
                    'fields' => $this->get_section_one_fields(),
                ),
                array(
                    'id'    => 'tab_two', // Set a unique slug-like ID
                    'title' => 'تنظیمات قیمت',
                    'fields' => $this->get_section_two_fields(),
                ),
             
            );

            foreach ($sections as $section) {
                CSF::createSection($this->prefix, $section);
            }
        }
    }

    private function get_section_one_fields() {
        return array(
                array(
                'id'         => 'auto_update_products',
                'type'       => 'switcher',
                'title'      => 'بروزرسانی محصولات',
                'default'    => false
                ),
                array(
                    'id'    => 'update_products_min_time',
                    'type'  => 'number',
                    'title' => 'کم ترین فاصله زمانی بروزرسانی محصولات',
                    'dependency' => array( 'auto_update_products', '==', '1' ),

                  ),
                  array(
                    'id'    => 'update_products_max_time',
                    'type'  => 'number',
                    'title' => 'بیشترین فاصله زمان بروزرسانی محصولات',
                    'dependency' => array( 'auto_update_products', '==', '1' ),
                  ),
                  array(
                    'id'          => 'scrapper_default_category',
                    'type'        => 'select',
                    'multiple'            => true,
                    'title'       => 'دسته بندی پیش فرض محصولات',
                    'placeholder' => 'Select a category',
                    'options'     => 'categories',
                    'query_args'  => array(
                      'taxonomy'  => 'product_cat',
                    ),
                  ),
        );
    }
    private function get_section_two_fields() {
        return array(
            array(
                'id'    => 'office_price',
                'type'  => 'number',
                'title' => 'هزینه دفتر',
                'dependency' => array( 'auto_update_products', '==', '1' ),
              ),
              array(
                'id'    => 'cargo_price',
                'type'  => 'number',
                'title' => 'هزینه کارگو و حمل',
                'dependency' => array( 'auto_update_products', '==', '1' ),
              ),
        );
    }


}

