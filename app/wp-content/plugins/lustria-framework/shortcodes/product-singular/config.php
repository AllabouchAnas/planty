<?php
/**
 * The template for displaying config.php
 *
 * @package WordPress
 * @subpackage lustria
 * @since lustria 1.0
 */
return array(
	'base' => 'gsf_product_singular',
	'name' => esc_html__('Product Singular', 'lustria-framework'),
	'category' => G5P()->shortcode()->get_category_name(),
	'icon' => 'fa fa-windows',
	'params' => array(
		array(
			'type' => 'autocomplete',
			'heading' => __( 'Choose product to show', 'lustria-framework' ),
			'param_name' => 'product_id',
            'settings' => array(
                'multiple' => false
            ),
            'save_always' => true,
		),
        array(
            'type' => 'textfield',
            'heading' => esc_html__('Featured Text', 'lustria-framework'),
            'param_name' => 'featured_title',
            'value' => ''
        ),
		G5P()->shortcode()->vc_map_add_css_animation(),
		G5P()->shortcode()->vc_map_add_animation_duration(),
		G5P()->shortcode()->vc_map_add_animation_delay(),
		G5P()->shortcode()->vc_map_add_extra_class(),
		G5P()->shortcode()->vc_map_add_css_editor(),
		G5P()->shortcode()->vc_map_add_responsive()
	)
);