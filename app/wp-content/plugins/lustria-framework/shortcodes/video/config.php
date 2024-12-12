<?php
return array(
	'name' => esc_html__( 'Video', 'lustria-framework' ),
	'base' => 'gsf_video',
	'icon' => 'fa fa-play-circle',
	'category' => G5P()->shortcode()->get_category_name(),
	'params' => array(
        array(
            'type' => 'dropdown',
            'heading' => esc_html__('Video Icon Style', 'lustria-framework'),
            'param_name' => 'video_style',
            'value' => array(
                esc_html__('Outline', 'lustria-framework') => 'outline',
                esc_html__('Fill', 'lustria-framework') => 'fill'
            ),
            'std' =>'outline'
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__('Video Icon Size', 'lustria-framework'),
            'param_name' => 'video_size',
            'value' => array(
                esc_html__('Large', 'lustria-framework') => 'large',
                esc_html__('Medium', 'lustria-framework') => 'medium',
                esc_html__('Small', 'lustria-framework') => 'small'),
            'std' =>'large',
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Link', 'lustria-framework' ),
            'param_name' => 'link',
            'value' => '',
            'description' => esc_html__( 'Enter link video', 'lustria-framework' ),
        ),

        array(
            'type' => 'colorpicker',
            'heading' => esc_html__( 'Icon Background/Border Color', 'lustria-framework' ),
            'param_name' => 'icon_bg_color',
            'edit_field_class' => 'vc_col-sm-6 vc_column',
            'std' => G5P()->options()->get_accent_color()
        ),
        array(
            'type' => 'colorpicker',
            'heading' => esc_html__( 'Icon Color', 'lustria-framework' ),
            'param_name' => 'icon_color',
            'edit_field_class' => 'vc_col-sm-6 vc_column',
            'std' => G5P()->options()->get_foreground_accent_color()
        ),
        array(
            'type' => 'colorpicker',
            'heading' => esc_html__( 'Icon Background Hover Color', 'lustria-framework' ),
            'param_name' => 'icon_bg_hover_color',
            'edit_field_class' => 'vc_col-sm-6 vc_column',
            'std' => '#333'
        ),
        array(
            'type' => 'colorpicker',
            'heading' => esc_html__( 'Icon Hover Color', 'lustria-framework' ),
            'param_name' => 'icon_hover_color',
            'edit_field_class' => 'vc_col-sm-6 vc_column',
            'std' => '#fff'
        ),
        G5P()->shortcode()->vc_map_add_css_animation(),
        G5P()->shortcode()->vc_map_add_animation_duration(),
        G5P()->shortcode()->vc_map_add_animation_delay(),
        G5P()->shortcode()->vc_map_add_extra_class(),
        G5P()->shortcode()->vc_map_add_css_editor(),
        G5P()->shortcode()->vc_map_add_responsive()
	)
);