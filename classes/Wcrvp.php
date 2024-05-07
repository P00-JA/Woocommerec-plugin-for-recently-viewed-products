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
     * Handles session management for recently viewed products.
 */
    class Wcrvp{

        /**
         * Start session if not started already.
         */
        public function wcrvp_start_session(){
            if(! session_id()){
                session_start();
            }
        }

        /**
         * Create session name based on user login status.
         * 
         * @return string The session name.
         */
        public function wcrvp_session_name(){
            if(is_user_logged_in()){
                $user_id = get_current_user_id();
                $wcrvp_session_name = 'wcrvp_products_'.$user_id; 
            }else{
                $wcrvp_session_name = 'wcrvp_products_guest';
            }

            return $wcrvp_session_name;
        }

        /**
         * Initialize session for current user.
         */
        public function wcrvp_init_session(){
            $session_name = $this->wcrvp_session_name();

            if(!isset($_SESSION[$session_name])){
                $_SESSION[$session_name] = serialize(array());
            }
        }

        /**
         * Get current user session.
         * 
         * @return mixed Array of product IDs or false if session is not set.
         */
        public function wcrvp_get_products(){
            $session_name = $this->wcrvp_session_name();
            if(!isset($_SESSION[$session_name])){
                return false;
            }

            return unserialize($_SESSION[$session_name]);
        }

        /**
         * Update user session with recently viewed product.
         */
        public function wcrvp_update_products(){
            $session_name = $this->wcrvp_session_name();
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

            $_SESSION[$session_name] = serialize($viewed_products);
        }
    }
}


