<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}
if (!class_exists('GSF_Inc_Admin_Taxonomy')) {
	class GSF_Inc_Admin_Taxonomy
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

		private $_taxonomies = array();

		public function init() {
			add_action('init', array($this, 'registerCustomTaxonomy'), 0);
			add_action('admin_init', array($this, 'registerTermMeta'));
			add_action('wp_ajax_gsf_tax_meta_form', array($this, 'ajaxMetaForm'));

			// Enqueue common styles and scripts
			add_action( 'admin_enqueue_scripts', array( $this, 'adminEnqueueStyles' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'adminEnqueueScripts' ), 15 );
		}

		public function adminEnqueueStyles() {
			if (!$this->isTermPage()) {
				return;
			}
			wp_enqueue_media();
			wp_enqueue_style('magnific-popup');
			wp_enqueue_style('font-awesome-5pro');
			wp_enqueue_style(GSF()->assetsHandle('fields'));
			wp_enqueue_style(GSF()->assetsHandle('term-meta'));

		}

		public function adminEnqueueScripts() {
			if (!$this->isTermPage()) {
				return;
			}
			wp_enqueue_media();
			wp_enqueue_script('magnific-popup');
			wp_enqueue_script(GSF()->assetsHandle('fields'));
			wp_enqueue_script(GSF()->assetsHandle('term-meta'));
			wp_localize_script(GSF()->assetsHandle('fields'), 'GSF_META_DATA', array(
				'ajaxUrl' => admin_url('admin-ajax.php'),
				'nonce'   => GSF()->helper()->getNonceValue(),
			));
		}

		public function registerCustomTaxonomy() {
			$custom_tax = apply_filters('gsf_register_taxonomy', array());
			foreach ($custom_tax as $tax => $args) {
				if (!is_array($args)) {
					return;
				}
				if (!isset($args['post_type'])) {
					return;
				}

				$post_type = array_unique((array)$args['post_type']);
				$label = isset($args['label']) ? $args['label'] : $tax;
				$singular_name = isset($args['singular_name']) ? $args['singular_name'] : $label;
				$name = isset($args['name']) ? $args['name'] : $label;


				$default = array(
					'hierarchical' => true,
					'label'        => $label,
					'query_var'    => true,
					'rewrite'      => array(
						'slug'       => $tax, // This controls the base slug that will display before each term
						'with_front' => false // Don't display the category base before
					),
					'labels'       => array(
						'name'                       => $name,
						'singular_name'              => $singular_name,
						'menu_name'                  => $label,
						'search_items'               => sprintf(esc_html__('Search %s', 'lustria-framework'), $label),
						'popular_items'              => sprintf(esc_html__('Popular %s', 'lustria-framework'), $label),
						'all_items'                  => sprintf(esc_html__('All %s', 'lustria-framework'), $label),
						'parent_item'                => sprintf(esc_html__('Parent %s', 'lustria-framework'), $singular_name),
						'parent_item_colon'          => sprintf(esc_html__('Parent %s:', 'lustria-framework'), $singular_name),
						'edit_item'                  => sprintf(esc_html__('Edit %s', 'lustria-framework'), $singular_name),
						'view_item'                  => sprintf(esc_html__('View %s', 'lustria-framework'), $singular_name),
						'update_item'                => sprintf(esc_html__('Update %s', 'lustria-framework'), $singular_name),
						'add_new_item'               => sprintf(esc_html__('Add New %s', 'lustria-framework'), $singular_name),
						'new_item_name'              => sprintf(esc_html__('New %s New', 'lustria-framework'), $singular_name),
						'separate_items_with_commas' => sprintf(esc_html__('Separate %s with commas', 'lustria-framework'), strtolower($label)),
						'add_or_remove_items'        => sprintf(esc_html__('Add or remove %s', 'lustria-framework'), strtolower($label)),
						'choose_from_most_used'      => sprintf(esc_html__('Choose from the most used %s', 'lustria-framework'), strtolower($label)),
						'not_found'                  => sprintf(esc_html__('No %s found.', 'lustria-framework'), strtolower($label)),
						'no_terms'                   => sprintf(esc_html__('No %s', 'lustria-framework'), strtolower($label)),
						'items_list_navigation'      => sprintf(esc_html__('%s list navigation', 'lustria-framework'), $label),
						'items_list'                 => sprintf(esc_html__('%s list', 'lustria-framework'), $label),
					)
				);

				$args = wp_parse_args($args, $default);
				$args['labels'] = wp_parse_args($args['labels'], $default['labels']);
				register_taxonomy(
					$tax,       //The name of the taxonomy. Name should be in slug form (must not contain capital letters or spaces).
					$post_type, //post type name
					$args
				);

			}
		}

		public function registerTermMeta() {
			$meta_configs = &$this->getMetaConfig();
			foreach ($meta_configs as $meta_id => $config) {
				if (!is_array($config)) {
					continue;
				}


				$taxonomies = isset($config['taxonomy']) ? (array)$config['taxonomy'] : array();
				$taxonomy_priority = isset($config['priority']) ? $config['priority'] : 10;

				$this->_taxonomies = array_merge($this->_taxonomies, $taxonomies );
				$this->_taxonomies = array_unique($this->_taxonomies);

				foreach ($taxonomies as $taxonomy) {

					add_action( $taxonomy . '_add_form_fields', array($this, 'termMetaAddDisplay'), $taxonomy_priority, 2 );
					add_action( $taxonomy . '_edit_form_fields', array($this, 'termMetaEditDisplay'), $taxonomy_priority, 2 );

					add_action( 'created_' . $taxonomy, array($this, 'saveTermMeta'), $taxonomy_priority, 2 );
					add_action( 'edited_' . $taxonomy, array($this, 'saveTermMeta'), $taxonomy_priority, 2 );
				}
			}
		}

		public function ajaxMetaForm() {
			$taxonomy = $_REQUEST['taxonomy'];
			$this->termMetaDisplay($taxonomy, true);
		}

		public function termMetaAddDisplay($taxonomy) {
			?>
			<div class="gsf-term-meta-wrapper gsf-term-meta-add-new" data-taxonomy="<?php echo esc_attr($taxonomy); ?>">
				<?php $this->termMetaDisplay($taxonomy, true); ?>
			</div>
			<?php
		}

		public function termMetaEditDisplay($term, $taxonomy) {
			?>
			<tr class="form-field">
				<td colspan="2">
					<div class="gsf-term-meta-wrapper gsf-term-meta-edit">
						<?php $this->termMetaDisplay($taxonomy, false); ?>
					</div>
				</td>
			</tr>
			<?php
		}

		public function termMetaDisplay($taxonomy, $is_new) {
			$meta_configs = &$this->getMetaConfig();
			foreach ($meta_configs as $meta_id => $configs) {
				if (!is_array($configs)) {
					continue;
				}

				$taxonomies = isset($configs['taxonomy']) ? (array)$configs['taxonomy'] : array();
				if (in_array($taxonomy, $taxonomies)) {
					?>
					<div class="gsf-taxonomy-meta-wrapper">
						<div class="gsf-taxonomy-meta-header">
							<h4>
								<span class="gsf-taxonomy-meta-header-title"><?php echo esc_html($configs['name']); ?></span>
								<button type="button" class="gsf-taxonomy-meta-header-toggle">
									<span></span>
								</button>
							</h4>
						</div>
						<div class="gsf-taxonomy-meta-content">
							<?php
							$meta_values = $this->getMetaValue($configs);
							GSF()->helper()->setFieldLayout(isset($configs['layout']) ? $configs['layout'] : 'inline');
							GSF()->helper()->renderFields($configs, $meta_values);
							?>
						</div>
					</div>
					<?php
				}
			}
		}

		public function saveTermMeta($term_id, $tag_id) {
			if (empty($_POST) || !isset($_POST['taxonomy'])) {
				return;
			}
			$meta_configs = &$this->getMetaConfig();
			$meta_field_keys = array();
			$current_taxonomy = $_POST['taxonomy'];

			$meta_default = array();

			foreach ($meta_configs as $configs) {
				if (isset($configs['taxonomy']) && ((!is_array($configs['taxonomy']) && ($current_taxonomy == $configs['taxonomy'])) || (is_array($configs['taxonomy']) && (in_array($current_taxonomy, $configs['taxonomy']))))) {
					$keys_config = GSF()->helper()->getConfigKeys($configs);
					$meta_field_keys = array_merge($meta_field_keys, $keys_config);

					$default = GSF()->helper()->getConfigDefault($configs);
					$meta_default = array_merge($meta_default, $default);
				}
			}

			foreach ($meta_field_keys as $meta_id => $field_meta) {
				if (isset($_POST[$meta_id])) {
					$meta_value = $_POST[$meta_id];
				}
				else {
					$meta_value = $field_meta['empty_value'];
				}
				update_term_meta($term_id, $meta_id, $meta_value);
			}
		}

		public function &getMetaConfig() {
			if (!isset($GLOBALS['gsf_term_meta_config'])) {
				$GLOBALS['gsf_term_meta_config'] = apply_filters('gsf_term_meta_config', array());
			}
			return $GLOBALS['gsf_term_meta_config'];
		}

		private function getMetaValue(&$configs) {
			$id = isset($_GET['tag_ID']) ? $_GET['tag_ID'] : '0';
			$meta_values = array();
			$config_keys = GSF()->helper()->getConfigKeys($configs);
			$config_defaults = GSF()->helper()->getConfigDefault($configs);

			foreach ($config_keys as $meta_id => $field_meta) {
				if ($this->isMetaSaved($meta_id, $id)) {
					$meta_values[$meta_id] = get_term_meta($id, $meta_id, true);
				}
				else {
					$meta_values[$meta_id] = isset($config_defaults[$meta_id]) ? $config_defaults[$meta_id] : '';
				}
			}

			return $meta_values;
		}

		private function isMetaSaved($meta_key, $term_id)
		{
			if ($this->isNewPage()) {
				return false;
			}
			if (!isset($GLOBALS['gsf_db_meta_key'])) {
				$GLOBALS['gsf_db_meta_key'] = array();
				global $wpdb;
				$rows = $wpdb->get_results($wpdb->prepare("SELECT meta_key FROM $wpdb->termmeta WHERE term_id = %d", $term_id));
				foreach ($rows as $row) {
					$GLOBALS['gsf_db_meta_key'][] = $row->meta_key;
				}
			}

			return in_array($meta_key, $GLOBALS['gsf_db_meta_key']);
		}

		private function isTermPage() {
			$taxonomy = isset($_REQUEST['taxonomy']) ? $_REQUEST['taxonomy'] : '';
			$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';
			if (empty($action)) {
				$screen = get_current_screen();
				$action = $screen->base;
			}
			return (('edit-tags' == $action) || ('term' == $action) || ('add-tag' == $action)) && in_array($taxonomy, $this->_taxonomies );
		}

		private function isNewPage() {
			$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';
			if (empty($action)) {
				$screen = get_current_screen();
				$action = $screen->base;
			}
			return ($action === 'edit-tags');
		}
	}
}