<?php
if (!defined('ABSPATH')) {
	exit;
}

use \Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Border;
use Elementor\Group_Control_Image_Size;

class UBE_Element_Testimonial extends UBE_Abstracts_Elements
{
	public function get_name()
	{
		return 'ube-testimonial';
	}

	public function get_title()
	{
		return esc_html__('Testimonial', 'ube');
	}

	public function get_ube_icon()
	{
		return 'eicon-testimonial';
	}

	public function get_ube_keywords()
	{
		return array('testimonial','ube', 'blockquote' , 'ube', 'ube testimonial');
	}

	protected function register_controls() {
		$this->register_content_section_controls();
		$this->register_style_section_controls();
	}

	protected function register_content_section_controls() {
		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__('Testimonial','ube')
			]
		);

		$this->add_control(
			'testimonial_layout',
			[
				'label' => esc_html__('Layout', 'ube'),
				'type' => Controls_Manager::SELECT,
				'default' => 'layout-01',
				'label_block' => false,
				'options' => ube_get_testimonials_style(),
			]
		);

		$this->add_control('testimonial_client_say', [
			'label' => esc_html__('Content', 'ube'),
			'default' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'ube'),
			'type' => Controls_Manager::TEXTAREA,
			'rows' => '10',
			'dynamic' => [
				'active' => true,
			],
		]);

		$this->add_control(
			'testimonial_avatar',
			[
				'label' => esc_html__('Choose Image', 'ube'),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'testimonial_avatar_size',
				'default' => 'full',
				'separator' => 'none',
				'condition' => [
					'testimonial_avatar[url]!' => '',
				],
			]
		);

		$this->add_control('testimonial_author_name', [
			'label' => esc_html__('Name', 'ube'),
			'type' => Controls_Manager::TEXT,
			'dynamic' => [
				'active' => true,
			],
			'default' => esc_html__('John Doe', 'ube'),
		]);

		$this->add_control('testimonial_author_job', [
			'label' => esc_html__('Position', 'ube'),
			'type' => Controls_Manager::TEXT,
			'dynamic' => [
				'active' => true,
			],
			'default' => esc_html__('Designer', 'ube'),
		]);

		$this->add_control('testimonial_rating',
			[
				'label' => esc_html__('Star', 'ube'),
				'type' => Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 5,
				'step' => 1,
				'default' => '',
			]
		);

		$this->add_responsive_control(
			'testimonial_text_align',
			[
				'label' => esc_html__('Alignment', 'ube'),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__('Left', 'ube'),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__('Center', 'ube'),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__('Right', 'ube'),
						'icon' => 'eicon-text-align-right',
					],
				],
				'prefix_class' => 'elementor%s-align-',
				'default' => 'center',
				'condition' => [
					'testimonial_layout!' => apply_filters('ube_testimonials_text_align_condition', array('layout-07')),
				],
			]
		);

		$this->add_control(
			'testimonial_enable_quote',
			[
				'label' => esc_html__('Content Quote', 'ube'),
				'type' => Controls_Manager::SWITCHER,
				'default' => '',
				'return_value' => 'yes',
				'separator' => 'before',
			]
		);



		$this->end_controls_section();
	}

	protected function register_style_section_controls() {
		$this->register_style_content_section_controls();
		$this->register_style_image_section_controls();
		$this->register_style_name_section_controls();
		$this->register_style_position_section_controls();
		$this->register_style_rating_section_controls();
		$this->register_style_quote_section_controls();
	}

	protected function register_style_content_section_controls() {
		$this->start_controls_section(
			'section_style_content',
			[
				'label' => esc_html__('Content','ube'),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'testimonial_client_say!' => '',
				]
			]
		);

		$this->add_control(
			'testimonial_client_text_color',
			[
				'label' => esc_html__( 'Text Color', 'ube' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .ube-testimonial-client-say' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'testimonial_client_typography',
				'selector' => '{{WRAPPER}} .ube-testimonial-client-say',
			]
		);


		$this->add_control('testimonial_client_class',[
			'label' => esc_html__('Custom Class','ube'),
			'type' => Controls_Manager::TEXT,
			'default' => '',
		]);

		$this->add_responsive_control(
			'testimonial_client_margin',
			[
				'label' => esc_html__('Margin', 'ube'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors' => [
					'{{WRAPPER}} .ube-testimonial-client-say' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'testimonial_enable_background',
			[
				'label' => esc_html__('Content Background', 'ube'),
				'type' => Controls_Manager::SWITCHER,
				'default' => '',
				'return_value' => 'yes',
				'separator' => 'before',
				'condition' => [
					'testimonial_layout!' => 'layout-07',
				],
			]
		);

		$this->add_control(
			'testimonial_content_background',
			[
				'label' => esc_html__('Background Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-testimonial' => '--ube-testimonial-bg-content: {{VALUE}};',
				],
				'conditions' => [
					'relation' => 'and',
					'terms' => [
						[
							'name' => 'testimonial_layout',
							'operator' => '!in',
							'value' => [
								'layout-07',
							],
						],
						[
							'name' => 'testimonial_enable_background',
							'operator' => 'in',
							'value' => [
								'yes',
							],
						],
					],
				],
			]
		);

		$this->add_responsive_control(
			'testimonial_content_padding',
			[
				'label' => esc_html__('Padding', 'ube'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors' => [
					'{{WRAPPER}} .ube-testimonial-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'conditions' => [
					'relation' => 'and',
					'terms' => [
						[
							'name' => 'testimonial_layout',
							'operator' => '!in',
							'value' => [
								'layout-07',
							],
						],
						[
							'name' => 'testimonial_enable_background',
							'operator' => 'in',
							'value' => [
								'yes',
							],
						],
					],
				],
			]
		);

		$this->add_responsive_control(
			'testimonial_content_margin',
			[
				'label' => esc_html__('Margin', 'ube'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors' => [
					'{{WRAPPER}} .ube-testimonial-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'conditions' => [
					'relation' => 'and',
					'terms' => [
						[
							'name' => 'testimonial_layout',
							'operator' => '!in',
							'value' => [
								'layout-07',
							],
						],
						[
							'name' => 'testimonial_enable_background',
							'operator' => 'in',
							'value' => [
								'yes',
							],
						],
					],
				],
			]
		);

		$this->add_control(
			'testimonial_content_radius',
			[
				'label' => esc_html__('Border Radius', 'ube'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .ube-testimonial-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'conditions' => [
					'relation' => 'and',
					'terms' => [
						[
							'name' => 'testimonial_layout',
							'operator' => '!in',
							'value' => [
								'layout-07',
							],
						],
						[
							'name' => 'testimonial_enable_background',
							'operator' => 'in',
							'value' => [
								'yes',
							],
						],
					],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'testimonial_content_box_shadow',
				'selector' => '{{WRAPPER}} .ube-testimonial-content',
				'conditions' => [
					'relation' => 'and',
					'terms' => [
						[
							'name' => 'testimonial_layout',
							'operator' => '!in',
							'value' => [
								'layout-07',
							],
						],
						[
							'name' => 'testimonial_enable_background',
							'operator' => 'in',
							'value' => [
								'yes',
							],
						],
					],
				],
			]
		);

		$this->end_controls_section();
	}

	protected function register_style_name_section_controls() {
		$this->start_controls_section(
			'section_style_name',
			[
				'label' => esc_html__('Name','ube'),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'testimonial_author_name!' => '',
				]
			]
		);

		$this->add_control(
			'testimonial_name_text_color',
			[
				'label' => esc_html__('Text Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .ube-testimonial-author-name' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'testimonial_name_typography',
				'selector' => '{{WRAPPER}} .ube-testimonial-author-name',
			]
		);

		$this->add_control('testimonial_name_class',[
			'label' => esc_html__('Custom Class','ube'),
			'type' => Controls_Manager::TEXT,
			'default' => '',
		]);

		$this->add_responsive_control(
			'testimonial_name_margin',
			[
				'label' => esc_html__('Margin', 'ube'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors' => [
					'{{WRAPPER}} .ube-testimonial-author-name' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

	}

	protected function register_style_image_section_controls() {
		$this->start_controls_section('section_style_image', [
			'label' => esc_html__('Image', 'ube'),
			'tab' => Controls_Manager::TAB_STYLE,
			'condition' => [
				'testimonial_avatar[url]!' => '',
			]
		]);

		$this->add_responsive_control('testimonial_image_width', [
			'label' => esc_html__('Width', 'ube'),
			'type' => Controls_Manager::SLIDER,
			'size_units' => ['px'],
			'range' => [
				'px' => [
					'min' => 1,
					'max' => 1000,
				],
			],
			'selectors' => [
				'{{WRAPPER}} .ube-testimonial' => '--ube-testimonial-author-width: {{SIZE}}{{UNIT}};',
			],
		]);

		$this->add_responsive_control('testimonial_image_height', [
			'label' => esc_html__('Height', 'ube'),
			'type' => Controls_Manager::SLIDER,
			'size_units' => ['px'],
			'range' => [
				'px' => [
					'min' => 1,
					'max' => 1000,
				],
			],
			'selectors' => [
				'{{WRAPPER}} .ube-testimonial' => '--ube-testimonial-author-height: {{SIZE}}{{UNIT}};',
			],
		]);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'testimonial_image_border_type',
				'label' => esc_html__('Border Type', 'ube'),
				'selector' => '{{WRAPPER}} .ube-testimonial-avatar img, {{WRAPPER}} .ube-testimonial-avatar .g5core__lazy-image',
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'testimonial_image_border_radius',
			[
				'label' => esc_html__('Border Radius', 'ube'),
				'type' => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .ube-testimonial-avatar img, {{WRAPPER}} .ube-testimonial-avatar .g5core__lazy-image' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
				],
			]
		);

		$this->add_responsive_control(
			'testimonial_image_margin',
			[
				'label' => esc_html__('Margin', 'ube'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors' => [
					'{{WRAPPER}} .ube-testimonial-avatar' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);


		$this->end_controls_section();

	}

	protected function register_style_position_section_controls() {
		$this->start_controls_section('section_style_position', [
			'label' => esc_html__('Position', 'ube'),
			'tab' => Controls_Manager::TAB_STYLE,
			'condition' => [
				'testimonial_author_job!' => '',
			]
		]);

		$this->add_control(
			'testimonial_job_text_color',
			[
				'label' => esc_html__('Text color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .ube-testimonial-author-job' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'testimonial_job_typography',
				'selector' => '{{WRAPPER}} .ube-testimonial-author-job',
			]
		);

		$this->add_control('testimonial_job_class',[
			'label' => esc_html__('Custom Class','ube'),
			'type' => Controls_Manager::TEXT,
			'default' => '',
		]);

		$this->add_responsive_control(
			'testimonial_job_margin',
			[
				'label' => esc_html__('Margin', 'ube'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors' => [
					'{{WRAPPER}} .ube-testimonial-author-job' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function register_style_quote_section_controls() {
		$this->start_controls_section('section_style_quote', [
			'label' => esc_html__('Quote', 'ube'),
			'tab' => Controls_Manager::TAB_STYLE,
			'condition' => [
				'testimonial_enable_quote' => 'yes',
			],
		]);

		$this->add_responsive_control('testimonial_quote_size', [
			'label' => esc_html__('Quote Size', 'ube'),
			'type' => Controls_Manager::SLIDER,
			'size_units' => ['px'],
			'range' => [
				'px' => [
					'min' => 1,
					'max' => 100,
				],
			],
			'selectors' => [
				'{{WRAPPER}} .ube-testimonial-content.ube-testimonial-is-quote .ube-testimonial-client-say:before,{{WRAPPER}} .ube-testimonial-content.ube-testimonial-is-quote .ube-testimonial-client-say:after' => 'font-size: {{SIZE}}{{UNIT}};',
			],
		]);

		$this->add_responsive_control('testimonial_quote_spacing', [
			'label' => esc_html__('Quote Spacing', 'ube'),
			'type' => Controls_Manager::SLIDER,
			'size_units' => ['px'],
			'range' => [
				'px' => [
					'min' => -200,
					'max' => 200,
				],
			],
			'selectors' => [
				'{{WRAPPER}} .ube-testimonial-content.ube-testimonial-is-quote .ube-testimonial-client-say:before' => 'left: {{SIZE}}{{UNIT}};',
				'{{WRAPPER}} .ube-testimonial-content.ube-testimonial-is-quote .ube-testimonial-client-say:after' => 'right: {{SIZE}}{{UNIT}};',
			],
		]);

		$this->add_control(
			'testimonial_quote_color',
			[
				'label' => esc_html__('Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .ube-testimonial-content.ube-testimonial-is-quote .ube-testimonial-client-say:before,{{WRAPPER}} .ube-testimonial-content.ube-testimonial-is-quote .ube-testimonial-client-say:after' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'testimonial_quote_padding',
			[
				'label' => esc_html__('Padding', 'ube'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors' => [
					'{{WRAPPER}} .ube-testimonial-content.ube-testimonial-is-quote .ube-testimonial-client-say' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function register_style_rating_section_controls() {
		$this->start_controls_section('section_style_rating', [
			'label' => esc_html__('Rating', 'ube'),
			'tab' => Controls_Manager::TAB_STYLE,
			'condition' => [
				'testimonial_rating!' => '',
			]
		]);

		$this->add_control(
			'testimonial_rating_color',
			[
				'label' => esc_html__('Rating Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .ube-testimonial-rating svg' => 'color: {{VALUE}};',
				]
			]
		);

		$this->add_responsive_control(
			'testimonial_rating_margin',
			[
				'label' => esc_html__('Margin', 'ube'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors' => [
					'{{WRAPPER}} .ube-testimonial-rating' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	public function render()
	{
		$settings          = $this->get_settings_for_display();
		$layout = isset($settings['testimonial_layout']) ? $settings['testimonial_layout'] : 'layout-01';
		$enable_quote = isset($settings['testimonial_enable_quote']) ? $settings['testimonial_enable_quote'] : '';
		$enable_background = isset($settings['testimonial_enable_background']) ? $settings['testimonial_enable_background'] : '';
		$rating = isset($settings['testimonial_rating']) ? $settings['testimonial_rating'] : '';
		$testimonial_client_say = isset($settings['testimonial_client_say']) ? $settings['testimonial_client_say'] : '';
		$testimonial_author_name = isset($settings['testimonial_author_name']) ? $settings['testimonial_author_name'] : '';
		$testimonial_author_job = isset($settings['testimonial_author_job']) ? $settings['testimonial_author_job'] : '';


		$client_say_class = isset($settings['testimonial_client_class']) ? $settings['testimonial_client_class'] : '';
		$author_name_class = isset($settings['testimonial_name_class']) ? $settings['testimonial_name_class'] : '';
		$author_job_class = isset($settings['testimonial_job_class']) ? $settings['testimonial_job_class'] : '';

		$image_html = '';
		if (isset($settings['testimonial_avatar'])) {
			$image_html =  Group_Control_Image_Size::get_attachment_image_html( $settings, 'testimonial_avatar_size', 'testimonial_avatar' );
		}

		ube_get_template('elements/testimonial.php', array(
			'element' => $this,
			'layout' => $layout,
			'enable_quote' => $enable_quote,
			'enable_background' => $enable_background,
			'rating' => $rating,
			'client_say' => $testimonial_client_say,
			'author_name' => $testimonial_author_name,
			'author_job' => $testimonial_author_job,
			'image_html' => $image_html,
			'client_say_class' => $client_say_class,
			'author_name_class' => $author_name_class,
			'author_job_class' => $author_job_class,
		));
	}


}