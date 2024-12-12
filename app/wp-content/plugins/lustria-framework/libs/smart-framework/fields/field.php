<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

if (!class_exists('GSF_Field')) {
	abstract class GSF_Field {
		public $_parentType = '';

		public $_panelID = '';
		public $_repeaterID = '';
		public $_panel_clone = false;
		public $_repeater_clone = false;

		public $_panelIndex = '';
		public $_repeaterIndex = '';
		public $_cloneIndex = 0;

		/**
		 * Field col (layout for row)
		 * @var string
		 */
		public $_colDefault = '12';

		/**
		 * Field Setting
		 * @var array
		 */
		public $_setting = array();

		/**
		 * Field Value
		 * @var string
		 */
		public $_value = null;

		public function __construct() {
			add_action('admin_footer', array($this, 'enqueue'));
		}
		public function enqueue()
		{
			// Nothing
		}

		/**
		 * Get field ID
		 * @return string
		 */
		public function getID() {
			if (!isset($this->_setting['id'])) {
				return '';
			}
			$id = $this->_setting['id'];
			if (!empty($this->_repeaterID)) {
				$id = sprintf('%s_%s', $this->_repeaterID , $id);
			}
			if (!empty($this->_panelID)) {
				$id = sprintf('%s_%s', $this->_panelID , $id);
			}
			return $id;
		}

		/**
		 * Render field ID attribute
		 */
		public function theID() {
			$id = $this->getID();
			echo empty($id) ? '' : sprintf(' id="%s"', esc_attr($id));
		}

		/**
		 * Get field name
		 * @return string
		 */
		public function getName() {
			if (!isset($this->_setting['id'])) {
				return '';
			}
			$prefix = GSF()->helper()->getFieldPrefix();
			$name = $this->_setting['id'];

			if (!empty($prefix)) {
				$prefix .= '[';
			}

			if (!empty($this->_panelID) && !empty($this->_repeaterID)) {
				$name = sprintf('%s%s%s%s[%s]%s[%s]',
					$prefix,
					$this->_panelID,
					!empty($prefix) ? ']' : '',
					$this->_panel_clone ? sprintf('[%d]', $this->_panelIndex) : '' ,
					$this->_repeaterID,
					$this->_repeater_clone ? sprintf('[%d]', $this->_repeaterIndex) : '' ,
					$name);
			}
			else {
				if (!empty($this->_repeaterID)) {
					$name = sprintf('%s%s%s%s[%s]',
						$prefix,
						$this->_repeaterID,
						!empty($prefix) ? ']' : '',
						$this->_repeater_clone ? sprintf('[%d]', $this->_repeaterIndex) : '' ,
						$name);
				}
				if (!empty($this->_panelID)) {
					$name = sprintf('%s%s%s%s[%s]',
						$prefix,
						$this->_panelID,
						!empty($prefix) ? ']' : '',
						$this->_panel_clone ? sprintf('[%d]', $this->_panelIndex) : '' ,
						$name);
				}
			}
			if ($name == $this->_setting['id']) {
				$name = sprintf('%s%s%s',
					$prefix,
					$name,
					!empty($prefix) ? ']' : ''
					);
			}
			return $name;
		}

		public function getInputName() {
			if ($this->isClone()) {
				return sprintf('%s[%d]', $this->getName(), $this->_cloneIndex);
			}
			return $this->getName();

		}
		public function theInputName() {
			echo esc_attr($this->getInputName());
		}

		/**
		 * Get Field Type
		 * @return string
		 */
		public function getType() {
			return isset($this->_setting['type']) ? $this->_setting['type'] : '';
		}

		public function theDataType() {
			echo sprintf(' data-field-type="%s"', $this->getType());
		}

		/**
		 * Get config layout: inline | full
		 * @default: inline
		 */
		public function getLayout() {
			return isset($this->_setting['layout']) ? $this->_setting['layout'] : GSF()->helper()->getFieldLayout();
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
				return '';
			}
		}

		public function getDefault() {
			return isset($this->_setting['default'])
				? $this->_setting['default']
				: '';
		}

		public function getFieldDefault() {
			$default = $this->getDefault();
			if (is_array($default) && empty($default)) {
				return $this->getDefault();
			}
			return $this->isClone() ? array($default) : $default;
		}

		public function getDataValue() {
			if ($this->isClone()) {
				return isset($this->_value[$this->_cloneIndex]) ?
					$this->_value[$this->_cloneIndex] : $this->getFieldDefault();
			}
			return !is_null($this->_value) ? $this->_value : $this->getDefault();
		}
		public function theDataValue() {
			$value = $this->getDataValue();
			if (!is_string($value)) {
				$value = json_encode($value);
			}
			echo sprintf(" data-field-value='%s'",
				in_array($this->getType(), array('panel', 'row', 'group', 'repeater')) ? '' : esc_attr($value));
		}

		public function getFieldValue() {
			if ($this->isClone()) {
				return isset($this->_value[$this->_cloneIndex])
					? $this->_value[$this->_cloneIndex]
					: $this->getDefault();
			}
			return !is_null($this->_value) ? $this->_value : $this->getDefault();
		}

		public function getCol() {
			$col = isset($this->_setting['col']) ? $this->_setting['col'] : $this->_colDefault;
			if (empty($col)) {
				$col = '12';
			}
			return $col;
		}

		public function getFieldTitle() {
			return isset($this->_setting['title']) ? $this->_setting['title'] : '';
		}
		public function getFieldSubTitle() {
			return isset($this->_setting['subtitle']) ? $this->_setting['subtitle'] : '';
		}



		/**
		 * Check field is clone
		 * @return bool
		 */
		public function isClone() {
			return isset($this->_setting['clone'])
				? $this->_setting['clone']
				: in_array($this->getType(), array('repeater', 'panel'));
		}

		/**
		 * Check field is sortable
		 * @return bool
		 */
		public function isSort() {
			return $this->isClone()
				&& (isset($this->_setting['sort'])
					? $this->_setting['sort']
					: false);
		}

		public function isInRow() {
			return in_array($this->_parentType, array('row', 'repeater'));
		}

		public function inRepeater() {
			return $this->_parentType === 'repeater';
		}

		/**
		 * Echo required field data
		 */
		public function theRequired() {
			$required = isset($this->_setting['required']) ? $this->_setting['required'] : array();
			if (!empty($required)) {
				printf(" data-required='%s'", json_encode($required));
			}
		}

		public function thePreset() {
			$preset_setting = isset($this->_setting['preset']) ? $this->_setting['preset'] : array();
			if (!empty($preset_setting)) {
				printf(" data-preset='%s'", json_encode($preset_setting));
			}
		}

		public function theFieldAttribute() {
			$this->theID();
			$this->theDataValue();
			$this->theDataType();
			$this->theRequired();
			$this->thePreset();
		}

		public function getFieldClass() {
			$field_classes = array('gsf-field');
			$field_classes[] = 'gsf-field-' . $this->getType();
			return $field_classes;
		}

		//region Render Field
		//----------------------------------------------
		public function renderStart() {
			$field_classes = $this->getFieldClass();
			?>
			<?php if ($this->isInRow()): ?>
				<?php $field_classes[] = 'gsf-col gsf-col-' . $this->getCol(); ?>
				<div <?php $this->theFieldAttribute()?> class="<?php echo join(' ', $field_classes); ?>">
					<div class="gsf-col-inner gsf-col-layout-<?php echo esc_attr($this->getLayout()); ?>">
			<?php else:; ?>
				<?php $field_classes[] = 'gsf-layout-' . $this->getLayout(); ?>
				<div <?php $this->theFieldAttribute()?> class="<?php echo join(' ', $field_classes); ?>">
					<div class="gsf-row">
						<div class="gsf-col gsf-col-<?php echo esc_attr($this->getCol()); ?>">
							<div class="gsf-col-inner gsf-col-layout-<?php echo esc_attr($this->getLayout()); ?>">
			<?php endif;?>
			<?php
		}
		public function renderEnd() {
			?>
			<?php if ($this->isInRow()): ?>
					</div><!-- /.gsf-col-inner -->
				</div> <!-- /.gsf-field -->
			<?php else: ?>
						</div><!-- /.gsf-col-inner -->
					</div><!-- /.gsf-col -->
				</div><!-- /.gsf-row -->
			</div> <!-- /.gsf-field -->
			<?php endif;?>
			<?php
		}
		public function renderLabel() {
			if ($this->inRepeater()) {
				return;
			}

			$subtitle = $this->getFieldSubTitle();
			?>
			<div class="gsf-label">
				<div class="gsf-title"><?php echo esc_html($this->getFieldTitle()); ?></div>
				<?php if (!empty($subtitle)): ?>
					<div class="gsf-subtitle">
						<?php echo wp_kses_post($subtitle); ?>
					</div>
				<?php endif;?>
			</div>
			<?php
		}
		public function renderDescription() {
			if ($this->inRepeater()) {
				return;
			}
			?>
			<?php if (!empty($this->_setting['desc'])): ?>
				<p class="gsf-desc"><?php echo wp_kses_post($this->_setting['desc']); ?></p>
			<?php endif;?>
			<?php
		}
		public function renderCloneAddButton() {
			?>
			<button class="gsf-clone-button-add button"
			        type="button"><?php echo esc_html__('+ Add more', 'lustria-framework'); ?></button>
			<?php
		}
		public function renderCloneRemoveButton() {
			$btn_class = 'gsf-clone-button-remove';
			if ($this->getType() === 'repeater') {
				$btn_class .= ' gsf-is-repeater';
			}
			?>
			<span class="<?php echo esc_attr($btn_class); ?>"><i class="dashicons dashicons-dismiss"></i></span>
			<?php
		}
		public function renderCloneSortButton() {
			$btn_class = 'gsf-sortable-button';
			if ($this->getType() === 'repeater') {
				$btn_class .= ' gsf-is-repeater';
			}
			?>
			<span class="<?php echo esc_attr($btn_class); ?>"><i class="dashicons dashicons-menu"></i></span>
			<?php
		}

		public function renderContentWrapper() {
			?>
			<div class="gsf-field-content">
				<?php if ($this->isClone()): ?>
					<?php
					$count_clone = !is_array($this->_value) ? 1 : count($this->_value);
					$count_clone = $count_clone > 0 ? $count_clone : 1;
					?>
					<div class="gsf-field-clone-wrapper <?php echo esc_attr($this->isSort() ? 'gsf-field-clone-sortable' : '' ); ?>">
						<?php for ($index = 0; $index < $count_clone; $index++): ?>
							<div class="gsf-field-clone-item" data-clone-index="<?php echo esc_attr($index); ?>">
								<div class="gsf-field-content-inner">
									<?php
									$this->_cloneIndex = $index;
									if ($this->isSort()) {
										$this->renderCloneSortButton();
									}
									$this->renderContent();
									$this->renderCloneRemoveButton();
									?>
								</div>
							</div>
						<?php endfor; ?>
					</div>
					<?php $this->renderCloneAddButton(); ?>
				<?php else:; ?>
					<div class="gsf-field-content-inner">
						<?php $this->renderContent(); ?>
					</div>
				<?php endif;?>
				<?php $this->renderDescription(); ?>
			</div>
			<?php
		}
		public function renderContent() {
			// Field content here
		}
		public function render() {
			$this->renderStart();
			$this->renderLabel();
			$this->renderContentWrapper();
			$this->renderEnd();
		}
		//----------------------------------------------
		//endregion
	}
}