<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Get color schemes config
 *
 * @return array
 * @since 1.0.0
 */
function ube_color_schemes_configs() {
	$schemes = apply_filters( 'ube_color_schemes_configs', array(
		"accent"    => array(
			'label' => __( 'Accent', 'ube' ),
			'color' => '#007bff'
		),
		"primary"   => array(
			'label' => __( 'Primary', 'ube' ),
			'color' => '#007bff'
		),
		"secondary" => array(
			'label' => __( 'Secondary', 'ube' ),
			'color' => '#6c757d'
		),
		"light"     => array(
			'label' => __( 'Light', 'ube' ),
			'color' => '#f8f9fa'
		),
		"dark"      => array(
			'label' => __( 'Dark', 'ube' ),
			'color' => '#343a40'
		),
		"success"   => array(
			'label' => __( 'Success', 'ube' ),
			'color' => '#28a745'
		),
		"danger"    => array(
			'label' => __( 'Danger', 'ube' ),
			'color' => '#dc3545'
		),
		"warning"   => array(
			'label' => __( 'Warning', 'ube' ),
			'color' => '#ffc107'
		),
		"info"      => array(
			'label' => __( 'Info', 'ube' ),
			'color' => '#17a2b8'
		),
	) );

	foreach ( ube_get_system_colors() as $k => $v ) {
		if ( isset( $schemes[ $v['_id'] ] ) ) {
			$schemes[ $v['_id'] ]['color'] = $v['color'];
		}
	}

	return $schemes;
}

/**
 * Get elements config
 *
 * @return mixed|void
 */
