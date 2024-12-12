<?php
/**
 * Shortcode attributes
 * @var $space_between
 * @var $atts
 * @var $layout_style
 * @var $title
 * @var $sub_title
 * @var $use_theme_fonts
 * @var $typography
 * @var $title_font_size
 * @var $title_letter_spacing
 * @var $title_line_height
 * @var $link
 * @var $sub_title
 * @var $sub_title_font_size
 * @var $sub_title_letter_spacing
 * @var $sub_title_color
 * @var $custom_sub_title_color
 * @var $sub_title_use_theme_fonts
 * @var $sub_title_typography
 * @var $title_color
 * @var $ib_bg_color
 * @var $ib_box_shadow
 * @var $icon_type
 * @var $image
 * @var $icon_font
 * @var $icon_bg_style
 * @var $icon_color
 * @var $icon_bg_color
 * @var $ib_icon_box_shadow
 * @var $icon_size
 * @var $icon_align
 * @var $distance_between
 * @var $flip_on_hover
 * @var $flip_bg_image
 * @var $hover_bg_color
 * @var $ib_hover_box_shadow
 * @var $hover_text_color
 * @var $icon_hover_color
 * @var $css_animation
 * @var $animation_duration
 * @var $animation_delay
 * @var $el_class
 * @var $css
 * @var $responsive
 * Shortcode class
 * @var $this WPBakeryShortCode_GSF_Info_Box
 */

$sub_title = $sub_title_typography = $sub_title_use_theme_fonts = $sub_title_letter_spacing = $sub_title_color = $sub_title_font_size = $title_line_height = $custom_sub_title_color = $space_between = $layout_style = $title = $sub_title = $use_theme_fonts = $typography = $title_font_size = $sub_title_font_size = $title_letter_spacing = $link = $title_color = $ib_bg_color =
$ib_box_shadow = $icon_type = $image = $icon_font = $icon_bg_style = $icon_color = $icon_bg_color = $ib_icon_box_shadow = $icon_size = $icon_align = $distance_between =
$flip_on_hover = $flip_bg_image = $hover_bg_color = $ib_hover_box_shadow = $hover_text_color = $icon_hover_color =
$css_animation = $animation_duration = $animation_delay = $el_class = $css = $responsive = '';

$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);

if (!in_array($layout_style, array('ib-left', 'ib-right'))) {
	$icon_align = '';
}
if (!in_array($layout_style, array('text-left', 'text-center', 'text-right'))) {
	$distance_between = '';
}
if ($icon_bg_style == 'icon-classic') $ib_icon_box_shadow = '';
$wrapper_classes = array(
	'gsf-info-box',
	$layout_style,
	'clearfix',
	$icon_align,
	$icon_bg_style,
	$icon_size,
	$distance_between,
	G5P()->core()->vc()->customize()->getExtraClass($el_class),
	$this->getCSSAnimation($css_animation),
	vc_shortcode_custom_css_class($css),
	$responsive
);

// animation
if ('' !== $css_animation && 'none' !== $css_animation) {
	$animation_class = G5P()->core()->vc()->customize()->get_animation_class($animation_duration, $animation_delay);
	$wrapper_classes[] = $animation_class;
}
if (empty($icon_bg_color)) $icon_bg_color = $icon_color;
if (empty($icon_hover_color)) $icon_hover_color = $icon_color;
$ib_custom_class = 'info-box-' . uniqid();
$title_font_sizes = explode('|', $title_font_size);
$title_font_size = $title_font_sizes[0];
$title_font_size_lg = (!isset($title_font_sizes[1]) || empty($title_font_sizes[1]) || intval($title_font_sizes[1]) <= 0) ? $title_font_size : $title_font_sizes[1];
$title_font_size_md = (!isset($title_font_sizes[2]) || empty($title_font_sizes[2]) || intval($title_font_sizes[2]) <= 0) ? $title_font_size_lg : $title_font_sizes[2];
$title_font_size_sm = (!isset($title_font_sizes[3]) || empty($title_font_sizes[3]) || intval($title_font_sizes[3]) <= 0) ? $title_font_size_md : $title_font_sizes[3];
$title_font_size_mb = (!isset($title_font_sizes[4]) || empty($title_font_sizes[4]) || intval($title_font_sizes[4]) <= 0) ? $title_font_size_sm : $title_font_sizes[4];
$icon_box_css = <<<CSS
    @media (min-width: 992px) and (max-width: 1199px) {
        .{$ib_custom_class} .info-box-title {
            font-size: {$title_font_size_lg}px !important;
        }
    }
    @media (min-width: 768px) and (max-width: 991px) {
        .{$ib_custom_class} .info-box-title {
            font-size: {$title_font_size_md}px !important;
        }
    }
    @media (min-width: 576px) and (max-width: 767px) {
        .{$ib_custom_class} .info-box-title {
            font-size: {$title_font_size_sm}px !important;
        }
    }
    @media (max-width: 575px) {
        .{$ib_custom_class} .info-box-title {
            font-size: {$title_font_size_mb}px !important;
        }
    }
	.{$ib_custom_class}:hover .info-box-title{
	 	color:  {$hover_text_color}!important;
	 }

