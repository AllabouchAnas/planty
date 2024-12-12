<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $layout_style
 * @var $hover_effect
 * @var $image
 * @var $link
 * @var $banner_title
 * @var $sub_title
 * @var $featured_title
 * @var $featured_color
 * @var $content
 * @var $height_mode
 * @var $height
 * @var $css_animation
 * @var $animation_duration
 * @var $animation_delay
 * @var $el_class
 * @var $css
 * @var $responsive
 * @var $background_postion
 * Shortcode class
 * @var $this WPBakeryShortCode_GSF_Banner
 */

$layout_style = $hover_effect = $image = $link = $banner_title = $sub_title = $featured_title = $featured_color = $height_mode = $height =
$css_animation = $animation_duration = $animation_delay = $el_class = $css = $responsive = '';
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);

$image_src = $img_width = $img_height = '';
$image_arr = wp_get_attachment_image_src($image, 'full');
if (is_array($image_arr)) {
	list($image_src, $img_width, $img_height) = $image_arr;
}

$has_featured = '';
if (!empty($featured_title)) {
	$has_featured = "has-featured";
}
$wrapper_classes = array(
	'gf-banner',
	'gf-banner-' . $layout_style,
	$has_featured,
	G5P()->core()->vc()->customize()->getExtraClass($el_class),
	$this->getCSSAnimation($css_animation),
	vc_shortcode_custom_css_class($css),
	$responsive
);

if ('' !== $css_animation && 'none' !== $css_animation) {
	$animation_class = G5P()->core()->vc()->customize()->get_animation_class($animation_duration, $animation_delay);
	$wrapper_classes[] = $animation_class;
}

$banner_bg_class = array(
	'gf-banner-bg',
	'effect-content'
);

$link_attributes = $title_attributes = array();
$link = ('||' === $link) ? '' : $link;
$link = vc_build_link($link);
$use_link = false;
$title = '';
if (strlen($link['url']) > 0) {
	$use_link = true;
	$link_attributes[] = 'href="' . esc_url(trim($link['url'])) . '"';
	if (strlen($link['target']) > 0) {
		$link_attributes[] = 'target="' . trim($link['target']) . '"';
	}
	if (strlen($link['rel']) > 0) {
		$link_attributes[] = 'rel="' . trim($link['rel']) . '"';
	}
	if (strlen($link['title']) > 0) {
		$link_attributes[] = 'title="' . trim($link['title']) . '"';
		if (empty($title)) {
			$title = trim($link['title']);
		}
	} elseif (!empty($title)) {
		$link_attributes[] = 'title="' . trim($title) . '"';
	}
	if (empty($title)) {
		$wrapper_classes[] = 'gf_banner_link';
	}
}

$banner_class = 'gf-banner-' . random_int(1000, 9999);

$banner_css = '';
if (!empty($image_src)) {
	if ($height_mode != 'custom') {
		if ($height_mode === 'original') {
			$height_mode = ($img_height / $img_width) * 100;
		}
		$banner_css = <<<CSS
    .{$banner_class} .gf-banner-bg {
        background-image: url('{$image_src}');
        padding-bottom: {$height_mode}%;
    }
CSS;
	} else {

		$banner_css = <<<CSS
    .{$banner_class} .gf-banner-bg {
        background-image: url('{$image_src}');
        height: {$height};
    }
CSS;
	}
} else {
	$banner_css = <<<CSS
    .{$banner_class} .gf-banner-bg {
        background-color: #f9f9f9;
        padding-bottom: 75%;
    }
CSS;
}

if (!empty($featured_title)) {
	$banner_css .= <<<CSS
    .{$banner_class} .banner-featured-title {
        color: {$featured_color} !important;
    }
CSS;
}
GSF()->customCss()->addCss($banner_css);

$wrapper_classes[] = $banner_class;
$class_to_filter = implode(' ', array_filter($wrapper_classes));
$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->getShortcode(), $atts);
?>
<div class="<?php echo esc_attr($css_class) ?> <?php echo esc_attr($hover_effect); ?>">
    <div class="effect-bg-image">
        <div class="<?php echo join(' ', $banner_bg_class); ?> <?php echo esc_attr($background_postion); ?>">
        </div>
    </div>
    <div class="gf-banner-inner">

        <div class="gf-banner-content">
			<?php if (!empty($banner_title)): ?>
                <span class="banner-sub-title"><?php echo esc_html($sub_title); ?></span>
			<?php endif; ?>
			<?php if (!empty($sub_title)): ?>
                <h4 class="banner-title"><?php echo esc_html($banner_title); ?></h4>
			<?php endif; ?>
			<?php if (!empty($title)): ?>
                <div class="banner-action">
					<?php if ($use_link): ?>
                        <a <?php echo implode(' ', $link_attributes); ?>
                                class="btn btn-accent btn-link btn-md btn-icon btn-icon-right"><?php echo esc_html($title); ?>
                            <i class="fal fa-arrow-right"></i></a>
					<?php else: ?>
                        <button class="btn btn-accent btn-link btn-md btn-icon btn-icon-right"><?php echo esc_html($title); ?>
                            <i class="fal fa-arrow-right"></i></button>
					<?php endif; ?>
                </div>
			<?php endif; ?>
        </div>

    </div>
</div>