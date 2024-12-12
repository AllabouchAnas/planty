<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Icons_Manager;

/**
 * @var $element UBE_Element_Advanced_Accordion
 * @var $accordion_spacing
 * @var $accordion_scheme
 * @var $accordion_tab_icon
 * @var $accordion_type
 * @var $ube_accordion_items
 * @var $accordion_tab_icon_position
 * @var $accordion_items
 */

$settings = $element->get_settings_for_display();

extract( $settings );

$acc_id = $element->get_id();
$card   = 'card ube-accordion-card';
if ( $accordion_spacing == 'yes' ) {
	$card = 'card ube-accordion-card ube-accordion-separate';
}
$card_class =array( $card);
if ( $accordion_scheme !== '' ) {
	$colors     = ube_color_schemes_configs();
	$text_color = ube_color_contrast( $colors[ $accordion_scheme ]['color'], 'white', 'dark' );
	$card_class[]= 'bg-' . $accordion_scheme . ' text-' . $text_color;
}
$migrated = isset( $settings['__fa4_migrated']['accordion_tab_icon'] );


$is_new   = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();
$has_icon = ( ! $is_new || ! empty( $settings['accordion_tab_icon']['value'] ) );

if ( $accordion_type == 'toggle' ) {
	$accordion_type = 'accordion accordion-toggle';
}
$element->add_render_attribute( 'acc_wrapper', 'class', array( 'ube-accordion', $accordion_type ) );
$element->add_render_attribute( 'acc_wrapper', 'id', 'accordion-' . $acc_id );

?>
<div <?php echo $element->get_render_attribute_string( 'acc_wrapper' ); ?>>
	<?php

	foreach ( $accordion_items as $i => $accorion_content ) :
		$item_id = $acc_id . uniqid();
		$header_class = 'collapsed';
		$body_class = 'collapse';
		$is_active = 'false';
		if ( $accorion_content['accordion_active_default'] == 'yes' ) {
			$is_active    = 'true';
			$body_class   = 'collapse show';
		}
		$card_class_item = array( $card );
		if ( $accorion_content['accordion_item_scheme'] != '' ) {
			$colors            = ube_color_schemes_configs();
			$text_color        = ube_color_contrast( $colors[ $accorion_content['accordion_item_scheme'] ]['color'], 'white', 'dark' );
			$card_class_item[] = 'bg-' . $accorion_content['accordion_item_scheme'] . ' text-' . $text_color;
		} else {
			$card_class_item = $card_class;
		}
		if ( $is_active == 'true' ) {
			$card_class_item[] = 'active';
		}
		$acc_card_setting_key = $element->get_repeater_setting_key( 'acc_card', 'accordion_items', $i );
		$element->add_render_attribute( $acc_card_setting_key, 'class', $card_class_item );
		$card_header_class = array( 'card-header ube-accordion-card-header' );
		if ( $is_active == 'true' ) {
			$card_header_class[] = 'active';
		}
		$acc_card_header_setting_key = $element->get_repeater_setting_key( 'acc_card_header', 'accordion_items', $i );
		$element->add_render_attribute( $acc_card_header_setting_key, 'class', $card_header_class );
		$element->add_render_attribute( $acc_card_header_setting_key, 'id', 'heading-' . $item_id );
		$acc_link_setting_key = $element->get_repeater_setting_key( 'acc_link', 'accordion_items', $i );
		$element->add_render_attribute( $acc_link_setting_key, array(
			'class'         => array( 'ube-accordion-link m-0 d-flex align-items-center', $header_class ),
			'data-toggle'   => 'collapse',
			'data-target'   => '#collapse-' . $item_id,
			'aria-expanded' => $is_active,
			'aria-controls' => 'collapse-' . $item_id
		) );
		?>
        <div <?php echo $element->get_render_attribute_string( $acc_card_setting_key ); ?>>
            <div <?php echo $element->get_render_attribute_string( $acc_card_header_setting_key ); ?>>
                <h5 <?php echo $element->get_render_attribute_string( $acc_link_setting_key ); ?>>
					<?php
					if ( $accordion_tab_icon_position == 'left' ):
						?>
                        <span class="ube-accordion-icon left-icon">
                                     <?php
                                     if ( $is_new || $migrated ) { ?>
	                                     <?php Icons_Manager::render_icon( $settings['accordion_tab_icon'] ); ?>
                                     <?php } else { ?>
                                         <i class="<?php echo esc_attr( $settings['accordion_tab_icon'] ); ?>"></i>
                                     <?php } ?>
                                </span>
					<?php
					endif;
					?>
					<?php
					$acc_title_setting_key = $element->get_repeater_setting_key( 'acc_title', 'accordion_items', $i );
					$element->add_render_attribute( $acc_title_setting_key, [] );
					$element->add_inline_editing_attributes( $acc_title_setting_key, 'none' );
					?>
                    <span <?php echo $element->get_render_attribute_string( $acc_title_setting_key ); ?>><?php echo $element->parse_text_editor( $accorion_content['acc_title'] ); ?></span>
					<?php
					if ( $accordion_tab_icon_position == 'right' ):
						?>
                        <span class="ube-accordion-icon right-icon ml-auto">
                            <?php
                            if ( $is_new || $migrated ) { ?>
                                <?php Icons_Manager::render_icon( $settings['accordion_tab_icon'] ); ?>
                            <?php } else { ?>
                                <i class="<?php echo esc_attr( $settings['accordion_tab_icon'] ); ?>"></i>
                            <?php } ?>
                        </span>
					<?php
					endif;
					?>
                </h5>
            </div>
			<?php $acc_collapse_setting_key = $element->get_repeater_setting_key( 'acc_collapse', 'accordion_items', $i );
			$element->add_render_attribute( $acc_collapse_setting_key, array(
				'class'           => array( 'ube-collapsible', $body_class ),
				'aria-labelledby' => 'heading-' . $item_id,
				'id'              => 'collapse-' . $item_id
			) );
			if ( $accordion_type === 'accordion' ) {
				$element->add_render_attribute( $acc_collapse_setting_key, 'data-parent', '#accordion-' . $acc_id );
			}
			?>
            <div <?php echo $element->get_render_attribute_string( $acc_collapse_setting_key ); ?>>
                <div class="card-body ube-accordion-card-body">
					<?php echo UBE_Module_Dynamic_Content::get_instance()->parse_widget_content( 'acc_content', $accorion_content['acc_content'], $element->get_id(), ( $i + 1 )); ?>
                </div>
            </div>
        </div>

	<?php endforeach; ?>
</div>