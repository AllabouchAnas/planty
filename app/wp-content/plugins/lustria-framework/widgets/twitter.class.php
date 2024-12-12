<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
if (!class_exists('G5P_Widget_Twitter')) {
    class G5P_Widget_Twitter extends GSF_Widget
    {
        public function __construct()
        {
            $this->widget_cssclass = 'widget-twitter';
            $this->widget_id = 'gsf-twitter';
            $this->widget_description = esc_html__("Display your latest tweets", 'lustria-framework');
            $this->widget_name = esc_html__('G5Plus: Twitter', 'lustria-framework');
            $this->settings = array(
                'fields' => array(
                    array(
                        'id'      => 'title',
                        'type'    => 'text',
                        'default' => '',
                        'title'   => esc_html__('Title', 'lustria-framework')
                    ),
                    array(
                        'id'      => 'user_name',
                        'type'    => 'text',
                        'default' => '',
                        'title'   => esc_html__('User Name', 'lustria-framework')
                    ),
                    array(
                        'id'      => 'consumer_key',
                        'type'    => 'text',
                        'default' => '',
                        'title'   => esc_html__('Consumer Key', 'lustria-framework')
                    ),
                    array(
                        'id'      => 'consumer_secret',
                        'type'    => 'text',
                        'default' => '',
                        'title'   => esc_html__('Consumer Secret', 'lustria-framework')
                    ),
                    array(
                        'id'      => 'access_token',
                        'type'    => 'text',
                        'default' => '',
                        'title'   => esc_html__('Access Token', 'lustria-framework')
                    ),
                    array(
                        'id'      => 'access_token_secret',
                        'type'    => 'text',
                        'default' => '',
                        'title'   => esc_html__('Access Token Secret', 'lustria-framework')
                    ),
                    array(
                        'id'      => 'time_to_store',
                        'type'    => 'text',
                        'default' => '',
                        'title'   => esc_html__('Time To Store', 'lustria-framework')
                    ),
                    array(
                        'id'      => 'total_feed',
                        'type'    => 'text',
                        'default' => '',
                        'title'   => esc_html__('Total Feed', 'lustria-framework')
                    )
                )
            );
            parent::__construct();
        }

        public function widget($args, $instance)
        {
            if ($this->get_cached_widget($args)) return;
            G5P()->loadFile(G5P()->pluginDir("widgets/twitter/twitterclient.php"));
            extract($args, EXTR_SKIP);

            $title = (!empty($instance['title'])) ? $instance['title'] : '';
            $title = apply_filters('widget_title', $title, $instance, $this->id_base);
            $user_name = (!empty($instance['user_name'])) ? $instance['user_name'] : '';
            $consumer_key = (!empty($instance['consumer_key'])) ? $instance['consumer_key'] : '';
            $consumer_secret = (!empty($instance['consumer_secret'])) ? $instance['consumer_secret'] : '';
            $access_token = (!empty($instance['access_token'])) ? $instance['access_token'] : '';
            $access_token_secret = (!empty($instance['access_token_secret'])) ? $instance['access_token_secret'] : '';
            $time_to_store = (!empty($instance['time_to_store'])) ? $instance['time_to_store'] : '';
            $total_feed = (!empty($instance['total_feed'])) ? $instance['total_feed'] : '';

            $transient_feed_tweet = 'transient_feed_tweet';
            if (!empty($time_to_store) && is_numeric($time_to_store)) {
                $fetchedTweets = get_transient($transient_feed_tweet);
            } else {
                delete_transient($transient_feed_tweet);
            }

            $twitterClient = new TwitterClient(trim($consumer_key), trim($consumer_secret), trim($access_token), trim($access_token_secret));

            if (!isset($fetchedTweets) || !$fetchedTweets) {
                $fetchedTweets = $twitterClient->getTweet(trim($user_name), $total_feed);
                if (!empty($time_to_store) && is_numeric($time_to_store)) {
                    set_transient($transient_feed_tweet, $fetchedTweets, 60 * $time_to_store);
                }
            }
            ob_start();
            $limitToDisplay = 0;
            if (!empty($fetchedTweets)) {
                $limitToDisplay = min($total_feed, count($fetchedTweets));
            }
            if ($limitToDisplay > 0) {

                ?>
                <?php echo wp_kses_post($args['before_widget']); ?>
                <?php if ($title) {
                    echo wp_kses_post($args['before_title'] . $title . $args['after_title']);
                } ?>
                <div class="widget-twitter-wrapper">
                    <?php for ($i = 0; $i < $limitToDisplay; $i++):
                        $tweet = $fetchedTweets[$i];
                        $text = $twitterClient->sanitize_links($tweet);
                        ?>
                        <div class="widget-twitter-item">
                            <i class="fab fa-twitter"></i>
                            <div class="twitter-content heading-color">
                                <?php echo wp_kses_post($text); ?>
                            </div>
                        </div>
                    <?php endfor; ?>
                    <a href="<?php echo esc_html('http://twitter.com/' . $user_name); ?>" target="_blank" class="follow-us btn btn-primary"><?php echo esc_html('Follow on Twitter','lustria-framework')?></a>
                </div>
                <?php echo wp_kses_post($args['after_widget']); ?>
                <?php
            }
            $content = ob_get_clean();
            echo wp_kses_post($content);
            $this->cache_widget($args, $content);
        }
    }
}