function ube_get_element_configs() {
	return apply_filters( 'ube_get_element_configs', array(
		'general'  => array(
			'title' => esc_html__( 'General', 'ube' ),
			'items' => array(
				'Accordion'                         => array(
					'title'    => esc_html__( 'Accordion', 'ube' ),
					'demo'     => 'accordion',
					'document' => '',
				),
				'Alert'                             => array(
					'title'    => esc_html__( 'Alert', 'ube' ),
					'demo'     => 'alert',
					'document' => '',
				),
				'Badge'                             => array(
					'title'    => esc_html__( 'Badge', 'ube' ),
					'demo'     => '#',
					'document' => '',
				),
				'Banner'                            => array(
					'title'    => esc_html__( 'Banner', 'ube' ),
					'demo'     => 'banner',
					'document' => '',
				),
				'Breadcrumbs'                       => array(
					'title' => esc_html__( 'Breadcrumbs', 'ube' ),
				),
				'Business_Hours'                    => array(
					'title' => esc_html__( 'Business Hours', 'ube' ),
					'demo'  => 'business-hours',
				),
				'Button'                            => array(
					'title' => esc_html__( 'Button', 'ube' ),
					'demo'  => 'button',
				),
				'Button_Group'                      => array(
					'title' => esc_html__( 'Button Group', 'ube' ),
				),
				'Call_To_Action'                    => array(
					'title' => esc_html__( 'Call To Action', 'ube' ),
					'demo'  => 'call-to-action',
				),
				'Chart'                             => array(
					'title' => esc_html__( 'Chart', 'ube' ),
					'demo'  => 'chart',
				),
				'Client_Logo'                       => array(
					'title' => esc_html__( 'Client Logo', 'ube' ),
					'demo'  => 'client-logo',
				),
				'Countdown'                         => array(
					'title' => esc_html__( 'Countdown', 'ube' ),
					'demo'  => 'countdown',
				),
				'Counter'                           => array(
					'title' => esc_html__( 'Counter', 'ube' ),
					'demo'  => 'counter',
				),
				'Divider'                           => array(
					'title' => esc_html__( 'Divider', 'ube' ),
					'demo'  => 'divider',
				),
				'Double_Button'                     => array(
					'title' => esc_html__( 'Double Button', 'ube' ),
					'demo'  => 'double-button',
				),
				'Dropcaps'                          => array(
					'title' => esc_html__( 'Dropcaps', 'ube' ),
					'demo'  => 'dropcaps',
				),
				'Dual_Heading'                      => array(
					'title' => esc_html__( 'Dual Heading', 'ube' ),
					'demo'  => 'dual-heading',
				),
				'Fancy_Text'                        => array(
					'title' => esc_html__( 'Fancy Text', 'ube' ),
					'demo'  => 'fancy-text',
				),
				'Flip_Box'                          => array(
					'title' => esc_html__( 'Flip Box', 'ube' ),
					'demo'  => 'flip-box',
				),
				'Gallery_Justified'                 => array(
					'title' => esc_html__( 'Gallery Justified', 'ube' ),
					'demo'  => 'gallery-justify',
				),
				'Gallery_Masonry'                   => array(
					'title' => esc_html__( 'Gallery Masonry', 'ube' ),
					'demo'  => 'gallery-masonry',
				),
				'Gallery_Metro'                     => array(
					'title' => esc_html__( 'Gallery Metro', 'ube' ),
					'demo'  => 'gallery-metro',
				),
				'Heading'                           => array(
					'title' => esc_html__( 'Heading', 'ube' ),
					'demo'  => 'heading',
				),
				'Icon_Box'                          => array(
					'title' => esc_html__( 'Icon Box', 'ube' ),
					'demo'  => 'icon-box',
				),
				'Image'                             => array(
					'title' => esc_html__( 'Image', 'ube' ),
					'demo'  => 'image',
				),
				'Image_Box'                         => array(
					'title' => esc_html__( 'Image Box', 'ube' ),
					'demo'  => 'image-box',
				),
				'Inline_Menu'                       => array(
					'title' => esc_html__( 'Inline Menu', 'ube' ),
					'demo'  => 'inline-menu',
				),
				'List_Group'                        => array(
					'title' => esc_html__( 'List Group', 'ube' ),
				),
				'List_Icon'                         => array(
					'title' => esc_html__( 'List Icon', 'ube' ),
					'demo'  => 'icon-list',
				),
				'modals'                            => array(
					'title' => esc_html__( 'Modals', 'ube' ),
				),
				'Pricing_Table'                     => array(
					'title' => esc_html__( 'Pricing Table', 'ube' ),
					'demo'  => 'pricing-table',
				),
				'Page_Title'                        => array(
					'title' => esc_html__( 'Page Title', 'ube' ),
					'demo'  => '',
				),
				'Progress'                          => array(
					'title' => esc_html__( 'Progress', 'ube' ),
					'demo'  => 'progress',
				),
				'Search_Box'                        => array(
					'title' => esc_html__( 'Search Box', 'ube' ),
				),
				'Slider'                            => array(
					'title' => esc_html__( 'Slider', 'ube' ),
					'demo'  => 'slider',
				),
				'Slider_Container'                  => array(
					'title' => esc_html__( 'Slider Container', 'ube' ),
					'demo'  => 'slider-container',
				),
				'Social_Icon'                       => array(
					'title' => esc_html__( 'Social Icon', 'ube' ),
					'demo'  => 'social-icon',
				),
				'Social_Share'                      => array(
					'title' => esc_html__( 'Social Share', 'ube' ),
					'demo'  => 'social-share',
				),
				'Tabs'                              => array(
					'title' => esc_html__( 'Tabs', 'ube' ),
					'demo'  => 'tabs',
				),
				'Team_Member'                       => array(
					'title' => esc_html__( 'Team Member', 'ube' ),
					'demo'  => 'team-member',
				),
				'Testimonial'                       => array(
					'title' => esc_html__( 'Testimonial', 'ube' ),
					'demo'  => 'testimonial',
				),
				'Timeline'                          => array(
					'title' => esc_html__( 'Timeline', 'ube' ),
				),
				'Tour'                              => array(
					'title' => esc_html__( 'Tour', 'ube' ),
					'demo'  => 'tour',
				),
				'Video_Popup'                       => array(
					'title' => esc_html__( 'Video Popup', 'ube' ),
					'demo'  => 'video-popup',
				),
				'Bullet_One_Page_Scroll_Navigation' => array(
					'title' => esc_html__( 'Bullet One Page Scroll Navigation', 'ube' ),
				),
			),
		),
		'post'     => array(
			'title' => esc_html__( 'Posts', 'ube' ),
			'items' => array(
				'Post_Grid'    => array(
					'title' => esc_html__( 'Post Grid', 'ube' ),
					'demo'  => 'post-grid',
				),
				'Post_List'    => array(
					'title' => esc_html__( 'Post List', 'ube' ),
					'demo'  => 'post-list',
				),
				'Post_Masonry' => array(
					'title' => esc_html__( 'Post Masonry', 'ube' ),
					'demo'  => 'post-masonry',
				),
				'Post_Metro'   => array(
					'title' => esc_html__( 'Post Metro', 'ube' ),
					'demo'  => 'post-metro',
				),
				'Post_Slider'  => array(
					'title' => esc_html__( 'Post Slider', 'ube' ),
					'demo'  => 'post-slider',
				),
			)
		),
		'advanced' => array(
			'title' => esc_html__( 'Advanced', 'ube' ),
			'items' => array(
				'Advanced_Image_Box'    => array(
					'title' => esc_html__( 'Advanced Image Box', 'ube' ),
					'demo'  => 'image-box',
				),
				'Advanced_Icon_Box'     => array(
					'title' => esc_html__( 'Advanced Icon Box', 'ube' ),
					'demo'  => 'icon-box',
				),
				'Advanced_Team_Member'  => array(
					'title' => esc_html__( 'Advanced Team Member', 'ube' ),
					'demo'  => 'team-member',
				),
				'Advanced_Testimonial'  => array(
					'title' => esc_html__( 'Advanced Testimonial', 'ube' ),
					'demo'  => 'testimonial',
				),
				'Advanced_Client_Logo'  => array(
					'title' => esc_html__( 'Advanced Client Logo', 'ube' ),
					'demo'  => 'client-logo',
				),
				'Advanced_Accordion'    => array(
					'title' => esc_html__( 'Advanced Accordion', 'ube' ),
					'demo'  => 'advanced-accordion',
				),
				'Advanced_Tabs'         => array(
					'title' => esc_html__( 'Advanced Tabs', 'ube' ),
					'demo'  => 'advanced-tabs',
				),
				'Advanced_Tour'         => array(
					'title' => esc_html__( 'Advanced Tour', 'ube' ),
					'demo'  => 'advanced-tour',
				),
				'Advanced_Slider'       => array(
					'title' => esc_html__( 'Advanced Slider', 'ube' ),
					'demo'  => 'advanced-slider',
				),
				'Contact_Form_7'        => array(
					'title' => esc_html__( 'Contact Form 7', 'ube' ),
					'demo'  => 'contact-form',
				),
				'Facebook_Feed'         => array(
					'title' => esc_html__( 'Facebook Feed', 'ube' ),
				),
				'Form'                  => array(
					'title' => esc_html__( 'Form', 'ube' ),
				),
				'Google_Map'            => array(
					'title' => esc_html__( 'Google Map', 'ube' ),
					'demo'  => 'google-map',
				),
				'Mapbox'                => array(
					'title' => esc_html__( 'Mapbox', 'ube' ),
					'demo'  => 'map-box',
				),
				'Offcanvas'             => array(
					'title' => esc_html__( 'Off Canvas', 'ube' ),
					'demo'  => 'offcanvas',
				),
				'Image_Comparison'      => array(
					'title' => esc_html__( 'Image Comparison', 'ube' ),
					'demo'  => 'image-comparison',
				),
				'Image_Layers'          => array(
					'title' => esc_html__( 'Image Layers', 'ube' ),
					'demo'  => 'image-layers',
				),
				'Image_Marker'          => array(
					'title' => esc_html__( 'Image Marker', 'ube' ),
					'demo'  => 'image-marker',
				),
				'Instagram'             => array(
					'title' => esc_html__( 'Instagram', 'ube' ),
					'demo'  => 'instagram',
				),
				'Subscribe_News_Letter' => array(
					'title' => esc_html__( 'Subscribe News Letter', 'ube' ),
					'demo'  => 'subscribe-news-letter',
				),
				'Twitter_Feed'          => array(
					'title' => esc_html__( 'Twitter Feed', 'ube' ),
				),
				'Vertical_Menu'         => array(
					'title' => esc_html__( 'Vertical Menu', 'ube' )
				),
			)
		),
	) );
}

