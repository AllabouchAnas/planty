<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

class UBE_Element_Google_Map extends UBE_Abstracts_Elements {

	public function get_name() {
		return 'ube-google-map';
	}

	public function get_title() {
		return esc_html__( 'Google Map', 'ube' );
	}

	public function get_ube_icon() {
		return 'eicon-google-maps';
	}

	public function get_ube_keywords() {
		return array( 'map', 'google map' , 'ube' , 'ube google map' );
	}

	public function get_script_depends() {
		return array( 'ube-widget-google-map' );
	}

	protected function register_controls() {

		$this->map_setting_section();
		$this->marker_content_section();
		$this->add_map_markers_style_section();
	}

	private function map_setting_section() {
		$this->start_controls_section(
			'google_map_content',
			[
				'label' => esc_html__( 'Google Map', 'ube' ),
			]
		);
		$this->add_control( 'google_map_type',
			[
				'label'   => esc_html__( 'Map Type', 'ube' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'roadmap'   => esc_html__( 'Road Map', 'ube' ),
					'satellite' => esc_html__( 'Satellite', 'ube' ),
					'terrain'   => esc_html__( 'Terrain', 'ube' ),
					'hybrid'    => esc_html__( 'Hybrid', 'ube' ),
				],
				'default' => 'roadmap',
			]
		);


		$this->add_control(
			'zoom_control',
			[
				'label'        => esc_html__( 'Zoom Control', 'ube' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);

		$this->add_control(
			'map_default_zoom',
			[
				'label'     => esc_html__( 'Default Zoom', 'ube' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 5,
				],
				'range'     => [
					'px' => [
						'min' => 1,
						'max' => 24,
					],
				],
				'condition' => [
					'zoom_control' => 'yes',
				]
			]
		);

		$this->add_responsive_control(
			'google_map_height',
			[
				'label'     => esc_html__( 'Map Height', 'ube' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 1000,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ube-google-map' => 'min-height: {{SIZE}}{{UNIT}}',
				],
			]
		);
		$this->add_control(
			'center_address',
			[
				'label' => __( 'Center Address', 'ube' ),
				'type' => Controls_Manager::TEXTAREA,
				'placeholder' => __( 'Enter your center address.', 'ube' ),
				'default' => __( 'Americal', 'ube' ),
			]
		);
		$this->add_control(
			'google_map_control',
			[
				'label'     => esc_html__( 'Control', 'ube' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_control( 'google_map_map_type_control',
			[
				'label'        => esc_html__( 'Map Type Control', 'ube' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control( 'google_map_option_streeview',
			[
				'label'        => esc_html__( 'Street View Control', 'ube' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);

		$this->add_control( 'google_map_option_fullscreen_control',
			[
				'label'        => esc_html__( 'Fullscreen Control', 'ube' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);
		$this->add_control( 'google_map_option_draggable_control',
			[
				'label'        => esc_html__( 'Draggable Control', 'ube' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);
		$this->add_control( 'google_map_option_scale_control',
			[
				'label'        => esc_html__( 'Scale Control', 'ube' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);

		$this->add_control(
			'google_map_style',
			[
				'label'     => esc_html__( 'Map Style', 'ube' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',

			]
		);
		$this->add_control(
			'style_address',
			[
				'label'       => esc_html__( 'Map Style', 'ube' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => esc_html__( 'Enter Map Style Json Code.', 'ube' ),
				'description' => wp_kses_post(__( 'Go to <a href="https://snazzymaps.com/" target=_blank>Snazzy Maps</a> and Choose/Customize your Map Style. Click on your demo and copy JavaScript Style Array', 'ube' ))
			]
		);

		$this->end_controls_section();

	}

	private function marker_content_section() {
		$this->start_controls_section(
			'google_map_marker',
			[
				'label' => esc_html__( 'Map Marker', 'ube' ),
			]
		);
		$repeater = new \Elementor\Repeater();
		$repeater->start_controls_tabs(
			'google_map_marker_tabs'
		);

		$repeater->start_controls_tab(
			'google_map_marker_tab',
			[
				'label' => esc_html__( 'Marker', 'ube' ),
			]
		);
		$repeater->add_control(
			'marker_lat', [
				'label'       => esc_html__( 'Latitude', 'ube' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
			]
		);
		$repeater->add_control(
			'marker_lng', [
				'label'       => esc_html__( 'Longitude', 'ube' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
			]
		);
		$repeater->add_control(
			'custom_marker',
			[
				'label' => esc_html__( 'Custom marker', 'ube' ),
				'type'  => \Elementor\Controls_Manager::MEDIA,
			]
		);

		$repeater->end_controls_tab();
		$repeater->start_controls_tab(
			'google_map_marker_popup',
			[
				'label' => esc_html__( 'Popup', 'ube' ),
			]
		);
		$repeater->add_control(
			'marker_title', [
				'label'       => esc_html__( 'Title', 'ube' ),
				'type'        => \Elementor\Controls_Manager::TEXTAREA,
				'label_block' => true,
			]
		);
		$repeater->add_control(
			'marker_description', [
				'label'       => esc_html__( 'Description', 'ube' ),
				'type'        => \Elementor\Controls_Manager::WYSIWYG,
				'label_block' => true,
			]
		);
		$repeater->add_control(
			'marker_popup_image',
			[
				'label'   => esc_html__( 'Image', 'ube' ),
				'type'    => \Elementor\Controls_Manager::MEDIA,
			]
		);

		$repeater->end_controls_tab();
		$repeater->end_controls_tabs();

		$this->add_control(
			'map_marker_list',
			[
				'label'       => esc_html__( 'Marker', 'ube' ),
				'type'        => Controls_Manager::REPEATER,
				'default'     => [
					[
						'marker_title'       => esc_html__( 'This is Decatur district, Iowa United States', 'ube' ),
						'marker_description' => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure ', 'ube' ),
						'marker_lat'         => esc_html__( '40.612334', 'ube' ),
						'marker_lng'         => esc_html__( '-93.598606', 'ube' ),
					]

				],
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ marker_title }}}',
			]
		);

		$this->end_controls_section();
	}

	private function add_map_markers_style_section() {
		$this->start_controls_section( 'markers_popup_style_section', [
			'label' => esc_html__( 'Markers Popup', 'ube' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'markers_popup_wrapper_heading', [
			'label' => esc_html__( 'Wrapper', 'ube' ),
			'type'  => Controls_Manager::HEADING,
		] );

		$this->add_responsive_control( 'markers_popup_padding', [
			'label'      => esc_html__( 'Padding', 'ube' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%', 'em' ],
			'selectors'  => [
				'{{WRAPPER}} .card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		] );

		$this->add_responsive_control( 'markers_popup_width', [
			'label'      => esc_html__( 'Width', 'ube' ),
			'type'       => Controls_Manager::SLIDER,
			'default'    => [
				'unit' => 'px',
			],
			'size_units' => [ '%', 'px' ],
			'range'      => [
				'%'  => [
					'min' => 5,
					'max' => 50,
				],
				'px' => [
					'min' => 300,
					'max' => 1000,
				],
			],
			'selectors'  => [
				'{{WRAPPER}} .card' => 'width: {{SIZE}}{{UNIT}};',
			],
		] );
		$this->add_control( 'markers_popup_color', [
			'label'     => esc_html__( 'Color', 'ube' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .card-body' => 'color: {{VALUE}};',
			],
		] );

		$this->add_control( 'markers_popup_image_heading', [
			'label'     => esc_html__( 'Image', 'ube' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_responsive_control( 'markers_popup_image_spacing', [
			'label'      => esc_html__( 'Spacing', 'ube' ),
			'type'       => Controls_Manager::SLIDER,
			'default'    => [
				'unit' => 'px',
			],
			'size_units' => [ 'px', '%', 'em' ],
			'range'      => [
				'%'  => [
					'min' => 0,
					'max' => 100,
				],
				'px' => [
					'min' => 0,
					'max' => 200,
				],
			],
			'selectors'  => [
				'{{WRAPPER}} .card .card-img-top' => 'margin-bottom: {{SIZE}}{{UNIT}};',
			],
		] );

		$this->add_control( 'markers_popup_title_heading', [
			'label'     => esc_html__( 'Title', 'ube' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'     => 'markers_popup_title',
			'selector' => '{{WRAPPER}} .card-title',
		] );

		$this->add_control( 'markers_popup_title_color', [
			'label'     => esc_html__( 'Color', 'ube' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .card-title' => 'color: {{VALUE}};',
			],
		] );
		$this->add_responsive_control( 'markers_popup_title_spacing', [
			'label'      => esc_html__( 'Spacing', 'ube' ),
			'type'       => Controls_Manager::SLIDER,
			'default'    => [
				'unit' => 'px',
			],
			'size_units' => [ 'px', '%', 'em' ],
			'range'      => [
				'%'  => [
					'min' => 0,
					'max' => 100,
				],
				'px' => [
					'min' => 0,
					'max' => 200,
				],
			],
			'selectors'  => [
				'{{WRAPPER}} .card .card-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
			],
		] );


		$this->add_control( 'markers_popup_description_heading', [
			'label'     => esc_html__( 'Content', 'ube' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'     => 'markers_popup_description',
			'selector' => '{{WRAPPER}} .card-text',
		] );

		$this->add_control( 'markers_popup_description_color', [
			'label'     => esc_html__( 'Color', 'ube' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .card-text' => 'color: {{VALUE}};',
			],
		] );

		$this->end_controls_section();
	}

	public function render_popup_item( $image_id,$image_url, $title, $description ) {
		if ( empty( $image_url ) && empty( $title ) && empty( $description ) ) {
			return '';
		}
		$string = '<div class="card">';

		if ( ! empty( $image_url ) ) {
			$image_data=ube_get_img_meta($image_id);
			$string .= '<img class="card-img-top" src="' . esc_url($image_url ) . '" alt="'.esc_attr($image_data['alt']).'">';
		}

		$string .= '<div class="card-body">';

		if ( ! empty( $title ) ) {
			$string .= '<h5 class="card-title">' . esc_html( $title ) . '</h5>';
		}

		if ( ! empty( $description ) ) {
			$string .= '<p class="card-text">' . esc_html( $description ) . '</p>';
		}

		$string .= '</div >';
		$string .= '</div >';

		return $string;
	}

	protected function render() {

		ube_get_template( 'elements/google-map.php', array(
			'element' => $this
		) );

	}


	protected function content_template() {
		ube_get_template( 'elements-view/google-map.php');
	}
}