CSS;
if (!empty($hover_text_color)) {
	$icon_box_css .= <<<CSS
	.{$ib_custom_class}:hover .info-box-title{
	 	color:  {$hover_text_color}!important;
	 }
CSS;
}
if (!empty($ib_bg_color)) {
	$icon_box_css .= <<<CSS
	 .{$ib_custom_class} .ib-content{
	 	background-color:  {$ib_bg_color}!important;
	 }
CSS;
}
if (!empty($ib_box_shadow)) {
	$icon_box_css .= <<<CSS
	 .{$ib_custom_class} {
        box-shadow: 0 33px 43px 0 {$ib_box_shadow};
    }
CSS;
}

if (!empty($ib_icon_box_shadow)) {
	$icon_box_css .= <<<CSS
	 .{$ib_custom_class} .ib-shape-inner {
        box-shadow: 0 2px 20px 0 {$ib_icon_box_shadow};
    }
CSS;
}
if (!empty($title_color)) {
	$icon_box_css .= <<<CSS
              .{$ib_custom_class} .info-box-title {
                 color:{$title_color} !important;
               }
CSS;

}
if (!empty($title_line_height)) {
	$title_line_height = str_replace('|', '', $title_line_height);
	if (!empty($title_line_height) && !in_array($title_line_height, array('px', 'em', '%'))) {
		$icon_box_css .= <<<CSS
              .{$ib_custom_class} .info-box-title {
                 line-height: {$title_line_height} !important;
               }
CSS;
	}
}
if (!empty($title_font_size)) {
	$title_font_size = str_replace('|', '', $title_font_size);
	if (!empty($title_font_size) && !in_array($title_font_size, array('px', 'em', '%'))) {
		$icon_box_css .= <<<CSS
              .{$ib_custom_class} .info-box-title {
                 font-size: {$title_font_size}px;
               }
CSS;
	}
}
if (!empty($title_letter_spacing)) {
	$title_letter_spacing = str_replace('|', '', $title_letter_spacing);
	if (!empty($title_letter_spacing) && !in_array($title_letter_spacing, array('px', 'em', '%'))) {
		$icon_box_css .= <<<CSS
              .{$ib_custom_class} .info-box-title {
                 letter-spacing: {$title_letter_spacing};
    }
CSS;
	}
}
if (!empty($space_between)) {
	$space_between = str_replace('|', '', $space_between);
	if (!empty($space_between) && !in_array($space_between, array('px', 'em', '%'))) {
		$icon_box_css .= <<<CSS
            .{$ib_custom_class} .info-box-title {
                margin-bottom: {$space_between} !important;
            }
CSS;
	}
}
if (!empty($ib_hover_box_shadow)) {
	$icon_box_css .= <<<CSS
	 .{$ib_custom_class}:hover {
        box-shadow: 0 33px 43px 0 {$ib_hover_box_shadow};
    }
CSS;
}
if (in_array($icon_bg_style, array('icon-bg-circle-fill', 'icon-bg-square-fill', 'icon-float-on-circle'))) {
	$icon_box_css .= <<<CSS
        .{$ib_custom_class} .ib-shape-inner{
            background-color: {$icon_bg_color} !important;
            color: {$icon_color} !important;
        }
        .{$ib_custom_class} .ib-shape-inner:before{
            border-color: {$icon_bg_color} !important;
        }
CSS;
} elseif (in_array($icon_bg_style, array('icon-bg-circle-outline', 'icon-bg-square-outline'))) {
	$icon_box_css .= <<<CSS
        .{$ib_custom_class} .ib-shape-inner {
            border-color: {$icon_bg_color} !important;
            color: {$icon_color};
        }
CSS;
} else {
	if (!empty($icon_color)) {
		$icon_box_css .= <<<CSS
        .{$ib_custom_class} .ib-shape-inner {
            color: {$icon_color};
        }
CSS;
	}
}
if ('on' == $ib_box_shadow) {
	$wrapper_classes[] = 'ib-shadow';
}
if ('on' !== $use_theme_fonts) {
	$typography = $this->get_font_attrs($typography);
	$icon_box_css .= <<<CSS
        .{$ib_custom_class} .info-box-title {
            font-family: {$typography[0]} !important;
            font-weight: {$typography[2]} !important;
            font-style: {$typography[3]} !important;
        }
CSS;
}

