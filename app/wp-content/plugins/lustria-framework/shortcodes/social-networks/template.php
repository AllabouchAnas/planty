<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $social_networks
 * @var $social_shape
 * @var $social_size
 * @var $space_between
 * @var $css_animation
 * @var $animation_duration
 * @var $animation_delay
 * @var $el_class
 * @var $css
 * @var $responsive
 * Shortcode class
 * @var $this WPBakeryShortCode_GSF_Social_Networks
 */

$social_networks = $social_shape = $social_size = $space_between = $css_animation = $animation_duration = $animation_delay = $el_class = $css = $responsive = '';
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);

$wrapper_classes = array(
	'gf-social-networks',
	G5P()->core()->vc()->customize()->getExtraClass($el_class),
	$this->getCSSAnimation($css_animation),
	vc_shortcode_custom_css_class( $css ),
	$responsive
);

if ('' !== $css_animation && 'none' !== $css_animation) {
	$animation_class = G5P()->core()->vc()->customize()->get_animation_class($animation_duration, $animation_delay);
	$wrapper_classes[] = $animation_class;
}

$social_class = 'gsf-testimonial-' . uniqid();
$social_css = '';
$space_betweens = explode('|', $space_between);
$space_between = $space_betweens[0];
$space_between_lg = (! isset($space_betweens[1]) || empty($space_betweens[1]) || intval($space_betweens[1]) <=0) ? $space_between : $space_betweens[1];
$space_between_md = (! isset($space_betweens[2]) || empty($space_betweens[2]) || intval($space_betweens[2]) <=0) ? $space_between_lg : $space_betweens[2];
$space_between_sm = (! isset($space_betweens[3]) || empty($space_betweens[3]) || intval($space_betweens[3]) <=0) ? $space_between_md : $space_betweens[3];
$space_between_mb = (! isset($space_betweens[4]) || empty($space_betweens[4]) || intval($space_betweens[4]) <=0) ? $space_between_sm : $space_betweens[4];
$social_css .= <<<CSS
    .{$social_class} li {
        margin-right: {$space_between}px !important;
    }
    @media (min-width: 992px) and (max-width: 1199px) {
        .{$social_class} li {
            margin-right: {$space_between_lg}px !important;
        }
    }
    @media (min-width: 768px) and (max-width: 991px) {
        .{$social_class} li {
            margin-right: {$space_between_md}px !important;
        }
    }
    @media (min-width: 576px) and (max-width: 767px) {
        .{$social_class} li {
            margin-right: {$space_between_sm}px !important;
        }
    }
    @media (max-width: 575px) {
        .{$social_class} li {
            margin-right: {$space_between_mb}px !important;
        }
    }
CSS;

$wrapper_classes[] = $social_class;
GSF()->customCss()->addCss($social_css);

$class_to_filter = implode(' ', array_filter($wrapper_classes));
$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts);

?>
<div class="<?php echo esc_attr($css_class) ?>">
	<?php if(function_exists( 'G5Plus_Lustria' )): ?>
		<?php G5Plus_Lustria()->templates()->social_networks(explode( ',', $social_networks ), $social_shape, $social_size); ?>
	<?php endif; ?>
</div>