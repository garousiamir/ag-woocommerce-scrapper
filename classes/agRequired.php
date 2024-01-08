<?php
if ( ! defined( 'ABSPATH' ) ) { die; }  // Cannot access directly.

class agRequired{

    public function __construct(){
        add_action('wp', [$this ,'ag_required']);
    }

    private function ag_required(){
      
    }

}