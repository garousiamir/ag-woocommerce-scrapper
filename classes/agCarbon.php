<?php
use Carbon_Fields\Container;
use Carbon_Fields\Field;

class agCarbon{

    public function __construct(){
        add_action( 'carbon_fields_register_fields', 'ag_crb_attach_theme_options' );
        add_action( 'after_setup_theme', 'ag_crb_load' );
    }

    public function ag_crb_attach_theme_options() {
        Container::make( 'theme_options', __( 'Theme Options' ) )
            ->add_fields( array(
    
                
    
            ) );
    }

    public function ag_crb_load() {
        \Carbon_Fields\Carbon_Fields::boot();
    }

}

if(is_admin()){
    $theme_options = new agCarbon();
}
  


