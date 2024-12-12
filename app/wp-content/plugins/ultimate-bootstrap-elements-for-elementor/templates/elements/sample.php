<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * @var $element UBE_Element_Sample
 */

$settings = $element->get_settings_for_display();
$element->add_inline_editing_attributes('text', 'basic');
$element->add_render_attribute( 'button', 'class', 'btn btn-primary' );
$element->add_render_attribute( 'icon', 'class', $settings['icon']['value'] );
?>
<div <?php echo $element->get_render_attribute_string( 'button' ) ?>>
	<i <?php echo $element->get_render_attribute_string( 'icon' ) ?>></i>
	<span <?php echo $element->get_render_attribute_string( 'text' ) ?>>
		<?php echo $settings['text'] ?>
	</span>
</div>