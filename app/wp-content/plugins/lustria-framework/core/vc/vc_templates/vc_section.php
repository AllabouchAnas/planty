<?php
if (!defined('ABSPATH')) {
    die('-1');
}

/**
 * Shortcode attributes
 * @var $atts
 * @var $el_class
 * @var $full_height
 * @var $columns_placement
 * @var $content_placement
 * @var $parallax
 * @var $parallax_image
 * @var $css
 * @var $el_id
 * @var $video_bg
 * @var $video_bg_url
 * @var $video_bg_parallax
 * @var $parallax_speed_bg
 * @var $parallax_speed_video
 * @var $content - shortcode content
 * @var $css_animation
 * @var $container_width
 * @var $content_width
 * Shortcode class
 * @var $this WPBakeryShortCode_VC_Row
 */
$el_class = $full_height = $parallax_speed_bg = $parallax_speed_video = $flex_row = $columns_placement = $content_placement = $parallax = $parallax_image = $css = $el_id = $video_bg = $video_bg_url = $video_bg_parallax = $css_animation = $container_width = $content_width = '';
$disable_element = '';
$output = $after_output = '';
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);

wp_enqueue_script('wpb_composer_front_js');

$el_class = $this->getExtraClass($el_class) . $this->getCSSAnimation($css_animation);

$css_classes = array(
    'vc_section',
    $el_class,
    vc_shortcode_custom_css_class($css),
);

if ('yes' === $disable_element) {
    if (vc_is_page_editable()) {
        $css_classes[] = 'vc_hidden-lg vc_hidden-xs vc_hidden-sm vc_hidden-md';
    } else {
        return '';
    }
}

if (vc_shortcode_custom_css_has_property($css, array(
        'border',
        'background',
    )) || $video_bg || $parallax
) {
    $css_classes[] = 'vc_section-has-fill';
}


$wrapper_attributes = array();
// build attributes for wrapper
if (!empty($el_id)) {
    $wrapper_attributes[] = 'id="' . esc_attr($el_id) . '"';
}


if (!empty($full_height)) {
    $css_classes[] = 'vc_row-o-full-height';
}

if (!empty($content_placement)) {
    $flex_row = true;
    $css_classes[] = 'vc_section-o-content-' . $content_placement;
}

if (!empty($flex_row)) {
    $css_classes[] = 'vc_section-flex';
}

$has_video_bg = (!empty($video_bg) && !empty($video_bg_url) && vc_extract_youtube_id($video_bg_url));

$parallax_speed = $parallax_speed_bg;
if ($has_video_bg) {
    $parallax = $video_bg_parallax;
    $parallax_speed = $parallax_speed_video;
    $parallax_image = $video_bg_url;
    $css_classes[] = 'vc_video-bg-container';
    wp_enqueue_script('vc_youtube_iframe_api_js');
}

if (!empty($parallax)) {
    wp_enqueue_script('vc_jquery_skrollr_js');
    $wrapper_attributes[] = 'data-vc-parallax="' . esc_attr($parallax_speed) . '"'; // parallax speed
    $css_classes[] = 'vc_general vc_parallax vc_parallax-' . $parallax;
    if (false !== strpos($parallax, 'fade')) {
        $css_classes[] = 'js-vc_parallax-o-fade';
        $wrapper_attributes[] = 'data-vc-parallax-o-fade="on"';
    } elseif (false !== strpos($parallax, 'fixed')) {
        $css_classes[] = 'js-vc_parallax-o-fixed';
    }
}

if (!empty($parallax_image)) {
    if ($has_video_bg) {
        $parallax_image_src = $parallax_image;
    } else {
        $parallax_image_id = preg_replace('/[^\d]/', '', $parallax_image);
        $parallax_image_src = wp_get_attachment_image_src($parallax_image_id, 'full');
        if (!empty($parallax_image_src[0])) {
            $parallax_image_src = $parallax_image_src[0];
        }
    }
    $wrapper_attributes[] = 'data-vc-parallax-image="' . esc_attr($parallax_image_src) . '"';
}
if (!$parallax && $has_video_bg) {
    $wrapper_attributes[] = 'data-vc-video-bg="' . esc_attr($video_bg_url) . '"';
}

$row_inner_classes = array('gf-row-inner');
if ($content_width == 'limit') {
    $row_inner_classes[] = 'gf-container container';
} elseif ($content_width == 'full-desktop') {
    $row_inner_classes[] = 'gf-container-fluid';
}

$row_inner_class = implode(' ', $row_inner_classes);


$css_class = preg_replace('/\s+/', ' ', apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, implode(' ', array_filter(array_unique($css_classes))), $this->settings['base'], $atts));
$wrapper_attributes[] = 'class="' . esc_attr(trim($css_class)) . '"';
?>
<?php if (($container_width === 'limit')) : ?>
<div class="gf-container container">
    <?php endif; ?>
    <section <?php echo implode(' ', $wrapper_attributes) ?>>
        <?php if ($container_width === 'full'): ?>
        <div class="<?php echo esc_attr($row_inner_class) ?>">
            <?php endif; ?>

            <?php echo wpb_js_remove_wpautop($content); ?>
            <?php if (($container_width === 'full')): ?>
        </div>
    <?php endif; ?>
    </section>
    <?php if (($container_width === 'limit')) : ?>
</div>
<?php endif; ?>
