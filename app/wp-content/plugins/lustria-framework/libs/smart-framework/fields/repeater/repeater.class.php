<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}
if (!class_exists('GSF_Field_Repeater')) {
	class GSF_Field_Repeater extends  GSF_Field {
		public function renderContentWrapper() {
			if ($this->_value === null) {
				$this->_value = $this->getFieldDefault();
			}
			?>
			<div class="gsf-field-content">
				<?php $this->repeaterLabel(); ?>
				<?php if ($this->isClone()): ?>
					<?php
					$count_clone = !is_array($this->_value) ? 1 : count($this->_value);
					$count_clone = $count_clone > 0 ? $count_clone : 1;
					?>
					<div class="gsf-field-clone-wrapper gsf-field-repeater-clone <?php echo $this->isSort() ? 'gsf-field-clone-sortable' : '' ; ?>">
						<?php for ($index = 0; $index < $count_clone; $index++): ?>
							<div class="gsf-field-clone-item gsf-field-repeater-clone-item" data-clone-index="<?php echo $index; ?>">
								<div class="gsf-field-content-inner">
									<?php
									$this->_cloneIndex = $index;
									if ($this->isSort()) {
										$this->renderCloneSortButton();
									}
									$this->repeaterContent($index);
									$this->renderCloneRemoveButton();
									?>
								</div>
							</div>
						<?php endfor; ?>
					</div>
					<?php $this->repeaterDescription(); ?>
					<?php $this->renderCloneAddButton(); ?>
				<?php else:; ?>
					<div class="gsf-field-content-inner">
						<?php $this->repeaterContent(''); ?>
						<?php $this->repeaterDescription(); ?>
					</div>
				<?php endif;?>
			</div>
		<?php
		}

		public function renderStart() {
			$col = $this->getCol();
			$this->_setting['col'] = '';
			parent::renderStart();
			$this->_setting['col'] = $col;
		}

		public function repeaterLabel() {
			$header_classes = array('gsf-row', 'gsf-field-repeater-header');
			if ($this->isClone()) {
				$header_classes[] = 'gsf-field-repeater-is-clone';
			}
			if ($this->isSort()) {
				$header_classes[] = 'gsf-field-repeater-is-sortable';
			}
			?>
			<div class="<?php echo join(' ', $header_classes); ?>">
				<?php
			foreach ($this->_setting['fields'] as &$setting) {
				if (empty($setting['type'])) {
					continue;
				}
				if (in_array($setting['type'], array('row', 'group', 'repeater', 'panel'))) {
					continue;
				}
				$col = isset($setting['col']) ? $setting['col'] :  $this->getCol();
				$title = isset($setting['title']) ? $setting['title'] : '';
				$subtitle = isset($setting['subtitle']) ? $setting['subtitle'] : '';
				$this->repeaterLabelField($col, $title, $subtitle);
			}
			?>
			</div><!-- /.gsf-row -->
			<?php
		}
		public function repeaterLabelField($col, $title, $subtitle) {
			?>
			<div class="gsf-col gsf-col-<?php echo esc_attr($col); ?>">
				<div class="gsf-field-repeater-title"><?php echo esc_attr($title); ?></div>
				<?php if (!empty($subtitle)): ?>
					<div class="gsf-field-repeater-subtitle">
						<?php echo esc_html($subtitle); ?>
					</div>
				<?php endif;?>
			</div>
			<?php
		}


		public function repeaterContent($repeater_index) {
			?>
			<div class="gsf-row">
			<?php
			foreach ($this->_setting['fields'] as &$setting) {
				if (empty($setting['type'])) {
					continue;
				}
				if (in_array($setting['type'], array('row', 'group', 'repeater', 'panel'))) {
					continue;
				}

				$field = GSF()->helper()->createField($setting['type']);

				$field->_parentType = $this->getType();
				$field->_panelID = $this->_panelID;
				$field->_panelIndex = $this->_panelIndex;
				$field->_repeaterID = isset($this->_setting['id']) ? $this->_setting['id'] : '';
				$field->_repeaterIndex = $repeater_index;
				$field->_colDefault = $this->getCol();
				$field->_setting = &$setting;
				$field->_panel_clone = $this->_panel_clone;
				$field->_repeater_clone = $this->isClone();

				$id = isset($setting['id']) ? $setting['id'] : '';

				if ($repeater_index !== '') {
					if (!empty($id) && isset($this->_value[$repeater_index]) && isset($this->_value[$repeater_index][$id])) {
						$field->_value = &$this->_value[$repeater_index][$id];
					}
					else {
						$field->_value = null;
					}
				}
				else {
					if (!empty($id) && isset($this->_value[$id])) {
						$field->_value = &$this->_value[$id];
					}
					else {
						$field->_value = null;
					}
				}

				$field->render();
			}
			?>
			</div><!-- /.gsf-row -->
			<?php
		}

		public function repeaterDescription() {
			$header_classes = array('gsf-row', 'gsf-field-repeater-footer');
			if ($this->isClone()) {
				$header_classes[] = 'gsf-field-repeater-is-clone';
			}
			if ($this->isSort()) {
				$header_classes[] = 'gsf-field-repeater-is-sortable';
			}
			?>
			<div class="<?php echo join(' ', $header_classes); ?>">
				<?php
				foreach ($this->_setting['fields'] as &$setting) {
					if (empty($setting['type'])) {
						continue;
					}
					if (in_array($setting['type'], array('row', 'group', 'repeater', 'panel'))) {
						continue;
					}
					$col = isset($setting['col']) ? $setting['col'] :  $this->getCol();
					$desc = isset($setting['desc']) ? $setting['desc'] : '';
					if (!empty($desc)) {
						echo sprintf('<div class="gsf-col gsf-col-%s"><p class="gsf-desc">%s</p></div>', $col, $desc);
					}
				}
				?>
			</div><!-- /.gsf-row -->
		<?php
		}

		/**
		 * Field empty value
		 * @return string
		 */
		public function getEmptyValue() {
			return array();
		}

		public function getDefault() {
			return isset($this->_setting['default'])
				? $this->_setting['default']
				: array();
		}
		public function getFieldDefault() {
			return $this->getDefault();
		}

	}
}