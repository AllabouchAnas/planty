<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}
if (!class_exists('GSF_Field_Info')) {
	class GSF_Field_Info extends GSF_Field
	{
		function enqueue()
		{
			wp_enqueue_style(GSF()->assetsHandle('field_info'), GSF()->helper()->getAssetUrl('fields/info/assets/info.min.css'), array(), GSF()->pluginVer());
		}
		function render()
		{
			$desc = isset($this->_setting['desc']) ? $this->_setting['desc']: '';
			$title = isset($this->_setting['title']) ? $this->_setting['title']: '';
			$class_inner = array('gsf-info-inner');
			if (isset($this->_setting['style'])) {
				$class_inner[] = 'gsf-info-style-' . $this->_setting['style'];
			}

			$icon = isset($this->_setting['icon']) ? $this->_setting['icon'] : '';
			if ($icon === true) {
				if (isset($this->_setting['style'])) {
					switch ($this->_setting['style']) {
						case 'info':
							$icon = 'dashicons-info';
							break;
						case 'warning':
							$icon = 'dashicons-shield-alt';
							break;
						case 'success':
							$icon = 'dashicons-yes';
							break;
						case 'error':
							$icon = 'dashicons-dismiss';
							break;
					}
				}
				else {
					$icon = 'dashicons-wordpress';
				}
			}

			if (isset($this->_setting['icon'])) {
				$class_inner[] = 'gsf-info-has-icon gsf-clearfix';
			}
			$field_classes = array('gsf-field');
			$field_classes[] = 'gsf-field-' . $this->getType();
			?>
			<div <?php $this->theFieldAttribute()?> class="<?php echo join(' ', $field_classes); ?>">
				<div class="<?php echo join(' ', $class_inner) ?>">
					<div class="gsf-info-content">
						<?php if (isset($this->_setting['icon'])): ?>
							<span class="gsf-info-content-icon dashicons <?php echo esc_attr($icon); ?>"></span>
						<?php endif;?>
						<?php if (!empty($title)): ?>
							<div class="gsf-info-content-title">
								<?php echo wp_kses_post($title); ?>
							</div>
						<?php endif;?>
						<?php if (!empty($desc)): ?>
							<div class="gsf-info-content-desc">
								<?php echo wp_kses_post($desc); ?>
							</div>
						<?php endif;?>
					</div>
				</div>
			</div>
			<?php
		}
	}
}