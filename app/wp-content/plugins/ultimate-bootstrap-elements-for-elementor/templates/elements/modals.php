<?php
if (!defined('ABSPATH')) {
	exit;
}

use Elementor\Plugin;
use Elementor\Icons_Manager;

/**
 * @var $element UBE_Element_Badge
 */

$settings = $element->get_settings_for_display();

$modal_classes = array(
	'ube-modal-btn-show',
	'btn'
);

$id_modal = $element->get_id();

$element->add_render_attribute(
	[
		'btn_show_attr' => [
			'class' => $modal_classes,
			'type' => 'button',
			'data-toggle' => 'modal',
			'data-target' => "#exampleModal-{$id_modal}",
		],
	]
);

$main_modal_classes = array(
	'modal',
	'fade'
);

$element->add_render_attribute(
	[
		'main_modal_attr' => [
			'class' => $main_modal_classes,
			'id' => "exampleModal-{$id_modal}",
			'tabindex' => "-1",
			'role' => 'dialog',
			'aria-labelledby' => 'exampleModalLabel',
			'aria-hidden' => 'true'
		],
	]
);

$footer_class[] = 'modal-footer';
if ($settings['modal_footer_text'] !== '') {
	$footer_class[] = 'has-content';
}
$element->add_render_attribute('modal_footer_attr', 'class', $footer_class);

?>
<div class="ube-modal">
    <button <?php echo $element->get_render_attribute_string('btn_show_attr') ?>>
		<?php if (!empty($settings['modal_button_icon']['value'])): ?>
			<?php Icons_Manager::render_icon($settings['modal_button_icon'], ['aria-hidden' => 'true']); ?>
		<?php endif; ?>
		<?php if ($settings['modal_button_text'] !== ''): ?>
			<?php echo esc_html($settings['modal_button_text']) ?>
		<?php endif; ?>
    </button>
    <div <?php echo $element->get_render_attribute_string('main_modal_attr') ?>>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
				<?php if ($settings['modal_enable_header'] === 'yes'): ?>
                    <div class="modal-header">
						<?php if ($settings['modal_header_text'] !== ''): ?>
                            <h4 class="modal-title"><?php echo esc_html($settings['modal_header_text']) ?></h4>
						<?php endif; ?>
                        <button type="button" class="close" data-dismiss="modal" aria-label="<?php esc_attr_e('Close','ube')?>">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
				<?php endif; ?>
                <div class="modal-body">
					<?php
					if ($settings['modal_content_source'] === 'custom' && !empty($settings['modal_custom_content'])) {
						echo wp_kses_post($settings['modal_custom_content']);
					} elseif ($settings['modal_content_source'] === 'template' && !empty($settings['modal_template_id'])) {
						echo ube_get_builder_content_for_display($settings['modal_template_id']);
					}
					?>
                </div>
				<?php if ($settings['modal_enable_footer'] === 'yes'): ?>
                    <div <?php echo $element->get_render_attribute_string('modal_footer_attr') ?>>
						<?php if ($settings['modal_footer_text'] !== ''): ?>
                            <div class="modal-footer-content"><?php echo esc_html($settings['modal_footer_text']) ?></div>
						<?php endif; ?>
                        <button type="button" class="btn ube-modal-btn-close"
                                data-dismiss="modal"><?php esc_html_e('Close', 'ube') ?></button>
                    </div>
				<?php endif; ?>
            </div>
        </div>
    </div>
</div>