<?php
/**
 * The template for displaying number-responsive.tpl.php
 * @var $settings
 * @var $value
 * @var $size_types
 */
$field_classes = array(
	'wpb_vc_param_value',
	$settings['param_name'],
	"{$settings['type']}_field"
);
$data = explode('|', $value);
$field_class = implode(' ', array_filter($field_classes));
?>
<div class="gsf-vc-number-responsive-wrapper">
	<input type="hidden" name="<?php echo esc_attr($settings['param_name']) ?>"
	       class="<?php echo esc_attr($field_class) ?>" value="<?php echo esc_attr($value) ?>">
	<div class="gsf-vc_number-responsive-inner">
        <?php foreach ($size_types as $key => $size) : ?>
            <div class="vc_screen-size vc_screen-size-<?php echo esc_attr($key) ?>">
                <?php $icon = '';
                $custom_css = array();
                $index = array_search($key, array_keys($size_types));
                switch ($key) {
                    case 'lg':
                        $icon = 'landscape-tablets';
                        break;
                    case 'md':
                        $icon = 'portrait-tablets';
                        break;
                    case 'sm':
                        $custom_css[] = 'font-size: 11px';
                        $icon = 'landscape-smartphones';
                        break;
                    case 'mb':
                        $icon = 'portrait-smartphones';
                        break;
                    default:
                    case 'xl':
                        $icon = 'default';
                        break;
                }?>
                <label title="<?php echo esc_attr($size) ?>" for="vc_number-<?php echo esc_attr($key);?>"><i
                        class="vc-composer-icon vc-c-icon-layout_<?php echo esc_attr($icon) ?>" style='<?php echo join(';', $custom_css); ?>'></i></label>
                <input type="number" name="vc_number-<?php echo esc_attr($key);?>" id="vc_number-<?php echo esc_attr($key);?>" value="<?php echo esc_attr($data[$index]) ?>" class="gsf-vc-number-responsive-field">
            </div>
        <?php endforeach; ?>
	</div>
</div>
