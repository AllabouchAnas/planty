<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
if (!class_exists('GSF_Inc_Admin_Meta_Boxes')) {
    class GSF_Inc_Admin_Meta_Boxes
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
            add_action('init', array($this, 'registerCustomPostType'), 0);
            add_action('add_meta_boxes', array($this, 'registerMetaBoxes'));
            add_action('save_post', array($this, 'saveMetaBoxes'));
            add_action('admin_enqueue_scripts', array( $this, 'adminEnqueueStyles' ) );
            add_action('admin_enqueue_scripts', array( $this, 'adminEnqueueScripts' ) );
        }

        public function registerCustomPostType() {
            $ctp_args = apply_filters('gsf_register_post_type', array());

            foreach ($ctp_args as $post_type => $args) {
                $post_type_name = !is_array($args)
                    ? $args
                    : (isset($args['labels']) && isset($args['labels']['name'])
                        ? $args['labels']['name']
                        : (isset($args['label']) ? $args['label'] : $post_type));

                $singular_name = $post_type_name;

                if (!is_array($args)) {
                    $args = array();
                    $args['labels'] = array();
                } else {
                    if (!isset($args['labels'])) {
                        $args['labels'] = array();
                    }
                    if (isset($args['label'])) {
                        $args['labels']['name'] = $args['label'];
                    }
                    if (isset($args['singular_name'])) {
                        $singular_name = $args['singular_name'];
                    }
                }

                $defaults = array(
                    'label'              => $post_type_name,
                    'public'             => true,
                    'publicly_queryable' => true,
                    'show_ui'            => true,
                    'show_in_menu'       => true,
                    'query_var'          => true,
                    'rewrite'            => array('slug' => $post_type),
                    'capability_type'    => 'post',
                    'has_archive'        => true,
                    'hierarchical'       => false,
                    'menu_position'      => null,
                    'supports'           => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments'),
                    'labels'             => array(
                        'name'                  => $post_type_name,
                        'singular_name'         => $singular_name,
                        'add_new_item'          => sprintf(__('Add New %s', 'lustria-framework'), $singular_name),
                        'edit_item'             => sprintf(__('Edit %s', 'lustria-framework'), $singular_name),
                        'new_item'              => sprintf(__('New %s', 'lustria-framework'), $singular_name),
                        'view_item'             => sprintf(__('View %s', 'lustria-framework'), $singular_name),
                        'search_items'          => sprintf(__('Search %s', 'lustria-framework'), $post_type_name),
                        'not_found'             => sprintf(__('No %s found.', 'lustria-framework'), strtolower($post_type_name)),
                        'not_found_in_trash'    => sprintf(__('No %s found in Trash.', 'lustria-framework'), strtolower($post_type_name)),
                        'all_items'             => sprintf(__('All %s', 'lustria-framework'), $post_type_name),
                        'archives'              => sprintf(__('%s Archives', 'lustria-framework'), $post_type_name),
                        'insert_into_item'      => sprintf(__('Insert into %s', 'lustria-framework'), strtolower($singular_name)),
                        'uploaded_to_this_item' => sprintf(__('Uploaded to this %s', 'lustria-framework'), strtolower($singular_name)),
                        'filter_items_list'     => sprintf(__('Filter %s list', 'lustria-framework'), strtolower($post_type_name)),
                        'items_list_navigation' => sprintf(__('%s list navigation', 'lustria-framework'), $post_type_name),
                        'items_list'            => sprintf(__('%s list', 'lustria-framework'), $post_type_name),
                    )
                );
                $args = wp_parse_args($args, $defaults);
                $args['labels'] = wp_parse_args($args['labels'], $defaults['labels']);

                register_post_type($post_type, $args);
            }
            flush_rewrite_rules();
        }

        public function registerMetaBoxes() {
            $meta_configs = &$this->getMetaConfig();
            foreach ($meta_configs as $meta_id => $configs) {
                if (!is_array($configs)) {
                    continue;
                }
                $meta_name = isset($configs['name']) ? $configs['name'] : $meta_id;
                $post_type = isset($configs['post_type']) ? $configs['post_type'] : array();
                $this->post_types = array_merge($this->post_types, $post_type );
                $this->post_types = array_unique($this->post_types);

                add_meta_box($meta_id, $meta_name, array($this, 'metaBoxDisplayCallback'), $post_type, 'advanced', 'default', $configs);
            }
        }

        public function adminEnqueueStyles() {
            if (!$this->isMetaPage()) {
                return;
            }
            wp_enqueue_media();
            wp_enqueue_style('magnific-popup');
            wp_enqueue_style('font-awesome-5pro');
            wp_enqueue_style(GSF()->assetsHandle('fields'));
            wp_enqueue_script(GSF()->assetsHandle('meta-box'));

        }

        public function adminEnqueueScripts() {
            if (!$this->isMetaPage()) {
                return;
            }
            wp_enqueue_media();
            wp_enqueue_script('magnific-popup');
            wp_enqueue_script(GSF()->assetsHandle('fields'));

            wp_localize_script(GSF()->assetsHandle('fields'), 'GSF_META_DATA', array(
                'ajaxUrl' => admin_url('admin-ajax.php'),
                'nonce'   => GSF()->helper()->getNonceValue(),
            ));
        }

        public function &getMetaConfig() {
            if (!isset($GLOBALS['gsf_meta_box_config'])) {
                $GLOBALS['gsf_meta_box_config'] = apply_filters('gsf_meta_box_config', array());
            }
            return $GLOBALS['gsf_meta_box_config'];
        }

        /**
         * Binder Option Page
         */
        public function metaBoxDisplayCallback($post, $args) {
            $configs = &$args['args'];
            wp_nonce_field(GSF()->helper()->getNonceVerifyKey(), 'gsf_save_meta_box_nonce');
            $meta_values = $this->getMetaValue($configs);
            GSF()->helper()->setFieldLayout(isset($configs['layout']) ? $configs['layout'] : 'inline');
            GSF()->helper()->renderFields($configs, $meta_values);
        }

		public function saveMetaBoxes($post_id) {
			if (empty($_POST)) {
				return;
			}

            if (!isset($_POST['gsf_save_meta_box_nonce']) || !wp_verify_nonce($_POST['gsf_save_meta_box_nonce'], GSF()->helper()->getNonceVerifyKey())) {
			    return;
            }

			$meta_configs = &$this->getMetaConfig();
			$meta_field_keys = array();
			$current_post_type = $this->getCurrentPostType();
			foreach ($meta_configs as $configs) {
				if (isset($configs['post_type']) && ((!is_array($configs['post_type']) && ($current_post_type == $configs['post_type'])) || (is_array($configs['post_type']) && (in_array($current_post_type, $configs['post_type']))))) {
					$keys_config = GSF()->helper()->getConfigKeys($configs);

                    $meta_field_keys = array_merge($meta_field_keys, $keys_config);
                }
            }

            foreach ($meta_field_keys as $meta_id => $field_meta) {
                if (isset($_POST[$meta_id])) {
                    $meta_value = $_POST[$meta_id];
                }
                else {
                    $meta_value = $field_meta['empty_value'];
                }
                update_post_meta($post_id, $meta_id, $meta_value);
            }
        }

        public function getMetaValue(&$configs) {
            $id = get_the_ID();
            $meta_values = array();
            $config_keys = GSF()->helper()->getConfigKeys($configs);
            $config_defaults = GSF()->helper()->getConfigDefault($configs);
            foreach ($config_keys as $meta_id => $field_meta) {
                if ($this->isMetaSaved($meta_id, $id)) {
                    $meta_values[$meta_id] = get_post_meta($id, $meta_id, true);
                }
                else {
                    $meta_values[$meta_id] = isset($config_defaults[$meta_id]) ? $config_defaults[$meta_id] : '';
                }
            }
            return $meta_values;
        }

        private function isMetaSaved($meta_key, $post_id)
        {
            if ($this->isEditPage('new')) {
                return false;
            }
            if (!isset($GLOBALS['gsf_db_meta_key'])) {
                $GLOBALS['gsf_db_meta_key'] = array();
                global $wpdb;
                $rows = $wpdb->get_results($wpdb->prepare("SELECT meta_key FROM $wpdb->postmeta WHERE post_id = %d", $post_id));
                foreach ($rows as $row) {
                    $GLOBALS['gsf_db_meta_key'][] = $row->meta_key;
                }
            }

            return in_array($meta_key, $GLOBALS['gsf_db_meta_key']);
        }

        private function isMetaPage($screen = null) {
            if ( ! ( $screen instanceof WP_Screen ) )
            {
                $screen = get_current_screen();
            }
            return 'post' == $screen->base && in_array( $screen->post_type, $this->post_types );
        }

        private function getCurrentPostType() {
            $post_type = '';
            $screen = get_current_screen();
            if ($screen != null) {
                $post_type = $screen->post_type;
            }
            return $post_type;
        }

        private function isEditPage($new_edit = null)
        {
            global $pagenow;
            //make sure we are on the backend
            if (!is_admin()) {
                return false;
            }

            if ($new_edit == "edit")
                return in_array($pagenow, array('post.php',));
            elseif ($new_edit == "new") //check for new post page
                return in_array($pagenow, array('post-new.php'));
            else //check for either new or edit
                return in_array($pagenow, array('post.php', 'post-new.php'));
        }
    }
}