<?php
if (!class_exists('Wcrvp_view')) {
    /**
     * Class Wcrvp_view
     * Handles displaying recently viewed products before or after related products.
     */
    class Wcrvp_view
    {
        /**
         * Display recently viewed products after related products.
         */
        public function wcrvp_show_after_related_products()
        {
            $wcrvp_settings = get_option('wcrvp_settings');

            // Check if the setting for the position of recently viewed products is set to after related products
            if (!isset($wcrvp_settings['wcrvp_position']) || ("after_related_products" !== $wcrvp_settings['wcrvp_position'])) {
                return; // If not, exit the function
            }
            
            // Display recently viewed products
            return wcrvp_products_view();
        }

        /**
         * Display recently viewed products before related products.
         */
        public function wcrvp_show_before_related_products()
        {
            $wcrvp_settings = get_option('wcrvp_settings');

            // Check if the setting for the position of recently viewed products is set to before related products
            if (!isset($wcrvp_settings['wcrvp_position']) || ("before_related_products" !== $wcrvp_settings['wcrvp_position'])) {
                return; // If not, exit the function
            }

            // Display recently viewed products
            return wcrvp_products_view();
        }

        public function wcrvp_show_in_shop_page(){
            $wcrvp_settings = get_option('wcrvp_settings');
            // Check if the setting to show in shop page of recently viewed products is enabled
            if (!isset($wcrvp_settings['wcrvp_in_shop_page']) || ("enabled" !== $wcrvp_settings['wcrvp_in_shop_page'])) {
                return; // If not, exit the function
            }
            // Display recently viewed products
            return wcrvp_products_view();
            
        }


        public function wcrvp_show_in_cart_page(){
            $wcrvp_settings = get_option('wcrvp_settings');
            // Check if the setting to show in shop page of recently viewed products is enabled
            if (!isset($wcrvp_settings['wcrvp_in_cart_page']) || ("enabled" !== $wcrvp_settings['wcrvp_in_cart_page'])) {
                return; // If not, exit the function
            }
            // Display recently viewed products
            return wcrvp_products_view();
            
        }
    }
}




