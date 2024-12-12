<?php
if (!defined('ABSPATH')) {
	exit('Direct script access denied.');
}

if (!class_exists('G5P_Dashboard_Plugins')) {
	class G5P_Dashboard_Plugins
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
			G5P()->helper()->getTemplate('core/dashboard/templates/dashboard', array('current_page' => 'plugins'));
		}

		public function get_plugins() {
		    if (class_exists('TGM_Plugin_Activation')) {
		        return TGM_Plugin_Activation::$instance->plugins;
            }
		    return array();
        }

        public function is_plugin_installed($slug){
		    if (class_exists('TGM_Plugin_Activation')) {
		        return TGM_Plugin_Activation::$instance->is_plugin_installed($slug);
            }
            return false;
        }

        public function is_plugin_active($slug) {
            if (class_exists('TGM_Plugin_Activation')) {
                return TGM_Plugin_Activation::$instance->is_plugin_active($slug);
            }
            return false;
        }

        public function does_plugin_have_update($slug) {
            if (class_exists('TGM_Plugin_Activation')) {
                return TGM_Plugin_Activation::$instance->does_plugin_have_update($slug);
            }
            return false;
        }

        public function get_actions_link($action,$slug) {
            $nonce_url = '#';
            if (class_exists('TGM_Plugin_Activation')) {
                $nonce_url = wp_nonce_url(
                    add_query_arg(
                        array(
                            'plugin'           => urlencode($slug),
                            'tgmpa-' . $action => $action . '-plugin',
                            'return_url' => 'gsf_plugins'
                        ),
                        admin_url('admin.php?page=gsf_plugins')
                    ),
                    'tgmpa-' . $action,
                    'tgmpa-nonce'
                );
            }
            return $nonce_url;
        }

        public function do_plugin_install(){
            if (class_exists('TGM_Plugin_Activation')) {
                if (empty($_GET['plugin'])) {
                    return false;
                }
                $_this = TGM_Plugin_Activation::$instance;
                // All plugin information will be stored in an array for processing.
                $slug = $_this->sanitize_key(urldecode($_GET['plugin']));


                if (!isset($_this->plugins[$slug])) {
                    return false;
                }

                // Was an install or upgrade action link clicked?
                if ((isset($_GET['tgmpa-install']) && 'install-plugin' === $_GET['tgmpa-install']) || (isset($_GET['tgmpa-update']) && 'update-plugin' === $_GET['tgmpa-update'])) {

                    $install_type = 'install';
                    if (isset($_GET['tgmpa-update']) && 'update-plugin' === $_GET['tgmpa-update']) {
                        $install_type = 'update';
                    }

                    check_admin_referer('tgmpa-' . $install_type, 'tgmpa-nonce');

                    // Pass necessary information via URL if WP_Filesystem is needed.
                    $url = wp_nonce_url(
                        add_query_arg(
                            array(
                                'plugin'                 => urlencode($slug),
                                'tgmpa-' . $install_type => $install_type . '-plugin',
                            ),
                            admin_url('admin.php?page=gsf_plugins')
                        ),
                        'tgmpa-' . $install_type,
                        'tgmpa-nonce'
                    );

                    $method = ''; // Leave blank so WP_Filesystem can populate it as necessary.

                    if (false === ($creds = request_filesystem_credentials(esc_url_raw($url), $method, false, false, array()))) {
                        return true;
                    }

                    if (!WP_Filesystem($creds)) {
                        request_filesystem_credentials(esc_url_raw($url), $method, true, false, array()); // Setup WP_Filesystem.
                        return true;
                    }

                    /* If we arrive here, we have the filesystem. */

                    // Prep variables for Plugin_Installer_Skin class.
                    $extra = array();
                    $extra['slug'] = $slug; // Needed for potentially renaming of directory name.
                    $source = $_this->get_download_url($slug);
                    $api = ('repo' === $_this->plugins[$slug]['source_type']) ? $_this->get_plugins_api($slug) : null;
                    $api = (false !== $api) ? $api : null;

                    $url = add_query_arg(
                        array(
                            'action' => $install_type . '-plugin',
                            'plugin' => urlencode($slug),
                        ),
                        'update.php'
                    );

                    if (!class_exists('Plugin_Upgrader', false)) {
                        require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
                    }

                    $title = ('update' === $install_type) ? $_this->strings['updating'] : $_this->strings['installing'];
                    $skin_args = array(
                        'type'   => ('bundled' !== $_this->plugins[$slug]['source_type']) ? 'web' : 'upload',
                        'title'  => sprintf($title, $_this->plugins[$slug]['name']),
                        'url'    => esc_url_raw($url),
                        'nonce'  => $install_type . '-plugin_' . $slug,
                        'plugin' => '',
                        'api'    => $api,
                        'extra'  => $extra,
                    );
                    unset($title);

                    if ('update' === $install_type) {
                        $skin_args['plugin'] = $_this->plugins[$slug]['file_path'];
                        $skin = new Plugin_Upgrader_Skin($skin_args);
                    } else {
                        $skin = new Plugin_Installer_Skin($skin_args);
                    }

                    // Create a new instance of Plugin_Upgrader.
                    $upgrader = new Plugin_Upgrader($skin);

                    // Perform the action and install the plugin from the $source urldecode().
                    add_filter('upgrader_source_selection', array($_this, 'maybe_adjust_source_dir'), 1, 3);

                    if ('update' === $install_type) {
                        // Inject our info into the update transient.
                        $to_inject = array($slug => $_this->plugins[$slug]);
                        $to_inject[$slug]['source'] = $source;
                        $_this->inject_update_info($to_inject);

                        $upgrader->upgrade($_this->plugins[$slug]['file_path']);
                    } else {
                        $upgrader->install($source);
                    }

                    remove_filter('upgrader_source_selection', array($_this, 'maybe_adjust_source_dir'), 1);

                    // Make sure we have the correct file path now the plugin is installed/updated.
                    $_this->populate_file_path($slug);

                    // Only activate plugins if the config option is set to true and the plugin isn't
                    // already active (upgrade).
                    if ($_this->is_automatic && !$_this->is_plugin_active($slug)) {
                        $plugin_activate = $upgrader->plugin_info(); // Grab the plugin info from the Plugin_Upgrader method.
                        if (false === $_this->activate_single_plugin($plugin_activate, $slug, true)) {
                            return true; // Finish execution of the function early as we encountered an error.
                        }
                    }

                    return true;
                } elseif (isset($_this->plugins[$slug]['file_path'], $_GET['tgmpa-activate']) && 'activate-plugin' === $_GET['tgmpa-activate']) {
                    // Activate action link was clicked.
                    check_admin_referer('tgmpa-activate', 'tgmpa-nonce');
                    activate_plugins($_this->plugins[$slug]['file_path']);
                    return true;
                } elseif (isset($_this->plugins[$slug]['file_path'], $_GET['tgmpa-deactived']) && 'deactived-plugin' === $_GET['tgmpa-deactived']) {
                    // Activate action link was clicked.
                    check_admin_referer('tgmpa-deactived', 'tgmpa-nonce');

                    deactivate_plugins($_this->plugins[$slug]['file_path']);

                    return true;
                }
                return false;
            }
            return false;

        }
	}
}