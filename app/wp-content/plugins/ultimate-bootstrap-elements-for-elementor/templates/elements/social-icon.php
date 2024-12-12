<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Icons_Manager;

/**
 * @var $element UBE_Element_Social_Icon
 */
$social_items_color = $social_items_bg = $social_animation = $social_icon_outline = $social_id = '';

$settings            = $element->get_settings_for_display();
$social_icon_classes = array(
	'ube-social-icons',
	'ube-social-' .$settings['social_icon_shape'],
	'ube-social-' .$settings['social_size'],
);

$element->add_render_attribute( 'social_icon', 'class', $social_icon_classes );

if ( ! empty( $settings['social_item_text_scheme'] ) ) {
	$social_items_color = 'text-' . $settings['social_item_text_scheme'];
}

if ( ! empty( $settings['social_item_background_scheme'] ) && $settings['social_icon_shape'] !== 'text' && $settings['social_icon_shape'] !== 'classic' ) {
	$social_items_bg = 'bg-' . $settings['social_item_background_scheme'];
}

if ( ! empty( $settings['social_hover_animation'] ) ) {
	$social_animation = 'elementor-animation-' . $settings['social_hover_animation'];
}

if ( $settings['social_icon_outline'] === 'yes' && $settings['social_icon_shape'] !== 'text' && $settings['social_icon_shape'] !== 'classic' ) {
	$social_icon_outline = 'ube-social-outline';
}

?>

<ul <?php echo $element->get_render_attribute_string( 'social_icon' ) ?>>
	<?php foreach ( $settings['social_icon_list'] as $index => $item ) : ?>

		<?php $social ='';
		if ( $item['social_title'] == '' ) {
			if ( 'svg' !== $item['social_icon']['library'] ) {
				$social = explode( ' ', $item['social_icon']['value'] );
				if ( empty( $social[1] ) ) {
					$social = '';
				} else {
					$social = str_replace( 'fa-', '', $social[1] );
				}
				$social_icon = 'ube-social-' . $social;
			} else{
				$social_icon = 'ube-social-svg';
			}
		} else{
			$social_icon = 'ube-social-'.$item['social_title'];
		}


		$social_icon_tag = 'span';

		$social_items_classes = $element->get_repeater_setting_key( 'social_classes', 'social_icon_list', $index );
		$social_items_links   = $element->get_repeater_setting_key( 'social_link', 'social_icon_list', $index );

		if ( $item['social_icon_link']['url'] !== '' ) {
			$element->add_link_attributes( $social_items_links, $item['social_icon_link'] );
			$social_icon_tag = 'a';
		}

		$social_classes   = array( $social_icon,'elementor-repeater-item-' . $item['_id'] );
		if ( ! empty( $social_items_color ) ) {
			$social_classes[] = $social_items_color;
		}
		if ( ! empty( $social_items_bg ) ) {
			$social_classes[] = $social_items_bg;
		}
		if ( ! empty( $social_icon_outline ) ) {
			$social_classes[] = $social_icon_outline;
		}
		if ( ! empty( $social_animation ) ) {
			$social_classes[] = $social_animation;
		}

		if ($item['social_title'] == ''){
			$socials_title = $social;
		} else {
			$socials_title = $item['social_title'];
		}

		if ( ( $settings['social_switcher_tooltip'] === '' ) ) {
			$element->add_render_attribute( $social_items_classes, 'class' , $social_classes);
			$element->add_render_attribute( $social_items_links, array(
				'class' => 'ube-social-icon-icon',
				'title' => $socials_title,
			));
		} else {
			$element->add_render_attribute( $social_items_classes, array(
				'class' =>  $social_classes,
				'title' => $socials_title,
				'data-toggle' => 'tooltip',
				'data-placement' => $settings['social_position'],
			));
			$element->add_render_attribute( $social_items_links, 'class' , 'ube-social-icon-icon');
		}

		?>
        <li <?php echo $element->get_render_attribute_string( $social_items_classes ); ?>>
			<?php printf( '<%1$s %2$s>', $social_icon_tag, $element->get_render_attribute_string( $social_items_links ) );
			Icons_Manager::render_icon( $item['social_icon'] ); ?>
			<?php if ( $settings['social_icon_shape'] === 'text' && $item['social_title'] == '') : ?>
                <span class="ube-text-social"><?php echo esc_html( $social ); ?></span>
			<?php endif; ?>
			<?php if ( $settings['social_icon_shape'] === 'text' && $item['social_title'] !== '') : ?>
	            <span class="ube-text-social"><?php echo $item['social_title']; ?></span>
	        <?php endif;
			printf( '</%1$s>', $social_icon_tag ); ?>
        </li>
	<?php endforeach; ?>
</ul>
