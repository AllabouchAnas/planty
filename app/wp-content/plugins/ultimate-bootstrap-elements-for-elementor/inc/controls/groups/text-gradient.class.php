<?php

//namespace UBE\Group_Control;

use Elementor\Group_Control_Base;
use Elementor\Controls_Manager;

defined( 'ABSPATH' ) || exit;

/**
 * Elementor text gradient color control.
 *
 * A base control for creating text classic & gradient color control. Displays input fields to define
 * the classic color, gradient color.
 *
 * @since 1.0.0
 */
class UBE_Group_Control_Text_Gradient extends Group_Control_Base {

	/**
	 * Fields.
	 *
	 * Holds all the text gradient control fields.
	 *
	 * @since  1.0.0
	 * @access protected
	 * @static
	 *
	 * @var array text gradient color control fields.
	 */
	protected static $fields;

	/**
	 * Color Types.
	 *
	 * Holds all the available color types.
	 *
	 * @since  1.0.0
	 * @static
	 *
	 * @var array
	 */
	private static $color_types;

	/**
	 * Get text gradient color control type.
	 *
	 * Retrieve the control type, in this case `text-gradient`.
	 *
	 * @since  1.0.0
	 * @access public
	 * @static
	 *
	 * @return string Control type.
	 */
	public static function get_type() {
		return UBE_Controls_Manager::TEXT_GRADIENT;
	}

	/**
	 * Get text gradient control types.
	 *
	 * Retrieve available color types.
	 *
	 * @since  1.0.0
	 * @access public
	 * @static
	 *
	 * @return array Available background types.
	 */
	public static function get_color_types() {
		if ( null === self::$color_types ) {
			self::$color_types = self::get_default_color_types();
		}

		return self::$color_types;
	}

	/**
	 * Get default color types.
	 *
	 * Retrieve color control initial types.
	 *
	 * @since  1.0.0
	 * @access private
	 * @static
	 *
	 * @return array Default color types.
	 */
	private static function get_default_color_types() {
		return [
			'classic'  => [
				'title' => _x( 'Classic', 'Text Gradient Control', 'ube' ),
				'icon'  => 'eicon-paint-brush',
			],
			'gradient' => [
				'title' => _x( 'Gradient', 'Text Gradient Control', 'ube' ),
				'icon'  => 'eicon-barcode',
			],
		];
	}

