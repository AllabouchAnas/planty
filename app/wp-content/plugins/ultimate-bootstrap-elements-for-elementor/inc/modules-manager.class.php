<?php
if (!defined('ABSPATH')) {
    exit;
}

class UBE_Modules_Manager
{
    private static $_instance = null;

    public static function get_instance() {
        return self::$_instance === null ? self::$_instance = new self() : self::$_instance;
    }

    const DYNAMIC_CONTENT = 'dynamic_content';
    const SITE_SETTINGS = 'site_settings';
    const TEMPLATES = 'templates';

    public function get_modules() {
        return apply_filters('ube_get_modules', array(
            self::DYNAMIC_CONTENT,
            self::SITE_SETTINGS,
	        self::TEMPLATES
        ));
    }

    public function init() {
        foreach ($this->get_modules() as $module) {
            /**
             * @var $class_name UBE_Abstracts_Module
             */
            $class_name = 'UBE_Module_' . str_replace( ' ', '_', ucwords( str_replace( '_', ' ', $module ) ) );
            if (class_exists($class_name) && $class_name::is_enabled()) {
                $class_name::get_instance()->init();
            }
        }
    }
}