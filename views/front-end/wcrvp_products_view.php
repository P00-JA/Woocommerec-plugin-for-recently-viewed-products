<?php
/**
 *  @package woocommerce recently viewed products
 */

if (!defined("ABSPATH")) {
    exit();
}

if (!function_exists('wcrvp_products_view')) {
    /**
     * Display recently viewed products.
     *
     * @param int $col_num        Number of columns.
     * @param int $products_num   Number of products.
     * @return void
     */
    function wcrvp_products_view($col_num = 0, $products_num = 0)
    {
        // Check if disable checkbox is checked
        $wcrvp_settings = get_option('wcrvp_settings');

        if (isset($wcrvp_settings['wcrvp_disable_frontend']) && $wcrvp_settings['wcrvp_disable_frontend'] == 'disabled') {
            return; // Exit the function if disable checkbox is checked
        }

        // Creating new instance of class to obtain all the products
        $products = new Wcrvp();
        $products_ids = $products->wcrvp_get_products();

        if (!isset($products_ids) || empty($products_ids)) {
            return false;
        }

        if (count($products_ids) <= 0) {
            return false;
        }

        // Determine the number of products to display
        if (0 == $products_num) {
            $num_of_display_products = isset($wcrvp_settings['wcrvp_numb_products']) ? $wcrvp_settings['wcrvp_numb_products'] : 4;
        } else {
            $num_of_display_products = $products_num;
        }

        // Slice the product IDs array based on the number of products to display
        if (count($products_ids) > $num_of_display_products) {
            $ids = array_slice($products_ids, -1 * $num_of_display_products, $num_of_display_products, true);
        } else {
            $ids = $products_ids;
        }

        // Query products based on the sliced IDs
        $the_query = new WP_Query(array(
            "post_type" => "product",
            "post_status" => "publish",
            "post__in" => array_reverse($ids),
            "orderby" => 'post__in',
            "posts_per_page" => $num_of_display_products, // to limit the number of products
        ));

        if ($the_query->have_posts()) {
            // Display section and heading
            echo '<section class="products">';
            echo '<h2>' . esc_html(isset($wcrvp_settings['wcrvp_label']) ? $wcrvp_settings['wcrvp_label'] : '') . ' </h2>';

            // Determine the number of columns
            if (0 == $col_num) {
                $col = 4;
            } else {
                $col = $col_num;
            }

            // Display product list
            echo '<ul class="products columns-' . esc_attr($col) . '">';
            while ($the_query->have_posts()) {
                $the_query->the_post();
                wc_get_template_part('content', 'product'); // Check if the template part is loaded correctly
            }
            echo '</ul>';
            echo '</section>';
            wp_reset_postdata();
        } else {
            return false;
        }
    }
}


