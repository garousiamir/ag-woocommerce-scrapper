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

}