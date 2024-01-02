<?php
if ( ! defined( 'ABSPATH' ) ) { die; }  // Cannot access directly.

class agFetch{
    
    public function __construct(){

    }

    public static function ag_get_title_from_url($url){
      // Create a new HTML DOM object
      $html = file_get_html($url);

      // Find the title element based on the class 'pr-new-br'
      $titleElement = $html->find('h1.pr-new-br', 0);

      if ($titleElement) {
         return $titleElement->innertext;
      } else {
         return 'Title not found';
      }
    }

    public static function ag_get_price_from_url($url){
      // Create a new HTML DOM object
      $html = file_get_html($url);
  
      // Find the element based on the class 'prc-dsc'
      $priceElement = $html->find('.prc-dsc', 0);
  
      if ($priceElement) {
          $string = $priceElement->innertext;
          $number = (int) preg_replace('/[^0-9]/', '', $string);
          return $number;
      } else {
          return 'Price not found';
     }
       
    }

   public static function ag_get_desc_from_url($url){
      // Create a new HTML DOM object
      $html = file_get_html($url);
      // Find the element based on the class 'info-wrapper'
      $descElement = $html->find('.info-wrapper', 0);
  
      if ($descElement) {
          return $descElement->innertext;
      } else {
          return 'Description not found';
      }
    }

  public static function ag_get_vars_from_url($url){
      // Create a new HTML DOM object
      $html = file_get_html($url);
  
      // Find the elements based on the class 'starred-attributes' and retrieve the first item
      $attrElement = $html->find('.size-variant-wrapper .variants', 0);
  
      if ($attrElement) {
          return $attrElement->innertext;
      } else {
          return 'variations not found';
      }
    }

    public static function ag_get_gallery_from_url($url){
        // Fetch the HTML content from the URL
        $html = file_get_html($url);

        // Find script tags with JSON-LD content
        $productScripts = $html->find('script[type="application/ld+json"]',0)->innertext;
        $json = json_decode($productScripts ,true);
        $images = $json['image'];
        return  $images;
    }

    public static function ag_attr_from_url($url){
        // Create a new HTML DOM object
        $html = file_get_html($url);
        // Find the elements based on the class 'starred-attributes' and retrieve the first item
        $container = $html->find('.detail-attr-container', 0);
        $container = json_decode($container,true);
        return $container;
    }
  

}