<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $title
 * @var $units
 * @var $value_color
 * @var $title_color
 * @var $bar_color
 * @var $bar_custom_color
 * @var $color
 * @var $custom_color
 * @var $max_width
 * @var $text_align
 * @var $css_animation
 * @var $animation_duration
 * @var $animation_delay
 * @var $el_class
 * @var $css
 * @var $responsive
 * Shortcode class
 * @var $this WPBakeryShortCode_GSF_Pie_Chart
 */

$title = $value = $units = $value_color = $title_color = $bar_color = $bar_custom_color = $color = $custom_color = $max_width = '';
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);

$accent_color = G5P()->options()->get_accent_color();
$colors = array(
	'accent-color' => $accent_color,
	'blue' => '#5472d2',
	'turquoise' => '#00c1cf',
	'pink' => '#fe6c61',
	'violet' => '#8d6dc4',
	'peacoc' => '#4cadc9',
	'chino' => '#cec2ab',
	'mulled-wine' => '#50485b',
	'vista-blue' => '#75d69c',
	'orange' => '#f7be68',
	'sky' => '#5aa1e3',
	'green' => '#6dab3c',
	'juicy-pink' => '#f4524d',
	'sandy-brown' => '#f79468',
	'purple' => '#b97ebb',
	'black' => '#2a2a2a',
	'grey' => '#ebebeb',
	'white' => '#ffffff',
);

if ('custom' === $color) {
	$color = $custom_color;
} else {
	$color = isset($colors[$color]) ? $colors[$color] : '';
}

if (!$color) {
	$color = $colors['grey'];
}
if ('bar_custom' === $bar_color) {
	$bar_color = $bar_custom_color;
} else {
	$bar_color = isset($colors[$bar_color]) ? $colors[$bar_color] : '';
}

if (!$bar_color) {
	$bar_color = $colors['grey'];
}

$wrapper_classes = array(
	'g5plus-pie-chart',
	'vc_pie_chart',
	$text_align,
	$this->getExtraClass($el_class)
);
$max_width = explode('|', $max_width);
if (intval($max_width[0]) !== 0) {
	$width = $max_width[0] * 100 / 80;
	$pie_class = 'gf-pie-chart-' . random_int(1000, 9999);
	$pie_css = <<<CSS
    .{$pie_class} {
        max-width: {$width}{$max_width[1]};
    }
CSS;
	$wrapper_classes[] = $pie_class;
	GSF()->customCss()->addCss($pie_css);
}

$class_to_filter = implode(' ', array_filter($wrapper_classes));
$class_to_filter .= vc_shortcode_custom_css_class($css, ' ');
$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts);
$bar_attributes = array();
if ($bar_color !== '') {
	$bar_attributes[] = ' style="border-color:' . esc_attr($bar_color) . '"';
}
$value_attributes = array();
if ($value_color !== '') {
	$value_attributes[] = ' style="color:' . esc_attr($value_color) . '"';
}
?>
    <div class="<?php echo esc_attr($css_class) ?>"
         data-pie-value="<?php echo esc_attr($value); ?>"
         data-pie-units="<?php echo esc_attr($units) ?>" data-pie-color="<?php echo esc_attr($color) ?>">
        <div class="wpb_wrapper">
            <div class="vc_pie_wrapper">
                <span class="vc_pie_chart_back"<?php echo implode(' ', $bar_attributes); ?>></span>
                <span<?php echo implode(' ', $value_attributes); ?> class="vc_pie_chart_value"></span>
                <canvas width="101" height="101"></canvas>
            </div>
        </div>
    </div>
<?php if (!empty($title)) :
	?>
    <h4 class="wpb_pie_chart_heading"><?php echo esc_html($title); ?></h4>
<?php endif; ?>