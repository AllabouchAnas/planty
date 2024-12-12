<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $layout_style
 * @var $time
 * @var $url_redirect
 * @var $main_color
 * @var $day_enable
 * @var $css_animation
 * @var $animation_duration
 * @var $animation_delay
 * @var $el_class
 * @var $css
 * @var $responsive
 * Shortcode class
 * @var $this WPBakeryShortCode_GSF_Countdown
 */
$layout_style = $time = $url_redirect = $main_color = $day_enable = $css_animation = $animation_duration = $animation_delay = $el_class = $css = $responsive = '';
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);
if (empty($time)) return;
$wrapper_classes = array(
	'gsf-countdown',
	G5P()->core()->vc()->customize()->getExtraClass($el_class),
	$this->getCSSAnimation($css_animation),
	vc_shortcode_custom_css_class($css),
	$responsive
);

if ('on' !== $day_enable) {
	$wrapper_classes[] = 'gsf-countdown-hide-day';
}

$cd_class = 'cd-' . uniqid();
$cd_css = '';
if ('on' !== $title_use_theme_fonts) {
	$title_typography = $this->get_font_attrs($title_typography);
	$cd_css .= <<<CSS
        .{$cd_class} .countdown-value {
            font-family: '{$title_typography[0]}' !important;
            font-weight: {$title_typography[2]} !important;
            font-style: {$title_typography[3]} !important;
}
CSS;
}
if (empty($main_color)) {
	$main_color = G5P()->options()->get_accent_color();
}
$cd_css .= <<<CSS
    .{$cd_class} .countdown-value,
    .{$cd_class} .countdown-value:before,
     .{$cd_class} .countdown-section:before {
        color: {$main_color} !important;
}
CSS;
GSF()->customCss()->addCss($cd_css);
if ('' !== $css_animation && 'none' !== $css_animation) {
	$animation_class = G5P()->core()->vc()->customize()->get_animation_class($animation_duration, $animation_delay);
	$wrapper_classes[] = $animation_class;
}
$class_to_filter = implode(' ', array_filter($wrapper_classes));
$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts);

$time = mysql2date('Y/m/d H:i:s', $time);
?>
<div class="<?php echo esc_attr($css_class) ?>"
     data-url-redirect="<?php echo esc_attr($url_redirect) ?>"
     data-date-end="<?php echo esc_attr($time); ?>">
    <div class="gsf-countdown-inner countdown-<?php echo esc_attr($layout_style); ?> <?php echo esc_attr($cd_class); ?>">
        <div class="countdown-section countdown-day">
            <span class="countdown-value">00</span>
            <span class="countdown-text"><?php esc_html_e('Days', 'lustria-framework'); ?></span>
        </div>
        <div class="countdown-section countdown-hours">
            <span class="countdown-value">00</span>
            <span class="countdown-text"><?php esc_html_e('Hours', 'lustria-framework'); ?></span>
        </div>
        <div class="countdown-section countdown-minutes">
            <span class="countdown-value">00</span>
            <span class="countdown-text"><?php esc_html_e('Mins', 'lustria-framework'); ?></span>
        </div>
        <div class="countdown-section countdown-seconds">
            <span class="countdown-value">00</span>
            <span class="countdown-text"><?php esc_html_e('Secs', 'lustria-framework'); ?></span>
        </div>
    </div>
</div>