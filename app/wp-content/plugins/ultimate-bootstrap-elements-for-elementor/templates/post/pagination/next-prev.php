<?php
/**
 * @var $nonce_field
 * @var $settings_array
 * @var $args
 */
?>
<nav class="ube-post-pagination">
    <ul class="pagination">
        <li class="page-item ube-page-item disabled prev" data-args="<?php echo http_build_query( $args ) ?>"
            data-settings="<?php echo http_build_query( $settings_array ) ?>"
            data-page="1" data-total-page="<?php echo esc_attr( $total_page ) ?>"
            data-widget="<?php echo esc_attr( $settings_array['id'] ) ?>"
            data-nonce="<?php echo esc_attr($nonce_field)?>"
        >

            <a href="#" class="page-link ladda-button" title="<?php esc_attr_e( 'Next', 'ube' ) ?>" data-ladda="true"
               data-style="zoom-out" data-spinner-color="black">
				<?php if ( ! empty( $settings_array['prev_text'] ) ): ?>
                    <span class="text">
                         <?php
                         echo esc_html( $settings_array['prev_text'] )
                         ?>
                    </span>
				<?php endif; ?>
				<?php if ( ! empty( $settings_array['prev_icon']['value'] ) ): ?>
                    <span class="icon">
                <?php \Elementor\Icons_Manager::render_icon( $settings_array['prev_icon'] ); ?>
            </span>
				<?php endif; ?>

            </a>

        </li>
        <li class="page-item ube-page-item next" data-args="<?php echo http_build_query( $args ) ?>"
            data-settings="<?php echo http_build_query( $settings_array ) ?>"
            data-page="2" data-total-page="<?php echo esc_attr( $total_page ) ?>"
            data-widget="<?php echo esc_attr( $settings_array['id'] ) ?>"
            data-nonce="<?php echo esc_attr($nonce_field)?>"
        >
            <a href="#" class="page-link ladda-button" title="<?php esc_attr_e( 'Previous', 'ube' ) ?>" data-ladda="true" data-style="zoom-out" data-spinner-color="black">
				<?php if ( ! empty( $settings_array['next_text'] ) ): ?>
                    <span class="text">
                         <?php
                         echo esc_html( $settings_array['next_text'] )
                         ?>
                    </span>
				<?php endif; ?>
				<?php if ( ! empty( $settings_array['next_icon']['value'] ) ): ?>
                    <span class="icon">
                <?php \Elementor\Icons_Manager::render_icon( $settings_array['next_icon'] ); ?>
                    </span>
				<?php endif; ?>
            </a>
        </li>
    </ul>
</nav>