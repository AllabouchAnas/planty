<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}
if (!class_exists('GSF_Field_Gallery')) {
	class GSF_Field_Gallery extends GSF_Field
	{
		function enqueue() {
			wp_enqueue_script(GSF()->assetsHandle('media'));
			wp_enqueue_script(GSF()->assetsHandle('field_gallery'), GSF()->helper()->getAssetUrl('fields/gallery/assets/gallery.min.js'), array(), GSF()->pluginVer(), true);
			wp_enqueue_style(GSF()->assetsHandle('field_gallery'), GSF()->helper()->getAssetUrl('fields/gallery/assets/gallery.min.css'), array(), GSF()->pluginVer());
		}
		function renderContent()
		{
			$field_value = $this->getFieldValue();
			$field_value_arr = explode('|', $field_value);

			?>
			<div class="gsf-field-gallery-inner">
				<input data-field-control="" type="hidden" name="<?php $this->theInputName(); ?>" value="<?php echo esc_attr($field_value); ?>"/>
				<?php foreach ($field_value_arr as $image_id): ?>
					<?php
					if (empty($image_id)) {
						continue;
					}
					$image_url = '';
					$image_attributes = wp_get_attachment_image_src($image_id);
					if (!empty($image_attributes) && is_array($image_attributes)) {
						$image_url = $image_attributes[0];
					}
					?>
					<div class="gsf-gallery-image-preview" data-id="<?php echo esc_attr($image_id); ?>">
						<div class="centered">
							<img src="<?php echo esc_url($image_url); ?>"/>
						</div>
						<span class="gsf-gallery-remove dashicons dashicons dashicons-no-alt"></span>
					</div>
				<?php endforeach;?>
				<div class="gsf-gallery-add">
					<?php esc_html_e('+ Add Images', 'lustria-framework'); ?>
				</div>
			</div>
			<?php
		}
	}
}