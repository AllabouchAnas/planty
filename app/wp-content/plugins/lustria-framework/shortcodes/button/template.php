<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $title
 * @var $link
 * @var $style
 * @var $shape
 * @var $color
 * @var $size
 * @var $align
 * @var $button_block
 * @var $icon_align
 * @var $icon_font
 * @var $css_animation
 * @var $animation_duration
 * @var $animation_delay
 * @var $el_class
 * @var $css
 * @var $custom_onclick
 * @var $custom_onclick_code
 * @var $responsive
 * Shortcode class
 * @var $this WPBakeryShortCode_GSF_Button
 */
$title = $link = $style = $shape = $color = $size = $align = $button_block = $icon_align = $icon_font = $css_animation = $animation_duration = $animation_delay = $el_class = $css = $custom_onclick = $custom_onclick_code = $responsive = '';
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);

$wrapper_classes = array(
    'btn-container',
    G5P()->core()->vc()->customize()->getExtraClass($el_class),
    $this->getCSSAnimation($css_animation),
    vc_shortcode_custom_css_class($css),
    $responsive
);

if ('' !== $css_animation && 'none' !== $css_animation) {
    $animation_class = G5P()->core()->vc()->customize()->get_animation_class($animation_duration, $animation_delay);
    $wrapper_classes[] = $animation_class;
}
$btn_color = "btn-{$color}";
$button_attributes = array();
$button_classes = array(
    'btn',
    $btn_color,
    "btn-{$style}",
    "btn-{$size}"
);

if ('link' !== $style) {
    $button_classes[] = "btn-{$shape}";
}

if ('inline' === $align) {
    $wrapper_classes[] = "btn-{$align}";
} else {
    $wrapper_classes[] = "text-{$align}";
}
$a_href = $a_title = $a_target = $a_rel = '';
//parse link
$link = ('||' === $link) ? '' : $link;
$link = vc_build_link($link);
$use_link = false;
if (strlen($link['url']) > 0) {
    $use_link = true;
    $a_href = $link['url'];
    $a_title = $link['title'];
    $a_target = $link['target'];
    $a_rel = $link['rel'];
}

if ('on' === $button_block && 'inline' !== $align) {
    $button_classes[] = 'btn-block';
}

$button_html = $title;
if ('' !== $icon_font) {
    $button_classes[] = 'btn-icon';
    $button_classes[] = 'btn-icon-' . $icon_align;

    $icon_html = '<i class="' . esc_attr($icon_font) . '"></i>';

    if ('left' === $icon_align) {
        $button_html = $icon_html . $button_html;
    } else {
        $button_html = $button_html . $icon_html;
    }
}


$button_class = implode(' ', array_filter($button_classes));

$button_attributes[] = 'class="' . $button_class . '"';
if ($use_link) {
    $button_attributes[] = 'href="' . esc_url(trim($a_href)) . '"';
    if (empty($a_title)) {
        $a_title = $title;
    }
    $button_attributes[] = 'title="' . esc_attr(trim($a_title)) . '"';
    if (!empty($a_target)) {
        $button_attributes[] = 'target="' . esc_attr(trim($a_target)) . '"';
    }

    if (!empty($a_rel)) {
        $button_attributes[] = 'rel="' . esc_attr(trim($a_rel)) . '"';
    }
}
if ('on' === $custom_onclick && $custom_onclick_code) {
    $button_attributes[] = 'onclick="' . esc_attr($custom_onclick_code) . '"';
}



$wrapper_class = implode(' ', array_filter($wrapper_classes));
?>
<div class="<?php echo esc_attr($wrapper_class) ?>">
    <?php if ($use_link) : ?>
        <a <?php echo implode(' ', $button_attributes); ?>><?php echo wp_kses_post($button_html); ?></a>
    <?php else: ?>
        <button <?php echo implode(' ', $button_attributes); ?>><?php echo wp_kses_post($button_html); ?></button>
    <?php endif; ?>
</div>

