<?php

use Elementor\Control_Media;
use Elementor\Group_Control_Image_Size;
use Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

abstract class UBE_Abstracts_Module {
    private static $_instance = array();

    /**
     * @return UBE_Abstracts_Module
     */
    public static final function get_instance() {
        $class = get_called_class();
        if (!isset(self::$_instance[$class])) {

            self::$_instance[$class] = new $class();
        }

        return self::$_instance[$class];
    }

    public static function is_enabled() {
        return true;
    }

    public function init() {}



}