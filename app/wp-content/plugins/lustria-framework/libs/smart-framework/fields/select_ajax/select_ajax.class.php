<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
if (!class_exists('GSF_Field_Select_Ajax')) {
    class GSF_Field_Select_Ajax extends GSF_Field
    {
        function enqueue() {
            wp_enqueue_style('selectize');
            wp_enqueue_style('selectize-default');
            wp_enqueue_script('selectize');

            wp_enqueue_script(GSF()->assetsHandle('field_select_ajax'), GSF()->helper()->getAssetUrl('fields/select_ajax/assets/select-ajax.min.js'), array(), GSF()->pluginVer(), true);
        }

        function renderContent()
        {
            $field_value = $this->getFieldValue();

            $input_type = isset($this->_setting['input_type']) ? $this->_setting['input_type'] : 'text';
            $place_holder = isset($this->_setting['placeholder']) ? $this->_setting['placeholder'] : '';
            $multiple = isset($this->_setting['multiple']) ? $this->_setting['multiple'] : false;
            $post_type = isset($this->_setting['data']) ? $this->_setting['data'] : 'post';
            $options = array();
            $args = array(
                'post__in' => (array)$field_value,
                'post_type' => $post_type
            );
            $posts = get_posts($args);
            foreach ($posts as $post) {
                $options[$post->ID] = $post->post_title;
            }
            if ($multiple && is_array($field_value)) {
                // Sort options array by $field_value
                $options_temp = array();
                foreach ($field_value as $post_id) {
                    if (isset($options[$post_id])) {
                        $options_temp[$post_id] = $options[$post_id];
                    }
                }
                $options = $options_temp;
            }
            ?>
            <div class="gsf-field-select_ajax-inner">
                <select data-field-control=""
                        data-field-no-change="true"
                        data-field-set-value="true"
                        class="gsf-select-ajax repositories" type="<?php echo esc_attr($input_type); ?>"
                        name="<?php $this->theInputName(); ?><?php echo $multiple ? '[]' : ''; ?>"
                        data-value="<?php echo esc_attr(is_array($field_value) ? json_encode($field_value) : $field_value) ?>"
                        placeholder="<?php echo esc_attr($place_holder); ?>"
                        data-source="<?php echo esc_attr($post_type); ?>"
                    <?php echo esc_attr($multiple ? 'multiple' : '' ); ?>>
                    <option class="empty-select" value="" <?php GSF()->helper()->theSelected('', $field_value); ?>></option>
                    <?php foreach ($options as $opt_key => $opt_val): ?>
                        <option value="<?php echo esc_attr($opt_key); ?>" <?php GSF()->helper()->theSelected($opt_key, $field_value); ?>><?php echo esc_html($opt_val); ?></option>
                    <?php endforeach;?>
                </select>
            </div>
            <?php
        }

        /**
         * Field empty value
         * @return string
         */
        public function getEmptyValue() {
            if ($this->isClone()) {
                return array();
            }
            else {
                if (isset($this->_setting['multiple']) && $this->_setting['multiple']) {
                    return array();
                }
                return '';
            }
        }

        /**
         * Get default value
         *
         * @return array | string
         */
        function getDefault() {
            $default = '';
            if (isset($this->_setting['multiple']) && $this->_setting['multiple']) {
                $default = array();
            }
            $field_default = isset($this->_setting['default']) ? $this->_setting['default'] : $default;
            return $field_default;
        }
    }
}