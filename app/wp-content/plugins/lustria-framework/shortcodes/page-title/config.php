<?php
/**
 * The template for displaying config.php
 *
 */
return array(
	'base' => 'gsf_page_title',
	'name' => esc_html__('Page Title', 'lustria-framework'),
	'category' => G5P()->shortcode()->get_category_name(),
	'icon' => 'fab fa-pinterest-p',
	'params' => array(
		array(
			'type' => 'font_container',
			'param_name' => 'font_container',
			'value' => 'text_align:left|color:#333333',
			'settings' => array(
				'fields' => array(
					'text_align' =>'left',
					'color' => '#333333',
					'text_align_description' => __( 'Select text alignment.', 'lustria-framework' ),
					'color_description' => __( 'Select heading color.', 'lustria-framework' ),
				),
			),
		),
        array(
            'type' => 'gsf_number_responsive',
            'heading' => esc_html__('Font size', 'lustria-framework'),
            'param_name' => 'title_font_size',
            'value' => '40||34||30'
        ),
		array(
			'type' => 'gsf_switch',
			'heading' => __( 'Use theme default font family?', 'lustria-framework' ),
			'param_name' => 'use_theme_fonts',
            'std' => 'on',
			'description' => __( 'Use font family from the theme.', 'lustria-framework' ),
		),
		array(
			'type' => 'gsf_typography',
			'param_name' => 'typography',
            'dependency' => array('element' => 'use_theme_fonts', 'value_not_equal_to' => 'on')
		),
		G5P()->shortcode()->vc_map_add_css_animation(),
		G5P()->shortcode()->vc_map_add_animation_duration(),
		G5P()->shortcode()->vc_map_add_animation_delay(),
		G5P()->shortcode()->vc_map_add_extra_class(),
		G5P()->shortcode()->vc_map_add_css_editor(),
		G5P()->shortcode()->vc_map_add_responsive()
	)
);