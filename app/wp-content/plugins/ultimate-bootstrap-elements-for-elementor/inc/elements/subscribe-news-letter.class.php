<?php
if (!defined('ABSPATH')) {
	exit;
}

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Background;

class UBE_Element_Subscribe_News_Letter extends UBE_Abstracts_Elements
{
	public static function is_enabled() {
		return function_exists('_mc4wp_load_plugin');
	}

	public function get_name()
	{
		return 'ube-subscribe-news-letter';
	}

	public function get_title()
	{
		return esc_html__('Subscribe News Letter', 'ube');
	}

	public function get_ube_icon()
	{
		return 'eicon-mailchimp';
	}

	public function get_ube_keywords()
	{
		return array('subscribe news letter', 'ube','mailchimp');
	}

	protected function register_controls()
	{

		if (is_plugin_active('mailchimp-for-wp/mailchimp-for-wp.php') === false) {

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
					'raw' => wp_kses_post(__('<strong>Mailchimp for WordPress</strong> is not installed/activated on your site. Please install and activate <strong>Mailchimp for WordPress</strong> first.', 'ube')),
					'content_classes' => 'ube-warning',
				]
			);

			$this->end_controls_section();

		} else {

			/**
			 * Content Tab: Subscribe News Letter
			 * -------------------------------------------------
			 */
			$this->snl_section_content();


			/**
			 * Style Tab: Wrapper
			 * -------------------------------------------------
			 */
			$this->snl_wrapper_section_style();

			/**
			 * Style Tab: Input Box
			 * -------------------------------------------------
			 */
			$this->snl_input_box_section_style();

			/**
			 * Style Tab: Submit
			 * -------------------------------------------------
			 */
			$this->snl_submit_section_style();

			/**
			 * Style Tab: Label
			 * -------------------------------------------------
			 */
			$this->snl_section_label_style();

			/**
			 * Style Tab: Label
			 * -------------------------------------------------
			 */
			$this->snl_section_response_style();
		}
	}

	private function snl_section_content()
	{
		$this->start_controls_section('snl_section_content', [
			'label' => esc_html__('Subscribe News Letter', 'ube'),
			'tab' => Controls_Manager::TAB_CONTENT,
		]);

		$this->add_control(
			'snl_id',
			[
				'label' => esc_html__('Mailchimp ID', 'ube'),
				'type' => Controls_Manager::TEXT,
				'placeholder' => esc_html__('Enter ID', 'ube'),
				'description' => wp_kses_post(__('For show ID <a href="admin.php?page=mailchimp-for-wp-forms" target="_blank"> Click here </a>', 'ube')),
				'label_block' => true,
				'separator' => 'before',
			]
		);

		$this->end_controls_section();
	}

	private function snl_wrapper_section_style()
	{
		$this->start_controls_section('snl_wrapper_style_section', [
			'tab' => Controls_Manager::TAB_STYLE,
			'label' => esc_html__('Wrapper', 'ube'),
		]);

		$this->add_responsive_control(
			'snl_wrapper_max_width',
			[
				'label' => esc_html__('Max Width', 'ube'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'max' => 1000,
						'min' => 0,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ube-subscribe-news-letter' => 'max-width: {{SIZE}}{{UNIT}}; -webkit-box-flex:{{SIZE}}{{UNIT}}; -ms-flex:70px; flex:{{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control('snl_alignment', [
			'label' => esc_html__('Alignment', 'ube'),
			'type' => Controls_Manager::CHOOSE,
			'options' => [
				'flex-start' => [
					'title' => esc_html__('Left', 'ube'),
					'icon' => 'eicon-h-align-left',
				],
				'center' => [
					'title' => esc_html__('Center', 'ube'),
					'icon' => 'eicon-h-align-center',
				],
				'flex-end' => [
					'title' => esc_html__('Right', 'ube'),
					'icon' => 'eicon-h-align-right',
				],
			],
			'selectors' => [
				'{{WRAPPER}} .elementor-widget-container' => 'display: -webkit-box; display: -ms-flexbox ; display: flex; -webkit-box-pack:{{VALUE}};-ms-flex-pack:{{VALUE}};justify-content:{{VALUE}}',
			],
		]);
		$this->end_controls_section();
	}

	private function snl_input_box_section_style()
	{

		$this->start_controls_section('snl_input_box_section_style', [
			'label' => esc_html__('Input Box', 'ube'),
			'tab' => Controls_Manager::TAB_STYLE,
		]);

		$this->add_responsive_control(
			'snl_input_box_height',
			[
				'label' => esc_html__('Height', 'ube'),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 150,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .mc4wp-form input[type*="text"]' => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .ube-subscribe-news-letter.layout-02 .mc4wp-form-fields' => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .mc4wp-form input[type*="email"]' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'snl_input_box_width',
			[
				'label' => esc_html__('Width', 'ube'),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 1000,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .mc4wp-form input[type*="email"]' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'snl_input_box_background',
			[
				'label' => esc_html__('Background Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mc4wp-form input[type*="text"]' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .mc4wp-form input[type*="email"]' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .mc4wp-form select[name*="_mc4wp_lists"]' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'snl_input_box_text_color',
			[
				'label' => esc_html__('Text Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mc4wp-form input[type*="text"]' => 'color: {{VALUE}};',
					'{{WRAPPER}} .mc4wp-form input[type*="email"]' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'snl_input_box_placeholder_color',
			[
				'label' => esc_html__('Placeholder Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mc4wp-form input[type*="text"]::-webkit-input-placeholder' => 'color: {{VALUE}};',
					'{{WRAPPER}} .mc4wp-form input[type*="text"]::-moz-placeholder' => 'color: {{VALUE}};',
					'{{WRAPPER}} .mc4wp-form input[type*="text"]:-ms-input-placeholder' => 'color: {{VALUE}};',
					'{{WRAPPER}} .mc4wp-form input[type*="email"]::-webkit-input-placeholder' => 'color: {{VALUE}};',
					'{{WRAPPER}} .mc4wp-form input[type*="email"]::-moz-placeholder' => 'color: {{VALUE}};',
					'{{WRAPPER}} .mc4wp-form input[type*="email"]:-ms-input-placeholder' => 'color: {{VALUE}};',
					'{{WRAPPER}} .mc4wp-form select[name*="_mc4wp_lists"]' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'snl_input_typography',
				'selector' => '{{WRAPPER}} .mc4wp-form input[type*="email"],{{WRAPPER}} .mc4wp-form input[type*="email"]',
			]
		);

		$this->start_controls_tabs('snl_input_box_style_tabs');

		$this->start_controls_tab(
			'snl_input_box_style_normal_tab',
			[
				'label' => esc_html__('Normal', 'ube'),
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'snl_input_box_border',
				'label' => esc_html__('Border', 'ube'),
				'selector' => '{{WRAPPER}} .mc4wp-form input[type*="email"]',
			]
		);

		$this->add_responsive_control(
			'snl_input_box_border_radius',
			[
				'label' => esc_html__('Border Radius', 'ube'),
				'type' => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .mc4wp-form input[type*="text"]' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
					'{{WRAPPER}} .mc4wp-form input[type*="email"]' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'snl_input_box_style_focus_tab',
			[
				'label' => esc_html__('Focus', 'ube'),
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'snl_input_box_border_focus',
				'label' => esc_html__('Border', 'ube'),
				'selector' => '{{WRAPPER}} .mc4wp-form input[type*="email"]:focus',
			]
		);

		$this->add_responsive_control(
			'snl_input_box_border_radius_focus',
			[
				'label' => esc_html__('Border Radius', 'ube'),
				'type' => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .mc4wp-form input[type*="text"]:focus' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
					'{{WRAPPER}} .mc4wp-form input[type*="email"]:focus' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'snl_input_box_padding',
			[
				'label' => esc_html__('Padding', 'ube'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors' => [
					'{{WRAPPER}} .mc4wp-form input[type*="text"]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .mc4wp-form input[type*="email"]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'snl_input_box_margin',
			[
				'label' => esc_html__('Margin', 'ube'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors' => [
					'{{WRAPPER}} .mc4wp-form input[type*="text"]' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .mc4wp-form input[type*="email"]' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();
	}

	private function snl_submit_section_style()
	{
		$this->start_controls_section(
			'snl_mailchimp_input_submit_style',
			[
				'label' => esc_html__('Button', 'ube'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs('snl_submit_style_tabs');

		$this->start_controls_tab(
			'snl_submit_style_normal_tab',
			[
				'label' => esc_html__('Normal', 'ube'),
			]
		);

		$this->add_responsive_control(
			'snl_input_submit_height',
			[
				'label' => esc_html__('Height', 'ube'),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 150,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .mc4wp-form [type*="submit"]' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'snl_input_submit_width',
			[
				'label' => esc_html__('Width', 'ube'),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 1000,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .mc4wp-form [type*="submit"]' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'snl_input_submit_typography',
				'selector' => '{{WRAPPER}} .mc4wp-form [type*="submit"]',
			]
		);

		$this->add_control(
			'snl_input_submit_text_color',
			[
				'label' => esc_html__('Text Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mc4wp-form [type*="submit"]' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'snl_input_submit_background_color',
			[
				'label' => esc_html__('Background Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mc4wp-form [type="submit"]' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'snl_input_submit_padding',
			[
				'label' => esc_html__('Padding', 'ube'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors' => [
					'{{WRAPPER}} .mc4wp-form [type*="submit"]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'snl_input_submit_margin',
			[
				'label' => esc_html__('Margin', 'ube'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors' => [
					'{{WRAPPER}} .mc4wp-form [type*="submit"]' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'snl_input_submit_border',
				'label' => esc_html__('Border', 'ube'),
				'selector' => '{{WRAPPER}} .mc4wp-form [type*="submit"]',
			]
		);

		$this->add_responsive_control(
			'snl_input_submit_border_radius',
			[
				'label' => esc_html__('Border Radius', 'ube'),
				'type' => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .mc4wp-form [type*="submit"]' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'snl_input_submit_box_shadow',
				'label' => esc_html__('Box Shadow', 'ube'),
				'selector' => '{{WRAPPER}} .mc4wp-form [type*="submit"]',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'snl_submit_style_hover_tab',
			[
				'label' => esc_html__('Hover', 'ube'),
			]
		);

		$this->add_control(
			'snl_input_submit_hover_text_color',
			[
				'label' => esc_html__('Text Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mc4wp-form [type*="submit"]:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'snl_input_submit_hover_background_color',
			[
				'label' => esc_html__('Background Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mc4wp-form [type*="submit"]:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'snl_input_submit_hover_border',
				'label' => esc_html__('Border', 'ube'),
				'selector' => '{{WRAPPER}} .mc4wp-form [type*="submit"]:hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	private function snl_section_label_style()
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
					'{{WRAPPER}} .ube-subscribe-news-letter label' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'snl_typography_label',
				'label' => esc_html__('Typography', 'ube'),

				'selector' => '{{WRAPPER}} .ube-subscribe-news-letter label',
			]
		);

		$this->end_controls_section();
	}

	private function snl_section_response_style()
	{
		$this->start_controls_section(
			'snl_section_response_style',
			[
				'label' => esc_html__('Response', 'ube'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'snl_text_color_response',
			[
				'label' => esc_html__('Text Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-subscribe-news-letter .mc4wp-form-error .mc4wp-response' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'snl_typography_response',
				'label' => esc_html__('Typography', 'ube'),
				'selector' => '{{WRAPPER}} .ube-subscribe-news-letter .mc4wp-form-error .mc4wp-form-error .mc4wp-response',
			]
		);

		$this->end_controls_section();
	}

	public function render()
	{
		ube_get_template('elements/subscribe-news-letter.php', array(
			'element' => $this
		));
	}
}