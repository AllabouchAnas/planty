<?php
/**
 * Class Fonts
 *
 */
if (!defined('ABSPATH')) {
	exit('Direct script access denied.');
}

if (!class_exists('GSF_Inc_Custom_Css')) {
	class GSF_Inc_Custom_Css
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

		private $_custom_css = array();

		public function init() {
            add_action('wp_head', array($this, 'initCustomCss'),100);
            add_action('wp_footer', array($this, 'renderCustomCss'),100);
		}

		/**
		 * Add custom css
		 *
		 * @param $css
		 * @param string $key (default: '')
		 */
		public function addCss($css, $key = '')
		{
			if ($key === '') {
				$this->_custom_css[] = $css;
			} else {
				$this->_custom_css[$key] = $css;
			}
		}

		/**
		 * Get Custom Css
		 *
		 * @return string
		 */
		public function getCss()
		{
			$css ='   ' . implode('', $this->_custom_css);
			return preg_replace('/\r\n|\n|\t/','',$css);
		}


        /**
         * Render custom css in footer
         */
        public function initCustomCss() {
            echo '<style type="text/css" id="gsf-custom-css"></style>';
        }

        public function renderCustomCss() {
            echo sprintf('<script>jQuery("style#gsf-custom-css").append("%s");</script>',$this->getCss());
        }
	}
}