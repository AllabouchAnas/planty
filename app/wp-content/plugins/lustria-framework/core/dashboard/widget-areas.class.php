<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
if (!class_exists('G5P_Dashboard_Widget_Areas')) {
	class G5P_Dashboard_Widget_Areas {

		protected $widget_areas = array();

		protected $version = '1.0';

		protected $widget_areas_key =  'gsf-widget-areas';


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
			add_action('admin_enqueue_scripts',array($this,'enqueue'));
			add_action('wp_loaded', array($this, 'add_sidebar'));
			add_action('widgets_init',array($this, 'register_custom_widget_areas'),12);
			add_action( 'wp_ajax_gsf_delete_widget_area', array( $this, 'delete_widget_area' ) );
		}

		public function binderPage() {
			G5P()->helper()->getTemplate('core/dashboard/templates/dashboard', array('current_page' => 'sidebars'));
		}

		public function get_widget_areas() {
			// If the single instance hasn't been set, set it now.
			if ( !empty($this->widget_areas) ) {
				return $this->widget_areas;
			}

			$db = get_option($this->widget_areas_key);
			if (!empty($db)) {
				$this->widget_areas = $db;
			}
			return $this->widget_areas;
		}

		public function enqueue() {
			wp_enqueue_script(G5P()->assetsHandle('widget-areas'), G5P()->helper()->getAssetUrl('core/dashboard/widget-areas/assets/js/widget-areas.min.js'), array('jquery'), $this->version);
			wp_enqueue_style(G5P()->assetsHandle('widget-areas'), G5P()->helper()->getAssetUrl('core/dashboard/widget-areas/assets/css/widget-areas.min.css'), array(), $this->version, 'screen');
			wp_localize_script(
				G5P()->assetsHandle('widget-areas'),
				'gsf_widget_areas_variable',
				array(
					'ajax_url' => wp_nonce_url(admin_url('admin-ajax.php?action=gsf_delete_widget_area'), 'gsf-delete-widget-area-action', '_wpnonce'),
					'confirm_delete' => esc_html__('Are you sure to delete this widget areas?', 'lustria-framework')
				)
			);

		}

		public function add_sidebar() {
			if (!isset($_POST['gsf_add_sidebar_nonce']) || !wp_verify_nonce(sanitize_text_field($_POST['gsf_add_sidebar_nonce']), 'gsf_add_sidebar_action')) {
				return;
			}
			$widget_name = $_POST['gsf-add-widget-input'];
			if (!empty($widget_name)) {
				$this->widget_areas = $this->get_widget_areas();

				$widget_name = $this->check_widget_area_name($widget_name);

				$widgetId = sanitize_key($widget_name);

				$this->widget_areas[$widgetId] = $widget_name;

				$this->save_widget_areas();

				wp_redirect($_POST['_wp_http_referer']);
				die();
			}
		}

		public function check_widget_area_name($name) {
			global $wp_registered_sidebars;
			if(empty($wp_registered_sidebars))
				return $name;

			$taken = array();
			foreach ( $wp_registered_sidebars as $widget_area ) {
				$taken[] = $widget_area['name'];
			}
			if(in_array($name, $taken)) {
				$counter  = substr($name, -1);
				if(!is_numeric($counter)) {
					$new_name = $name . " 1";
				} else {
					$new_name = substr($name, 0, -1) . ((int) $counter + 1);
				}

				$name = $this->check_widget_area_name($new_name);
			}
			return $name;
		}

		function save_widget_areas() {
			update_option($this->widget_areas_key,array_unique( $this->widget_areas ));
		}

		function delete_widget_area() {
			if (!check_ajax_referer('gsf-delete-widget-area-action','_wpnonce')) return;
			if(!empty($_REQUEST['name'])) {
				$name = strip_tags( ( stripslashes( $_REQUEST['name'] ) ) );
				$this->widget_areas = $this->get_widget_areas();
				if( array_key_exists($name, $this->widget_areas )) {
					unset($this->widget_areas[$name]);
					$this->save_widget_areas();
				}
				echo "widget-area-deleted";
			}
			die();
		}

		public function register_custom_widget_areas() {
			// If the single instance hasn't been set, set it now.
			if ( empty($this->widget_areas) ) {
				$this->widget_areas = $this->get_widget_areas();
			}
			$args = array(
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h4 class="widget-title"><span>',
				'after_title'   => '</span></h4>',
			);
			$args = apply_filters('gsf_custom_widget_args', $args);
			if (is_array($this->widget_areas)) {
				foreach (array_unique($this->widget_areas) as $key => $value) {
					$args['class']   = 'gsf-widgets-custom';
					$args['name']    = $value;
					$args['id']      = $key;
					register_sidebar($args);
				}
			}
		}


	}
}