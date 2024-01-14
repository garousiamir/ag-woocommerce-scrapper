<?php
if ( ! defined( 'ABSPATH' ) ) { die; }  // Cannot access directly.

class agScrap {

    private $prefix;

    public function __construct($prefix) {
        $this->prefix = $prefix;
        $this->create_options();
    }

    public function create_options() {
        if (class_exists('CSF')) {
            CSF::createOptions($this->prefix, 
            array(
                'menu_title' => __( 'مدیریت اسکراپ' ),
                'menu_slug'  => 'scrapper_manager',
            ));

            $sections = array(
                array(
                    'id'    => 'tab_one', // Set a unique slug-like ID
                    'title' => 'لیست محصولات واکشی',
                    'fields' => $this->get_section_one_fields(),
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
                'id'        => 'product_opt_repeater',
                'type'      => 'repeater',
                'title'     => 'اضافه کردن محصول',
                'fields'    => array(
                   array(
                      'id'           => 'product_rep_link',
                      'type'         => 'text',
                      'title'        => 'لینک محصول',
                    ),
                    array(
                        'id'      => 'product_rep_op_switch',
                        'type'    => 'switcher',
                        'title'   => 'بروزرسانی محصول طبق تنظیمات',
                        'text_on'    => 'فعال',
                        'text_off'   => 'غیرفعال',
                        'default' => false
                    ),
                    array(
                        'id'           => 'product_rep_update',
                        'type'         => 'number',
                        'title'        => 'فاصله بروزرسانی محصول',
                        'dependency' => array( 'product_rep_op_switch', '==', '1' ),

                    ),
                    array(
                        'id'           => 'product_rep_cargo',
                        'type'         => 'number',
                        'title'        => 'قیمت باربری',
                         'dependency' => array( 'product_rep_op_switch', '==', '1' ),

                    ),
                    array(
                        'id'          => 'product_rep_catgo',
                        'type'        => 'select',
                        'multiple'            => true,
                        'title'       => 'دسته بندی این محصول',
                        'placeholder' => 'Select a category',
                        'options'     => 'categories',
                        'query_args'  => array(
                          'taxonomy'  => 'product_cat',
                        ),
                        'dependency' => array( 'product_rep_op_switch', '==', '1' ),
                      ),




        
                ),
                'default'   => array(
               
                
                )
            ),
              
        );
    }


}