if ('on' === $flip_on_hover) {
	$wrapper_classes[] = 'flip-on-hover';
	if (!empty($flip_bg_image)) {
		$image_src = '';
		if ('icon-classic' === $icon_bg_style) {
			$img = wp_get_attachment_image_src($flip_bg_image, 'full');
			if (is_array($img) && isset($img[0])) {
				$image_src = $img[0];
			}
		}
		$icon_box_css .= <<<CSS
        .{$ib_custom_class} .ib-flip-content {
            background-image: url('{$image_src}');
        }
CSS;
	}
} else {
	if (empty($hover_bg_color)) $hover_bg_color = $ib_bg_color;
	$icon_box_css .= <<<CSS
	 .{$ib_custom_class}:hover{
	 	background-color:  {$hover_bg_color}!important;
	 }
	.{$ib_custom_class}:hover .ib-shape-inner i {
	 	color:  {$icon_hover_color} !important;
	 	background-image: none;
	 }
CSS;
}


if (!empty($sub_title)) {
	$sub_title_letter_spacing = str_replace('|', '', $sub_title_letter_spacing);
	if (!empty($sub_title_letter_spacing) && !in_array($sub_title_letter_spacing, array('px', 'em', '%'))) {
		$icon_box_css .= <<<CSS
.{$ib_custom_class} .ib-sub-title {
            letter-spacing: {$sub_title_letter_spacing} !important;
        }
CSS;
	}
	if ('on' !== $sub_title_use_theme_fonts) {
		$sub_title_typography = $this->get_font_attrs($sub_title_typography);
		$icon_box_css .= <<<CSS
    .{$ib_custom_class} .ib-sub-title {
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
		$icon_box_css .= <<<CSS
         .{$ib_custom_class} .ib-sub-title {
            font-size: {$sub_title_font_size}px !important;
        }
        
        @media (min-width: 992px) and (max-width: 1199px) {
            .{$ib_custom_class} .ib-sub-title {
                font-size: {$sub_title_font_size_lg}px !important;
            }
        }
        
        @media (min-width: 768px) and (max-width: 991px) {
            .{$ib_custom_class} .ib-sub-title {
                font-size: {$sub_title_font_size_md}px !important;
            }
        }
        
        @media (min-width: 576px) and (max-width: 767px) {
            .{$ib_custom_class} .ib-sub-title {
                font-size: {$sub_title_font_size_sm}px !important;
            }
        }
        
        @media (max-width: 575px) {
            .{$ib_custom_class} .ib-sub-title {
                font-size: {$sub_title_font_size_mb}px !important;
            }
        }

CSS;
	}
}
$ib_box_sub_title_classes = array('ib-sub-title');
if ($sub_title_color === 'custom' && $custom_sub_title_color !== '') {
	$icon_box_css .= <<<CSS
    .{$ib_custom_class} .ib-sub-title {
        color: {$custom_sub_title_color} !important;     
    }
CSS;
}

if ($sub_title_color !== 'custom') {
	$ib_box_sub_title_classes[] = $sub_title_color;
}


GSF()->customCss()->addCss($icon_box_css);
$wrapper_classes[] = $ib_custom_class;

$ib_class = array(
	'ib-shape-inner'
);
$ib_content_classes = array(
	'ib-content'
);
if (!empty($sub_title)) {
	$ib_content_classes[] = 'ib-has-sub-title';
}
//parse link
$link_attributes = $title_attributes = array();
$link = ('||' === $link) ? '' : $link;
$link = vc_build_link($link);
$use_link = false;
$link_title = esc_attr__('Learn More', 'lustria-framework');
if (strlen($link['url']) > 0) {
	$use_link = true;
	$link_attributes[] = 'href="' . esc_url(trim($link['url'])) . '"';
	if (strlen($link['target']) > 0) {
		$link_attributes[] = 'target="' . trim($link['target']) . '"';
	}
	if (strlen($link['rel']) > 0) {
		$link_attributes[] = 'rel="' . trim($link['rel']) . '"';
	}
	$title_attributes = $link_attributes;
	if (strlen($link['title']) > 0) {
		$link_attributes[] = 'title="' . trim($link['title']) . '"';
		$link_title = trim($link['title']);
	}

	if (!empty($title)) {
		$title_attributes[] = 'title="' . esc_attr(trim($title)) . '"';
	}
}

// icon html
$icon_html = '';
if ('icon' === $icon_type && !empty($icon_font)) {
	$icon_html = '<i class="' . esc_attr($icon_font) . '"></i>';
} elseif ('image' === $icon_type && !empty($image)) {
	$image_src = '';
	if ('icon-classic' === $icon_bg_style) {
		$img = wp_get_attachment_image_src($image, 'full');
		if (!empty($img) && isset($img[0])) {
			$image_src = $img[0];
		}
	} else {
		$img = G5P()->image_resize()->resize(array(
			'image_id' => $image,
			'width' => 160,
			'height' => 160
		));
		if (isset($img['url']) && ($img['url'] !== '')) {
			$image_src = $img['url'];
		}
	}
	if (!empty($image_src)) {
		$alt = '';
		if (!empty($title)) {
			$alt = sprintf(' alt="%s"', esc_attr($title));
		}
		$icon_html = '<img' . $alt . ' src="' . esc_url($image_src) . '">';
	}
}
$class_to_filter = implode(' ', array_filter($wrapper_classes));
$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->getShortcode(), $atts);


