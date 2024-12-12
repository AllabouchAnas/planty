<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $title
 * @var $menu_items
 * @var $css_animation
 * @var $animation_duration
 * @var $animation_delay
 * @var $el_class
 * @var $css
 * @var $icon_font
 * @var $responsive
 * Shortcode class
 * @var $this WPBakeryShortCode_GSF_Menu_Column
 */

$icon_font = $title = $menu_items = $css_animation = $animation_duration = $animation_delay = $el_class = $css = $responsive = '';
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);

$wrapper_classes = array(
	'gsf-menu-column',
	G5P()->core()->vc()->customize()->getExtraClass($el_class),
	$this->getCSSAnimation($css_animation),
	vc_shortcode_custom_css_class( $css ),
	$responsive
);

if ('' !== $css_animation && 'none' !== $css_animation) {
	$animation_class = G5P()->core()->vc()->customize()->get_animation_class($animation_duration, $animation_delay);
	$wrapper_classes[] = $animation_class;
}

$class_to_filter = implode(' ', array_filter($wrapper_classes));
$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts);
?>
<div class="<?php echo esc_attr($css_class) ?>">
    <?php if(!empty($title)): ?>
        <h4 class="x-menu-heading" >
            <?php if(!empty($icon_font)): ?>
                <i class="accent-color text-left <?php echo esc_attr($icon_font); ?>"></i>
            <?php endif; ?>
            <span><?php echo wp_kses_post($title); ?></span>
        </h4>
    <?php endif; ?>
    <?php
    $menu_items = (array)vc_param_group_parse_atts($menu_items);
    if(is_array($menu_items) && count($menu_items) > 0): ?>
        <ul class="x-menu-list">
            <?php foreach ($menu_items as $item):
                if(!isset($item['label']) && empty($item['label'])) {
                    continue;
                }
                $link_attr = array();
                $link_html = '';
                $link = ('||' === $item['link']) ? '' : $item['link'];
                $link = vc_build_link($link);
                if (strlen($link['url']) > 0) {
                    $link_attr[] = 'href="' . esc_url(trim($link['url'])) . '"';
                } else {
                    $link_attr[] = 'href="#"';
                }
                if (!empty($link['title'])) {
                    $link_attr[] = 'title="' . esc_attr(trim($link['title'])) . '"';
                }
                if (!empty($link['target'])) {
                    $link_attr[] = 'target="' . esc_attr(trim($link['target'])) . '"';
                }
                if (!empty($link['rel'])) {
                    $link_attr[] = 'rel="' . esc_attr(trim($link['rel'])) . '"';
                }

                if (!empty($item['icon_font'])) {
                    $link_html .= '<i class="' . esc_attr($item['icon_font']) . '"></i> ';
                }
                $link_html .= esc_attr($item['label']);
                if (!empty($item['item_style']) && !empty($item['style_title'])) {
                    $link_html .= '<span class="x-menu-link-featured x-menu-link-featured-' . esc_html($item['item_style']) .'">' . esc_html($item['style_title']) .'</span>';
                }
                ?>
                <li><a <?php echo(implode(' ', $link_attr)); ?>><?php echo wp_kses_post($link_html); ?></a></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>