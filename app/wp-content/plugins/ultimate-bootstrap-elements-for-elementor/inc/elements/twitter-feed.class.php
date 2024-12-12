<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Background;

class UBE_Element_Twitter_Feed extends UBE_Abstracts_Elements_Grid {
	public function get_name() {
		return 'ube-twitter-feed';
	}

	public function get_title() {
		return esc_html__( 'Twitter Feed', 'ube' );
	}

	public function get_ube_icon() {
		return 'eicon-twitter';
	}

	public function get_ube_keywords() {
		return array( 'twitter feed', 'ube', 'ube twitter feed' );
	}

	public function get_script_depends() {
		return array( 'slick', 'ube-widget-slider' );
	}

	protected function add_repeater_controls( \Elementor\Repeater $repeater ) {

	}

	protected function get_repeater_defaults() {
	}

	protected function print_grid_item() {
		$settings     = $this->get_settings_for_display();
		$item         = $this->get_current_item();
		$twitter_link = '//twitter.com/' . $settings['twitter_feed_ac_name'];
		$item_link    = '//twitter.com/@' . $item['user']['screen_name'] . '/status/' . $item['id_str'];

		ube_get_template( 'elements/twitter-feed.php', array(
			'twitter_link'                => $twitter_link,
			'item'                        => $item,
			'settings'                    => $settings,
			'item_link'                   => $item_link,
			'twitter_feed_show_avatar'    => $settings['twitter_feed_show_avatar'],
			'twitter_feed_show_icon'      => $settings['twitter_feed_show_icon'],
			'twitter_feed_show_date'      => $settings['twitter_feed_show_date'],
			'twitter_feed_show_read_more' => $settings['twitter_feed_show_read_more'],
			'twitter_feed_read_more_text' => $settings['twitter_feed_read_more_text'],
			'twitter_feed_media'          => $settings['twitter_feed_media']

		) );

	}

	protected function register_controls() {

		$this->register_account_settings_section_controls();
		$this->register_twitter_feed_options_section_controls();
		$this->register_grid_section_controls( [ 'twitter_feed_layout' => 'grid' ] );
		$this->register_slider_section_controls( [
			'name'     => 'twitter_feed_layout',
			'operator' => '=',
			'value'    => 'slider'
		] );
		$this->register_item_style_section_controls();
		$this->register_typo_color_section_controls();
		$this->register_read_more_section_controls();
		$this->remove_control( 'slider_content_position' );
		$this->remove_control( 'slider_content_alignment' );
		$this->remove_control( 'grid_content_position' );
		$this->remove_control( 'grid_content_alignment' );

	}

