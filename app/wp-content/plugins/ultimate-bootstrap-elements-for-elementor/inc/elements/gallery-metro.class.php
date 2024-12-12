<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Typography;

class UBE_Element_Gallery_Metro extends UBE_Abstracts_Elements {

	public function get_name() {
		return 'ube-gallery-metro';
	}

	public function get_title() {
		return esc_html__( 'Gallery Metro', 'ube' );
	}

	public function get_ube_icon() {
		return 'eicon-gallery-group';
	}

	public function get_ube_keywords() {
		return array( 'metro', 'gallery', 'gallery metro', 'ube', 'ube gallery metro' );
	}

	public function get_script_depends() {
		return array( 'ube-widget-gallery-grid' );
	}

	protected function register_controls() {
		$this->section_content();
		$this->section_wrapper_style();
		$this->section_image_style();
		$this->section_title_style();
		$this->section_view_more();
	}

	public function section_content() {
		$this->start_controls_section(
			'section_image',
			[
				'label' => esc_html__( 'Gallery', 'ube' ),
			]
		);

		$this->add_control(
			'gallery',
			[
				'label'   => esc_html__( 'Add Images', 'ube' ),
				'type'    => \Elementor\Controls_Manager::GALLERY,
				'default' => [],
			]
		);
		$this->add_control(
			'gallery_number_images',
			[
				'label' => esc_html__( 'Number Of Image', 'ube' ),
				'type'  => \Elementor\Controls_Manager::NUMBER,
				'min'   => 1,
				'step'  => 1,
			]
		);

		$this->add_control(
			'gallery_ratio',
			[
				'label'   => esc_html__( 'Ratio', 'ube' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'1by1'   => '1:1',
					'3by2'   => '3:2',
					'4by3'   => '4:3',
					'9by16'  => '9:16',
					'16by9'  => '16:9',
					'21by9'  => '21:9',
					'custom' => esc_html__( 'Custom', 'ube' ),
				],
				'default' => '4by3',
			]
		);
		$this->add_control(
			'width',
			[
				'label'     => __( 'Width', 'ube' ),
				'type'      => \Elementor\Controls_Manager::NUMBER,
				'min'       => 1,
				'max'       => 100,
				'step'      => 1,
				'condition' => [
					'gallery_ratio' => 'custom',
				]
			]
		);
		$this->add_control(
			'height',
			[
				'label'     => __( 'Height', 'ube' ),
				'type'      => \Elementor\Controls_Manager::NUMBER,
				'min'       => 1,
				'max'       => 100,
				'step'      => 1,
				'condition' => [
					'gallery_ratio' => 'custom',
				]
			]
		);

		$this->add_responsive_control(
			'gallery_number_column',
			[
				'label'           => esc_html__( 'Column', 'ube' ),
				'type'            => \Elementor\Controls_Manager::NUMBER,
				'default' => '3',
				'min'             => 1,
				'max'             => 30,
				'step'            => 1,
				'selectors'       => [
					'{{WRAPPER}} .ube-gallery-metro ' => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
				],
			]
		);
		$repeater = new \Elementor\Repeater();
		$repeater->add_responsive_control(
			'number_row',
			[
				'label'           => __( 'Number Row', 'ube' ),
				'type'            => \Elementor\Controls_Manager::SELECT,
				'default' => '1',
				'tablet_default'  => '1',
				'mobile_default'  => '1',
				'options'         => [
					'1' => esc_html__( '1', 'ube' ),
					'2' => esc_html__( '2', 'ube' ),
					'3' => esc_html__( '3', 'ube' ),
					'4' => esc_html__( '4', 'ube' ),
					'5' => esc_html__( '5', 'ube' ),
					'6' => esc_html__( '6', 'ube' ),
					'7' => esc_html__( '7', 'ube' ),
					'8' => esc_html__( '8', 'ube' ),
					'9' => esc_html__( '9', 'ube' ),
					'10' => esc_html__( '10', 'ube' ),
					'11' => esc_html__( '11', 'ube' ),
					'12' => esc_html__( '12', 'ube' ),
				],
			]
		);
		$repeater->add_responsive_control(
			'number_column',
			[
				'label'           => __( 'Number Column', 'ube' ),
				'type'            => \Elementor\Controls_Manager::SELECT,
				'default' => '1',
				'tablet_default'  => '1',
				'mobile_default'  => '1',
				'options'         => [
					'1' => esc_html__( '1', 'ube' ),
					'2' => esc_html__( '2', 'ube' ),
					'3' => esc_html__( '3', 'ube' ),
					'4' => esc_html__( '4', 'ube' ),
					'5' => esc_html__( '5', 'ube' ),
					'6' => esc_html__( '6', 'ube' ),
					'7' => esc_html__( '7', 'ube' ),
					'8' => esc_html__( '8', 'ube' ),
					'9' => esc_html__( '9', 'ube' ),
					'10' => esc_html__( '10', 'ube' ),
					'11' => esc_html__( '11', 'ube' ),
					'12' => esc_html__( '12', 'ube' ),
				],
			]
		);
		$this->add_control(
			'gallery_grid_items',
			[
				'label'     => esc_html__( 'Grid Items', 'ube' ),
				'type'      => \Elementor\Controls_Manager::REPEATER,
				'separator' => 'before',
				'fields'    => $repeater->get_controls(),
			]
		);
		$this->add_control(
			'gallery_loop_layout',
			[
				'label'        => esc_html__( 'Loop layout', 'ube' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'ube' ),
				'label_off'    => esc_html__( 'Hide', 'ube' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);
		$this->add_responsive_control(
			'column_gap',
			[
				'label'      => esc_html__( 'Column Gap', 'ube' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 200,
						'step' => 1,
					],
					'%'  => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .ube-gallery-metro ' => 'grid-row-gap: {{SIZE}}{{UNIT}};grid-column-gap: {{SIZE}}{{UNIT}};',
				],
				'separator'  => 'after'
			]
		);
		$this->add_control(
			'hover_animation',
			[
				'label'   => esc_html__( 'Hover Effect', 'ube' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => '',
				'options' => ube_get_hover_effect()
			]
		);
		$this->add_control(
			'hover_image_animation',
			[
				'label'   => esc_html__( 'Hover Image Effect', 'ube' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => '',
				'options' => ube_get_image_effect(),
			]
		);

		$this->add_control(
			'background_hover_transition',
			[
				'label'     => esc_html__( 'Transition Duration', 'ube' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max'  => 3,
						'step' => 0.1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ube-gallery-metro:not(.ube-gallery-hover-flash) .card .card-img' => 'transition-duration: {{SIZE}}s;',
					'{{WRAPPER}} .ube-gallery-hover-flash .card:hover .card-img'                   => 'animation-duration: {{SIZE}}s;',
					'{{WRAPPER}} .ube-gallery-hover-shine .card .card-img::after'                  => 'animation-duration: {{SIZE}}s;',
					'{{WRAPPER}} .ube-gallery-hover-circle .card .card-img::after'                 => 'animation-duration: {{SIZE}}s;',
				],
				'separator' => 'after'
			]
		);
		$this->add_control(
			'show_caption',
			[
				'label'   => esc_html__( 'Show Caption', 'ube' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'none',
				'options' => [
					'none'   => esc_html__( 'None', 'ube' ),
					'always' => esc_html__( 'Always', 'ube' ),
					'hover'  => esc_html__( 'Hover', 'ube' ),

				],
			]
		);

		$this->add_control(
			'hover_caption_animation',
			[
				'label'       => esc_html__( 'Caption Hover Animation', 'ube' ),
				'type'        => \Elementor\Controls_Manager::SELECT2,
				'options'     => ube_get_animation_name(),
				'default'     => '',
				'label_block' => true,
				'condition'   => [
					'show_caption' => 'hover'
				]
			]
		);


		$this->add_control(
			'view',
			[
				'label'   => esc_html__( 'View', 'ube' ),
				'type'    => Controls_Manager::HIDDEN,
				'default' => 'traditional',
			]
		);

		$this->end_controls_section();

	}

	public function section_wrapper_style() {
		$this->start_controls_section(
			'section_style_gallery',
			[
				'label' => esc_html__( 'Gallery', 'ube' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'gallery_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'ube' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ube-gallery-metro .card-img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .ube-gallery-metro .card'     => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'gallery_box_shadow',
				'exclude'  => [
					'box_shadow_position',
				],
				'selector' => '{{WRAPPER}} .ube-gallery-metro .card',
			]
		);

		$this->add_control(
			'gallery_background_overlay_color',
			[
				'label'     => esc_html__( 'Background Overlay Color', 'ube' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-gallery-caption-hover .card:hover .card-img-overlay' => 'background: {{VALUE}}',
					'{{WRAPPER}} .ube-gallery-caption-always .card-img-overlay'            => 'background: {{VALUE}}',
				],
				'condition' => [
					'show_caption!' => 'none'
				]
			]
		);

		$this->end_controls_section();
	}

	public function section_image_style() {
		//Wrapper style

		$this->start_controls_section(
			'section_style_image',
			[
				'label' => esc_html__( 'Image', 'ube' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( 'image_effects' );

		$this->start_controls_tab( 'normal',
			[
				'label' => esc_html__( 'Normal', 'ube' ),
			]
		);

		$this->add_control(
			'opacity',
			[
				'label'     => esc_html__( 'Opacity', 'ube' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max'  => 1,
						'min'  => 0.10,
						'step' => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ube-gallery-metro .card-img' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name'     => 'css_filters',
				'selector' => '{{WRAPPER}} .ube-gallery-metro .card-img',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'hover',
			[
				'label' => esc_html__( 'Hover', 'ube' ),
			]
		);


		$this->add_control(
			'opacity_hover',
			[
				'label'     => esc_html__( 'Opacity', 'ube' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max'  => 1,
						'min'  => 0.10,
						'step' => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ube-gallery-metro .card:hover .card-img' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name'     => 'css_filters_hover',
				'selector' => '{{WRAPPER}} .ube-gallery-metro .card:hover .card-img',
			]
		);


		$this->end_controls_tab();

		$this->end_controls_tabs();


		$this->end_controls_section();

	}

	public function section_title_style() {
		//Title Style Section

		$this->start_controls_section(
			'section_style_caption',
			[
				'label'     => esc_html__( 'Caption', 'ube' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_caption!' => 'none'
				]
			]
		);

		$this->add_control(
			'text_color',
			[
				'label'     => esc_html__( 'Text Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ube-gallery-metro .card-text' => 'color: {{VALUE}};',
				],
			]
		);


		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'caption_typography',
				'selector' => '{{WRAPPER}} .ube-gallery-metro .card-text',
			]
		);

		$this->add_responsive_control(
			'caption_padding',
			[
				'label'      => esc_html__( 'Padding', 'ube' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ube-gallery-metro .card-img-overlay .ube-gallery-caption' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	public function section_view_more() {
		//Title Style Section

		$this->start_controls_section(
			'section_style_view_more',
			[
				'label'     => esc_html__( 'View More', 'ube' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'gallery_number_images!' => ''
				]
			]
		);

		$this->add_control(
			'view_more_color',
			[
				'label'     => esc_html__( 'Text Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ube-view-more-wrap p' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label'    => esc_html__( 'Number Typography', 'ube' ),
				'name'     => 'number_typography',
				'selector' => '{{WRAPPER}} .ube-view-more-wrap .ube-number-gallery',
			]
		);
		$this->add_responsive_control(
			'number_spacing',
			[
				'label'      => esc_html__( 'Number Spacing', 'ube' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 200,
						'step' => 1,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .ube-view-more-wrap .ube-number-gallery ' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label'    => esc_html__( 'Label Typography', 'ube' ),
				'name'     => 'view_more_typography',
				'selector' => '{{WRAPPER}} .ube-view-more-wrap .ube-view-more-image',
			]
		);


		$this->end_controls_section();
	}


	protected function render() {
		ube_get_template( 'elements/gallery-metro.php', array(
			'element' => $this
		) );

	}
}