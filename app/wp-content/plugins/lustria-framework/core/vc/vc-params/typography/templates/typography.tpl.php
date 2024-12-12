<?php
/**
 * The template for displaying typography.tpl.php
 *
 * @var $settings
 * @var $value
 */
$field_classes = array(
	'wpb_vc_param_value',
	$settings['param_name'],
	"{$settings['type']}_field"
);
$field_class = implode(' ', array_filter($field_classes));
$values = GSF()->core()->fonts()->getActiveFonts();
?>
<div class="gsf-field-typography-wrapper">
	<input type="hidden" name="<?php echo esc_attr($settings['param_name']) ?>"
	       class="<?php echo esc_attr($field_class) ?>" value="<?php echo esc_attr($value) ?>">
	<?php if (!empty($values) && count($values) > 0) : ?>
		<div class="gsf-field-typography-inner">
			<?php
            $index = 0;
            $font_family = $font_variant = $font_weight = $font_style = '';
            $font = $values[0];
            if(!empty($value)) {
                list($font_family, $font_variant, $font_weight, $font_style) = explode('|', $value);
            } else {
                $font_family = isset($font['name']) ? $font['name'] : $font['family'];
                $font_variant = isset($font['variants'][0]) ? $font['variants'][0] : '400';
                if(strpos($font_variant, 'i') && strpos($font_variant, 'i') != -1) {
                    $font_style = 'italic';
                    $font_weight = substr($font_variant, 0, strpos($font_variant, 'i'));
                    if(!$font_weight || '' == $font_weight) {
                        $font_weight = '400';
                    }
                } else {
                    $font_style = 'normal';
                    if($font_variant == 'regular') {
                        $font_weight = '400';
                    } else {
                        $font_weight = $font_variant;
                    }
                }
            }

            $current_font = $values[0];
            foreach ($values as $font) {
                if((isset($font['name']) && $font_family == $font['name']) || ($font_family == $font['family'])) {
                    $current_font = $font;
                }
            }
            ?>
            <div class="gsf-typography-family">
                <div class="wpb_element_label"><?php esc_html_e('Font Family','lustria-framework'); ?></div>
                <p>
                    <select data-field-control="" placeholder="<?php esc_attr_e('Select Font Family','lustria-framework'); ?>"
                            class="gsf-typography-font-family" name="font_family">
                        <?php foreach ($values as $font): ?>
                            <option data-font-variants="<?php echo esc_attr(join('|', $font['variants'])); ?>" value="<?php echo esc_attr($font['family']); ?>"
                                <?php selected($font['family'], $font_family); ?>><?php echo esc_html(isset($font['name']) ? $font['name'] : $font['family']); ?></option>
                        <?php endforeach;?>
                    </select>
                </p>
            </div>
            <div class="gsf-typography-weight-style">
                <div class="wpb_element_label"><?php esc_html_e('Font Style','lustria-framework'); ?></div>
                <p>
                    <select class="gsf-typography-variants" placeholder="<?php esc_attr_e('Select Font Style','lustria-framework'); ?>" name="font_variant">
                        <?php foreach ($current_font['variants'] as $variant): ?>
                            <option value="<?php echo esc_attr($variant); ?>"
                                <?php selected($variant, $font_variant); ?>><?php echo esc_html($variant); ?></option>
                        <?php endforeach;?>
                    </select>
                </p>
            </div>
            <div class="typography-preview">
                <div class="wpb_element_label"><?php esc_html_e('Font Preview','lustria-framework'); ?></div>
                <p style="font-family: '<?php echo esc_attr($font_family); ?>'; font-style: <?php echo esc_attr($font_style); ?>;
                    font-weight: <?php echo esc_attr($font_weight); ?>">​‌A​‌B​‌C​‌D​‌E​‌F​‌G​‌H​‌I​‌J​‌K​‌L​‌M​‌N​‌O​‌P​‌Q​‌R​‌S​‌T​‌U​‌V​‌W​‌X​‌Y​‌Z​‌a​‌b​‌c​‌d​‌e​‌f​‌g​‌h​‌i​‌j​‌k​‌l​‌m​‌n​‌o​‌p​‌q​‌r​‌s​‌t​‌u​‌v​‌w​‌x​‌y​‌z​‌1​‌2​‌3​‌4​‌5​‌6​‌7​‌8​‌9​‌0​‌‘​‌?​‌’​‌“​‌!​‌”​‌(​‌%​‌)​‌[​‌#​‌]​‌{​‌@​‌}​‌/​‌&​‌<​‌-​‌+​‌÷​‌×​‌=​‌>​‌®​‌©​‌$​‌€​‌£​‌¥​‌¢​‌:​‌;​‌,​‌.​‌*</p>
            </div>
		</div>
	<?php endif; ?>
</div>
