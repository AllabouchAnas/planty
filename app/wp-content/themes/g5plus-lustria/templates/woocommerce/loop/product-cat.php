<?php
/**
 * Created by PhpStorm.
 * User: MyPC
 * Date: 07/08/2017
 * Time: 10:45 SA
 */
// show product category
$product_category_enable = G5Plus_Lustria()->options()->get_product_category_enable();
if ('on' == $product_category_enable) {
    $cat_name = '';
    $terms = wc_get_product_terms( get_the_ID(), 'product_cat', array( 'orderby' => 'parent', 'order' => 'DESC' ) );
    $cat_link = '';
    if ($terms) {
        $cat_link = get_term_link( $terms[0], 'product_cat' );
        $cat_name = $terms[0]->name;
    }
    if (!empty($cat_name)) {
        echo '<div class="product-cat"><a class="gsf-link" href="'. esc_url($cat_link).'" title="'. esc_attr($cat_name) .'">'. esc_html($cat_name) .'</a></div>';
    }
}