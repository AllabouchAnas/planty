<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $video_style
 * @var $video_size
 * @var $link
 * @var $icon_bg_color
 * @var $icon_color
 * @var $icon_bg_hover_color
 * @var $icon_hover_color
 * @var $css_animation
 * @var $animation_duration
 * @var $animation_delay
 * @var $el_class
 * @var $css
 * Shortcode class
 * @var $this WPBakeryShortCode_GSF_Video
 */


$video_style = $video_size = $link = $icon_bg_color = $icon_color = $icon_bg_hover_color = $icon_hover_color =
$css_animation = $animation_duration = $animation_delay = $el_class = $css = '';
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);

$wrapper_classes = array(
	'gsf-video',
	'gsf-video-' . $video_style,
	'gsf-video-' . $video_size,
	G5P()->core()->vc()->customize()->getExtraClass($el_class),
	$this->getCSSAnimation($css_animation),
	vc_shortcode_custom_css_class($css),
	$responsive
);
if ('' !== $css_animation && 'none' !== $css_animation) {
	$animation_class = G5P()->core()->vc()->customize()->get_animation_class($animation_duration, $animation_delay);
	$wrapper_classes[] = $animation_class;
}

$icon_class = 'gsf-icon-' . uniqid();
if ('outline' === $video_style) {
	$icon_css = <<<CSS
        .{$icon_class} .view-video {
            background-color: transparent !important;
            color: {$icon_color} !important;
        }
        .{$icon_class} .view-video:before {
            border-color: {$icon_bg_color} !important;
        }
CSS;
} else {
	$icon_css = <<<CSS
        .{$icon_class} .view-video {
            background-color: {$icon_bg_color} !important;
            color: {$icon_color} !important;
        }
        .{$icon_class} .view-video:before {
            border-color: {$icon_bg_color} !important;
        }
CSS;
}
$icon_css .= <<<CSS
    .{$icon_class} .view-video:hover,
     .{$icon_class} .view-video:focus,
     .{$icon_class} .view-video:active {
        background-color: {$icon_bg_hover_color} !important;
        color: {$icon_hover_color} !important;
    }
CSS;

$wrapper_classes[] = $icon_class;
GSF()->customCss()->addCss($icon_css);

$icon_class = 'fas fa-play';
if ('outline' === $video_style) {
	$icon_class = 'fal fa-play';
}
$class_to_filter = implode(' ', array_filter($wrapper_classes));
$class_to_filter .= vc_shortcode_custom_css_class($css, ' ');
$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts);

$args = array(
	'type' => 'iframe',
	'mainClass' => 'mfp-fade'
);
?>
<div class="<?php echo esc_attr($css_class) ?>">
    <a data-magnific="true" data-magnific-options='<?php echo json_encode($args) ?>' class="view-video"
       href="<?php echo esc_url($link) ?>">
        <i class="<?php echo esc_attr($icon_class); ?>"></i>
    </a>
    <a data-magnific="true" data-magnific-options='<?php echo json_encode($args) ?>'
       href="<?php echo esc_url($link) ?>"><span class="text-video">PLAY VIDEO</span> </a>
</div>