$sub_title = rawurldecode(base64_decode(strip_tags($sub_title)));
?>
<div class="<?php echo esc_attr($css_class) ?>">
    <div class="ib-content-wrap">
		<?php if ($layout_style == 'ib-left-inline'): ?>
			<?php if (!empty($title) || !empty($icon_html)): ?>
                <div class="<?php echo join(' ', $ib_content_classes); ?>">
                    <div class="ib-content-top">
                        <div class="ib-shape">
                            <div class="<?php echo implode(' ', $ib_class); ?>">
								<?php if ($use_link): ?>
                                    <a <?php echo implode(' ', $link_attributes); ?> class="transition03 gsf-link">
										<?php echo wp_kses_post($icon_html); ?>
                                    </a>
								<?php else:
									echo wp_kses_post($icon_html);
								endif; ?>
                            </div>
                        </div>
						<?php if (!empty($sub_title)): ?>
                        <div class="ib-main-info">
							<?php endif; ?>
							<?php if (!empty($title)):
								if ($use_link): ?>
                                    <h4 class="info-box-title"><a <?php echo implode(' ', $title_attributes); ?>
                                                class="transition03 gsf-link">
                                            <span><?php echo esc_attr($title) ?></span>
                                        </a></h4>
								<?php else: ?>
                                    <h4 class="info-box-title"><?php echo esc_attr($title) ?></h4>
								<?php endif;
							endif; ?>
							<?php if (!empty($sub_title)): ?>
                            <span class="<?php echo esc_attr(implode(' ', $ib_box_sub_title_classes)) ?> ib-sub-title"><?php echo wp_kses_post($sub_title); ?></span>
                        </div>
					<?php endif; ?>
                    </div>
                </div>
			<?php endif; ?>
		<?php elseif ($layout_style == 'ib-right-inline'): ?>
			<?php if (!empty($title) || !empty($icon_html)): ?>
                <div class="<?php echo join(' ', $ib_content_classes); ?>">
                    <div class="ib-content-top">
						<?php if (!empty($sub_title)): ?>
                        <div class="ib-main-info">
							<?php endif; ?>
							<?php if (!empty($title)):
								if ($use_link): ?>
                                    <h4 class="info-box-title"><a <?php echo implode(' ', $title_attributes); ?>
                                                class="transition03 gsf-link">
                                            <span><?php echo esc_attr($title) ?></span>
                                        </a></h4>
								<?php else: ?>
                                    <h4 class="info-box-title"><?php echo esc_attr($title) ?></h4>
								<?php endif;
							endif; ?>
							<?php if (!empty($sub_title)): ?>
                            <span class="<?php echo esc_attr(implode(' ', $ib_box_sub_title_classes)) ?>  ib-sub-title"<?php echo wp_kses_post($sub_title); ?></span>
                        </div>
					<?php endif; ?>
                        <div class="ib-shape">
                            <div class="<?php echo implode(' ', $ib_class); ?>">
								<?php if ($use_link): ?>
                                    <a <?php echo implode(' ', $link_attributes); ?> class="transition03 gsf-link">
										<?php echo wp_kses_post($icon_html); ?>
                                    </a>
								<?php else:
									echo wp_kses_post($icon_html);
								endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
			<?php endif; ?>
		<?php elseif ($layout_style != 'ib-right'): ?>
            <div class="ib-shape">
                <div class="<?php echo implode(' ', $ib_class); ?>">
					<?php if ($use_link): ?>
                        <a <?php echo implode(' ', $link_attributes); ?> class="transition03 gsf-link">
							<?php echo wp_kses_post($icon_html); ?>
                        </a>
					<?php else:
						echo wp_kses_post($icon_html);
					endif; ?>
                </div>
            </div>
			<?php if (!empty($title)): ?>
                <div class="<?php echo join(' ', $ib_content_classes); ?>">
					<?php if (!empty($sub_title)): ?>
                    <div class="ib-main-info">
						<?php endif; ?>
						<?php if (!empty($title)):
							if ($use_link): ?>
                                <h4 class="info-box-title"><a <?php echo implode(' ', $title_attributes); ?>
                                            class="transition03 gsf-link">
                                        <span><?php echo esc_attr($title) ?></span>
                                    </a></h4>
							<?php else: ?>
                                <h4 class="info-box-title"><?php echo esc_attr($title) ?></h4>
							<?php endif;
						endif;
						if (!empty($sub_title)): ?>
                        <span class="<?php echo esc_attr(implode(' ', $ib_box_sub_title_classes)) ?> ib-sub-title"><?php echo wp_kses_post($sub_title); ?></span>
                    </div>
				<?php endif; ?>
                </div>
			<?php endif; ?>
		<?php else: ?>
			<?php if (!empty($title)): ?>
                <div class="<?php echo join(' ', $ib_content_classes); ?>">
					<?php if (!empty($sub_title)): ?>
                    <div class="ib-main-info">
						<?php endif; ?>
						<?php if (!empty($title)):
							if ($use_link): ?>
                                <h4 class="info-box-title"><a <?php echo implode(' ', $title_attributes); ?>
                                            class="transition03 gsf-link">
                                        <span><?php echo esc_attr($title) ?></span>
                                    </a></h4>
							<?php else: ?>
                                <h4 class="info-box-title"><?php echo esc_attr($title) ?></h4>
							<?php endif;
						endif;
						if (!empty($sub_title)): ?>
                        <span class="<?php echo esc_attr(implode(' ', $ib_box_sub_title_classes)) ?>  ib-sub-title"><?php echo wp_kses_post($sub_title); ?></span>
                    </div>
				<?php endif; ?>
                </div>
			<?php endif; ?>
            <div class="ib-shape">
                <div class="<?php echo implode(' ', $ib_class); ?>">
					<?php if ($use_link): ?>
                        <a <?php echo implode(' ', $link_attributes); ?> class="transition03 gsf-link">
							<?php echo wp_kses_post($icon_html); ?>
                        </a>
					<?php else:
						echo wp_kses_post($icon_html);
					endif; ?>
                </div>
            </div>
		<?php endif; ?>
    </div>
	<?php if ('on' === $flip_on_hover): ?>
        <div class="ib-flip-content">
            <a <?php echo implode(' ', $title_attributes); ?>
                    class="btn btn-outline btn-md btn-white"><?php echo esc_attr($link_title); ?></a>
        </div>
	<?php endif; ?>
</div>
