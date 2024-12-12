<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}
if (!class_exists('GSF_Field_Row')) {
	class GSF_Field_Row extends  GSF_Field {
		public function render() {
			if (!isset($this->_setting['fields'])) {
				return;
			}
			$field_classes = array('gsf-field');
			$field_classes[] = 'gsf-field-' . $this->getType();
			$field_classes[] = 'gsf-layout-' . $this->getLayout();
			?>
			<div <?php $this->theFieldAttribute()?> class="<?php echo join(' ', $field_classes); ?>">
					<div class="gsf-row">
			<?php
			foreach ($this->_setting['fields'] as &$setting) {
				$type = isset($setting['type']) ? $setting['type'] : '';
				if (empty($type)) {
					continue;
				}

				if (in_array($type, array('row', 'panel'))) {
					continue;
				}

				$field = GSF()->helper()->createField($type);

				$field->_parentType = $this->getType();
				$field->_panelID = $this->_panelID;
				$field->_panelIndex = $this->_panelIndex;
				$field->_repeaterID = $this->_repeaterID;
				$field->_repeaterIndex = $this->_repeaterIndex;
				$field->_panel_clone = $this->_panel_clone;
				$field->_repeater_clone = $this->_repeater_clone;
				$field->_colDefault = $this->getCol();
				$field->_setting = &$setting;

				$id = isset($setting['id']) ? $setting['id'] : '';

				if (in_array($type, array('row', 'group'))) {
					$field->_value = $this->_value;
				}
				else {
					if (!empty($id)) {
						$field->_value = isset($this->_value[$id]) ? $this->_value[$id] : null;
					}
					else {
						$field->_value = null;
					}
				}

				$field->render();
			}
			?>
					</div><!-- /.gsf-row -->
			</div><!-- /.gsf-field-row -->
		<?php
		}
	}
}