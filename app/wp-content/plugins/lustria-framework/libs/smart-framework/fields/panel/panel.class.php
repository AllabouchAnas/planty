<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}
if (!class_exists('GSF_Field_Panel')) {
	class GSF_Field_Panel extends  GSF_Field {
		public function render() {
			$this->renderStart();
			$this->renderContentWrapper();
			$this->renderEnd();
		}
		public function renderCloneRemoveButton() {
			?>
			<span class="gsf-clone-button-remove"><i class="dashicons dashicons-no-alt"></i></span>
		<?php
		}

		public function renderPanelTitle() {
			$title_class = array('gsf-field-panel-title');
			if ($this->isSort()) {
				$title_class[] = 'gsf-field-panel-title-sortable';
			}
			?>
			<h4 class="<?php echo join(' ', $title_class); ?>">
				<span class="gsf-field-panel-title-text"><?php echo esc_html($this->_setting['title']); ?></span>
				<?php if ($this->isClone()): ?>
					<?php $this->renderCloneRemoveButton(); ?>
				<?php endif;?>
				<span class="gsf-field-panel-title-toggle"></span>
			</h4>
			<?php
		}

		public function renderContentWrapper() {
			$panel_title = isset($this->_setting['panel_title']) ? $this->_setting['panel_title'] : '';
			if (!empty($panel_title)) {
				$panel_title = $this->getID() . '_' . $panel_title;
			}
			if ($this->_value === null) {
				$this->_value = $this->getFieldDefault();
			}
			?>
			<div class="gsf-field-content">
				<?php if ($this->isClone()): ?>
					<?php
					$count_clone = !is_array($this->_value) ? 1 : count($this->_value);
					$count_clone = $count_clone > 0 ? $count_clone : 1;
					?>
					<div class="gsf-field-clone-wrapper gsf-field-panel-clone <?php echo esc_attr($this->isSort() ? 'gsf-field-clone-sortable' : '') ; ?>">
						<?php for ($index = 0; $index < $count_clone; $index++): ?>
							<div class="gsf-field-clone-item gsf-field-panel-clone-item" data-clone-index="<?php echo esc_attr($index); ?>">
								<div class="gsf-field-content-inner gsf-field-panel-inner" data-panel-title="<?php echo esc_attr($panel_title); ?>">
									<?php $this->renderPanelTitle(); ?>
									<?php $this->renderPanelContent($index); ?>
								</div>
							</div>
						<?php endfor; ?>
					</div>
					<?php $this->renderCloneAddButton(); ?>
				<?php else:; ?>
					<div class="gsf-field-content-inner gsf-field-panel-inner" data-panel-title="<?php echo esc_attr($panel_title); ?>">
						<?php $this->renderPanelTitle(); ?>
						<?php $this->renderPanelContent(''); ?>
					</div>
				<?php endif;?>
			</div>
		<?php
		}
		public function renderCloneAddButton() {
			?>
			<button class="gsf-clone-button-add button"
			        type="button"><?php echo esc_html__('+ Add ', 'lustria-framework'); ?> <?php echo esc_html($this->_setting['title']); ?></button>
		<?php
		}

		public function renderPanelContent($panel_index) {
			?>
			<div class="gsf-field-panel-content">
				<?php
				foreach ($this->_setting['fields'] as &$setting) {
					$type = $setting['type'];
					if (empty($type)) {
						continue;
					}
					if (in_array($type, array('panel'))) {
						continue;
					}

					$field = GSF()->helper()->createField($type);

					$field->_parentType = $this->getType();
					$field->_panelID = isset($this->_setting['id']) ? $this->_setting['id'] : '';
					$field->_panelIndex = $panel_index;
					$field->_repeaterID = $this->_repeaterID;
					$field->_repeaterIndex = $this->_repeaterIndex;
					$field->_colDefault = $this->getCol();
					$field->_setting = &$setting;
					$field->_panel_clone = $this->isClone();
					$field->_repeater_clone = $this->_repeater_clone;

					$id = isset($setting['id']) ? $setting['id'] : '';

					if (in_array($type, array('group', 'row'))) {
						if ($panel_index !== '') {
							$field->_value = &$this->_value[$panel_index];
						}
						else {
							$field->_value = &$this->_value;
						}
					}
					else {
						if ($panel_index !== '') {
							if (!empty($id) && isset($this->_value[$panel_index]) && isset($this->_value[$panel_index][$id])) {
								$field->_value = &$this->_value[$panel_index][$id];
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
					}

					$field->render();
				}
				?>
			</div><!-- /.gsf-field-panel-content -->
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
			$default = isset($this->_setting['default'])
				? $this->_setting['default']
				: array();
			return $default;
		}
		public function getFieldDefault() {
			return $this->getDefault();
		}
	}
}