<?php
return array(
	'base' => 'gsf_social_networks',
	'name' => esc_html__( 'Social Networks', 'lustria-framework' ),
	'icon' => 'fa fa-share-alt',
	'category' => G5P()->shortcode()->get_category_name(),
	'params' => array(
		array(
			'param_name' => 'social_networks',
			'heading' => esc_html__('Social Networks', 'lustria-framework'),
			'type' => 'gsf_selectize',
			'multiple' => true,
			'drag' => true,
			'description' => esc_html__('Select Social Networks', 'lustria-framework'),
			'value' => G5P()->shortcode()->switch_array_key_value(G5P()->settings()->get_social_networks())
		),
		array(
			'param_name' => 'social_shape',
			'heading' => esc_html__('Social Shape', 'lustria-framework'),
			'type' => 'dropdown',
			'value' => array(
				esc_html__( 'Classic', 'lustria-framework' ) => 'classic',
				esc_html__( 'Circle Fill', 'lustria-framework' ) => 'circle',
                esc_html__( 'Circle Outline', 'lustria-framework' ) => 'circle-outline',
                esc_html__( 'Square', 'lustria-framework' ) => 'square',
			),
			'std' => 'classic'
		),
        array(
            'param_name' => 'social_size',
            'heading' => esc_html__('Social Size', 'lustria-framework'),
            'type' => 'dropdown',
            'value' => array(
                esc_html__( 'Small', 'lustria-framework' ) => 'small',
                esc_html__( 'Normal', 'lustria-framework' ) => 'normal',
                esc_html__( 'Large', 'lustria-framework' ) => 'large'
            ),
            'std' => 'normal'
        ),
        array(
            'type' => 'gsf_number_responsive',
            'heading' => esc_html__('Distance between items', 'lustria-framework'),
            'param_name' => 'space_between',
            'std' => '10||||'
        ),
		G5P()->shortcode()->vc_map_add_css_animation(),
		G5P()->shortcode()->vc_map_add_animation_duration(),
		G5P()->shortcode()->vc_map_add_animation_delay(),
		G5P()->shortcode()->vc_map_add_extra_class(),
		G5P()->shortcode()->vc_map_add_css_editor(),
		G5P()->shortcode()->vc_map_add_responsive()
	),
);