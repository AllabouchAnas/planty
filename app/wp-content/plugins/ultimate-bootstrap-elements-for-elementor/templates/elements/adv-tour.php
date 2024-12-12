<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Group_Control_Image_Size;
use Elementor\Icons_Manager;

/**
 * @var $element UBE_Element_Tabs
 * @var $tab_type
 * @var $tab_title_type_icon
 * @var $tab_header_icon_pos_style
 * @var $tab_items
 * @var $tab_scheme
 * @var $tab_enable_spacing
 * @var $tab_responsive_mode
 * @var $tab_shape
 * @var $tab_align
 */

$settings = $element->get_settings_for_display();
extract( $settings );

$nav_link_classes = '';
$icon_classes     = '';
$title_classes    = '';
if ( $tab_title_type_icon == 'yes' ) {
	switch ( $tab_header_icon_pos_style ) {
		case 'right-pos':
			$nav_link_classes .= 'align-items-center';
			$icon_classes     = 'order-1 icon-right';
			$title_classes    = 'order-0';
			break;
		case 'top-pos':
			$nav_link_classes .= ' flex-column';
			$icon_classes     = 'order-0 icon-top';
			$title_classes    = 'order-1';
			break;
		case 'bottom-pos':
			$nav_link_classes .= ' flex-column';
			$icon_classes     = 'order-1 icon-bottom';
			$title_classes    = 'order-0';
			break;
		default:
			$icon_classes     = 'icon-left';
			$nav_link_classes .= 'align-items-center';

	}
}
$schema = '';
if ( $tab_type == 'flat' || $tab_type == 'classic' || $tab_type == 'pills' ) {
	if ( $tab_scheme != '' ) {
		$colors     = ube_color_schemes_configs();
		$text_color = ube_color_contrast( $colors[ $tab_scheme ]['color'], 'white', 'dark' );
		$schema     .= 'bg-' . $tab_scheme . ' text-' . $text_color;
	}
}
$wrapper_scheme = '';
if ( $tab_type == 'outline' ) {
	if ( $tab_scheme != '' ) {
		$wrapper_scheme = 'tabs-outline-' . $tab_scheme;
	}
} elseif ( $tab_type == 'classic' ) {
	if ( $tab_scheme != '' ) {
		$wrapper_scheme = 'tabs-classic-' . $tab_scheme;
	}
} elseif ( $tab_type == 'flat' ) {
	if ( $tab_scheme != '' ) {
		$wrapper_scheme = 'tabs-flat-' . $tab_scheme;
	}
}
$tabs_classes        = '';
$tab_content_classes = '';
if ( $tab_align == 'left' ) {
	$tabs_classes        = 'order-0';
	$tab_content_classes = 'order-1';
} elseif ( $tab_align == 'right' ) {
	$tabs_classes        = 'order-1';
	$tab_content_classes = 'order-0';
}

$tab_wrapper_classes[] = 'collapse-tabs d-flex ube-tour ube-advanced-tour';
if($tab_scheme!==''){
	$tab_wrapper_classes[]='ube-tabs-scheme';
}
if ( $tab_type !== '' ) {
	$tab_wrapper_classes[] = 'ube-tour-' . $tab_type;
}
if ( $tab_shape !== '' && ! is_null( $tab_shape ) ) {
	$tab_wrapper_classes[] = 'ube-tour-' . $tab_shape;
}
if ( $tab_align !== '' && ! is_null( $tab_align ) ) {
	$tab_wrapper_classes[] = 'ube-tour-' . $tab_align;
}
if ( $wrapper_scheme !== '' ) {
	$tab_wrapper_classes[] = $wrapper_scheme;
}
$element->add_render_attribute( 'tabs_wrapper_class', 'class', $tab_wrapper_classes );

$navs_wrapper_classes[] = 'tabs';
$navs_wrapper_classes[] = $tabs_classes;
$element->add_render_attribute( 'tabs_class', 'class', $navs_wrapper_classes );
$nav_classes[] = 'nav flex-column';
if ( $tab_type == 'pills' ) {
	$nav_classes[] = 'nav-pills';
} else {
	$nav_classes[] = 'nav-tabs';
}
$element->add_render_attribute( 'nav_wrapper', 'class', $nav_classes );
$element->add_render_attribute( 'nav_wrapper', 'role', 'tablist' );
$tab_content[] = 'tab-content d-flex flex-column';
$tab_content[] = $tab_content_classes;
if ( $tab_enable_spacing == 'yes' ) {
	$tab_content[] = 'ube-tab-separate';
}
$element->add_render_attribute( 'tab_content_class', 'class', $tab_content );
$id_int = $element->get_id();
?>

