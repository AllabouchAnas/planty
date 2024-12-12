<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $product_id
 * @var $featured_title
 * @var $css_animation
 * @var $animation_duration
 * @var $animation_delay
 * @var $el_class
 * @var $css
 * @var $responsive
 * Shortcode class
 * @var $this WPBakeryShortCode_GSF_Product_Singular
 */
$product_id = $featured_title = $css_animation = $animation_duration = $animation_delay = $el_class = $css = $responsive = '';
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);

$wrapper_classes = array(
	'gsf-product-singular',
	G5P()->core()->vc()->customize()->getExtraClass($el_class),
	$this->getCSSAnimation($css_animation),
	vc_shortcode_custom_css_class($css),
	$responsive
);

if ('' !== $css_animation && 'none' !== $css_animation) {
	$animation_class = G5P()->core()->vc()->customize()->get_animation_class($animation_duration, $animation_delay);
	$wrapper_classes[] = $animation_class;
}
if (empty($product_id)) return;
global $product;
$product = wc_get_product($product_id);
$wrapper_class = implode(' ', array_filter($wrapper_classes));


?>
<div class="<?php echo esc_attr($wrapper_class) ?>">
	<?php if (!empty($featured_title)): ?>
        <p class="singular-product-featured-title"><?php echo esc_attr($featured_title) ?></p>
	<?php endif; ?>
    <h2 class="singular-product-title"><?php echo esc_attr($product->get_title()); ?></h2>
	<?php if (count($product->get_category_ids())) {
		echo wc_get_product_category_list($product->get_id(), ', ', '<span class="singular-product-categories">', '</span>');
	} ?>
    <div class="singular-product-description">
		<?php echo esc_attr(get_the_excerpt($product->get_id())); ?>
    </div>
    <p class="price"><?php echo $product->get_price_html(); ?></p>
    <div class="singular-product-actions">
		<?php do_action('gsf_product_singular_actions'); ?>
    </div>
</div>