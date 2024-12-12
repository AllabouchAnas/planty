<?php
return array(
	'base' => 'gsf_counter',
	'name' => esc_html__( 'Counter', 'lustria-framework' ),
	'icon' => 'fa fa-tachometer',
	'category' => G5P()->shortcode()->get_category_name(),
	'params' => array(
        array(
            'type' => 'gsf_button_set',
            'heading' => esc_html__('Alignment', 'lustria-framework'),
            'param_name' => 'text_align',
            'description' => esc_html__('Select Alignment for counter', 'lustria-framework'),
            'value' => array(
                esc_html__('Left', 'lustria-framework') => 'text-left',
                esc_html__('Center', 'lustria-framework') => 'text-center',
                esc_html__('Right', 'lustria-framework') => 'text-right'
            ),
            'edit_field_class' => 'vc_col-sm-6 vc_column',
            'std' => 'text-center'
        ),
        array(
            'type' => 'gsf_button_set',
            'heading' => esc_html__('Counter Size', 'lustria-framework'),
            'param_name' => 'counter_size',
            'description' => esc_html__('Select Size for counter', 'lustria-framework'),
            'value' => array(
                esc_html__('Small', 'lustria-framework') => 'counter-size-sm',
                esc_html__('Medium', 'lustria-framework') => 'counter-size-md',
                esc_html__('Large', 'lustria-framework') => 'counter-size-lg',
            ),
            'edit_field_class' => 'vc_col-sm-6 vc_column',
            'std' => 'counter-size-md'
        ),
		G5P()->shortcode()->vc_map_add_title(array('admin_label' => true)),
        array(
            'type' => 'colorpicker',
            'heading' => esc_html__('Custom Title Color', 'lustria-framework'),
            'param_name' => 'title_color',
            'std' => '',
            'edit_field_class' => 'vc_col-sm-6 vc_column',
            'dependency' => array('element' => 'title', 'value_not_equal_to' => array('')),
        ),
        G5P()->shortcode()->vc_map_add_icon_font(),
        array(
            'type' => 'colorpicker',
            'heading' => esc_html__('ICon Color', 'lustria-framework'),
            'param_name' => 'icon_color',
            'std' => '',
            'edit_field_class' => 'vc_col-sm-6 vc_column',
            'dependency' => array('element' => 'icon_font', 'value_not_equal_to' => array('')),
        ),
        array(
            'type' => 'colorpicker',
            'heading' => esc_html__('Icon Hover Color', 'lustria-framework'),
            'param_name' => 'icon_hover_color',
            'std' => '',
            'description' => __( 'Choose icon color when hover', 'lustria-framework' ),
            'edit_field_class' => 'vc_col-sm-6 vc_column',
            'dependency' => array('element' => 'icon_font', 'value_not_equal_to' => array(''))
        ),
        array(
            'type' => 'gsf_switch',
            'heading' => __('Use Theme Default Font family for Counter title?', 'lustria-framework'),
            'param_name' => 'title_use_theme_fonts',
            'std' => 'on'
        ),
        array(
            'type' => 'gsf_typography',
            'param_name' => 'title_typography',
            'dependency' => array('element' => 'title_use_theme_fonts', 'value_not_equal_to' => 'on')
        ),
		array(
			'type'             => 'textfield',
			'heading'          => esc_html__('Start Value', 'lustria-framework'),
			'param_name'       => 'start',
			'value'            => '',
			'std'              => '0',
			'edit_field_class' => 'vc_col-sm-6 vc_column',
            'group' => esc_html__('Value Options', 'lustria-framework')
		),
		array(
			'type'             => 'textfield',
			'heading'          => esc_html__('End Value', 'lustria-framework'),
			'param_name'       => 'end',
			'value'            => '',
			'std'              => '1000',
			'admin_label' => true,
			'edit_field_class' => 'vc_col-sm-6 vc_column',
            'group' => esc_html__('Value Options', 'lustria-framework')
		),
		array(
			'type'             => 'textfield',
			'heading'          => esc_html__('Decimals', 'lustria-framework'),
			'param_name'       => 'decimals',
			'value'            => '',
			'std'              => '0',
			'edit_field_class' => 'vc_col-sm-6 vc_column',
            'group' => esc_html__('Value Options', 'lustria-framework')
		),
		array(
			'type'             => 'textfield',
			'heading'          => esc_html__('Duration (s)', 'lustria-framework'),
			'param_name'       => 'duration',
			'value'            => '',
			'std'              => '2,5',
			'edit_field_class' => 'vc_col-sm-6 vc_column',
            'group' => esc_html__('Value Options', 'lustria-framework')
		),
		array(
			'type'             => 'textfield',
			'heading'          => esc_html__('Separator', 'lustria-framework'),
			'param_name'       => 'separator',
			'value'            => '',
			'std'              => '',
			'edit_field_class' => 'vc_col-sm-6 vc_column',
            'group' => esc_html__('Value Options', 'lustria-framework')
		),
		array(
			'type'             => 'textfield',
			'heading'          => esc_html__('Decimal', 'lustria-framework'),
			'param_name'       => 'decimal',
			'value'            => '',
			'std'              => '.',
			'edit_field_class' => 'vc_col-sm-6 vc_column',
            'group' => esc_html__('Value Options', 'lustria-framework')
		),
		array(
			'type'             => 'textfield',
			'heading'          => esc_html__('Prefix', 'lustria-framework'),
			'param_name'       => 'prefix',
			'value'            => '',
			'edit_field_class' => 'vc_col-sm-6 vc_column',
            'group' => esc_html__('Value Options', 'lustria-framework')
		),
		array(
			'type'             => 'textfield',
			'heading'          => esc_html__('Suffix', 'lustria-framework'),
			'param_name'       => 'suffix',
			'value'            => '',
			'edit_field_class' => 'vc_col-sm-6 vc_column',
            'group' => esc_html__('Value Options', 'lustria-framework')
		),
        array(
            'type' => 'colorpicker',
            'heading' => esc_html__('Value Color', 'lustria-framework'),
            'param_name' => 'main_color',
            'edit_field_class' => 'vc_col-sm-6 vc_column',
            'std' => '',
            'group' => esc_html__('Value Options', 'lustria-framework')
        ),
        array(
            'type' => 'gsf_number_responsive',
            'heading' => esc_html__('Value Font size', 'lustria-framework'),
            'param_name' => 'value_title',
            'group' => esc_html__('Value Options', 'lustria-framework'),
            'value' => ''
        ),
        array(
            'type' => 'gsf_switch',
            'heading' => __('Use Theme Default Font family for Counter title?', 'lustria-framework'),
            'param_name' => 'value_use_theme_fonts',
            'std' => 'on',
            'group' => esc_html__('Value Options', 'lustria-framework')
        ),
        array(
            'type' => 'gsf_typography',
            'param_name' => 'value_typography',
            'dependency' => array('element' => 'value_use_theme_fonts', 'value_not_equal_to' => 'on'),
            'group' => esc_html__('Value Options', 'lustria-framework')
        ),
		G5P()->shortcode()->vc_map_add_css_animation(),
		G5P()->shortcode()->vc_map_add_animation_duration(),
		G5P()->shortcode()->vc_map_add_animation_delay(),
		G5P()->shortcode()->vc_map_add_extra_class(),
		G5P()->shortcode()->vc_map_add_css_editor(),
		G5P()->shortcode()->vc_map_add_responsive()
	),
);