<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;

class UBE_Element_Mapbox extends UBE_Abstracts_Elements {

	public function get_name() {
		return 'ube-mapbox';
	}

	public function get_title() {
		return esc_html__( 'Mapbox', 'ube' );
	}

	public function get_ube_icon() {
		return 'eicon-google-maps';
	}

	public function get_ube_keywords() {
		return array( 'map', 'mapbox', 'ube' , 'ube mapbox' );
	}

	public function get_style_depends() {
		return array( 'mapbox-gl' );
	}

	public function get_script_depends() {
		return array( 'ube-widget-map-box' );
	}

	protected function register_controls() {
		$this->register_marker_section_controls();
		$this->register_map_section_controls();
		$this->register_style_section_controls();
	}


	protected function register_marker_section_controls() {
		$this->start_controls_section(
			'section_markers',
			[
				'label' => esc_html__('Markers','ube')
			]
		);

		$repeater = new Repeater();

		$this->add_repeater_controls( $repeater );

		$this->add_control(
			'items',
			[
				'label'     => esc_html__( 'Items', 'ube' ),
				'type'      => Controls_Manager::REPEATER,
				'fields'    => $repeater->get_controls(),
				'default'   => [
						[
							'address' => '40.735601,-74.165918',
							'title' => esc_html__('Title','ube'),
							'description' =>  esc_html__('Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit...','ube')
						]
				],
			]
		);



		$this->end_controls_section();
	}

	protected function add_repeater_controls(\Elementor\Repeater $repeater ) {

		$repeater->start_controls_tabs('tabs_marker');

		$repeater->start_controls_tab('tab_marker',[
			'label' => esc_html__( 'Marker', 'ube' ),

		]);

		$repeater->add_control('address' , [
			'label' => esc_html__('Address','ube'),
			'type' => \Elementor\Controls_Manager::TEXT,
			'description' => esc_html__('Enter address or coordinate. Example: 40.735601,-74.165918', 'ube'),
			'default' => '40.735601,-74.165918',
			'label_block' => true,
		]);

		$repeater->add_control(
			'image_marker',
			[
				'label' => esc_html__( 'Marker Image', 'ube' ),
				'type'  => \Elementor\Controls_Manager::MEDIA,
			]
		);


		$repeater->end_controls_tab();


		$repeater->start_controls_tab('tab_popup',[
			'label' => esc_html__( 'Popup', 'ube' ),

		]);

		$repeater->add_control('title',[
			'label' => esc_html__('Title','ube'),
			'type' => \Elementor\Controls_Manager::TEXT,
			'default' => esc_html__('Title','ube'),
			'label_block' => true,
		]);

		$repeater->add_control('description', [
				'label'       => esc_html__( 'Description', 'ube' ),
				'type'        => \Elementor\Controls_Manager::WYSIWYG,
				'label_block' => true,
			]
		);
		$repeater->add_control(
			'image',
			[
				'label' => esc_html__( 'Image', 'ube' ),
				'type'  => \Elementor\Controls_Manager::MEDIA,
			]
		);


		$repeater->end_controls_tab();


		$repeater->end_controls_tabs();
	}

