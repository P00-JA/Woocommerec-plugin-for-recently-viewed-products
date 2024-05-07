<?php
/**
 *  @package woocommerce recently viewed products
 */

if (!defined("ABSPATH")) {
    exit();
}

?>
    <div class="wrap">
        <h1><?php echo esc_html__('WooCommerce Recently Viewed Products', 'wcrvp-plugin'); ?></h1>
        <?php
        if (isset($_GET['success'])) {
            ?>
            <div class="notice notice-success is-dismissible">
                <p><?php echo esc_html(urldecode($_GET['success'])); ?></p>
            </div>
            <?php
        }
        if (isset($_GET['error'])) {
            ?>
            <div class="notice notice-error is-dismissible">
                <p><?php echo esc_html(urldecode($_GET['error'])); ?></p>
            </div>
            <?php
        }
        ?>
        <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
            <input type="hidden" name="action" value="wcrvp_save_settings_fields">
            <?php wp_nonce_field('wcrvp_save_settings_fields_verify'); ?>
            <?php
            $settings = get_option('wcrvp_settings', array());
            ?>
            <table class="form-table">
                <tbody>
                <tr>
                        <th scope="row">
                            <label for="wcrvp_label">
                                <?php echo esc_html__('Recently Viewed Products Label', 'wcrvp-plugin'); ?>
                            </label>
                        </th>
                        <td>
                            <input type="text" id="wcrvp_label" name="wcrvp_label" value="<?php echo esc_attr(isset($settings['wcrvp_label']) ? $settings['wcrvp_label'] : ''); ?>" required>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="wcrvp_numb_products">
                                <?php echo esc_html__('Recently Viewed Products Count', 'wcrvp-plugin'); ?>
                            </label>
                        </th>
                        <td>
                            <input type="number" id="wcrvp_numb_products" name="wcrvp_numb_products" value="<?php echo esc_attr(isset($settings['wcrvp_numb_products']) ? $settings['wcrvp_numb_products'] : ''); ?>" required>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="wcrvp_position">
                                <?php echo esc_html__('Recently Viewed Products Position in Products Page', 'wcrvp-plugin'); ?>
                            </label>
                        </th>
                        <td>
                            <input <?php if(!isset($settings['wcrvp_position']) || 'after_related_products' == $settings['wcrvp_position']){ echo 'checked' ;} ?> type="radio" id="wcrvp_position_after" name="wcrvp_position" value="after_related_products" >
                            <label for="wcrvp_position_after"><?php echo esc_html__('After Related Products', 'wcrvp-plugin'); ?></label><br>
                            <input <?php if(isset($settings['wcrvp_position']) && 'before_related_products' == $settings['wcrvp_position']){ echo 'checked' ;} ?> type="radio" id="wcrvp_position_before" name="wcrvp_position" value="before_related_products" >
                            <label for="wcrvp_position_before"><?php echo esc_html__('Before Related Products', 'wcrvp-plugin'); ?></label>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="wcrvp_in_shop_page">
                                <?php echo esc_html__('Show Recently Viewed Products in Shop Page', 'wcrvp-plugin'); ?>
                            </label>
                        </th>
                        <td>
                            <input <?php if(isset($settings['wcrvp_in_shop_page']) && 'enabled' == $settings['wcrvp_in_shop_page']){ echo 'checked' ;} ?> type="checkbox" id="wcrvp_in_shop_page" name="wcrvp_in_shop_page" value="enabled">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="wcrvp_in_cart_page">
                                <?php echo esc_html__('Show Recently Viewed Products in Cart Page', 'wcrvp-plugin'); ?>
                            </label>
                        </th>
                        <td>
                            <input <?php if(isset($settings['wcrvp_in_cart_page']) && 'enabled' == $settings['wcrvp_in_cart_page']){ echo 'checked' ;} ?> type="checkbox" id="wcrvp_in_cart_page" name="wcrvp_in_cart_page" value="enabled" >
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="wcrvp_disable_frontend">
                                <?php echo esc_html__('Hide recently viewed products from page', 'wcrvp-plugin'); ?>
                            </label>
                        </th>
                        <td>
                        <input <?php if(isset($settings['wcrvp_disable_frontend']) && 'disabled' == $settings['wcrvp_disable_frontend']){ echo 'checked' ;} ?> type="checkbox" id="wcrvp_disable_frontend" name="wcrvp_disable_frontend" value="disabled" >
                        </td>
                    </tr>
                </tbody>
            </table>
            <?php submit_button(__('Save Changes', 'wcrvp-plugin')); ?>
        </form>
    </div>
<?php







