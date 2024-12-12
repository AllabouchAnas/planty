<?php
/**
 * @var $category_length
 */
?>
<article class="card ube-post-item ube-post-list-layout-03">
    <div class="ube-post-list-content">
		<?php
		if ( has_post_thumbnail() && $settings['show_image'] == 'yes' ) :
			?>
            <a class="ube-entry-post-thumb card-img" href="<?php echo esc_url( get_the_permalink() ) ?>"
               style="background-image: url('<?php echo esc_url( wp_get_attachment_image_url( get_post_thumbnail_id(), $settings['image_size'] ) ) ?>')">
            </a>
		<?php endif; ?>
        <div class="card-body">
			<?php if ( $settings['show_date'] === 'yes' ) :
				$date = date_create( get_the_date() );
				$day = date_format( $date, "d" );
				$month = date_format( $date, "F" );
				?>
                <div class="ube-posted-on">
                    <span class="day"><?php echo esc_html( $day ) ?></span>
                    <span class="month"><?php echo esc_html( $month ) ?></span>
                </div>
			<?php endif; ?>
            <div class="ube-post-content">
                <ul class="ube-entry-meta list-inline">
					<?php if ( $settings['show_meta'] ) : ?>
						<?php if ( $settings['show_author'] === 'yes' ) : ?>
                            <li class="list-inline-item ube-posted-by">
                                <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) ?> "
                                   class="value"><?php echo esc_html( get_the_author_meta( 'display_name' ) ) ?></a>
                            </li>
						<?php endif; ?>
					<?php endif; ?>
					<?php if ( $settings['show_meta'] === 'yes' && $settings['show_author'] === 'yes' && $settings['show_category'] == 'yes' ) : ?>
                        <li class="list-inline-item ube-post-meta-separate">
                            /
                        </li>
					<?php endif; ?>
					<?php if ( $settings['show_category'] == 'yes' ):
						$categories = ube_get_terms_as_list( 'category', $category_length, get_the_ID() );
						if ( ! empty( $categories ) ):
							?>
                            <li class="list-inline-item ube-post-terms">
                                <div class="item category">
									<?php
									echo wp_kses_post( $categories );
									?>
                                </div>
                            </li>
						<?php endif; ?>
					<?php endif; ?>
                </ul>
                <header class="ube-entry-header">
					<?php if ( $settings['show_title'] ): ?>
                        <h2 class="ube-entry-title">
                            <a class="ube-post-link" href="<?php echo esc_url( get_the_permalink() ) ?>"
                               title="<?php echo esc_attr( get_the_title() ) ?>">
								<?php echo esc_html( get_the_title() ) ?>
                            </a>
                        </h2>
					<?php endif; ?>
                </header>
				<?php if ( $settings['show_excerpt'] ) : ?>
                    <div class="ube-entry-content">
                        <div class="ube-post-excerpt">
                            <p><?php echo wp_kses_post( wp_trim_words( strip_shortcodes( get_the_excerpt() ? get_the_excerpt() :
									get_the_content() ), $settings['excerpt_length'],
									$settings['excerpt_expansion_indicator'] ) ) ?></p>
                        </div>
                        <div class="read-more-button-wrapper">
							<?php if ( $settings['show_read_more_button'] ) : ?>
                                <a href="<?php echo esc_url( get_the_permalink() ) ?>"
                                   class="ube-post-read-more-btn <?php if ( $settings['show_read_more_button_prefix_style'] == 'yes' ) {
									   echo 'ube-post-read-more-btn-prefix';
								   } ?>  <?php echo esc_attr($settings['read_more_class'])?>">
									<?php echo
									esc_html( $settings['read_more_button_text'] ) ?>
									<?php if ( ! empty( $settings['read_more_button_text_suffix']['value'] ) ): ?>
                                        <span class="button-suffix">
                                <?php \Elementor\Icons_Manager::render_icon( $settings['read_more_button_text_suffix'] ); ?>
                            </span>
									<?php endif; ?>
                                </a>
							<?php endif; ?>
                        </div>
                    </div>
				<?php endif; ?>
            </div>
        </div>
    </div>
</article>