<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

if (!class_exists('GSF_Inc_File')) {
    class GSF_Inc_File {
        private static $_instance;
        public static function getInstance()
        {
            if (self::$_instance == NULL) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        public function getContents($file){
            require_once(ABSPATH . 'wp-admin/includes/file.php');
            WP_Filesystem();
            global $wp_filesystem;
            return  $wp_filesystem->get_contents($file);
        }

        public function putContents($file,$content) {
            require_once(ABSPATH . 'wp-admin/includes/file.php');
            WP_Filesystem();
            global $wp_filesystem;
            return $wp_filesystem->put_contents($file, $content, FS_CHMOD_FILE);
        }

        public function mkdir($file) {
            require_once(ABSPATH . 'wp-admin/includes/file.php');
            WP_Filesystem();
            global $wp_filesystem;
            return $wp_filesystem->mkdir($file);
        }

        public function rmdir($path,$recursive = false ){
            require_once(ABSPATH . 'wp-admin/includes/file.php');
            WP_Filesystem();
            global $wp_filesystem;
            return $wp_filesystem->rmdir($path,$recursive);
        }


        public function delete($file, $recursive = false, $type = false ){
            require_once(ABSPATH . 'wp-admin/includes/file.php');
            WP_Filesystem();
            global $wp_filesystem;
            return $wp_filesystem->delete($file, $recursive, $type);
        }
    }
}