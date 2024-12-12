<?php
if (!defined('ABSPATH')) {
	exit;
}

use \Elementor\Controls_Manager;

class UBE_Element_Client_Logo extends UBE_Abstracts_Elements
{
	public function get_name()
	{
		return 'ube-client-logo';
	}

	public function get_title()
	{
		return esc_html__('Client Logo', 'ube');
	}

	public function get_ube_icon()
	{
		return 'eicon-logo';
	}

	public function get_ube_keywords()
	{
		return array('logo', 'client', 'client logo', 'ube client logo', 'ube');
	}

	protected function register_controls()
	{

		$this->register_content_section_controls();

		$this->register_style_wrapper_section_controls();

		$this->register_style_logo_hover_section_controls();
	}

	protected function register_content_section_controls()
	{
		$this->start_controls_section(
			'client_logo_content_section',
			[
				'label' => esc_html__('Content', 'ube'),
			]
		);

		$this->add_control(
			'client_logo_logo',
			[
				'label' => esc_html__('Logo', 'ube'),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_control(
			'client_logo_link',
			[
				'label' => esc_html__('Link', 'ube'),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => esc_html__('https://your-link.com', 'ube'),
				'show_external' => true,
				'default' => [
					'url' => '',
					'is_external' => true,
					'nofollow' => true,
				],
				'separator' => 'after',
			]
		);

		$this->add_control('client_logo_hover', [
			'label' => esc_html__('Hover Type', 'ube'),
			'type' => Controls_Manager::SELECT,
			'options' => [
				'' => esc_html__('None', 'ube'),
				'grayscale' => esc_html__('Gray scale', 'ube'),
				'opacity' => esc_html__('Opacity', 'ube'),
				'faded' => esc_html__('Faded', 'ube'),
			],
			'default' => '',
		]);


		$this->end_controls_section();
	}

	protected function register_style_logo_hover_section_controls()
	{
		$this->start_controls_section(
			'style_logo_hover_section',
			[
				'label' => esc_html__('Logo Hover', 'ube'),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'client_logo_hover!' => '',
				],
			]
		);
		$this->start_controls_tabs('client_logo_tabs');

		$this->start_controls_tab(
			'client_logo_tab_normal',
			[
				'label' => esc_html__('Normal', 'ube'),
			]
		);

		$this->add_control(
			'client_logo_gray_scale',
			[
				'label' => esc_html__('Gray scale', 'ube'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['%'],
				'default' => ['unit' => '%'],
				'range' => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ube-client-logo-hover-grayscale' => '-webkit-filter: grayscale({{SIZE}}{{UNIT}}); filter: grayscale({{SIZE}}{{UNIT}});',
				],
				'condition' => [
					'client_logo_hover' => 'grayscale',
				],
			]
		);

		$this->add_control(
			'client_logo_opacity',
			[
				'label' => esc_html__('Opacity', 'ube'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['%'],
				'default' => ['unit' => '%'],
				'selectors' => [
					'{{WRAPPER}} .ube-client-logo-hover-grayscale,
					{{WRAPPER}} .ube-client-logo-hover-opacity,
					{{WRAPPER}} .ube-client-logo-hover-faded' => 'opacity : {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'client_logo_hover!' => '',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'client_logo_tab_hover',
			[
				'label' => esc_html__('Hover', 'ube'),
			]
		);


		$this->add_control(
			'client_logo_gray_scale_hover',
			[
				'label' => esc_html__('Gray scale', 'ube'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['%'],
				'default' => ['unit' => '%'],
				'range' => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ube-client-logo-hover-grayscale:hover' => '-webkit-filter: grayscale({{SIZE}}{{UNIT}}); filter: grayscale({{SIZE}}{{UNIT}});',
				],
				'condition' => [
					'client_logo_hover' => 'grayscale',
				],
			]
		);

		$this->add_control(
			'client_logo_opacity_hover',
			[
				'label' => esc_html__('Opacity', 'ube'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['%'],
				'default' => ['unit' => '%'],
				'range' => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ube-client-logo-hover-grayscale:hover,
					{{WRAPPER}} .ube-client-logo-hover-opacity:hover,
					{{WRAPPER}} .ube-client-logo-hover-faded:hover' => 'opacity : {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'client_logo_hover!' => '',
				],
			]
		);


		$this->end_controls_tab();

		$this->end_controls_tabs();


		$this->end_controls_section();
	}

	protected function register_style_wrapper_section_controls()
	{
		$this->start_controls_section('client_logo_style_section', [
			'label' => esc_html__('Wrapper', 'ube'),
			'tab' => Controls_Manager::TAB_STYLE
		]);

		$this->add_control(
			'max_width',
			[
				'label' => esc_html__('Width', 'ube'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px', '%'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .ube-client-logo-item img' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control('client_logo_content_alignment', [
			'label' => esc_html__('Content Alignment', 'ube'),
			'type' => Controls_Manager::SELECT,
			'options' => [
				'' => esc_html__('Default', 'ube'),
				'justify-content-start' => esc_html__('Left', 'ube'),
				'justify-content-center' => esc_html__('Center', 'ube'),
				'justify-content-end' => esc_html__('Right', 'ube'),
			],
			'selectors_dictionary' => [
				'justify-content-start' => 'start',
				'justify-content-center' => 'center',
				'justify-content-end' => 'flex-end',
			],
			'selectors' => [
				'{{WRAPPER}} .ube-client-logo-item' => 'justify-content: {{VALUE}};-ms-flex-pack: {{VALUE}};-webkit-box-pack: {{VALUE}};',
			],
			'default' => '',
			'separator' => 'before',
		]);

		$this->add_responsive_control('client_logo_grid_content_padding', [
			'label' => esc_html__('Item Padding', 'ube'),
			'type' => Controls_Manager::DIMENSIONS,
			'size_units' => ['px', '%', 'em'],
			'selectors' => [
				'{{WRAPPER}} .ube-client-logo-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		]);

		$this->end_controls_section();
	}

	public function render()
	{
		$settings = $this->get_settings_for_display();
		$logo = isset($settings['client_logo_logo']) ? $settings['client_logo_logo'] : array();
		$client_logo_hover = isset($settings['client_logo_hover']) ? $settings['client_logo_hover'] : '';
		$client_logo_link = isset($settings['client_logo_link']) ? $settings['client_logo_link'] : array();

		$wrapper_classes = array(
			'ube-client-logo'
		);

		$this->add_render_attribute('wrapper', 'class', $wrapper_classes);
		?>
        <div <?php $this->print_render_attribute_string('wrapper'); ?>>
			<?php
			ube_get_template('elements/client-logo.php', array(
				'logo' => $logo,
				'hover' => $client_logo_hover,
				'link' => $client_logo_link,
				'element' => $this,
				'custom_css' => 'd-flex',
			));
			?>
        </div>
		<?php
	}
}