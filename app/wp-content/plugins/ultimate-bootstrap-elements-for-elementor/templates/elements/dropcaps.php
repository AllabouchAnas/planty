<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * @var $element UBE_Element_Dropcaps
 */

$settings = $element->get_settings_for_display();

$dropcaps_sharp = '';

if ( ! empty( $settings['sharp'] )  ) {
	$dropcaps_sharp = 'sharp-' . $settings['sharp'];
}

$element->add_render_attribute( 'dropcaps_warpper', 'class', array(
	'ube-dropcaps',
	'view-'.$settings['view'],
	$dropcaps_sharp
) );

?>
<div <?php echo $element->get_render_attribute_string( 'dropcaps_warpper' ) ?>>
	<?php if( !empty( $settings['dropcaps_text'] ) ){?>
		<p><?php echo esc_html($settings['dropcaps_text']) ?></p>
	<?php }?>
</div>