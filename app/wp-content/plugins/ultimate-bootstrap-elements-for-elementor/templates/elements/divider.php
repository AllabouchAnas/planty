<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Icons_Manager;

/**
 * @var $element UBE_Element_Divider
 */

$settings = $element->get_settings_for_display();

$divider_classes = array(
	'ube-divider',
	"ube-divider-style-{$settings['divider_style']}"
);

if ( $settings['divider_add_element'] !== '' ) {
	$divider_classes[] = 'has-element';
}

$element->add_render_attribute( 'divider_attr', 'class', $divider_classes );

?>
<div <?php echo $element->get_render_attribute_string( 'divider_attr' ) ?>>
	<div class="ube-divider-separator">
		<?php if ( $settings['divider_add_element'] !== '' ) : ?>
			<span class="ube-divider-element"></span>
			<span class="ube-divider-content">
				<?php if ( $settings['divider_add_element'] === 'text' && $settings['divider_text'] !== '' ): ?>
					<?php echo esc_html( $settings['divider_text'] ); ?>
				<?php endif; ?>
				<?php if ( $settings['divider_add_element'] === 'icon' && ! empty( $settings['divider_icon']['value'] ) ): ?>
					<?php Icons_Manager::render_icon( $settings['divider_icon'], [ 'aria-hidden' => 'true' ] ); ?>
				<?php endif; ?>
			</span>
			<span class="ube-divider-element"></span>
		<?php endif; ?>
	</div>
</div>
