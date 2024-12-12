<?php
if (!defined('ABSPATH')) {
	exit('Direct script access denied.');
}

if (!class_exists('G5P_Dashboard_Welcome')) {
	class G5P_Dashboard_Welcome
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

		public function init() {

		}

		public function render_content() {
			G5P()->helper()->getTemplate('core/dashboard/templates/dashboard', array('current_page' => 'welcome'));
		}


		public function get_features() {
            $current_theme = wp_get_theme();
            $themes_info = G5P()->theme_info();
            return array(
                array(
                    'icon' => 'dashicons dashicons-book',
                    'label' => esc_html__('Documentation', 'lustria-framework'),
                    'description' => sprintf(__('This is the place to go to reference different aspects of the theme. Our online documentation is an incredible resource for learning the ins and outs of using %1$s.', 'lustria-framework'),$current_theme['Name']),
                    'button_text' => esc_html__('Documentation', 'lustria-framework'),
                    'button_url' => $themes_info['docs']
                ),
                array(
                    'icon' => 'dashicons dashicons-portfolio',
                    'label' => esc_html__('Knowledge Base', 'lustria-framework'),
                    'description' => esc_html__('Our knowledge base contains additional content that is not inside of our documentation. This information is more specific and unique to various versions or aspects of theme.', 'lustria-framework'),
                    'button_text' => esc_html__('Knowledgebase', 'lustria-framework'),
                    'button_url' => $themes_info['knowledgeBase']
                ),
                array(
                    'icon' => 'dashicons dashicons-format-video',
                    'label' => esc_html__('Video Tutorials', 'lustria-framework'),
                    'description' => sprintf(__('Nothing is better than watching a video to learn. We have a growing library of high-definititon, narrated video tutorials to help teach you the different aspects of using %1$s.','lustria-framework'),$current_theme['Name']),
                    'button_text' => esc_html__('Watch Videos', 'lustria-framework'),
                    'button_url' => $themes_info['video_tutorials_url']
                ),
                array(
                    'icon' => 'dashicons dashicons-sos',
                    'label' => esc_html__('Support forum', 'lustria-framework'),
                    'description' => sprintf(__('We offer outstanding support through our forum. To get support first you need to register (create an account) and open a thread in the %1$s Section.','lustria-framework'),$current_theme['Name']),
                    'button_text' => esc_html__('Open Forum', 'lustria-framework'),
                    'button_url' => $themes_info['support']
                ),
            );
        }
	}
}