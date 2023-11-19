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
                    'id'    => 'one_tab', // Set a unique slug-like ID
                    'title' => 'تنظیمات عمومی',
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
                'id'           => 'bglogin',
                'type'         => 'upload',
                'title'        => 'آپلود بک گراند صفحه لاگین وردپرس',
                'library'      => 'image',
                'placeholder'  => 'http://',
                'button_title' => 'آپلود تصویر',
                'remove_title' => 'حذف تصویر',
                'default' => 'https://s21.uupload.ir/files/garousiamir/autumn-season-leafs-plant-scene-generative-ai.jpg',
                ),
                array(
                'id'           => 'kaveh_logo_up',
                'type'         => 'upload',
                'title'        => 'آپلود لوگو',
                'library'      => 'image',
                'placeholder'  => 'http://',
                'button_title' => 'آپلود تصویر',
                'remove_title' => 'حذف تصویر',
                'default' => 'https://kaveh.moeinwp.com/1/wp-content/uploads/2022/10/demo1.svg',
                ),
                array(
                'id'      => 'kaveh_preload_switch',
                'type'    => 'switcher',
                'title'   => 'پیش بارگزاری صفحات',
                'text_on'    => 'فعال',
                'text_off'   => 'غیرفعال',
                'default' => false
                ),
            
        
                array(
                'id'         => 'search_kaveh_tasavir',
                'type'       => 'switcher',
                'title'      => 'بنر های تبلیغاتی در بخش سرچ',
                'default'    => false
                ),
        
                array(
                'id'        => 'search-pic-repeater',
                'type'      => 'repeater',
                'title'     => 'تصاویر اسلایدر باکس سرچ',
                'dependency' => array( 'search_kaveh_tasavir', '==', '1' ),
                'fields'    => array(
        
                    array(
                        'id'           => 'searc-pic',
                        'type'         => 'upload',
                        'title'        => 'تصویر اسلایدر',
                        'library'      => 'image',
                        'placeholder'  => 'http://',
                        'button_title' => 'آپلود تصویر',
                        'remove_title' => 'حذف تصویر',
                    ),
                    array(
                        'id'           => 'searc-pic-url',
                        'type'         => 'link',
                        'title'        => 'لینک آیکون دوم',
                        'add_title'    => 'اضافه کردن لینک',
                        'edit_title'   => 'ویرایش لینک',
                        'remove_title' => 'حذف لینک',
                    ),
        
        
                ),
                'default'   => array(
                    array(
                    'searc-pic' => 'https://kaveh.moeinwp.com/4/wp-content/uploads/2023/02/slider.png',
                    ),
                    array(
                    'searc-pic' => 'https://kaveh.moeinwp.com/4/wp-content/uploads/2023/02/cloths3.jpg',
                    ),
                    array(
                    'searc-pic' => 'https://kaveh.moeinwp.com/4/wp-content/uploads/2023/02/cloths2.jpg',
                    ),
                )
                ),
        
                array(
                'id'           => 'aj-search',
                'type'         => 'upload',
                'title'        => 'تصویر کوچک اول سرچ',
                'library'      => 'image',
                'placeholder'  => 'http://',
                'button_title' => 'آپلود تصویر',
                'remove_title' => 'حذف تصویر',
                'dependency' => array( 'search_kaveh_tasavir', '==', '1' ),
                'default' => 'https://kaveh.moeinwp.com/1/wp-content/uploads/2022/08/banner-03.png',
        
                ),
                array(
                'id'           => 'aj-search2',
                'type'         => 'upload',
                'title'        => 'تصویر کوچک اول دوم',
                'library'      => 'image',
                'placeholder'  => 'http://',
                'button_title' => 'آپلود تصویر',
                'remove_title' => 'حذف تصویر',
                'dependency' => array( 'search_kaveh_tasavir', '==', '1' ),
                'default' => 'https://kaveh.moeinwp.com/1/wp-content/uploads/2022/08/banner-02.png',
                ),
        );
    }


}

