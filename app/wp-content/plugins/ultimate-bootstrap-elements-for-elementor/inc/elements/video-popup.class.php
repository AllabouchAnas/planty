<?php
if (!defined('ABSPATH')) {
	exit;
}

use \Elementor\Controls_Manager;
use Elementor\Embed;
use \Elementor\Group_Control_Border;
use Elementor\Group_Control_Css_Filter;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Background;
use Elementor\Modules\DynamicTags\Module as TagsModule;

class UBE_Element_Video_Popup extends UBE_Abstracts_Elements
{
	public function get_name()
	{
		return 'ube-popup-video';
	}

	public function get_title()
	{
		return esc_html__('Popup Video', 'ube');
	}

	public function get_ube_icon()
	{
		return 'eicon-play-o';
	}

	public function get_ube_keywords()
	{
		return array('video' , 'ube', 'ube video');
	}

	protected function register_controls()
	{
		$this->start_controls_section(
			'section_video',
			[
				'label' => esc_html__('Video Popup', 'ube'),
			]
		);

		$this->add_control(
			'video_type',
			[
				'label' => esc_html__('Source', 'ube'),
				'type' => Controls_Manager::SELECT,
				'default' => 'youtube',
				'options' => [
					'youtube' => esc_html__('YouTube', 'ube'),
					'vimeo' => esc_html__('Vimeo', 'ube'),
					'dailymotion' => esc_html__('Dailymotion', 'ube'),
					'hosted' => esc_html__('Self Hosted', 'ube'),
				],
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'youtube_url',
			[
				'label' => esc_html__('Link', 'ube'),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
					'categories' => [
						TagsModule::POST_META_CATEGORY,
						TagsModule::URL_CATEGORY,
					],
				],
				'placeholder' => esc_html__('Enter your URL', 'ube') . ' (YouTube)',
				'default' => 'https://www.youtube.com/watch?v=XHOmBV4js_E',
				'label_block' => true,
				'condition' => [
					'video_type' => 'youtube',
				],
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'vimeo_url',
			[
				'label' => esc_html__('Link', 'ube'),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
					'categories' => [
						TagsModule::POST_META_CATEGORY,
						TagsModule::URL_CATEGORY,
					],
				],
				'placeholder' => esc_html__('Enter your URL', 'ube') . ' (Vimeo)',
				'default' => 'https://vimeo.com/235215203',
				'label_block' => true,
				'condition' => [
					'video_type' => 'vimeo',
				],
			]
		);

		$this->add_control(
			'dailymotion_url',
			[
				'label' => esc_html__('Link', 'ube'),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
					'categories' => [
						TagsModule::POST_META_CATEGORY,
						TagsModule::URL_CATEGORY,
					],
				],
				'placeholder' => esc_html__('Enter your URL', 'ube') . ' (Dailymotion)',
				'default' => 'https://www.dailymotion.com/video/x6tqhqb',
				'label_block' => true,
				'condition' => [
					'video_type' => 'dailymotion',
				],
			]
		);

		$this->add_control(
			'insert_url',
			[
				'label' => esc_html__('External URL', 'ube'),
				'type' => Controls_Manager::SWITCHER,
				'condition' => [
					'video_type' => 'hosted',
				],
			]
		);

		$this->add_control(
			'hosted_url',
			[
				'label' => esc_html__('Choose File', 'ube'),
				'type' => Controls_Manager::MEDIA,
				'dynamic' => [
					'active' => true,
					'categories' => [
						TagsModule::MEDIA_CATEGORY,
					],
				],
				'media_type' => 'video',
				'condition' => [
					'video_type' => 'hosted',
					'insert_url' => '',
				],
			]
		);

		$this->add_control(
			'external_url',
			[
				'label' => esc_html__('URL', 'ube'),
				'type' => Controls_Manager::URL,
				'autocomplete' => false,
				'options' => false,
				'label_block' => true,
				'show_label' => false,
				'dynamic' => [
					'active' => true,
					'categories' => [
						TagsModule::POST_META_CATEGORY,
						TagsModule::URL_CATEGORY,
					],
				],
				'media_type' => 'video',
				'placeholder' => esc_html__('Enter your URL', 'ube'),
				'condition' => [
					'video_type' => 'hosted',
					'insert_url' => 'yes',
				],
			]
		);


