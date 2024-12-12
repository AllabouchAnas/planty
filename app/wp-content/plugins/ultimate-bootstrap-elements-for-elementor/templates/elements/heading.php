<?php
if (!defined('ABSPATH')) {
	exit;
}

/**
 * @var $element UBE_Element_Badge
 */

$settings = $element->get_settings_for_display();
$heading_class = array('ube-heading');

$tag_html_title = Elementor\Utils::validate_html_tag(isset($settings['heading_title_tag']) ? $settings['heading_title_tag'] : 'h2' );
$tag_html_sub = Elementor\Utils::validate_html_tag(isset($settings['heading_sub_title_tag']) ? $settings['heading_sub_title_tag'] : 'h6' );

$divider_html = '';
if ($settings['heading_divider_enable'] !== '') {
	$divider_html = '<div class="ube-heading-divider"></div>';
	$heading_class[] = 'ube-heading-divider-' . $settings['heading_divider_position'];
}

$title_class = array('ube-heading-title');
if ($settings['heading_title_size'] !== '') {
	$title_class[] = 'ube-heading-size-' . $settings['heading_title_size'];
}

if (isset($settings['heading_title_class']) &&  !empty($settings['heading_title_class'])) {
	$title_class[] = $settings['heading_title_class'];
}

$sub_title_class = array('ube-heading-sub-title');
if (isset($settings['heading_sub_title_class']) &&  !empty($settings['heading_sub_title_class'])) {
	$sub_title_class[] = $settings['heading_sub_title_class'];
}

$description_class = array('ube-heading-description');
if (isset($settings['heading_description_class']) &&  !empty($settings['heading_description_class'])) {
	$description_class[] = $settings['heading_description_class'];
}


$element->add_render_attribute('heading_attr', 'class', $heading_class);
$element->add_render_attribute('title_attr', 'class', $title_class);
$element->add_render_attribute('description_attr', 'class', $description_class);
$element->add_render_attribute('sub_title_attr', 'class', $sub_title_class);
?>
<div <?php echo $element->get_render_attribute_string('heading_attr') ?>>
	<?php
	if ($settings['heading_sub_title_text'] !== '') {
		printf('<%1$s %2$s >%3$s</%1$s>', $tag_html_sub, $element->get_render_attribute_string('sub_title_attr'), wp_kses_post($settings['heading_sub_title_text']));
	}
	if ($settings['heading_divider_position'] === 'before') {
		echo wp_kses_post($divider_html);
	}
	if ($settings['heading_title'] !== '') {
		$heading_title = $settings['heading_title'];
		if ($settings['heading_title_link']['url'] !== '') {
			$element->add_link_attributes('link_title_atrr', $settings['heading_title_link']);
			$heading_title = sprintf('<a %1$s>%2$s</a>', $element->get_render_attribute_string('link_title_atrr'), wp_kses_post($settings['heading_title']));
		}
		printf('<%1$s %2$s>%3$s</%1$s>', $tag_html_title, $element->get_render_attribute_string('title_attr'), $heading_title);
	}
	if ($settings['heading_divider_position'] === 'after') {
		echo wp_kses_post($divider_html);
	}
	if ($settings['heading_description'] !== '') {
		printf('<div %1$s>%2$s</div>', $element->get_render_attribute_string('description_attr'), wp_kses_post($settings['heading_description']));
	}
	?>
</div>