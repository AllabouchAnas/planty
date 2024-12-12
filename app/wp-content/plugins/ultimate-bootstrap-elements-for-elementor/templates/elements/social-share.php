<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Icons_Manager;

/**
 * @var $element UBE_Element_social_share
 */
$social_items_color = $social_items_bg = $social_animation = $social_share_outline = $social_id = '';


$settings  = $element->get_settings_for_display();
$social_share_classes = array(
	'ube-social-share',
	'ube-social-icons',
	'ube-social-' .$settings['social_share_shape'],
	'ube-social-' .$settings['social_size'],
);

$element->add_render_attribute( 'social_share', 'class', $social_share_classes );

if ( ! empty( $settings['social_item_text_scheme'] ) ) {
	$social_items_color = 'text-' . $settings['social_item_text_scheme'];
}

if ( ! empty( $settings['social_item_background_scheme'] ) && $settings['social_share_shape'] !== 'classic'
     && $settings['social_share_shape'] !== 'text' ) {
	$social_items_bg = 'bg-' . $settings['social_item_background_scheme'];
}

if ( ! empty( $settings['social_hover_animation'] ) ) {
	$social_animation = 'elementor-animation-' . $settings['social_hover_animation'];
}

if ( $settings['social_share_outline'] === 'yes' && $settings['social_share_shape'] !== 'classic'
&& $settings['social_share_shape'] !== 'text' ){
	$social_share_outline = 'ube-social-outline';
}

?>

<ul <?php echo $element->get_render_attribute_string( 'social_share' ) ?>>
	<?php foreach ( $settings['social_share_list'] as $index => $item ) : ?>

		<?php
		$social_classes = array( 'ube-social-' . $item['social_share_label'], 'elementor-repeater-item-' . $item['_id'] );
		if ( ! empty( $social_items_color ) ) {
			$social_classes[] = $social_items_color;
		}
		if ( ! empty( $social_items_bg ) ) {
			$social_classes[] = $social_items_bg;
		}
		if ( ! empty( $social_share_outline ) ) {
			$social_classes[] = $social_share_outline;
		}
		if ( ! empty( $social_animation ) ) {
			$social_classes[] = $social_animation;
		}
		if ( ! empty( $social_id ) ) {
			$social_classes[] = $social_id;
		}

		$social_items_classes = $element->get_repeater_setting_key( 'social_attr', 'social_share_list', $index );

		if ( ( $settings['social_switcher_tooltip'] !== '' ) ) {
			$element->add_render_attribute( $social_items_classes, array(
				'data-toggle' => 'tooltip',
				'data-placement' => $settings['social_position'],
			));
		}

		$element->add_render_attribute( $social_items_classes, array(
			'class'       => $social_classes,
			'data-social' => $item['social_share_media'],
			'title' => $item['social_share_label'],
		) );
		?>
        <li <?php echo $element->get_render_attribute_string( $social_items_classes ); ?>>
			<?php Icons_Manager::render_icon( $item['social_icon'] ); ?>
			<?php if ( $settings['social_share_shape'] === 'text' || $settings['social_share_shape'] === 'text-background' ) : ?>
                <span class="ube-text-social"><?php echo $item['social_share_label']; ?></span>
			<?php endif; ?>
        </li>
	<?php endforeach; ?>
</ul>
