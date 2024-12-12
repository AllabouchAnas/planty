<?php
if (!defined('ABSPATH')) exit;
if (!class_exists('G5P_Core_XMenu')) {
	final class G5P_Core_XMenu
	{
		private static $_instance;
		public static function getInstance()
		{
			if (self::$_instance == NULL) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		/**
		 * Plugin construct
		 */
		public function init()
		{
			$this->includes();
			$this->add_actions();
			$this->add_filters();
		}

		/**
		 * Include library for plugin
		 */
		private function includes()
		{
			require_once G5P()->pluginDir('core/xmenu/inc/xmenu-walker.php');
		}

		private function add_actions()
		{
			/**
			 * Load admin assets for xmenu
			 */
			add_action('admin_print_styles-nav-menus.php', array($this, 'admin_load_assets'));

			/**
			 * Load frontend assets for xmenu
			 */
			add_action('wp_enqueue_scripts', array($this, 'frontend_load_assets'));

			/**
			 * XMenu Ajax
			 */
			add_action('wp_ajax_nopriv_xmenu_get_xmenu_panel', array($this, 'xmenu_panel'));
			add_action('wp_ajax_xmenu_get_xmenu_panel', array($this, 'xmenu_panel'));

			add_action('wp_ajax_nopriv_xmenu_save_menu', array($this, 'save_menu'));
			add_action('wp_ajax_xmenu_save_menu', array($this, 'save_menu'));

			/**
			 * Register post type: xmenu_mega
			 */
			add_action('init', array($this, 'register_post_type_mega_menu'));

            add_action( 'wp_head', array($this,'vc_custom_css'), 999 );
		}

		private function add_filters()
		{
			/**
			 * Filter for xmenu walker
			 */
			add_filter('wp_nav_menu_args', array($this, 'menu_walker'), 100);
		}

		public function admin_load_assets()
		{
			if (isset($_GET['action']) && ($_GET['action'] == 'locations')) {
				return;
			}
			GSF()->core()->iconPopup()->enqueue();

			wp_enqueue_style(G5P()->assetsHandle('xmenu_admin'), G5P()->helper()->getAssetUrl('core/xmenu/assets/css/xmenu-admin.min.css'), array(), G5P()->pluginVer());
			wp_enqueue_script(G5P()->assetsHandle('xmenu_admin'), G5P()->helper()->getAssetUrl('core/xmenu/assets/js/xmenu-admin.min.js'), array(), G5P()->pluginVer(), true);

			wp_localize_script(G5P()->assetsHandle('xmenu_admin'), 'xmenu_meta', array(
				'data'     => $this->get_menu_data(),
				'ajax_url' => admin_url('admin-ajax.php')
			));
		}

		public function frontend_load_assets() {
			wp_enqueue_style(G5P()->assetsHandle('xmenu-animate'), G5P()->helper()->getAssetUrl('core/xmenu/assets/css/animate.min.css'), array(), '3.5.1');
			//wp_enqueue_style(G5P()->assetsHandle('xmenu'), G5P()->helper()->getAssetUrl('core/xmenu/assets/css/xmenu.min.css'), array(), G5P()->pluginVer());
			wp_enqueue_script(G5P()->assetsHandle('xmenu'), G5P()->helper()->getAssetUrl('core/xmenu/assets/js/xmenu.min.js'), array(), G5P()->pluginVer(), true);
		}

		public function menu_walker($args)
		{
			$args['walker'] = new XMenuWalker();

			if (isset($args['main_menu']) && ($args['main_menu'])) {
				$args['menu_class'] .= ' x-nav-menu';
			}

			return $args;
		}

		/**
		 * Get XMENU Data
		 *
		 * @return array
		 */
		public function get_menu_data()
		{
			global $nav_menu_selected_id;
			$menu_items = wp_get_nav_menu_items($nav_menu_selected_id, array('post_status' => 'any'));
			$xmenu_data = array();
			if (is_array($menu_items)) {
				foreach ($menu_items as $key => $item) {
					$menu = array(
						'type_label'            => $item->type_label,
						'type'                  => $item->type,
						'menu-item-url'         => $item->url,
						'menu-item-title'       => $item->title,
						'menu-item-attr-title'  => $item->attr_title,
						'menu-item-target'      => $item->target,
						'menu-item-classes'     => join(' ', $item->classes),
						'menu-item-xfn'         => $item->xfn,
						'menu-item-description' => $item->description,
					);
					$menu_item_meta = get_post_meta($item->ID, $this->get_menu_meta_key(), true);
					if ($menu_item_meta) {
						$menu_item_meta = json_decode($menu_item_meta, true);
						$menu = array_merge($menu_item_meta, $menu);
					}
					$xmenu_data ['menu_' . $item->ID] = $menu;
				}
			}

			return $xmenu_data;
		}

		/**
		 * Get XMenu Panel
		 */
		public function xmenu_panel()
		{
			include_once G5P()->pluginDir('core/xmenu/templates/xmenu-panel.php');
			die();
		}

		/**
		 * Save Menu Items
		 */
		public function save_menu()
		{
			$nonce = $_POST['nonce'];
			if (!wp_verify_nonce($nonce, "XMENU_SAVE")) {
				echo 0;
				die();
			}
			$data = $_POST['data'];
			foreach ($data as $item) {
				$menu_id = $item['menu_id'];
				$term = wp_get_object_terms($menu_id, 'nav_menu');
				if (!is_array($term)) {
					continue;
				}
				$term = $term[0];

				$menu_list = wp_get_nav_menu_items($term->term_id, array('post_status' => 'any'));
				$menu_obj = null;
				foreach ($menu_list as $key => $menu_value) {
					if ($menu_value->ID == $menu_id) {
						$menu_obj = $menu_list[$key];
						break;
					}
				}
				if (!$menu_obj) {
					continue;
				}

				$args = array(
					'menu-item-db-id'       => $menu_id,
					'menu-item-object-id'   => $menu_obj->object_id,
					'menu-item-object'      => $menu_obj->object,
					'menu-item-parent-id'   => $menu_obj->menu_item_parent,
					'menu-item-position'    => $menu_obj->menu_order,
					'menu-item-type'        => $menu_obj->type,
					'menu-item-title'       => $item['data']['menu-item-title'],
					'menu-item-url'         => $menu_obj->type == 'custom' ? $item['data']['menu-item-url'] : $menu_obj->url,
					'menu-item-description' => $item['data']['menu-item-description'],
					'menu-item-attr-title'  => $item['data']['menu-item-attr-title'],
					'menu-item-target'      => $item['data']['menu-item-target'],
					'menu-item-classes'     => $item['data']['menu-item-classes'],
					'menu-item-xfn'         => $item['data']['menu-item-xfn'],
					'menu-item-status'      => $menu_obj->post_status,
				);

				/**
				 * Update menu item data
				 */
				$id = wp_update_nav_menu_item($term->term_id, $menu_id, $args);


				$xmenu_meta = array(
					'menu-item-featured-style'  => $item['data']['menu-item-featured-style'],
					'menu-item-featured-text'   => $item['data']['menu-item-featured-text'],
					'menu-item-icon'            => $item['data']['menu-item-icon'],
					'menu-submenu-width'        => $item['data']['menu-submenu-width'],
					'menu-submenu-custom-width' => $item['data']['menu-submenu-custom-width'],
					'menu-submenu-position'     => $item['data']['menu-submenu-position'],
					'menu-submenu-transition'   => $item['data']['menu-submenu-transition']
				);
				/**
				 * Update xmenu meta
				 */
				update_post_meta((int)$menu_id, $this->get_menu_meta_key(), json_encode($xmenu_meta));
			}
			echo 1;
			die();
		}

		public function register_post_type_mega_menu() {
			$post_type = 'xmenu_mega';
			$post_type_name = esc_html__('Mega Menu', 'lustria-framework');
			$singular_name = esc_html__('Mega Menu', 'lustria-framework');

			$args = array(
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
				'menu_position'      => 35,
				'supports'           => array('title', 'editor'),
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

			register_post_type($post_type, $args);
		}

        public function vc_custom_css() {
            $locations = get_nav_menu_locations();
            $page_menu = '';
            if (is_singular()) {
                $page_menu = G5P()->metaBox()->get_page_menu();
            }

            if (!empty($page_menu)) {
                $locations[] = $page_menu;
            }
            foreach ( $locations as $location ) {
                $menu = wp_get_nav_menu_object( $location );

                if ( is_object( $menu ) ) {
                    $nav_items     = wp_get_nav_menu_items( $menu->term_id );
                    $mega_menu_ids = array();

                    foreach ( (array) $nav_items as $nav_item ) {
                        if ( 'xmenu_mega' == $nav_item->object ) {
                            $mega_menu_ids[] = $nav_item->object_id;
                        }
                    }

                    $custom_css = array();

                    if ( ! empty( $mega_menu_ids ) ) {

                        foreach ( $mega_menu_ids as $mega_menu_id ) {
                            $post_custom_css = get_post_meta( $mega_menu_id, '_wpb_post_custom_css', true );
                            if ( ! empty( $post_custom_css ) ) {
                                $custom_css[] = $post_custom_css;
                            }

                            $shortcodes_custom_css = get_post_meta( $mega_menu_id, '_wpb_shortcodes_custom_css', true );
                            if ( ! empty( $shortcodes_custom_css ) ) {
                                $custom_css[] = $shortcodes_custom_css;
                            }
                        }
                    }

                    if (!empty($custom_css)) {
                        echo '<style type="text/css" data-type="vc_custom-css">';
                        echo implode( '', $custom_css );
                        echo '</style>';
                    }
                }
            }
        }

		/**
		 * Get Menu Meta Key
		 */
		private function get_menu_meta_key() {
			return apply_filters('xmenu_meta_key', '_menu_item_xmenu_config');
		}
	}
}