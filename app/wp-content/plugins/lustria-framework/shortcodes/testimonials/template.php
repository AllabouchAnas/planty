<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $columns_gutter
 * @var $quote_image
 * @var $tes_style
 * @var $content_typography
 * @var $values
 * @var $dots
 * @var $nav
 * @var $nav_position
 * @var $nav_style
 * @var $autoplay
 * @var $autoplay_timeout
 * @var $columns
 * @var $columns_md
 * @var $columns_sm
 * @var $columns_xs
 * @var $columns_mb
 * @var $css_animation
 * @var $animation_duration
 * @var $animation_delay
 * @var $el_class
 * @var $css
 * @var $responsive
 * Shortcode class
 * @var $this WPBakeryShortCode_GSF_Testimonials
 */
$columns_gutter = $quote_image = $tes_style = $content_typography = $values = $dots = $nav = $nav_position = $nav_style = $autoplay = $autoplay_timeout =
$columns = $columns_md = $columns_sm = $columns_xs = $columns_mb = $css_animation = $animation_duration = $animation_delay = $el_class = $css = $responsive = '';
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);

$wrapper_classes = array(
	'gsf-testimonials',
	'gsf-slider-container',
	'clearfix',
	G5P()->core()->vc()->customize()->getExtraClass($el_class),
	$this->getCSSAnimation($css_animation),
	vc_shortcode_custom_css_class($css),
	$responsive
);
if ('' !== $css_animation && 'none' !== $css_animation) {
	$animation_class = G5P()->core()->vc()->customize()->get_animation_class($animation_duration, $animation_delay);
	$wrapper_classes[] = $animation_class;
}
$wrapper_classes[] = 'owl-carousel owl-theme';
$columns = intval($columns);
$columns_md = intval($columns_md);
$columns_sm = intval($columns_sm);
$columns_xs = intval($columns_xs);
$columns_mb = intval($columns_mb);
$wrapper_classes[] = 'item-gutter-' . $columns_gutter;
$owl_attributes = array(
	'items' => $columns,
	'margin' => 0,
	'dots' => ($dots === 'on') ? true : false,
	'nav' => ($nav === 'on') ? true : false,
	'autoHeight' => true,
	'autoplay' => ($autoplay === 'on') ? true : false,
	'autoplayTimeout' => $autoplay_timeout,
	'responsive' => array(
		'1200' => array(
			'items' => $columns,
			'slideBy' => $columns,
		),
		'992' => array(
			'items' => $columns_md,
			'slideBy' => $columns_md,
		),
		'768' => array(
			'items' => $columns_sm,
			'slideBy' => $columns_sm,
		),
		'600' => array(
			'items' => $columns_xs,
			'slideBy' => $columns_xs,
		),
		'0' => array(
			'items' => $columns_mb,
			'slideBy' => $columns_mb,
		)
	)
);

if ($nav === 'on') {
	$wrapper_classes[] = $nav_position;
	$wrapper_classes[] = $nav_style;
	$wrapper_classes[] = $nav_size;
	if ($nav_style !== 'nav-style') {
		$wrapper_classes[] = $nav_hover_style;
	}
}

$tes_content_class = 'gsf-testimonial-' . uniqid();
$tes_content_css = '';

$wrapper_classes[] = $tes_content_class;
GSF()->customCss()->addCss($tes_content_css);
$class_to_filter = implode(' ', $wrapper_classes);
$class_to_filter .= vc_shortcode_custom_css_class($css, ' ');
$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->getShortcode(), $atts);
?>
<div class="<?php echo esc_attr($css_class) ?>" data-owl-options='<?php echo json_encode($owl_attributes); ?>'>
	<?php
	$values = (array)vc_param_group_parse_atts($values);
	foreach ($values as $value):
		$name = isset($value['author_name']) ? $value['author_name'] : '';
		$job = isset($value['author_job']) ? $value['author_job'] : '';
		$bio = isset($value['author_bio']) ? $value['author_bio'] : '';
		$url = isset($value['author_link']) ? $value['author_link'] : '';
		$avatar = isset($value['author_avatar']) ? $value['author_avatar'] : '';
		$image_src = '';
		if (!empty($avatar)) {
			$image_full = wpb_resize($avatar, null, 670, 430, true);
			if (is_array($image_full) && isset($image_full['url'])) {
				$image_src = $image_full['url'];
			}
		}
		?>
		<?php G5P()->helper()->getTemplate('shortcodes/testimonials/templates/style', array('name' => $name, 'job' => $job, 'bio' => $bio, 'image_src' => $image_src, 'url' => $url, 'quote_image' => $quote_image)); ?>
	<?php endforeach; ?>
</div>
