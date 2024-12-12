<?php
/**
 * The template for displaying sale count down
 *
 * @var $is_single
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
$product_sale_count_down_enable = G5Plus_Lustria()->options()->get_product_sale_count_down_enable();
if (!$product_sale_count_down_enable) {
    return;
}
global $post, $product;
$sales_price_to = '';
if ($product->is_on_sale() && $product->get_type() != 'grouped') {
    if ($product->get_type() == 'variable') {
        $available_variations = $product->get_available_variations();
        $arr_count = count($available_variations);
        for ($i = 0; $i < $arr_count; ++$i) {
            $sales_price_to_temp = '';
            $variation_id = $available_variations[$i]['variation_id'];
            $variable_product = new WC_Product_Variation( $variation_id );
            $regular_price = $variable_product->get_regular_price();
            $sales_price = $variable_product->get_sale_price();
            $price = $variable_product->get_price();
            if ( $sales_price != $regular_price && $sales_price == $price ) {
                $sales_price_to_temp = $variable_product->get_date_on_sale_to() ? $variable_product->get_date_on_sale_to()->getOffsetTimestamp() : '';
                if (isset($sales_price_to_temp) && !empty($sales_price_to_temp) && ($sales_price_to_temp > $sales_price_to)) {
                    $sales_price_to = $sales_price_to_temp;
                }
            }
        }
    } else {
        $sales_price_to = $product->get_date_on_sale_to() ? $product->get_date_on_sale_to()->getOffsetTimestamp() : '';
    }
}

if ( !empty($sales_price_to)) {

    $sales_price_to = date("Y/m/d", $sales_price_to);
    ?>
    <div class="product-deal-countdown" data-date-end="<?php echo esc_attr($sales_price_to); ?>">
        <?php if($is_single): ?>
            <span class="deal-heading"><?php esc_html_e('Time remaining for sale', 'g5plus-lustria'); ?></span>
        <?php endif; ?>
        <div class="product-deal-countdown-inner">
            <div class="countdown-section">
                <span class="countdown-amount countdown-day"></span>
                <span class="countdown-period s-font"><?php esc_html_e('DAY','g5plus-lustria'); ?></span>
            </div>
            <div class="countdown-section">
                <span class="countdown-amount countdown-hours"></span>
                <span class="countdown-period s-font"><?php esc_html_e('HOUR','g5plus-lustria'); ?></span>
            </div>
            <div class="countdown-section">
                <span class="countdown-amount countdown-minutes"></span>
                <span class="countdown-period s-font"><?php esc_html_e('MIN','g5plus-lustria'); ?></span>
            </div>
            <div class="countdown-section">
                <span class="countdown-amount countdown-seconds"></span>
                <span class="countdown-period s-font"><?php esc_html_e('SEC','g5plus-lustria'); ?></span>
            </div>
        </div>
    </div>
    <?php
}