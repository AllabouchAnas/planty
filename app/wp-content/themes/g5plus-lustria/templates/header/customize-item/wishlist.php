<?php
/**
 * @var $customize_location
 */
if (!(defined( 'YITH_WCWL' ) && function_exists('yith_wcwl_object_id'))) {
    return;
}
$wishlist_href = '#';
$wishlist_page_id = yith_wcwl_object_id( get_option( 'yith_wcwl_wishlist_page_id' ) );
if(!empty($wishlist_page_id)) {
    $wishlist_href = get_the_permalink($wishlist_page_id);
}
$count = 0;
if( defined( 'YITH_WCWL' ) && function_exists( 'yith_wcwl_count_all_products' ) ) {
    $count = yith_wcwl_count_all_products();
}
?>
<a href="<?php echo esc_url($wishlist_href) ?>" title="<?php esc_attr_e('Wishlist', 'g5plus-lustria') ?>" class="gsf-link transition03">
    <i class="far fa-heart"></i><span class="wishlist-count"><?php echo esc_html($count); ?></span>
</a>