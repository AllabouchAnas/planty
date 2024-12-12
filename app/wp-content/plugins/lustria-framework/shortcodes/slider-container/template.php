<?php
/**
 * Shortcode attributes
 * @var $content
 * @var $atts
 * @var $layout_style
 * @var $image
 * @var $rows
 * @var $dots
 * @var $nav
 * @var $nav_position
 * @var $nav_size
 * @var $nav_style
 * @var $nav_hover_scheme
 * @var $nav_hover_style
 * @var loop
 * @var $autoplay
 * @var $autoplay_timeout
 * @var $margin
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
 * @var $this WPBakeryShortCode_GSF_Slider_Container
 */
$layout_style = $image = $dots = $nav = $nav_position = $nav_style = $nav_size = $nav_hover_scheme = $loop=  $autoplay = $autoplay_timeout = $margin = $columns = $columns_md = $columns_sm = $columns_xs = $columns_mb =
$css_animation = $animation_duration = $animation_delay = $el_class = $css = $responsive = '';
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);

$wrapper_classes = array(
	'gsf-slider-container',
    'owl-carousel owl-theme',
	'clearfix',
    G5P()->core()->vc()->customize()->getExtraClass($el_class),
    $this->getCSSAnimation($css_animation),
    vc_shortcode_custom_css_class( $css ),
    $responsive
);

if ('' !== $css_animation && 'none' !== $css_animation) {
    $animation_class = G5P()->core()->vc()->customize()->get_animation_class($animation_duration, $animation_delay);
    $wrapper_classes[] = $animation_class;
}
$columns = intval($columns);
$columns_md = intval($columns_md);
$columns_sm = intval($columns_sm);
$columns_xs = intval($columns_xs);
$columns_mb = intval($columns_mb);
$wrapper_classes[] = 'item-gutter-' . $margin;
$owl_args = array(
    'items' => $columns,
    'margin' => 0,
    'slideBy' => 1,
    'dots' => ('on' === $dots) ? true : false,
    'nav' => ('on' === $nav) ? true : false,
    'loop' => ('on' === $loop) ? true : false,
    'smartSpeed' => 500,
    'responsive' => array(
        '1200' => array(
            'items' => $columns
        ),
        '992' => array(
            'items' => $columns_md
        ),
        '768' => array(
            'items' => $columns_sm
        ),
        '600' => array(
            'items' => $columns_xs
        ),
        '0' => array(
            'items' => $columns_mb
        )
    ),
    'autoHeight' => true,
    'autoplay' => ($autoplay === 'on') ? true : false,
    'autoplayTimeout' => intval($autoplay_timeout)
);

if ($nav === 'on') {
    $wrapper_classes[] = $nav_position;
    $wrapper_classes[] = $nav_style;
    $wrapper_classes[] = $nav_size;
    if ($nav_style !== 'nav-style-01') {
        $wrapper_classes[] = $nav_hover_style;
    }
}

$class_to_filter = implode(' ', array_filter($wrapper_classes));
$class_to_filter .= vc_shortcode_custom_css_class($css, ' ');
$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts);

?>
<div class="<?php echo esc_attr($css_class) ?>" data-owl-options='<?php echo json_encode($owl_args); ?>'>
	<?php G5P()->helper()->shortCodeContent($content); ?>
</div>