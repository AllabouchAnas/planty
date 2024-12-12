<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
if (!class_exists('GPL_Columns')) {
	class GPL_Columns {
		private static $_instance;
		public static function getInstance()
		{
			if (self::$_instance == NULL) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		public function init() {
			add_action( 'post_submitbox_misc_actions', array( $this, 'submitbox_views' ) );
			add_action( 'save_post', array( $this, 'save_post' ), 10, 2 );
		}

		public function submitbox_views() {
			global $post;
			$post_types = array('post');
			if (! in_array($post->post_type, $post_types) || !current_user_can('edit_post',$post->ID)) {
				return;
			}
			$count = GPL()->get_like_count($post->ID);
			?>
			<div class="misc-pub-section" id="post-like">
				<?php wp_nonce_field( 'post_like_count', 'gpl_nonce' ); ?>
				<span id="post-like-display"> <i class="dashicons dashicons-thumbs-up"></i>
				<?php echo esc_html__('Post Likes','g5plus-post-like') . ': <b>' . number_format_i18n( (int) $count ) . '</b>'; ?>
				</span>
				<a href="#post-like" class="edit-post-like hide-if-no-js"><?php _e( 'Edit', 'g5plus-post-like' ); ?></a>
				<div id="post-like-input-container" class="hide-if-js">
					<p><?php _e( 'Adjust the like count for this post.', 'g5plus-post-like' ); ?></p>
					<input type="number" name="post_like" id="post-like-input" value="<?php echo (int) $count; ?>"/><br />
					<p>
						<a href="#post-like" class="save-post-like hide-if-no-js button"><?php _e( 'OK', 'g5plus-post-like' ); ?></a>
						<a href="#post-like" class="cancel-post-like hide-if-no-js"><?php _e( 'Cancel', 'g5plus-post-like' ); ?></a>
					</p>
				</div>
			</div>
			<?php
		}

		public function save_post($post_id, $post) {
			// break if doing autosave
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
				return $post_id;

			// break if current user can't edit this post
			if ( ! current_user_can( 'edit_post', $post_id ) )
				return $post_id;

			// is post views set
			if ( ! isset( $_POST['post_like'] ) )
				return $post_id;

			// break if post views in not one of the selected
			$post_types = array('post');

			if ( ! in_array( $post->post_type, (array) $post_types ) )
				return $post_id;

			// validate data
			if ( ! isset( $_POST['gpl_nonce'] ) || ! wp_verify_nonce( $_POST['gpl_nonce'], 'post_like_count' ) )
				return $post_id;

			$count = absint( $_POST['post_like']);
			GPL()->update_like_count($count,$post_id);
		}

	}
}