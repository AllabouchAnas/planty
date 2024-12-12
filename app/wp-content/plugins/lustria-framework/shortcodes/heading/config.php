<?php
return array(
    'base' => 'gsf_heading',
    'name' => esc_html__('Heading', 'lustria-framework'),
    'icon' => 'fa fa-header',
    'category' => G5P()->shortcode()->get_category_name(),
    'params' => array(
        array(
            'type' => 'gsf_image_set',
            'heading' => esc_html__('Layout Style', 'lustria-framework'),
            'param_name' => 'layout_style',
            'value' => apply_filters('gsf_heading_layout_style', array(
                'style-1' => array(
                    'label' => esc_html__('Style 01', 'lustria-framework'),
                    'img' => G5P()->pluginUrl('assets/images/shortcode/heading-1.jpg'),
                ),
                'style-2' => array(
                    'label' => esc_html__('Style 02', 'lustria-framework'),
                    'img' => G5P()->pluginUrl('assets/images/shortcode/heading-2.jpg'),
                ),
            )),
            'std' => 'style-1',
            'admin_label' => true,
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__('Text Alignment', 'lustria-framework'),
            'param_name' => 'text_align',
            'description' => esc_html__('Select text alignment.', 'lustria-framework'),
            'value' => array(
                esc_html__('Left', 'lustria-framework') => 'text-left',
                esc_html__('Center', 'lustria-framework') => 'text-center',
                esc_html__('Right', 'lustria-framework') => 'text-right'
            ),
            'std' => 'text-center',
            'admin_label' => true,
        ),
        array(
            'type' => 'gsf_number_and_unit',
            'heading' => esc_html__('Distance between Title and Subtitle', 'lustria-framework'),
            'param_name' => 'space_between',
            'edit_field_class' => 'vc_col-sm-6 vc_column',
            'value' => ''
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__('Title', 'lustria-framework'),
            'param_name' => 'title',
            'admin_label' => true,
        ),
        array(
            'type' => 'colorpicker',
            'heading' => esc_html__('Title Color', 'lustria-framework'),
            'param_name' => 'title_color',
            'std' => '',
            'dependency' => array('element' => 'title', 'value_not_equal_to' => array('')),
            'group' => esc_html__('Title Options', 'lustria-framework')
        ),
        array(
            'type' => 'gsf_number_responsive',
            'heading' => esc_html__('Font size', 'lustria-framework'),
            'param_name' => 'title_font_size',
            'group' => esc_html__('Title Options', 'lustria-framework'),
            'dependency' => array('element' => 'title', 'value_not_equal_to' => array('')),
            'value' => ''
        ),
        array(
            'type' => 'gsf_number_and_unit',
            'heading' => esc_html__('Title Line Height', 'lustria-framework'),
            'param_name' => 'title_line_height',
            'std' => '',
            'dependency' => array('element' => 'title', 'value_not_equal_to' => array('')),
            'edit_field_class' => 'vc_col-sm-6 vc_column',
            'group' => esc_html__('Title Options', 'lustria-framework')
        ),
        array(
            'type' => 'gsf_number_and_unit',
            'heading' => esc_html__('Title Letter Spacing', 'lustria-framework'),
            'param_name' => 'title_letter_spacing',
            'std' => '',
            'dependency' => array('element' => 'title', 'value_not_equal_to' => array('')),
            'edit_field_class' => 'vc_col-sm-6 vc_column',
            'group' => esc_html__('Title Options', 'lustria-framework')
        ),
        array(
            'type' => 'gsf_switch',
            'heading' => __('Use Theme Default Font family for Heading title?', 'lustria-framework'),
            'param_name' => 'title_use_theme_fonts',
            'std' => 'on',
            'group' => esc_html__('Title Options', 'lustria-framework'),
            'dependency' => array('element' => 'title', 'value_not_equal_to' => array(''))
        ),
        array(
            'type' => 'gsf_typography',
            'param_name' => 'title_typography',
            'dependency' => array('element' => 'title_use_theme_fonts', 'value_not_equal_to' => 'on'),
            'group' => esc_html__('Title Options', 'lustria-framework')
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__('Sub Title', 'lustria-framework'),
            'param_name' => 'sub_title',
        ),
        array(
            'type' => 'gsf_number_responsive',
            'heading' => esc_html__('Font size', 'lustria-framework'),
            'param_name' => 'sub_title_font_size',
            'group' => esc_html__('Sub Title Options', 'lustria-framework'),
            'dependency' => array('element' => 'sub_title', 'value_not_equal_to' => array('')),
            'value' => ''
        ),

        array(
            'type' => 'gsf_number_and_unit',
            'heading' => esc_html__('Sub Title Letter Spacing', 'lustria-framework'),
            'param_name' => 'sub_title_letter_spacing',
            'std' => '',
            'dependency' => array('element' => 'sub_title', 'value_not_equal_to' => array('')),
            'edit_field_class' => 'vc_col-sm-6 vc_column',
            'group' => esc_html__('Sub Title Options', 'lustria-framework')
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__('Sub Title color', 'lustria-framework'),
            'param_name' => 'sub_title_color',
            'value' => array(
                esc_html__('None', 'lustria-framework') => '',
                esc_html__('Accent Color', 'lustria-framework') => 'accent-color',
                esc_html__('Heading Color', 'lustria-framework') => 'heading-color',
                esc_html__('Text Color', 'lustria-framework') => 'text-color',
                esc_html__('Disable Color', 'lustria-framework') => 'disable-color',
                esc_html__('Primary Color', 'lustria-framework') => 'primary-color',
                esc_html__('Custom', 'lustria-framework') => 'custom',
            ),
            'std' => 'None',
            'group' => esc_html__('Sub Title Options', 'lustria-framework'),
            'edit_field_class' => 'vc_col-sm-6 vc_column',
            'dependency' => array('element' => 'sub_title', 'value_not_equal_to' => array(''))
        ),
        array(
            'type' => 'colorpicker',
            'heading' => esc_html__('Custom color', 'lustria-framework'),
            'param_name' => 'custom_sub_title_color',
            'group' => esc_html__('Sub Title Options', 'lustria-framework'),
            'std' => '',
            'dependency' => array(
                'element' => 'sub_title_color',
                'value' => array('custom')
            ),
        ),
        array(
            'type' => 'gsf_switch',
            'heading' => __('Use Theme Default Font family for Heading sub title?', 'lustria-framework'),
            'param_name' => 'sub_title_use_theme_fonts',
            'std' => 'on',
            'group' => esc_html__('Sub Title Options', 'lustria-framework'),
            'dependency' => array('element' => 'sub_title', 'value_not_equal_to' => array(''))
        ),
        array(
            'type' => 'gsf_typography',
            'param_name' => 'sub_title_typography',
            'dependency' => array('element' => 'sub_title_use_theme_fonts', 'value_not_equal_to' => 'on'),
            'group' => esc_html__('Sub Title Options', 'lustria-framework'),
        ),
        G5P()->shortcode()->vc_map_add_css_animation(),
        G5P()->shortcode()->vc_map_add_animation_duration(),
        G5P()->shortcode()->vc_map_add_animation_delay(),
        G5P()->shortcode()->vc_map_add_extra_class(),
        G5P()->shortcode()->vc_map_add_css_editor(),
        G5P()->shortcode()->vc_map_add_responsive()
    ),
);