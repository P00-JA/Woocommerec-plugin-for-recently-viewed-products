<?php
/**
 *  @package woocommerce recently viewed products
 */

if (!defined("ABSPATH")) {
    exit();
}

if (!function_exists('wcrvp_activation')) {
    /**
     * Plugin activation function.
     * Checks and sets default settings upon activation.
     */
    function wcrvp_activation()
    {
        // Log activation event
        error_log("Activation function called");

        // Check if wcrvp_settings option not found
        if (!get_option('wcrvp_settings')) {
            // Set default options
            add_option('wcrvp_settings', array(
                'wcrvp_disable_frontend' => '',
                'wcrvp_label' => 'Recently Viewed Products',
                'wcrvp_numb_products' => 4,
                'wcrvp_position' => '',
                'wcrvp_in_shop_page' => '',
                'wcrvp_in_cart_page' => 'enabled',
            ));
        }
    }
}



