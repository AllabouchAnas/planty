<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

/**
 * @var $element UBE_Element_Lustria_Product_Category
 */

$atts = $element->get_settings();
$wrap_class = array(
	'gf-product-category',
	'gf-product-category-' . $atts['layout_category'],
);
$category = $atts['cat'];

if ($atts['category_image']['url'] !== '') {
	$bg_style = array();
	$pd_bottom = 66.6666666;

	if ($atts['category_image']['id'] !== '') {
		$media_image = wp_get_attachment_image_src($atts['category_image']['id'], 'full');
		$pd_bottom = ($media_image[2] / $media_image[1]) * 100;
	}

	if ($atts['size_mode'] !== 'custom' && $atts['size_mode'] !== 'original') {
		$pd_bottom = $atts['size_mode'];
	}

	if ( $atts['size_mode'] !== 'custom') {
		$bg_style[] = "padding-bottom:{$pd_bottom}%";
	}

	$bg_style[] = "background-image : url({$atts['category_image']['url']})";

	$element->add_render_attribute('bg_attr', array(
		'class' => 'gf-product-category-bg effect-bg-image effect-content',
		'style' => join(";", $bg_style),
	));
}

$element->add_render_attribute('product_attr', 'class', $wrap_class);
?>
<?php if (!empty($category)): ?>
	<div <?php $element->print_render_attribute_string('product_attr') ?>>
		<?php $term = get_term( $category, 'product_cat' );?>
		<?php $cate_link = get_term_link($term); ?>
		<?php $category = get_term_by('term_id', $category, 'product_cat', 'OBJECT'); ?>
		<?php if ($category && !is_object($cate_link)): ?>
			<?php $cat_count    = get_term_meta( $category->term_id, 'product_count_product_cat', true ); ?>
			<?php if ('' !== $atts['hover_effect']): ?>
				<div class="<?php echo esc_attr($atts['hover_effect']); ?>">
			<?php endif; ?>
			<div <?php $element->print_render_attribute_string('bg_attr') ?>>
				<a href="<?php echo esc_url($cate_link); ?>" title="<?php echo esc_attr($category->name); ?>"
				   class="gsf-link"></a>
			</div>
			<?php if ('' !== $atts['hover_effect']): ?>
				</div>
			<?php endif; ?>
			<a class="btn btn-white btn-md <?php if ('style-02' === $atts['layout_category']): ?>btn-outline <?php endif; ?>btn-product-category"
			   href="<?php echo esc_url($cate_link); ?>"
			   title="<?php echo esc_attr($category->name); ?>"><?php echo esc_html($category->name); ?><sup
						class="cate-count">( <?php echo wp_kses_post($cat_count) ?> )</sup></a>
			<?php $count = _n_noop('%s item', '%s items', 'lustria-framework'); ?>
		<?php endif; ?>
	</div>
<?php endif; ?>
