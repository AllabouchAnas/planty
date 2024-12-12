<?php
/**
 * Created by PhpStorm.
 * User: MyPC
 * Date: 07/08/2017
 * Time: 8:10 SA
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
$product_per_page = G5Plus_Lustria()->options()->get_woocommerce_customize_item_show();
if(!empty($product_per_page)) {
    $product_per_page_arr = explode(",", $product_per_page);
} else {
    $product_per_page_arr = array(intval(get_option( 'posts_per_page')));
}

$product_request = isset( $_GET['product_per_page'] ) ? wc_clean( $_GET['product_per_page'] ) : '';
$product_per_page = !empty($product_request) ? $product_request : $product_per_page_arr[0];
if(!empty($product_request) && !in_array($product_request, $product_per_page_arr)) {
    $product_per_page_arr[] = $product_request;
    sort($product_per_page_arr);
}

global $wp_query;
$cat 	  = $wp_query->get_queried_object();
$action   = ( isset( $cat->term_id ) ) ? get_term_link( $cat->term_id ) : esc_url_raw( get_pagenum_link() );

?>
<form class="woocommerce-page-size" method="get" action="<?php echo esc_url($action)?>">
    <select name="product_per_page" id="product_per_page" onchange="this.form.submit()">
        <?php foreach ( $product_per_page_arr as $number ) { ?>
            <option value="<?php echo esc_attr($number); ?>" <?php selected ( $number, $product_per_page ); ?>><?php printf('%s %s', esc_attr($number), esc_html__('items','g5plus-lustria')); ?></option>
        <?php } ?>
    </select>
    <?php
    // Keep query string vars intact
    foreach ( $_GET as $key => $val ) {
        if ( 'product_per_page' === $key || 'submit' === $key ) {
            continue;
        }
        if ( is_array( $val ) ) {
            foreach( $val as $innerVal ) {
                echo '<input type="hidden" name="' . esc_attr( $key ) . '[]" value="' . esc_attr( $innerVal ) . '" />';
            }
        } else {
            echo '<input type="hidden" name="' . esc_attr( $key ) . '" value="' . esc_attr( $val ) . '" />';
        }
    }
    ?>
</form>

