<?php
class agGeneral {
    public function __construct() {
        add_action('admin_enqueue_scripts', array($this, 'ag_admin_styles'));
    }

    public function ag_admin_styles() {
        wp_enqueue_style('ag-admin-style', plugin_dir_url(dirname(__FILE__)) . 'assets/ag-admin-style.css');
    }
}
