<?php
/**
 *  @package woocommerce recently viewed products
 */

if (!defined("ABSPATH")) {
    exit();
}

if (!class_exists('Wcrvp_save_settings')) {
    /**
     * Class Wcrvp_save_settings
     * Handles saving of admin field settings for recently viewed products.
     */
    class Wcrvp_save_settings
    {
        /**
         * Save the admin field settings.
         */
        public function wcrvp_save_admin_field_settings()
        {
            // Verify nonce
            check_admin_referer('wcrvp_save_settings_fields_verify');

            // Check user capability
            if (!current_user_can('manage_options')) {
                wp_die('You are not allowed to edit settings.');
            }

            // Sanitize and retrieve POST data
            $wcrvp_disable_frontend = isset($_POST['wcrvp_disable_frontend']) ? 'disabled' : '';
            $wcrvp_label = sanitize_text_field($_POST['wcrvp_label']);
            $wcrvp_numb_products = absint($_POST['wcrvp_numb_products']);
            $wcrvp_position = in_array($_POST['wcrvp_position'], array('before_related_products', 'after_related_products')) ? $_POST['wcrvp_position'] : '';
            $wcrvp_in_shop_page = isset($_POST['wcrvp_in_shop_page']) ? 'enabled' : '';
            $wcrvp_in_cart_page = isset($_POST['wcrvp_in_cart_page']) ? 'enabled' : '';

            // Construct the array of settings values
            $values = array(
                'wcrvp_disable_frontend' => $wcrvp_disable_frontend,
                'wcrvp_label' => $wcrvp_label,
                'wcrvp_numb_products' => $wcrvp_numb_products,
                'wcrvp_position' => $wcrvp_position,
                'wcrvp_in_shop_page' => $wcrvp_in_shop_page,
                'wcrvp_in_cart_page' => $wcrvp_in_cart_page,
            );

            // Check if the label field is empty
            if (!isset($wcrvp_label) || empty($wcrvp_label || '' == $wcrvp_label)) {
                // Redirect with error message
                wp_redirect(get_admin_url().'admin.php?page=wcrvp_settings&serror='.urlencode('Settings failed'));
                exit();
            }

            // Update option with the settings values
            update_option('wcrvp_settings', $values);

            // Redirect with success message
            wp_redirect(get_admin_url().'admin.php?page=wcrvp_settings&success='.urlencode('Settings saved'));
            exit();
        }
    }
}
