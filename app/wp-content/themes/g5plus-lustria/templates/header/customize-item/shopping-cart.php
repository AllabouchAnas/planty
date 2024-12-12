<?php
/**
 * @var $customize_location
 */
if (!class_exists('WooCommerce')) {
    return;
}
?>
<div class="header-customize-item item-shopping-cart fold-out hover woocommerce">
    <div class="widget_shopping_cart_content">
        <?php wc_get_template('cart/mini-cart.php'); ?>
    </div>
</div>