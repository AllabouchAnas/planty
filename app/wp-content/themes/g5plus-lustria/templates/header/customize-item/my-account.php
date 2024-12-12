<?php
/**
 * @var $customize_location
 */
if (!class_exists('WooCommerce')) {
    return;
}
add_action('g5plus_after_page_wrapper', array(G5Plus_Lustria()->templates(),'login_register_popup'));
?>
<a href="<?php echo esc_url(get_permalink(get_option('woocommerce_myaccount_page_id'))); ?>" class="gsf-link transition03"
   title="<?php esc_attr_e('My Account', 'g5plus-lustria'); ?>"><i class="far fa-user"></i></a>