	/**
	 * Init fields.
	 *
	 * Initialize background control fields.
	 *
	 * @since  1.2.2
	 * @access public
	 *
	 * @return array Control fields.
	 */
	public function init_fields() {
		$fields = [];

		$fields['color_type'] = [
			'label'       => esc_html__( 'Color Type', 'ube' ),
			'type'        => Controls_Manager::CHOOSE,
			'label_block' => false,
			'render_type' => 'template',
			'default'     => 'classic',
		];

		$fields['color'] = [
			'label'     => esc_html__( 'Color', 'ube' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => '',
			'selectors' => [
				'{{SELECTOR}}'         => 'color: {{VALUE}};',
				'{{SELECTOR}} .stop-a' => 'stop-color: {{VALUE}}',
				'{{SELECTOR}} .stop-b' => 'stop-color: {{VALUE}}',
			],
			'condition' => [
				'color_type' => [ 'classic' ],
			],
		];

		$fields['color_a'] = [
			'label'       => esc_html__( 'First Color', 'ube' ),
			'type'        => Controls_Manager::COLOR,
			'default'     => '#5758DF',
			'render_type' => 'ui',
			'condition'   => [
				'color_type' => [ 'gradient' ],
			],
			'of_type'     => 'gradient',
		];

		$fields['color_a_stop'] = [
			'label'       => _x( 'Location', 'Text Gradient Control', 'ube' ),
			'type'        => Controls_Manager::SLIDER,
			'size_units'  => [ '%' ],
			'default'     => [
				'unit' => '%',
				'size' => 0,
			],
			'render_type' => 'ui',
			'condition'   => [
				'color_type' => [ 'gradient' ],
			],
			'of_type'     => 'gradient',
		];

		$fields['color_b'] = [
			'label'       => esc_html__( 'Second Color', 'ube' ),
			'type'        => Controls_Manager::COLOR,
			'default'     => '#F77991',
			'render_type' => 'ui',
			'condition'   => [
				'color_type' => [ 'gradient' ],
			],
			'of_type'     => 'gradient',
		];

		$fields['color_b_stop'] = [
			'label'       => _x( 'Location', 'Text Gradient Control', 'ube' ),
			'type'        => Controls_Manager::SLIDER,
			'size_units'  => [ '%' ],
			'default'     => [
				'unit' => '%',
				'size' => 100,
			],
			'render_type' => 'ui',
			'condition'   => [
				'color_type' => [ 'gradient' ],
			],
			'of_type'     => 'gradient',
		];

		$fields['gradient_angle'] = [
			'label'      => _x( 'Angle', 'Text Gradient Control', 'ube' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'deg' ],
			'default'    => [
				'unit' => 'deg',
				'size' => 90,
			],
			'range'      => [
				'deg' => [
					'step' => 10,
				],
			],
			'selectors'  => [
				'{{SELECTOR}}'         => 'background-color: transparent; background-image: linear-gradient({{SIZE}}{{UNIT}}, {{color_a.VALUE}} {{color_a_stop.SIZE}}{{color_a_stop.UNIT}}, {{color_b.VALUE}} {{color_b_stop.SIZE}}{{color_b_stop.UNIT}}); color: transparent; -webkit-background-clip: text; background-clip: text;',
				'{{SELECTOR}} .stop-a' => 'stop-color: {{color_a.VALUE}}',
				'{{SELECTOR}} .stop-b' => 'stop-color: {{color_b.VALUE}}',
			],
			'condition'  => [
				'color_type' => [ 'gradient' ],
			],
			'of_type'    => 'gradient',
		];

		return $fields;
	}

	/**
	 * Get child default args.
	 *
	 * Retrieve the default arguments for all the child controls for a specific group
	 * control.
	 *
	 * @since  1.2.2
	 * @access protected
	 *
	 * @return array Default arguments for all the child controls.
	 */
	protected function get_child_default_args() {
		return [
			'types'    => [ 'classic', 'gradient' ],
			'selector' => '{{WRAPPER}}:not(.elementor-motion-effects-element-type-background), {{WRAPPER}} > .elementor-motion-effects-container > .elementor-motion-effects-layer',
		];
	}

	/**
	 * Filter fields.
	 *
	 * Filter which controls to display, using `include`, `exclude`, `condition`
	 * and `of_type` arguments.
	 *
	 * @since  1.2.2
	 * @access protected
	 *
	 * @return array Control fields.
	 */
	protected function filter_fields() {
		$fields = parent::filter_fields();

		$args = $this->get_args();

		foreach ( $fields as &$field ) {
			if ( isset( $field['of_type'] ) && ! in_array( $field['of_type'], $args['types'] ) ) {
				unset( $field );
			}
		}

		return $fields;
	}

	/**
	 * Prepare fields.
	 *
	 * Process text gradient color control fields before adding them to `add_control()`.
	 *
	 * @since  1.2.2
	 * @access protected
	 *
	 * @param array $fields Background control fields.
	 *
	 * @return array Processed fields.
	 */
	protected function prepare_fields( $fields ) {
		$args = $this->get_args();

		$color_types = self::get_color_types();

		$choose_types = [];

		foreach ( $args['types'] as $type ) {
			if ( isset( $color_types[ $type ] ) ) {
				$choose_types[ $type ] = $color_types[ $type ];
			}
		}

		$fields['color_type']['options'] = $choose_types;

		return parent::prepare_fields( $fields );
	}

	/**
	 * Get default options.
	 *
	 * Retrieve the default options of the background control. Used to return the
	 * default options while initializing the background control.
	 *
	 * @since  1.9.0
	 * @access protected
	 *
	 * @return array Default background control options.
	 */
	protected function get_default_options() {
		return [
			'popover' => false,
		];
	}
}
