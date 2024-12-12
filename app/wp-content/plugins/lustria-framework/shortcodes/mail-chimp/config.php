<?php
/**
 * The template for displaying config.php
 *
 * @package WordPress
 * @subpackage lustria
 * @since lustria 1.0
 */
return array(
	'base'     => 'gsf_mail_chimp',
	'name'     => esc_html__('Mail Chimp', 'lustria-framework'),
	'category' => G5P()->shortcode()->get_category_name(),
	'icon'     => 'fa fa-envelope',
	'params'   => array(
		array(
			'type'        => 'gsf_image_set',
			'heading'     => esc_html__('Layout Style', 'lustria-framework'),
			'param_name'  => 'layout_style',
			'value'       => apply_filters('gsf_mail_chimp_layout_style',array(
				'style-01' => array(
					'label' => esc_html__('Style 01', 'lustria-framework'),
					'img'   => G5P()->pluginUrl('assets/images/shortcode/mailchimp-01.png'),
				),
				'style-02' => array(
					'label' => esc_html__('Style 02', 'lustria-framework'),
					'img'   => G5P()->pluginUrl('assets/images/shortcode/mailchimp-02.png'),
				),
			)),
			'std'         => 'style-01',
			'admin_label' => true,
		),
		G5P()->shortcode()->vc_map_add_css_animation(),
		G5P()->shortcode()->vc_map_add_animation_duration(),
		G5P()->shortcode()->vc_map_add_animation_delay(),
		G5P()->shortcode()->vc_map_add_extra_class(),
		G5P()->shortcode()->vc_map_add_css_editor(),
		G5P()->shortcode()->vc_map_add_responsive()
	)
);