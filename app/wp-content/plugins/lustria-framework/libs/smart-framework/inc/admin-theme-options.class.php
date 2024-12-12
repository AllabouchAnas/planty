<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}
if (!class_exists('GSF_Inc_Admin_Theme_Options')) {
	class GSF_Inc_Admin_Theme_Options
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
			add_action('admin_menu', array($this, 'themeOptionsMenu'));

			add_action('wp_ajax_gsf_save_options', array($this, 'saveOptions'));
			add_action('wp_ajax_gsf_import_popup', array($this, 'importPopup'));
			add_action('wp_ajax_gsf_export_theme_options', array($this, 'exportThemeOption'));
			add_action('wp_ajax_gsf_import_theme_options', array($this, 'importThemeOptions'));
			add_action('wp_ajax_gsf_reset_theme_options', array($this, 'resetThemeOptions'));
			add_action('wp_ajax_gsf_reset_section_options', array($this, 'resetSectionOptions'));
			add_action('wp_ajax_gsf_create_preset_options', array($this, 'createPresetOptions'));
			add_action('wp_ajax_gsf_ajax_theme_options', array($this, 'ajaxThemeOption'));
			add_action('wp_ajax_gsf_delete_preset', array($this, 'deletePreset'));
		}

		public function themeOptionsMenu() {

			$current_page = isset($_GET['page']) ? $_GET['page'] : '';
			$configs = &$this->getOptionConfig();

			foreach ($configs as $page => $config) {
				if (isset($config['parent_slug'])) {
					if (empty($config['parent_slug'])) {
						add_menu_page(
							$config['page_title'],
							$config['menu_title'],
							$config['permission'],
							$page,
							array($this, 'binderPage'),
							isset($config['icon_url']) ? $config['icon_url'] : '',
							isset($config['position']) ? $config['position'] : null
						);
					}
					else {
						add_submenu_page(
							$config['parent_slug'],
							$config['page_title'],
							$config['menu_title'],
							$config['permission'],
							$page,
							array($this, 'binderPage')
						);
					}
				}
				else {
					add_theme_page(
						$config['page_title'],
						$config['menu_title'],
						$config['permission'],
						$page,
						array($this, 'binderPage')
					);
				}

				if ($current_page == $page) {
					// Enqueue common styles and scripts
					add_action('admin_init', array($this, 'adminEnqueueStyles'));
					add_action('admin_init', array($this, 'adminEnqueueScripts'), 15);
				}
			}
		}

		public function adminEnqueueStyles() {
			wp_enqueue_media();
			wp_enqueue_style('magnific-popup');
			wp_enqueue_style('font-awesome-5pro');
			wp_enqueue_style(GSF()->assetsHandle('options'));
			wp_enqueue_style(GSF()->assetsHandle('fields'));

		}

		public function adminEnqueueScripts() {
			wp_enqueue_media();
			wp_enqueue_script('magnific-popup');
			wp_enqueue_script('quicktags');

			wp_enqueue_script(GSF()->assetsHandle('fields'));
			wp_enqueue_script(GSF()->assetsHandle('options'));
			wp_localize_script(GSF()->assetsHandle('fields'), 'GSF_META_DATA', array(
				'ajaxUrl' => admin_url('admin-ajax.php'),
				'nonce'   => GSF()->helper()->getNonceValue(),
				'msgSavingOptions' => esc_html__('Saving Options...','lustria-framework'),
				'msgResettingOptions' => esc_html__('Resetting Options...','lustria-framework'),
				'msgResettingSection' => esc_html__('Resetting Section...','lustria-framework'),
				'msgConfirmResetSection'   => esc_html__('Are you sure? Resetting will lose all custom values.', 'lustria-framework'),
				'msgConfirmResetOptions' => esc_html__('Are you sure? Resetting will lose all custom values in this section.', 'lustria-framework'),
				'msgResetOptionsDone' => esc_html__('Reset theme options done','lustria-framework'),
				'msgResetOptionsError' => esc_html__('Reset theme options error','lustria-framework'),
				'msgResetSectionDone' => esc_html__('Reset section done','lustria-framework'),
				'msgResetSectionError' => esc_html__('Reset section error','lustria-framework'),
				'msgConfirmImportData'               => esc_html__('Are you sure?  This will overwrite all existing option values, please proceed with caution!', 'lustria-framework'),
				'msgImportDone'                      => esc_html__('Import option done', 'lustria-framework'),
				'msgImportError'                     => esc_html__('Import option error', 'lustria-framework'),
				'msgSaveWarning' => esc_html__('Settings have changed, you should save them!','lustria-framework'),
				'msgSaveSuccess' => esc_html__('Data saved successfully!','lustria-framework'),
				'msgConfirmDeletePreset'   => esc_html__('Are you sure? The current preset will be deleted!', 'lustria-framework'),
				'msgDeletePresetDone' => esc_html__('Reset theme options done','lustria-framework'),
				'msgDeletePresetError' => esc_html__('Reset theme options error','lustria-framework'),
				'msgDeletingPreset' => esc_html__('Deleting Section...','lustria-framework'),
				'msgPreventChangeData' => esc_html__('Changes you made may not be saved. Do you want change options?','lustria-framework')
			));
		}

		public function &getOptionConfig($page = '', $in_preset = false) {
			if (!isset($GLOBALS['gsf_option_config'])) {
				$GLOBALS['gsf_option_config'] = apply_filters('gsf_option_config', array());
			}
			if ($page === '') {
				return $GLOBALS['gsf_option_config'];
			}
			if (isset($GLOBALS['gsf_option_config'][$page])) {
				$configs = &$GLOBALS['gsf_option_config'][$page];
				$enable_preset = isset($configs['preset']) ? $configs['preset'] : false;
				if ($enable_preset && $in_preset) {
					$this->processPresetConfigSection($configs, $in_preset);
				}

				return $configs;
			}
			return array();
		}

		private function processPresetConfigSection(&$configs, $in_preset) {
			if (isset($configs['section'])) {
				foreach ($configs['section'] as $key => &$section) {
					if ($in_preset && isset($section['general_options']) && $section['general_options']) {
						unset($configs['section'][$key]);
						continue;
					}
					if (isset($section['fields'])) {
						$this->processPresetConfigField($section['fields'], $in_preset);
					}

				}
			}
			else {
				if (isset($configs['fields'])) {
					$this->processPresetConfigField($configs['fields'], $in_preset);
				}
			}
		}

		private function processPresetConfigField(&$fields, $in_preset) {
			foreach ($fields as $key => &$field) {
				if ($in_preset && isset($field['general_options']) && $field['general_options']) {
					unset($fields[$key]);
					continue;
				}
				$type = isset($field['type']) ? $field['type'] : '';

				switch ($type) {
					case 'group':
					case 'row':
					case 'panel':
					case 'repeater':
						if (isset($field['fields'])) {
							$this->processPresetConfigField($field['fields'], $in_preset);
						}
						break;
				}
			}
		}

		public function &getOptions($option_name) {
			$preset_name = isset($GLOBALS['gsf_current_preset']) ? $GLOBALS['gsf_current_preset'] : '';
			if (isset($_REQUEST['_gsf_preset'])) {
				$preset_name = $_REQUEST['_gsf_preset'];
			}


			if (!isset($GLOBALS['gsf_options'])) {
				$GLOBALS['gsf_options'] = array();
			}
			$options_key = $this->getOptionPresetName($option_name, $preset_name);

			if (isset($GLOBALS['gsf_options'][$options_key])) {
				return $GLOBALS['gsf_options'][$options_key];
			}
			$options = get_option($option_name);

			if (!is_array($options)) {
				$options = array();
			}

			if (!empty($preset_name)) {
				$preset_options = get_option($options_key);
				if (is_array($preset_options)) {
					foreach ($preset_options as $key => $value) {
						$options[$key] = $value;
					}
				}
			}

			$options_default = array();
			if (class_exists('GSF_Options')) {
				$options_default = GSF_Options::getInstance()->getDefault();
			}
			$options = array_merge($options_default, $options);

			$GLOBALS['gsf_options'][$options_key] = &$options;

			return $GLOBALS['gsf_options'][$options_key];
		}

		public function setOptions($option_name, &$new_options) {
			if (!isset($GLOBALS['gsf_options'])) {
				$GLOBALS['gsf_options'] = array();
			}
			$GLOBALS['gsf_options'][$option_name] = $new_options;
		}

		public function getPresetOptionKeys($option_name) {
			$option_keys = get_option('gsf_preset_options_keys_' . $option_name);
			if (!is_array($option_keys)) {
				$option_keys = array();
			}
			return $option_keys;
		}

		public function getOptionPresetName($option_name, $preset_name) {
			return $option_name . (!empty($preset_name) ? '__' . $preset_name : '');
		}

		public function updatePresetOptionsKey($option_name, $preset_name, $preset_title) {
			$option_keys = $this->getPresetOptionKeys($option_name);
			if (!isset($option_keys[$preset_name])) {
				$option_keys[$preset_name] = $preset_title;
			}
			update_option('gsf_preset_options_keys_' . $option_name, $option_keys);
		}
		public function deletePresetOptionKeys($option_name, $preset_name) {
			$option_keys = $this->getPresetOptionKeys($option_name);
			if (isset($option_keys[$preset_name])) {
				unset($option_keys[$preset_name]);
			}
			update_option('gsf_preset_options_keys_' . $option_name, $option_keys);
		}


		/**
		 * Binder Option Page
		 */
		public function binderPage() {
			add_action('admin_footer', array($this, 'binderPresetPopup'));
			$page = $_GET['page'];
			$current_preset = isset($_GET['_gsf_preset']) ? $_GET['_gsf_preset'] : '';
			$configs = &$this->getOptionConfig($page, !empty($current_preset));
			$enable_preset = isset($configs['preset']) ? $configs['preset'] : false;
			if (!$enable_preset) {
				$current_preset = '';
			}

			if (empty($current_preset)) {
				$this->enqueueOptionsAssets($configs);
			}
			else {
				$configs_general = apply_filters('gsf_option_config', array());
				$configs_general = isset($configs_general[$page]) ? $configs_general[$page] : array();
				$this->enqueueOptionsAssets($configs_general);
			}

			$option_name = $configs['option_name'];
			if (!empty($current_preset)) {
				$preset_keys = $this->getPresetOptionKeys($option_name);
				if (isset($preset_keys[$current_preset])) {
					$configs['page_title'] = $preset_keys[$current_preset];
				}
			}

			GSF()->helper()->setFieldLayout(isset($configs['layout']) ? $configs['layout'] : 'inline');

			/**
			 * Get Options Value
			 */
			$options = get_option($this->getOptionPresetName($option_name, $current_preset));
			?>
			<div class="gsf-theme-options-page">
				<?php
				GSF()->helper()->getTemplate('admin/templates/theme-options-start',
					array(
						'option_name' => $option_name,
						'page' => $page,
						'current_preset' => $current_preset,
						'page_title' => $configs['page_title'],
						'preset' => $enable_preset,
					)
				);
				GSF()->helper()->renderFields($configs, $options);
				GSF()->helper()->getTemplate('admin/templates/theme-options-end', array(
					'is_exists_section' => isset($configs['section'])
				));
				?>
			</div><!-- /.gsf-theme-options-page -->
			<?php
		}

		public function binderPresetPopup() {
			GSF()->helper()->getTemplate('admin/templates/preset-popup');
		}

		public function createPresetOptions() {
			$page = $_POST['_current_page'];
			$current_preset = $_POST['_current_preset'];
			$preset_title = $_POST['_preset_title'];
			$new_preset_name = sanitize_title($preset_title);

			$configs = &$this->getOptionConfig($page, !empty($new_preset_name));
			$enable_preset = isset($configs['preset']) ? $configs['preset'] : false;
			if (!$enable_preset) {
				die(0);
			}

			$option_name = $configs['option_name'];

			$options = get_option($this->getOptionPresetName($option_name, $current_preset));

			if (wp_verify_nonce($_POST['_wpnonce'], GSF()->helper()->getNonceVerifyKey())) {
				$new_preset_name = sanitize_title($preset_title);
				$option_keys = $this->getPresetOptionKeys($option_name);
				if (!isset($option_keys[$new_preset_name])) {
					if (!empty($new_preset_name)) {
						$option_default = GSF()->helper()->getConfigDefault($configs);

						foreach ($option_default as $key => $value) {
							if (!isset($options[$key])) {
								$options[$key] = $option_default[$key];
							}
						}
						foreach ($options as $key => $value) {
							if (!isset($option_default[$key])) {
								unset($options[$key]);
							}
						}

						update_option($this->getOptionPresetName($option_name, $new_preset_name), $options);
						$configs['page_title'] = $preset_title;
						$this->updatePresetOptionsKey($option_name, $new_preset_name, $preset_title);
					}
					$configs['option_name'] = $this->getOptionPresetName($option_name, $new_preset_name);
				}
			}


			GSF()->helper()->setFieldLayout(isset($configs['layout']) ? $configs['layout'] : 'inline');
			GSF()->helper()->getTemplate('admin/templates/theme-options-start',
				array(
					'option_name' => $option_name,
					'page' => $page,
					'current_preset' => $new_preset_name,
					'page_title' => $configs['page_title'],
					'preset' => true,
				)
			);

			GSF()->helper()->renderFields($configs, $options);
			GSF()->helper()->getTemplate('admin/templates/theme-options-end', array(
				'is_exists_section' => isset($configs['section'])
			));
			die();
		}

		public function ajaxThemeOption() {
			$page = $_POST['_current_page'];
			$current_preset = $_POST['_current_preset'];

			$configs = &$this->getOptionConfig($page, !empty($current_preset));

			$option_name = $configs['option_name'];
			$options = get_option($this->getOptionPresetName($option_name, $current_preset));

			$option_keys = $this->getPresetOptionKeys($option_name);
			if (isset($option_keys[$current_preset])) {
				$configs['page_title'] = $option_keys[$current_preset];
				$configs['option_name'] = $this->getOptionPresetName($option_name, $current_preset);
			}
			GSF()->helper()->setFieldLayout(isset($configs['layout']) ? $configs['layout'] : 'inline');
			GSF()->helper()->getTemplate('admin/templates/theme-options-start',
				array(
					'option_name' => $option_name,
					'page' => $page,
					'current_preset' => $current_preset,
					'page_title' => $configs['page_title'],
					'preset' => isset($configs['preset']) ? $configs['preset'] : false,
				)
			);

			GSF()->helper()->renderFields($configs, $options);
			GSF()->helper()->getTemplate('admin/templates/theme-options-end', array(
				'is_exists_section' => isset($configs['section'])
			));
			die();
		}

		public function importPopup() {
			$page = $_GET['_current_page'];
			$current_preset = $_GET['_current_preset'];
			$configs = &$this->getOptionConfig($page, !empty($current_preset));
			$option_name = $configs['option_name'];
			$options = get_option($this->getOptionPresetName($option_name, $current_preset));
			?>
			<div class="gsf-theme-options-backup-popup-wrapper mfp-with-anim">
				<div class="gsf-theme-options-backup-popup">
					<div class="gsf-theme-options-backup-header gsf-clearfix">
						<h4><?php esc_html_e('Import/Export Options','lustria-framework'); ?></h4>
					</div>
					<div class="gsf-theme-options-backup-content">
						<section>
							<h5><?php esc_html_e('Import Options','lustria-framework'); ?></h5>
							<div class="gsf-theme-options-backup-import">
								<textarea></textarea>
								<button type="button" class="button"
								        data-import-text="<?php esc_attr_e('Import','lustria-framework'); ?>"
								        data-importing-text="<?php esc_attr_e('Importing...','lustria-framework'); ?>"><?php esc_html_e('Import','lustria-framework'); ?></button>
								<span class=""><?php esc_html_e('WARNING! This will overwrite all existing option values, please proceed with caution!','lustria-framework'); ?></span>
							</div>
						</section>
						<section>
							<h5><?php esc_html_e('Export Options','lustria-framework'); ?></h5>
							<div class="gsf-theme-options-backup-export">
								<textarea readonly><?php echo base64_encode(json_encode($options)); ?></textarea>
								<button type="button" class="button"><?php esc_html_e('Download Data File','lustria-framework'); ?></button>
							</div>
						</section>
					</div>
				</div>
			</div>
		<?php
			die();
		}

		/**
		 * Save Options
		 */
		public function saveOptions() {
			$page = $_POST['_current_page'];
			$current_preset = $_POST['_current_preset'];

			$configs = &$this->getOptionConfig($page, !empty($current_preset));
			$option_name = $configs['option_name'];

			if (!wp_verify_nonce($_POST['_wpnonce'], GSF()->helper()->getNonceVerifyKey())) {
				return;
			}

			$config_keys = GSF()->helper()->getConfigKeys($configs);
			$field_default = GSF()->helper()->getConfigDefault($configs);

			$config_options = array();
			$meta_value = '';
			foreach ($config_keys as $meta_id => $field_meta) {
				if (isset($_POST[$meta_id])) {
					$meta_value = $_POST[$meta_id];
				}
				else {
					$meta_value = $field_meta['empty_value'];

				}
				$config_options[$meta_id] = wp_unslash($meta_value);
			}

			/**
			 * Call action before save options
			 */
			do_action("gsf_before_save_options/{$option_name}", $config_options, $current_preset);

			/**
			 * Update options
			 */
			update_option($this->getOptionPresetName($option_name, $current_preset), $config_options);

			if (!empty($current_preset)) {
				$default_options = get_option($option_name);
				$config_options = wp_parse_args($config_options, $default_options);
			}

			/**
			 * Call action after save options
			 */
			do_action("gsf_after_save_options/{$option_name}", $config_options, $current_preset);

			/**
			 * Call action after change options
			 */
			do_action("gsf_after_change_options/{$option_name}", $config_options, $current_preset);

			wp_send_json_success(esc_html__('Save options Done','lustria-framework'));
		}

		/**
		 * Export theme options
		 */
		public function exportThemeOption() {
			$page = $_GET['_current_page'];
			$current_preset = $_GET['_current_preset'];
			$configs = &$this->getOptionConfig($page, !empty($current_preset));
			$option_name = $configs['option_name'];

			if ( ! wp_verify_nonce( $_GET['_wpnonce'], GSF()->helper()->getNonceVerifyKey() ) ) {
				return;
			}

			$options = get_option($this->getOptionPresetName($option_name, $current_preset));
			header( 'Content-Description: File Transfer' );
			header( 'Content-type: application/txt' );
			header( 'Content-Disposition: attachment; filename="smart_framework_' . $option_name . '_backup_' . date( 'd-m-Y' ) . '.json"' );
			header( 'Content-Transfer-Encoding: binary' );
			header( 'Expires: 0' );
			header( 'Cache-Control: must-revalidate' );
			header( 'Pragma: public' );

			echo base64_encode(json_encode($options));
			die();
		}

		/**
		 * Import Options
		 */
		public function importThemeOptions() {
			$page = $_POST['_current_page'];
			$current_preset = $_POST['_current_preset'];
			$configs = &$this->getOptionConfig($page, !empty($current_preset));
			$option_name = $configs['option_name'];
			if ( ! wp_verify_nonce( $_POST['_wpnonce'], GSF()->helper()->getNonceVerifyKey() ) ) {
				return;
			}
			if (!isset($_POST['backup_data'])) {
				return;
			}
			$backup = json_decode(base64_decode($_POST['backup_data']), true);
			if (($backup == null) || !is_array($backup)) {
				return;
			}

			$options = get_option($this->getOptionPresetName($option_name, $current_preset));

			$option_default = GSF()->helper()->getConfigDefault($configs);

			foreach ($backup as $key => $value) {
				if (isset($option_default[$key])) {
					$options[$key] = $value;
				}
			}
			/**
			 * Call action after save options
			 */
			do_action("gsf_before_import_options/{$option_name}", $options, $current_preset);

			/**
			 * Update Options
			 */
			update_option($this->getOptionPresetName($option_name, $current_preset), $options);

			if (!empty($current_preset)) {
				$default_options = get_option($option_name);
				$options = wp_parse_args($options, $default_options);
			}

			/**
			 * Call action after save options
			 */
			do_action("gsf_after_import_options/{$option_name}", $options, $current_preset);

			/**
			 * Call action after change options
			 */
			do_action("gsf_after_change_options/{$option_name}", $options, $current_preset);

			echo 1;
			die();
		}

		public function resetThemeOptions() {
			$page = $_POST['_current_page'];
			$current_preset = isset($_POST['_current_preset']) ?  $_POST['_current_preset'] : '';

			$configs = &$this->getOptionConfig($page, !empty($current_preset));
			$option_name = $configs['option_name'];
			if ( ! wp_verify_nonce( $_POST['_wpnonce'], GSF()->helper()->getNonceVerifyKey() ) ) {
				return;
			}

			$options = GSF()->helper()->getConfigDefault($configs);

			do_action("gsf_before_reset_options/{$option_name}", $options, $current_preset);

			/**
			 * Update Options
			 */
			update_option($this->getOptionPresetName($option_name, $current_preset), $options);

			if (!empty($current_preset)) {
				$default_options = get_option($option_name);
				$options = wp_parse_args($options, $default_options);
			}

			/**
			 * Call action after reset options
			 */
			do_action("gsf_after_reset_options/{$option_name}", $options, $current_preset);

			/**
			 * Call action after change options
			 */
			do_action("gsf_after_change_options/{$option_name}", $options, $current_preset);

			echo 1;
			die();

		}

		public function resetSectionOptions() {
			$page = $_POST['_current_page'];
			$current_preset = isset($_POST['_current_preset']) ? $_POST['_current_preset'] : '';
			$configs = &$this->getOptionConfig($page, !empty($current_preset));
			$option_name = $configs['option_name'];
			if ( ! wp_verify_nonce( $_POST['_wpnonce'], GSF()->helper()->getNonceVerifyKey() ) ) {
				return;
			}
			$section = $_POST['section'];
			if (empty($section)) {
				return;
			}

			$option_default = GSF()->helper()->getConfigDefault($configs, $section);

			$options = get_option($this->getOptionPresetName($option_name, $current_preset));

			foreach ($option_default as $key => $value) {
				$options[$key] = $value;
			}

			do_action("gsf_before_reset_section/{$option_name}", $options, $current_preset);

			/**
			 * Update Options
			 */
			update_option($this->getOptionPresetName($option_name, $current_preset), $options);

			if (!empty($current_preset)) {
				$default_options = get_option($option_name);
				$options = wp_parse_args($options, $default_options);
			}

			/**
			 * Call action after reset options
			 */
			do_action("gsf_after_reset_section/{$option_name}", $options, $current_preset);

			/**
			 * Call action after change options
			 */
			do_action("gsf_after_change_options/{$option_name}", $options, $current_preset);

			echo 1;
			die();
		}
		public function deletePreset() {
			$page = $_POST['_current_page'];
			$current_preset = $_POST['_current_preset'];
			$configs = &$this->getOptionConfig($page, !empty($current_preset));
			$option_name = $configs['option_name'];
			if ( ! wp_verify_nonce( $_POST['_wpnonce'], GSF()->helper()->getNonceVerifyKey() ) ) {
				return;
			}

			/**
			 * Call action before delete preset
			 */
			do_action('gsf_before_delete_preset', $option_name, $current_preset);

			delete_option($this->getOptionPresetName($option_name, $current_preset));
			$this->deletePresetOptionKeys($option_name, $current_preset);

			/**
			 * Call action after delete preset
			 */
			do_action('gsf_after_delete_preset', $option_name, $current_preset);

			echo 1;
			die();
		}

		private function enqueueOptionsAssets(&$configs) {
			if (isset($configs['section'])) {
				foreach ($configs['section'] as $key => &$section) {
					$this->enqueueOptionsAssetsField($section['fields']);
				}
			}
			else {
				if (isset($configs['fields'])) {
					$this->enqueueOptionsAssetsField($configs['fields']);
				}
			}
		}

		private function enqueueOptionsAssetsField($configs) {
			foreach ($configs as $config) {
				$type = isset($config['type']) ?  $config['type'] : '';
				if (empty($type)) {
					continue;
				}

				$field = GSF()->helper()->createField($type);
				if ($field) {
					$field->enqueue();
				}

				switch ($type) {
					case 'row':
					case 'group':
					case 'panel':
					case 'repeater':
						if (isset($config['fields']) && is_array($config['fields'])) {
							$this->enqueueOptionsAssetsField($config['fields']);
						}
						break;
				}
			}
		}
	}
}