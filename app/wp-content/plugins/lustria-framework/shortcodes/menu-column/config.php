<?php
return array(
	'base' => 'gsf_menu_column',
	'name' => esc_html__( 'Menu Column', 'lustria-framework' ),
	'icon' => 'fa fa-bars',
	'category' => G5P()->shortcode()->get_category_name(),
	'params' => array(
        array(
            'type' => 'textfield',
            'heading' => esc_html__('Column Heading', 'lustria-framework'),
            'param_name' => 'title',
            'admin_label' => true,
        ),
        G5P()->shortcode()->vc_map_add_icon_font(array(
            'edit_field_class' => 'vc_col-sm-6 vc_column'
        )),
        array(
            'type' => 'param_group',
            'heading' => esc_html__('Menu Items', 'lustria-framework'),
            'param_name' => 'menu_items',
            'params' => array(
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__('Item Title', 'lustria-framework'),
                    'param_name' => 'label',
                    'admin_label' => true
                ),
                array(
                    'type' => 'vc_link',
                    'heading' => esc_html__('URL (Link)', 'lustria-framework'),
                    'param_name' => 'link'
                ),
                G5P()->shortcode()->vc_map_add_icon_font(array(
                    'edit_field_class' => 'vc_col-sm-6 vc_column'
                )),
                array(
                    'type' => 'dropdown',
                    'heading' => esc_html__('Item Style', 'lustria-framework'),
                    'param_name' => 'item_style',
                    'value' => array(
                        esc_html__('None', 'lustria-framework') => '',
                        esc_html__('New', 'lustria-framework') => 'new',
                        esc_html__('Hot', 'lustria-framework') => 'hot'
                    )
                ),
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__('Style Title', 'lustria-framework'),
                    'param_name' => 'style_title',
                    'dependency' => array('element' => 'item_style', 'value' => array('new', 'hot'))
                )
            )
        ),
		G5P()->shortcode()->vc_map_add_css_animation(),
		G5P()->shortcode()->vc_map_add_animation_duration(),
		G5P()->shortcode()->vc_map_add_animation_delay(),
		G5P()->shortcode()->vc_map_add_extra_class(),
		G5P()->shortcode()->vc_map_add_css_editor(),
		G5P()->shortcode()->vc_map_add_responsive()
	),
);