<?php
if (!defined('ABSPATH')) {
	exit;
}
/**
 * @var $element UBE_Element_Fancy_Text
 */

$settings = $element->get_settings_for_display();

$fancy_classes = array(
	'ube-fancy-text',
);

if ($settings['fancy_text_animation_type'] !== '') {
	$fancy_classes[] = 'ube-fancy-text-' . $settings['fancy_text_animation_type'];
}

if (!empty($settings['fancy_text_class'])) {
	$fancy_classes[] = $settings['fancy_text_class'];
}

$additional_data = array();
if ($settings['fancy_text_slide_up_pause_time'] !== '') {
	$additional_data['animationDelay'] = $settings['fancy_text_slide_up_pause_time'];
}

if ($settings['fancy_text_animated_background'] !== '') {
	$fancy_classes[] = 'ube-fancy-text-animate-has-bg';
}

if ($settings['fancy_text_animation_type'] === 'typing') {
	$data_text = $element->data_animation_text($settings);
	$element->add_render_attribute('fancy_attr', 'data-text', wp_json_encode($data_text));

	if ($settings['fancy_text_typing_speed'] !== '') {
		$additional_data['typingSpeed'] = $settings['fancy_text_typing_speed'];
	}

	if ($settings['fancy_text_typing_delay'] !== '') {
		$additional_data['typingDelay'] = $settings['fancy_text_typing_delay'];
	}

	if ($settings['fancy_text_typing_loop'] === 'yes') {
		$additional_data['typingLoop'] = true;
	}

	if ($settings['fancy_text_typing_cursor'] === 'yes') {
		$additional_data['typingCursor'] = true;
	}
}

$element->add_render_attribute('fancy_attr', array(
	'data-additional-options' => wp_json_encode($additional_data),
	'class' => $fancy_classes,
));


$tag_html = Elementor\Utils::validate_html_tag(isset($settings['fancy_text_tag']) ? $settings['fancy_text_tag'] : 'h2' );


$j = 0;


$fancy_text_animated_classes = array('ube-fancy-text-animated');
if (!empty($settings['fancy_text_animated_class'])) {
	$fancy_text_animated_classes[] = $settings['fancy_text_animated_class'];
}
$element->add_render_attribute('fancy_text_animated_attr','class', $fancy_text_animated_classes);



printf('<%1$s %2$s>', $tag_html, $element->get_render_attribute_string('fancy_attr'));
if ($settings['fancy_text_prefix'] !== '') :?>
    <span class="ube-fancy-text-before"><?php echo wp_kses_post($settings['fancy_text_prefix']) ?></span>
<?php endif; ?>
<span <?php $element->print_render_attribute_string('fancy_text_animated_attr') ?>>
	<?php if (isset($settings['fancy_text_animated_text']) && $settings['fancy_text_animation_type'] !== 'typing'): ?>
		<?php foreach ($settings['fancy_text_animated_text'] as $i => $item):
			$j++;
			$item_setting_key = $element->get_repeater_setting_key('fancy_text_animated_item', 'fancy_text_animated_text', $i);
			$items_class = array(
				'ube-fancy-text-item',
			);
			if ($j == '1') {
				$items_class[] = 'ube-fancy-text-show';
			}
			$element->add_render_attribute('fancy_text_item' . $j, 'class', $items_class);
			?>
            <b <?php echo $element->get_render_attribute_string('fancy_text_item' . $j); ?>><?php echo esc_html($item['fancy_text_field_animated']) ?> </b>
		<?php endforeach; ?>
	<?php endif; ?>
</span>
<?php
if ($settings['fancy_text_suffix'] !== '') : ?>
    <span class="ube-fancy-text-after"><?php echo esc_html($settings['fancy_text_suffix']) ?></span>
<?php endif;
printf('</%1$s>', $tag_html); ?>
