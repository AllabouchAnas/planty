<?php
global $product;
$swatches_enable = G5Plus_Lustria()->options()->get_product_swatches_enable();
if('on' !== $swatches_enable || !$product || !$product->is_type( 'variable' )) {
    return;
}
$get_variations = count( $product->get_children() ) <= apply_filters(    'woocommerce_ajax_variation_threshold', 30, $product );
$attributes           =  $product->get_attributes();
$available_variations = $get_variations ? $product->get_available_variations() : false;//$product->get_available_variations();
$html_attributes = array('class="gf-swatches gf-swatches-wrap"');
if ( has_post_thumbnail() ) {
	$srcset = wp_get_attachment_image_srcset( get_post_thumbnail_id(), 'shop_catalog' );
	$sizes  = wp_get_attachment_image_sizes( get_post_thumbnail_id(), 'shop_catalog' );
	$html_attributes[] = sprintf('data-srcset="%s"',$srcset);
    $html_attributes[] = sprintf('data-sizes="%s"',$sizes);
    $html_attributes[] = sprintf('data-product_id="%s"',get_the_ID());

}
?>
<div <?php echo implode(' ',$html_attributes); ?>
	data-product_variations="<?php echo esc_attr( json_encode( $available_variations ) ) ?>">
	<?php
    $swatches_taxonomies = G5Plus_Lustria()->options()->get_product_swatches_taxonomies();
    $attribute_names = array_keys($attributes);
    $check = (bool)array_intersect($swatches_taxonomies, $attribute_names);
    $stop = false;
	foreach ( $attributes as $attribute_name => $options ) {
	    if((!$check && !$stop) || ($check && in_array($attribute_name, $swatches_taxonomies))) {
		    $attr_data = $options->get_data();
		    if ($attr_data['variation'] === false) {
			    continue;
		    }

            $attr_id = wc_attribute_taxonomy_id_by_name($attribute_name);
            $attribute_name = preg_replace("/%u([0-9a-f]{3,4})/i", "&#x\\1;", urldecode($attribute_name));
            $term_sanitized = html_entity_decode($attribute_name, null, 'UTF-8');
            if ($attr_id) {
                $attr_info = wc_get_attribute($attr_id);
                if ('select' !== $attr_info->type) {
                    //$stop = true;
                    $curr['style'] = $attr_info->type;
                    $curr['title'] = $attr_info->name;
                    if (taxonomy_exists($term_sanitized)) {
                        $curr['terms'] = wp_get_post_terms($product->get_id(), $term_sanitized, array('hide_empty' => false));
                    }
                    ?>
                    <div class="swatches-inner swatches-<?php echo esc_attr($curr['style']); ?>"
                         data-attribute="<?php echo esc_attr($attribute_name); ?>">
                        <?php
                        switch ($curr['style']) {
                            case 'text' :
                                foreach ($curr['terms'] as $l => $b) {
                                    $val = G5Plus_Lustria()->termMeta()->get_product_taxonomy_text($b->term_id);
                                    $val = !empty($val) ? $val : $b->name;
                                    $tooltip = $b->name;
                                    ?>
                                    <span class="swatches-item"
                                          data-toggle="tooltip"
                                          title="<?php echo esc_attr($tooltip); ?>"
                                          data-term="<?php echo esc_attr($b->slug); ?>"><?php echo esc_html($val); ?></span>
                                    <?php
                                }
                                break;
                            case 'color':
                                foreach ($curr['terms'] as $l => $b) {
                                    $val = G5Plus_Lustria()->termMeta()->get_product_taxonomy_color($b->term_id);
                                    $val = !empty($val) ? $val : '#fff';
                                    $tooltip = $b->name;
                                    ?>
                                    <span data-toggle="tooltip"
                                          class="swatches-item"
                                          title="<?php echo esc_attr($tooltip); ?>"
                                          data-term="<?php echo esc_attr($b->slug); ?>"
                                          style="color: <?php echo esc_attr($val); ?>"></span>
                                    <?php
                                }
                                break;
                            case 'image':
                                foreach ($curr['terms'] as $l => $b) {
                                    $val = G5Plus_Lustria()->termMeta()->get_product_taxonomy_image($b->term_id);
                                    $val = !empty($val['id']) ? wp_get_attachment_thumb_url($val['id']) : wc_placeholder_img_src();
                                    $tooltip = $b->name;
                                    ?>
                                    <span data-toggle="tooltip"
                                          class="swatches-item"
                                          title="<?php echo esc_attr($tooltip); ?>"
                                          data-term="<?php echo esc_attr($b->slug); ?>"
                                          style="background-image: url('<?php echo esc_url($val)?>')"></span>
                                    <?php
                                }
                                break;
                            default:
                                break;
                        }
                        ?>
                    </div>
                    <?php
                }
            }
        }
    }
    ?>
    <a class="reset_variations" href="#" style="display: none;"><?php esc_html_e('Clear', 'g5plus-lustria') ?></a>
</div>
