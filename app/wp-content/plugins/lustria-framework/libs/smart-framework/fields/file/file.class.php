<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}
if (!class_exists('GSF_Field_File')) {
	class GSF_Field_File extends GSF_Field
	{
		function enqueue() {
			wp_enqueue_script(GSF()->assetsHandle('media'));

			wp_enqueue_script(GSF()->assetsHandle('field_file'), GSF()->helper()->getAssetUrl('fields/file/assets/file.min.js'), array(), GSF()->pluginVer(), true);
			wp_enqueue_style(GSF()->assetsHandle('field_file'), GSF()->helper()->getAssetUrl('fields/file/assets/file.min.css'), array(), GSF()->pluginVer());
			wp_localize_script(GSF()->assetsHandle('field_file'), 'GSF_FILE_FIELD_META', array(
				'title'   => esc_html__('Select File', 'lustria-framework'),
				'button'  => esc_html__('Use these files', 'lustria-framework')
			));
		}

		/*
		 * Render field content
		 */
		function renderContent()
		{
			$field_value = $this->getFieldValue();
			$field_value_arr = explode('|', $field_value);
			$remove_text = esc_html__('Remove','lustria-framework');
			$lib_filter = '';
			if (isset($this->_setting['lib_filter']) && !empty($this->_setting['lib_filter'])) {
				$lib_filter = sprintf('data-lib-filter="%s"', esc_attr($this->_setting['lib_filter']));
			}
			?>
			<div class="gsf-field-file-inner" data-remove-text="<?php echo esc_attr($remove_text); ?>" <?php echo ($lib_filter); ?>>
				<input data-field-control="" type="hidden" name="<?php $this->theInputName(); ?>" value="<?php echo esc_attr($field_value); ?>"/>
				<?php foreach ($field_value_arr as $file_id): ?>
					<?php
					if (empty($file_id)) {
						continue;
					}
					$file_meta = get_post($file_id);
					if ($file_meta == null) {
						continue;
					}
					?>
					<div class="gsf-file-item" data-file-id="<?php echo esc_attr($file_id); ?>">
						<span class="dashicons dashicons-media-document"></span>
						<div class="gsf-file-info">
							<a class="gsf-file-title" href="<?php echo esc_url(get_edit_post_link($file_id)); ?>" target="_blank"><?php echo esc_html($file_meta->post_title); ?></a>
							<div class="gsf-file-name"><?php echo esc_html(wp_basename($file_meta->guid)); ?></div>
							<div class="gsf-file-action">
								<span class="gsf-file-remove"><span class="dashicons dashicons-no-alt"></span>  <?php echo esc_html($remove_text) ?></span>
							</div>
						</div>
					</div>
				<?php endforeach;?>
				<div class="gsf-file-add">
					<button class="button" type="button"><?php esc_html_e('+ Add File','lustria-framework'); ?></button>
				</div>
			</div>
			<?php
		}
	}
}