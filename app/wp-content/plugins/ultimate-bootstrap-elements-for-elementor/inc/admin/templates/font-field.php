<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * @var $select_name
 * @var $select_value
 */
?>
<select name="<?php echo esc_attr($select_name) ?>" id="<?php echo esc_attr($select_name) ?>" class="regular-text select2 ube-select2">
    <option value=""><?php echo esc_html__('Default', 'ube') ?></option>
    <?php foreach (\Elementor\Fonts::get_font_groups() as $g_key => $g_value): ?>
        <optgroup label="<?php echo esc_attr($g_value) ?>">
            <?php foreach (\Elementor\Fonts::get_fonts() as $f_key => $f_value): ?>
                <?php if ($f_value === $g_key): ?>
                    <option value="<?php echo esc_attr($f_key)?>" <?php selected($select_value, $f_key) ?>>
                        <?php echo esc_html($f_key) ?>
                    </option>
                <?php endif; ?>
            <?php endforeach; ?>
        </optgroup>
    <?php endforeach; ?>
</select>