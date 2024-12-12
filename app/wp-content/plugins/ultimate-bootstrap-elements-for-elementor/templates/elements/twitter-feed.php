<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @var $twitter_link
 * @var $item
 * @var $item_link
 * @var $twitter_feed_show_avatar
 * @var $twitter_feed_show_date
 * @var $twitter_feed_show_icon
 * @var $twitter_feed_media
 * @var $twitter_feed_show_read_more
 * @var $twitter_feed_read_more_text
 */

?>
<div class="ube-twitter-feed-item">
    <div class="ube-twitter-feed-item-inner">
        <div class="ube-twitter-feed-header d-flex align-items-center justify-content-between">
            <div class="ube-twitter-feed-use d-flex align-items-center">
				<?php if ( $twitter_feed_show_avatar == 'true' ): ?>
                    <a class="ube-twitter-feed-avatar"
                       href="<?php echo esc_url( $twitter_link ) ?>" target="_blank">
                        <img src="<?php echo esc_url( $item['user']['profile_image_url_https'] ) ?>"
                             alt="<?php echo esc_attr( $item['user']['name'] ) ?>">
                    </a>
				<?php endif; ?>
                <a class="ube-twitter-feed-meta d-flex align-items-center   "
                   href="<?php echo esc_url( $twitter_link ) ?>" target="_blank">
					<?php if ( $twitter_feed_show_icon === 'true' ): ?>
                        <i class="eicon-twitter"></i>
					<?php endif; ?>
                    <span class="ube-twitter-feed-author"><?php echo esc_html( $item['user']['name'] ) ?></span>
                </a>
            </div>
			<?php if ( $twitter_feed_show_date === 'true' ): ?>
                <span class="ube-twitter-feed-date"><?php echo esc_html( human_time_diff( strtotime( $item['created_at'] ) ) ) . ' ' . esc_html__( 'ago', 'ube' ) ?></span>
			<?php endif; ?>
        </div>
        <div class="ube-twitter-feed-content">
            <p><?php echo wp_kses_post( substr( str_replace( @$item['entities']['urls'][0]['url'], '', $item['full_text'] ), 0, intval( $settings['twitter_feed_content_length'] ) ) ) ?>
                ...</p>
			<?php $img = isset( $item['extended_entities']['media'][0] ) && $twitter_feed_media == 'true' ? ( $item['extended_entities']['media'][0]['type'] == 'photo' ? '<img class="preview" src="' . esc_url( $item['extended_entities']['media'][0]['media_url_https'] ) . '">' : '' ) : '' ?>
			<?php echo wp_kses_post( $img ) ?>
			<?php if ( $twitter_feed_show_read_more === 'true' ): ?>
                <a href="<?php echo esc_url( $item_link ) ?>"
                   target="_blank"
                   class="btn-read-more btn btn-primary"><?php echo esc_html( $twitter_feed_read_more_text ) ?></i></a>
			<?php endif; ?>
        </div>
    </div>
</div>