<?php
/*
Plugin Name: Advanced Custom Fields: Child Category selector Field
Plugin URI: http://adroittechnosoft.com/acf-category-child-addon/
Description: Add a Child Category selector Field to Advanced Custom Fields. This field allows you to select the Child category whose children will show as values in the frontend.
Version: 1.0.0
Author: Adroit Technosoft
Author URI: http://adroittechnosoft.com
Text Domain: rkd-acf-child-category
License: GPL
*/

define( 'ACF_CHILD_CATEGORY_VERSION', '1.0.0' );

/**
 * load text domain
 */
add_action( 'plugins_loaded', 'rkd_acf_child_category_textdomain' );
function rkd_acf_child_category_textdomain() {
	load_plugin_textdomain( 'rkd-acf-child-category' );
}

class rkd_acf_field_parent_category_plugin {
    
    /*
     * __construct
     */
    function __construct() {
        add_action('acf/include_fields', array($this, 'include_fields'));
    }
	 
    /*
     * include_fields
     */
    function include_fields() {
        include_once 'fields.php';
    }

}

new rkd_acf_field_parent_category_plugin();
  