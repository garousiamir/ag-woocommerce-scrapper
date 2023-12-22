<?php
if ( ! defined( 'ABSPATH' ) ) { die; }  // Cannot access directly.

use PHPHtmlParser\Dom;
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
          return $priceElement->innertext;
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
   

  public static function ag_get_attr_from_url($url){
      // Create a new HTML DOM object
      $html = file_get_html($url);
  
      // Find the elements based on the class 'starred-attributes' and retrieve the first item
      $attrElement = $html->find('.starred-attributes > li', 0);
  
      if ($attrElement) {
          return $attrElement->innertext;
      } else {
          return 'Attributes not found';
      }
  }


  public static function ag_get_vari_from_url($url){
      // Create a new HTML DOM object
      $html = file_get_html($url);

      // Find elements for title and attribute sliders
      $titleElements = $html->find('.slicing-attributes > section > .scl-title');
      $attributeSliderElements = $html->find('.slicing-attributes > section > .attributeSlider > a');

      $titles = [];
      $attributeSliders = [];

      // Retrieve inner HTML content for titles
      foreach ($titleElements as $element) {
         $titles[] = $element->innertext;
      }

      // Retrieve inner HTML content for attribute sliders
      foreach ($attributeSliderElements as $element) {
         $attributeSliders[] = $element->innertext;
      }

      return [$titles, $attributeSliders];
   }


   public static function ag_get_image_from_url($url){
       // Create a new HTML DOM object
       $html = file_get_html($url);
   
       // Find the image element based on the CSS selector
       $imageElement = $html->find('#product-detail-app .gallery-container .product-image-container .base-product-image img', 0);
   
       if ($imageElement) {
           return $imageElement->outertext;
       } else {
           return 'Image not found';
       }
   }
  

}

