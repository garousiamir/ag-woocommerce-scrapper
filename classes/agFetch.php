<?php
if ( ! defined( 'ABSPATH' ) ) { die; }  // Cannot access directly.

class agFetch{
    
    public function __construct(){

    }

    public static function ag_get_title_from_url($url){
      // Create a new HTML DOM object
      $html = file_get_html($url);

      // Find the title element based on the class 'pr-new-br'
      $titleElement = $html->find('h1.pr-new-br', 0)->innertext;
      $title = strip_tags($titleElement);
      if ($titleElement) {
         return $title;
      } else {
         return false;
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
          return false;
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
          return false;
      }
    }

    public static function ag_get_vars_from_url($url){
      // Create a new HTML DOM object
      $html = file_get_html($url);

      $attrElementtitle = $html->find('.size-variant-wrapper', 0);
      $doc = new DOMDocument();
      $doc->loadHTML($attrElementtitle);
      $spanElements = $doc->getElementsByTagName('span');
      foreach ($spanElements as $span) {
          if ($span->getAttribute('class') === 'size-variant-title') {
              $titleElement = $span->getElementsByTagName('span')->item(0);
              $titlee = $titleElement->textContent;
          }
      }
      $attrElement = $html->find('.size-variant-wrapper .variants', 0);

      $dom = new DOMDocument();
      $dom->loadHTML($attrElement);
      $xpath = new DOMXPath($dom);
      $elements = $xpath->query('//div[@title]');
      $vars = [];
      if ($elements !== false) {
          foreach ($elements as $element) {
              $title = $element->textContent;
              $vars[] = $title;
          }
      }
  
      if (!empty($vars)) {
          return [$titlee , $vars];
      } else {
          return false;
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
        if(!empty($container)){
        $doc = new DOMDocument();
        $doc->loadHTML($container);

        $liElements = $doc->getElementsByTagName('li');

        $firsts = [];
        $seconds = [];
        foreach ($liElements as $li) {
            $spans = $li->getElementsByTagName('span');
            
            if ($spans->length >= 2) {
                $firstSpan = $spans->item(0)->nodeValue;
                $secondSpan = $spans->item(1)->nodeValue;

                $firsts[] = $firstSpan . PHP_EOL;
                $seconds[] = $secondSpan . PHP_EOL;

            }
        }
        }
        if(!empty($firsts)){
            return [$firsts,$seconds];
        }else{
            return false;
        }
    }

}