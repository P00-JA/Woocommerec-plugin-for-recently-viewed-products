<?php
/**
 *  @package woocommerce recently viewed products
 */

if (!defined("ABSPATH")) {
    exit();
}

if (!class_exists('Wcrvp_settings_page')) {
    /**
     * Class Wcrvp_settings_page
     * Handles the creation of settings page for recently viewed products.
     */
    class Wcrvp_settings_page
    {
        /**
         * Create the settings page.
         */
        public function wcrvp_create_settings_page()
        {
            // Add submenu for recently viewed items
            add_submenu_page(
                "woocommerce",
                __("Recently Viewed Products", "wcrvp-plugin"),
                __("Recently Viewed Products", "wcrvp-plugin"),
                "manage_options",
                "wcrvp_settings",
                array($this, 'wcrvp_settings_page_callback') // Updated callback to be a method of this class
            );
        }

        /**
         * Callback function for the settings page.
         * Includes the settings page view.
         */
        public function wcrvp_settings_page_callback()
        {
            // Include the settings page view
            include(WCRVP_PATH . '/views/admin/settings_page.php');
        }
    }
}


