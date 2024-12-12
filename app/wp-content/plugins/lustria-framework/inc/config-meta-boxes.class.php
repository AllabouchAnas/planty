<?php
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}

if (!class_exists('G5P_Inc_Config_Meta_Boxes')) {
    class G5P_Inc_Config_Meta_Boxes
    {
	    /*
	 * loader instances
	 */
	    private static $_instance;

	    public static function getInstance()
	    {
		    if (self::$_instance == NULL) {
			    self::$_instance = new self();
		    }

		    return self::$_instance;
	    }

        public function init()
        {
            // Defined Theme Options
            add_filter('gsf_meta_box_config', array($this, 'register_meta_boxes'));
        }

	    public function getPostType() {
		    return apply_filters('gsf_page_setting_post_type', array('page'));
	    }

        public function register_meta_boxes($configs)
        {
            $prefix = G5P()->getMetaPrefix();

            if(class_exists('WooCommerce')) {
                $configs['gsf_product_setting'] = array(
                    'name'      => esc_html__('Product Settings', 'lustria-framework'),
                    'post_type' => array('product'),
                    'layout'    => 'inline',
                    'section' => array(
                        array(
                            'id' => "{$prefix}section_product_general",
                            'title' => esc_html__('Single Product', 'lustria-framework'),
                            'icon' => 'dashicons dashicons-welcome-write-blog',
                            'fields' => array(
                                array(
                                    'id' => "{$prefix}product_single_layout",
                                    'title' => esc_html__('Product Single Layout', 'lustria-framework'),
                                    'subtitle' => esc_html__('Specify your product single layout', 'lustria-framework'),
                                    'type' => 'image_set',
                                    'options' => G5P()->settings()->get_product_single_layout(true),
                                    'default' => ''
                                ),
                                array(
                                    'id' => "{$prefix}product_single_video",
                                    'title' => esc_html__('Product Video Introduction', 'lustria-framework'),
                                    'subtitle' => esc_html__('Video URL', 'lustria-framework'),
                                    'type' => 'text',
                                    'width' => '350px',
                                    'default' => ''
                                )
                            )
                        ),
                        array(
                            'id' => "{$prefix}section_product_related",
                            'title' => esc_html__('Related Products', 'lustria-framework'),
                            'icon' => 'dashicons dashicons-images-alt2',
                            'fields' => array(
                                G5P()->configOptions()->get_config_toggle(array(
                                    'id' => "{$prefix}product_related_enable",
                                    'title' => esc_html__('Show Related Products', 'lustria-framework'),
                                    'default' => ''
                                ), true),
                                array(
                                    'id' => "{$prefix}product_related_algorithm",
                                    'title' => esc_html__('Related Products Algorithm', 'lustria-framework'),
                                    'subtitle' => esc_html__('Specify the algorithm of related products', 'lustria-framework'),
                                    'type' => 'select',
                                    'options' => G5P()->settings()->get_related_product_algorithm(true),
                                    'default' => '',
                                    'required' => array("{$prefix}product_related_enable", 'in', array('on', ''))
                                ),
                                G5P()->configOptions()->get_config_toggle(array(
                                    'id' => "{$prefix}product_related_carousel_enable",
                                    'title' => esc_html__('Carousel Mode', 'lustria-framework'),
                                    'subtitle' => esc_html__('Turn On this option if you want to enable carousel mode', 'lustria-framework'),
                                    'default' => '',
                                    'required' => array("{$prefix}product_related_enable", 'in', array('on', ''))
                                ), true),
                                array(
                                    'id' => "{$prefix}product_related_columns_gutter",
                                    'title' => esc_html__('Product Columns Gutter', 'lustria-framework'),
                                    'subtitle' => esc_html__('Specify your horizontal space between product.', 'lustria-framework'),
                                    'type' => 'select',
                                    'options' => G5P()->settings()->get_post_columns_gutter(true),
                                    'default' => '',
                                    'required' => array("{$prefix}product_related_enable", 'in', array('on', ''))
                                ),
                                array(
                                    'id' => "{$prefix}product_related_columns_group",
                                    'title' => esc_html__('Product Columns', 'lustria-framework'),
                                    'type' => 'group',
                                    'required' => array("{$prefix}product_related_enable", 'in', array('on', '')),
                                    'fields' => array(
                                        array(
                                            'id' => "{$prefix}product_related_columns_row_1",
                                            'type' => 'row',
                                            'col' => 3,
                                            'fields' => array(
                                                array(
                                                    'id' => "{$prefix}product_related_columns",
                                                    'title' => esc_html__('Large Devices', 'lustria-framework'),
                                                    'desc' => esc_html__('Specify your related products columns on large devices (>= 1200px)', 'lustria-framework'),
                                                    'type' => 'select',
                                                    'options' => G5P()->settings()->get_post_columns(true),
                                                    'default' => '',
                                                    'layout' => 'full',
                                                ),
                                                array(
                                                    'id' => "{$prefix}product_related_columns_md",
                                                    'title' => esc_html__('Medium Devices', 'lustria-framework'),
                                                    'desc' => esc_html__('Specify your related products columns on medium devices (>= 992px)', 'lustria-framework'),
                                                    'type' => 'select',
                                                    'options' => G5P()->settings()->get_post_columns(true),
                                                    'default' => '',
                                                    'layout' => 'full',
                                                ),
                                                array(
                                                    'id' => "{$prefix}product_related_columns_sm",
                                                    'title' => esc_html__('Small Devices', 'lustria-framework'),
                                                    'desc' => esc_html__('Specify your related products columns on small devices (>= 768px)', 'lustria-framework'),
                                                    'type' => 'select',
                                                    'options' => G5P()->settings()->get_post_columns(true),
                                                    'default' => '',
                                                    'layout' => 'full',
                                                ),
                                                array(
                                                    'id' => "{$prefix}product_related_columns_xs",
                                                    'title' => esc_html__('Extra Small Devices ', 'lustria-framework'),
                                                    'desc' => esc_html__('Specify your related products columns on extra small devices (< 768px)', 'lustria-framework'),
                                                    'type' => 'select',
                                                    'options' => G5P()->settings()->get_post_columns(true),
                                                    'default' => '',
                                                    'layout' => 'full',
                                                ),
                                                array(
                                                    'id' => "{$prefix}product_related_columns_mb",
                                                    'title' => esc_html__('Extra Extra Small Devices ', 'lustria-framework'),
                                                    'desc' => esc_html__('Specify your related products columns on extra extra small devices (< 576px)', 'lustria-framework'),
                                                    'type' => 'select',
                                                    'options' => G5P()->settings()->get_post_columns(true),
                                                    'default' => '',
                                                    'layout' => 'full',
                                                )
                                            )
                                        ),
                                    )
                                ),
                                array(
                                    'id' => "{$prefix}product_related_per_page",
                                    'title' => esc_html__('Products Per Page', 'lustria-framework'),
                                    'subtitle' => esc_html__('Enter number of products per page you want to display.', 'lustria-framework'),
                                    'type' => 'text',
                                    'input_type' => 'number',
                                    'default' => '',
                                    'required' => array("{$prefix}product_related_enable", 'in', array('on', ''))
                                ),
                                array(
                                    'id' => "{$prefix}product_related_animation",
                                    'title' => esc_html__('Animation', 'lustria-framework'),
                                    'subtitle' => esc_html__('Specify your product animation', 'lustria-framework'),
                                    'type' => 'select',
                                    'options' => G5P()->settings()->get_animation(true),
                                    'default' => '',
                                    'required' => array("{$prefix}product_related_enable", 'in', array('on', ''))
                                )
                            )
                        )
                    )
                );
            }

            /**
             * CUSTOM PAGE SETTINGS
             */
            $configs['gsf_page_setting'] = array(
                'name' => esc_html__('Page Settings', 'lustria-framework'),
                'post_type' => $this->getPostType(),
                'layout' => 'inline',
	            'section' => array(
		            array(
			            'id' =>  "{$prefix}section_general",
			            'title' => esc_html__('General', 'lustria-framework'),
			            'icon' => 'dashicons dashicons-admin-site',
			            'fields' => array(
				            G5P()->configOptions()->get_config_preset(array('id' => "{$prefix}page_preset")),
				            array(
					            'id' => "{$prefix}group_layout",
					            'type' => 'group',
					            'title' => esc_html__('Layout','lustria-framework'),
					            'fields' => array(
						            array(
							            'id' => "{$prefix}main_layout",
							            'title' => esc_html__('Site Layout', 'lustria-framework'),
							            'type' => 'image_set',
							            'options' => G5P()->settings()->get_main_layout(true),
							            'default' => '',
						            ),

						            G5P()->configOptions()->get_config_toggle(array(
							            'id' => "{$prefix}content_full_width",
							            'title' => esc_html__('Content Full Width', 'lustria-framework'),
							            'subtitle' => esc_html__('Turn On this option if you want to expand the content area to full width.', 'lustria-framework'),
							            'default' => '',
						            ),true),

						            G5P()->configOptions()->get_config_toggle(array(
							            'id' => "{$prefix}custom_content_padding",
							            'title' => esc_html__('Custom Content Padding','lustria-framework'),
							            'subtitle' => esc_html__('Turn On this option if you want to custom content padding.', 'lustria-framework'),
							            'default' => ''
						            )),

						            array(
							            'id' => "{$prefix}content_padding",
							            'title' => esc_html__('Content Padding', 'lustria-framework'),
							            'subtitle' => esc_html__('Set content padding', 'lustria-framework'),
							            'type' => 'spacing',
							            'default' => array('left' => 0, 'right' => 0, 'top' => 50, 'bottom' => 50),
							            'required' => array("{$prefix}custom_content_padding",'=','on')
						            ),

						            G5P()->configOptions()->get_config_toggle(array(
							            'id' => "{$prefix}mobile_custom_content_padding",
							            'title' => esc_html__('Mobile Custom Content Padding','lustria-framework'),
							            'subtitle' => esc_html__('Turn On this option if you want to custom content padding on mobile devices.', 'lustria-framework'),
							            'default' => ''
						            )),

						            array(
							            'id' => "{$prefix}mobile_content_padding",
							            'title' => esc_html__('Mobile Content Padding', 'lustria-framework'),
							            'subtitle' => esc_html__('Set content padding', 'lustria-framework'),
							            'type' => 'spacing',
							            'default' => array('left' => 0, 'right' => 0, 'top' => 50, 'bottom' => 50),
							            'required' => array("{$prefix}mobile_custom_content_padding",'=','on')
						            ),

						            G5P()->configOptions()->get_config_sidebar_layout(array(
							            'id' => "{$prefix}sidebar_layout",
						            ),true),
						            G5P()->configOptions()->get_config_sidebar(array(
							            'id' => "{$prefix}sidebar",
							            'required' => array("{$prefix}sidebar_layout",'!=','none')
						            )),
					            )
				            ),

				            array(
					            'id' => "{$prefix}group_page_title",
					            'type' => 'group',
					            'title' => esc_html__('Page Title','lustria-framework'),
					            'fields' => array(
						            G5P()->configOptions()->get_config_toggle(array(
							            'title' => esc_html__('Page Title Enable','lustria-framework'),
							            'id' => "{$prefix}page_title_enable"
						            ),true),
						            G5P()->configOptions()->get_config_content_block(array(
							            'id' => "{$prefix}page_title_content_block",
							            'desc' => esc_html__('Specify the Content Block to use as a page title content.', 'lustria-framework'),
							            'required' => array("{$prefix}page_title_enable", '!=', 'off')
						            ),true),

						            array(
							            'title'       => esc_html__('Custom Page title', 'lustria-framework'),
							            'id'          => "{$prefix}page_title_content",
							            'type'        => 'text',
							            'default'     => '',
							            'required' => array("{$prefix}page_title_enable", '!=', 'off'),
							            'desc'        => esc_html__('Enter custom page title for this page', 'lustria-framework')
						            )
					            )
				            ),
				            array(
					            'title'        => esc_html__('Custom Css Class', 'lustria-framework'),
					            'id'          => "{$prefix}css_class",
					            'type'        => 'selectize',
					            'tags' => true,
					            'default'         => '',
					            'desc'        => esc_html__('Enter custom class for this page', 'lustria-framework')
				            )
			            )
		            ),
		            array(
			            'id' => "{$prefix}section_menu",
			            'title' => esc_html__('Menu', 'lustria-framework'),
			            'icon' => 'dashicons dashicons-menu',
			            'fields' => array(
				            array(
					            'id' => "{$prefix}page_menu",
					            'title' => esc_html__('Page Menu', 'lustria-framework'),
					            'type' => 'selectize',
					            'allow_clear' => true,
					            'placeholder' => esc_html__('Select Menu', 'lustria-framework'),
					            'desc' => esc_html__('Optionally you can choose to override the menu that is used on the page', 'lustria-framework'),
					            'data' => 'menu'
				            ),
				            array(
					            'id' => "{$prefix}page_mobile_menu",
					            'title' => esc_html__('Page Mobile Menu', 'lustria-framework'),
					            'type' => 'selectize',
					            'allow_clear' => true,
					            'placeholder' => esc_html__('Select Menu', 'lustria-framework'),
					            'desc' => esc_html__('Optionally you can choose to override the menu mobile that is used on the page', 'lustria-framework'),
					            'data' => 'menu'
				            ),
				            G5P()->configOptions()->get_config_toggle(array(
					            'id' => "{$prefix}is_one_page",
					            'title' => esc_html__('Is One Page', 'lustria-framework'),
					            'desc' => esc_html__('Set page style is One Page', 'lustria-framework'),
				            ))
			            )
		            ),

	            ),
            );

            /**
             * CUSTOME POST SETTING
             */
            $configs['gsf_post_setting'] = array(
                'name' => esc_html__('Post Settings', 'lustria-framework'),
                'post_type' => array('post'),
                'layout' => 'inline',
                'section' => array(
                    array(
                        'id' =>  "{$prefix}section_post_general",
                        'title' => esc_html__('General', 'lustria-framework'),
                        'icon' => 'dashicons dashicons-admin-site',
                        'fields' => array(
                            array(
                                'id' => "gf_format_video_embed",
                                'title' => esc_html__('Featured Video/Audio Code','lustria-framework'),
                                'subtitle' => esc_html__('Paste YouTube, Vimeo or self hosted video URL then player automatically will be generated.','lustria-framework'),
                                'type' => 'textarea'
                            ),
                            array(
                                'id' => "gf_format_audio_embed",
                                'title' => esc_html__('Featured Video/Audio Code','lustria-framework'),
                                'subtitle' => esc_html__('Paste YouTube, Vimeo or self hosted video URL then player automatically will be generated.','lustria-framework'),
                                'type' => 'textarea'
                            ),
                            array(
                                'id' => "gf_format_gallery_images",
                                'title' => esc_html__('Featured Gallery','lustria-framework'),
                                'subtitle' => esc_html__('Select images for featured gallery. (Apply for post format gallery)','lustria-framework'),
                                'type' => 'gallery'
                            ),
                            array(
                                'id' => "gf_format_link_url",
                                'title' => esc_html__('Featured Link','lustria-framework'),
                                'subtitle' => esc_html__('Enter featured link. (Apply for post format link)','lustria-framework'),
                                'type' => 'text'
                            ),
                            array(
                                'id' => "{$prefix}single_post_layout",
                                'title' => esc_html__('Post Layout', 'lustria-framework'),
                                'subtitle' => esc_html__('Specify your post layout', 'lustria-framework'),
                                'type' => 'image_set',
                                'options' => G5P()->settings()->get_single_post_layout(true),
                                'default' => ''
                            ),
                            G5P()->configOptions()->get_config_toggle(array(
                                'id' => "{$prefix}single_reading_process_enable",
                                'title' => esc_html__('Reading Process', 'lustria-framework'),
                                'subtitle' => esc_html__('Turn Off this option if you want to hide reading process on single blog', 'lustria-framework'),
                                'default' => ''
                            ), true),
                            G5P()->configOptions()->get_config_toggle(array(
                                'id' => "{$prefix}single_tag_enable",
                                'title' => esc_html__('Tags', 'lustria-framework'),
                                'subtitle' => esc_html__('Turn Off this option if you want to hide tags on single blog', 'lustria-framework'),
                                'default' => ''
                            ), true),
                            G5P()->configOptions()->get_config_toggle(array(
                                'id' => "{$prefix}single_share_enable",
                                'title' => esc_html__('Share', 'lustria-framework'),
                                'subtitle' => esc_html__('Turn Off this option if you want to hide share on single blog', 'lustria-framework'),
                                'default' => ''
                            ), true),
                            G5P()->configOptions()->get_config_toggle(array(
                                'id' => "{$prefix}single_navigation_enable",
                                'title' => esc_html__('Navigation', 'lustria-framework'),
                                'subtitle' => esc_html__('Turn Off this option if you want to hide navigation on single blog', 'lustria-framework'),
                                'default' => ''
                            ), true),
                            G5P()->configOptions()->get_config_toggle(array(
                                'id' => "{$prefix}single_author_info_enable",
                                'title' => esc_html__('Author Info', 'lustria-framework'),
                                'subtitle' => esc_html__('Turn Off this option if you want to hide author info area on single blog', 'lustria-framework'),
                                'default' => ''
                            ), true)
                        )
                    ),
                    array(
                        'id' =>  "{$prefix}section_post_related",
                        'title' => esc_html__('Related Posts', 'lustria-framework'),
                        'icon' => 'dashicons dashicons-images-alt2',
                        'fields' => array(
                            G5P()->configOptions()->get_config_toggle(array(
                                'id' => "{$prefix}single_related_post_enable",
                                'title' => esc_html__('Related Posts', 'lustria-framework'),
                                'subtitle' => esc_html__('Turn Off this option if you want to hide related posts area on single blog', 'lustria-framework'),
                                'default' => ''
                            ), true),
                            array(
                                'id' => "{$prefix}single_related_post_algorithm",
                                'title' => esc_html__('Related Posts Algorithm', 'lustria-framework'),
                                'subtitle' => esc_html__('Specify the algorithm of related posts', 'lustria-framework'),
                                'type' => 'select',
                                'options' => G5P()->settings()->get_related_post_algorithm(true),
                                'default' => '',
                                'required' => array("{$prefix}single_related_post_enable",'in',array('on', ''))
                            ),
                            G5P()->configOptions()->get_config_toggle(array(
                                'id' => "{$prefix}single_related_post_carousel_enable",
                                'title' => esc_html__('Carousel Mode', 'lustria-framework'),
                                'subtitle' => esc_html__('Turn On this option if you want to enable carousel mode', 'lustria-framework'),
                                'default' => '',
                                'required' => array("{$prefix}single_related_post_enable",'in',array('on', ''))
                            ), true),
                            array(
                                'id' => "{$prefix}single_related_post_per_page",
                                'title' => esc_html__('Posts Per Page', 'lustria-framework'),
                                'subtitle' => esc_html__('Enter number of posts per page you want to display', 'lustria-framework'),
                                'type' => 'text',
                                'input_type' => 'number',
                                'default' => '',
                                'required' => array("{$prefix}single_related_post_enable",'in',array('on', ''))
                            ),
                            array(
                                'id' => "{$prefix}single_related_post_columns_gutter",
                                'title' => esc_html__('Post Columns Gutter', 'lustria-framework'),
                                'subtitle' => esc_html__('Specify your horizontal space between post.', 'lustria-framework'),
                                'type' => 'select',
                                'options' => G5P()->settings()->get_post_columns_gutter(true),
                                'default' => '',
                                'required' => array("{$prefix}single_related_post_enable",'in',array('on', ''))
                            ),
                            array(
                                'id' => "{$prefix}single_related_post_columns_group",
                                'title' => esc_html__('Post Columns', 'lustria-framework'),
                                'type' => 'group',
                                'required' => array("{$prefix}single_related_post_enable",'in',array('on', '')),
                                'fields' => array(
                                    array(
                                        'id' => "{$prefix}single_related_post_columns_row_1",
                                        'type' => 'row',
                                        'col' => 3,
                                        'fields' => array(
                                            array(
                                                'id' => "{$prefix}single_related_post_columns",
                                                'title' => esc_html__('Large Devices', 'lustria-framework'),
                                                'desc' => esc_html__('Specify your post columns on large devices (>= 1200px)', 'lustria-framework'),
                                                'type' => 'select',
                                                'options' => G5P()->settings()->get_post_columns(true),
                                                'default' => '',
                                                'layout' => 'full',
                                            ),
                                            array(
                                                'id' => "{$prefix}single_related_post_columns_md",
                                                'title' => esc_html__('Medium Devices', 'lustria-framework'),
                                                'desc' => esc_html__('Specify your post columns on medium devices (>= 992px)', 'lustria-framework'),
                                                'type' => 'select',
                                                'options' => G5P()->settings()->get_post_columns(true),
                                                'default' => '',
                                                'layout' => 'full',
                                            ),
                                            array(
                                                'id' => "{$prefix}single_related_post_columns_sm",
                                                'title' => esc_html__('Small Devices', 'lustria-framework'),
                                                'desc' => esc_html__('Specify your post columns on small devices (>= 768px)', 'lustria-framework'),
                                                'type' => 'select',
                                                'options' => G5P()->settings()->get_post_columns(true),
                                                'default' => '',
                                                'layout' => 'full',
                                            ),
                                            array(
                                                'id' => "{$prefix}single_related_post_columns_xs",
                                                'title' => esc_html__('Extra Small Devices ', 'lustria-framework'),
                                                'desc' => esc_html__('Specify your post columns on extra small devices (< 768px)', 'lustria-framework'),
                                                'type' => 'select',
                                                'options' => G5P()->settings()->get_post_columns(true),
                                                'default' => '',
                                                'layout' => 'full',
                                            ),
                                            array(
                                                'id' => "{$prefix}single_related_post_columns_mb",
                                                'title' => esc_html__('Extra Extra Small Devices ', 'lustria-framework'),
                                                'desc' => esc_html__('Specify your post columns on extra extra small devices (< 480px)', 'lustria-framework'),
                                                'type' => 'select',
                                                'options' => G5P()->settings()->get_post_columns(true),
                                                'default' => '',
                                                'layout' => 'full',
                                            )
                                        )
                                    ),
                                )
                            ),
                            array(
                                'id' => "{$prefix}single_related_post_paging",
                                'title' => esc_html__('Post Paging', 'lustria-framework'),
                                'subtitle' => esc_html__('Specify your post paging mode', 'lustria-framework'),
                                'type' => 'select',
                                'options' => G5P()->settings()->get_post_paging_small_mode(true),
                                'default' => '',
                                'required' => array("{$prefix}single_related_post_enable",'in',array('on', ''))
                            ),
                            array(
                                'id' => "{$prefix}single_related_post_animation",
                                'title' => esc_html__('Animation', 'lustria-framework'),
                                'subtitle' => esc_html__('Specify your post animation', 'lustria-framework'),
                                'type' => 'select',
                                'options' => G5P()->settings()->get_animation(true),
                                'default' => '',
                                'required' => array("{$prefix}single_related_post_enable",'in',array('on', ''))
                            )
                        )
                    ),
                    array(
                        'id' =>  "{$prefix}section_layout",
                        'title' => esc_html__('Layout', 'lustria-framework'),
                        'icon' => 'dashicons dashicons-editor-table',
                        'fields' => array(
                            G5P()->configOptions()->get_config_preset(array('id' => "{$prefix}page_preset")),
                            array(
                                'id' => "{$prefix}group_layout",
                                'type' => 'group',
                                'title' => esc_html__('Layout','lustria-framework'),
                                'fields' => array(
                                    array(
                                        'id' => "{$prefix}main_layout",
                                        'title' => esc_html__('Site Layout', 'lustria-framework'),
                                        'type' => 'image_set',
                                        'options' => G5P()->settings()->get_main_layout(true),
                                        'default' => '',
                                    ),

                                    G5P()->configOptions()->get_config_toggle(array(
                                        'id' => "{$prefix}content_full_width",
                                        'title' => esc_html__('Content Full Width', 'lustria-framework'),
                                        'subtitle' => esc_html__('Turn On this option if you want to expand the content area to full width.', 'lustria-framework'),
                                        'default' => '',
                                    ),true),

                                    G5P()->configOptions()->get_config_toggle(array(
                                        'id' => "{$prefix}custom_content_padding",
                                        'title' => esc_html__('Custom Content Padding','lustria-framework'),
                                        'subtitle' => esc_html__('Turn On this option if you want to custom content padding.', 'lustria-framework'),
                                        'default' => ''
                                    )),

                                    array(
                                        'id' => "{$prefix}content_padding",
                                        'title' => esc_html__('Content Padding', 'lustria-framework'),
                                        'subtitle' => esc_html__('Set content padding', 'lustria-framework'),
                                        'type' => 'spacing',
                                        'default' => array('left' => 0, 'right' => 0, 'top' => 50, 'bottom' => 50),
                                        'required' => array("{$prefix}custom_content_padding",'=','on')
                                    ),

                                    G5P()->configOptions()->get_config_toggle(array(
                                        'id' => "{$prefix}mobile_custom_content_padding",
                                        'title' => esc_html__('Mobile Custom Content Padding','lustria-framework'),
                                        'subtitle' => esc_html__('Turn On this option if you want to custom content padding on mobile devices.', 'lustria-framework'),
                                        'default' => ''
                                    )),

                                    array(
                                        'id' => "{$prefix}mobile_content_padding",
                                        'title' => esc_html__('Mobile Content Padding', 'lustria-framework'),
                                        'subtitle' => esc_html__('Set content padding', 'lustria-framework'),
                                        'type' => 'spacing',
                                        'default' => array('left' => 0, 'right' => 0, 'top' => 50, 'bottom' => 50),
                                        'required' => array("{$prefix}mobile_custom_content_padding",'=','on')
                                    ),

                                    G5P()->configOptions()->get_config_sidebar_layout(array(
                                        'id' => "{$prefix}sidebar_layout",
                                    ),true),
                                    G5P()->configOptions()->get_config_sidebar(array(
                                        'id' => "{$prefix}sidebar",
                                        'required' => array("{$prefix}sidebar_layout",'!=','none')
                                    )),
                                )
                            ),

                            array(
                                'id' => "{$prefix}group_page_title",
                                'type' => 'group',
                                'title' => esc_html__('Page Title','lustria-framework'),
                                'fields' => array(
                                    G5P()->configOptions()->get_config_toggle(array(
                                        'title' => esc_html__('Page Title Enable','lustria-framework'),
                                        'id' => "{$prefix}page_title_enable"
                                    ),true),
                                    G5P()->configOptions()->get_config_content_block(array(
                                        'id' => "{$prefix}page_title_content_block",
                                        'desc' => esc_html__('Specify the Content Block to use as a page title content.', 'lustria-framework'),
                                        'required' => array("{$prefix}page_title_enable", '!=', 'off')
                                    ),true),

                                    array(
                                        'title'       => esc_html__('Custom Page title', 'lustria-framework'),
                                        'id'          => "{$prefix}page_title_content",
                                        'type'        => 'text',
                                        'default'     => '',
                                        'required' => array("{$prefix}page_title_enable", '!=', 'off'),
                                        'desc'        => esc_html__('Enter custom page title for this page', 'lustria-framework')
                                    ),
                                    array(
                                        'title' => esc_html__('Custom Page Subtitle', 'lustria-framework'),
                                        'id' => "{$prefix}page_subtitle_content",
                                        'type' => 'text',
                                        'default' => '',
                                        'required' => array("{$prefix}page_title_enable", '!=', 'off'),
                                        'desc' => esc_html__('Enter custom page subtitle for this page', 'lustria-framework')
                                    )
                                )
                            ),
                            array(
                                'title'        => esc_html__('Custom Css Class', 'lustria-framework'),
                                'id'          => "{$prefix}css_class",
                                'type'        => 'selectize',
                                'tags' => true,
                                'default'         => '',
                                'desc'        => esc_html__('Enter custom class for this page', 'lustria-framework')
                            )
                        )
                    ),
                    array(
                        'id' => "{$prefix}section_menu",
                        'title' => esc_html__('Menu', 'lustria-framework'),
                        'icon' => 'dashicons dashicons-menu',
                        'fields' => array(
                            array(
                                'id' => "{$prefix}page_menu",
                                'title' => esc_html__('Page Menu', 'lustria-framework'),
                                'type' => 'selectize',
                                'allow_clear' => true,
                                'placeholder' => esc_html__('Select Menu', 'lustria-framework'),
                                'desc' => esc_html__('Optionally you can choose to override the menu that is used on the page', 'lustria-framework'),
                                'data' => 'menu'
                            ),
                            array(
                                'id' => "{$prefix}page_mobile_menu",
                                'title' => esc_html__('Page Mobile Menu', 'lustria-framework'),
                                'type' => 'selectize',
                                'allow_clear' => true,
                                'placeholder' => esc_html__('Select Menu', 'lustria-framework'),
                                'desc' => esc_html__('Optionally you can choose to override the menu mobile that is used on the page', 'lustria-framework'),
                                'data' => 'menu'
                            ),
                            G5P()->configOptions()->get_config_toggle(array(
                                'id' => "{$prefix}is_one_page",
                                'title' => esc_html__('Is One Page', 'lustria-framework'),
                                'desc' => esc_html__('Set page style is One Page', 'lustria-framework'),
                            ))
                        )
                    ),
                )
            );

            return $configs;
        }
    }
}