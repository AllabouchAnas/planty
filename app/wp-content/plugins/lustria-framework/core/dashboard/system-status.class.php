<?php
if (!defined('ABSPATH')) {
	exit('Direct script access denied.');
}

if (!class_exists('G5P_Dashboard_System_Status')) {
	class G5P_Dashboard_System_Status
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
            add_action('admin_enqueue_scripts', array($this, 'admin_enqueue'));
		}

		public function admin_enqueue() {
            wp_enqueue_script(G5P()->assetsHandle('dashboard-system-status'));
            wp_enqueue_style('powertip');
            wp_enqueue_style('powertip-dark');
            wp_enqueue_script('powertip');
        }

		public function render_content() {
			G5P()->helper()->getTemplate('core/dashboard/templates/dashboard', array('current_page' => 'system'));
		}

		public function get_settings()
		{
		    $theme_info = G5P()->theme_info();
			$current_theme = wp_get_theme();
			return array(
				array(
					'label' => sprintf(esc_html__('%s Versions', 'lustria-framework'), $current_theme['Name']),
					'fields' => array(
						array(
							'label' => esc_html__('Current Version', 'lustria-framework'),
							'help' => '',
							'content' => $current_theme['Version']
						),
						array(
							'label' => esc_html__('Update History', 'lustria-framework'),
							'help' => '',
							'content' => sprintf(wp_kses_post(__('<a target="_blank" href="%1$s">View changelog details</a>', 'lustria-framework')), $theme_info['changelog'])
						)
					)
				),
				array(
					'label' => esc_html__('WordPress Environment', 'lustria-framework'),
					'fields' => array(
						array(
							'label' => esc_html__('Home URL', 'lustria-framework'),
							'help' => esc_html__('The URL of your site\'s homepage.', 'lustria-framework'),
							'content' => home_url('/')
						),
						array(
							'label' => esc_html__('Site URL', 'lustria-framework'),
							'help' => esc_html__('The root URL of your site.', 'lustria-framework'),
							'content' => site_url('/')
						),
						array(
							'label' => esc_html__('WP Version', 'lustria-framework'),
							'help' => esc_html__('The version of WordPress installed on your site.', 'lustria-framework'),
							'content' => get_bloginfo('version')
						),
						array(
							'label' => esc_html__('WP Multisite', 'lustria-framework'),
							'help' => esc_html__('Whether or not you have WordPress Multisite enabled.', 'lustria-framework'),
							'content' => is_multisite() ? esc_html__('Enable', 'lustria-framework') : esc_html__('Disable', 'lustria-framework')
						),
						array(
							'label' => esc_html__('WP Memory Limit', 'lustria-framework'),
							'help' => esc_html__('The maximum amount of memory (RAM) that your site can use at one time.', 'lustria-framework'),
							'content' => $this->get_memory_limit_markup()
						),
						array(
							'label' => esc_html__('WP Debug Mode', 'lustria-framework'),
							'help' => esc_html__('Displays whether or not WordPress is in Debug Mode.', 'lustria-framework'),
							'content' => (defined('WP_DEBUG') && WP_DEBUG) ? esc_html__('Enable', 'lustria-framework') : esc_html__('Disable', 'lustria-framework')
						),
						array(
							'label' => esc_html__('Language', 'lustria-framework'),
							'help' => esc_html__('The current language used by WordPress. Default = English', 'lustria-framework'),
							'content' => get_locale()
						)

					)
				),
				array(
					'label' => esc_html__('Server Environment', 'lustria-framework'),
					'fields' => array(
						array(
							'label' => esc_html__('Server Info', 'lustria-framework'),
							'help' => esc_html__('Information about the web server that is currently hosting your site.', 'lustria-framework'),
							'content' => $_SERVER['SERVER_SOFTWARE']
						),
						array(
							'label' => esc_html__('PHP Version', 'lustria-framework'),
							'help' => esc_html__('The version of PHP installed on your hosting server.', 'lustria-framework'),
							'content' => $this->get_php_version_markup()
						),
						array(
							'label' => esc_html__('Post Max Size', 'lustria-framework'),
							'help' => esc_html__('The largest file size that can be contained in one post.', 'lustria-framework'),
							'content' => $this->get_php_post_max_size_markup()
						),
						array(
							'label' => esc_html__('Max Execution Time', 'lustria-framework'),
							'help' => esc_html__('The amount of time (in seconds) that your site will spend on a single operation before timing out (to avoid server lockups)', 'lustria-framework'),
							'content' => $this->get_php_max_execution_time_markup()
						),
						array(
							'label' => esc_html__('Max Input Vars', 'lustria-framework'),
							'help' => esc_html__('The maximum number of variables your server can use for a single function to avoid overloads.', 'lustria-framework'),
							'content' => $this->get_php_max_input_var_markup()
						),
						array(
							'label' => esc_html__('ZipArchive', 'lustria-framework'),
							'help' => esc_html__('ZipArchive is required for importing demos. They are used to import and export zip files specifically for sliders.', 'lustria-framework'),
							'content' => class_exists('ZipArchive') ? array('status' => true, 'html' => esc_html__('Enable', 'lustria-framework')) : array('status' => false, 'html' => esc_html__('Disable', 'lustria-framework'))
						),
						array(
							'label' => esc_html__('MySQL Version', 'lustria-framework'),
							'help' => esc_html__('The version of MySQL installed on your hosting server.', 'lustria-framework'),
							'content' => $this->get_mysql_version_markup()
						),
						array(
							'label' => esc_html__('Max Upload Size', 'lustria-framework'),
							'help' => esc_html__('The largest file size that can be uploaded to your WordPress installation.', 'lustria-framework'),
							'content' => size_format(wp_max_upload_size())
						)
					)
				),
				$this->get_plugins_active()

			);
		}

        private function memory_size_format( $size ) {
            $l   = substr( $size, -1 );
            $ret = substr( $size, 0, -1 );
            switch ( strtoupper( $l ) ) {
                case 'P':
                    $ret *= 1024;
                case 'T':
                    $ret *= 1024;
                case 'G':
                    $ret *= 1024;
                case 'M':
                    $ret *= 1024;
                case 'K':
                    $ret *= 1024;
            }
            return $ret;
        }

		private function get_memory_limit_markup()
		{
			$memory = $this->memory_size_format(WP_MEMORY_LIMIT);
			if ($memory < 128000000) {
				$status = false;
				$memory_limit_markup = '<mark class="error">' . sprintf(wp_kses_post(__('%1$s - We recommend setting memory to at least <strong>128MB</strong>.<br /> Please define memory limit in <strong>wp-config.php</strong> file.<br /> To learn how, see: <a href="%2$s" target="_blank" rel="noopener noreferrer">Increasing memory allocated to PHP.</a>', 'lustria-framework')), size_format($memory), 'http://codex.wordpress.org/Editing_wp-config.php#Increasing_memory_allocated_to_PHP') . '</mark>';
			} else {
				$status = true;
				$memory_limit_markup = size_format($memory);
			}
			return array(
				'status' => $status,
				'html' => $memory_limit_markup
			);
		}

		private function get_php_version_markup()
		{
			if (!function_exists('phpversion')) return '';
			$php_version = phpversion();
			if ($php_version < 5.4) {
				$status = false;
				$php_version_markup = '<mark class="error">' . sprintf(wp_kses_post(__('%1$s - We recommend use php version at least <strong>5.4</strong>. <br /> Please <a href="%2$s" target="_blank">download and update latest version</a>', 'lustria-framework')), $php_version, 'http://php.net/downloads.php') . '</mark>';
			} else {
				$status = true;
				$php_version_markup = $php_version;
			}
			return array(
				'status' => $status,
				'html' => $php_version_markup
			);
		}

		private function get_php_post_max_size_markup()
		{
			if (!function_exists('ini_get')) return '';
			$post_max_size = $this->memory_size_format(ini_get('post_max_size'));
			if ($post_max_size < 64000000) {
				$status = false;
				$post_max_size_markup = '<mark class="error">' . sprintf(wp_kses_post(__('%1$s - We recommend setting post max size to at least <strong>64MB</strong>.', 'lustria-framework')), size_format($post_max_size)) . '</mark>';
			} else {
				$status = true;
				$post_max_size_markup = size_format($post_max_size);
			}
			return array(
				'status' => $status,
				'html' => $post_max_size_markup
			);

		}

		private function get_php_max_execution_time_markup()
		{
			if (!function_exists('ini_get')) return '';
			$max_execution_time = ini_get('max_execution_time');
			if ($max_execution_time < 300) {
				$status = false;
				$max_execution_time_markup = '<mark class="error">' . sprintf(wp_kses_post(__('%1$s - We recommend setting max execution time to at least 300.<br />See: <a href="%2$s" target="_blank" rel="noopener noreferrer">Increasing max execution to PHP</a>', 'lustria-framework')), $max_execution_time, 'http://codex.wordpress.org/Common_WordPress_Errors#Maximum_execution_time_exceeded') . '</mark>';
			} else {
				$status = true;
				$max_execution_time_markup = $max_execution_time;
			}
			return array(
				'status' => $status,
				'html' => $max_execution_time_markup
			);
		}

		private function get_php_max_input_var_markup()
		{
			if (!function_exists('ini_get')) return '';
			$max_input_var = ini_get('max_input_vars');
			if ($max_input_var < 3000) {
				$status = false;
				$max_input_var_markup = '<mark class="error">' . sprintf(wp_kses_post(__('%1$s - We recommend setting max input var to at least 3000.<br /> Max input vars limitation will truncate POST data such as menus See: <a href="%2$s" target="_blank" rel="noopener noreferrer">Increasing max input vars limit.</a>', 'lustria-framework')), $max_input_var, 'http://sevenspark.com/docs/ubermenu-3/faqs/menu-item-limit') . '</mark>';
			} else {
				$status = true;
				$max_input_var_markup = $max_input_var;
			}
			return array(
				'status' => $status,
				'html' => $max_input_var_markup
			);
		}

		private function get_mysql_version_markup()
		{
			global $wpdb;
			return $wpdb->db_version();
		}

		private function get_plugins_active()
		{
			$fields = array();
			$active_plugins = get_option('active_plugins');
			$active_plugin_count = 0;
			if (is_array($active_plugins)) {
				$active_plugin_count = sizeof($active_plugins);

				foreach ($active_plugins as $plugin) {
					$plugin_data = get_plugin_data(WP_PLUGIN_DIR . '/' . $plugin);
					if (!empty($plugin_data['Name'])) {

						$label = '';

						if (!empty($plugin_data['PluginURI'])) {
							$label = '<a target="_blank" title="'. esc_html__('Visit plugin homepage', 'lustria-framework') .'" href="'. esc_url($plugin_data['PluginURI']) .'">' . $plugin_data['Name'] . '</a>';
						}

						$content = '';
						$author_markup = '';
						if (!empty($plugin_data['Author'])) {
							$author_markup = $plugin_data['Author'];
						}

						if (!empty($plugin_data['AuthorURI'])) {
							$author_markup = '<a target="_blank" href="'. esc_url($plugin_data['AuthorURI']) .'" title="'. esc_attr($author_markup) .'">' . $author_markup . '</a>';
						}

						$content = esc_html__('by ', 'lustria-framework') . $author_markup;

						$field = array(
							'label' => $label,
							'content' => $content
						);
						$fields[] = $field;
					}
				}

			}
			return array(
				'label' => sprintf(__('Active Plugins (%1$s)', 'lustria-framework'), $active_plugin_count),
				'fields' => $fields
			);
		}
	}
}