<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
	exit('Direct script access denied.');
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;

if ( ! class_exists( 'G5P_Elements_Listing_Blog_Abstract', false ) ) {
	G5P()->loadFile( G5P()->pluginDir( 'inc/abstracts/elementor-listing-blog.class.php' ) );
}

class UBE_Element_Lustria_Posts extends G5P_Elements_Listing_Blog_Abstract
{
	public function get_name()
	{
		return 'lustria-posts';
	}

	public function get_ube_icon()
	{
		return 'eicon-posts-grid';
	}

	public function get_title()
	{
		return esc_html__('Lustria Posts', 'lustria-framework');
	}

	public function get_ube_keywords() {
		return array('posts', 'cpt', 'item', 'loop', 'query', 'cards', 'custom post type','ube','g5' );
	}

	public function get_script_depends() {
		return array(G5P()->assetsHandle('posts'));
	}

	protected function _register_controls()
	{
		$this->register_layout_section_controls();
		$this->register_image_size_section_controls();
		$this->register_query_section_section_controls();
		$this->register_columns_responsive_section_controls(array(
			'post_layout' => ['grid', 'masonry']
		));
		$this-> register_style_section_controls();
	}

	public function render()
	{
		G5P()->get_template_element('posts/template.php', array(
			'element' => $this
		));
	}
}