	protected function register_map_section_controls() {
		$this->start_controls_section('section_map',[
			'label' => esc_html__('Map Configs','ube')
		]);

		$this->add_control( 'map_style',
			[
				'label'   => esc_html__( 'Map Style', 'ube' ),
				'type'    => Controls_Manager::SELECT,
				'options' => apply_filters( 'ube_mapbox_style', [
					'skin1'           => esc_html__( 'Streets', 'ube' ),
					'skin2'          => esc_html__( 'Outdoors', 'ube' ),
					'skin3'             => esc_html__( 'Light', 'ube' ),
					'skin4'              => esc_html__( 'Dark', 'ube' ),
					'skin6'          => esc_html__( 'Satellite', 'ube' ),
					'skin7' => esc_html__( 'Nav Day', 'ube' ),
					'skin8'     => esc_html__( 'Nav Night', 'ube' ),
					'skin9'   => esc_html__( 'Guide Day', 'ube' ),
					'skin10'   => esc_html__( 'Guide Night', 'ube' ),
					'skin12'   => esc_html__( 'Standard', 'ube' ),
				] ),
				'default' => 'skin1',
			]
		);


		$this->add_responsive_control(
			'map_height',
			[
				'label'     => esc_html__( 'Map Height', 'ube' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 1000,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ube-map-box' => 'height: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'map_zoom',
			[
				'label'   => esc_html__( 'Map Zoom', 'ube' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'min'     => 0,
				'max'     => 24,
				'step'    => 1,
				'default' => 13,
			]
		);

		$this->add_control(
			'zoom_mouse_wheel',
			[
				'label'        => esc_html__( 'Zoom by MouseWheel', 'ube' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'marker_effect',
			[
				'label'        => esc_html__( 'Marker Effect', 'ube' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->end_controls_section();
	}

	protected function register_style_section_controls() {
		$this->register_style_marker_section_controls();
		$this->register_style_popup_section_controls();
	}

	protected function register_style_marker_section_controls() {
		$this->start_controls_section('style_marker_section',[
			'label' => esc_html__('Markers','ube'),
			'tab' => Controls_Manager::TAB_STYLE,
			'condition'    => [ 'marker_effect' => 'yes' ],
		]);


		$this->add_control( 'marker_effect_color_1', [
			'label'     => esc_html__( 'Marker Effect Color 1', 'ube' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .ube-map-box-effect' => '--map-box-effect-color1: {{VALUE}};',
			],
		] );

		$this->add_control( 'marker_effect_color_2', [
			'label'     => esc_html__( 'Marker Effect Color 2', 'ube' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .ube-map-box-effect' => '--map-box-effect-color2: {{VALUE}};',
			],
		] );

		$this->end_controls_section();
	}

	protected function register_style_popup_section_controls() {
		$this->start_controls_section('style_popup_section',[
			'label' => esc_html__('Popup','ube'),
			'tab' => Controls_Manager::TAB_STYLE,
		]);

		$this->add_responsive_control( 'markers_popup_width', [
			'label'      => esc_html__( 'Popup Width', 'ube' ),
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
				'px'  => [
					'min' => 0,
					'max' => 1000,
				],
			],
			'selectors'  => [
				'{{WRAPPER}} .mapboxgl-popup-content .card' => 'width: {{SIZE}}{{UNIT}};',
			],
		] );

		$this->add_responsive_control( 'markers_popup_padding', [
			'label'      => esc_html__( 'Padding', 'ube' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%', 'em' ],
			'selectors'  => [
				'{{WRAPPER}}  .mapboxgl-popup-content .card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		] );

		$this->add_control(
			'content_align',
			[
				'label'     => esc_html__( 'Text Align', 'ube' ),
				'type'      => \Elementor\Controls_Manager::CHOOSE,
				'options'   => [
					'left'   => [
						'title' => esc_html__( 'Left', 'ube' ),
						'icon'  => 'eicon-h-align-left',
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
					'{{WRAPPER}} .mapboxgl-popup-content .card-body'        => 'text-align: {{VALUE}};',
				],
			]
		);

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
				'{{WRAPPER}} .mapboxgl-popup-content .card-img-top' => 'margin-bottom: {{SIZE}}{{UNIT}};',
			],
		] );

		$this->add_control( 'markers_popup_title_heading', [
			'label'     => esc_html__( 'Title', 'ube' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'     => 'markers_popup_title',
			'selector' => '{{WRAPPER}} .mapboxgl-popup-content .card-title',
		] );

		$this->add_control( 'markers_popup_title_color', [
			'label'     => esc_html__( 'Color', 'ube' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .mapboxgl-popup-content .card-title' => 'color: {{VALUE}};',
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
				'{{WRAPPER}} .mapboxgl-popup-content .card-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
			],
		] );


		$this->add_control( 'markers_popup_description_heading', [
			'label'     => esc_html__( 'Content', 'ube' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'     => 'markers_popup_description',
			'selector' => '{{WRAPPER}} .mapboxgl-popup-content p',
		] );

		$this->add_control( 'markers_popup_description_color', [
			'label'     => esc_html__( 'Color', 'ube' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .mapboxgl-popup-content p' => 'color: {{VALUE}};',
			],
		] );

		$this->end_controls_section();

	}
	public function render_popup_item( $title, $description, $image ) {
		if ( empty( $image['url'] ) && empty( $title ) && empty( $description ) ) {
			return '';
		}
		ob_start();
		?>
		<div class="card">
			<?php if (!empty($image['id'])): ?>
				<?php echo wp_get_attachment_image($image['id'], 'full',false,array('class' => 'card-img-top' )) ?>
			<?php endif; ?>
			<div class="card-body">
				<?php if (!empty($title)): ?>
					<h5 class="card-title"><?php echo esc_html($title)?></h5>
				<?php endif; ?>
				<?php if (!empty($description)): ?>
					<p class="card-text"><?php echo wp_kses_post($description)?></p>
				<?php endif; ?>

			</div>
		</div>
		<?php
		return ob_get_clean();
	}

	protected function render() {
		ube_get_template( 'elements/mapbox.php', array(
			'element' => $this
		) );

	}
	protected function content_template() {
		ube_get_template( 'elements-view/mapbox.php' );
	}
}