		$this->add_control(
			'start',
			[
				'label' => esc_html__('Start Time', 'ube'),
				'type' => Controls_Manager::NUMBER,
				'description' => esc_html__('Specify a start time (in seconds)', 'ube'),
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'end',
			[
				'label' => esc_html__('End Time', 'ube'),
				'type' => Controls_Manager::NUMBER,
				'description' => esc_html__('Specify an end time (in seconds)', 'ube'),
				'condition' => [
					'video_type' => ['youtube', 'hosted'],
				],
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'video_options',
			[
				'label' => esc_html__('Video Options', 'ube'),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'mute',
			[
				'label' => esc_html__('Mute', 'ube'),
				'type' => Controls_Manager::SWITCHER,
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'loop',
			[
				'label' => esc_html__('Loop', 'ube'),
				'type' => Controls_Manager::SWITCHER,
				'condition' => [
					'video_type!' => 'dailymotion',
				],
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'controls',
			[
				'label' => esc_html__('Player Controls', 'ube'),
				'type' => Controls_Manager::SWITCHER,
				'label_off' => esc_html__('Hide', 'ube'),
				'label_on' => esc_html__('Show', 'ube'),
				'default' => 'yes',
				'condition' => [
					'video_type!' => 'vimeo',
				],
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'showinfo',
			[
				'label' => esc_html__('Video Info', 'ube'),
				'type' => Controls_Manager::SWITCHER,
				'label_off' => esc_html__('Hide', 'ube'),
				'label_on' => esc_html__('Show', 'ube'),
				'default' => 'yes',
				'condition' => [
					'video_type' => ['dailymotion'],
				],
			]
		);

		$this->add_control(
			'modestbranding',
			[
				'label' => esc_html__('Modest Branding', 'ube'),
				'type' => Controls_Manager::SWITCHER,
				'condition' => [
					'video_type' => ['youtube'],
					'controls' => 'yes',
				],
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'logo',
			[
				'label' => esc_html__('Logo', 'ube'),
				'type' => Controls_Manager::SWITCHER,
				'label_off' => esc_html__('Hide', 'ube'),
				'label_on' => esc_html__('Show', 'ube'),
				'default' => 'yes',
				'condition' => [
					'video_type' => ['dailymotion'],
				],
			]
		);

		// YouTube.
		$this->add_control(
			'yt_privacy',
			[
				'label' => esc_html__('Privacy Mode', 'ube'),
				'type' => Controls_Manager::SWITCHER,
				'description' => esc_html__('When you turn on privacy mode, YouTube won\'t store information about visitors on your website unless they play the video.', 'ube'),
				'condition' => [
					'video_type' => 'youtube',
				],
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'rel',
			[
				'label' => esc_html__('Suggested Videos', 'ube'),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'' => esc_html__('Current Video Channel', 'ube'),
					'yes' => esc_html__('Any Video', 'ube'),
				],
				'condition' => [
					'video_type' => 'youtube',
				],
			]
		);

		// Vimeo.
		$this->add_control(
			'vimeo_title',
			[
				'label' => esc_html__('Intro Title', 'ube'),
				'type' => Controls_Manager::SWITCHER,
				'label_off' => esc_html__('Hide', 'ube'),
				'label_on' => esc_html__('Show', 'ube'),
				'default' => 'yes',
				'condition' => [
					'video_type' => 'vimeo',
				],
			]
		);

		$this->add_control(
			'vimeo_portrait',
			[
				'label' => esc_html__('Intro Portrait', 'ube'),
				'type' => Controls_Manager::SWITCHER,
				'label_off' => esc_html__('Hide', 'ube'),
				'label_on' => esc_html__('Show', 'ube'),
				'default' => 'yes',
				'condition' => [
					'video_type' => 'vimeo',
				],
			]
		);

		$this->add_control(
			'vimeo_byline',
			[
				'label' => esc_html__('Intro Byline', 'ube'),
				'type' => Controls_Manager::SWITCHER,
				'label_off' => esc_html__('Hide', 'ube'),
				'label_on' => esc_html__('Show', 'ube'),
				'default' => 'yes',
				'condition' => [
					'video_type' => 'vimeo',
				],
			]
		);

		$this->add_control(
			'color',
			[
				'label' => esc_html__('Controls Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'video_type' => ['vimeo', 'dailymotion'],
				],
			]
		);

		$this->add_control(
			'download_button',
			[
				'label' => esc_html__('Download Button', 'ube'),
				'type' => Controls_Manager::SWITCHER,
				'label_off' => esc_html__('Hide', 'ube'),
				'label_on' => esc_html__('Show', 'ube'),
				'condition' => [
					'video_type' => 'hosted',
				],
			]
		);

		$this->add_control(
			'poster',
			[
				'label' => esc_html__('Poster', 'ube'),
				'type' => Controls_Manager::MEDIA,
				'dynamic' => [
					'active' => true,
				],
				'condition' => [
					'video_type' => 'hosted',
				],
			]
		);

		$this->add_control(
			'view',
			[
				'label' => esc_html__('View', 'ube'),
				'type' => Controls_Manager::HIDDEN,
				'default' => 'youtube',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_button_video',
			[
				'label' => esc_html__('Button', 'ube'),
			]
		);

		$this->add_control('video_text_button', [
			'label' => esc_html__('Text Button', 'ube'),
			'type' => Controls_Manager::TEXT,
			'default' => esc_html__('Play', 'ube'),
		]);

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

		$this->add_control(
			'video_button_icon',
			[
				'label' => esc_html__('Icon', 'ube'),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value'=>'fas fa-play',
					'library' => 'solid',
				],
			]
		);

		$this->add_control(
			'video_button_icon_align',
			[
				'label' => esc_html__('Icon Position', 'ube'),
				'type' => Controls_Manager::SELECT,
				'default' => 'before',
				'options' => [
					'before' => esc_html__('Before', 'ube'),
					'after' => esc_html__('After', 'ube'),
				],
				'condition' => [
					'video_button_icon[value]!' => '',
				],
			]
		);

		$this->add_control(
			'video_button_type',
			[
				'label' => esc_html__('Type', 'ube'),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'separator' => 'before',
				'options' => ube_get_button_styles(),
			]
		);

		$this->add_control(
			'video_button_scheme',
			[
				'label' => esc_html__('Scheme', 'ube'),
				'type' => Controls_Manager::SELECT,
				'options' => ube_get_color_schemes(false),
				'default' => 'primary',
				'condition' => [
					'video_button_type[value]!' => 'link',
				],
			]
		);

		$this->add_control(
			'video_button_shape',
			[
				'label' => esc_html__('Shape', 'ube'),
				'type' => Controls_Manager::SELECT,
				'default' => 'rounded',
				'options' => ube_get_button_shape(),
				'condition' => [
					'video_button_type[value]!' => 'link',
				],
			]
		);


		$this->add_control(
			'video_button_size',
			[
				'label' => esc_html__('Size', 'ube'),
				'type' => Controls_Manager::SELECT,
				'default' => 'md',
				'options' => ube_get_button_sizes(),
				'style_transfer' => true,
			]
		);


		$this->end_controls_section();

		$this->start_controls_section(
			'section_video_style',
			[
				'label' => esc_html__('Video', 'ube'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'aspect_ratio',
			[
				'label' => esc_html__('Aspect Ratio', 'ube'),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'56.25%' => '16:9',
					'42.8571%' => '21:9',
					'75%' => '4:3',
					'66.6666%' => '3:2',
					'100%' => '1:1',
					'177.8%' => '9:16',
				],
				'default' => '56.25%',
				'selectors' => [
					'#elementor-lightbox-{{ID}} .elementor-fit-aspect-ratio' => 'padding-bottom: {{VALUE}};',
				],
				'frontend_available' => true,
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' => 'css_filters',
				'selector' => '#elementor-lightbox-{{ID}} .elementor-video-container',
			]
		);


		$this->end_controls_section();

		$this->start_controls_section(
			'section_lightbox_style',
			[
				'label' => esc_html__('Lightbox', 'ube'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'lightbox_color',
			[
				'label' => esc_html__('Background Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'#elementor-lightbox-{{ID}}' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'lightbox_ui_color',
			[
				'label' => esc_html__('UI Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'#elementor-lightbox-{{ID}} .dialog-lightbox-close-button' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'lightbox_ui_color_hover',
			[
				'label' => esc_html__('UI Hover Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'#elementor-lightbox-{{ID}} .dialog-lightbox-close-button:hover' => 'color: {{VALUE}}',
				],
				'separator' => 'after',
			]
		);

		$this->add_control(
			'lightbox_video_width',
			[
				'label' => esc_html__('Content Width', 'ube'),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'unit' => '%',
				],
				'range' => [
					'%' => [
						'min' => 30,
					],
				],
				'selectors' => [
					'(desktop+)#elementor-lightbox-{{ID}} .elementor-video-container' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'lightbox_content_position',
			[
				'label' => esc_html__('Content Position', 'ube'),
				'type' => Controls_Manager::SELECT,
				'frontend_available' => true,
				'options' => [
					'' => esc_html__('Center', 'ube'),
					'top' => esc_html__('Top', 'ube'),
				],
				'selectors' => [
					'#elementor-lightbox-{{ID}} .elementor-video-container' => '{{VALUE}}; transform: translateX(-50%);',
				],
				'selectors_dictionary' => [
					'top' => 'top: 60px',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section('video_button_style_section', [
			'label' => esc_html__('Button', 'ube'),
			'tab' => Controls_Manager::TAB_STYLE,
		]);

		$this->add_control(
			'video_button_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'ube' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .ube-video-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'video_button_height',
			[
				'label'     => esc_html__( 'Height', 'ube' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ube-video-btn' => 'height: {{SIZE}}{{UNIT}};',
				],

			]
		);

		$this->add_responsive_control(
			'video_button_width',
			[
				'label'     => esc_html__( 'Width', 'ube' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ube-video-btn' => 'width: {{SIZE}}{{UNIT}};',
				],

			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'video_button_typography',
				'selector' => '{{WRAPPER}} .ube-video-btn',
			]
		);

		$this->start_controls_tabs('video_button_tabs');

		$this->start_controls_tab('video_button_normal_tab', [
			'label' => esc_html__('Normal', 'ube'),
		]);

		$this->add_control(
			'video_button_text_color',
			[
				'label' => esc_html__('Button Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .ube-video-btn' => 'fill: {{VALUE}}; color: {{VALUE}};',
				],
			]
		);


		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'video_button_border',
				'label' => esc_html__('Border', 'ube'),
				'selector' => '{{WRAPPER}} .ube-video-btn',
			]
		);


		$this->add_group_control(Group_Control_Background::get_type(), [
			'name' => 'video_button_background',
			'selector' => '{{WRAPPER}} .ube-video-btn',
		]);

		$this->end_controls_tab();

		$this->start_controls_tab('video_button_hover_tab', [
			'label' => esc_html__('Hover', 'ube'),
		]);

		$this->add_control(
			'video_button_text_color_hover',
			[
				'label' => esc_html__('Button Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .ube-video-btn:hover' => 'fill: {{VALUE}}; color: {{VALUE}};',
				],
			]
		);


		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'video_button_border_hover',
				'label' => esc_html__('Border', 'ube'),
				'selector' => '{{WRAPPER}} .ube-video-btn:hover',
			]
		);

		$this->add_group_control(Group_Control_Background::get_type(), [
			'name' => 'video_button_background_hover',
			'selector' => '{{WRAPPER}} .ube-video-btn:hover',
		]);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'video_button_padding',
			[
				'label' => esc_html__('Padding', 'ube'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors' => [
					'{{WRAPPER}} .ube-video-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'video_button_margin',
			[
				'label' => esc_html__('Margin', 'ube'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors' => [
					'{{WRAPPER}} .ube-video-btn' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section('video_icon_style_section', [
			'label' => esc_html__('Icon', 'ube'),
			'tab' => Controls_Manager::TAB_STYLE,
			'condition' => [
				'video_button_icon[value]!' => '',
			],
		]);


		$this->add_responsive_control('video_button_icon_spacing', [
			'label' => esc_html__('Spacing Icon', 'ube'),
			'type' => Controls_Manager::SLIDER,
			'default' => [
				'unit' => 'px',
			],
			'size_units' => ['px', 'em'],
			'range' => [
				'px' => [
					'min' => 0,
					'max' => 200,
				],
			],
			'selectors' => [
				'{{WRAPPER}} .ube-video-btn.icon-before > i' => 'margin-right : {{SIZE}}{{UNIT}}',
				'{{WRAPPER}} .ube-video-btn.icon-after > i' => 'margin-left : {{SIZE}}{{UNIT}}'
			],
			'condition' => [
				'video_button_icon[value]!' => '',
			],
		]);

		$this->add_responsive_control(
			'video_button_icon_size',
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
					'{{WRAPPER}} .ube-video-btn > i' => 'font-size: {{SIZE}}{{UNIT}}',
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
					'{{WRAPPER}} .ube-video-btn > i' => 'fill: {{VALUE}}; color: {{VALUE}};',
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
					'{{WRAPPER}} .ube-video-btn:hover > i' => 'fill: {{VALUE}}; color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();



		$this->end_controls_tabs();


		$this->end_controls_section();
	}

	public function get_embed_params()
	{
		$settings = $this->get_settings_for_display();

		$params = [];

		$params_dictionary = [];

		if ('youtube' === $settings['video_type']) {
			$params_dictionary = [
				'loop',
				'controls',
				'mute',
				'rel',
				'modestbranding',
			];

			if ($settings['loop']) {
				$video_properties = Embed::get_video_properties($settings['youtube_url']);

				$params['playlist'] = $video_properties['video_id'];
			}

			$params['start'] = $settings['start'];

			$params['end'] = $settings['end'];

			$params['wmode'] = 'opaque';
		} elseif ('vimeo' === $settings['video_type']) {
			$params_dictionary = [
				'loop',
				'mute' => 'muted',
				'vimeo_title' => 'title',
				'vimeo_portrait' => 'portrait',
				'vimeo_byline' => 'byline',
			];

			$params['color'] = str_replace('#', '', $settings['color']);

			$params['autopause'] = '0';
		} elseif ('dailymotion' === $settings['video_type']) {
			$params_dictionary = [
				'controls',
				'mute',
				'showinfo' => 'ui-start-screen-info',
				'logo' => 'ui-logo',
			];

			$params['ui-highlight'] = str_replace('#', '', $settings['color']);

			$params['start'] = $settings['start'];

			$params['endscreen-enable'] = '0';
		}

		foreach ($params_dictionary as $key => $param_name) {
			$setting_name = $param_name;

			if (is_string($key)) {
				$setting_name = $key;
			}

			$setting_value = $settings[$setting_name] ? '1' : '0';

			$params[$param_name] = $setting_value;
		}
		return $params;
	}

	public function get_embed_options()
	{
		$settings = $this->get_settings_for_display();

		$embed_options = [];

		if ('youtube' === $settings['video_type']) {
			$embed_options['privacy'] = $settings['yt_privacy'];
		} elseif ('vimeo' === $settings['video_type']) {
			$embed_options['start'] = $settings['start'];
		}
		$embed_options['lazy_load'] = '';

		return $embed_options;
	}

	public function get_hosted_params()
	{
		$settings = $this->get_settings_for_display();

		$video_params = [];

		foreach (['loop', 'controls'] as $option_name) {
			if ($settings[$option_name]) {
				$video_params[$option_name] = '';
			}
		}

		if ($settings['mute']) {
			$video_params['muted'] = 'muted';
		}

		if (!$settings['download_button']) {
			$video_params['controlsList'] = 'nodownload';
		}

		if ($settings['poster']['url']) {
			$video_params['poster'] = $settings['poster']['url'];
		}

		return $video_params;
	}

	public function get_hosted_video_url()
	{
		$settings = $this->get_settings_for_display();

		if (!empty($settings['insert_url'])) {
			$video_url = $settings['external_url']['url'];
		} else {
			$video_url = $settings['hosted_url']['url'];
		}

		if (empty($video_url)) {
			return '';
		}

		if ($settings['start'] || $settings['end']) {
			$video_url .= '#t=';
		}

		if ($settings['start']) {
			$video_url .= $settings['start'];
		}

		if ($settings['end']) {
			$video_url .= ',' . $settings['end'];
		}

		return $video_url;
	}

	public function render()
	{
		ube_get_template('elements/video-popup.php', array(
			'element' => $this
		));
	}
}