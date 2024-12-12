<?php
/**
 * The template for displaying responsive.tpl.php
 * @var $settings
 * @var $value
 * @var $size_types
 */
$field_classes = array(
	'wpb_vc_param_value',
	$settings['param_name'],
	"{$settings['type']}_field"
);
$data = preg_split('/\s+/', $value);
$field_class = implode(' ', array_filter($field_classes));
?>
<div class="gsf-vc-responsive-wrapper">
	<input type="hidden" name="<?php echo esc_attr($settings['param_name']) ?>"
	       class="<?php echo esc_attr($field_class) ?>" value="<?php echo esc_attr($value) ?>">
	<table class="vc_table vc_column-offset-table">
		<tr>
			<td class="vc_screen-size">
				<?php esc_html_e('Device', 'lustria-framework') ?>
			</td>
			<?php foreach ($size_types as $key => $size) : ?>
                <td class="vc_screen-size vc_screen-size-<?php echo esc_attr($key) ?>">
                    <?php $icon = '';
                    switch ($key) {
                        case 'md':
                            $icon = 'landscape-tablets';
                            break;
                        case 'sm':
                            $icon = 'portrait-tablets';
                            break;
                        case 'xs':
                            $icon = 'portrait-smartphones';
                            break;
                        default:
                        case 'lg':
                            $icon = 'default';
                            break;
                    }?>
                    <span title="<?php echo esc_attr($size) ?>"><i
                            class="vc-composer-icon vc-c-icon-layout_<?php echo esc_attr($icon) ?>"></i></span>
                </td>
			<?php endforeach; ?>
		</tr>
		<tr>
			<td>
				<?php esc_html_e('Hide on device?', 'lustria-framework') ?>

			</td>
			<?php foreach ($size_types as $key => $size) : ?>
				<td>
					<label>
						<input type="checkbox" name="vc_hidden-<?php echo esc_attr($key);?>" <?php echo in_array('vc_hidden-' . $key, $data) ? ' checked="true"' : '' ?>
						       class="gsf-vc-responsive-field">
					</label>
				</td>
			<?php endforeach; ?>
		</tr>
	</table>
</div>
