<?php
if (!defined('ABSPATH')) {
	exit;
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border as Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography as Group_Control_Typography;

class UBE_Element_Contact_Form_7 extends UBE_Abstracts_Elements
{
	public static function is_enabled() {
		return class_exists('WPCF7');
	}

	public function get_name()
	{
		return 'ube-contact-form-7';
	}

	public function get_title()
	{
		return esc_html__('Contact Form 7', 'ube');
	}

	public function get_ube_icon()
	{
		return 'eicon-form-horizontal';
	}

	public function get_ube_keywords()
	{
		return array('form', 'contact', 'contact form' , 'ube' , 'ube contact form');
	}

	public function select_contact_form()
	{
		$options = array();

		if (function_exists('wpcf7')) {
			$wpcf7_form_list = get_posts(array(
				'post_type' => 'wpcf7_contact_form',
				'showposts' => 999,
			));
			$options[0] = esc_html__('Select a Contact Form', 'ube');
			if (!empty($wpcf7_form_list) && !is_wp_error($wpcf7_form_list)) {
				foreach ($wpcf7_form_list as $post) {
					$options[$post->ID] = $post->post_title;
				}
			} else {
				$options[0] = esc_html__('Create a Form First', 'ube');
			}
		}

		return $options;
	}

	protected function register_controls()
	{
		/*-----------------------------------------------------------------------------------*/
		/*    CONTENT TAB
		/*-----------------------------------------------------------------------------------*/
		if (!function_exists('wpcf7')) {
			$this->start_controls_section(
				'global_warning',
				[
					'label' => esc_html__('Warning!', 'ube'),
				]
			);

			$this->add_control(
				'global_warning_text',
				[
					'type' => Controls_Manager::RAW_HTML,
					'raw' => wp_kses_post(__('<strong>Contact Form 7</strong> is not installed/activated on your site. Please install and activate <strong>Contact Form 7</strong> first.', 'ube')),
					'content_classes' => 'ube-warning',
				]
			);

			$this->end_controls_section();
		} else {
			/**
			 * Content Tab: Contact Form
			 * -------------------------------------------------
			 */
			$this->section_contact_form();

			/**
			 * Content Tab: Errors
			 * -------------------------------------------------
			 */
			$this->section_error_setting();


			/*-----------------------------------------------------------------------------------*/
			/*    STYLE TAB
			/*-----------------------------------------------------------------------------------*/

			/**
			 * Style Tab: Input & Textarea
			 * -------------------------------------------------
			 */
			$this->section_input_style();

			/**
			 * Style Tab: Label Section
			 */
			$this->section_label_style();

			/**
			 * Style Tab: Placeholder Section
			 */
			$this->section_place_holder();


			/**
			 * Style Tab: Submit Button
			 */
			$this->section_submit_button();

			/**
			 * Style Tab: Errors
			 */
			$this->section_error_style();

			/**
			 * Style Tab: After Submit Feedback
			 */
			$this->section_after_feedback();
		}
	}

	private function section_contact_form()
	{
		$this->start_controls_section(
			'section_info_box',
			[
				'label' => esc_html__('Contact Form', 'ube'),
			]
		);

		$this->add_control(
			'contact_form_list',
			[
				'label' => esc_html__('Select Form', 'ube'),
				'type' => Controls_Manager::SELECT,
				'label_block' => true,
				'options' => $this->select_contact_form(),
				'default' => '0',
			]
		);


		$this->end_controls_section();
	}

	private function section_error_setting()
	{
		$this->start_controls_section(
			'section_errors',
			[
				'label' => esc_html__('Errors', 'ube'),
			]
		);

		$this->add_control(
			'error_messages',
			[
				'label' => esc_html__('Error Messages', 'ube'),
				'type' => Controls_Manager::SELECT,
				'default' => 'show',
				'options' => [
					'show' => esc_html__('Show', 'ube'),
					'hide' => esc_html__('Hide', 'ube'),
				],
				'selectors_dictionary' => [
					'show' => 'block',
					'hide' => 'none',
				],
				'selectors' => [
					'{{WRAPPER}} .ube-contact-form-7 .wpcf7-not-valid-tip' => 'display: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'validation_errors',
			[
				'label' => esc_html__('Validation Errors', 'ube'),
				'type' => Controls_Manager::SELECT,
				'default' => 'show',
				'options' => [
					'show' => esc_html__('Show', 'ube'),
					'hide' => esc_html__('Hide', 'ube'),
				],
				'selectors_dictionary' => [
					'show' => 'block',
					'hide' => 'none',
				],
				'selectors' => [
					'{{WRAPPER}} .ube-contact-form-7 .wpcf7-validation-errors' => 'display: {{VALUE}} !important;',
				],
			]
		);

		$this->end_controls_section();
	}

	private function section_input_style()
	{
		$this->start_controls_section(
			'section_fields_style',
			[
				'label' => esc_html__('Input & Textarea', 'ube'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_responsive_control(
			'input_spacing',
			[
				'label' => esc_html__('Spacing', 'ube'),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => '0',
					'unit' => 'px',
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .ube-contact-form-7 label' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'field_padding',
			[
				'label' => esc_html__('Padding', 'ube'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .ube-contact-form-7 .wpcf7-form-control.wpcf7-text, {{WRAPPER}} .ube-contact-form-7 .wpcf7-form-control.wpcf7-date, {{WRAPPER}} .ube-contact-form-7 .wpcf7-form-control.wpcf7-textarea' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'text_indent',
			[
				'label' => esc_html__('Text Indent', 'ube'),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 60,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 30,
						'step' => 1,
					],
				],
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .ube-contact-form-7 .wpcf7-form-control.wpcf7-text, {{WRAPPER}} .ube-contact-form-7 .wpcf7-form-control.wpcf7-textarea, {{WRAPPER}} .ube-contact-form-7 .wpcf7-form-control.wpcf7-date, {{WRAPPER}} .ube-contact-form-7 .wpcf7-form-control.wpcf7-select' => 'text-indent: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'input_width',
			[
				'label' => esc_html__('Input Width', 'ube'),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1200,
						'step' => 1,
					],
				],
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .ube-contact-form-7 .wpcf7-form-control.wpcf7-text, {{WRAPPER}} .ube-contact-form-7 .wpcf7-form-control.wpcf7-date, {{WRAPPER}} .ube-contact-form-7 .wpcf7-form-control.wpcf7-select' => 'width: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'input_height',
			[
				'label' => esc_html__('Input Height', 'ube'),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1200,
						'step' => 1,
					],
				],
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .ube-contact-form-7 .wpcf7-form-control.wpcf7-text, {{WRAPPER}} .ube-contact-form-7 .wpcf7-form-control.wpcf7-date, {{WRAPPER}} .ube-contact-form-7 .wpcf7-form-control.wpcf7-select' => 'height: {{SIZE}}{{UNIT}};line-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'textarea_width',
			[
				'label' => esc_html__('Textarea Width', 'ube'),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1200,
						'step' => 1,
					],
				],
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .ube-contact-form-7 .wpcf7-form-control.wpcf7-textarea' => 'width: {{SIZE}}{{UNIT}}',
				],
			]
		);
		$this->add_responsive_control(
			'textarea_height',
			[
				'label' => esc_html__('Textarea Height', 'ube'),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1200,
						'step' => 1,
					],
				],
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .ube-contact-form-7 .wpcf7-form-control.wpcf7-textarea' => 'height: {{SIZE}}{{UNIT}}',
				],
			]
		);


		$this->add_control(
			'field_radius',
			[
				'label' => esc_html__('Border Radius', 'ube'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .ube-contact-form-7 .wpcf7-form-control.wpcf7-text, {{WRAPPER}} .ube-contact-form-7 .wpcf7-form-control.wpcf7-date, {{WRAPPER}} .ube-contact-form-7 .wpcf7-form-control.wpcf7-textarea' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'field_typography',
				'label' => esc_html__('Typography', 'ube'),

				'selector' => '{{WRAPPER}} .ube-contact-form-7 .wpcf7-form-control.wpcf7-text, {{WRAPPER}} .ube-contact-form-7 .wpcf7-form-control.wpcf7-textarea, {{WRAPPER}} .ube-contact-form-7 .wpcf7-form-control.wpcf7-select',
				'separator' => 'before',
			]
		);


		$this->start_controls_tabs('tabs_fields_style');

		$this->start_controls_tab(
			'tab_fields_normal',
			[
				'label' => esc_html__('Normal', 'ube'),
			]
		);

		$this->add_control(
			'field_bg',
			[
				'label' => esc_html__('Background Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .ube-contact-form-7 .wpcf7-form-control.wpcf7-text, {{WRAPPER}} .ube-contact-form-7 .wpcf7-form-control.wpcf7-date, {{WRAPPER}} .ube-contact-form-7 .wpcf7-form-control.wpcf7-textarea, {{WRAPPER}} .ube-contact-form-7 .wpcf7-form-control.wpcf7-select' => 'background-color: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'field_border',
				'label' => esc_html__('Border', 'ube'),
				'placeholder' => '1px',
				'default' => '1px',
				'selector' => '{{WRAPPER}} .ube-contact-form-7 .wpcf7-form-control.wpcf7-text,{{WRAPPER}} .ube-contact-form-7 .wpcf7-form-control.wpcf7-date, {{WRAPPER}} .ube-contact-form-7 .wpcf7-form-control.wpcf7-textarea, {{WRAPPER}} .ube-contact-form-7 .wpcf7-form-control.wpcf7-select',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'field_box_shadow',
				'selector' => '{{WRAPPER}} .ube-contact-form-7 .wpcf7-form-control.wpcf7-text, {{WRAPPER}} .ube-contact-form-7 .wpcf7-form-control.wpcf7-textarea, {{WRAPPER}} .ube-contact-form-7 .wpcf7-form-control.wpcf7-select',
				'separator' => 'before',
			]
		);


		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_fields_focus',
			[
				'label' => esc_html__('Focus', 'ube'),
			]
		);

		$this->add_control(
			'field_bg_focus',
			[
				'label' => esc_html__('Background Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .ube-contact-form-7 .wpcf7-form input:focus, {{WRAPPER}} .ube-contact-form-7 .wpcf7-form textarea:focus' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'input_border_focus',
				'label' => esc_html__('Border', 'ube'),
				'placeholder' => '1px',
				'default' => '1px',
				'selector' => '{{WRAPPER}} .ube-contact-form-7 .wpcf7-form input:focus, {{WRAPPER}} .ube-contact-form-7 .wpcf7-form textarea:focus',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'focus_box_shadow',
				'selector' => '{{WRAPPER}} .ube-contact-form-7 .wpcf7-form input:focus, {{WRAPPER}} .ube-contact-form-7 .wpcf7-form textarea:focus',
				'separator' => 'before',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	private function section_label_style()
	{
		$this->start_controls_section(
			'section_label_style',
			[
				'label' => esc_html__('Labels', 'ube'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'text_color_label',
			[
				'label' => esc_html__('Text Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-contact-form-7 .wpcf7-form p' => 'color: {{VALUE}}',
					'{{WRAPPER}} .ube-contact-form-7 label' => 'color: {{VALUE}}',
					'{{WRAPPER}} .ube-contact-form-7 .wpcf7-list-item-label' => 'color: {{VALUE}}'
				],
			]
		);

		$this->add_responsive_control(
			'label_spacing',
			[
				'label' => esc_html__('Spacing', 'ube'),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .ube-contact-form-7 .wpcf7-form-control-wrap' => 'margin-top: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .ube-contact-form-7 .wpcf7-list-item-label:first-child' => 'margin-right: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .ube-contact-form-7 .wpcf7-list-item-label:last-child' => 'margin-left: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'typography_label',
				'label' => esc_html__('Typography', 'ube'),

				'selector' => '{{WRAPPER}} .ube-contact-form-7 .wpcf7-form p,{{WRAPPER}} .ube-contact-form-7 .wpcf7-form label,{{WRAPPER}} .ube-contact-form-7 .wpcf7-list-item-label',
			]
		);

		$this->end_controls_section();
	}

	private function section_place_holder()
	{
		$this->start_controls_section(
			'section_placeholder_style',
			[
				'label' => esc_html__('Placeholder', 'ube'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);


		$this->add_control(
			'text_color_placeholder',
			[
				'label' => esc_html__('Text Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-contact-form-7 .wpcf7-form-control::-webkit-input-placeholder' => 'color: {{VALUE}}',
					'{{WRAPPER}} .ube-contact-form-7 .wpcf7-form-control::-moz-placeholder' => 'color: {{VALUE}};',
					'{{WRAPPER}} .ube-contact-form-7 .wpcf7-form-control:-ms-input-placeholder' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'typography_placeholder',
				'label' => esc_html__('Typography', 'ube'),

				'selector' => '{{WRAPPER}} .ube-contact-form-7 .wpcf7-form-control::-webkit-input-placeholder',
			]
		);

		$this->end_controls_section();
	}


	private function section_submit_button()
	{
		$this->start_controls_section(
			'section_submit_button_style',
			[
				'label' => esc_html__('Submit Button', 'ube'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'button_align',
			[
				'label' => esc_html__('Alignment', 'ube'),
				'type' => Controls_Manager::CHOOSE,
				'default' => 'left',
				'options' => [
					'left' => [
						'title' => esc_html__('Left', 'ube'),
						'icon' => 'eicon-h-align-left',
					],
					'center' => [
						'title' => esc_html__('Center', 'ube'),
						'icon' => 'eicon-h-align-center',
					],
					'right' => [
						'title' => esc_html__('Right', 'ube'),
						'icon' => 'eicon-h-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ube-contact-form-7 .wpcf7-form p:nth-last-of-type(1)' => 'text-align: {{VALUE}};',
					'{{WRAPPER}} .ube-contact-form-7 .wpcf7-form input[type="submit"]' => 'display:inline-block;',
				],
				'condition' => [
					'button_width_type' => 'custom',
				],
			]
		);

		$this->add_control(
			'button_width_type',
			[
				'label' => esc_html__('Width', 'ube'),
				'type' => Controls_Manager::SELECT,
				'default' => 'custom',
				'options' => [
					'full-width' => esc_html__('Full Width', 'ube'),
					'custom' => esc_html__('Custom', 'ube'),
				],
				'prefix_class' => 'ube-contact-form-7-button-',
			]
		);

		$this->add_responsive_control(
			'button_width',
			[
				'label' => esc_html__('Width', 'ube'),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1200,
						'step' => 1,
					],
				],
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .ube-contact-form-7 .wpcf7-form input[type="submit"]' => 'width: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'button_width_type' => 'custom',
				],
			]
		);

		$this->add_responsive_control(
			'button_height',
			[
				'label' => esc_html__('Height', 'ube'),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1200,
						'step' => 1,
					],
				],
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .ube-contact-form-7 .wpcf7-form input[type="submit"]' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'button_border_radius',
			[
				'label' => esc_html__('Border Radius', 'ube'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .ube-contact-form-7 .wpcf7-form input[type="submit"]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'button_padding',
			[
				'label' => esc_html__('Padding', 'ube'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .ube-contact-form-7 .wpcf7-form input[type="submit"]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'button_margin',
			[
				'label' => esc_html__('Margin Top', 'ube'),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .ube-contact-form-7 .wpcf7-form input[type="submit"]' => 'margin-top: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'button_typography',
				'label' => esc_html__('Typography', 'ube'),

				'selector' => '{{WRAPPER}} .ube-contact-form-7 .wpcf7-form input[type="submit"]',
				'separator' => 'before',
			]
		);

		$this->start_controls_tabs('tabs_button_style');

		$this->start_controls_tab(
			'tab_button_normal',
			[
				'label' => esc_html__('Normal', 'ube'),
			]
		);

		$this->add_control(
			'button_bg_color_normal',
			[
				'label' => esc_html__('Background Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .ube-contact-form-7 .wpcf7-form input[type="submit"]' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'button_text_color_normal',
			[
				'label' => esc_html__('Text Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .ube-contact-form-7 .wpcf7-form input[type="submit"]' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'button_border_normal',
				'label' => esc_html__('Border', 'ube'),
				'default' => '1px',
				'selector' => '{{WRAPPER}} .ube-contact-form-7 .wpcf7-form input[type="submit"]',
			]
		);


		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'button_box_shadow',
				'selector' => '{{WRAPPER}} .ube-contact-form-7 .wpcf7-form input[type="submit"]',
				'separator' => 'before',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_hover',
			[
				'label' => esc_html__('Hover', 'ube'),
			]
		);

		$this->add_control(
			'button_bg_color_hover',
			[
				'label' => esc_html__('Background Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .ube-contact-form-7 .wpcf7-form input[type="submit"]:hover' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'button_text_color_hover',
			[
				'label' => esc_html__('Text Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .ube-contact-form-7 .wpcf7-form input[type="submit"]:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'button_border_color_hover',
			[
				'label' => esc_html__('Border Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .ube-contact-form-7 .wpcf7-form input[type="submit"]:hover' => 'border-color: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'button_box_shadow_hover',
				'selector' => '{{WRAPPER}} .ube-contact-form-7 .wpcf7-form input[type="submit"]:hover',
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'button_opacity',
			[
				'label' => esc_html__('Opacity', 'ube'),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'size_units' => [],
				'selectors' => [
					'{{WRAPPER}} .ube-contact-form-7 .wpcf7-form input[type="submit"]:hover' => 'opacity: {{SIZE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	private function section_error_style()
	{
		$this->start_controls_section(
			'section_error_style',
			[
				'label' => esc_html__('Errors', 'ube'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'error_messages_heading',
			[
				'label' => esc_html__('Error Messages', 'ube'),
				'type' => Controls_Manager::HEADING,
				'condition' => [
					'error_messages' => 'show',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'error_messages_typography',
				'label' => esc_html__('Typography', 'ube'),

				'selector' => '{{WRAPPER}} .ube-contact-form-7 .wpcf7-not-valid-tip',
				'separator' => 'before',
				'condition' => [
					'error_messages' => 'show',
				],
			]
		);

		$this->start_controls_tabs('tabs_error_messages_style');

		$this->start_controls_tab(
			'tab_error_messages_alert',
			[
				'label' => esc_html__('Alert', 'ube'),
				'condition' => [
					'error_messages' => 'show',
				],
			]
		);

		$this->add_control(
			'error_alert_text_color',
			[
				'label' => esc_html__('Text Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .ube-contact-form-7 .wpcf7-not-valid-tip' => 'color: {{VALUE}}',
				],
				'condition' => [
					'error_messages' => 'show',
				],
			]
		);

		$this->add_responsive_control(
			'error_alert_spacing',
			[
				'label' => esc_html__('Spacing', 'ube'),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .ube-contact-form-7 .wpcf7-not-valid-tip' => 'margin-top: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'error_messages' => 'show',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_error_messages_fields',
			[
				'label' => esc_html__('Fields', 'ube'),
				'condition' => [
					'error_messages' => 'show',
				],
			]
		);

		$this->add_control(
			'error_field_bg_color',
			[
				'label' => esc_html__('Background Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .ube-contact-form-7 .wpcf7-form-control:not(.wpcf7-checkbox).wpcf7-not-valid' => 'background: {{VALUE}}!important',
				],
				'condition' => [
					'error_messages' => 'show',
				],
			]
		);

		$this->add_control(
			'error_field_color',
			[
				'label' => esc_html__('Text Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .ube-contact-form-7 .wpcf7-form-control:not(.wpcf7-checkbox).wpcf7-not-valid' => 'color: {{VALUE}}!important',
				],
				'condition' => [
					'error_messages' => 'show',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'error_field_border',
				'label' => esc_html__('Border', 'ube'),
				'placeholder' => '1px',
				'default' => '1px',
				'selector' => '{{WRAPPER}} .wpcf7-form-control:not(.wpcf7-checkbox).wpcf7-not-valid',
				'separator' => 'before',
				'condition' => [
					'error_messages' => 'show',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'validation_errors_heading',
			[
				'label' => esc_html__('Validation Errors', 'ube'),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'validation_errors' => 'show',
				],
			]
		);

		$this->add_control(
			'validation_errors_bg_color',
			[
				'label' => esc_html__('Background Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .ube-contact-form-7 .wpcf7-validation-errors' => 'background: {{VALUE}}',
				],
				'condition' => [
					'validation_errors' => 'show',
				],
			]
		);

		$this->add_control(
			'validation_errors_color',
			[
				'label' => esc_html__('Text Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .ube-contact-form-7 .wpcf7-validation-errors' => 'color: {{VALUE}}',
				],
				'condition' => [
					'validation_errors' => 'show',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'validation_errors_typography',
				'label' => esc_html__('Typography', 'ube'),

				'selector' => '{{WRAPPER}} .ube-contact-form-7 .wpcf7-validation-errors',
				'separator' => 'before',
				'condition' => [
					'validation_errors' => 'show',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'validation_errors_border',
				'label' => esc_html__('Border', 'ube'),
				'placeholder' => '1px',
				'default' => '1px',
				'selector' => '{{WRAPPER}} .ube-contact-form-7 .wpcf7-validation-errors',
				'separator' => 'before',
				'condition' => [
					'validation_errors' => 'show',
				],
			]
		);

		$this->add_responsive_control(
			'validation_errors_margin',
			[
				'label' => esc_html__('Margin', 'ube'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .ube-contact-form-7 .wpcf7-validation-errors' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'validation_errors' => 'show',
				],
			]
		);

		$this->end_controls_section();
	}

	private function section_after_feedback()
	{
		$this->start_controls_section(
			'section_after_submit_feedback_style',
			[
				'label' => esc_html__('After Submit Feedback', 'ube'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'contact_form_after_submit_feedback_typography',
				'label' => esc_html__('Typography', 'ube'),
				'selector' => '{{WRAPPER}} .ube-contact-form-7 .wpcf7-response-output',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'contact_form_after_submit_feedback_color',
			[
				'label' => esc_html__('Text Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .ube-contact-form-7 .wpcf7-response-output' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'contact_form_after_submit_feedback_background',
				'label' => esc_html__('Background', 'ube'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .ube-contact-form-7 .wpcf7-response-output',
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'contact_form_after_submit_feedback_border',
				'label' => esc_html__('Border', 'ube'),
				'placeholder' => '1px',
				'default' => '1px',
				'selector' => '{{WRAPPER}} .ube-contact-form-7 .wpcf7-response-output',
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'contact_form_after_submit_feedback_border_radius',
			[
				'label' => esc_html__('Radius', 'ube'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px', 'em', '%'],
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 1500,
					],
					'em' => [
						'min' => 1,
						'max' => 80,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ube-contact-form-7 .wpcf7-response-output' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'contact_form_after_submit_feedback_border_margin',
			[
				'label' => esc_html__('Margin', 'ube'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .ube-contact-form-7 .wpcf7-response-output' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'contact_form_after_submit_feedback_border_padding',
			[
				'label' => esc_html__('Padding', 'ube'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .ube-contact-form-7 .wpcf7-response-output' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();
	}


	protected function render()
	{

		ube_get_template('elements/contact-form-7.php', array(
			'element' => $this
		));

	}
}