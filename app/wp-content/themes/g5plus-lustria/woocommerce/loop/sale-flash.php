<?php
/**
 * Product loop sale flash
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/sale-flash.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see 	    http://docs.woothemes.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $product;
// product sale label

echo '<div class="product-flash-wrap">';
$product_sale_label_enable = G5Plus_Lustria()->options()->get_product_sale_label_enable();
if ($product->is_on_sale() && $product->get_type() != 'grouped' && 'on' === $product_sale_label_enable) {
	$product_sale_flash_mode = G5Plus_Lustria()->options()->get_product_sale_flash_mode();
	if ($product_sale_flash_mode == 'text') {
		$product_sale_label_text = G5Plus_Lustria()->options()->get_product_sale_label_text();
	} else {
		if ($product->get_type() == 'variable') {
			$sale_percent = 0;
			$available_variations = $product->get_available_variations();
			for ($i = 0; $i < count($available_variations); ++$i) {
				$variation_id = $available_variations[$i]['variation_id'];
				$variable_product = new WC_Product_Variation( $variation_id );
				$regular_price = $variable_product->get_regular_price();
				$sales_price = $variable_product->get_sale_price();
				$price = $variable_product->get_price();
				if ( $sales_price != $regular_price && $sales_price == $price ) {
					$percentage= round((( ( $regular_price - $sales_price ) / $regular_price ) * 100));
					if ($percentage > $sale_percent) {
						$sale_percent = $percentage;
					}
				}
			}
			$percentage = $sale_percent;
		} else {
			$percentage = round((( ( $product->get_regular_price() - $product->get_sale_price() ) / $product->get_regular_price() ) * 100));
		}
		if ($percentage > 0) {
			$product_sale_label_text = '-'.$percentage.'%';
		}
	}
	if (!empty($product_sale_label_text)) {
		echo apply_filters( 'woocommerce_sale_flash', '<span class="on-sale product-flash">' . $product_sale_label_text . '</span>', $post, $product );
	}
}
// product featured label
$product_featured_label_enable = G5Plus_Lustria()->options()->get_product_featured_label_enable();
if ($product->is_featured() && 'on' === $product_featured_label_enable) {
	$product_featured_label_text = G5Plus_Lustria()->options()->get_product_featured_label_text();
	echo apply_filters( 'g5plus_woocommerce_featured_flash', '<span class="on-featured product-flash">' . $product_featured_label_text . '</span>', $post, $product );
}

// product new label
$product_new_label_enable = G5Plus_Lustria()->options()->get_product_new_label_enable();
if ('on' === $product_new_label_enable) {
    $product_new_label_since = G5Plus_Lustria()->options()->get_product_new_label_since();
    $diff = date_diff(wc_string_to_datetime(get_post_time('Y/m/d g:i')), wc_string_to_datetime(current_time( 'Y/m/d g:i' )));
    if($diff->days <= intval($product_new_label_since)) {
        $product_new_label_text = G5Plus_Lustria()->options()->get_product_new_label_text();
        echo apply_filters( 'g5plus_woocommerce_new_flash', '<span class="on-new product-flash">' . $product_new_label_text . '</span>', $post, $product );
    }
}
echo '</div>';