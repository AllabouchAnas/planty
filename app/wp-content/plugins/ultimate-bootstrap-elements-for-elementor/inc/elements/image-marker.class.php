<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;

class UBE_Element_Image_Marker extends UBE_Abstracts_Elements {

	public function get_name() {
		return 'ube-image-marker';
	}

	public function get_title() {
		return esc_html__( 'Image Marker', 'ube' );
	}

	public function get_ube_icon() {
		return 'eicon-image-hotspot';
	}

	public function get_ube_keywords() {
		return array( 'image', 'marker', 'hotspot' , 'ube' , 'image marker', 'ube image marker');
	}

	public function get_script_depends() {
		return array( 'ube-widget-image-marker' );
	}

	protected function register_controls() {
		$this->section_content();
		$this->section_wrapper_style();
		$this->section_marker_style();
		$this->section_content_style();
	}

	public function section_content() {
		$this->start_controls_section(
			'image_marker_image_section',
			[
				'label' => esc_html__( 'Image', 'ube' ),
			]
		);

		$this->add_control(
			'image',
			[
				'label'   => esc_html__( 'Choose Image', 'ube' ),
				'type'    => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Image_Size::get_type(),
			[
				'name'    => 'image_size',
				// // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
				'exclude' => [ 'custom' ],
				'include' => [],
				'default' => 'large',
			]
		);

		$this->end_controls_section(); // Marker Image Content section

		// Marker Content section
		$this->start_controls_section(
			'image_marker_content_section',
			[
				'label' => esc_html__( 'Marker', 'ube' ),
			]
		);

		$repeater = new Repeater();
		$repeater->add_control(
			'type_of_marker',
			[
				'label'   => esc_html__( 'Type of Marker', 'ube' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'icon',
				'options' => [
					'text' => esc_html__( 'Text', 'ube' ),
					'icon' => esc_html__( 'Icon', 'ube' ),
				],
			]
		);
		$repeater->add_control(
			'marker_text',
			[
				'label'     => esc_html__( 'Marker Text', 'ube' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Marker Text', 'ube' ),
				'condition' => [
					'type_of_marker' => 'text'
				]
			]
		);

		$repeater->add_control(
			'marker_icon',
			[
				'label'     => esc_html__( 'Icon', 'ube' ),
				'type'      => \Elementor\Controls_Manager::ICONS,
				'default'   => [
					'value'   => 'fas fa-info-circle',
					'library' => 'fa-solid',
				],
				'condition' => [
					'type_of_marker' => 'icon'
				]
			]
		);
		$repeater->add_control(
			'marker_link',
			[
				'label'         => esc_html__( 'Marker Link', 'ube' ),
				'type'          => \Elementor\Controls_Manager::URL,
				'placeholder'   => esc_html__( 'https://your-link.com', 'ube' ),
				'show_external' => true,
				'default'       => [
					'url'         => '',
					'is_external' => true,
					'nofollow'    => true,
				],
			]
		);


		$repeater->add_control(
			'marker_title',
			[
				'label'   => esc_html__( 'Marker Title', 'ube' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Marker #1', 'ube' ),
			]
		);

		$repeater->add_control(
			'marker_content',
			[
				'label'   => esc_html__( 'Marker Content', 'ube' ),
				'type'    => Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Lorem ipsum pisaci volupt atem accusa saes ntisdumtiu loperm asaerks.', 'ube' ),
			]
		);

		$repeater->add_control(
			'marker_x_position',
			[
				'label'     => esc_html__( 'X Position', 'ube' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 66,
					'unit' => '%',
				],
				'range'     => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ube-marker-wrapper .ube-image-pointer{{CURRENT_ITEM}}' => 'left: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$repeater->add_control(
			'marker_y_position',
			[
				'label'     => esc_html__( 'Y Position', 'ube' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 15,
					'unit' => '%',
				],
				'range'     => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ube-marker-wrapper .ube-image-pointer{{CURRENT_ITEM}}' => 'top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'image_marker_list',
			[
				'type'        => Controls_Manager::REPEATER,
				'fields'      =>  $repeater->get_controls(),
				'default'     => [
					[
						'marker_title'      => esc_html__( 'Marker #1', 'ube' ),
						'marker_content'    => esc_html__( 'Lorem ipsum pisaci volupt atem accusa saes ntisdumtiu loperm asaerks.', 'ube' ),
						'marker_x_position' => [
							'size' => 66,
							'unit' => '%',
						],
						'marker_y_position' => [
							'size' => 15,
							'unit' => '%',
						],
					]
				],
				'title_field' => '{{{ marker_title }}}',
			]
		);

		$this->end_controls_section();

	}

	public function section_wrapper_style() {
		$this->start_controls_section(
			'image_wrapper_style_section',
			[
				'label' => esc_html__( 'Wrapper', 'ube' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'wrapper_align',
			[
				'label'     => esc_html__( 'Alignment', 'ube' ),
				'type'      => \Elementor\Controls_Manager::CHOOSE,
				'options'   => [
					'left'   => [
						'title' => esc_html__( 'Left', 'ube' ),
						'icon'  => ' eicon-h-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'ube' ),
						'icon'  => 'eicon-h-align-center',
					],
					'right'  => [
						'title' => esc_html__( 'Right', 'ube' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'default'   => 'left',
				'toggle'    => true,
				'selectors' => [
					'{{WRAPPER}} .elementor-widget-container' => 'text-align: {{VALUE}};',

				],
			]
		);
		$this->end_controls_section();
	}

	public function section_marker_style() {
		$this->start_controls_section(
			'image_marker_style_section',
			[
				'label' => esc_html__( 'Marker', 'ube' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'marker_typography',

				'selector' => '{{WRAPPER}} .ube-marker-wrapper .ube-pointer-icon',
			]
		);

		$this->add_responsive_control(
			'marker_icon_width',
			[
				'label'      => esc_html__( 'Width', 'ube' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem' ],
				'selectors'  => [
					'{{WRAPPER}} .ube-marker-wrapper .ube-image-pointer' => 'width: {{SIZE}}{{UNIT}};',

				],
			]
		);
		$this->add_responsive_control(
			'marker_icon_height',
			[
				'label'      => esc_html__( 'Height', 'ube' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem' ],
				'selectors'  => [
					'{{WRAPPER}} .ube-marker-wrapper .ube-image-pointer' => 'height: {{SIZE}}{{UNIT}};',

				],
			]
		);

		$this->add_control(
			'image_marker_color',
			[
				'label'     => esc_html__( 'Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-marker-wrapper .ube-pointer-icon' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'image_marker_background',
				'label'    => esc_html__( 'Background', 'ube' ),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .ube-marker-wrapper .ube-image-pointer',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'marker_box_shadow',
				'label'    => esc_html__( 'Box Shadow', 'ube' ),
				'selector' => '{{WRAPPER}} .ube-marker-wrapper .ube-image-pointer',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'image_marker_border',
				'label'    => esc_html__( 'Border', 'ube' ),
				'selector' => '{{WRAPPER}} .ube-marker-wrapper .ube-image-pointer',
			]
		);

		$this->add_responsive_control(
			'image_marker_border_radius',
			[
				'label'     => esc_html__( 'Border Radius', 'ube' ),
				'type'      => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .ube-marker-wrapper .ube-image-pointer' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
				],
			]
		);

		$this->add_responsive_control(
			'image_marker_padding',
			[
				'label'      => esc_html__( 'Padding', 'ube' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ube-marker-wrapper .ube-image-pointer' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'image_marker_animation',
			[
				'label'        => esc_html__( 'Animation Icon', 'ube' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'ube' ),
				'label_off'    => esc_html__( 'Hide', 'ube' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);

		$this->end_controls_section(); // End Marker style tab

	}

	public function section_content_style() {
		//Title Style Section
		$this->start_controls_section(
			'image_marker_content_style_section',
			[
				'label' => esc_html__( 'Content', 'ube' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'image_marker_arrow',
			[
				'label'        => esc_html__( 'Show Arrow', 'ube' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'ube' ),
				'label_off'    => esc_html__( 'Hide', 'ube' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);
		$this->add_control(
			'marker_arrow_color',
			[
				'label'     => esc_html__( 'Arrow Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-marker-wrapper .bs-tooltip-top .arrow::before'    => 'border-top-color: {{VALUE}}!important;',
					'{{WRAPPER}} .ube-marker-wrapper .bs-tooltip-bottom .arrow::before' => 'border-bottom-color: {{VALUE}}!important;',
				],
				'condition' => [
					'image_marker_arrow' => 'yes'
				]
			]
		);
		$this->add_control(
			'content_align',
			[
				'label'     => esc_html__( 'Alignment', 'ube' ),
				'type'      => \Elementor\Controls_Manager::CHOOSE,
				'options'   => [
					'left'   => [
						'title' => esc_html__( 'Left', 'ube' ),
						'icon'  => ' eicon-h-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'ube' ),
						'icon'  => 'eicon-h-align-center',
					],
					'right'  => [
						'title' => esc_html__( 'Right', 'ube' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'toggle'    => true,
				'selectors' => [
					'{{WRAPPER}} .ube-marker-wrapper .tooltip-inner' => 'text-align: {{VALUE}};',

				],
			]
		);
		$this->add_responsive_control(
			'marker_content_width',
			[
				'label'      => esc_html__( 'Width', 'ube' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 1000,
						'step' => 1,
					],
					'%'  => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .ube-marker-wrapper .tooltip' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'marker_content_color',
			[
				'label'     => esc_html__( 'Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-marker-wrapper .tooltip-inner' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'image_marker_content_area_background',
				'label'    => esc_html__( 'Background', 'ube' ),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .ube-marker-wrapper .tooltip-inner',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'image_marker_content_area_border',
				'label'    => esc_html__( 'Border', 'ube' ),
				'selector' => '{{WRAPPER}} .ube-marker-wrapper .tooltip-inner',
			]
		);

		$this->add_responsive_control(
			'image_marker_content_area_border_radius',
			[
				'label'     => esc_html__( 'Border Radius', 'ube' ),
				'type'      => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .ube-marker-wrapper .tooltip-inner' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
				],
			]
		);

		$this->add_responsive_control(
			'image_marker_content_area_padding',
			[
				'label'      => esc_html__( 'Padding', 'ube' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ube-marker-wrapper .tooltip .tooltip-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'image_marker_content_style_tabs' );

		// Style Title Tab start
		$this->start_controls_tab(
			'style_title_tab',
			[
				'label' => esc_html__( 'Title', 'ube' ),
			]
		);
		$this->add_control(
			'image_marker_title_color',
			[
				'label'     => esc_html__( 'Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-marker-wrapper .tooltip h4' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'image_marker_title_typography',

				'selector' => '{{WRAPPER}} .ube-marker-wrapper .tooltip h4',
			]
		);


		$this->add_responsive_control(
			'image_marker_title_margin_bottom',
			[
				'label'      => esc_html__( 'Spacing', 'ube' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ube-marker-wrapper .tooltip h4' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab(); // Style Title Tab end

		// Style Description Tab start
		$this->start_controls_tab(
			'style_description_tab',
			[
				'label' => esc_html__( 'Description', 'ube' ),
			]
		);

		$this->add_control(
			'image_marker_description_color',
			[
				'label'     => esc_html__( 'Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-marker-wrapper .tooltip p' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'image_marker_description_typography',

				'selector' => '{{WRAPPER}} .ube-marker-wrapper .tooltip p',
			]
		);

		$this->end_controls_tab(); // Style Description Tab end

		$this->end_controls_tabs();

		$this->end_controls_section(); // End Content style tab
	}


	protected function render() {

		ube_get_template( 'elements/image-marker.php', array(
			'element' => $this
		) );

	}


	protected function content_template() {
		ube_get_template( 'elements-view/image-marker.php' );
	}
}