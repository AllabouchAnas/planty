<?php
return array(
	'base' => 'gsf_lists',
	'name' => esc_html__('Lists','lustria-framework'),
	'icon' => 'fa fa-list-ol',
    'category' => G5P()->shortcode()->get_category_name(),
	'params' =>	array(
	    array(
			'type' => 'dropdown',
			'heading' => esc_html__('Bullet Type', 'lustria-framework'),
			'param_name' => 'bullet_type',
			'value' => array(
				esc_html__('Number','lustria-framework') => 'list-number',
				esc_html__('Icon','lustria-framework') => 'list-icon',
				esc_html__('Dot','lustria-framework') => 'list-dot',
				esc_html__('Square','lustria-framework') => 'list-square',
			),
            'std' => 'list-number',
			'admin_label' => true,
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__('Bullet Style', 'lustria-framework'),
			'param_name' => 'bullet_style',
			'value' => array(
                esc_html__('Simple','lustria-framework') => 'list-simple',
                esc_html__('Square','lustria-framework') => 'list-square-outline',
                esc_html__('Circle','lustria-framework') => 'list-circle-outline',
            ),
			'std' => 'list-simple',
			'description' => esc_html__( 'Select lists design style.', 'lustria-framework' ),
			'admin_label' => true,
			'dependency'  => array('element' => 'bullet_type', 'value' => 'list-icon'),
		),
        array(
            'type' => 'colorpicker',
            'heading' => esc_html__( 'Bullet Color', 'lustria-framework' ),
            'param_name' => 'bullet_color',
            'std' => '',
            'description' => esc_html__( 'Select bullet color.', 'lustria-framework' )
        ),
		array(
			'type' => 'colorpicker',
			'heading' => esc_html__( 'Label Color', 'lustria-framework' ),
			'param_name' => 'label_color',
			'description' => esc_html__( 'Select Label color.', 'lustria-framework' ),
            'std' => ''
		),
        G5P()->shortcode()->vc_map_add_icon_font(array(
            'dependency'  => array('element' => 'bullet_type', 'value' => 'list-icon')
        )),
		array(
			'type' => 'param_group',
			'heading' => esc_html__('Values','lustria-framework'),
			'param_name' => 'values',
			'description' => esc_html__('Enter values for list - icon and text','lustria-framework'),
			'value' => '',
			'params' => array(
				array(
					'type' => 'textarea',
					'heading' => esc_html__( 'Label', 'lustria-framework' ),
					'param_name' => 'label',
					'admin_label' => true,
				),
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__( 'Custom Bullet', 'lustria-framework' ),
                    'param_name' => 'custom_bullet',
                    'description' => esc_html__('Set empty for default', 'lustria-framework')
                ),
                array(
                    'type' => 'colorpicker',
                    'heading' => esc_html__( 'Bullet Color', 'lustria-framework' ),
                    'param_name' => 'bullet_color',
                    'std' => '',
                    'description' => esc_html__( 'Set empty for default.', 'lustria-framework' )
                ),
                array(
                    'type' => 'colorpicker',
                    'heading' => esc_html__( 'Label Color', 'lustria-framework' ),
                    'param_name' => 'label_color',
                    'description' => esc_html__( 'Set empty for default.', 'lustria-framework' ),
                    'std' => ''
                ),
                G5P()->shortcode()->vc_map_add_icon_font(),
			)
		),
        G5P()->shortcode()->vc_map_add_css_animation(),
        G5P()->shortcode()->vc_map_add_animation_duration(),
        G5P()->shortcode()->vc_map_add_animation_delay(),
        G5P()->shortcode()->vc_map_add_extra_class(),
        G5P()->shortcode()->vc_map_add_css_editor(),
        G5P()->shortcode()->vc_map_add_responsive()
	)
);
