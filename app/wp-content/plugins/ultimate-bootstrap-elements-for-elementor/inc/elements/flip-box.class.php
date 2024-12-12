<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Background;
use \Elementor\Group_Control_Image_Size;

class UBE_Element_Flip_Box extends UBE_Abstracts_Elements {
	public function get_name() {
		return 'ube-flip-box';
	}

	public function get_title() {
		return esc_html__( 'Flip Box', 'ube' );
	}

	public function get_ube_icon() {
		return 'eicon-flip-box';
	}

	public function get_ube_keywords() {
		return array( 'flip box' , 'ube', 'ube flip box' );
	}

	public function get_script_depends() {
		return array( 'ube-widget-flip-box' );
	}

	protected function register_controls() {
		$this->register_section_front();
		$this->register_section_back();
		$this->register_section_settings();
		$this->register_section_front_style();
		$this->register_section_back_style();
	}

	private function register_section_front() {

		$this->start_controls_section( 'flip_box_section_front', [
			'label' => esc_html__( 'Front', 'ube' ),
			'tab'   => Controls_Manager::TAB_CONTENT,
		] );

		$this->start_controls_tabs( 'side_a_content_tabs_front' );

		$this->start_controls_tab( 'side_a_content_tab_front', [ 'label' => esc_html__( 'Content', 'ube' ) ] );

		$this->add_control(
			'flip_box_graphic',
			[
				'label'       => esc_html__( 'Graphic Element', 'ube' ),
				'type'        => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options'     => [
					'none'  => [
						'title' => esc_html__( 'None', 'ube' ),
						'icon'  => 'eicon-ban',
					],
					'image' => [
						'title' => esc_html__( 'Image', 'ube' ),
						'icon'  => 'fa fa-picture-o',
					],
					'icon'  => [
						'title' => esc_html__( 'Icon', 'ube' ),
						'icon'  => 'eicon-star',
					],
				],
				'default'     => 'icon',
			]
		);

