<?php
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}

if (!class_exists('G5P_Inc_Config_User_Meta')) {
    class G5P_Inc_Config_User_Meta
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
            add_filter('gsf_user_meta_config', array($this, 'register_user_meta'));
        }


        public function register_user_meta()
        {
            $prefix = G5P()->getMetaPrefix();
            /**
             * CUSTOM PAGE SETTINGS
             */
            $configs['gsf_user_meta_setting'] = array(
                'name' => esc_html__('Social Networks', 'lustria-framework'),
                'layout' => 'inline',
	            'fields' => array(
		            array(
			            'id' => "{$prefix}social_networks",
			            'title' => esc_html__('Social Networks', 'lustria-framework'),
			            'desc' => esc_html__('Define here all the social networks you will need.', 'lustria-framework'),
			            'type' => 'panel',
			            'toggle_default' => false,
			            'default' => G5P()->settings()->get_social_networks_default(),
			            'panel_title' => 'social_name',
			            'fields' => array(
				            array(
					            'id' => 'social_name',
					            'title' => esc_html__('Title', 'lustria-framework'),
					            'subtitle' => esc_html__('Enter your social network name', 'lustria-framework'),
					            'type' => 'text',
				            ),
				            array(
					            'id' => 'social_id',
					            'title' => esc_html__('Unique Social Id', 'lustria-framework'),
					            'subtitle' => esc_html__('This value is created automatically and it shouldn\'t be edited unless you know what you are doing.', 'lustria-framework'),
					            'type' => 'text',
					            'input_type' => 'unique_id',
					            'default' => 'social-'
				            ),
				            array(
					            'id' => 'social_icon',
					            'title' => esc_html__('Social Network Icon', 'lustria-framework'),
					            'subtitle' => esc_html__('Specify the social network icon', 'lustria-framework'),
					            'type' => 'icon',
				            ),
				            array(
					            'id' => 'social_link',
					            'title' => esc_html__('Social Network Link', 'lustria-framework'),
					            'subtitle' => esc_html__('Enter your social network link', 'lustria-framework'),
					            'type' => 'text',
				            )
			            )
		            )
	            )
            );




            return $configs;
        }
    }
}