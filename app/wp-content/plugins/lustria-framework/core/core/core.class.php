<?php
if (!defined('ABSPATH')) {
	exit('Direct script access denied.');
}

if (!class_exists('G5P_Core_Core')) {
	class G5P_Core_Core
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
			$this->dashboard()->init();
			//$this->less()->init();
			$this->vc()->init();
			$this->xmenu()->init();
			$this->sass()->init();
			$this->elementor()->init();
		}

		/**
		 * @return G5P_Core_Dashboard
		 */
		public function dashboard() {
			return G5P_Core_Dashboard::getInstance();
		}




		/**
		 * @return G5P_Core_Less
		 */
		public function less() {
			return G5P_Core_Less::getInstance();
		}


		/**
		 * @return G5P_Core_Vc
		 */
		public function vc() {
			return G5P_Core_Vc::getInstance();
		}

		/**
		 * @return G5P_Core_XMenu
		 */
		public function xmenu() {
			return G5P_Core_XMenu::getInstance();
		}

		/**
		 * @return G5P_Core_Sass
		 */
		public function sass() {
			return G5P_Core_Sass::getInstance();
		}

		/**
		 * @return G5P_Core_Elementor
		 */
		public function elementor() {
			return G5P_Core_Elementor::getInstance();
		}

	}
}