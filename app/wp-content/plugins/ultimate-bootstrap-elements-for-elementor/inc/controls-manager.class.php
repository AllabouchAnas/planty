<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
class UBE_Controls_Manager {
    private static $_instance = null;
    public static function get_instance() {
        return self::$_instance === null ? self::$_instance = new self() : self::$_instance;
    }

    const WIDGETAREA  = 'widgetarea';
    const AUTOCOMPLETE = 'autocomplete';
    const BOOTSTRAP_RESPONSIVE = 'bootstrap_responsive';

    const TEXT_GRADIENT = 'text_gradient';


    public function init() {
        add_action('elementor/controls/controls_registered', array($this, 'controls_registered'));
    }

    public function get_controls() {
        return apply_filters('ube_get_controls', array(
            self::WIDGETAREA,
            self::AUTOCOMPLETE,
	        self::BOOTSTRAP_RESPONSIVE,
        ));
    }

    public function get_group_controls() {
        return apply_filters('ube_get_group_controls', array(
            self::TEXT_GRADIENT
        ));
    }

    public function controls_registered() {
        foreach ($this->get_controls() as $control_id) {
            $class_name = 'UBE_Control_' . str_replace( ' ', '_', ucwords( str_replace( '_', ' ', $control_id ) ) );
            if (class_exists($class_name)) {
                UBE()->elementor()->controls_manager->register_control($control_id, new $class_name);
            }
        }

        // Register group controls
        foreach ($this->get_group_controls() as $control_id) {
            $class_name = 'UBE_Group_Control_' . str_replace( ' ', '_', ucwords( str_replace( '_', ' ', $control_id ) ) );
            if (class_exists($class_name)) {
                UBE()->elementor()->controls_manager->add_group_control($control_id, new $class_name);
            }
        }
    }
}