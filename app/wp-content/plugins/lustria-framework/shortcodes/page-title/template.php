<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $use_theme_fonts
 * @var $typography
 * @var $font_container
 * @var $title_font_size
 * @var $css_animation
 * @var $animation_duration
 * @var $animation_delay
 * @var $el_class
 * @var $css
 * @var $responsive
 * Shortcode class
 * @var $this WPBakeryShortCode_GSF_Page_Title
 */
$use_theme_fonts = $font_container = $title_font_size =
$typography = $css_animation = $animation_duration = $animation_delay = $el_class = $css = $responsive = '';
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);

$wrapper_classes = array(
	'page-title-container',
	G5P()->core()->vc()->customize()->getExtraClass($el_class),
	$this->getCSSAnimation($css_animation),
	vc_shortcode_custom_css_class( $css ),
	$responsive
);

if ('' !== $css_animation && 'none' !== $css_animation) {
	$animation_class = G5P()->core()->vc()->customize()->get_animation_class($animation_duration, $animation_delay);
	$wrapper_classes[] = $animation_class;
}
$attributes = $this->get_font_container_attributes($font_container);
$title_class = 'gf-page-title-' . uniqid();
$title_css = '';
$title_font_sizes = explode('|', $title_font_size);
$title_font_size = $title_font_sizes[0];
$title_font_size_lg = (! isset($title_font_sizes[1]) || empty($title_font_sizes[1]) || intval($title_font_sizes[1]) <=0) ? $title_font_size : $title_font_sizes[1];
$title_font_size_md = (! isset($title_font_sizes[2]) || empty($title_font_sizes[2]) || intval($title_font_sizes[2]) <=0) ? $title_font_size_lg : $title_font_sizes[2];
$title_font_size_sm = (! isset($title_font_sizes[3]) || empty($title_font_sizes[3]) || intval($title_font_sizes[3]) <=0) ? $title_font_size_md : $title_font_sizes[3];
$title_font_size_mb = (! isset($title_font_sizes[4]) || empty($title_font_sizes[4]) || intval($title_font_sizes[4]) <=0) ? $title_font_size_sm : $title_font_sizes[4];

$title_css .= <<<CSS
        .{$title_class} {
            color: {$attributes['color']} !important;
            font-size: {$title_font_size}px !important;
        }
        @media (max-width: 1199px) {
            .{$title_class} {
                font-size: {$title_font_size_lg}px !important;
            }
        }
        @media (max-width: 991px) {
            .{$title_class} {
                font-size: {$title_font_size_md}px !important;
            }
        }
        @media (max-width: 767px) {
            .{$title_class} {
                font-size: {$title_font_size_sm}px !important;
            }
        }
        @media (max-width: 575px) {
            .{$title_class} {
                font-size: {$title_font_size_mb}px !important;
            }
        }
CSS;
$title_classes = array(
    'mg-top-0',
    $attributes['text_align'],
    $title_class
);
if('on' !== $use_theme_fonts) {
    $typography = $this->get_font_attrs($typography);
    $title_css .= <<<CSS
        .{$title_class} {
            font-family: {$typography[0]} !important;
            font-weight: {$typography[2]} !important;
            font-style: {$typography[3]} !important;
        }
CSS;
}

GSF()->customCss()->addCss($title_css);
$title_class = implode(' ', array_filter($title_classes));
$wrapper_class = implode(' ', array_filter($wrapper_classes));
?>
<div class="<?php echo esc_attr($wrapper_class) ?>">
	<?php $page_title = '';
	if(function_exists( 'G5Plus_Lustria' )){
		$page_title = G5Plus_Lustria()->helper()->get_page_title();
	}
	?>
    <h1 class="<?php echo esc_attr($title_class) ?>"><?php echo esc_html($page_title); ?></h1>
</div>