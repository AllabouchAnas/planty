<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

/**
 * @var $element UBE_Element_Lustria_Product_Singular
 */

$atts = $element->get_settings();
$wrap_class = array(
	'gsf-product-singular',
);
$product_id = $atts['id'];
if ($product_id === '') {return;}
global $product;
$product = wc_get_product( $product_id );
if (!is_a($product,'WC_Product')){
	return;
}
$element->add_render_attribute('product_attr', 'class', $wrap_class);
?>
<div <?php $element->print_render_attribute_string('product_attr') ?>>
	<?php if( !empty($atts['title'])): ?>
		<p class="singular-product-featured-title"><?php echo wp_kses_post($atts['title'])?></p>
	<?php endif; ?>
	<h2 class="singular-product-title"><a href="<?php echo esc_url(get_the_permalink($product_id)) ?>" title="<?php echo esc_attr($product->get_title()); ?>" class="gsf-link transition03"><?php echo esc_html($product->get_title()); ?></a></h2>
	<?php if(count($product->get_category_ids())) {
		echo wc_get_product_category_list($product->get_id(), ', ', '<span class="singular-product-categories">', '</span>');
	}?>
	<div class="singular-product-description">
		<?php echo wp_kses_post($product->get_short_description()); ?>
	</div>
	<p class="price"><?php echo $product->get_price_html(); ?></p>
	<div class="singular-product-actions">
		<?php do_action('gsf_product_singular_actions'); ?>
	</div>
</div>
