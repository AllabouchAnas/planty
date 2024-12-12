<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}
if (!class_exists('GSF_Field_Map')) {
	class GSF_Field_Map extends GSF_Field
	{
		public function enqueue()
		{
			$api_key = isset($this->_setting['api_key']) ? $this->_setting['api_key'] : 'AIzaSyAwey_47Cen4qJOjwHQ_sK1igwKPd74J18';
			$google_map_url = apply_filters('gsf_google_map_api_url', 'https://maps.googleapis.com/maps/api/js?key=' . $api_key);
			wp_enqueue_script('google_map', esc_url_raw($google_map_url), array(), '', true);

			wp_enqueue_script(GSF()->assetsHandle('field_map'), GSF()->helper()->getAssetUrl('fields/map/assets/map.min.js'), array(), GSF()->pluginVer(), true);
			wp_enqueue_style(GSF()->assetsHandle('field_map'), GSF()->helper()->getAssetUrl('fields/map/assets/map.min.css'), array(), GSF()->pluginVer());
		}

		function renderContent()
		{
			$field_value = $this->getFieldValue();
			if (!is_array($field_value)) {
				$field_value = array();
			}
			$value_default = $this->getDefault();
			$field_value = wp_parse_args($field_value, $value_default);
			
			$js_options = isset($this->_setting['js_options']) ? $this->_setting['js_options'] : array();
			if (isset($js_options['styles'])) {
				$js_options['styles'] = json_decode($js_options['styles']);
			}
			$placeholder = isset($this->_setting['placeholder']) ? $this->_setting['placeholder'] : esc_html__('Enter an address...','lustria-framework');
		    ?>
			<div class="gsf-field-map-inner">
				<input data-field-control="" type="hidden" class="gsf-map-location-field" name="<?php $this->theInputName(); ?>[location]" value="<?php echo esc_attr($field_value['location']); ?>"/>
				<?php if (!isset($this->_setting['show_address']) || $this->_setting['show_address']): ?>
					<div class="gsf-map-address">
						<div class="gsf-map-address-text">
							<input data-field-control="" type="text" placeholder="<?php echo esc_attr($placeholder); ?>" name="<?php $this->theInputName(); ?>[address]" value="<?php echo esc_attr($field_value['address']); ?>"/>
						</div>
						<button type="button" class="button"><?php echo esc_html__('Find Address','lustria-framework'); ?></button>
						<div class="gsf-map-suggest"></div>
					</div>
				<?php endif;?>
				<div class="gsf-map-canvas" data-options="<?php echo esc_attr(wp_json_encode($js_options)); ?>"></div>
			</div>
			<?php
		}

		/**
		 * Get default value
		 *
		 * @return array
		 */
		function getDefault() {
			$default = array(
				'location' => isset($this->_setting['default']) ? $this->_setting['default'] : '-33.868419, 151.193245',
				'address' => ''
			);

			$field_default = isset($this->_setting['default']) ? $this->_setting['default'] : array();

			return wp_parse_args($field_default, $default);
		}
	}
}