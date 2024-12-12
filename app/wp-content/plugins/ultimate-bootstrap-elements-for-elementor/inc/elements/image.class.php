<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Utils;

class UBE_Element_Image extends UBE_Abstracts_Elements {

	public function get_name() {
		return 'ube-image';
	}

	public function get_title() {
		return esc_html__( 'Image', 'ube' );
	}

	public function get_ube_icon() {
		return 'eicon-image';
	}

	public function get_ube_keywords() {
		return array( 'image' , 'ube' , 'ube image' );
	}

	protected function register_controls() {
		$this->section_content();
		$this->section_wrapper_image_style();
		$this->section_title_style();
	}

	public function section_content() {
		$this->start_controls_section(
			'section_image',
			[
				'label' => esc_html__( 'Image', 'ube' ),
			]
		);

		$this->add_control(
			'image',
			[
				'label'   => esc_html__( 'Choose Image', 'ube' ),
				'type'    => Controls_Manager::MEDIA,
				'dynamic' => [
					'active' => true,
				],
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'image_size',
				// Usage: `{name}_size` and `{name}_custom_dimension`, in this case `image_size` and `image_custom_dimension`.
				'default'   => 'large',
				'separator' => 'none',
				'condition' => [
					'image[id]!' => ''
				]
			]
		);

		$this->add_responsive_control(
			'space',
			[
				'label'          => esc_html__( 'Max Width', 'ube' ) . ' (%)',
				'type'           => Controls_Manager::SLIDER,
				'default'        => [
					'unit' => '%',
				],
				'tablet_default' => [
					'unit' => '%',
				],
				'mobile_default' => [
					'unit' => '%',
				],
				'size_units'     => [ '%' ],
				'range'          => [
					'%' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors'      => [
					'{{WRAPPER}} .ube-image img, {{WRAPPER}} .ube-image .g5core__lazy-image' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'hover_animation',
			[
				'label'   => esc_html__( 'Hover Image Animation', 'ube' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => '',
				'options' => ube_get_image_effect(),
			]
		);


		$this->add_control(
			'background_hover_overlay_color',
			[
				'label'     => esc_html__( 'Background Overlay Color', 'ube' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-image-hover-shine:hover .card-img::before'                                        => 'background: {{VALUE}}',
					'{{WRAPPER}} .ube-image-hover-circle:hover .card-img::before'                                       => 'background: {{VALUE}}',
					'{{WRAPPER}} .ube-image:not(ube-image-hover-circle):not(.ube-image-hover-circle) .card-img::before' => 'background: {{VALUE}}',
				],
				'condition' => [
					'hover_animation' => [ '', 'shine', 'circle' ]
				]
			]
		);
		$this->add_control(
			'hover_overlay_animation',
			[
				'label'   => esc_html__( 'Hover Overlay Effect', 'ube' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => '',
				'options' => ube_get_hover_effect(),
			]
		);

		$this->add_control(
			'background_hover_transition',
			[
				'label'     => esc_html__( 'Transition Hover Duration', 'ube' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max'  => 3,
						'step' => 0.1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ube-image img'               => 'transition-duration: {{SIZE}}s',
					'{{WRAPPER}} .ube-image .card-img'         => 'transition-duration: {{SIZE}}s',
					'{{WRAPPER}} .ube-image .card-img::before' => 'transition-duration: {{SIZE}}s;animation-duration: {{SIZE}}s;',
					'{{WRAPPER}} .ube-image-hover-flash:hover .card-img' => 'animation-duration: {{SIZE}}s;',
				],
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
		$this->add_control(
			'separator_panel_style',
			[
				'type'  => Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);

		$this->add_control(
			'link',
			[
				'label'       => esc_html__( 'Link', 'ube' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => esc_html__( 'https://your-link.com', 'ube' ),
			]
		);

		$this->add_control(
			'caption',
			[
				'label'       => esc_html__( 'Caption', 'ube' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter your image caption', 'ube' ),
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
				],

			]
		);
		$this->add_control(
			'caption_position',
			[
				'label'     => esc_html__( 'Caption Position', 'ube' ),
				'type'      => Controls_Manager::SELECT,
				'condition' => [
					'caption!' => '',
				],
				'options'   => [
					'in'  => esc_html__( 'In image', 'ube' ),
					'out' => esc_html__( 'Out of image', 'ube' ),
				],
				'default'   => 'out',
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

	public function section_wrapper_image_style() {
		$this->start_controls_section(
			'section_style_image_wrapper',
			[
				'label' => esc_html__( 'Wrapper Image', 'ube' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_responsive_control(
			'image_wrapper_width',
			[
				'label'      => esc_html__( 'Max Width', 'ube' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ '%', 'px', 'vw' ],
				'range'      => [
					'%'  => [
						'min' => 1,
						'max' => 100,
					],
					'px' => [
						'min' => 1,
						'max' => 1000,
					],
					'vw' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .card-img' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'align',
			[
				'label'     => esc_html__( 'Alignment', 'ube' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'flex-start' => [
						'title' => esc_html__( 'Left', 'ube' ),
						'icon'  => 'eicon-h-align-left',
					],
					'center'     => [
						'title' => esc_html__( 'Center', 'ube' ),
						'icon'  => 'eicon-h-align-center',
					],
					'flex-end'   => [
						'title' => esc_html__( 'Right', 'ube' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-widget-container' => 'display: -webkit-box; display: -ms-flexbox ; display: flex; -webkit-box-pack:{{VALUE}};-ms-flex-pack:{{VALUE}};justify-content:{{VALUE}}',
				],

			]
		);

		$this->add_responsive_control(
			'image_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'ube' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ube-image .card-img img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .ube-image .card-img'     => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'image_box_shadow',
				'exclude'  => [
					'box_shadow_position',
				],
				'selector' => '{{WRAPPER}} .ube-image .card-img',
			]
		);
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
					'caption!' => ''
				]
			]
		);

		$this->add_control(
			'caption_align',
			[
				'label'     => esc_html__( 'Horizontal Alignment', 'ube' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'flex-start' => [
						'title' => esc_html__( 'Left', 'ube' ),
						'icon'  => 'eicon-h-align-left',
					],
					'center'     => [
						'title' => esc_html__( 'Center', 'ube' ),
						'icon'  => 'eicon-h-align-center',
					],
					'flex-end'   => [
						'title' => esc_html__( 'Right', 'ube' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ube-image-caption-out .card-body'       => 'justify-content: {{VALUE}};',
					'{{WRAPPER}} .ube-image-caption-in .card-img-overlay' => 'justify-content: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'caption_vertical_align',
			[
				'label'     => esc_html__( 'Vertical Alignment', 'ube' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'flex-start' => [
						'title' => esc_html__( 'Top', 'ube' ),
						'icon'  => 'eicon-v-align-top',
					],
					'center'     => [
						'title' => esc_html__( 'Center', 'ube' ),
						'icon'  => 'eicon-v-align-middle',
					],
					'flex-end'   => [
						'title' => esc_html__( 'Bottom', 'ube' ),
						'icon'  => 'eicon-v-align-bottom',
					],

				],
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ube-image-caption-out .card-body'       => 'align-items: {{VALUE}};',
					'{{WRAPPER}} .ube-image-caption-in .card-img-overlay' => 'align-items: {{VALUE}};',
				],
				'condition' => [
					'caption_position' => 'in'
				]
			]
		);


		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'caption_typography',
				'selector' => '{{WRAPPER}} .card-title',
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name'     => 'caption_text_shadow',
				'selector' => '{{WRAPPER}} .card-title',
			]
		);

		$this->add_responsive_control(
			'caption_space',
			[
				'label'     => esc_html__( 'Spacing', 'ube' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .card-body' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'caption_position' => 'out'
				]
			]
		);
		$this->add_responsive_control(
			'caption_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'ube' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ube-image .card-body' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'  => [
					'caption_position' => 'out'
				]
			]
		);
		$this->add_responsive_control(
			'caption_padding',
			[
				'label'      => esc_html__( 'Padding', 'ube' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ube-image-caption-out .card-body'       => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .ube-image-caption-in .card-img-overlay' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'caption_styles' );

		$this->start_controls_tab( 'caption_normal',
			[
				'label' => esc_html__( 'Normal', 'ube' ),
			]
		);

		$this->add_control(
			'text_color',
			[
				'label'     => esc_html__( 'Text Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .card-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'caption_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .card-body' => 'background-color: {{VALUE}};',
				],
				'condition'  => [
					'caption_position' => 'out'
				]
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab( 'caption_hover',
			[
				'label' => esc_html__( 'Hover', 'ube' ),
			]
		);

		$this->add_control(
			'text_color_hover',
			[
				'label'     => esc_html__( 'Text Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ube-image:hover .card-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'caption_background_color_hover',
			[
				'label'     => esc_html__( 'Background Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-image:hover .card-body' => 'background-color: {{VALUE}};',
				],
				'condition'  => [
					'caption_position' => 'out'
				]
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();
	}


	protected function render() {

		ube_get_template( 'elements/image.php', array(
			'element' => $this
		) );

	}

	protected function content_template() {
		ube_get_template( 'elements-view/image.php' );
	}
}