		$this->add_control(
			'image_front',
			[
				'label'     => esc_html__( 'Choose Image', 'ube' ),
				'type'      => Controls_Manager::MEDIA,
				'default'   => [
					'url' => Elementor\Utils::get_placeholder_image_src(),
				],
				'dynamic'   => [
					'active' => true,
				],
				'condition' => [
					'flip_box_graphic' => 'image',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'image_front_size',
				'default' => 'full',
				'condition' => [
					'flip_box_graphic' => 'image',
				],
			]
		);


		$this->add_control(
			'icon_front',
			[
				'label'            => esc_html__( 'Icon', 'ube' ),
				'type'             => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'default'          => [
					'value'   => 'fas fa-star',
					'library' => 'fa-solid',
				],
				'condition'        => [
					'flip_box_graphic' => 'icon',
				],
			]
		);

		$this->add_control(
			'view_front',
			[
				'label' => esc_html__( 'View', 'ube' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'' => esc_html__( 'Default', 'ube' ),
					'stacked' => esc_html__( 'Stacked', 'ube' ),
					'framed' => esc_html__( 'Framed', 'ube' ),
				],
				'default' => '',
				'condition'        => [
					'flip_box_graphic' => 'icon',
				],
			]
		);

		$this->add_control(
			'shape_front',
			[
				'label' => esc_html__( 'Shape', 'ube' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'circle' => esc_html__( 'Circle', 'ube' ),
					'square' => esc_html__( 'Square', 'ube' ),
				],
				'default' => 'circle',
				'condition' => [
					'view_front!' => '',
					'flip_box_graphic' => 'icon',
				],
			]
		);

		$this->add_control(
			'title_front',
			[
				'label'       => esc_html__( 'Title & Description', 'ube' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'This is the heading', 'ube' ),
				'placeholder' => esc_html__( 'Enter your title', 'ube' ),
				'dynamic'     => [
					'active' => true,
				],
				'label_block' => true,
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'description_front',
			[
				'label'       => esc_html__( 'Description', 'ube' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => esc_html__( 'Lorem ipsum dolor sit amet consectetur adipiscing elit dolor', 'ube' ),
				'placeholder' => esc_html__( 'Enter your description', 'ube' ),
				'separator'   => 'none',
				'dynamic'     => [
					'active' => true,
				],
				'rows'        => 10,
				'show_label'  => false,
			]
		);

		$this->add_control( 'heading_title_size_front', [
			'label'   => esc_html__( 'Size', 'ube' ),
			'type'    => Controls_Manager::SELECT,
			'options' => array(
				'' => esc_html__( 'Default', 'ube' ),
				'sm' => esc_html__( 'Small', 'ube' ),
				'md' => esc_html__( 'Medium', 'ube' ),
				'lg' => esc_html__( 'Large', 'ube' ),
				'xl' => esc_html__( 'Extra Large', 'ube' ),
				'xxl' => esc_html__( 'Extra Extra Large', 'ube' ),
			),
			'default' => '',
		] );

		$this->add_control(
			'title_tag_front',
			[
				'label'   => esc_html__( 'Title HTML Tag', 'ube' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'h1'   => 'H1',
					'h2'   => 'H2',
					'h3'   => 'H3',
					'h4'   => 'H4',
					'h5'   => 'H5',
					'h6'   => 'H6',
					'div'  => 'div',
					'span' => 'span',
					'p'    => 'p',
				],
				'default' => 'h3',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'side_a_background_tab', [ 'label' => esc_html__( 'Background', 'ube' ) ] );

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'background_front',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .ube-flip-box-front',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	private function register_section_back() {

		$this->start_controls_section( 'flip_box_section_back', [
			'label' => esc_html__( 'Back', 'ube' ),
			'tab'   => Controls_Manager::TAB_CONTENT,
		] );

		$this->start_controls_tabs( 'side_a_content_tabs_back' );

		$this->start_controls_tab( 'side_a_content_tab_back', [ 'label' => esc_html__( 'Content', 'ube' ) ] );

		$this->add_control(
			'flip_box_graphic_back',
			[
				'label'       => esc_html__( 'Graphic Element', 'ube' ),
				'type'        => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options'     => [
					'none'  => [
						'title' => esc_html__( 'None', 'ube' ),
						'icon'  => 'eicon-ban',
					],
					'image' => [
						'title' => esc_html__( 'Image', 'ube' ),
						'icon'  => 'fa fa-picture-o',
					],
					'icon'  => [
						'title' => esc_html__( 'Icon', 'ube' ),
						'icon'  => 'eicon-star',
					],
				],
				'default'     => 'icon',
			]
		);

		$this->add_control(
			'image_back',
			[
				'label'     => esc_html__( 'Choose Image', 'ube' ),
				'type'      => Controls_Manager::MEDIA,
				'default'   => [
					'url' => Elementor\Utils::get_placeholder_image_src(),
				],
				'dynamic'   => [
					'active' => true,
				],
				'condition' => [
					'flip_box_graphic_back' => 'image',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'image_back_size',
				'default'   => 'full',
				'condition' => [
					'flip_box_graphic_back' => 'image',
				],
			]
		);

		$this->add_control(
			'icon_back',
			[
				'label'            => esc_html__( 'Icon', 'ube' ),
				'type'             => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'default'          => [
					'value'   => 'fas fa-star',
					'library' => 'fa-solid',
				],
				'condition'        => [
					'flip_box_graphic_back' => 'icon',
				],
			]
		);

		$this->add_control(
			'view_back',
			[
				'label' => esc_html__( 'View', 'ube' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'' => esc_html__( 'Default', 'ube' ),
					'stacked' => esc_html__( 'Stacked', 'ube' ),
					'framed' => esc_html__( 'Framed', 'ube' ),
				],
				'default' => '',
				'condition'        => [
					'flip_box_graphic_back' => 'icon',
				],
			]
		);

		$this->add_control(
			'shape_back',
			[
				'label' => esc_html__( 'Shape', 'ube' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'circle' => esc_html__( 'Circle', 'ube' ),
					'square' => esc_html__( 'Square', 'ube' ),
				],
				'default' => 'circle',
				'condition' => [
					'view_back!' => '',
					'flip_box_graphic_back' => 'icon',
				],
			]
		);

		$this->add_control(
			'title_back',
			[
				'label'       => esc_html__( 'Title & Description', 'ube' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'This is the heading', 'ube' ),
				'placeholder' => esc_html__( 'Enter your title', 'ube' ),
				'dynamic'     => [
					'active' => true,
				],
				'label_block' => true,
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'description_back',
			[
				'label'       => esc_html__( 'Description', 'ube' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => esc_html__( 'Lorem ipsum dolor sit amet consectetur adipiscing elit dolor', 'ube' ),
				'placeholder' => esc_html__( 'Enter your description', 'ube' ),
				'separator'   => 'none',
				'dynamic'     => [
					'active' => true,
				],
				'rows'        => 10,
				'show_label'  => false,
			]
		);

		$this->add_control(
			'button_text',
			[
				'label'     => esc_html__( 'Button Text', 'ube' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Click Here', 'ube' ),
				'dynamic'   => [
					'active' => true,
				],
				'separator' => 'before',
			]
		);

		$this->add_control( 'heading_title_size_back', [
			'label'   => esc_html__( 'Size', 'ube' ),
			'type'    => Controls_Manager::SELECT,
			'options' => array(
				'' => esc_html__( 'Default', 'ube' ),
				'sm' => esc_html__( 'Small', 'ube' ),
				'md' => esc_html__( 'Medium', 'ube' ),
				'lg' => esc_html__( 'Large', 'ube' ),
				'xl' => esc_html__( 'Extra Large', 'ube' ),
				'xxl' => esc_html__( 'Extra Extra Large', 'ube' ),
			),
			'default' => '',
		] );

		$this->add_control(
			'title_tag_back',
			[
				'label'   => esc_html__( 'Title HTML Tag', 'ube' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'h1'   => 'H1',
					'h2'   => 'H2',
					'h3'   => 'H3',
					'h4'   => 'H4',
					'h5'   => 'H5',
					'h6'   => 'H6',
					'div'  => 'div',
					'span' => 'span',
					'p'    => 'p',
				],
				'default' => 'h3',
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
			'link_click',
			[
				'label'     => esc_html__( 'Apply Link On', 'ube' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'box'    => esc_html__( 'Whole Box', 'ube' ),
					'button' => esc_html__( 'Button Only', 'ube' ),
				],
				'default'   => 'button',
				'condition' => [
					'link[url]!' => '',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'side_background_tab_back', [ 'label' => esc_html__( 'Background', 'ube' ) ] );

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'background_back',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .ube-flip-box-back',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	private function register_section_settings() {

		$this->start_controls_section( 'flip_box_section_settings', [
			'label' => esc_html__( 'Settings', 'ube' ),
			'tab'   => Controls_Manager::TAB_CONTENT,
		] );

		$this->add_responsive_control(
			'height',
			[
				'label'      => esc_html__( 'Height', 'ube' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min' => 100,
						'max' => 1000,
					],
					'vh' => [
						'min' => 10,
						'max' => 100,
					],
				],
				'size_units' => [ 'px', 'vh' ],
				'selectors'  => [
					'{{WRAPPER}} .ube-flip-box' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'ube' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'separator'  => 'after',
				'selectors'  => [
					'{{WRAPPER}} .ube-flip-box-layer' => 'border-radius: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'flip_effect',
			[
				'label'   => esc_html__( 'Flip Effect', 'ube' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'flip',
				'options' => [
					'flip'     => esc_html__( 'Flip', 'ube' ),
					'slide'    => esc_html__( 'Slide', 'ube' ),
					'push'     => esc_html__( 'Push', 'ube' ),
					'zoom-in'  => esc_html__( 'Zoom In', 'ube' ),
					'zoom-out' => esc_html__( 'Zoom Out', 'ube' ),
					'fade'     => esc_html__( 'Fade', 'ube' ),
				],
			]
		);

		$this->add_control(
			'flip_direction',
			[
				'label'     => esc_html__( 'Flip Direction', 'ube' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'up',
				'options'   => [
					'left'  => esc_html__( 'Left', 'ube' ),
					'right' => esc_html__( 'Right', 'ube' ),
					'up'    => esc_html__( 'Up', 'ube' ),
					'down'  => esc_html__( 'Down', 'ube' ),
				],
				'condition' => [
					'flip_effect!' => [
						'fade',
						'zoom-in',
						'zoom-out',
					],
				],
			]
		);

		$this->add_control(
			'flip_box_3d',
			[
				'label'        => esc_html__( '3D Depth', 'ube' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'ube' ),
				'label_off'    => esc_html__( 'Hide', 'ube' ),
				'return_value' => 'yes',
				'default'      => '',
				'condition'    => [
					'flip_effect' => 'flip',
				],
			]
		);

		$this->end_controls_section();
	}

	private function register_section_front_style() {

		$this->start_controls_section( 'flip_box_section_front_style', [
			'label' => esc_html__( 'Front', 'ube' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_responsive_control(
			'padding_front',
			[
				'label'      => esc_html__( 'Padding', 'ube' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ube-flip-box-front' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'alignment_front',
			[
				'label'       => esc_html__( 'Alignment', 'ube' ),
				'type'        => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options'     => [
					'justify-content-start'  => [
						'title' => esc_html__( 'Left', 'ube' ),
						'icon'  => 'eicon-text-align-left',
					],
					'justify-content-center' => [
						'title' => esc_html__( 'Center', 'ube' ),
						'icon'  => 'eicon-text-align-center',
					],
					'justify-content-end'    => [
						'title' => esc_html__( 'Right', 'ube' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'default'     => 'justify-content-center',
			]
		);

		$this->add_control(
			'vertical_position_front',
			[
				'label'                => esc_html__( 'Vertical Position', 'ube' ),
				'type'                 => Controls_Manager::CHOOSE,
				'label_block'          => false,
				'options'              => [
					'top'    => [
						'title' => esc_html__( 'Top', 'ube' ),
						'icon'  => 'eicon-v-align-top',
					],
					'middle' => [
						'title' => esc_html__( 'Middle', 'ube' ),
						'icon'  => 'eicon-v-align-middle',
					],
					'bottom' => [
						'title' => esc_html__( 'Bottom', 'ube' ),
						'icon'  => 'eicon-v-align-bottom',
					],
				],
				'selectors_dictionary' => [
					'top'    => 'flex-start',
					'middle' => 'center',
					'bottom' => 'flex-end',
				],
				'default'              => 'middle',
				'selectors'            => [
					'{{WRAPPER}} .ube-flip-box-front .ube-flip-content' => '-ms-flex-item-align:{{VALUE}};-ms-grid-row-align:{{VALUE}};align-self:{{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'border_a',
				'selector' => '{{WRAPPER}} .ube-flip-box-front',
			]
		);


		$this->add_control(
			'heading_image_style',
			[
				'type'      => Controls_Manager::HEADING,
				'label'     => esc_html__( 'Image', 'ube' ),
				'condition' => [
					'flip_box_graphic' => 'image',
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'image_spacing',
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
					'{{WRAPPER}} .ube-flip-box-front .ube-flip-flip-image' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'flip_box_graphic' => 'image',
				],
			]
		);

		$this->add_control(
			'image_width',
			[
				'label'      => esc_html__( 'Size', 'ube' ) . ' (%)',
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ '%' ],
				'default'    => [
					'unit' => '%',
				],
				'range'      => [
					'%' => [
						'min' => 5,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .ube-flip-box-front .ube-flip-flip-image' => 'width: {{SIZE}}{{UNIT}}',
				],
				'condition'  => [
					'flip_box_graphic' => 'image',
				],
			]
		);

		$this->add_control(
			'image_opacity',
			[
				'label'     => esc_html__( 'Opacity', 'ube' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 1,
				],
				'range'     => [
					'px' => [
						'max'  => 1,
						'min'  => 0.10,
						'step' => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ube-flip-box-front .ube-flip-flip-image img' => 'opacity: {{SIZE}};',
				],
				'condition' => [
					'flip_box_graphic' => 'image',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'image_border',
				'selector'  => '{{WRAPPER}} .ube-flip-box-front .ube-flip-flip-image',
				'condition' => [
					'flip_box_graphic' => 'image',
				],
			]
		);

		$this->add_control(
			'image_border_radius',
			[
				'label'     => esc_html__( 'Border Radius', 'ube' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ube-flip-box-front .ube-flip-flip-image' => 'border-radius: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'flip_box_graphic' => 'image',
				],
			]
		);

		$this->add_control(
			'heading_icon_style',
			[
				'type'      => Controls_Manager::HEADING,
				'label'     => esc_html__( 'Icon', 'ube' ),
				'condition' => [
					'flip_box_graphic' => 'icon',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label'     => esc_html__( 'Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ube-flip-box-front .ube-flip-box-icon svg g' => 'stroke: {{VALUE}}',
					'{{WRAPPER}} .ube-flip-box-front .ube-flip-box-icon .elementor-icon'       => 'color: {{VALUE}}',
				],
				'condition' => [
					'flip_box_graphic' => 'icon',
				],
			]
		);

		$this->add_control(
			'icon_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ube-flip-box-front .ube-flip-box-icon .elementor-icon' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'view_front' => 'stacked',
					'flip_box_graphic' => 'icon',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'icon_border',
				'selector'  => '{{WRAPPER}} .ube-flip-box-front .ube-flip-box-icon .elementor-icon',
				'condition' => [
					'view_front!' => '',
					'flip_box_graphic' => 'icon',
				],
			]
		);

		$this->add_responsive_control(
			'icon_spacing',
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
					'{{WRAPPER}} .ube-flip-box-front .ube-flip-box-icon .elementor-icon' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'flip_box_graphic' => 'icon',
				],
			]
		);

		$this->add_responsive_control(
			'icon_size',
			[
				'label'     => esc_html__( 'Icon Size', 'ube' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 6,
						'max' => 300,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ube-flip-box-front .ube-flip-box-icon .elementor-icon'=> 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .ube-flip-box-front .ube-flip-box-icon svg' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'flip_box_graphic' => 'icon',
				],
			]
		);

		$this->add_control(
			'icon_rotate',
			[
				'label'     => esc_html__( 'Icon Rotate', 'ube' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 0,
					'unit' => 'deg',
				],
				'selectors' => [
					'{{WRAPPER}} .ube-flip-box-front .ube-flip-box-icon i'   => 'transform: rotate({{SIZE}}{{UNIT}});',
					'{{WRAPPER}} .ube-flip-box-front .ube-flip-box-icon svg' => 'transform: rotate({{SIZE}}{{UNIT}});',
				],
				'condition' => [
					'flip_box_graphic' => 'icon',
				],
			]
		);

		$this->add_control(
			'icon_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'ube' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ube-flip-box-front .ube-flip-box-icon .elementor-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'  => [
					'view_front!' => '',
					'flip_box_graphic' => 'icon',
				],
			]
		);

		$this->add_responsive_control(
			'icon_padding',
			[
				'label'      => esc_html__( 'Icon Padding', 'ube' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ube-flip-box-front .ube-flip-box-icon .elementor-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'  => [
					'flip_box_graphic' => 'icon',
				],
			]
		);


		$this->add_control(
			'heading_title_style_front',
			[
				'type'      => Controls_Manager::HEADING,
				'label'     => esc_html__( 'Title', 'ube' ),
				'separator' => 'before',
				'condition' => [
					'title_front!' => '',
				],
			]
		);


		$this->add_control(
			'title_color_front',
			[
				'label'     => esc_html__( 'Text Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-flip-box-front .ube-flip-box-title' => 'color: {{VALUE}}',

				],
				'condition' => [
					'title_front!' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'title_typography_front',
				'selector'  => '{{WRAPPER}} .ube-flip-box-front .ube-flip-box-title',
				'condition' => [
					'title_front!' => '',
				],
			]
		);

		$this->add_control('title_class_front',[
			'label' => esc_html__('Custom Class','ube'),
			'type' => Controls_Manager::TEXT,
			'default' => '',
			'condition' => [
				'title_front!' => '',
			],
		]);


		$this->add_control(
			'heading_description_style_front',
			[
				'type'      => Controls_Manager::HEADING,
				'label'     => esc_html__( 'Description', 'ube' ),
				'separator' => 'before',
				'condition' => [
					'description_front!' => '',
				],
			]
		);

		$this->add_responsive_control(
			'title_description_front',
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
					'{{WRAPPER}} .ube-flip-box-front .ube-flip-box-description' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'description_front!' => '',
					'title_front!'       => '',
				],
			]
		);

		$this->add_control(
			'description_color_front',
			[
				'label'     => esc_html__( 'Text Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-flip-box-front .ube-flip-box-description' => 'color: {{VALUE}}',

				],
				'condition' => [
					'description_front!' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'description_typography_front',
				'selector'  => '{{WRAPPER}} .ube-flip-box-front .ube-flip-box-description',
				'condition' => [
					'description_front!' => '',
				],
			]
		);

		$this->add_control('desc_class_front',[
			'label' => esc_html__('Custom Class','ube'),
			'type' => Controls_Manager::TEXT,
			'default' => '',
			'condition' => [
				'description_front!' => '',
			],
		]);

		$this->end_controls_section();
	}

	private function register_section_back_style() {

		$this->start_controls_section( 'flip_box_section_back_style', [
			'label' => esc_html__( 'Back', 'ube' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_responsive_control(
			'padding_back',
			[
				'label'      => esc_html__( 'Padding', 'ube' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ube-flip-box-back' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'alignment_back',
			[
				'label'       => esc_html__( 'Alignment', 'ube' ),
				'type'        => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options'     => [
					'justify-content-start'  => [
						'title' => esc_html__( 'Left', 'ube' ),
						'icon'  => 'eicon-text-align-left',
					],
					'justify-content-center' => [
						'title' => esc_html__( 'Center', 'ube' ),
						'icon'  => 'eicon-text-align-center',
					],
					'justify-content-end'    => [
						'title' => esc_html__( 'Right', 'ube' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'default'     => 'justify-content-center',
			]
		);

		$this->add_control(
			'vertical_position_back',
			[
				'label'                => esc_html__( 'Vertical Position', 'ube' ),
				'type'                 => Controls_Manager::CHOOSE,
				'label_block'          => false,
				'options'              => [
					'top'    => [
						'title' => esc_html__( 'Top', 'ube' ),
						'icon'  => 'eicon-v-align-top',
					],
					'middle' => [
						'title' => esc_html__( 'Middle', 'ube' ),
						'icon'  => 'eicon-v-align-middle',
					],
					'bottom' => [
						'title' => esc_html__( 'Bottom', 'ube' ),
						'icon'  => 'eicon-v-align-bottom',
					],
				],
				'selectors_dictionary' => [
					'top'    => 'flex-start',
					'middle' => 'center',
					'bottom' => 'flex-end',
				],
				'default'              => 'middle',
				'selectors'            => [
					'{{WRAPPER}} .ube-flip-box-back .ube-flip-content' => '-ms-flex-item-align:{{VALUE}};-ms-grid-row-align:{{VALUE}};align-self:{{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'border_b',
				'selector' => '{{WRAPPER}} .ube-flip-box-back',
			]
		);

		$this->add_control(
			'heading_image_style_back',
			[
				'type'      => Controls_Manager::HEADING,
				'label'     => esc_html__( 'Image', 'ube' ),
				'condition' => [
					'flip_box_graphic_back' => 'image',
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'image_spacing_back',
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
					'{{WRAPPER}} .ube-flip-box-back .ube-flip-flip-image' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'flip_box_graphic_back' => 'image',
				],
			]
		);

		$this->add_control(
			'image_width_back',
			[
				'label'      => esc_html__( 'Size', 'ube' ) . ' (%)',
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ '%' ],
				'default'    => [
					'unit' => '%',
				],
				'range'      => [
					'%' => [
						'min' => 5,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .ube-flip-box-back .ube-flip-flip-image' => 'width: {{SIZE}}{{UNIT}}',
				],
				'condition'  => [
					'flip_box_graphic_back' => 'image',
				],
			]
		);

		$this->add_control(
			'image_opacity_back',
			[
				'label'     => esc_html__( 'Opacity', 'ube' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 1,
				],
				'range'     => [
					'px' => [
						'max'  => 1,
						'min'  => 0.10,
						'step' => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ube-flip-box-back .ube-flip-flip-image img' => 'opacity: {{SIZE}};',
				],
				'condition' => [
					'flip_box_graphic_back' => 'image',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'image_border_back',
				'selector'  => '{{WRAPPER}} .ube-flip-box-back .ube-flip-flip-image',
				'condition' => [
					'flip_box_graphic_back' => 'image',
				],
			]
		);

		$this->add_control(
			'image_border_radius_back',
			[
				'label'     => esc_html__( 'Border Radius', 'ube' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ube-flip-box-back .ube-flip-flip-image' => 'border-radius: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'flip_box_graphic_back' => 'image',
				],
			]
		);

		$this->add_control(
			'heading_icon_style_back',
			[
				'type'      => Controls_Manager::HEADING,
				'label'     => esc_html__( 'Icon', 'ube' ),
				'condition' => [
					'flip_box_graphic_back' => 'icon',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'icon_color_back',
			[
				'label'     => esc_html__( 'Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ube-flip-box-back .ube-flip-box-icon svg g' => 'stroke: {{VALUE}}',
					'{{WRAPPER}} .ube-flip-box-back .ube-flip-box-icon .elementor-icon'       => 'color: {{VALUE}}',
				],
				'condition' => [
					'flip_box_graphic_back' => 'icon',
				],
			]
		);

		$this->add_control(
			'icon_bg_color_back',
			[
				'label'     => esc_html__( 'Background Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ube-flip-box-back .ube-flip-box-icon .elementor-icon' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'view_back' => 'stacked',
					'flip_box_graphic_back' => 'icon',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'icon_border_back',
				'selector'  => '{{WRAPPER}} .ube-flip-box-back .ube-flip-box-icon .elementor-icon',
				'condition' => [
					'view_back!' => '',
					'flip_box_graphic_back' => 'icon',
				],
			]
		);

		$this->add_responsive_control(
			'icon_spacing_back',
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
					'{{WRAPPER}} .ube-flip-box-back .ube-flip-box-icon .elementor-icon' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'flip_box_graphic_back' => 'icon',
				],
			]
		);

		$this->add_responsive_control(
			'icon_size_back',
			[
				'label'     => esc_html__( 'Icon Size', 'ube' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 6,
						'max' => 300,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ube-flip-box-back .ube-flip-box-icon .elementor-icon'     => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .ube-flip-box-back .ube-flip-box-icon svg' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'flip_box_graphic_back' => 'icon',
				],
			]
		);

		$this->add_control(
			'icon_rotate_back',
			[
				'label'     => esc_html__( 'Icon Rotate', 'ube' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 0,
					'unit' => 'deg',
				],
				'selectors' => [
					'{{WRAPPER}} .ube-flip-box-back .ube-flip-box-icon i'   => 'transform: rotate({{SIZE}}{{UNIT}});',
					'{{WRAPPER}} .ube-flip-box-back .ube-flip-box-icon svg' => 'transform: rotate({{SIZE}}{{UNIT}});',
				],
				'condition' => [
					'flip_box_graphic_back' => 'icon',
				],
			]
		);

		$this->add_control(
			'icon_border_radius_back',
			[
				'label'      => esc_html__( 'Border Radius', 'ube' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ube-flip-box-back .ube-flip-box-icon .elementor-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'  => [
					'view_back!' => '',
					'flip_box_graphic_back' => 'icon',
				],
			]
		);

		$this->add_responsive_control(
			'icon_padding_back',
			[
				'label'      => esc_html__( 'Icon Padding', 'ube' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ube-flip-box-back .ube-flip-box-icon .elementor-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'  => [
					'flip_box_graphic_back' => 'icon',
				],
			]
		);

		$this->add_control(
			'heading_title_style_back',
			[
				'type'      => Controls_Manager::HEADING,
				'label'     => esc_html__( 'Title', 'ube' ),
				'separator' => 'before',
				'condition' => [
					'title_back!' => '',
				],
			]
		);


		$this->add_control(
			'title_color_back',
			[
				'label'     => esc_html__( 'Text Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-flip-box-back .ube-flip-box-title' => 'color: {{VALUE}}',

				],
				'condition' => [
					'title_back!' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'title_typography_back',
				'selector'  => '{{WRAPPER}} .ube-flip-box-back .ube-flip-box-title',
				'condition' => [
					'title_back!' => '',
				],
			]
		);

		$this->add_control('title_class_back',[
			'label' => esc_html__('Custom Class','ube'),
			'type' => Controls_Manager::TEXT,
			'default' => '',
			'condition' => [
				'title_back!' => '',
			],
		]);

		$this->add_control(
			'heading_description_style_back',
			[
				'type'      => Controls_Manager::HEADING,
				'label'     => esc_html__( 'Description', 'ube' ),
				'separator' => 'before',
				'condition' => [
					'description_back!' => '',
				],
			]
		);

		$this->add_responsive_control(
			'title_description_back',
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
					'{{WRAPPER}} .ube-flip-box-back .ube-flip-box-description' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'description_back!' => '',
					'title_back!'       => '',
				],
			]
		);

		$this->add_control(
			'description_color_back',
			[
				'label'     => esc_html__( 'Text Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-flip-box-back  .ube-flip-box-description' => 'color: {{VALUE}}',

				],
				'condition' => [
					'description_back!' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'description_typography_back',
				'selector'  => '{{WRAPPER}} .ube-flip-box-back  .ube-flip-box-description',
				'condition' => [
					'description_back!' => '',
				],
			]
		);

		$this->add_control('desc_class_back',[
			'label' => esc_html__('Custom Class','ube'),
			'type' => Controls_Manager::TEXT,
			'default' => '',
			'condition' => [
				'description_back!' => '',
			],
		]);

		$this->add_control(
			'heading_button',
			[
				'type'      => Controls_Manager::HEADING,
				'label'     => esc_html__( 'Button', 'ube' ),
				'separator' => 'before',
				'condition' => [
					'button_text!' => '',
				],
			]
		);

		$this->add_responsive_control(
			'button_spacing_back',
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
					'{{WRAPPER}} .ube-flip-box-back .btn' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'button_text!' => '',
				],
			]
		);

		$this->add_control(
			'button_size',
			[
				'label'     => esc_html__( 'Size', 'ube' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'md',
				'options'   => [
					'xs' => esc_html__( 'Extra Small', 'ube' ),
					'sm' => esc_html__( 'Small', 'ube' ),
					'md' => esc_html__( 'Medium', 'ube' ),
					'lg' => esc_html__( 'Large', 'ube' ),
					'xl' => esc_html__( 'Extra Large', 'ube' ),
				],
				'condition' => [
					'button_text!' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'button_typography',
				'selector'  => '{{WRAPPER}} .btn',
				'condition' => [
					'button_text!' => '',
				],
			]
		);

		$this->add_control(
			'button_border_radius',
			[
				'label'     => esc_html__( 'Border Radius', 'ube' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .btn' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'button_text!' => '',
				],
			]
		);

		$this->start_controls_tabs( 'button_tabs' );

		$this->start_controls_tab( 'normal',
			[
				'label'     => esc_html__( 'Normal', 'ube' ),
				'condition' => [
					'button_text!' => '',
				],
			]
		);

		$this->add_control(
			'button_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .btn' => 'color: {{VALUE}};',
				],
				'condition' => [
					'button_text!' => '',
				],
			]
		);

		$this->add_control(
			'button_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .btn' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'button_text!' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'button_border',
				'selector'  => '{{WRAPPER}} .btn',
				'condition' => [
					'button_text!' => '',
				],
			]
		);


		$this->end_controls_tab();

		$this->start_controls_tab(
			'hover',
			[
				'label'     => esc_html__( 'Hover', 'ube' ),
				'condition' => [
					'button_text!' => '',
				],
			]
		);

		$this->add_control(
			'button_hover_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .btn:hover' => 'color: {{VALUE}};',
				],
				'condition' => [
					'button_text!' => '',
				],
			]
		);

		$this->add_control(
			'button_hover_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .btn:hover' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'button_text!' => '',
				],
			]
		);

		$this->add_control(
			'button_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .btn:hover' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'button_text!' => '',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}


	public function render() {
		ube_get_template( 'elements/flip-box.php', array(
			'element' => $this
		) );
	}

	protected function content_template() {
		ube_get_template( 'elements-view/flip-box.php' );
	}
}