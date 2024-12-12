<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $title
 * @var $title_color
 * @var $layout_style
 * @var $space_between
 * @var $title_text_shadow_color
 * @var $title_font_size
 * @var $title_line_height
 * @var $title_letter_spacing
 * @var $sub_title
 * @var $sub_title_font_size
 * @var $sub_title_letter_spacing
 * @var $sub_title_color
 * @var $custom_sub_title_color
 * @var $icon_font
 * @var $text_align
 * @var $title_use_theme_fonts
 * @var $title_typography
 * @var $sub_title_use_theme_fonts
 * @var $sub_title_typography
 * @var $css_animation
 * @var $animation_duration
 * @var $animation_delay
 * @var $el_class
 * @var $css
 * @var $responsive
 * Shortcode class
 * @var $this WPBakeryShortCode_GSF_Heading
 */
$layout_style = $title = $title_font_size = $title_color = $space_between = $title_text_shadow_color = $title_line_height = $title_letter_spacing = $sub_title = $sub_title_font_size =
$sub_title_letter_spacing = $sub_title_color = $custom_sub_title_color = $icon_font = $text_align = $title_use_theme_fonts =
$title_typography = $sub_title_use_theme_fonts = $sub_title_typography =
$css_animation = $animation_duration = $animation_delay = $el_class = $css = $responsive = '';
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);

$wrapper_classes = array(
	'gf-heading',
	'gf-heading-' . $layout_style,
	G5P()->core()->vc()->customize()->getExtraClass($el_class),
	$this->getCSSAnimation($css_animation),
	vc_shortcode_custom_css_class($css),
	$responsive
);

if ('' !== $css_animation && 'none' !== $css_animation) {
	$animation_class = G5P()->core()->vc()->customize()->get_animation_class($animation_duration, $animation_delay);
	$wrapper_classes[] = $animation_class;
}

