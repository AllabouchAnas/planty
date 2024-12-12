<?php
if (!defined('ABSPATH')) {
	exit;
}


/**
 * @var $element UBE_Element_Dual_Heading
 */

$settings = $element->get_settings_for_display();

$dual_heading_classes = array(
	'ube-dual-heading',
);

$tag_html = Elementor\Utils::validate_html_tag(isset($settings['dual_heading_title_tag']) ? $settings['dual_heading_title_tag'] : 'h2' );
$tag_html_sub = Elementor\Utils::validate_html_tag(isset($settings['dual_heading_sub_title_tag']) ? $settings['dual_heading_sub_title_tag'] : 'h6' );

$divider_html = '';
if ($settings['dual_heading_divider_enable'] !== '') {
	$divider_html = '<div class="ube-heading-divider"></div>';
	$dual_heading_classes[] = 'ube-dual-heading-divider-' . $settings['dual_heading_divider_position'];
}

if ($settings['dual_heading_title_size'] !== '') {
	$dual_heading_classes[] = 'ube-dual-heading-size-' . $settings['dual_heading_title_size'];
}

$dual_heading_first_html = '';
if ($settings['dual_heading_title_first'] !== '') {
	$dual_heading_first_html = '<span class="ube-dual-heading-title-first">' . esc_html($settings['dual_heading_title_first']) . '</span>';
}
$dual_heading_last_html = '';
if ($settings['dual_heading_title_last'] !== '') {
	$dual_heading_last_html = '<span class="ube-dual-heading-title-last">' . esc_html($settings['dual_heading_title_last']) . '</span>';
}

$element->add_render_attribute('dual_heading_attr', 'class', $dual_heading_classes);
$element->add_render_attribute('dual_heading_sub_title_attr', 'class', 'ube-dual-heading-sub-title');
$element->add_render_attribute('dual_heading_description_attr', 'class', 'ube-dual-heading-desc-heading');

?>
<div <?php echo $element->get_render_attribute_string('dual_heading_attr') ?>>
	<?php
	if ($settings['dual_heading_sub_title_text'] !== '') {
		printf('<%1$s %2$s >%3$s</%1$s>', $tag_html_sub, $element->get_render_attribute_string('dual_heading_sub_title_attr'), wp_kses_post($settings['dual_heading_sub_title_text']));
	}
	if ($settings['dual_heading_divider_position'] === 'before') {
		echo wp_kses_post($divider_html);
	}
	if ($settings['dual_heading_title_last'] !== '' || $settings['dual_heading_title_first'] !== '') {
		printf('<%1$s class="ube-dual-heading-title">%2$s %3$s</%1$s>', $tag_html, $dual_heading_first_html, $dual_heading_last_html);
	}
	if ($settings['dual_heading_divider_position'] === 'after') {
		echo wp_kses_post($divider_html);
	}
	if ($settings['dual_heading_desc_heading'] !== '') {
		printf('<div %1$s>%2$s</div>', $element->get_render_attribute_string('dual_heading_description_attr'), wp_kses_post($settings['dual_heading_desc_heading']));
	}
	?>
</div>