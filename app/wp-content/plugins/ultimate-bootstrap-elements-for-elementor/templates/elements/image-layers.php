<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @var $element UBE_Element_Image_Layers
 */

$settings = $element->get_settings_for_display();

$artboard_classes[] = 'ube-image-layers';

$element->add_render_attribute( 'artboard', 'class', $artboard_classes );
$layers_id = 'ube-layers-' . $element->get_id();
$element->add_render_attribute( 'layers_wrapper', array(
	'class' => 'layers-wrapper',
) );
if ( $settings['section_style_animation'] == 'yes' ) {
	$element->add_render_attribute( 'layers_wrapper', array(
		'id'      => $layers_id,
		'data-id' => $layers_id
	) );
}
?>
<div <?php $element->print_render_attribute_string( 'artboard' ); ?>>
    <div <?php $element->print_render_attribute_string( 'layers_wrapper' ); ?>>
		<?php if ( ! empty( $settings['layers'] ) ) {

			$layer_index = 0;

			foreach ( $settings['layers'] as $key => $layer ) {
				$layer_index ++;
				$layer_id          = $layer['_id'];
				$layer_key         = 'layer_' . $layer_id;
				$layer_content_key = 'layer_content_' . $layer_id;
				$layer_classes     = array();
				$layer_classes[]   = 'card ube-image layer';
				$layer_classes[]   = 'elementor-repeater-item-' . $layer_id;
				if ( $layer['custom_class_item'] !== '' ) {
					$layer_classes[] = $layer['custom_class_item'];
				}
				if ( ! empty( $settings['hover_animation'] ) ) {
					$layer_classes[] = 'ube-image-hover-' . $settings['hover_animation'];
				}
				if ( ! empty( $settings['hover_overlay_animation'] ) ) {
					$layer_classes[] = 'ube-image-hover-' . $settings['hover_overlay_animation'];
				}

				$element->add_render_attribute( $layer_key, [
					'class' => $layer_classes,
					'style' => "z-index: {$layer_index}",
				] );

				if ( 'yes' === $layer['static'] ) {
					$element->add_render_attribute( $layer_key, [
						'class' => 'static-layer',
					] );
				}
				if ( $settings['section_style_animation'] == 'yes' ) {
					$depth = $layer['depth_animation'];
					if ( $depth == '' ) {
						$depth = 0.1;
					}
					$element->add_render_attribute( $layer_key, [
						'data-depth' => $depth,
					] );
				}

				$element->add_render_attribute( $layer_content_key, [
					'class' => 'card-img layer-content',
				] );

				if ( ! empty( $layer['loop'] ) ) {
					$element->add_render_attribute( $layer_content_key, [
						'class' => 'ube-layer-loop ube-loop-' . $layer['loop'],
					] );
				}
				$element->add_link_attributes( 'link_' . $layer_content_key, $layer['image_link'] );
				?>
                <div <?php $element->print_render_attribute_string( $layer_key ); ?>>
	                <?php if ( $layer['image_link']['url'] !== '' ): ?>
                        <a <?php echo $element->get_render_attribute_string( 'link_' . $layer_content_key ) ?>>
                    <?php endif; ?>
                        <div <?php $element->print_render_attribute_string( $layer_content_key ); ?>>
                                <?php echo ube_get_elementor_attachment( [
                                    'settings' => $layer,
                                ] ); ?>
                        </div>
                    <?php if ( $layer['image_link']['url'] !== '' ): ?>
                         </a>
                     <?php endif; ?>
                </div>
				<?php
			}
		}
		?>
    </div>
</div>