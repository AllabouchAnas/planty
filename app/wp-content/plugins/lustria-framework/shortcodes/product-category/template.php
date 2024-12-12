<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $layout_style
 * @var $image
 * @var $category
 * @var $hover_effect
 * @var $title_size
 * @var $height_mode
 * @var $height
 * @var $css_animation
 * @var $animation_duration
 * @var $animation_delay
 * @var $el_class
 * @var $css
 * @var $responsive
 * Shortcode class
 * @var $this WPBakeryShortCode_GSF_Product_Category
 */

$layout_style = $image = $hover_effect = $title_size = $category = $height_mode = $height =
$css_animation = $animation_duration = $animation_delay = $el_class = $css = $responsive = '';
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);

$wrapper_classes = array(
	'gf-product-category',
	'gf-product-category-' . $layout_style,
	$title_size,
	G5P()->core()->vc()->customize()->getExtraClass($el_class),
	$this->getCSSAnimation($css_animation),
	vc_shortcode_custom_css_class($css),
	$responsive
);

if ('' !== $css_animation && 'none' !== $css_animation) {
	$animation_class = G5P()->core()->vc()->customize()->get_animation_class($animation_duration, $animation_delay);
	$wrapper_classes[] = $animation_class;
}
$banner_class = 'gf-product-cate-' . random_int(1000, 9999);
$banner_bg_css = '';
if (!empty($image)) {
	$image_src = '';
	$image_arr = wp_get_attachment_image_src($image, 'full');
	$img_width = $img_height = '';
	if (is_array($image_arr)) {
		$image_src = isset($image_arr[0]) ? $image_arr[0] : '';
		$img_width = isset($image_arr[1]) ? intval($image_arr[1]) : 0;
		$img_height = isset($image_arr[2]) ? intval($image_arr[2]) : 0;
	} else {
		$image_src = G5P()->pluginUrl('assets/images/placeholder.png');
		$img_width = $img_height = 300;
	}

	if ($height_mode != 'custom') {
		if ($height_mode === 'original' && intval($img_width) != 0) {
			$height_mode = ($img_height / $img_width) * 100;
		}
		$banner_bg_css = <<<CSS
			.{$banner_class} {
				background-image: url('{$image_src}');
				padding-bottom: {$height_mode}%;
			}
CSS;
	} else {
		$height = str_replace('|', '', $height);
		$banner_bg_css = <<<CSS
			.{$banner_class} {
				background-image: url('{$image_src}');
				height: {$height};
			}
CSS;
	}
}
GSF()->customCss()->addCss($banner_bg_css);


$class_to_filter = implode(' ', array_filter($wrapper_classes));
$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->getShortcode(), $atts);


?>
<?php if (!empty($category)): ?>
    <div class="<?php echo esc_attr($css_class) ?>">
		<?php $cate_link = get_term_link($category, 'product_cat'); ?>
		<?php $category = get_term_by('slug', $category, 'product_cat', 'OBJECT'); ?>
		<?php if ($category && !is_object($cate_link)): ?>
			<?php $cat_count    = get_term_meta( $category->term_id, 'product_count_product_cat', true ); ?>
			<?php if ('' !== $hover_effect): ?>
                <div class="<?php echo esc_attr($hover_effect); ?>">
			<?php endif; ?>
            <div class="gf-product-category-bg effect-bg-image effect-content <?php echo esc_attr($banner_class); ?>">
                <a href="<?php echo esc_url($cate_link); ?>" title="<?php echo esc_attr($category->name); ?>"
                   class="gsf-link"></a>
            </div>
			<?php if ('' !== $hover_effect): ?>
                </div>
			<?php endif; ?>
            <a class="btn btn-white btn-md <?php if ('style-02' === $layout_style): ?>btn-outline <?php endif; ?>btn-product-category"
               href="<?php echo esc_url($cate_link); ?>"
               title="<?php echo esc_attr($category->name); ?>"><?php echo esc_html($category->name); ?><sup
                        class="cate-count">( <?php echo wp_kses_post($cat_count) ?> )</sup></a>
			<?php $count = _n_noop('%s item', '%s items', 'lustria-framework'); ?>
		<?php endif; ?>
    </div>
<?php endif; ?>