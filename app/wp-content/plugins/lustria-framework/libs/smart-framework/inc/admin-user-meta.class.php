<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}
if (!class_exists('GSF_Inc_Admin_User_Meta')) {
	class GSF_Inc_Admin_User_Meta
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

		/**
		 * list post type apply meta box
		 */
		public $post_types = array();


		public function init() {
			add_action( 'admin_print_styles-profile.php' , array($this,'adminEnqueueScripts')  );
			add_action( 'admin_print_styles-profile.php' , array($this,'adminEnqueueStyles')  );
			add_action( 'admin_print_styles-user-edit.php' , array($this,'adminEnqueueScripts') );
			add_action( 'admin_print_styles-user-edit.php' , array($this,'adminEnqueueStyles') );

			add_action( 'show_user_profile', array( $this, 'addCustomMetaFields' ) );
			add_action( 'edit_user_profile', array( $this, 'addCustomMetaFields' ) );
			add_action( 'personal_options_update', array( $this, 'saveCustomMetaFields' ) );
			add_action( 'edit_user_profile_update', array( $this, 'saveCustomMetaFields' ) );
		}

		public function adminEnqueueStyles() {
			wp_enqueue_media();
			wp_enqueue_style('magnific-popup');
			wp_enqueue_style('font-awesome-5pro');
			wp_enqueue_style(GSF()->assetsHandle('fields'));
			wp_enqueue_style(GSF()->assetsHandle('user-meta'));

		}

		public function adminEnqueueScripts() {
			wp_enqueue_media();
			wp_enqueue_script('magnific-popup');
			wp_enqueue_script(GSF()->assetsHandle('fields'));
			wp_enqueue_script(GSF()->assetsHandle('user-meta'));

			wp_localize_script(GSF()->assetsHandle('fields'), 'GSF_META_DATA', array(
				'ajaxUrl' => admin_url('admin-ajax.php'),
				'nonce'   => GSF()->helper()->getNonceValue(),
			));
		}

		public function &getMetaConfig() {
			if (!isset($GLOBALS['gsf_user_meta_config'])) {
				$GLOBALS['gsf_user_meta_config'] = apply_filters('gsf_user_meta_config', array());
			}
			return $GLOBALS['gsf_user_meta_config'];
		}

		/**
		 * @param $user
		 */
		public function addCustomMetaFields($user) {
			$meta_configs = &$this->getMetaConfig();
			if (empty($meta_configs)) {
				return;
			}
			foreach($meta_configs as $configs) {
				if (!is_array($configs)) {
					continue;
				}
				?>
				<div class="gsf-user-meta-wrapper">
					<div class="gsf-user-meta-header">
						<h4>
							<span class="gsf-user-meta-header-title"><?php echo esc_html($configs['name']); ?></span>
							<button type="button" class="gsf-user-meta-header-toggle">
								<span></span>
							</button>
						</h4>
					</div>
					<div class="gsf-user-meta-content">
						<?php
						$meta_values = $this->getMetaValue($user->ID, $configs);
						GSF()->helper()->setFieldLayout(isset($configs['layout']) ? $configs['layout'] : 'inline');
						GSF()->helper()->renderFields($configs, $meta_values);
						?>
					</div>
				</div>
				<?php
			}
		}

		public function saveCustomMetaFields($user_id) {
			if (empty($_POST)) {
				return;
			}
			$meta_configs = &$this->getMetaConfig();
			$meta_field_keys = array();
			$field_default = array();
			foreach ($meta_configs as $configs) {
				$keys_config = GSF()->helper()->getConfigKeys($configs);
				$meta_field_keys = array_merge($meta_field_keys, $keys_config);

				$default = GSF()->helper()->getConfigDefault($configs);
				$field_default = array_merge($field_default, $default);
			}

			$meta_value = '';
			foreach ($meta_field_keys as $meta_id => $field_meta) {
				if (isset($_POST[$meta_id])) {
					$meta_value = $_POST[$meta_id];
				}
				else {
					$meta_value = $field_meta['empty_value'];
				}
				update_user_meta($user_id, $meta_id, $meta_value);
			}
		}

		private function getMetaValue($userId, &$configs) {
			$meta_values = array();

			$config_keys = GSF()->helper()->getConfigKeys($configs);
			$config_defaults = GSF()->helper()->getConfigDefault($configs);
			foreach ($config_keys as $meta_id => $field_meta) {
				if ($this->isMetaSaved($meta_id, $userId)) {
					$meta_values[$meta_id] = get_user_meta($userId, $meta_id, true);
				}
				else {
					$meta_values[$meta_id] = isset($config_defaults[$meta_id]) ? $config_defaults[$meta_id] : '';
				}
			}

			return $meta_values;
		}

		private function isMetaSaved($meta_key, $user_id)
		{
			if (!$user_id) {
				return false;
			}
			if (!isset($GLOBALS['gsf_db_meta_key'])) {
				$GLOBALS['gsf_db_meta_key'] = array();
				global $wpdb;
				$rows = $wpdb->get_results($wpdb->prepare("SELECT meta_key FROM $wpdb->usermeta WHERE user_id = %d", $user_id));
				foreach ($rows as $row) {
					$GLOBALS['gsf_db_meta_key'][] = $row->meta_key;
				}
			}

			return in_array($meta_key, $GLOBALS['gsf_db_meta_key']);
		}
	}
}