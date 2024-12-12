<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}

if (!class_exists('UBE_Admin_Message')) {
    class UBE_Admin_Message
    {
        private $_messages = array();
	    private $_message_key = 'ube_admin_messages';


        private static $_instance;
        public static function get_instance()
        {
            if (self::$_instance == NULL) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        public function init() {
	        add_action('init', array($this, 'init_message_list'), 0);
	        add_action( 'admin_notices', array( $this, 'print_messages' ), 15 );
        }
        public function init_message_list() {
	        $this->_messages = get_user_meta(get_current_user_id(), $this->_message_key, true);

	        if (!is_array($this->_messages)) {
		        $this->_messages = array();
	        }
        }

        /**
         * Get notices
         *
         * @return array
         */
        public function get_messages() {
            return $this->_messages;
        }

	    /**
	     * @param $name
	     * @param $message
	     * @param string $type dismiss | success | warning | error | info
	     */
        public function add_message($message, $type = 'info', $name = '') {
        	if ($name === '') {
		        $this->_messages[] = array(
			        'message' => $message,
			        'type' => $type
		        );
	        }
	        else {
		        $this->_messages[$name] = array(
			        'message' => $message,
			        'type' => $type
		        );
	        }

	        update_user_meta(get_current_user_id(), $this->_message_key, $this->_messages);
        }

        public function remove_message($name) {
        	unset($this->_messages[$name]);
	        update_user_meta(get_current_user_id(), $this->_message_key, $this->_messages);
        }

        public function admin_print_message() {
	        add_action( 'admin_notices', array( $this, 'print_message' ), 15 );
        }

        public function print_messages() {
			foreach ($this->_messages as $key => $value) {
				?>
				<div id="message" class="notice is-dismissible notice-<?php echo esc_attr($value['type']) ?>">
					<p><?php echo wp_kses_post($value['message']) ?></p>
					<button type="button" class="notice-dismiss"><span class="screen-reader-text"><?php echo esc_html__('Close','ube') ?></span></button>
				</div>
				<?php
			}
	        delete_user_meta(get_current_user_id(), $this->_message_key);
        }
    }
}