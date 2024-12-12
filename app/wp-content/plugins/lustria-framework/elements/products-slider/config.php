<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

use \Elementor\Controls_Manager;

if ( ! class_exists( 'G5Shop_Abstracts_Elements_Listing', false ) ) {
	G5P()->loadFile( G5P()->pluginDir( 'inc/abstracts/elementor-listing-shop.class.php' ) );
}

class UBE_Element_Lustria_Products_Slider extends G5Shop_Abstracts_Elements_Listing {
	public function get_name()
	{
		return 'lustria-products-slider';
	}
	public function get_title()
	{
		return esc_html__('Lustria Products Slider', 'lustria-framework');
	}
	public function get_ube_icon() {
		return 'eicon-products';
	}

	public function get_script_depends() {
		return array(G5P()->assetsHandle('products-slider'));
	}

	protected function _register_controls()
	{
		$this->register_layout_section_controls();
		$this->register_slider_section_controls();
		$this->register_query_section_controls();
		$this->register_style_section_controls();
	}

	protected function register_layout_section_controls()
	{
		parent::register_layout_section_controls();
		$this->remove_control('post_paging');
	}

	public function render() {
		G5P()->get_template_element( 'products-slider/template.php', array(
			'element' => $this
		) );
	}

}