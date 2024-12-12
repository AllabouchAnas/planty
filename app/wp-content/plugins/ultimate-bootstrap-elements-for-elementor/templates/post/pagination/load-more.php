<?php
/**
 * @var $show_load_more_text
 * @var $args
 * @var $settings_array
 * @var $total_page
 * @var $class
 * @var $show_load_more_text
 * @var $nonce_field
 */
?>
<div class="ube-load-more-button-wrap">
    <button class="ladda-button <?php echo esc_attr($settings_array['button_class']) ?>" data-ladda="true" data-style="zoom-out"
            data-spinner-color="black"
            data-args="<?php echo http_build_query( $args ) ?>"
            data-settings="<?php echo http_build_query( $settings_array ) ?>" data-page="1"
            data-total-page="<?php echo esc_attr( $total_page ) ?>"
            data-nonce="<?php echo esc_attr($nonce_field)?>" data-widget="<?php echo esc_attr( $settings_array['id'] ) ?>">
        <span class="button-text"><?php echo esc_html( $show_load_more_text ) ?></span>
    </button>
</div>