<div <?php echo $element->get_render_attribute_string( 'tabs_wrapper_class' ); ?>>
    <div <?php echo $element->get_render_attribute_string( 'tabs_class' ); ?>>
        <ul <?php echo $element->get_render_attribute_string( 'nav_wrapper' ); ?>>
			<?php
			foreach ( $tab_items as $i => $item ):
				$tab_id = $id_int . uniqid();
				$tab_items[$i]['tab_uniqid'] = $tab_id;

				$nav_item_classes = array();
				$nav_item_classes[] = 'nav-item';
				$is_active = 'false';
				if ( $i == 0 ) {
					$nav_item_classes[] = 'active';
					$is_active          = 'true';
				}
				if ( $tab_enable_spacing == 'yes' ) {
					$nav_item_classes[] = 'ube-tab-separate';
				}
				if ( ( $tab_type == 'pills' || $tab_type == 'underline' ) && $tab_scheme != '' && $tab_scheme !== 'light' ) {
					$nav_item_classes[] = 'text-' . $tab_scheme;
				}
				$tabs_item_setting_key = $element->get_repeater_setting_key( 'nav_item', 'tab_items', $i );
				$element->add_render_attribute( $tabs_item_setting_key, 'class', $nav_item_classes );
				$link_class   = array();
				$link_class[] = 'nav-link d-flex';
				if ( $i == 0 ) {
					$link_class[] = 'active';
				}
				if ( $nav_link_classes !== '' ) {
					$link_class[] = $nav_link_classes;
				}
				if ( $schema !== '' ) {
					$link_class[] = $schema;
				}
				$tabs_link_setting_key = $element->get_repeater_setting_key( 'nav_link', 'tab_items', $i );
				$data_toggle           = '';
				if ( $tab_type == 'pills' ) {
					$data_toggle = 'pill';
				} else {
					$data_toggle = 'tab';
				}

				$element->add_render_attribute( $tabs_link_setting_key, array(
					'class'         => $link_class,
					'id'            => 'item-' . $tab_id . '-tab',
					'data-toggle'   => $data_toggle,
					'href'          => '#content-' . $tab_id,
					'aria-controls' => 'content-' . $tab_id,
					'role'          => 'tab',
					'aria-selected' => $is_active,
				) );
				?>
                <li <?php echo $element->get_render_attribute_string( $tabs_item_setting_key ); ?>>
                    <a <?php echo $element->get_render_attribute_string( $tabs_link_setting_key ); ?>>
						<?php if ( $tab_title_type_icon == 'yes' ): ?>
                            <span class="ube-tab-icon <?php echo esc_attr( $icon_classes ) ?>">
                        <?php
                        if ( ! empty( $item['tab_title_image']['url'] ) ) {
	                        echo Group_Control_Image_Size::get_attachment_image_html( $item, 'thumbnail', 'tab_title_image' );
                        } elseif ( ! empty( $item['tab_title_icons'] ) ) {
	                        Icons_Manager::render_icon( $item['tab_title_icons'] );
                        }
                        ?>
                             </span>
						<?php
						endif;
						?>

						<?php
						$tab_title_setting_key = $element->get_repeater_setting_key( 'tab_title', 'tab_items', $i );
						$element->add_render_attribute( $tab_title_setting_key, 'class', $title_classes );
						$element->add_inline_editing_attributes( $tab_title_setting_key, 'none' );
						?>
                        <span <?php echo $element->get_render_attribute_string( $tab_title_setting_key ); ?>>
                            <?php echo $element->parse_text_editor( $item['tab_title'] ); ?>
                        </span>
                    </a>
                </li>
			<?php
			endforeach;
			?>
        </ul>
    </div>
    <div <?php echo $element->get_render_attribute_string( 'tab_content_class' ); ?>>
		<?php
		$tab_container_classes = array( 'ube-tab-content-container' );
		$element->add_render_attribute( 'tabs_collapse_wrapper', array(
			'class' => $tab_container_classes,
			'id'    => 'collapse-tabs-accordion-' . $id_int
		) );
		?>
        <div <?php echo $element->get_render_attribute_string( 'tabs_collapse_wrapper' ); ?>>
			<?php
			foreach (
				$tab_items

				as $i => $item
			):
				$tab_id = $item['tab_uniqid'];
				$tab_pane_classes = array();
				$tab_pane_classes[] = 'tab-pane fade';
				if ( $i == 0 ) {
					$tab_pane_classes[] = 'show active';
				}
				$tabs_pane_setting_key = $element->get_repeater_setting_key( 'tab_pane', 'tab_items', $i );
				$element->add_render_attribute( $tabs_pane_setting_key,
					array(
						'class'           => $tab_pane_classes,
						'id'              => 'content-' . $tab_id,
						'role'            => "tabpanel",
						'aria-labelledby' => 'item-' . $tab_id . '-tab'
					) );
				$card_class   = array();
				$card_class[] = 'card ube-tabs-card';
				if ( $tab_type != 'pills' && $tab_type != 'flat' && $schema !== '' ) {
					$card_class[] = $schema;
				}
				if ( $tab_type == 'flat' && $schema !== '' ) {
					$card_class[] = 'text-' . $text_color;
				}
				if ( $i == 0 ) {
					$card_class[] = 'active';
				}
				$tabs_card_setting_key = $element->get_repeater_setting_key( 'tab_card', 'tab_items', $i );
				$element->add_render_attribute( $tabs_card_setting_key, 'class', $card_class );

				$card_header_classes   = array();
				$card_header_classes[] = 'card-header ube-tabs-card-header';
				if ( $tab_type == 'pills' && $schema !== '' ) {
					$card_header_classes[] = $schema;
				}
				$tabs_card_header_setting_key = $element->get_repeater_setting_key( 'tab_card_header', 'tab_items', $i );
				$element->add_render_attribute( $tabs_card_header_setting_key, array(
					'class' => $card_header_classes,
					'id'    => 'heading-' . $tab_id
				) );

				$tabs_card_title_setting_key = $element->get_repeater_setting_key( 'tab_card_title', 'tab_items', $i );

				$card_title_classes   = array();
				$card_title_classes[] = 'm-0 card-title d-flex ube-tabs-card-title';
				if ( $nav_link_classes !== '' ) {
					$card_title_classes[] = $nav_link_classes;
				}
				if ( $i !== 0 ) {
					$card_title_classes[] = 'collapsed';
				}
				if ( ( $tab_type == 'pills' || $tab_type == 'underline' ) && $tab_scheme != '' && $tab_scheme !== 'light' ) {
					$card_title_classes[] = 'text-' . $tab_scheme;
				}
				$card_title_toggle = '';
				if ( $i == 0 ) {
					$card_title_toggle = "false";
				} else {
					$card_title_toggle = "collapse";
				}

				$aria_expanded = '';
				if ( $i !== 0 ) {
					$aria_expanded = 'false';
				} else {
					$aria_expanded = 'true';
				}
				$element->add_render_attribute( $tabs_card_title_setting_key, array(
					'class'         => $card_title_classes,
					'data-toggle'   => $card_title_toggle,
					'aria-expanded' => $aria_expanded,
					'data-target'   => "#collapse-" . $tab_id,
					'aria-controls' => "collapse-" . $tab_id,
					'role'          => 'button'

				) );
				$collapse_class   = array();
				$collapse_class[] = 'collapse collapsible';
				if ( $i == 0 ) {
					$collapse_class[] = 'show';
				}
				$tabs_collapse_setting_key = $element->get_repeater_setting_key( 'tab_collapse', 'tab_items', $i );
				$element->add_render_attribute( $tabs_collapse_setting_key,
					array(
						'id'              => "collapse-" . $tab_id,
						'class'           => $collapse_class,
						'aria-labelledby' => "heading-" . $tab_id,
						'data-parent'     => "#collapse-tabs-accordion-" . $id_int
					) );
				?>
                <div <?php echo $element->get_render_attribute_string( $tabs_pane_setting_key ); ?>>
                    <div <?php echo $element->get_render_attribute_string( $tabs_card_setting_key ); ?>>
                        <div <?php echo $element->get_render_attribute_string( $tabs_card_header_setting_key ); ?>>
                            <div <?php echo $element->get_render_attribute_string( $tabs_card_title_setting_key ); ?>>
								<?php if ( $tab_title_type_icon == 'yes' ): ?>
                                    <span class="ube-tab-icon <?php echo esc_attr( $icon_classes ) ?>">
                        <?php
                        if ( ! empty( $item['tab_title_image']['url'] ) ) {
	                        echo Group_Control_Image_Size::get_attachment_image_html( $item, 'thumbnail', 'tab_title_image' );
                        } elseif ( ! empty( $item['tab_title_icons'] ) ) {
	                        Icons_Manager::render_icon( $item['tab_title_icons'] );
                        }
                        ?>
                             </span>
								<?php
								endif;
								?>
                                <span class="<?php echo esc_attr( $title_classes ) ?>">
                            <?php echo esc_html( $item['tab_title'] ); ?>
                        </span>
                            </div>
                        </div>
                        <div <?php echo $element->get_render_attribute_string( $tabs_collapse_setting_key ); ?>>
                            <div class="card-body border-sm-0 ube-tabs-card-body">
								<?php echo UBE_Module_Dynamic_Content::get_instance()->parse_widget_content( 'tab_content', $item['tab_content'], $element->get_id(), ( $i + 1 )); ?>
                            </div>
                        </div>
                    </div>

                </div>
			<?php
			endforeach;
			?>
        </div>
    </div>
</div>