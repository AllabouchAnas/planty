<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $bullet_type
 * @var $bullet_style
 * @var $bullet_color
 * @var $label_color
 * @var $icon_font
 * @var $values
 * @var $css_animation
 * @var $animation_duration
 * @var $animation_delay
 * @var $el_class
 * @var $css
 * @var $custom_onclick
 * @var $custom_onclick_code
 * @var $responsive
 * Shortcode class
 * @var $this WPBakeryShortCode_GSF_Lists
 */
$bullet_type = $bullet_style = $bullet_color = $label_color = $icon_font = $values =
$css_animation = $animation_duration = $animation_delay = $el_class = $css = $custom_onclick = $custom_onclick_code = $responsive = '';
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);

$wrapper_classes = array(
	'gsf-lists',
	'clearfix',
	$bullet_type,
	G5P()->core()->vc()->customize()->getExtraClass($el_class),
	$this->getCSSAnimation($css_animation),
	vc_shortcode_custom_css_class($css),
	$responsive
);
if ($bullet_type === 'list-icon') {
	$wrapper_classes[] = $bullet_style;
}

if ('' !== $css_animation && 'none' !== $css_animation) {
	$animation_class = G5P()->core()->vc()->customize()->get_animation_class($animation_duration, $animation_delay);
	$wrapper_classes[] = $animation_class;
}
$lists_class = 'gsf-lists-' . uniqid();
$lists_css = '';
if (!empty($bullet_color)) {
	$lists_css .= <<<CSS
    .{$lists_class} li,
    .{$lists_class} li .list-bullet {
        color: {$bullet_color};
        border-color: {$bullet_color} !important;
    }
CSS;
}
if (!empty($label_color)) {
	$lists_css .= <<<CSS
        .{$lists_class} li .list-label {
        color: {$label_color};    
    }
CSS;
}

GSF()->customCss()->addCss($lists_css);
$wrapper_classes[] = $lists_class;
$values = (array)vc_param_group_parse_atts($values);
$index = 1;

$class_to_filter = implode(' ', array_filter($wrapper_classes));
$class_to_filter .= vc_shortcode_custom_css_class($css, ' ');
$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts);



if (!empty($values)): ?>
    <ul class="<?php echo esc_attr($css_class) ?>">
		<?php foreach ($values as $value) : ?>
			<?php
			$li_classes = '';
			$item_bullet_color = isset($value['bullet_color']) ? $value['bullet_color'] : '';
			$item_label_color = isset($value['label_color']) ? $value['label_color'] : '';
			$item_icon_font = isset($value['icon_font']) ? $value['icon_font'] : '';
			if ((!empty($item_bullet_color) && $item_bullet_color != $bullet_color) || (!empty($item_label_color) && $item_label_color != $label_color)) {
				$item_bullet_color = empty($item_bullet_color) ? $bullet_color : $item_bullet_color;
				$item_label_color = empty($item_label_color) ? $label_color : $item_label_color;
				$li_classes = 'list-item-' . uniqid();
				$li_item_css = <<<CSS
                .gsf-lists li.{$li_classes},
                .gsf-lists li.{$li_classes} .list-bullet {
                    color: {$item_bullet_color};
                    border-color: {$item_bullet_color} !important;
                }
                .gsf-lists li.{$li_classes} .list-label {
                    color: {$item_label_color};
                }
CSS;
				GSF()->customCss()->addCss($li_item_css);
			}
			$item_custom_bullet = isset($value['custom_bullet']) ? $value['custom_bullet'] : '';
			$item_icon_font = empty($item_icon_font) ? $icon_font : $item_icon_font;
			?>
            <li class="list-item <?php echo esc_attr($li_classes); ?>">
				<?php if (!empty($item_custom_bullet)): ?>
                    <span class="list-bullet"><?php echo esc_attr($item_custom_bullet); ?></span>
				<?php elseif ($bullet_type === 'list-icon' && !empty($item_icon_font)) : ?>
                    <span class="list-bullet"><i class="<?php echo esc_attr($item_icon_font); ?>"></i></span>
				<?php elseif ($bullet_type === 'list-number'): ?>
                    <span class="list-bullet"><?php echo esc_html($index); ?>.</span>
				<?php endif;
				if (!empty($value['label'])) :?>
                    <p class="list-label"><?php echo esc_html($value['label']); ?></p>
				<?php endif; ?>
            </li>
			<?php $index++; ?>
		<?php endforeach; ?>
    </ul>
<?php endif; ?>
