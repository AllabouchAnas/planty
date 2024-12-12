<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}
if (!class_exists('GSF_Widget')) {
	class GSF_Widget extends WP_Widget
	{
		public $widget_cssclass;
		public $widget_description;
		public $widget_id;
		public $widget_name;
		public $settings = array();

		public function __construct(){
			$widget_ops = array(
				'classname'   => $this->widget_cssclass,
				'description' => $this->widget_description
			);
			parent::__construct( $this->widget_id, $this->widget_name, $widget_ops );
		}
		function get_cached_widget( $args ) {
			$cache = wp_cache_get( $this->widget_id, 'widget' );
			if ( ! is_array( $cache ) ) {
				$cache = array();
			}

			if ( isset( $cache[ $args['widget_id'] ] ) ) {
				echo wp_kses_post($cache[ $args['widget_id'] ]);
				return true;
			}

			return false;
		}

		/**
		 * Cache the widget
		 * @param string $content
		 */
		public function cache_widget( $args, $content ) {
			$cache = wp_cache_get( $this->widget_id, 'widget' );

			$cache[ $args['widget_id'] ] = $content;

			wp_cache_set( $this->widget_id, $cache, 'widget' );
		}

		/**
		 * Flush the cache
		 *
		 * @return void
		 */
		public function flush_gfs_widget_cache() {
			wp_cache_delete( $this->widget_id, 'widget' );
		}
		public function update( $new_instance, $old_instance ) {
			$instance = $old_instance;

			if ( ! $this->settings ) {
				return $instance;
			}

			$config_keys = GSF()->helper()->getConfigKeys($this->settings);

			foreach ($config_keys as $key => $field_meta ) {
				if ( isset( $new_instance[ $key ] ) ) {
					if ( current_user_can('unfiltered_html') ) {
						$instance[$key] =  $new_instance[$key];
					}
					else {
						$instance[$key] = stripslashes( wp_filter_post_kses( addslashes($new_instance[$key]) ) );
					}
				}
				else {
					$instance[$key] = $field_meta['empty_value'];
				}
			}

			return $instance;
		}

		/**
		 * Render widget form
		 *
		 * @param array $instance
		 * @return string|void
		 */
		public function form( $instance ) {
			GSF()->helper()->setFieldPrefix('widget-' . $this->id_base . '[' . $this->number . ']');
			GSF()->helper()->setFieldLayout(isset($this->settings['layout']) ? $this->settings['layout'] : 'full');
			GSF()->helper()->renderFields($this->settings, $instance);
			GSF()->helper()->setFieldPrefix('');
		}

		public function widget($args, $instance) {}
	}
}