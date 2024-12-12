<?php
/**
 * Autoloader functions
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Auto load libraries
 */
spl_autoload_register( 'ube_autoload' );

/**
 * Autoload processd
 *
 * @param $class
 */
function ube_autoload( $class ) {
    if (class_exists($class)) {
        return;
    }
	if ( strpos( $class, 'UBE_' ) === 0 ) {
		$path      = '';
		$module_prefix_class = 'UBE_Module_';
        $file_name = '';

		if (strpos( $class, $module_prefix_class ) === 0) {
		    $module_paths = substr( $class, strlen($module_prefix_class) );
            $module_paths = explode('__', $module_paths);

            $module_file = '';
            if (count($module_paths) > 1) {
                $module_file = array_pop($module_paths);
            }

            $module_paths = join('/', $module_paths);
            $module_paths = strtolower(str_replace('_','-', $module_paths) );

            $path = "modules/{$module_paths}/";

            $file_name = empty($module_class)
                ? 'module'
                : strtolower(str_replace('_','-', $module_file ));
        }
		else {
            $sub_paths = array(
                'UBE_Core_' => 'core/',
                'UBE_Admin_' => 'admin/',
                'UBE_Element_' => 'elements/',
                'UBE_Control_' => 'controls/',
                'UBE_Group_Control_' => 'controls/groups/',
                'UBE_Walker_' => 'walker/',
                'UBE_' => '',
            );

            foreach ($sub_paths as $class_prefix => $class_path) {
                if ( strpos( $class, $class_prefix ) === 0 ) {
                    $path = $class_path;
                    $file_name = strtolower(str_replace('_','-', substr( $class, strlen($class_prefix) )) );
                    break;
                }
            }
        }

		$full_path = apply_filters( 'ube_autoload_file_dir', ube_get_plugin_dir( "inc/{$path}{$file_name}.class.php" ), $class );
		if ( is_readable( $full_path ) ) {
			include_once $full_path;
		}
	}
}