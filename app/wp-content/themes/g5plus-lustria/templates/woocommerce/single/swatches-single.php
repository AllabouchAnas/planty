<?php
global $product;
$swatches_enable = G5Plus_Lustria()->options()->get_product_single_swatches_enable();
if('on' !== $swatches_enable) return;
wp_enqueue_script( 'wc-add-to-cart-variation' );
$get_variations = count( $product->get_children() ) <= apply_filters(    'woocommerce_ajax_variation_threshold', 30, $product );

$attributes           =  $product->get_attributes();
$available_variations = $get_variations ? $product->get_available_variations() : false;//$product->get_available_variations();
$variation_attributes = $product->get_variation_attributes();
$selected_attributes  = $product->get_default_attributes();//$product->get_default_attributes();
do_action( 'woocommerce_before_add_to_cart_form' ); ?>
<form class="gf-swatches gf-swatches-single-wrap variations_form cart"
	method="post"
	enctype="multipart/form-data"
	data-product_id="<?php echo esc_attr(absint( get_the_ID() )); ?>"
	data-product_variations="<?php echo esc_attr( json_encode( $available_variations ) ) ?>">
	<?php
	do_action( 'woocommerce_before_variations_form' );
	if ( empty( $available_variations ) && false !== $available_variations ) {
		?>
		<p class="stock out-of-stock"><?php esc_html__( 'This product is currently out of stock and unavailable.', 'g5plus-lustria' ) ?></p>
	<?php } else {
		?>
		<table class="variations" cellspacing="0">
			<tbody>
			<?php
			foreach ( $attributes as $attribute_name => $options ) {

				$attr_data = $options->get_data();

				if ($attr_data['variation'] === false) {
					continue;
				}
                $attr_id = wc_attribute_taxonomy_id_by_name($attribute_name);
                $attribute_name = preg_replace("/%u([0-9a-f]{3,4})/i", "&#x\\1;", urldecode($attribute_name));
                if ($attr_id) {
                    $term_sanitized = html_entity_decode($attribute_name, null, 'UTF-8');
                    $attr_info = wc_get_attribute($attr_id);


                    $curr['type'] = isset($attr_info->type) ? $attr_info->type : 'select';
                    $curr['slug'] = isset($attr_info->slug) ? $attr_info->slug : '';
                    $curr['name'] = isset($attr_info->name) ? $attr_info->name : '';
                    if (taxonomy_exists($term_sanitized)) {
                        $curr['terms'] = wp_get_post_terms($product->get_id(), $term_sanitized, array('hide_empty' => false));
                    }
                    ?>
                    <tr>
                        <td class="label">
                            <label for="<?php echo esc_attr($curr['slug']); ?>">
                                <span><?php echo esc_html($curr['name'] ? $curr['name'] : wc_attribute_label($attribute_name)); ?></span>
                            </label>
                        </td>
                        <td class="value">
                            <?php if (($curr['type'] != '') && ($curr['type'] != 'select')) { ?>
                                <div class="swatches-inner swatches-<?php echo esc_attr($curr['type']); ?>"
                                     data-attribute="<?php echo esc_attr($attribute_name); ?>">
                                    <?php
                                    switch ($curr['type']) {
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
                                            if (isset($_REQUEST['attribute_' . sanitize_title($attribute_name)])) {
                                                $selected = $_REQUEST['attribute_' . sanitize_title($attribute_name)];
                                            } else if (isset($selected_attributes[sanitize_title($attribute_name)])) {
                                                $selected = $selected_attributes[sanitize_title($attribute_name)];
                                            } else {
                                                $selected = '';
                                            }
                                            $attribute_name = $attr_data['name'];
                                            $args = array(
                                                'options' => $variation_attributes[$attribute_name],
                                                'attribute' => $attribute_name,
                                                'product' => $product,
                                                'selected' => $selected,
                                                'class' => 'swatches-dropdown-select',
                                                'show_option_none' => false
                                            );
                                            wc_dropdown_variation_attribute_options($args);
                                            break;
                                    }
                                    ?>
                                </div>
                            <?php } ?>
                            <?php
                            if (isset($_REQUEST['attribute_' . sanitize_title($attribute_name)])) {
                                $selected = $_REQUEST['attribute_' . sanitize_title($attribute_name)];
                            } else if (isset($selected_attributes[sanitize_title($attribute_name)])) {
                                $selected = $selected_attributes[sanitize_title($attribute_name)];
                            } else {
                                $selected = '';
                            }
                            if (!$attr_info) {
                                $attribute_name = $attr_data['name'];
                            }
                            $args = array(
                                'options' => $variation_attributes[$attribute_name],
                                'attribute' => $attribute_name,
                                'product' => $product,
                                'selected' => $selected,
                                'class' => 'swatches-dropdown-' . $curr['type']
                            );
                            wc_dropdown_variation_attribute_options($args);
                            ?>
                            <a class="reset_variations reset_variations--single"
                               href="#"><?php esc_html_e('Clear', 'g5plus-lustria'); ?></a>
                        </td>
                    </tr>
                    <?php
                } else { ?>
                    <tr>
                        <td class="label">
                            <label for="<?php echo esc_attr($attribute_name); ?>">
                                <span><?php echo wc_attribute_label($attribute_name); ?></span>
                            </label>
                        </td>
                        <td class="value">
                            <div class="swatches-inner swatches-text"
                                 data-attribute="<?php echo esc_attr($attribute_name); ?>">
                                <?php
                                foreach ($options->get_options() as $option) :?>
                                    <span class="swatches-item"
                                          data-term="<?php echo esc_attr($option); ?>"><?php echo esc_attr($option); ?></span>
                                <?php endforeach; ?>
                            </div>
                            <?php
                            if (isset($_REQUEST['attribute_' . sanitize_title($attribute_name)])) {
                                $selected = $_REQUEST['attribute_' . sanitize_title($attribute_name)];
                            } else if (isset($selected_attributes[sanitize_title($attribute_name)])) {
                                $selected = $selected_attributes[sanitize_title($attribute_name)];
                            } else {
                                $selected = '';
                            }
                            $attribute_name = $attr_data['name'];
                            $args = array(
                                'options' => $variation_attributes[$attribute_name],
                                'attribute' => $attribute_name,
                                'product' => $product,
                                'selected' => $selected,
                                'class' => 'swatches-dropdown-text'
                            );
                            wc_dropdown_variation_attribute_options($args);
                            ?>
                            <a class="reset_variations reset_variations--single"
                               href="#"><?php esc_html_e('Clear', 'g5plus-lustria'); ?></a>
                        </td>
                    </tr>
                    <?php
                }
            }
			?>
			</tbody>
		</table>

		<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

		<div class="single_variation_wrap">
			<?php
			/**
			 * woocommerce_before_single_variation Hook
			 */
			do_action( 'woocommerce_before_single_variation' );

			/**
			 * woocommerce_single_variation hook. Used to output the cart button and placeholder for variation data.
			 *
			 * @since  2.4.0
			 * @hooked woocommerce_single_variation - 10 Empty div for variation data.
			 * @hooked woocommerce_single_variation_add_to_cart_button - 20 Qty and cart button.
			 */
			do_action( 'woocommerce_single_variation' );

			/**
			 * woocommerce_after_single_variation Hook
			 */
			do_action( 'woocommerce_after_single_variation' );
			?>
		</div>

	<?php } ?>

	<?php do_action( 'woocommerce_after_variations_form' ); ?>

</form>

<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>
