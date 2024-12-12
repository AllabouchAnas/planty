<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

use \Elementor\Controls_Manager;

if ( ! class_exists( 'G5Shop_Abstracts_Elements_Listing', false ) ) {
	G5P()->loadFile( G5P()->pluginDir( 'inc/abstracts/elementor-listing-shop.class.php' ) );
}

class UBE_Element_Lustria_Product_Category extends G5Shop_Abstracts_Elements_Listing {
	public function get_name()
	{
		return 'lustria-product-category';
	}
	public function get_title()
	{
		return esc_html__('Lustria Products Category', 'lustria-framework');
	}
	public function get_ube_icon() {
		return 'eicon-products';
	}

	public function get_style_depends(){
		return array(G5P()->assetsHandle('product-category'));
	}

	protected function _register_controls()
	{
		$this->start_controls_section('setting_section', [
			'label' => esc_html__('Setting', 'lustria-framework'),
			'tab' => Controls_Manager::TAB_CONTENT,
		]);

		$this ->register_layout_category_controls();
		$this->register_cat_controls();
		$this->register_image_category_controls();
		$this-> register_hover_effect_controls();
		$this->register_size_mode_controls();

		$this->end_controls_section();
	}

	protected function register_cat_controls()
	{
		parent::register_cat_controls();
		$this->update_control('cat',[
			'multiple' => false,
			'condition' => '',
		]);
	}

	public function render() {
		G5P()->get_template_element( 'product-category/template.php', array(
			'element' => $this
		) );
	}

}