/**
 * Get UBE Admin Setting Tabs
 *
 * @return mixed|void
 */
function ube_get_admin_setting_tabs() {
	return apply_filters( 'ube_get_admin_setting_tabs', array(
		'welcome'  => esc_html__( 'Welcome', 'ube' ),
		'elements' => esc_html__( 'Elements', 'ube' ),
		'api'      => esc_html__( 'API', 'ube' ),
	) );
}

function ube_get_api_configs() {
	$allowed_html = array(
		'i'    => array(
			'class' => array()
		),
		'span' => array(
			'class' => array()
		),
		'a'    => array(
			'href'   => array(),
			'title'  => array(),
			'target' => array()
		)
	);

	return apply_filters( 'ube_get_api_configs', array(
		'google_map' => array(
			'label'  => esc_html__( 'Google Map', 'ube' ),
			'desc'   => sprintf( __( 'Visit %s to get api key. Click %s for instructions on getting google map api key.', 'ube' ),
				'<a href="https://console.cloud.google.com/project/_/google/maps-apis/overview" target="_blank">' . esc_html__( 'Google Map Console', 'ube' ) . '</a>',
				'<a href="https://developers.google.com/maps/documentation/maps-static/get-api-key" target="_blank">' . esc_html__( 'here', 'ube' ) . '</a>' ),
			'fields' => array(
				'api_key' => esc_html__( 'API Key', 'ube' ),
			),
		),
		'map_box'    => array(
			'label'  => esc_html__( 'Map Box', 'ube' ),
			'desc'   => wp_kses( __( 'A Mapbox API Access Token is required to load maps. You can get it in <a target="_blank" href="https://www.mapbox.com/account/">in your Mapbox user dashboard</a>.', 'ube' ), $allowed_html ),
			'fields' => array(
				'mapbox_api_access_token' => esc_html__( 'API Access Token', 'ube' ),
			),
		)
	) );
}


