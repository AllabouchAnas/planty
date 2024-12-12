<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @var $element UBE_Element_List_Icon
 */

use Elementor\Icons_Manager;

$settings = $element->get_settings_for_display();

$list_icon_tag = 'span';

$list_icon_classes = array(
	'ube-list-icon',
);

if ( $settings['list_icon_size'] !== '' ) {
	$list_icon_classes[] = 'ube-list-icon-'. $settings['list_icon_size'];
}

if ( $settings['list_icon_scheme'] !== '' ) {
	$list_icon_classes[] = 'text-' . $settings['list_icon_scheme'];
}

if(!empty($settings['list_icon_type']) && $settings['list_icon_view'] === 'list-type-icon'){
	$list_icon_classes[] = 'ube-list-icon-'.$settings['list_icon_type'];
}

$element->add_render_attribute( 'list_icon', 'class', $list_icon_classes );

if ( $settings['list_icon_layout'] === 'list-column' ) {
	$element->add_render_attribute( 'list_icon', 'class', 'list-unstyled' );
	$element->add_render_attribute( 'list_icon_item', 'class', 'list-icon-item' );

} else {
	$element->add_render_attribute( 'list_icon', 'class', 'list-inline' );
	$element->add_render_attribute( 'list_icon_item', 'class', 'list-inline-item' );
}

$auto_number       = (int) $settings['list_icon_number'] - 1;
$list_number_start = 'item ' . $auto_number;

if ( $settings['list_icon_number'] > 0 ) {
	$element->add_render_attribute( 'list_icon', 'style', 'counter-reset:' . $list_number_start );
}
?>
<ul <?php echo $element->get_render_attribute_string( 'list_icon' ); ?>>
	<?php foreach ( $settings['list_icon_repeater'] as $index => $item ) { ?>
		<?php
		$list_items_classes = $element->get_repeater_setting_key( 'list_icon_content_classes', 'list_icon_repeater', $index );
		$link_list_icon = $element->get_repeater_setting_key( 'link-list', 'list_icon_repeater', $index );

		if ( ! empty( $item['list_icon_link']['url'] ) ) {
			$element->add_link_attributes( $link_list_icon, $item['list_icon_link'] );
			$list_icon_tag = 'a';
		}
		$element->add_render_attribute( $link_list_icon, 'class', 'ube-list-icon-title');

		$list_icon_content_classes = array( 'ube-list-icon-icon' );

		$element->add_render_attribute( $list_items_classes, 'class', $list_icon_content_classes );

		?>
        <li <?php echo $element->get_render_attribute_string( 'list_icon_item' ); ?>>
			<?php if ( ! empty( $settings['list_icon_type_icon']['value'] ) && $item['list_icon_selected_icon']['value'] === "" && $settings['list_icon_view'] === 'list-icon-icon' ) : ?>
                <span <?php echo $element->get_render_attribute_string($list_items_classes ); ?>>
					<?php Icons_Manager::render_icon( $settings['list_icon_type_icon'] ); ?>
				</span>
			<?php endif; ?>
			<?php if ( ! empty( $item['list_icon_selected_icon']['value'] ) && $settings['list_icon_view'] === 'list-icon-icon' ) : ?>
                <span <?php echo $element->get_render_attribute_string( $list_items_classes ); ?>>
					<?php Icons_Manager::render_icon( $item['list_icon_selected_icon'] ); ?>
				</span>
			<?php endif; ?>
			<?php if ( ! empty( $item['list_icon_title'] )) : ?>
				<?php
				printf( '<%1$s %2$s>', $list_icon_tag, $element->get_render_attribute_string( $link_list_icon ) );
				echo wp_kses_post( $item['list_icon_title'] );
				printf( '</%1$s>', $list_icon_tag ); ?>
			<?php endif; ?>
        </li>
	<?php } ?>
</ul>



