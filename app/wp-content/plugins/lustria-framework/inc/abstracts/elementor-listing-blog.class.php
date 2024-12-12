<?php
// Do not allow directly accessing this file.
use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Typography;

if (!defined('ABSPATH')) {
	exit('Direct script access denied.');
}

if (!class_exists('G5P_Elements_Listing_Abstract', false)) {
	G5P()->loadFile(G5P()->pluginDir('inc/abstracts/elementor-listing.class.php'));
}


abstract class G5P_Elements_Listing_Blog_Abstract extends G5P_Elements_Listing_Abstract
{
	protected function register_layout_section_controls()
	{
		$this->start_controls_section(
			'section_layout',
			[
				'label' => esc_html__('Layout', 'lustria-framework'),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->register_layout_controls();
		$this->register_columns_gutter_controls(array(
			'post_layout!' => ['large-image', 'medium-image']
		));
		$this->register_post_count_control();
		$this->register_post_animation_controls();
		$this->register_post_paging_controls();
		$this->register_cate_filter_controls();

		$this->end_controls_section();
	}

	protected function register_query_section_section_controls()
	{
		$this->start_controls_section(
			'section_query_section',
			[
				'label' => esc_html__('Query', 'lustria-framework'),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->register_cat_controls();
		$this->register_tag_controls();
		$this->register_post_ids_controls();
		$this->register_order_by_controls();
		$this->register_meta_key_controls();
		$this->register_order_controls();
		$this->register_time_filter_controls();

		$this->end_controls_section();
	}

	protected function register_style_section_controls()
	{
		$this->register_style_title_section_controls();
		$this->register_style_meta_section_controls();
		$this->register_style_excerpt_section_controls();
	}

	protected function register_style_title_section_controls()
	{
		$this->start_controls_section(
			'section_design_title',
			[
				'label' => esc_html__('Title', 'lustria-framework'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'selector' => '{{WRAPPER}} .gf-post-title',
			]
		);

		$this->add_control(
			'title_spacing',
			[
				'label' => esc_html__('Spacing', 'lustria-framework'),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .gf-post-title' => 'margin-top: {{SIZE}}{{UNIT}};',
				]
			]
		);

		$this->start_controls_tabs('title_color_tabs');

		$this->start_controls_tab('title_color_normal',
			[
				'label' => esc_html__('Normal', 'lustria-framework'),
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => esc_html__('Color', 'lustria-framework'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .gf-post-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab('title_color_hover',
			[
				'label' => esc_html__('Hover', 'lustria-framework'),
			]
		);


		$this->add_control(
			'title_hover_color',
			[
				'label' => esc_html__('Color', 'lustria-framework'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .gf-post-title:hover' => 'color: {{VALUE}};',
				],
			]
		);


		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function register_style_meta_section_controls()
	{
		$this->start_controls_section(
			'section_design_meta',
			[
				'label' => esc_html__('Meta', 'lustria-framework'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'meta_typography',
				'selector' => '{{WRAPPER}} .gf-post-meta li',
			]
		);

		$this->add_control(
			'meta_spacing',
			[
				'label' => esc_html__('Spacing', 'lustria-framework'),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .gf-post-meta' => 'margin-top: {{SIZE}}{{UNIT}};',
				]
			]
		);


		$this->start_controls_tabs('meta_color_tabs');

		$this->start_controls_tab('meta_color_normal',
			[
				'label' => esc_html__('Normal', 'lustria-framework'),
			]
		);

		$this->add_control(
			'meta_color',
			[
				'label' => esc_html__('Color', 'lustria-framework'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ul.gf-post-meta li' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab('meta_color_hover',
			[
				'label' => esc_html__('Hover', 'lustria-framework'),
			]
		);


		$this->add_control(
			'meta_hover_color',
			[
				'label' => esc_html__('Color', 'lustria-framework'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ul.gf-post-meta li > a:hover' => 'color: {{VALUE}};',
				],
			]
		);


		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function register_style_excerpt_section_controls()
	{
		$this->start_controls_section(
			'section_design_excerpt',
			[
				'label' => esc_html__('Excerpt', 'lustria-framework'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'excerpt_typography',
				'selector' => '{{WRAPPER}} .gf-post-excerpt',
			]
		);

		$this->add_control(
			'excerpt_spacing',
			[
				'label' => esc_html__('Spacing', 'lustria-framework'),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .gf-post-excerpt' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'excerpt_color',
			[
				'label' => esc_html__('Color', 'lustria-framework'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .gf-post-excerpt' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	public function get_config_post_layout()
	{
		$config = apply_filters('g5p_elementor_post_layout', array(
			'large-image' => array(
				'label' => esc_html__('Large Image', 'lustria-framework'),
			),
			'medium-image' => array(
				'label' => esc_html__('Medium Image', 'lustria-framework'),
			),
			'grid' => array(
				'label' => esc_html__('Grid', 'lustria-framework'),
			),
			'masonry' => array(
				'label' => esc_html__('Masonry', 'lustria-framework'),
			),
		));


		$result = array();
		foreach ($config as $k => $v) {
			$result[$k] = $v['label'];
		}
		return $result;

	}
}