<?php
/*
 * Plugin Name: WooCommerce Recently Viewed Products
 * Description: This is a WOOCOMMERCE plugin for recently viewed Products.
 * Plugin URI: https://example.com/wc-recently-viewed-products
 * Author: Pooja M P
 * Author URI: https://example.com 
 * Version: 1.0
 * Requires at least: 6.5.2
 * Requires PHP: 7.4
 * Text Domain: wcrvp-plugin
 * Domain Path: /languages
 */

 // If this file is called directly, abort.
 if (!defined("ABSPATH")) {
    exit();
}

/*=========================================
check wordpress version
==========================================*/

if (version_compare(get_bloginfo('version'), '6.5.2', '<')) {
    $message = "Not compatible with this version of WordPress, use WordPress 6.5.2 or higher";
    die($message);
}

/**
 * CONSTANTS
 */

define('WCRVP_PATH', plugin_dir_path(__FILE__));
define('WCRVP_URI', plugin_dir_url(__FILE__));


/**
 * Check if WooCommerce enabled
 */

if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
    // Yes, WooCommerce is enabled
    if (!class_exists('WCRVP_core')) {
        class WCRVP_core
        {
            public function __construct()
            {
                //include files
                //require(WCRVP_PATH . '/views/admin/settings_page.php');
                require(WCRVP_PATH . '/views/front-end/wcrvp_products_view.php');
                require(WCRVP_PATH . '/includes/activation.php');
                
                //include classes
                require(WCRVP_PATH . '/classes/Wcrvp_settings_page.php');
                require(WCRVP_PATH . '/classes/Wcrvp_save_settings.php');
                require(WCRVP_PATH . '/classes/Wcrvp.php');
                require(WCRVP_PATH . '/classes/Wcrvp_view.php');
                //hook
                register_activation_hook(__FILE__, 'wcrvp_activation');
                add_action('init', array(new Wcrvp(), 'wcrvp_start_session'), 10);
                add_action('init', array(new Wcrvp(), 'wcrvp_init_session'), 15);
                add_action('wp', array(new Wcrvp(), 'wcrvp_update_products'));

                add_action('admin_menu', array(new Wcrvp_settings_page(), 'wcrvp_create_settings_page'));
                add_action('admin_post_wcrvp_save_settings_fields', array(new Wcrvp_save_settings(), 'wcrvp_save_admin_field_settings'));
                add_action('woocommerce_after_single_product_summary',array(new Wcrvp_view(),'wcrvp_show_after_related_products'),21);
                add_action('woocommerce_after_single_product_summary',array(new Wcrvp_view(),'wcrvp_show_before_related_products'),19);
                add_action( 'woocommerce_after_shop_loop', array(new Wcrvp_view(),'wcrvp_show_in_shop_page'),15 );
                add_action( 'woocommerce_cart_collaterals', array(new Wcrvp_view(),'wcrvp_show_in_cart_page'),20 );

                
                //shortcode
            }
        }

        $WCRVP_core = new WCRVP_core();
    }
} else {
    // WooCommerce is NOT enabled!
}


/*
* Display the recently viewed products after the single product summary.
*/
/* function products_position(){
 wcrvp_products_view(); // Fixed the function call
}
add_action('woocommerce_after_single_product_summary','products_position',21); */







