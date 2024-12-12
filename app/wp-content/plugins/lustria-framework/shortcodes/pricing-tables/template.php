<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $layout_style
 * @var $name
 * @var $min_height
 * @var $price
 * @var $currency_code
 * @var $text_time
 * @var $featured_text
 * @var $values
 * @var $button_text
 * @var $link
 * @var $is_featured
 * @var $css_animation
 * @var $animation_duration
 * @var $animation_delay
 * @var $el_class
 * @var $css
 * @var $responsive
 * Shortcode class
 * @var $this WPBakeryShortCode_GSF_Pricing_tables
 */

$layout_style = $is_featured = $name = $min_height = $price = $currency_code = $text_time = $featured_text = $values = $button_text = $link = $css_animation = $animation_duration = $animation_delay = $el_class = $css = $responsive = '';
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);

$wrapper_classes = array(
	'gf-pricing-tables',
	$layout_style,
	G5P()->core()->vc()->customize()->getExtraClass($el_class),
	$this->getCSSAnimation($css_animation),
	vc_shortcode_custom_css_class($css),
	$responsive
);
if ($is_featured) {
	$wrapper_classes[] = 'is-featured';
}
$name = !empty($name) ? $name : '';
$price = !empty($price) ? $price : '';
$currency_code = !empty($currency_code) ? $currency_code : '';
$text_time = !empty($text_time) ? $text_time : '';
$featured_text = !empty($featured_text) ? $featured_text : '';

$values = (array)vc_param_group_parse_atts($values);

//parse link
$a_href = '';
$link = ('||' === $link) ? '' : $link;
$link = vc_build_link($link);
$use_link = false;
if (strlen($link['url']) > 0) {
	$use_link = true;
	$a_href = $link['url'];
	$a_title = $link['title'];
	$a_target = $link['target'];
}
$button_attributes = array();
if ($use_link) {
	$button_attributes[] = 'href="' . esc_url(trim($a_href)) . '"';
	if (empty($a_title)) {
		$a_title = $button_text;
	}
	$button_attributes[] = 'title="' . esc_attr(trim($a_title)) . '"';
	if (!empty($a_target)) {
		$button_attributes[] = 'target="' . esc_attr(trim($a_target)) . '"';
	}
}
$min_height = intval($min_height);
$button_class = 'btn ';
$pricing_class = 'gf-pricing-' . uniqid();
$pricing_css = <<<CSS
.{$pricing_class} .pricing-item {
    min-height: {$min_height}px;
}
CSS;
GSF()->customCss()->addCss($pricing_css);
$wrapper_classes[] = $pricing_class;

if ($is_featured) {
	$button_class .= 'btn-accent btn-sm';
} elseif ('style-2' === $layout_style) {
	$button_class .= 'btn-white btn-outline btn-sm';
} else {
	$button_class .= 'btn-gray btn-outline btn-sm';
}


if ('' !== $css_animation && 'none' !== $css_animation) {
	$animation_class = G5P()->core()->vc()->customize()->get_animation_class($animation_duration, $animation_delay);
	$wrapper_classes[] = $animation_class;
}


$class_to_filter = implode(' ', array_filter($wrapper_classes));
$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts);
?>
<div class="<?php echo esc_attr($css_class) ?>">
	<?php if ('style-1' === $layout_style): ?>
    <div class="pricing-item">
		<?php endif; ?>
		<?php if ('style-1' !== $layout_style) : ?>
			<?php if (!empty($name)): ?>
                <h4 class="pricing-name"><?php echo esc_html($name) ?></h4>
			<?php endif; ?>
		<?php endif; ?>
		<?php if (!empty($price)): ?>
            <div class="pricing-price">
                <span><?php echo esc_html($currency_code) ?></span>
                <h4><?php echo esc_html($price) ?></h4> <?php if (!empty($text_time)) ?>
                <p>/ <?php echo esc_html($text_time) ?></p>
            </div>
		<?php endif; ?>
		<?php if ('style-1' === $layout_style) : ?>
			<?php if (!empty($featured_text) && ($is_featured)): ?>
                <div class="featured-text"><span><?php echo esc_html($featured_text) ?></span></div>
			<?php endif; ?>
			<?php if (!empty($name)): ?>
                <h4 class="pricing-name"><?php echo esc_html($name) ?></h4>
			<?php endif; ?>
		<?php endif; ?>
        <div class="pricing-features">
            <ul>
				<?php foreach ($values as $data): ?>
					<?php $features = isset($data['features']) ? $data['features'] : ''; ?>
					<?php if (!empty($features) || !empty($features_style)): ?>
                        <li>
							<?php echo wp_kses_post($data['features']) ?>
                        </li>
					<?php endif; ?>
				<?php endforeach; ?>
            </ul>
        </div>
		<?php if (!empty($button_text)): ?>
            <a class="pricing-button <?php echo esc_attr($button_class) ?>" <?php echo implode(' ', $button_attributes); ?>><?php echo esc_html($button_text) ?></a>
		<?php endif; ?>
		<?php if ('style-1' === $layout_style): ?>
    </div>
<?php endif; ?>
</div>
