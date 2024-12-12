<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Group_Control_Image_Size;

/**
 * @var $element UBE_Element_Image_Comparison
 */

$settings = $element->get_settings_for_display();

$element->add_render_attribute( 'ube_image_marker_attr', 'class', 'ube-marker-wrapper' );
if ( $settings['image_marker_animation'] == 'yes' ) {
	$element->add_render_attribute( 'ube_image_marker_attr', 'class', 'ube-marker-animate-icon' );
}
if ( $settings['image_marker_arrow'] == 'yes' ) {
	$element->add_render_attribute( 'ube_image_marker_attr', 'class', 'ube-marker-tooltip-arrow' );
}
?>
<div <?php echo $element->get_render_attribute_string( 'ube_image_marker_attr' ); ?> >
	<?php
	if (isset($settings['image'])) {
		echo Group_Control_Image_Size::get_attachment_image_html( $settings, 'image_size', 'image' );
	}
	?>
	<?php
	foreach ( $settings['image_marker_list'] as $i => $item ):
		$title = '';
		if ( ! empty( $item['marker_title'] ) ) {
			$title .= '<h4>' . esc_html( $item['marker_title'] ) . '</h4>';
		}
		if ( ! empty( $item['marker_content'] ) ) {
			$title .= '<p>' . esc_html( $item['marker_content'] ) . '</p>';
		}
		$marker_setting_key = $element->get_repeater_setting_key( 'marker_attr', 'image_marker_list', $i );
		$element->add_render_attribute( $marker_setting_key, 'title', $title );

		$marker_tag = 'div';
		if ( ! empty( $item['marker_link']['url'] ) ) {
			$marker_tag = 'a';
			$target     = $item['marker_link']['is_external'] ? ' target="_blank"' : '';
			$nofollow   = $item['marker_link']['nofollow'] ? ' rel="nofollow"' : '';
			$element->add_render_attribute( $marker_setting_key, array(
				'href'   => $item['marker_link']['url'],
				'target' => $target,
				'rel'    => $nofollow
			) );
		}
		$marker_classes = 'ube-image-pointer elementor-repeater-item-' . $item['_id'];
		$element->add_render_attribute( $marker_setting_key, array(
			'class'       => $marker_classes
		) );
		?>
		<?php printf( '<%1$s %2$s>', $marker_tag, $element->get_render_attribute_string( $marker_setting_key ) ); ?>
        <div class="ube-pointer-icon">
			<?php
			if ( $item['type_of_marker'] == 'icon' ) {
				if ( ! empty( $item['marker_icon']['value'] ) ) {
					\Elementor\Icons_Manager::render_icon( $item['marker_icon'] );
				} else {
					echo UBE_Icon::get_instance()->get_svg( 'info-circle' );
				}
			} else {
				echo esc_html( $item['marker_text'] );
			}

			?>
        </div>
		<?php printf( '</%1$s>', $marker_tag ); ?>
	<?php
	endforeach;
	?>
</div>
