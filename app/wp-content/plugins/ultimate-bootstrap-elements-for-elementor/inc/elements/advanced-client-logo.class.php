<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

use \Elementor\Controls_Manager;
use Elementor\Utils;

class UBE_Element_Advanced_Client_Logo extends UBE_Abstracts_Elements_Grid {

	/**
	 * Get element name.
	 *
	 * Retrieve the element name.
	 *
	 * @return string The name.
	 * @since 1.4.0
	 * @access public
	 *
	 */
	public function get_name() {
		return 'ube-advanced-client-logo';
	}

	protected function add_repeater_controls( \Elementor\Repeater $repeater ) {
		$repeater->add_control(
			'client_logo_logo',
			[
				'label'   => esc_html__( 'Logo', 'ube' ),
				'type'    => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$repeater->add_control(
			'client_logo_link',
			[
				'label'         => esc_html__( 'Link', 'ube' ),
				'type'          => \Elementor\Controls_Manager::URL,
				'placeholder'   => esc_html__( 'https://your-link.com', 'ube' ),
				'show_external' => true,
				'default'       => [
					'url'         => '',
					'is_external' => true,
					'nofollow'    => true,
				],
				'separator'     => 'after',
			]
		);

		$repeater->add_control(
			'max_width',
			[
				'label'      => esc_html__( 'Width', 'ube' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 500,
						'step' => 1,
					],
					'%'  => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => '',
				],
				'selectors'  => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .ube-client-logo-item img' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

	}

	protected function get_repeater_defaults() {
		$placeholder_image_src = Utils::get_placeholder_image_src();
		return [
			[
				'client_logo_logo' => [ 'url' => $placeholder_image_src ],
			],
			[
				'client_logo_logo' => [ 'url' => $placeholder_image_src ],
			],
		];
	}

	public function get_title() {
		return esc_html__( 'Advanced Client Logo', 'ube' );
	}

	public function get_ube_icon() {
		return 'eicon-logo';
	}

	public function get_ube_keywords() {
		return array( 'logo', 'client', 'client logo', 'advanced client logo' , 'ube' , 'advanced' , 'ube advanced client logo' );
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$wrapper_class  = 'ube-client-logo';
		$slider_enable = isset($settings['slider_enable']) ? $settings['slider_enable'] : '';
		if ($slider_enable === 'on') {
			$this->print_slider( $settings,$wrapper_class );
		}  else {
			$this->print_grid( $settings, $wrapper_class );
		}
	}

	protected function print_grid_item() {

		$settings = $this->get_settings_for_display();
		$client_logo_hover = isset( $settings['client_logo_hover'] ) ? $settings['client_logo_hover'] : '';

		$item          = $this->get_current_item();
		$item_key      =    $this->get_current_item_key();
		$logo              = isset( $item['client_logo_logo'] ) ? $item['client_logo_logo'] : array();
		$client_logo_link  = isset( $item['client_logo_link'] ) ? $item['client_logo_link'] : array();
		ube_get_template( 'elements/client-logo.php', array(
			'logo'       => $logo,
			'hover'      => $client_logo_hover,
			'link'       => $client_logo_link,
			'element'    => $this,
			'item_key' =>  $item_key
		) );

	}

	protected function register_controls() {
		$this->register_content_section_controls();
		parent::register_items_section_controls();
		$this->register_style_section_controls();
		$this->register_grid_section_controls(['slider_enable!' => 'on']);
		$this->register_slider_section_controls([
			'name'     => 'slider_enable',
			'operator' => '=',
			'value'    => 'on'
		]);
	}



	protected function register_content_section_controls() {
		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Content', 'ube' ),
			]
		);

		$this->add_control( 'client_logo_hover', [
			'label'   => esc_html__( 'Hover Type', 'ube' ),
			'type'    => Controls_Manager::SELECT,
			'options' => [
				''          => esc_html__( 'None', 'ube' ),
				'grayscale' => esc_html__( 'Gray scale', 'ube' ),
				'opacity'   => esc_html__( 'Opacity', 'ube' ),
				'faded'     => esc_html__( 'Faded', 'ube' ),
			],
			'default' => '',
		] );


		$this->add_control(
			'slider_enable',
			[
				'label'        => esc_html__( 'Slider', 'ube' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Enable', 'ube' ),
				'label_off'    => esc_html__( 'Disable', 'ube' ),
				'return_value' => 'on',
				'default'      => '',
			]
		);

		$this->end_controls_section();
	}

	protected function register_grid_section_controls($condition = [] ) {
		parent::register_grid_section_controls($condition);
		parent::register_grid_item_style_section_controls($condition);
	}

	protected function register_slider_section_controls($condition = []) {
		parent::register_slider_section_controls($condition);
		parent::register_slider_item_style_section_controls($condition);
		$this->remove_control('slider_type');
		$this->update_control('fade_enabled',[
			'conditions'   => [
				'terms' => [
					[
						'name'     => 'slides_to_show',
						'operator' => '==',
						'value'    => '1',
					],
				],
			],
		]);
	}

	protected function register_style_section_controls() {
		$this->register_style_hover_section_controls();
	}

	protected function register_style_hover_section_controls() {
		$this->start_controls_section(
			'style_hover_section',
			[
				'label' => esc_html__( 'Logo Hover', 'ube' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'client_logo_hover!' => '',
				],
			]
		);
		$this->start_controls_tabs( 'client_logo_tabs');

		$this->start_controls_tab(
			'client_logo_tab_normal',
			[
				'label' => esc_html__( 'Normal', 'ube' ),
			]
		);

		$this->add_control(
			'client_logo_gray_scale',
			[
				'label'      => esc_html__( 'Gray scale', 'ube' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ '%' ],
				'default'    => [ 'unit' => '%' ],
				'range'      => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .ube-client-logo-hover-grayscale' => '-webkit-filter: grayscale({{SIZE}}{{UNIT}}); filter: grayscale({{SIZE}}{{UNIT}});',
				],
				'condition'  => [
					'client_logo_hover' => 'grayscale',
				],
			]
		);

		$this->add_control(
			'client_logo_opacity',
			[
				'label'      => esc_html__( 'Opacity', 'ube' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ '%' ],
				'default'    => [ 'unit' => '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ube-client-logo-hover-grayscale,
					{{WRAPPER}} .ube-client-logo-hover-opacity,
					{{WRAPPER}} .ube-client-logo-hover-faded' => 'opacity : {{SIZE}}{{UNIT}};',
				],
				'condition'  => [
					'client_logo_hover!' => '',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'client_logo_tab_hover',
			[
				'label' => esc_html__( 'Hover', 'ube' ),
			]
		);


		$this->add_control(
			'client_logo_gray_scale_hover',
			[
				'label'      => esc_html__( 'Gray scale', 'ube' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ '%' ],
				'default'    => [ 'unit' => '%' ],
				'range'      => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .ube-client-logo-hover-grayscale:hover' => '-webkit-filter: grayscale({{SIZE}}{{UNIT}}); filter: grayscale({{SIZE}}{{UNIT}});',
				],
				'condition'  => [
					'client_logo_hover' => 'grayscale',
				],
			]
		);

		$this->add_control(
			'client_logo_opacity_hover',
			[
				'label'      => esc_html__( 'Opacity', 'ube' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ '%' ],
				'default'    => [ 'unit' => '%' ],
				'range'      => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .ube-client-logo-hover-grayscale:hover,
					{{WRAPPER}} .ube-client-logo-hover-opacity:hover,
					{{WRAPPER}} .ube-client-logo-hover-faded:hover' => 'opacity : {{SIZE}}{{UNIT}};',
				],
				'condition'  => [
					'client_logo_hover!' => '',
				],
			]
		);


		$this->end_controls_tab();

		$this->end_controls_tabs();


		$this->end_controls_section();
	}


}