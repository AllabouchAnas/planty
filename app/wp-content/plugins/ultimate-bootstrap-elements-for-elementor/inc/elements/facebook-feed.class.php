<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Background;

class UBE_Element_Facebook_Feed extends UBE_Abstracts_Elements_Grid {

	public function get_name() {
		return 'ube-facebook-feed';
	}

	public function get_title() {
		return esc_html__( 'Facebook Feed', 'ube' );
	}

	public function get_ube_icon() {
		return 'eicon-facebook';
	}

	public function get_ube_keywords() {
		return array( 'facebook feed', 'ube', 'ube facebook feed' );
	}

	public function get_script_depends() {
		return array( 'slick', 'ube-widget-slider' );
	}

	protected function add_repeater_controls( \Elementor\Repeater $repeater ) {

	}

	protected function get_repeater_defaults() {
	}

	protected function print_grid_item() {
		$settings  = $this->get_settings_for_display();
		$item      = $this->get_current_item();
		$page_id   = $settings['fbf_page_id'];
		$page_link = 'https://www.facebook.com/' . $page_id;
		$image_url = 'https://graph.facebook.com/v4.0/' . $page_id . '/picture';
		$message   = wp_trim_words( ( isset( $item['message'] ) ? $item['message'] : ( isset( $item['story'] ) ? $item['story'] : '' ) ), $settings['fbf_message_max_length']['size'], '...' );
		$photo     = ( isset( $item['full_picture'] ) ? $item['full_picture'] : '' );
		$likes     = ( isset( $item['reactions'] ) ? $item['reactions']['summary']['total_count'] : 0 );
		$comments  = ( isset( $item['comments'] ) ? $item['comments']['summary']['total_count'] : 0 );
		$target    = '_self';

		if ( $settings['fbf_link_target'] == 'yes' ) {
			$target = '_blank';
		}

		ube_get_template( 'elements/facebook-feed.php', array(
			'page_link'    => $page_link,
			'target'       => $target,
			'image_url'    => $image_url,
			'message'      => $message,
			'photo'        => $photo,
			'likes'        => $likes,
			'comments'     => $comments,
			'item'         => $item,
			'fbf_likes'    => $settings['fbf_likes'],
			'fbf_comments' => $settings['fbf_comments'],
			'fbf_date'     => $settings['fbf_date'],
			'fbf_message'  => $settings['fbf_message'],

		) );


	}

	protected function register_controls() {

		$this->register_account_setting();
		$this->register_section_content_setting();

		$this->register_grid_section_controls( [ 'slider_enable!' => 'on' ] );
		$this->register_slider_section_controls( [
			'name'     => 'slider_enable',
			'operator' => '=',
			'value'    => 'on'
		] );
		$this->register_section_style_content_setting();
		$this->remove_control( 'slider_content_position' );
		$this->remove_control( 'slider_content_alignment' );
		$this->remove_control( 'grid_content_position' );
		$this->remove_control( 'grid_content_alignment' );


	}

