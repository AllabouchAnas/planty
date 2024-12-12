<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * @var $item
 * @var $page_link
 * @var $target
 * @var $image_url
 * @var $message
 * @var $photo
 * @var $comments
 * @var $likes
 * @var $fbf_comments
 * @var $fbf_likes
 * @var $fbf_message
 * @var $fbf_date
 */


?>
<div class="ube-facebook-feed-item">
    <div class="ube-facebook-feed-item-inner">
        <header class="ube-facebook-feed-header d-flex align-items-center justify-content-between">
            <div class="item-user d-flex align-items-center">
                <a href="<?php echo esc_url( $page_link ) ?>"
                   target="<?php echo esc_attr( $target ) ?>" class="avatar"><img
                            src="<?php echo esc_url( $image_url ) ?>"
                            alt="<?php echo esc_attr( $item['from']['name'] ) ?>"
                            class="rounded-circle"></a>
                <a href="<?php echo esc_url( $page_link ) ?>"
                   target="<?php echo esc_attr( $target ) ?>">
                    <p class="username"><?php echo esc_html( $item['from']['name'] ) ?></p>
                </a>
            </div>
			<?php if ( $fbf_date == 'yes' ): ?>
                <a href="<?php echo esc_attr( $item['permalink_url'] ) ?>"
                   target="<?php echo esc_attr( $target ) ?>" class="post-time d-flex align-items-center">
					<?php echo UBE_Icon::get_instance()->get_svg( 'clock-regular' ) ?><?php echo esc_html( date( "d M Y", strtotime( $item['created_time'] ) ) ) ?>
                </a>
			<?php endif; ?>
        </header>
		<?php if ( $fbf_message && ! empty( $message ) ): ?>
            <div class="ube-facebook-feed-content">
                <p class="message"><?php echo esc_html( $message ) ?></p>
            </div>
		<?php endif; ?>
		<?php if ( ! empty( $photo ) || isset( $item['attachments']['data'] ) ): ?>
            <div class="ube-facebook-feed-preview">
				<?php if ( $item['status_type'] == 'shared_story' ): ?>
                    <a href="<?php $item['permalink_url'] ?>" target="<?php echo esc_attr( $target ) ?>"
                       class="preview d-block position-relative">
						<?php if ( $item['attachments']['data'][0]['media_type'] == 'video' ): ?>
                            <img class="img-preview" src="<?php echo esc_url( $photo ) ?>">
                            <div class="ube-facebook-feed-preview-overlay position-absolute d-flex align-items-center justify-content-center">
								<?php echo UBE_Icon::get_instance()->get_svg( 'play-circle-regular' ) ?>
                            </div>
						<?php else: ?>
                            <img class="img-preview" src="<?php echo esc_url( $photo ) ?>">
						<?php endif; ?>
                    </a>
                    <div class="url-preview">
                        <p class="url-host"><?php echo parse_url( $item['attachments']['data'][0]['unshimmed_url'] )['host'] ?></p>
                        <h2 class="url-title"><?php echo esc_html( $item['attachments']['data'][0]['title'] ) ?></h2>
                        <p class="url-description"><?php echo esc_html( $item['attachments']['data'][0]['description'] ) ?></p>
                    </div>
				<?php else: if ( $item['status_type'] == 'added_video' ): ?>
                    <a href="<?php echo esc_url( $item['permalink_url'] ) ?>"
                       target="<?php echo esc_attr( $target ) ?>"
                       class="preview d-block position-relative">
                        <img class="img-preview" src="<?php echo esc_url( $photo ) ?>">
                        <div class="ube-facebook-feed-preview-overlay position-absolute d-flex align-items-center justify-content-center">
							<?php echo UBE_Icon::get_instance()->get_svg( 'play-circle-regular' ) ?>
                        </div>
                    </a>
				<?php else: ?>
                    <a href="<?php echo esc_url( $item['permalink_url'] ) ?>"
                       target="<?php echo esc_attr( $target ) ?>" class="preview">
                        <img class="img-preview" src="<?php echo esc_url( $photo ) ?>">
                    </a>
				<?php endif; ?>
				<?php endif; ?>
            </div>
		<?php endif; ?>
		<?php if ( $fbf_likes || $fbf_comments ): ?>
            <footer class="ube-facebook-feed-footer">
				<?php if ( $fbf_likes ): ?>
                    <span class="post-likes"><?php echo UBE_Icon::get_instance()->get_svg( 'thumbs-up-regular' ) ?><?php echo esc_html( $likes ) ?></span>
				<?php endif; ?>
				<?php if ( $fbf_comments ): ?>
                    <span class="post-comments"><?php echo UBE_Icon::get_instance()->get_svg( 'comments-regular' ) ?><?php echo esc_html( $comments ) ?></span>
				<?php endif; ?>
            </footer>
		<?php endif; ?>
    </div>
</div>