<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Background;

class UBE_Element_Button extends UBE_Abstracts_Elements {
	public function get_name()
	{
		return 'ube-button';
	}

	public function get_title()
	{
		return esc_html__('Button', 'ube');
	}

	public function get_ube_icon()
	{
		return 'eicon-button';
	}

	public function get_ube_keywords() {
		return array('button','ube' , 'ube button');
	}

	protected function register_controls() {
		$this->register_section_content();
		$this->register_section_wrap_style();
		$this->register_section_icon_style();
	}

	private function register_section_content() {
		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__('Button','ube')
			]
		);

		$this->add_control(
			'text',
			[
				'label' => esc_html__( 'Text', 'ube' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'label_block' => true,
				'default' => esc_html__( 'Click here', 'ube' ),
				'placeholder' => esc_html__( 'Click here', 'ube' ),
			]
		);

		$this->add_control(
			'link',
			[
				'label' => esc_html__( 'Link', 'ube' ),
				'type' => Controls_Manager::URL,
				'dynamic' => [
					'active' => true,
				],
				'placeholder' => esc_html__( 'https://your-link.com', 'ube' ),
				'default' => [
					'url' => '#',
				],
			]
		);


		$this->add_control(
			'type',
			[
				'label' => esc_html__( 'Type', 'ube' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'separator'     => 'before',
				'options' => ube_get_button_styles(),
			]
		);

		$this->add_control(
			'scheme',
			[
				'label'   => esc_html__('Scheme', 'ube'),
				'type'    => Controls_Manager::SELECT,
				'options' => ube_get_color_schemes(false),
				'default' => 'primary',
				'condition' => [
					'type[value]!' => 'link',
				],
			]
		);

		$this->add_control(
			'shape',
			[
				'label' => esc_html__( 'Shape', 'ube' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'rounded',
				'options' => ube_get_button_shape(),
				'condition' => [
					'type[value]!' => 'link',
				],
			]
		);




		$this->add_control(
			'size',
			[
				'label' => esc_html__( 'Size', 'ube' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'md',
				'options' => ube_get_button_sizes(),
				'style_transfer' => true,
			]
		);

		$this->add_control(
			'icon',
			[
				'label' => esc_html__( 'Icon', 'ube' ),
				'type' => Controls_Manager::ICONS,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'icon_align',
			[
				'label' => esc_html__( 'Icon Position', 'ube' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'left',
				'options' => [
					'left' => esc_html__( 'Before', 'ube' ),
					'right' => esc_html__( 'After', 'ube' ),
				],
				'condition' => [
					'icon[value]!' => '',
				],
			]
		);



		$this->add_control(
			'button_css_id',
			[
				'label' => esc_html__( 'Button ID', 'ube' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'separator'     => 'before',
				'default' => '',
				'title' => esc_html__( 'Add your custom id WITHOUT the Pound key. e.g: my-id', 'ube' ),
				'description' =>wp_kses_post( __( 'Please make sure the ID is unique and not used elsewhere on the page this form is displayed. This field allows <code>A-z 0-9</code> & underscore chars without spaces.', 'ube' )),
			]
		);


		$this->add_control('button_event_switcher',
			[
				'label'         => esc_html__('onclick Event', 'ube'),
				'type'          => Controls_Manager::SWITCHER,
				'separator'     => 'before',
			]
		);

		$this->add_control('button_event_function',
			[
				'label'         => esc_html__('Example: myFunction();', 'ube'),
				'type'          => Controls_Manager::TEXTAREA,
				'dynamic'       => [ 'active' => true ],
				'condition'     => [
					'button_event_switcher' => 'yes',
				],
			]
		);

		$this->end_controls_section();
	}

	private function register_section_wrap_style() {
		$this->start_controls_section(
			'section_wrap_style',
			[
				'label' => esc_html__( 'Button', 'ube' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'typography',
				'selector' => '{{WRAPPER}} .ube-btn',
			]
		);

		$this->add_control(
			'button_gradient_background',
			[
				'label' => esc_html__( 'Use Gradient Background', 'ube'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'ube'),
				'label_off' => esc_html__( 'Hide', 'ube'),
				'return_value' => 'yes',
				'default' => '',
				'condition' => [
					'type!' => 'link',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_button_style' );

		$this->start_controls_tab(
			'tab_button_normal',
			[
				'label' => esc_html__( 'Normal', 'ube' ),
			]
		);

		$this->add_control(
			'button_text_color',
			[
				'label' => esc_html__( 'Text Color', 'ube' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .ube-btn' => 'fill: {{VALUE}}; color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_border_color',
			[
				'label' => esc_html__( 'Border Color', 'ube' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .ube-btn' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'type!' => 'link',
				],
			]
		);

		$this->add_control(
			'button_background_color',
			[
				'label' => esc_html__( 'Background Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .ube-btn' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'type!' => ['link','outline'] ,
					'button_gradient_background' => ''
				],
			]
		);


		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'button_background_gradient_color',
				'types' => [ 'gradient', 'classic' ],
				'selector' => '{{WRAPPER}} .ube-btn',
				'condition' => [
					'type!' => ['link','outline'] ,
					'button_gradient_background' => 'yes'
				],
			]
		);


		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_hover',
			[
				'label' => esc_html__( 'Hover', 'ube' ),
			]
		);


		$this->add_control(
			'button_text_color_hover',
			[
				'label' => esc_html__( 'Text Color', 'ube' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .ube-btn:hover' => 'fill: {{VALUE}}; color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_border_color_hover',
			[
				'label' => esc_html__( 'Border Color', 'ube' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .ube-btn:hover' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'type!' => 'link',
				],
			]
		);

		$this->add_control(
			'button_background_color_hover',
			[
				'label' => esc_html__( 'Background Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .ube-btn:hover' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'type!' => ['link'] ,
					'button_gradient_background' => ''
				],
			]
		);


		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'button_background_gradient_color_hover',
				'types' => [ 'gradient', 'classic' ],
				'selector' => '{{WRAPPER}} .ube-btn:hover',
				'condition' => [
					'type!' => ['link'] ,
					'button_gradient_background' => 'yes'
				],
			]
		);

		$this->add_control(
			'hover_animation',
			[
				'label' => esc_html__( 'Hover Animation', 'ube' ),
				'type' => Controls_Manager::HOVER_ANIMATION,
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();


		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'border',
				'selector' => '{{WRAPPER}} .ube-btn',
				'separator' => 'before',
			]
		);


		$this->add_control(
			'border_radius',
			[
				'label' => esc_html__('Border Radius', 'ube'),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ube-btn' => 'border-radius: {{SIZE}}px;',
				],
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label' => esc_html__( 'Alignment', 'ube' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left'    => [
						'title' => esc_html__( 'Left', 'ube' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'ube' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'ube' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'default' => '',
				'prefix_class' => 'elementor%s-align-',
			]
		);

		$this->add_responsive_control(
			'button_width',
			[
				'label'      => esc_html__( 'Width', 'ube'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 500,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ube-btn' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);


		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'button_box_shadow',
				'selector' => '{{WRAPPER}} .ube-btn',
			]
		);

		$this->add_responsive_control(
			'text_padding',
			[
				'label' => esc_html__( 'Padding', 'ube' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .ube-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);



		$this->end_controls_section();
	}

	private function register_section_icon_style() {
		$this->start_controls_section(
			'section_icon_style',
			[
				'label' => esc_html__( 'Icon', 'ube' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'icon[value]!' => '',
				],
			]
		);

		$this->add_control(
			'icon_indent',
			[
				'label' => esc_html__( 'Icon Spacing', 'ube' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ube-btn-icon-right .ube-btn-icon' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .ube-btn-icon-left .ube-btn-icon' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_size',
			[
				'label'      => esc_html__( 'Size', 'ube'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem'],
				'range'      => [
					'px' => [
						'min' => 1,
						'max' => 200,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ube-btn-icon' => 'font-size: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_icon_style' );

		$this->start_controls_tab(
			'tab_icon_normal',
			[
				'label' => esc_html__( 'Normal', 'ube' ),
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label' => esc_html__( 'Color', 'ube' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .ube-btn-icon' => 'fill: {{VALUE}}; color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();


		$this->start_controls_tab(
			'tab_icon_hover',
			[
				'label' => esc_html__( 'Hover', 'ube' ),
			]
		);

		$this->add_control(
			'icon_color_hover',
			[
				'label' => esc_html__( 'Color', 'ube' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .ube-btn-icon:hover' => 'fill: {{VALUE}}; color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();



		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	public function render()
	{
		ube_get_template('elements/button.php', array(
			'element' => $this
		));
	}

	protected function content_template() {
		ube_get_template( 'elements-view/button.php' );
	}

}