<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $partners
 * @var $border
 * @var $items
 * @var $dots
 * @var $nav
 * @var $nav_position
 * @var $is_slider
 * @var $nav_size
 * @var $nav_style
 * @var $nav_hover_scheme
 * @var $nav_hover_style
 * @var $autoplay
 * @var $autoplay_timeout
 * @var $items
 * @var $columns_gutter
 * @var $effect_at_first
 * @var $opacity
 * @var $grayscale
 * @var $items_md
 * @var $items_sm
 * @var $items_xs
 * @var $items_mb
 * @var $css_animation
 * @var $animation_duration
 * @var $animation_delay
 * @var $el_class
 * @var $css
 * @var $responsive
 * Shortcode class
 * @var $this WPBakeryShortCode_GSF_Partners
 */
$partners = $border = $items = $columns_gutter = $opacity = $grayscale = $items_md = $items_sm = $items_xs = $items_mb = $is_slider = $dots = $nav = $nav_position = $nav_size = $nav_hover_scheme = $nav_hover_style =
$nav_style = $effect_at_first = $autoplay = $autoplay_timeout = $css_animation = $animation_duration = $animation_delay = $el_class = $css = $responsive = '';
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);

$wrapper_attributes = array();
$wrapper_styles = array();

$wrapper_classes = array(
	'gsf-partner',
	'clearfix',
	G5P()->core()->vc()->customize()->getExtraClass($el_class),
	$this->getCSSAnimation($css_animation),
	vc_shortcode_custom_css_class($css),
	$responsive
);
if ($border === 'on') {
	$wrapper_classes[] = 'partner-border';
}
if ('' !== $css_animation && 'none' !== $css_animation) {
	$animation_class = G5P()->core()->vc()->customize()->get_animation_class($animation_duration, $animation_delay);
	$wrapper_classes[] = $animation_class;
}
if (intval($opacity) < 0 || intval($opacity) > 100) {
	$opacity = 100;
}
if ($items_md == -1) {
	$items_md = 4;
}

if ($items_sm == -1) {
	$items_sm = 3;
}

if ($items_xs == -1) {
	$items_xs = 2;
}

if ($items_mb == -1) {
	$items_mb = 1;
}
$partner_class = 'gf-partner-' . uniqid();
$partner_css = '';
if ('opacity' === $effect_at_first) {
	$opacity = $opacity / 100;
	$partner_css = <<<CSS
.{$partner_class} .partner-item-content {
    opacity: {$opacity};
}
CSS;
} elseif ('grayscale' === $effect_at_first) {
	$partner_css = <<<CSS
.{$partner_class} .partner-item-content {
-webkit-filter: grayscale({$grayscale}%);
filter: grayscale({$grayscale}%);
}
CSS;
} else {
	$opacity = $opacity / 100;
	$partner_css = <<<CSS
.{$partner_class} .partner-item-content {
opacity: {$opacity};
-webkit-filter: grayscale({$grayscale}%);
filter: grayscale({$grayscale}%);
}
CSS;
}
GSF()->customCss()->addCss($partner_css);
$wrapper_classes[] = $partner_class;
$data_owl = array();
$columns_class = '';
if ($is_slider) {
	$wrapper_classes[] = 'owl-carousel';
	if ($nav === 'on') {
		$wrapper_classes .= ' ' . $nav_position . ' ' . $nav_style . ' ' . $nav_size . ' ' . $nav_hover_scheme . ' ' . $nav_hover_style;
	}

	$owl_attributes = array(
		'items' => intval($items),
		'loop' => false,
		'dots' => ($dots === 'on') ? true : false,
		'nav' => ($nav === 'on') ? true : false,
		'margin' => intval($columns_gutter),
		'responsive' => array(
			'0' => array(
				'items' => intval($items_mb)
			),
			'600' => array(
				'items' => intval($items_xs)
			),
			'768' => array(
				'items' => intval($items_sm)
			),
			'992' => array(
				'items' => intval($items_md)
			),
			'1200' => array(
				'items' => intval($items)
			)
		),
		'autoplay' => ($autoplay === 'on') ? true : false,
		'autoplayTimeout' => intval($autoplay_timeout),
	);
	$data_owl[] = "data-owl-options='" . json_encode($owl_attributes) . "'";
} else {
	$wrapper_classes[] = 'row align-items-center';
	$wrapper_classes[] = 'partner-gutter-' . $columns_gutter;
	$columns = array(
		'xl' => $items,
		'lg' => $items_md,
		'md' => $items_sm,
		'sm' => $items_xs,
		'' => $items_mb
	);
	$columns_class = G5Plus_Lustria()->helper()->get_bootstrap_columns($columns);
}
$class_to_filter = implode(' ', array_filter($wrapper_classes));
$class_to_filter .= vc_shortcode_custom_css_class($css, ' ');
$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->getShortcode(), $atts);

?>

<div class="<?php echo esc_attr($css_class) ?>" <?php echo implode(' ', $data_owl); ?>>
	<?php
	$values = (array)vc_param_group_parse_atts($partners);
	foreach ($values as $data) {
		$partner_img = isset($data['image']) ? $data['image'] : '';
		$partner_img_url = '';
		if (!empty($partner_img)) {
			$partner_img_full = wp_get_attachment_image_src($partner_img, 'full');
			if (is_array($partner_img_full) && isset($partner_img_full[0])) {
				$partner_img_url = $partner_img_full[0];
			}
		}

		if (empty($partner_img_url)) {
			$partner_img_url = G5P()->pluginUrl('assets/images/placeholder.png');
		}


		$link = isset($data['link']) ? $data['link'] : '';
		$link = ($link == '||') ? '' : $link;
		$link_arr = vc_build_link($link);
		$a_title = '';
		$a_target = '';
		$a_href = '#';
		if (strlen($link_arr['url']) > 0) {
			$a_href = $link_arr['url'];
			$a_title = $link_arr['title'];
			$a_target = strlen($link_arr['target']) > 0 ? $link_arr['target'] : '_blank';
		}
		?>
        <div class='partner-item <?php echo esc_attr($columns_class) ?>'>
            <div class="partner-item-inner">
                <div class="partner-item-content">
					<?php if ($link != ''): ?>
                    <a title="<?php echo esc_attr($a_title); ?>" target="<?php echo trim(esc_attr($a_target)); ?>"
                       href="<?php echo esc_url($a_href) ?>">
						<?php endif; ?>
                        <img src="<?php echo esc_url($partner_img_url) ?>" alt="<?php echo esc_attr($a_title); ?>">
						<?php if ($link != ''): ?>
                    </a>
				<?php endif; ?>
                </div>
            </div>
        </div>
		<?php
	}
	?>
</div>