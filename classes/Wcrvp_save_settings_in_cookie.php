<?php
/**
 *  @package woocommerce recently viewed products
 */

if (!defined("ABSPATH")) {
    exit();
}

if (!class_exists('Wcrvp')){
    /**
     * Class Wcrvp
     * Handles cookie management for recently viewed products.
     */
    class Wcrvp{

        /**
         * Create cookie name based on user login status.
         * 
         * @return string The cookie name.
         */
        public function wcrvp_cookie_name(){
            if(is_user_logged_in()){
                $user_id = get_current_user_id();
                $wcrvp_cookie_name = 'wcrvp_products_'.$user_id; 
            }else{
                $wcrvp_cookie_name = 'wcrvp_products_guest';
            }

            return $wcrvp_cookie_name;
        }

        /**
         * Initialize cookie for current user.
         */
        public function wcrvp_init_cookie(){
            $cookie_name = $this->wcrvp_cookie_name();

            if(!isset($_COOKIE[$cookie_name])){
                setcookie($cookie_name, serialize(array()), time() + (30 * 24 * 60 * 60), '/'); // 30 days expiration
            }
        }

        /**
         * Get current user cookie.
         * 
         * @return mixed Array of product IDs or false if cookie is not set.
         */
        public function wcrvp_get_products(){
            $cookie_name = $this->wcrvp_cookie_name();
            if(!isset($_COOKIE[$cookie_name])){
                return false;
            }

            return unserialize($_COOKIE[$cookie_name]);
        }

        /**
         * Update user cookie with recently viewed product.
         */
        public function wcrvp_update_products(){
            $cookie_name = $this->wcrvp_cookie_name();
            // If not in single product page return false
            if(!is_product()){
                return false;
            }
            // Id of already viewed products
            $viewed_products = $this->wcrvp_get_products();

            // Checks if the product is already viewed, if not, add it to the array
            if(!in_array(get_the_id(), $viewed_products)){
                $viewed_products[] = get_the_id();
            }else{
                // Search the product id in the viewed products array
                $current_product_key = array_search(get_the_id(), $viewed_products);
                unset($viewed_products[$current_product_key]);
                $viewed_products[] = get_the_id();
            }

            setcookie($cookie_name, serialize($viewed_products), time() + (30 * 24 * 60 * 60), '/'); // 30 days expiration
        }
    }
}