$heading_class = 'gf-heading-' . uniqid();
$heading_css = '';
if (!empty($title)) {
	$title_line_height = str_replace('|', '', $title_line_height);
	$title_font_sizes = explode('|', $title_font_size);
	$title_font_size = $title_font_sizes[0];
	$title_font_size_lg = (!isset($title_font_sizes[1]) || empty($title_font_sizes[1]) || intval($title_font_sizes[1]) <= 0) ? $title_font_size : $title_font_sizes[1];
	$title_font_size_md = (!isset($title_font_sizes[2]) || empty($title_font_sizes[2]) || intval($title_font_sizes[2]) <= 0) ? $title_font_size_lg : $title_font_sizes[2];
	$title_font_size_sm = (!isset($title_font_sizes[3]) || empty($title_font_sizes[3]) || intval($title_font_sizes[3]) <= 0) ? $title_font_size_md : $title_font_sizes[3];
	$title_font_size_mb = (!isset($title_font_sizes[4]) || empty($title_font_sizes[4]) || intval($title_font_sizes[4]) <= 0) ? $title_font_size_sm : $title_font_sizes[4];

	if (!empty($title_font_size)) {
		$heading_css .= <<<CSS
        .{$heading_class} .heading-title {
            font-size: {$title_font_size}px !important;
        }
        @media (min-width: 992px) and (max-width: 1199px) {
            .{$heading_class} .heading-title {
                font-size: {$title_font_size_lg}px !important;
            }
        }
        @media (min-width: 768px) and (max-width: 991px) {
            .{$heading_class} .heading-title {
                font-size: {$title_font_size_md}px !important;
            }
        }
        @media (min-width: 576px) and (max-width: 767px) {
            .{$heading_class} .heading-title {
                font-size: {$title_font_size_sm}px !important;
            }
        }
        @media (max-width: 575px) {
            .{$heading_class} .heading-title {
                font-size: {$title_font_size_mb}px !important;
            }
        }
CSS;

	}

	if (!empty($title_color)) {
		$heading_css .= <<<CSS
         .{$heading_class} .heading-title {
            color: {$title_color} !important;
        }
CSS;

	}

	if ('on' !== $title_use_theme_fonts) {
		$title_typography = $this->get_font_attrs($title_typography);
		$heading_css .= <<<CSS
    .{$heading_class} .heading-title {
        font-family: {$title_typography[0]} !important;
        font-weight: {$title_typography[2]} !important;
        font-style: {$title_typography[3]} !important;
}
CSS;
	}


	$title_letter_spacing = str_replace('|', '', $title_letter_spacing);
	if (!empty($title_letter_spacing) && !in_array($title_letter_spacing, array('px', 'em', '%'))) {
		$heading_css .= <<<CSS
    .{$heading_class} .heading-title {
        letter-spacing: {$title_letter_spacing} !important;
}
CSS;
	}
}
if (!empty($space_between)) {
	$space_between = str_replace('|', '', $space_between);
	if (!empty($space_between)) {
		if ($layout_style === 'style-1') {
			$heading_css .= <<<CSS
            .{$heading_class} .heading-sub-title{
                margin-bottom: {$space_between} !important;
            }
CSS;
		} else {
			$heading_css .= <<<CSS
            .{$heading_class} .heading-sub-title{
                margin-top: {$space_between} !important;
            }
CSS;

		}
	}

}
$title_line_height = str_replace('|', '', $title_line_height);
if (!empty($title_line_height) && !in_array($title_line_height, array('px', 'em', '%'))) {
	$heading_css .= <<<CSS
.{$heading_class} .heading-title {
            line-height: {$title_line_height} !important;
        }
CSS;
}
if (!empty($sub_title)) {
	$sub_title_letter_spacing = str_replace('|', '', $sub_title_letter_spacing);
	if (!empty($sub_title_letter_spacing) && !in_array($sub_title_letter_spacing, array('px', 'em', '%'))) {
		$heading_css .= <<<CSS
.{$heading_class} .heading-sub-title {
            letter-spacing: {$sub_title_letter_spacing} !important;
        }
CSS;
	}


	if ('on' !== $sub_title_use_theme_fonts) {
		$sub_title_typography = $this->get_font_attrs($sub_title_typography);
		$heading_css .= <<<CSS
    .{$heading_class} .heading-sub-title {
        font-family: {$sub_title_typography[0]} !important;
        font-weight: {$sub_title_typography[2]} !important;
        font-style: {$sub_title_typography[3]} !important;
    }
CSS;
	}

	$sub_title_font_sizes = explode('|', $sub_title_font_size);
	$sub_title_font_size = $sub_title_font_sizes[0];
	$sub_title_font_size_lg = (!isset($sub_title_font_sizes[1]) || empty($sub_title_font_sizes[1]) || intval($sub_title_font_sizes[1]) <= 0) ? $sub_title_font_size : $sub_title_font_sizes[1];
	$sub_title_font_size_md = (!isset($sub_title_font_sizes[2]) || empty($sub_title_font_sizes[2]) || intval($sub_title_font_sizes[2]) <= 0) ? $sub_title_font_size_lg : $sub_title_font_sizes[2];
	$sub_title_font_size_sm = (!isset($sub_title_font_sizes[3]) || empty($sub_title_font_sizes[3]) || intval($sub_title_font_sizes[3]) <= 0) ? $sub_title_font_size_md : $sub_title_font_sizes[3];
	$sub_title_font_size_mb = (!isset($sub_title_font_sizes[4]) || empty($sub_title_font_sizes[4]) || intval($sub_title_font_sizes[4]) <= 0) ? $sub_title_font_size_sm : $sub_title_font_sizes[4];


	if (!empty($sub_title_font_size)) {
		$heading_css .= <<<CSS
         .{$heading_class} .heading-sub-title {
            font-size: {$sub_title_font_size}px !important;
        }
        
        @media (min-width: 992px) and (max-width: 1199px) {
            .{$heading_class} .heading-sub-title {
                font-size: {$sub_title_font_size_lg}px !important;
            }
        }
        
        @media (min-width: 768px) and (max-width: 991px) {
            .{$heading_class} .heading-sub-title {
                font-size: {$sub_title_font_size_md}px !important;
            }
        }
        
        @media (min-width: 576px) and (max-width: 767px) {
            .{$heading_class} .heading-sub-title {
                font-size: {$sub_title_font_size_sm}px !important;
            }
        }
        
        @media (max-width: 575px) {
            .{$heading_class} .heading-sub-title {
                font-size: {$sub_title_font_size_mb}px !important;
            }
        }

CSS;
	}
}

$heading_sub_title_classes = array('heading-sub-title');
if ($sub_title_color === 'custom' && $custom_sub_title_color !== '') {
	$heading_css .= <<<CSS
    .{$heading_class} .heading-sub-title {
        color: {$custom_sub_title_color} !important;     
    }
CSS;
}

if ($sub_title_color !== 'custom') {
	$heading_sub_title_classes[] = $sub_title_color;
}

GSF()->customCss()->addCss($heading_css);

$heading_inner_classes = array('gf-heading-inner', $text_align);
if (!empty($heading_css)) {
	$heading_inner_classes[] = $heading_class;
}


$class_to_filter = implode(' ', array_filter($wrapper_classes));
$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts);
?>
<?php if (!empty($title) || !empty($sub_title) || !empty($content)): ?>
    <div class="<?php echo esc_attr($css_class) ?>">
        <div class="<?php echo esc_attr(implode(' ', $heading_inner_classes)) ?>">
			<?php if ('style-1' === $layout_style) { ?>
				<?php if (!empty($sub_title)): ?>
                    <span class="<?php echo esc_attr(implode(' ', $heading_sub_title_classes)) ?>"><?php echo wp_kses_post($sub_title); ?></span>
				<?php endif; ?>
			<?php } ?>
			<?php if (!empty($title)): ?>
                <h4 class="heading-title"><?php echo wp_kses_post($title) ?></h4>
			<?php endif; ?>
			<?php if ('style-2' === $layout_style) { ?>
				<?php if (!empty($sub_title)): ?>
                    <span class="<?php echo esc_attr(implode(' ', $heading_sub_title_classes)) ?>"><?php echo wp_kses_post($sub_title); ?></span>
				<?php endif; ?>
			<?php } ?>
        </div>
    </div>
<?php endif; ?>