	protected function register_account_settings_section_controls() {
		$this->start_controls_section( 'account_settings_section', [
			'label' => esc_html__( 'Account Setting', 'ube' ),
			'tab'   => Controls_Manager::TAB_CONTENT,
		] );

		$this->add_control(
			'twitter_feed_ac_name',
			[
				'label'       => esc_html__( 'Account Name', 'ube' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '@g5team1',
				'label_block' => false,
				'description' => esc_html__( 'Use @ sign with your account name.', 'ube' ),

			]
		);

		$this->add_control(
			'twitter_feed_hashtag_name',
			[
				'label'       => esc_html__( 'Hashtag Name', 'ube' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => false,
				'description' => esc_html__( 'Remove # sign from your hashtag name.', 'ube' ),

			]
		);

		$this->add_control(
			'twitter_feed_consumer_key',
			[
				'label'       => esc_html__( 'Consumer Key', 'ube' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => false,
				'default'     => 'PrmnZCEA90ebDPW5UIowGRvGY',
				'description' => wp_kses_post( __( '<a href="https://apps.twitter.com/app/" target="_blank">Get Consumer Key.</a> Create a new app or select existing app and grab the <b>consumer key.</b>', 'ube' ) ),
			]
		);

		$this->add_control(
			'twitter_feed_consumer_secret',
			[
				'label'       => esc_html__( 'Consumer Secret', 'ube' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => false,
				'default'     => '4f84qecImWOu1TiimSwqaXYpPOj2OaDnj9wgLJpNLLBSB5xQkt',
				'description' => wp_kses_post( __( '<a href="https://apps.twitter.com/app/" target="_blank">Get Consumer Secret.</a> Create a new app or select existing app and grab the <b>consumer secret.</b>', '' ) ),
			]
		);

		$this->end_controls_section();
	}

	protected function register_twitter_feed_options_section_controls() {
		$this->start_controls_section(
			'ube_section_twitter_feed_options',
			[
				'label' => esc_html__( 'Twitter Feed Options', 'ube' ),
			]
		);

		$this->add_control(
			'twitter_feed_layout',
			[
				'label'   => esc_html__( 'Layout', 'ube' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'list',
				'options' => [
					'list'   => esc_html__( 'List', 'ube' ),
					'grid'   => esc_html__( 'Grid', 'ube' ),
					'slider' => esc_html__( 'Slider', 'ube' ),
				],
			]
		);


		$this->add_control(
			'twitter_feed_content_length',
			[
				'label'       => esc_html__( 'Content Length', 'ube' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => false,
				'default'     => '400',
			]
		);

		$this->add_control(
			'twitter_feed_post_limit',
			[
				'label'       => esc_html__( 'Post Limit', 'ube' ),
				'type'        => Controls_Manager::NUMBER,
				'label_block' => false,
				'default'     => 10,
			]
		);

		$this->add_control(
			'twitter_feed_media',
			[
				'label'        => esc_html__( 'Show Media Elements', 'ube' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'yes', 'ube' ),
				'label_off'    => esc_html__( 'no', 'ube' ),
				'default'      => 'true',
				'return_value' => 'true',
			]
		);

		$this->add_control(
			'twitter_feed_show_avatar',
			[
				'label'        => esc_html__( 'Show Avatar', 'ube' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'yes', 'ube' ),
				'label_off'    => esc_html__( 'no', 'ube' ),
				'default'      => 'false',
				'return_value' => 'true',
			]
		);

		$this->add_control(
			'twitter_feed_show_date',
			[
				'label'        => esc_html__( 'Show Date', 'ube' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'yes', 'ube' ),
				'label_off'    => esc_html__( 'no', 'ube' ),
				'default'      => 'true',
				'return_value' => 'true',
			]
		);

		$this->add_control(
			'twitter_feed_show_icon',
			[
				'label'        => esc_html__( 'Show Icon', 'ube' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'yes', 'ube' ),
				'label_off'    => esc_html__( 'no', 'ube' ),
				'default'      => 'true',
				'return_value' => 'true',
			]
		);

		$this->add_control(
			'twitter_feed_show_read_more',
			[
				'label'        => esc_html__( 'Show Read More', 'ube' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'yes', 'ube' ),
				'label_off'    => esc_html__( 'no', 'ube' ),
				'default'      => '',
				'return_value' => 'true',
			]
		);

		$this->add_control( 'twitter_feed_read_more_text', [
			'label'     => esc_html__( 'Text', 'ube' ),
			'type'      => Controls_Manager::TEXT,
			'default'   => esc_html__( 'Read More', 'ube' ),
			'dynamic'   => [
				'active' => true,
			],
			'condition' => [
				'twitter_feed_show_read_more' => 'true',
			]
		] );

		$this->end_controls_section();
	}

	protected function register_item_style_section_controls() {
		$this->start_controls_section(
			'twitter_feed_item_style_settings',
			[
				'label' => esc_html__( 'Twitter Feed Items', 'ube' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'twitter_feed_item_spacing',
			[
				'label'     => esc_html__( 'Spacing', 'ube' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 1,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ube-twitter-feed-layout-list .ube-twitter-feed-item:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'twitter_feed_layout' => 'list',
				]
			]
		);

		$this->add_group_control( Group_Control_Background::get_type(), [
			'name'     => 'twitter_feed_item_bg',
			'selector' => '{{WRAPPER}} .ube-twitter-feed-item-inner',
		] );

		$this->add_group_control(
			Group_Control_Border::get_type(), [
				'name'      => 'search_input_border',
				'selector'  => '{{WRAPPER}} .ube-twitter-feed-item-inner',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'search_input_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'ube' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ube-twitter-feed-item-inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control( 'twitter_feed_item_padding', [
			'label'      => esc_html__( 'Padding', 'ube' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%', 'em' ],
			'selectors'  => [
				'{{WRAPPER}} .ube-twitter-feed-item-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
			],
			'separator'  => 'before',
		] );

		$this->end_controls_section();
	}

	protected function register_typo_color_section_controls() {
		$this->start_controls_section(
			'twitter_feed_typo_color_style_settings',
			[
				'label' => esc_html__( 'Color & Typography', 'ube' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'twitter_feed_heading_ac_name',
			[
				'label'     => esc_html__( 'Account Name', 'ube' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'     => 'twitter_feed_ac_name_typography',
			'selector' => '{{WRAPPER}} .ube-twitter-feed-author',
		] );

		$this->add_control(
			'twitter_feed_ac_name_color',
			[
				'label'     => esc_html__( 'Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ube-twitter-feed-author' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control( 'twitter_feed_ac_name_padding', [
			'label'      => esc_html__( 'Padding', 'ube' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%', 'em' ],
			'selectors'  => [
				'{{WRAPPER}} .ube-twitter-feed-author' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
			],
		] );

		$this->add_control(
			'twitter_feed_heading_date',
			[
				'label'     => esc_html__( 'Post Time', 'ube' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'     => 'twitter_feed_date_typography',
			'selector' => '{{WRAPPER}} .ube-twitter-feed-date',
		] );

		$this->add_control(
			'twitter_feed_date_color',
			[
				'label'     => esc_html__( 'Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ube-twitter-feed-date' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'twitter_feed_heading_content',
			[
				'label'     => esc_html__( 'Content', 'ube' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'     => 'twitter_feed_content_typography',
			'selector' => '{{WRAPPER}} .ube-twitter-feed-content > p',
		] );

		$this->add_control(
			'twitter_feed_content_color',
			[
				'label'     => esc_html__( 'Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ube-twitter-feed-content > p' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'twitter_feed_heading_icon',
			[
				'label'     => esc_html__( 'Icon', 'ube' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'twitter_feed_show_icon' => 'true',
				]
			]
		);

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'      => 'twitter_feed_icon_typography',
			'selector'  => '{{WRAPPER}} .ube-twitter-feed-meta .eicon-twitter',
			'condition' => [
				'twitter_feed_show_icon' => 'true',
			]
		] );

		$this->add_control(
			'twitter_feed_icon_color',
			[
				'label'     => esc_html__( 'Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ube-twitter-feed-meta .eicon-twitter' => 'color: {{VALUE}};',
				],
				'condition' => [
					'twitter_feed_show_icon' => 'true',
				]
			]
		);

		$this->add_responsive_control( 'twitter_feed_icon_padding', [
			'label'      => esc_html__( 'Padding', 'ube' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%', 'em' ],
			'selectors'  => [
				'{{WRAPPER}} .ube-twitter-feed-meta .eicon-twitter' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
			],
			'condition'  => [
				'twitter_feed_show_icon' => 'true',
			]
		] );

		$this->end_controls_section();

	}

	protected function register_read_more_section_controls() {
		$this->start_controls_section(
			'twitter_feed_read_more_style_settings',
			[
				'label'     => esc_html__( 'Read More', 'ube' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'twitter_feed_show_read_more' => 'true',
				]
			]
		);

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'     => 'twitter_feed_read_more_typography',
			'selector' => '{{WRAPPER}} .ube-twitter-feed .btn-read-more',
		] );

		$this->add_control(
			'twitter_feed_read_more_color',
			[
				'label'     => esc_html__( 'Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ube-twitter-feed .btn-read-more' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control( Group_Control_Background::get_type(), [
			'name'     => 'twitter_feed_read_more_bg',
			'selector' => '{{WRAPPER}} .ube-twitter-feed .btn-read-more',
		] );

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'twitter_feed_read_more_border',
				'label'     => esc_html__( 'Border', 'ube' ),
				'selector'  => '{{WRAPPER}} .ube-twitter-feed .btn-read-more',
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'twitter_feed_read_more_border_radius',
			[
				'label'     => esc_html__( 'Border Radius', 'ube' ),
				'type'      => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .ube-twitter-feed .btn-read-more' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
				],
			]
		);

		$this->add_responsive_control( 'twitter_feed_read_more_padding', [
			'label'      => esc_html__( 'Padding', 'ube' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%', 'em' ],
			'selectors'  => [
				'{{WRAPPER}} .ube-twitter-feed .btn-read-more' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
			],
			'separator'  => 'before',
		] );

		$this->add_responsive_control( 'twitter_feed_read_more_margin', [
			'label'      => esc_html__( 'Margin', 'ube' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%', 'em' ],
			'selectors'  => [
				'{{WRAPPER}} .ube-twitter-feed .btn-read-more' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		] );

		$this->end_controls_section();
	}

	protected function register_grid_section_controls( $condition = [] ) {
		parent::register_grid_section_controls( $condition );
		$this->update_control( 'grid_columns', [ 'default' => 3 ] );
	}

	protected function register_slider_section_controls( $condition = [] ) {
		parent::register_slider_section_controls( $condition );
		$this->update_control( 'center_mode', [ 'default' => '' ] );
		$this->remove_control( 'slider_type' );
		$this->update_control( 'slides_to_show', [ 'default' => 3 ] );
	}

	protected function print_list( $settings, $wrapper_class ) {
		$wrapper_classes = array(
			$wrapper_class
		);

		$this->add_render_attribute( 'list', 'class', $wrapper_classes );
		?>
        <div <?php $this->print_render_attribute_string( 'list' ); ?>>
			<?php foreach ( $settings['items'] as $item ) {
				$item_id  = $item['_id'];
				$item_key = 'item_' . $item_id;
				$this->set_current_item( $item );
				$this->set_current_item_key( $item_key );
				$this->print_grid_item();
			} ?>
        </div>
		<?php
	}

	public function render() {
		$settings = $this->get_settings_for_display();
		if ( empty( $settings['twitter_feed_consumer_key'] ) || empty( $settings['twitter_feed_consumer_secret'] ) || empty( $settings['twitter_feed_ac_name'] ) ) {
			return;
		}

		$id    = $this->get_id();
		$token = get_option( $id . '_' . $settings['twitter_feed_ac_name'] . '_tf_token' );
		$items = get_transient( $id . '_' . $settings['twitter_feed_ac_name'] . '_tf_cache' );

		if ( $items === false ) {
			if ( empty( $token ) ) {
				$credentials = base64_encode( $settings['twitter_feed_consumer_key'] . ':' . $settings['twitter_feed_consumer_secret'] );

				add_filter( 'https_ssl_verify', '__return_false' );

				$response = wp_remote_post( 'https://api.twitter.com/oauth2/token', [
					'method'      => 'POST',
					'httpversion' => '1.1',
					'blocking'    => true,
					'headers'     => [
						'Authorization' => 'Basic ' . $credentials,
						'Content-Type'  => 'application/x-www-form-urlencoded;charset=UTF-8',
					],
					'body'        => [ 'grant_type' => 'client_credentials' ],
				] );

				$body = json_decode( wp_remote_retrieve_body( $response ) );

				if ( $body ) {
					update_option( $id . '_' . $settings['twitter_feed_ac_name'] . '_tf_token', $body->access_token );
					$token = $body->access_token;
				}
			}

			add_filter( 'https_ssl_verify', '__return_false' );

			$response = wp_remote_get( 'https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=' . $settings['twitter_feed_ac_name'] . '&count=999&tweet_mode=extended', [
				'httpversion' => '1.1',
				'blocking'    => true,
				'headers'     => [
					'Authorization' => "Bearer $token",
				],
			] );

			if ( ! is_wp_error( $response ) ) {
				$items = json_decode( wp_remote_retrieve_body( $response ), true );
			}
		}

		if ( empty( $items ) ) {
			return;
		}

		if ( $settings['twitter_feed_hashtag_name'] ) {
			foreach ( $items as $key => $item ) {
				$match = false;

				if ( $item['entities']['hashtags'] ) {
					foreach ( $item['entities']['hashtags'] as $tag ) {
						if ( strcasecmp( $tag['text'], $settings['twitter_feed_hashtag_name'] ) == 0 ) {
							$match = true;
						}
					}
				}

				if ( $match == false ) {
					unset( $items[ $key ] );
				}
			}
		}

		if ( $settings['twitter_feed_post_limit'] === '' ) {
			return;
		}

		$items       = array_splice( $items, 0, $settings['twitter_feed_post_limit'] );
		$twitter_arr = array();
		foreach ( $items as $data ) {
			$data['_id']   = $data['id'];
			$twitter_arr[] = $data;
		}
		$wrapper_class     = 'ube-twitter-feed ube-twitter-feed-layout-' . $settings['twitter_feed_layout'];
		$settings['items'] = $twitter_arr;
		if ( $settings['twitter_feed_layout'] === 'slider' ) {
			$this->print_slider( $settings, $wrapper_class );
		} elseif ( $settings['twitter_feed_layout'] === 'grid' ) {
			$this->print_grid( $settings, $wrapper_class );
		} else {
			$this->print_list( $settings, $wrapper_class );
		}

	}
}