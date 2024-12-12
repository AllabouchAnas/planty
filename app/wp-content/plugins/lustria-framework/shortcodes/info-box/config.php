<?php
return array(
    'base' => 'gsf_info_box',
    'name' => esc_html__('Info Box','lustria-framework'),
    'icon' => 'fa fa-diamond',
    'category' => G5P()->shortcode()->get_category_name(),
    'params' => array(
        array(
            'type' => 'gsf_image_set',
            'heading' => esc_html__('Layout Style', 'lustria-framework'),
            'param_name' => 'layout_style',
            'value' => apply_filters('gsf_info_box_layout_style',array(
                'text-left' => array(
                    'label' => esc_html__('Style 01', 'lustria-framework'),
                    'img' => G5P()->pluginUrl('assets/images/shortcode/info-box-01.png'),
                ),
                'text-center' => array(
                    'label' => esc_html__('Style 02', 'lustria-framework'),
                    'img' => G5P()->pluginUrl('assets/images/shortcode/info-box-02.png'),
                ),
                'text-right' => array(
                    'label' => esc_html__('Style 03', 'lustria-framework'),
                    'img' => G5P()->pluginUrl('assets/images/shortcode/info-box-03.png'),
                ),
                'ib-left' => array(
                    'label' => esc_html__('Style 04', 'lustria-framework'),
                    'img' => G5P()->pluginUrl('assets/images/shortcode/info-box-04.png'),
                ),
                'ib-right' => array(
                    'label' => esc_html__('Style 05', 'lustria-framework'),
                    'img' => G5P()->pluginUrl('assets/images/shortcode/info-box-05.png'),
                ),
                'ib-left-inline' => array(
                    'label' => esc_html__('Style 06', 'lustria-framework'),
                    'img' => G5P()->pluginUrl('assets/images/shortcode/info-box-06.png'),
                ),
                'ib-right-inline' => array(
                    'label' => esc_html__('Style 07', 'lustria-framework'),
                    'img' => G5P()->pluginUrl('assets/images/shortcode/info-box-07.png'),
                )
            )),
            'std' => 'text-left',
            'admin_label' => true
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__('Title', 'lustria-framework' ),
            'param_name' => 'title',
            'value' => '',
            'admin_label' => true,
        ),
        array(
            'type' => 'gsf_number_and_unit',
            'heading' => esc_html__('Distance between Title and Description', 'lustria-framework'),
            'param_name' => 'space_between',
            'edit_field_class' => 'vc_col-sm-6 vc_column',
            'value' => ''
        ),
        array(
            'type' => 'colorpicker',
            'heading' => esc_html__('Title Color', 'lustria-framework'),
            'param_name' => 'title_color',
            'std' => '',
            'group' => esc_html__('Title Options', 'lustria-framework'),
            'edit_field_class' => 'vc_col-sm-6 vc_column',
            'dependency' => array('element' => 'title', 'value_not_equal_to' => array(''))
        ),
        array(
            'type' => 'gsf_number_responsive',
            'heading' => esc_html__('Title Font Size', 'lustria-framework'),
            'param_name' => 'title_font_size',
            'group' => esc_html__('Title Options', 'lustria-framework'),
            'dependency' => array('element' => 'title', 'value_not_equal_to' => array('')),
            'std' => ''
        ),
        array(
            'type' => 'gsf_number_and_unit',
            'heading' => esc_html__('Title Line Height', 'lustria-framework'),
            'param_name' => 'title_line_height',
            'group' => esc_html__('Title Options', 'lustria-framework'),
            'dependency' => array('element' => 'title', 'value_not_equal_to' => array('')),
            'std' => '',
            'edit_field_class' => 'vc_col-sm-6 vc_column'
        ),
        array(
            'type' => 'gsf_number_and_unit',
            'heading' => esc_html__('Title Letter Spacing', 'lustria-framework'),
            'param_name' => 'title_letter_spacing',
            'group' => esc_html__('Title Options', 'lustria-framework'),
            'dependency' => array('element' => 'title', 'value_not_equal_to' => array('')),
            'std' => '',
            'edit_field_class' => 'vc_col-sm-6 vc_column'
        ),
        array(
            'type' => 'gsf_switch',
            'heading' => __( 'Use theme default font family?', 'lustria-framework' ),
            'param_name' => 'use_theme_fonts',
            'group' => esc_html__('Title Options', 'lustria-framework'),
            'std' => 'on',
            'description' => __( 'Use font family from the theme.', 'lustria-framework' ),
            'dependency' => array('element' => 'title', 'value_not_equal_to' => array(''))
        ),
        array(
            'type' => 'gsf_typography',
            'param_name' => 'typography',
            'group' => esc_html__('Title Options', 'lustria-framework'),
            'dependency' => array('element' => 'use_theme_fonts', 'value_not_equal_to' => 'on')
        ),
        array(
            'type' => 'textarea_raw_html',
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
        array(
            'type' => 'vc_link',
            'heading' => esc_html__('Link (url)', 'lustria-framework'),
            'param_name' => 'link',
            'value' => '',
        ),

        array(
            'type' => 'gsf_button_set',
            'heading' => esc_html__('Icon Type', 'lustria-framework'),
            'param_name' => 'icon_type',
            'group' => esc_html__('Icon Options', 'lustria-framework'),
            'value' => array(
                esc_html__('Icon', 'lustria-framework') => 'icon',
                esc_html__('Image', 'lustria-framework') => 'image',
            ),
            'std' => 'icon'
        ),
        array(
            'type'        => 'attach_image',
            'heading'     => esc_html__('Images', 'lustria-framework'),
            'param_name'  => 'image',
            'group' => esc_html__('Icon Options', 'lustria-framework'),
            'value'       => '',
            'description' => esc_html__('Select images from media library.', 'lustria-framework'),
            'dependency' => array('element' => 'icon_type', 'value' => 'image')
        ),
        G5P()->shortcode()->vc_map_add_icon_font(array(
            'group' => esc_html__('Icon Options', 'lustria-framework'),
            'dependency' => array('element' => 'icon_type', 'value' => 'icon')
        )),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__('Icon Background Style', 'lustria-framework'),
            'param_name' => 'icon_bg_style',
            'value' => array(
                esc_html__('Classic', 'lustria-framework') => 'icon-classic',
                esc_html__('Circle - Fill Color', 'lustria-framework') => 'icon-bg-circle-fill',
                esc_html__('Circle - Outline', 'lustria-framework') => 'icon-bg-circle-outline',
                esc_html__('Square - Fill Color', 'lustria-framework') => 'icon-bg-square-fill',
                esc_html__('Square - Outline', 'lustria-framework') => 'icon-bg-square-outline',
                esc_html__('Icon float on Circle Background', 'lustria-framework') => 'icon-float-on-circle'
            ),
            'std' => 'icon-classic',
            'group' => esc_html__('Icon Options', 'lustria-framework'),
            'description' => esc_html__('Select Icon Background Style.', 'lustria-framework'),
            'dependency' => array('element' => 'icon_type', 'value' => 'icon')
        ),
        array(
            'type' => 'colorpicker',
            'heading' => esc_html__('Icon Color', 'lustria-framework'),
            'param_name' => 'icon_color',
            'std' => '',
            'group' => esc_html__('Icon Options', 'lustria-framework'),
            'edit_field_class' => 'vc_col-sm-6 vc_column',
            'dependency' => array('element' => 'icon_type', 'value' => 'icon'),
        ),
        array(
            'type' => 'colorpicker',
            'heading' => esc_html__('Background Color', 'lustria-framework'),
            'param_name' => 'icon_bg_color',
            'std' => '',
            'group' => esc_html__('Icon Options', 'lustria-framework'),
            'edit_field_class' => 'vc_col-sm-6 vc_column',
            'dependency' => array('element'=>'icon_bg_style', 'value_not_equal_to'=>'icon-classic')
        ),
        array(
            'type' => 'colorpicker',
            'heading' => __( 'Icon Box Shadow', 'lustria-framework' ),
            'param_name' => 'ib_icon_box_shadow',
            'std' => '',
            'group' => esc_html__('Icon Options', 'lustria-framework'),
            'description' => __( 'Set empty for hidden', 'lustria-framework' ),
            'edit_field_class' => 'vc_col-sm-6 vc_column',
            'dependency' => array('element'=>'icon_bg_style', 'value_not_equal_to'=>'icon-classic')
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__('Icon Size', 'lustria-framework'),
            'param_name' => 'icon_size',
            'value' => array(
                esc_html__('Large', 'lustria-framework') => 'ib-large',
                esc_html__('Medium', 'lustria-framework') => 'ib-medium',
                esc_html__('Small', 'lustria-framework') => 'ib-small'
            ),
            'std' => 'ib-large',
            'group' => esc_html__('Icon Options', 'lustria-framework'),
            'description' => esc_html__('Select Color Scheme.', 'lustria-framework'),
            'edit_field_class' => 'vc_col-sm-6 vc_column',
            'dependency' => array('element' => 'icon_type', 'value' => 'icon'),
        ),
        array(
            'type' => 'gsf_button_set',
            'heading' => esc_html__('Icon Vertical Alignment', 'lustria-framework'),
            'param_name' => 'icon_align',
            'value' => array(
                esc_html__('Top', 'lustria-framework') => 'icon-align-top',
                esc_html__('Middle', 'lustria-framework') => 'icon-align-middle'
            ),
            'std' => 'icon-align-top',
            'group' => esc_html__('Icon Options', 'lustria-framework'),
            'description' => esc_html__('Select Icon Vertical Alignment.', 'lustria-framework'),
            'dependency' => array('element'=>'layout_style', 'value'=>array('ib-left','ib-right')),
            'edit_field_class' => 'vc_col-sm-6 vc_column',
        ),
        array(
            'type' => 'gsf_button_set',
            'heading' => esc_html__('Distance between Icon and Content', 'lustria-framework'),
            'param_name' => 'distance_between',
            'value' => array(
                esc_html__('Low', 'lustria-framework') => 'distance-low',
                esc_html__('Medium', 'lustria-framework') => 'distance-medium',
                esc_html__('Tall', 'lustria-framework') => 'distance-tall'
            ),
            'std' => 'distance-low',
            'group' => esc_html__('Icon Options', 'lustria-framework'),
            'dependency' => array('element'=>'layout_style', 'value'=>array('text-left', 'text-center','text-right')),
            'edit_field_class' => 'vc_col-sm-6 vc_column',
        ),

        array(
            'type' => 'gsf_switch',
            'heading' => esc_html__('Flip on Hover', 'lustria-framework'),
            'param_name' => 'flip_on_hover',
            'group' => esc_html__('Hover Options', 'lustria-framework'),
            'std' => ''
        ),
        array(
            'type' => 'attach_image',
            'heading' => esc_html__('Background Images on Flip', 'lustria-framework'),
            'param_name' => 'flip_bg_image',
            'value' => '',
            'description' => esc_html__('Select images from media library.', 'lustria-framework'),
            'group' => esc_html__('Hover Options', 'lustria-framework'),
            'dependency' => array('element' => 'flip_on_hover', 'value' => array('on'))
        ),
        array(
            'type' => 'colorpicker',
            'heading' => esc_html__('Background Color', 'lustria-framework'),
            'param_name' => 'hover_bg_color',
            'std' => '',
            'description' => __( 'Choose background color when hover', 'lustria-framework' ),
            'group' => esc_html__('Hover Options', 'lustria-framework'),
            'dependency' => array('element' => 'flip_on_hover', 'value_not_equal_to' => array('on')),
            'edit_field_class' => 'vc_col-sm-6 vc_column'
        ),
        array(
            'type' => 'colorpicker',
            'heading' => __( 'Box Shadow', 'lustria-framework' ),
            'param_name' => 'ib_hover_box_shadow',
            'std' => '',
            'group' => esc_html__('Hover Options', 'lustria-framework'),
            'description' => __( 'Set empty for hidden', 'lustria-framework' ),
            'edit_field_class' => 'vc_col-sm-6 vc_column'
        ),
        array(
            'type' => 'colorpicker',
            'heading' => esc_html__('Title', 'lustria-framework'),
            'param_name' => 'hover_text_color',
            'std' => '',
            'description' => __( 'Choose color when hover', 'lustria-framework' ),
            'group' => esc_html__('Hover Options', 'lustria-framework'),
            'dependency' => array('element' => 'flip_on_hover', 'value_not_equal_to' => array('on')),
            'edit_field_class' => 'vc_col-sm-6 vc_column'
        ),
        array(
            'type' => 'colorpicker',
            'heading' => esc_html__('Icon Color', 'lustria-framework'),
            'param_name' => 'icon_hover_color',
            'std' => '',
            'description' => __( 'Choose icon color when hover', 'lustria-framework' ),
            'group' => esc_html__('Hover Options', 'lustria-framework'),
            'edit_field_class' => 'vc_col-sm-6 vc_column',
            'dependency' => array('element' => 'flip_on_hover', 'value_not_equal_to' => array('on'))
        ),
        G5P()->shortcode()->vc_map_add_css_animation(),
        G5P()->shortcode()->vc_map_add_animation_duration(),
        G5P()->shortcode()->vc_map_add_animation_delay(),
        G5P()->shortcode()->vc_map_add_extra_class(),
        G5P()->shortcode()->vc_map_add_css_editor(),
        G5P()->shortcode()->vc_map_add_responsive()
    )
);