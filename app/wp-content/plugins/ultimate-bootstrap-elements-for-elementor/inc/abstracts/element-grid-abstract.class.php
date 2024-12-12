<?php

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

abstract class UBE_Abstracts_Elements_Grid extends UBE_Abstracts_Elements_Slider {

	private $current_item = null;

	private $current_item_key = null;

	abstract protected function add_repeater_controls( Repeater $repeater );

	abstract protected function get_repeater_defaults();

	abstract protected function print_grid_item();

	protected function register_items_section_controls() {
		$this->start_controls_section(
			'section_items',
			[
				'label' => esc_html__( 'Items', 'ube' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
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
				'default'   => $this->get_repeater_defaults(),
				'separator' => 'after',
			]
		);

		$this->end_controls_section();
	}

	protected function register_grid_section_controls( $condition = [] ) {
		$this->start_controls_section(
			'section_grid',
			[
				'label'     => esc_html__( 'Grid Options', 'ube' ),
				'tab'       => Controls_Manager::TAB_CONTENT,
				'condition' => $condition
			]
		);

		$this->add_responsive_control( 'grid_columns', [
			'label'          => esc_html__( 'Columns', 'ube' ),
			'type'           => Controls_Manager::NUMBER,
			'min'            => 1,
			'max'            => 12,
			'step'           => 1,
			'default'        => 4,
			'prefix_class'   => 'elementor-grid%s-',
		] );

		$this->add_responsive_control( 'grid_column_gutter', [
			'label'     => esc_html__( 'Column Gutter', 'ube' ),
			'type'      => Controls_Manager::NUMBER,
			'min'       => 0,
			'max'       => 200,
			'step'      => 1,
			'default'   => 30,
			'selectors' => [
				'{{WRAPPER}}' => '--grid-column-gap: {{VALUE}}px;',
			],
		] );

		$this->add_responsive_control( 'grid_row_gutter', [
			'label'     => esc_html__( 'Row Gutter', 'ube' ),
			'type'      => Controls_Manager::NUMBER,
			'min'       => 0,
			'max'       => 200,
			'step'      => 1,
			'default'   => 30,
			'selectors' => [
				'{{WRAPPER}}' => '--grid-row-gap: {{VALUE}}px;',
			],
		] );

		$this->add_responsive_control( 'grid_content_position', [
			'label'                => esc_html__( 'Content Position', 'ube' ),
			'type'                 => Controls_Manager::SELECT,
			'default'              => '',
			'options'              => [
				''       => esc_html__( 'Default', 'ube' ),
				'top'    => esc_html__( 'Top', 'ube' ),
				'middle' => esc_html__( 'Middle', 'ube' ),
				'bottom' => esc_html__( 'Bottom', 'ube' ),
			],
			'selectors_dictionary' => [
				'top'    => 'start',
				'middle' => 'center',
				'bottom' => 'end',
			],
			'selectors'            => [
				//'{{WRAPPER}} .elementor-grid' => 'align-items: {{VALUE}}',
				'{{WRAPPER}} .elementor-grid-item' => 'align-items: {{VALUE}}; display:grid;',

			],
		] );

		$this->add_responsive_control( 'grid_content_alignment', [
			'label'                => esc_html__( 'Content Alignment', 'ube' ),
			'type'                 => Controls_Manager::SELECT,
			'default'              => '',
			'options'              => [
				''       => esc_html__( 'Default', 'ube' ),
				'left'   => esc_html__( 'Left', 'ube' ),
				'center' => esc_html__( 'Center', 'ube' ),
				'right'  => esc_html__( 'Right', 'ube' ),
			],
			'selectors_dictionary' => [
				'left'  => 'start',
				'right' => 'end',
			],
			'selectors'            => [
				//'{{WRAPPER}} .elementor-grid' => 'justify-items: {{VALUE}}',
				'{{WRAPPER}} .elementor-grid-item' => 'justify-items: {{VALUE}};display:grid;',
			],
			//'render_type'          => 'template',
		] );



		$this->end_controls_section();
	}

	protected function register_grid_item_style_section_controls( $condition = []) {
		$this->start_controls_section(
			'section_grid_item_style',
			[
				'label'     => esc_html__( 'Grid Item', 'ube' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => $condition
			]
		);

		$this->add_responsive_control( 'grid_content_padding', [
			'label'      => esc_html__( 'Padding', 'ube' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%', 'em', 'rem' ],
			'selectors'  => [
				'{{WRAPPER}} .elementor-grid-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		] );

		$this->start_controls_tabs('grid_item_tabs');
		$this->start_controls_tab('grid_item_tab_normal',[
				'label' => esc_html__('Normal','ube')
		]);




		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'grid_item_border',
				'label'    => esc_html__( 'Border', 'ube' ),
				'selector' => '{{WRAPPER}} .elementor-grid-item',
			]
		);


		$this->add_responsive_control(
			'grid_item_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'ube' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .elementor-grid-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'

				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'grid_item_box_shadow',
				'selector' => '{{WRAPPER}}  .elementor-grid-item',
			]
		);

		$this->add_control(
			'grid_item_background',
			[
				'label' => esc_html__('Background Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-grid-item' => 'background-color: {{VALUE}};',
				]
			]
		);


		$this->end_controls_tab();

		$this->start_controls_tab('grid_item_tab_hover',[
			'label' => esc_html__('Hover','ube')
		]);




		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'grid_item_border_hover',
				'label'    => esc_html__( 'Border', 'ube' ),
				'selector' => '{{WRAPPER}} .elementor-grid-item:hover',
			]
		);


		$this->add_responsive_control(
			'grid_item_border_radius_hover',
			[
				'label'      => esc_html__( 'Border Radius', 'ube' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .elementor-grid-item:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'

				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'grid_item_box_shadow_hover',
				'selector' => '{{WRAPPER}}  .elementor-grid-item:hover',
			]
		);

		$this->add_control(
			'grid_item_background_hover',
			[
				'label' => esc_html__('Background Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-grid-item:hover' => 'background-color: {{VALUE}};',
				]
			]
		);


		$this->add_control(
			'grid_item_hover_transition',
			[
				'label' => esc_html__( 'Transition Duration', 'ube' ),
				'type' => Controls_Manager::SLIDER,
				'separator' => 'before',
				'default' => [
					'size' => 0.3,
				],
				'range' => [
					'px' => [
						'max' => 3,
						'step' => 0.1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-grid-item' => 'transition: background {{SIZE}}s, border {{SIZE}}s, border-radius {{SIZE}}s, box-shadow {{SIZE}}s',
				],
			]
		);



		$this->end_controls_tab();


		$this->end_controls_tabs();



		$this->end_controls_section();
	}

	protected function print_grid( array $settings = null, $wrapper_class = '' ) {
		if ( null === $settings ) {
			$settings = $this->get_active_settings();
		}
		$wrapper_classes = array(
			'elementor-grid',
			$wrapper_class
		);


		$this->add_render_attribute( 'grid', 'class', $wrapper_classes );
		?>
		<div <?php $this->print_render_attribute_string( 'grid' ); ?>>
			<?php $this->print_grid_items( $settings ); ?>
		</div>
		<?php
	}

	protected function print_grid_items( array $settings ) {
		?>
		<?php foreach ( $settings['items'] as $item ): ?>
			<?php
			$item_id  = $item['_id'];
			$item_key = 'item_' . $item_id;
			$this->set_current_item( $item );
			$this->set_current_item_key( $item_key );
			$custom_css = isset($item['css_classes']) ? $item['css_classes'] : '';
			$this->add_render_attribute( $item_key, [
				'class' => [
					'elementor-grid-item',
					'elementor-repeater-item-' . $item_id,
					$custom_css
				],
			] );
			?>
			<div <?php $this->print_render_attribute_string( $item_key ); ?>>
				<?php $this->print_grid_item(); ?>
			</div>
		<?php endforeach; ?>
		<?php
	}

	protected function get_current_item() {
		return $this->current_item;
	}

	protected function get_current_item_key() {
		return $this->current_item_key;
	}

	protected function set_current_item( $item ) {
		$this->current_item = $item;
	}

	protected function set_current_item_key( $key ) {
		$this->current_item_key = $key;
	}

	protected function print_slider_items(array $settings) {
		foreach (  $settings['items']  as $item ) {
			$item_id  = $item['_id'];
			$item_key = 'item_' . $item_id;
			$custom_css = isset($item['css_classes']) ? $item['css_classes'] : '';
			$this->set_current_item( $item );
			$this->set_current_item_key( $item_key );
			$this->add_render_attribute( $item_key, [
				'class' => [
					'ube-slider-item',
					'elementor-repeater-item-' . $item_id,
					$custom_css
				],
			] );
			?>
				<div <?php $this->print_render_attribute_string( $item_key ); ?>>
					<?php $this->print_grid_item(); ?>
				</div>
			<?php
		}
	}

	protected function register_item_custom_css_control( Repeater $repeater) {
		$repeater->add_control(
			'css_classes',
			[
				'label' => esc_html__( 'CSS Classes', 'ube' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'dynamic' => [
					'active' => true,
				],
				'prefix_class' => '',
				'title' => esc_html__( 'Add your custom class WITHOUT the dot. e.g: my-class', 'ube' ),
				'classes' => 'elementor-control-direction-ltr',
			]
		);
	}
}