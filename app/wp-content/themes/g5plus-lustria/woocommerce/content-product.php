<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 * @var $image_size
 * @var $post_class
 * @var $post_inner_class
 * @var $placeholder_enable
 */

defined( 'ABSPATH' ) || exit;

global $product;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}

if (!isset($post_class)) {
    $post_class = G5Plus_Lustria()->woocommerce()->get_product_class();
}

if (!isset($post_inner_class)) {
    $post_inner_class = G5Plus_Lustria()->woocommerce()->get_product_inner_class();
}

if (!isset($image_size)) {
    $image_size = 'shop_catalog';
}

if (!isset($placeholder_enable)) {
    $placeholder_enable = true;
}

?>
<article <?php wc_product_class($post_class,$product) ?>>
    <div class="<?php echo esc_attr($post_inner_class); ?>">
        <?php
        /**
         * woocommerce_before_shop_loop_item hook.
         *
         * @hooked woocommerce_template_loop_product_link_open - 10
         */
        do_action('woocommerce_before_shop_loop_item');
        ?>
        <div class="product-thumb">
            <?php
            G5Plus_Lustria()->woocommerce()->render_product_thumbnail_markup(array(
                'image_size' => $image_size,
                'image_ratio' => '',
                'placeholder_enable' => $placeholder_enable
            ));
            ?>

            <?php

            /**
             * woocommerce_before_shop_loop_item_title hook.
             *
             * @hooked shop_loop_sale_count_down - 10
             * @hooked woocommerce_show_product_loop_sale_flash - 10
             */
            do_action('woocommerce_before_shop_loop_item_title');

            ?>
            <?php
            $rtl = is_rtl() || G5Plus_Lustria()->options()->get_rtl_enable() === 'on' || isset($_GET['RTL']);
            $tooltip_options = $rtl ? array('placement' => 'right') : array('placement' => 'left'); ?>
            <div class="product-actions gf-tooltip-wrap"
                 data-tooltip-options='<?php echo esc_attr(json_encode($tooltip_options)); ?>'>
                <?php
                /**
                 * g5plus_woocommerce_product_action hook
                 *
                 * @hooked shop_loop_grid_add_to_cart - 5
                 * @hooked shop_loop_wishlist - 10
                 * @hooked shop_loop_quick_view - 15
                 * @hooked shop_loop_compare - 20
                 */
                do_action('g5plus_woocommerce_product_actions');
                ?>
            </div>

        </div>
        <div class="product-info">
            <?php
            /**
             * woocommerce_shop_loop_item_title hook.
             *
             * @hooked shop_loop_product_cat - 10
             * @hooked shop_loop_product_title - 15
             */

            do_action('woocommerce_shop_loop_item_title');

            /**
             * woocommerce_after_shop_loop_item_title hook.
             *
             * @hooked woocommerce_template_loop_price - 10
             * @hooked woocommerce_template_loop_rating - 15
             * @hooked shop_swatches_loop - 20
             */
            do_action('woocommerce_after_shop_loop_item_title');
            ?>
        </div>
        <?php
        /**
         * woocommerce_after_shop_loop_item hook.
         *
         * @hooked woocommerce_template_loop_product_link_close - 5
         */
        do_action('woocommerce_after_shop_loop_item');
        ?>
    </div>
</article>

