<?php
/**
 * @var $category_length
 * @var $settings
 */
?>
<div class="<?php echo esc_attr( $settings['column_class'] ) ?>">
    <article class="card ube-post-item ube-post-grid-layout-04 <?php if(!has_post_thumbnail() || $settings['show_image'] != 'yes'){ echo 'ube-post-item-no-thumb';}?>">
		<?php
		if ( has_post_thumbnail() && $settings['show_image'] == 'yes' ) :
			?>
            <a class="ube-entry-post-thumb card-img" href="<?php echo esc_url( get_the_permalink() ) ?>">
                <img src="<?php echo esc_url( wp_get_attachment_image_url( get_post_thumbnail_id(), $settings['image_size'] ) ) ?>"
                     alt="<?php echo esc_attr( get_the_title() ) ?>">
            </a>
		<?php endif; ?>
        <div class="card-img-overlay">
			<?php if ( $settings['show_day'] === 'yes' ) :
				$date = date_create( get_the_date() );
				$day = date_format( $date, "d" );
				$month = date_format( $date, "F" );
				?>
                <div class="ube-posted-day">
					<?php echo esc_html( $day ) ?>
                </div>
			<?php endif; ?>
			<?php if ( $settings['show_meta'] ) : ?>
                <ul class="ube-entry-meta list-inline">
					<?php if ( $settings['show_author'] === 'yes' ) : ?>
                        <li class="list-inline-item ube-posted-by">
							<?php if ( $settings['show_author_icon'] == 'yes' ) : ?>
								<?php
								echo UBE_Icon::get_instance()->get_svg( 'user' )
								?>
							<?php elseif ( $settings['show_avatar'] == 'yes' ) : ?>
                                <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) ?> "
                                   class="author-image"><?php echo get_avatar( get_the_author_meta( 'ID' ), 40 ) ?></a>
							<?php endif; ?>
							<?php if ( $settings['author_text_prefix'] != '' ) : ?>
                                <span class="text"><?php echo esc_html( $settings['author_text_prefix'] ) ?></span>
							<?php endif; ?>
                            <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) ?> "
                               class="value"><?php echo esc_html( get_the_author_meta( 'display_name' ) ) ?></a>

                        </li>
					<?php endif; ?>
					<?php if ( $settings['show_date'] === 'yes' ) : ?>
                        <li class="list-inline-item ube-posted-on">

							<?php if ( $settings['show_date_icon'] == 'yes' ) : ?>
								<?php
								echo UBE_Icon::get_instance()->get_svg( 'calendar-alt' )
								?>
							<?php endif; ?>
							<?php if ( $settings['date_text_prefix'] != '' ) : ?>
                                <span class="text"><?php echo esc_html( $settings['date_text_prefix'] ) ?></span>
							<?php endif; ?>
                            <a href="<?php echo esc_url( get_the_permalink() ) ?>" class="value">
                                <time
                                        datetime="<?php echo esc_attr( get_the_date() ) ?>"><?php echo esc_html( get_the_date() ) ?></time>
                            </a>

                        </li>
					<?php endif; ?>

					<?php

					if ( $settings['show_comment_count'] == 'yes' ) : ?>
                        <li class="list-inline-item ube-comments-count">
							<?php if ( $settings['show_comment_icon'] == 'yes' ) : ?>
								<?php
								echo UBE_Icon::get_instance()->get_svg( 'comment-alt' )
								?>
							<?php endif; ?>
                            <a href="<?php echo esc_url( get_the_permalink() ) ?>" class="value">
                                <span><?php echo esc_html( get_comments_number( get_the_ID() ) ) ?></span>

								<?php if ( $settings['comment_text_suffix'] != '' ) : ?>
                                    <span><?php echo esc_html( $settings['comment_text_suffix'] ) ?></span>
								<?php endif; ?>
                            </a>

                        </li>
					<?php endif; ?>
                </ul>
			<?php endif; ?>
			<?php if ( $settings['show_category'] == 'yes' ):
				$categories = ube_get_terms_as_list( 'category', $category_length, get_the_ID() );
				if ( ! empty( $categories ) ):
					?>
                    <div class="ube-post-terms">
                        <div class="item category">
							<?php if ( $settings['show_category_icon'] == 'yes' ) : ?>
								<?php
								echo UBE_Icon::get_instance()->get_svg( 'folder' )
								?>
							<?php endif; ?>
							<?php
							echo wp_kses_post( $categories );
							?>
                        </div>
                    </div>
				<?php endif; ?>
			<?php endif; ?>
            <header class="ube-entry-header">
				<?php if ( $settings['show_title'] ): ?>
                    <h2 class="ube-entry-title card-title">
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
                        <p class="card-text"><?php echo wp_kses_post( wp_trim_words( strip_shortcodes( get_the_excerpt() ? get_the_excerpt() :
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
    </article>
</div>
