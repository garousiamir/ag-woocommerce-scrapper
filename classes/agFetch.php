<?php
if ( ! defined( 'ABSPATH' ) ) { die; }  // Cannot access directly.

use PHPHtmlParser\Dom;
class agFetch{
    
    public function __construct(){

    }

    public static function ag_get_title_from_url($url){
       $dom = new Dom;
       $dom->loadFromUrl($url);
       return $dom->find('h1.pr-new-br')[0]->innerHtml;
    }


    public static function ag_get_price_from_url($url){
      $dom = new Dom;
      $dom->loadFromUrl($url);
      return $dom->find('.prc-dsc')[0]->innerHtml;
   }


   public static function ag_get_desc_from_url($url){
      $dom = new Dom;
      $dom->loadFromUrl($url);
      return $dom->find('.info-wrapper')[0]->innerHtml;
   }


   
   public static function ag_get_attr_from_url($url){
      $dom = new Dom;
      $dom->loadFromUrl($url);
      return $dom->find('.starred-attributes > li')->innerHtml;
   }


   public static function ag_get_vari_from_url($url){
      $dom = new Dom;
      $dom->loadFromUrl($url);
      return [$dom->find('.slicing-attributes > section > .scl-title')->innerHtml,$dom->find('.slicing-attributes > section > .attributeSlider > a')->innerHtml];
   }

    
    public static function ag_get_image_from_url($url){
        $dom = new Dom;
        $dom->loadFromUrl($url);
        return $dom->find('#product-detail-app .gallery-container .product-slide-container .product-slide > img')[0]->getAttribute('src');
     }

}

