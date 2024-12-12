<?php
/**
 * Custom Css In Page
 *
 * Add custom css any where and render it on footer (wp-footer)
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if (!class_exists('G5Plus_Lustria_Custom_Js')) {
	class G5Plus_Lustria_Custom_Js
	{
		/*
		 * instance framework
		 */
		public static $instance;

		private $_custom_js = array();

		private $_custom_js_variable = array();


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
            add_action('wp_head', array($this, 'init_custom_css'),10);
            add_action('wp_footer', array($this, 'render_custom_css'),10);

			add_action('wp_footer', array($this, 'render_custom_js_variable'));
		}

		/**
		 * Add custom js
		 *
		 * @param $js
		 * @param string $key (default: '')
		 */
		public function addJs($js, $key = '')
		{
			if ($key === '') {
				$this->_custom_js[] = $js;
			} else {
				$this->_custom_js[$key] = $js;
			}
		}

		/**
		 * Add custom js variable
		 *
		 * @param $variable
		 * @param string $key (default: '')
		 */
		public function addJsVariable($variable, $key)
		{
			$this->_custom_js_variable[$key] = $variable;
		}

		/**
		 * Get Custom Js
		 *
		 * @return string
		 */
		public function getJs()
		{
			$css ='   ' . implode('', $this->_custom_js);
			return preg_replace('/\r\n|\n|\t/','',$css);
		}

        /**
         * Render custom css in footer
         */
        public function init_custom_css() {
            echo '<style type="text/css" id="g5plus-custom-js"></style>';
        }

        public function render_custom_css() {
            echo sprintf('<script>jQuery("style#g5plus-custom-js").append("%s");</script>',$this->getJs());
        }

		public function render_custom_js_variable() {
			foreach ($this->_custom_js_variable as $key => $value) {
				wp_localize_script(
					G5Plus_Lustria()->helper()->assetsHandle('main'),
					$key,
					$value
				);
			}
		}
	}
}