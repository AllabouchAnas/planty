<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;

class UBE_Element_Gallery_Masonry extends UBE_Abstracts_Elements {

	public function get_name() {
		return 'ube-gallery-masonry';
	}

	public function get_title() {
		return esc_html__( 'Gallery Masonry', 'ube' );
	}

	public function get_ube_icon() {
		return 'eicon-gallery-masonry';
	}

	public function get_ube_keywords() {
		return array( 'masonry', 'gallery', 'gallery masonry' , 'ube' , 'ube gallery masonry' );
	}

	public function get_script_depends() {
		return array( 'ube-widget-gallery-masonry' );
	}

	protected function register_controls() {
		$this->section_content();
		$this->section_wrapper_style();
		$this->section_image_style();
		$this->section_title_style();
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

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'image_size',
				// Usage: `{name}_size` and `{name}_custom_dimension`, in this case `image_size` and `image_custom_dimension`.
				'default'   => 'large',
				'separator' => 'none',
			]
		);
		$this->add_responsive_control(
			'number_column',
			[
				'label'           => esc_html__( 'Column', 'ube' ),
				'type'            => \Elementor\Controls_Manager::SELECT,
				'default' => '3',
				'tablet_default'  => '2',
				'mobile_default'  => '1',
				'options'         => [
					''   => esc_html__( 'Auto', 'ube' ),
					'1'  => esc_html__( '1', 'ube' ),
					'2'  => esc_html__( '2', 'ube' ),
					'3'  => esc_html__( '3', 'ube' ),
					'4'  => esc_html__( '4', 'ube' ),
					'5'  => esc_html__( '5', 'ube' ),
					'6'  => esc_html__( '6', 'ube' ),
					'12' => esc_html__( '12', 'ube' ),
				],
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
					'{{WRAPPER}} .ube-gallery-item' => 'padding: calc({{SIZE}}{{UNIT}}/2);',
					'{{WRAPPER}} .row'              => 'margin-left: calc(0{{UNIT}} - {{SIZE}}{{UNIT}}/2);margin-right: calc(0{{UNIT}} - {{SIZE}}{{UNIT}}/2);',
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
					'{{WRAPPER}} .ube-gallery-masonry .ube-image img'       => 'transition-duration: {{SIZE}}s',
					'{{WRAPPER}} .ube-image-hover-shine .card-img::before'  => 'animation-duration: {{SIZE}}s;',
					'{{WRAPPER}} .ube-image-hover-circle .card-img::before' => 'animation-duration: {{SIZE}}s;',
					'{{WRAPPER}} .ube-image-hover-flash:hover .card-img'          => 'animation-duration: {{SIZE}}s;',
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
					'{{WRAPPER}} .ube-gallery-masonry .card-img'         => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .ube-gallery-masonry .card-img-overlay' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
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
					'{{WRAPPER}} .ube-image img' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name'     => 'css_filters',
				'selector' => '{{WRAPPER}} .ube-image img',
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
					'{{WRAPPER}} .ube-image:hover img' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name'     => 'css_filters_hover',
				'selector' => '{{WRAPPER}} .ube-image:hover img',
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
					'{{WRAPPER}} .ube-gallery-masonry .card-img-overlay .card-text' => 'color: {{VALUE}};',
				],
			]
		);


		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'caption_typography',
				'selector' => '{{WRAPPER}} .ube-gallery-masonry .card-img-overlay .card-text',
			]
		);
		$this->add_responsive_control(
			'caption_padding',
			[
				'label'      => esc_html__( 'Padding', 'ube' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ube-gallery-masonry .card-img-overlay .card-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}


	protected function render() {

		ube_get_template( 'elements/gallery-masonry.php', array(
			'element' => $this
		) );

	}
}