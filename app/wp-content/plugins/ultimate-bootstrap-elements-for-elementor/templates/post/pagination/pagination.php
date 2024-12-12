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
            data-page="0" data-total-page="<?php echo esc_attr( $total_page ) ?>"
            data-widget="<?php echo esc_attr( $settings_array['id'] ) ?>"
            data-nonce="<?php echo esc_attr( $nonce_field ) ?>"
        >
            <a href="#" class="page-link ladda-button" title="<?php esc_attr_e( 'Previous', 'ube' ) ?>" data-ladda="true"
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
		<?php for ( $i = 1; $i <= $total_page; $i ++ ): ?>
            <li class="page-item ube-page-item<?php if ( $i == 1 )
				echo ' active' ?>" data-args="<?php echo http_build_query( $args ) ?>"
                data-settings="<?php echo http_build_query( $settings_array ) ?>"
                data-page="<?php echo esc_attr( $i ) ?>"
                data-total-page="<?php echo esc_attr( $total_page ) ?>"
                data-widget="<?php echo esc_attr( $settings_array['id'] ) ?>"
                data-nonce="<?php echo esc_attr( $nonce_field ) ?>">
                <a class="page-link ladda-button" href="#" data-ladda="true" data-style="zoom-out"
                   data-spinner-color="black"><?php echo esc_html( $i ) ?></a>
            </li>
		<?php endfor; ?>
        <li class="page-item ube-page-item next" data-args="<?php echo http_build_query( $args ) ?>"
            data-settings="<?php echo http_build_query( $settings_array ) ?>"
            data-page="2" data-total-page="<?php echo esc_attr( $total_page ) ?>"
            data-widget="<?php echo esc_attr( $settings_array['id'] ) ?>"
            data-nonce="<?php echo esc_attr( $nonce_field ) ?>"
        >
            <a href="#" class="page-link ladda-button" title="<?php esc_attr_e( 'Next', 'ube' ) ?>" data-ladda="true"
               data-style="zoom-out" data-spinner-color="black">
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