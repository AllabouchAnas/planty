<?php
/**
 * Class Fonts
 *
 */
if (!defined('ABSPATH')) {
	exit('Direct script access denied.');
}

if (!class_exists('GSF_Core_Core')) {
	class GSF_Core_Core
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
			$this->fonts()->init();
			$this->iconPopup()->init();
		}

		/**
		 * @return GSF_Core_Fonts
		 */
		public function fonts() {
			return GSF_Core_Fonts::getInstance();
		}

		public function iconPopup() {
			return GSF_Core_Icons_Popup::getInstance();
		}
	}
}