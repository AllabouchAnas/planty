<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Icons_Manager;

/**
 * @var $element UBE_Element_Button
 */
$settings = $element->get_settings_for_display();
$wrapper_classes = array(
	'ube-btn',
	'btn',
	"btn-{$settings['size']}",
	"btn-{$settings['shape']}",
);

if ($settings['type'] !== '') {
	$wrapper_classes[] = "btn-{$settings['type']}";
}

if ($settings['type'] === '' || $settings['type'] === '3d') {
	$wrapper_classes[] = "btn-{$settings['scheme']}";
}

if ($settings['type'] === 'outline') {
	$wrapper_classes[] = "btn-outline-{$settings['scheme']}";
	$wrapper_classes[] = "btn-{$settings['scheme']}";
}

if ( $settings['hover_animation'] ) {
	$wrapper_classes[] = "elementor-animation-{$settings['hover_animation']}";
}


if (!empty($settings['icon']) && !empty($settings['icon']['value'])) {
	$wrapper_classes[] = "ube-btn-icon-{$settings['icon_align']}";
}

$element->add_render_attribute('wrapper','class',$wrapper_classes);

$element->add_render_attribute('text','class','ube-btn-text');
$element->add_inline_editing_attributes('text','none');

if ( ! empty( $settings['link']['url'] ) ) {
	$element->add_link_attributes( 'wrapper', $settings['link'] );
}

if ( ! empty( $settings['button_css_id'] ) ) {
	$element->add_render_attribute( 'wrapper', 'id', $settings['button_css_id'] );
}

if( 'yes' === $settings['button_event_switcher'] && ! empty( $settings['button_event_function'] ) ) {
	$this->add_render_attribute( 'wrapper', 'onclick', $settings['button_event_function'] );
}

?>
<a <?php echo $element->get_render_attribute_string( 'wrapper' ) ?>>
	<?php if (!empty($settings['icon']) && !empty($settings['icon']['value']) && ($settings['icon_align'] === 'left')): ?>
		<span class="ube-btn-icon"><?php Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] ); ?></span>
	<?php endif; ?>
	<span <?php echo $element->get_render_attribute_string('text') ?>><?php echo esc_html($settings['text']); ?></span>
	<?php if (!empty($settings['icon']) && !empty($settings['icon']['value']) && ($settings['icon_align'] === 'right')): ?>
		<span class="ube-btn-icon"><?php Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] ); ?></span>
	<?php endif; ?>
</a>