	protected function register_account_setting() {
		$this->start_controls_section(
			'facebook_feed_settings_account',
			[
				'label' => esc_html__( 'Facebook Account Settings', 'ube' ),
			]
		);

		$this->add_control(
			'fbf_page_id',
			[
				'label'       => esc_html__( 'Page ID', 'ube' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'default'     => '',
				'description' => wp_kses_post( __( '<a href="https://findmyfbid.com/" target="_blank">Find Your Page ID</a>', 'ube' ) ),
			]
		);

		$this->add_control(
			'fbf_access_token',
			[
				'label'       => esc_html__( 'Access Token', 'ube' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'default'     => '',
				'description' => wp_kses_post( __( '<a href="https://developers.facebook.com/" target="_blank">Get Access Token</a>', 'ube' ) ),
			]
		);

		$this->end_controls_section();
	}

	protected function register_grid_section_controls( $condition = [] ) {
		parent::register_grid_section_controls( $condition );
		$this->update_control( 'center_mode', [ 'default' => '' ] );
	}

	protected function register_slider_section_controls( $condition = [] ) {
		parent::register_slider_section_controls( $condition );
		$this->update_control( 'grid_columns', [ 'default' => 3 ] );
		$this->remove_control( 'slider_type' );
		$this->update_control( 'slides_to_show', [ 'default' => 3 ] );
	}

	protected function register_section_content_setting() {
		$this->start_controls_section(
			'facebook_feed_settings_content',
			[
				'label' => esc_html__( 'Facebook Feed Options', 'ube' ),
			]
		);
		$this->add_control(
			'fbf_content_heading',
			[
				'label' => esc_html__( 'Content Settings', 'ube' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'fbf_sort_by',
			[
				'label'   => esc_html__( 'Sort By', 'ube' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'most-recent'  => esc_html__( 'Newest', 'ube' ),
					'least-recent' => esc_html__( 'Oldest', 'ube' ),
				],
				'default' => 'most-recent',
			]
		);

		$this->add_control(
			'fbf_item_count',
			[
				'label'   => esc_html__( 'Max Visible Items', 'ube' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 6,
				],
				'range'   => [
					'px' => [
						'min' => 1,
						'max' => 100,
					],
				],
			]
		);

		$this->add_control(
			'fbf_message',
			[
				'label'        => esc_html__( 'Display Message', 'ube' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'fbf_message_max_length',
			[
				'label'      => esc_html__( 'Max Message Length', 'ube' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 10,
						'max' => 100,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 10,
				],
				'condition'  => [
					'fbf_message' => 'yes',
				],
			]
		);

		$this->add_control(
			'fbf_likes',
			[
				'label'        => esc_html__( 'Display Like', 'ube' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'fbf_comments',
			[
				'label'        => esc_html__( 'Display Comments', 'ube' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'fbf_date',
			[
				'label'        => esc_html__( 'Display Date', 'ube' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'fbf_link_target',
			[
				'label'        => esc_html__( 'Open link in new window', 'ube' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);
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

	protected function register_section_style_content_setting() {
		$this->start_controls_section(
			'fbf_styles_item',
			[
				'label' => esc_html__( 'Facebook Feed Item', 'ube' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);


		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'fbf_item_border',
				'label'     => esc_html__( 'Border', 'ube' ),
				'selector'  => '{{WRAPPER}} .ube-facebook-feed-item-inner',
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'fbf_item_border_radius',
			[
				'label'     => esc_html__( 'Border Radius', 'ube' ),
				'type'      => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .ube-facebook-feed-item-inner' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'fbf_styles_item_header',
			[
				'label' => esc_html__( 'Facebook Feed Header', 'ube' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'fbf_item_header_padding',
			[
				'label'      => esc_html__( 'Padding', 'ube' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ube-facebook-feed-header' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control( Group_Control_Background::get_type(), [
			'name'     => 'fbf_item_header_background',
			'selector' => '{{WRAPPER}} .ube-facebook-feed-header',
		] );

		$this->add_control(
			'fbf_heading_use',
			[
				'label'     => esc_html__( 'Username', 'ube' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'     => 'fbf_use_typography',
			'selector' => '{{WRAPPER}} .ube-facebook-feed-header .username',
		] );

		$this->add_control(
			'fbf_use_color',
			[
				'label'     => esc_html__( 'Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ube-facebook-feed-header .username' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'fbf_use_spacing',
			[
				'label'     => esc_html__( 'Spacing', 'ube' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ube-facebook-feed-header .username' => 'margin-left: {{SIZE}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_control(
			'fbf_heading_posttime',
			[
				'label'     => esc_html__( 'Post Time', 'ube' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'     => 'fbf_pt_typography',
			'selector' => '{{WRAPPER}} .ube-facebook-feed-header .post-time',
		] );

		$this->add_control(
			'fbf_pt_color',
			[
				'label'     => esc_html__( 'Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ube-facebook-feed-header .post-time' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'fbf_styles_item_content',
			[
				'label' => esc_html__( 'Facebook Feed Content', 'ube' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'fbf_item_content_padding',
			[
				'label'      => esc_html__( 'Padding', 'ube' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ube-facebook-feed-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control( Group_Control_Background::get_type(), [
			'name'     => 'fbf_item_content_background',
			'selector' => '{{WRAPPER}} .ube-facebook-feed-content',
		] );

		$this->add_control(
			'fbf_heading_status',
			[
				'label'     => esc_html__( 'Status', 'ube' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'     => 'fbf_ct_typography',
			'selector' => '{{WRAPPER}} .ube-facebook-feed-content .message',
		] );

		$this->add_control(
			'fbf_ct_color',
			[
				'label'     => esc_html__( 'Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ube-facebook-feed-content .message' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'fbf_styles_item_footer',
			[
				'label' => esc_html__( 'Facebook Feed Footer', 'ube' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'fbf_item_ft_padding',
			[
				'label'      => esc_html__( 'Padding', 'ube' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ube-facebook-feed-footer' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control( Group_Control_Background::get_type(), [
			'name'     => 'fbf_item_ft_background',
			'selector' => '{{WRAPPER}} .ube-facebook-feed-footer',
		] );

		$this->add_control(
			'fbf_like_comment_status',
			[
				'label'     => esc_html__( 'Like and Comment', 'ube' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'     => 'fbf_like_comment_typography',
			'selector' => '{{WRAPPER}} .ube-facebook-feed-footer > span',
		] );

		$this->add_control(
			'fbf_like_comment_color',
			[
				'label'     => esc_html__( 'Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ube-facebook-feed-footer > span' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'fbf_like_comment_spacing',
			[
				'label'     => esc_html__( 'Spacing', 'ube' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ube-facebook-feed-footer > span + span' => 'margin-left: {{SIZE}}{{UNIT}} !important;',
				],
			]
		);

		$this->end_controls_section();
	}

	public function render() {
		$settings = $this->get_settings_for_display();
		$page     = 0;
		$page_id  = $settings['fbf_page_id'];
		$token    = $settings['fbf_access_token'];

		if ( empty( $page_id ) || empty( $token ) ) {
			return;
		}

		$key = 'ube_facebook_feed_' . substr( str_rot13( str_replace( '.', '', $page_id . $token ) ), 32 );

		if ( get_transient( $key ) === false ) {
			$facebook_data = wp_remote_retrieve_body( wp_remote_get( "https://graph.facebook.com/v4.0/{$page_id}/posts?fields=status_type,created_time,from,message,story,full_picture,permalink_url,attachments.limit(1){type,media_type,title,description,unshimmed_url},comments.summary(total_count),reactions.summary(total_count)&access_token={$token}" ) );
			set_transient( $key, $facebook_data, 1800 );
		} else {
			$facebook_data = get_transient( $key );
		}

		$facebook_data     = json_decode( $facebook_data, true );
		$facebook_data_arr = array();
		if ( isset( $facebook_data['data'] ) ) {
			foreach ( $facebook_data['data'] as $index => $data ) {
				$data['_id']         = $data['id'];
				$facebook_data_arr[] = $data;
			}
		} else {
			return;
		}
		switch ( $settings['fbf_sort_by'] ) {
			case 'least-recent':
				$facebook_data_arr = array_reverse( $facebook_data_arr );
				break;
		}

		$items             = array_splice( $facebook_data_arr, ( $page * $settings['fbf_item_count']['size'] ), $settings['fbf_item_count']['size'] );
		$settings['items'] = $items;

		$wrapper_class = 'ube-facebook-feed';

		$slider_enable = isset( $settings['slider_enable'] ) ? $settings['slider_enable'] : '';
		if ( $slider_enable === 'on' ) {
			$this->print_slider( $settings, $wrapper_class );
		} else {
			$this->print_grid( $settings, $wrapper_class );
		}
	}
}