function ube_get_pricing_table_style() {
    return apply_filters('ube_pricing_table_style',[
        'style-1' => esc_html__('Style 1', 'ube'),
        'style-2' => esc_html__('Style 2', 'ube'),
        'style-3' => esc_html__('Style 3', 'ube'),
        'style-4' => esc_html__('Style 4', 'ube'),
    ]);
}

function ube_get_team_member_style() {
    return apply_filters('ube_team_member_style',[
        'style-01' => esc_html__( 'Layout 01', 'ube' ),
        'style-02' => esc_html__( 'Layout 02', 'ube' ),
        'style-03' => esc_html__( 'Layout 03', 'ube' ),
    ]);
}

function ube_get_testimonials_style(){
    return apply_filters('ube_testimonials_layout_style', array(
        'layout-01' => esc_html__('Layout 01', 'ube'),
        'layout-02' => esc_html__('Layout 02', 'ube'),
        'layout-03' => esc_html__('Layout 03', 'ube'),
        'layout-04' => esc_html__('Layout 04', 'ube'),
        'layout-05' => esc_html__('Layout 05', 'ube'),
        'layout-06' => esc_html__('Layout 06', 'ube'),
        'layout-07' => esc_html__('Layout 07', 'ube'),
    ));
}

function ube_get_post_metro_layout()
{
    return apply_filters('ube_get_post_metro_layout',[
        'post-metro-layout-01' => esc_html__( 'Post Metro Layout 01', 'ube' ),
        'post-metro-layout-02' => esc_html__( 'Post Metro Layout 02', 'ube' ),
        'post-metro-layout-03' => esc_html__( 'Post Metro Layout 03', 'ube' ),
    ]);
}

function ube_get_post_grid_layout()
{
    return apply_filters('ube_get_post_grid_layout',[
        'post-grid-layout-01' => esc_html__( 'Post Grid Layout 01', 'ube' ),
        'post-grid-layout-02' => esc_html__( 'Post Grid Layout 02', 'ube' ),
        'post-grid-layout-03' => esc_html__( 'Post Grid Layout 03', 'ube' ),
        'post-grid-layout-04' => esc_html__( 'Post Grid Layout 04', 'ube' ),
    ]);
}

function ube_get_post_list_layout()
{
    return apply_filters('ube_get_post_list_layout',[
        'post-list-layout-01' => esc_html__( 'Post List Layout 01', 'ube' ),
        'post-list-layout-02' => esc_html__( 'Post List Layout 02', 'ube' ),
        'post-list-layout-03' => esc_html__( 'Post List Layout 03', 'ube' ),
    ]);
}

function ube_get_post_masonry_layout()
{
    return apply_filters('ube_get_post_masonry_layout',[
        'post-masonry-layout-01' => esc_html__( 'Post Masonry Layout 01', 'ube' ),
        'post-masonry-layout-02' => esc_html__( 'Post Masonry Layout 02', 'ube' ),
        'post-masonry-layout-03' => esc_html__( 'Post Masonry Layout 03', 'ube' ),
        'post-masonry-layout-04' => esc_html__( 'Post Masonry Layout 04', 'ube' ),
        'post-masonry-layout-05' => esc_html__( 'Post Masonry Layout 05', 'ube' ),
    ]);
}