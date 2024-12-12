<?php
/**
 * The template for displaying number-and-unit.tpl.php
 * @var $settings
 * @var $value
 */
$field_classes = array(
	'wpb_vc_param_value',
	$settings['param_name'],
	"{$settings['type']}_field"
);
$data = explode('|', $value);
$field_class = implode(' ', array_filter($field_classes));
$units = apply_filters('gsf_number_units', array(
    'px' => 'px',
    'em' => 'em',
    '%' => '%'
));
?>
<div class="gsf-vc-number-and-unit-wrapper">
	<input type="hidden" name="<?php echo esc_attr($settings['param_name']) ?>"
	       class="<?php echo esc_attr($field_class) ?>" value="<?php echo esc_attr($value) ?>">
	<div class="gsf-vc_number-and-unit-inner">
        <div class="gsf-number-value">
            <input type="number" name="vc_number-value" value="<?php echo (isset($data[0]) ? esc_attr($data[0]) : '') ?>" class="gsf-vc-number-and-unit-field">
        </div>
        <select name="gsf-number-unit" id="gsf-number-unit" class="gsf-vc-number-and-unit-field">
            <?php foreach ($units as $key => $title): ?>
                <?php
                $selected = '';
                if (isset($data[1]) && $key === $data[1]) {
                    $selected = ' selected="selected"';
                }
                ?>
                <option value="<?php echo esc_attr($key) ?>" <?php echo ($selected) ?>><?php echo esc_html($title) ?></option>
            <?php endforeach; ?>
        </select>
	</div>
</div>
