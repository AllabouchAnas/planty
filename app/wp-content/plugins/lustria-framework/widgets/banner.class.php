<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}
if (!class_exists('G5P_Widget_Banner')) {
	class G5P_Widget_Banner extends  GSF_Widget
	{
		public function __construct() {
			$this->widget_cssclass    = 'widget-banner';
			$this->widget_id          = 'gsf-banner';
			$this->widget_name        = esc_html__( 'G5Plus: Banner', 'lustria-framework' );

			$this->settings = array(
				'fields' => array(
					array(
						'id'      => 'title',
						'type'    => 'text',
						'default' => '',
						'title'   => esc_html__('Title:', 'lustria-framework')
					),
                    array(
                        'id'          => 'image',
                        'title'       => esc_html__('Image:', 'lustria-framework'),
                        'type'        => 'image',
                        'sort'     => true,
                    ),
					array(
						'id'          => 'link',
						'title'       => esc_html__('Url redirect:', 'lustria-framework'),
						'type'        => 'text',
						'default'     => '',
                        'required' => array('image[id]', '!=', '')
					),
					array(
						'id'      => 'alt',
						'type'    => 'text',
						'default' => '',
						'title'   => esc_html__('Alt:', 'lustria-framework'),
                        'required' => array('image[id]', '!=', '')
					),
                    array(
                        'type' => 'select',
                        'title' => esc_html__( 'Height Mode', 'lustria-framework' ),
                        'id' => 'height_mode',
                        'options' => array(
                            '100' => '1:1',
                            'original' => esc_html__( 'Original', 'lustria-framework' ),
                            '133.333333333' => '4:3',
                            '75' => '3:4',
                            '177.777777778' => '16:9',
                            '56.25' => '9:16',
                            'custom' => esc_html__( 'Custom (image mode: background)', 'lustria-framework' )
                        ),
                        'default' => 'original',
                        'required' => array('image[id]', '!=', '')
                    ),
                    array(
                        'type' => 'text',
                        'input_type' => 'number',
                        'title' => esc_html__( 'Height', 'lustria-framework' ),
                        'id' => 'height',
                        'default' => '200',
                        'args' => array(
                            'min' => '0',
                            'max' => '500',
                            'step' => '1'
                        ),
                        'required' => array(
                            array('image[id]', '!=', ''),
                            array('height_mode', '=', 'custom')
                        )
                    ),
					array(
						'id'        => 'effect',
						'title'     => esc_html__('Hover Effect: ', 'lustria-framework'),
						'type'      => 'select',
						'default'      => 'normal-effect',
						'options' => array(
							'normal-effect' => esc_html__('Normal', 'lustria-framework'),
							'suprema-effect' => esc_html__('Suprema', 'lustria-framework'),
							'layla-effect' => esc_html__('Layla', 'lustria-framework'),
							'bubba-effect'=> esc_html__('Bubba', 'lustria-framework'),
							'jazz-effect' => esc_html__('Jazz', 'lustria-framework'),
                            'flash-effect' => esc_html__('Flash', 'lustria-framework')
						),
                        'required' => array('image[id]', '!=', '')
					)
				)
			);

			parent::__construct();
		}

		public function widget($args, $instance) {
			extract( $args, EXTR_SKIP );
			$wrapper_classes = array(
				'widget-banner-content',
				$instance['effect'],
			);
            $title = (!empty($instance['title'])) ? $instance['title'] : '';
            $title = apply_filters('widget_title', $title, $instance, $this->id_base);
            echo wp_kses_post($args['before_widget']);
            if ($title) {
                echo wp_kses_post($args['before_title'] . $title . $args['after_title']);
            }
            $image = apply_filters( 'widget_image', $instance['image'] );
            if(!empty($image['id']) && !empty($image['url']) && function_exists('G5Plus_Lustria')) {
                $alt = (!empty($instance['alt'])) ? $instance['alt'] : '';
                $link = $image_url = $attachment_title = "";
                $height_mode = (!empty($instance['height_mode'])) ? $instance['height_mode'] : '100';
                $height = (!empty($instance['height'])) ? $instance['height'] : '200';

                $banner_bg_css = '';
                $banner_class = 'gf-banner-'.random_int( 1000, 9999 );
                $image_arr = wp_get_attachment_image_src( $image['id'], 'full' );
                $img_width = isset($image_arr[1]) ? intval($image_arr[1]) : 0;
                $img_height = isset($image_arr[2]) ? intval($image_arr[2]) : 0;
                if($height_mode != 'custom') {
                    if($height_mode !== 'original') {
                        $height = round($img_width*$height_mode/100);
                        if($img_height < $height) {
                            $img_width = $img_height;
                            $img_height = round($img_width*$height_mode/100);
                        } else {
                            $img_height = $height;
                        }
                    }
                    if($img_width > 400) {
                        $img_height = round($img_height/($img_width/400));
                        $img_width = 400;
                    }
                } else {
                    $wrapper_classes[] = 'banner-mode-background';
                    $img_url = $image['url'];
                    $banner_bg_css =<<<CSS
			.{$banner_class} {
			    background-image: url('{$img_url}');
				height: {$height}px;
			}
CSS;
                }
                GSF()->customCss()->addCss($banner_bg_css);
                $wrapper_class = implode(' ', array_filter($wrapper_classes));

                $attachment_title = get_the_title($image['id']);
                $alt_image = (!empty($alt)) ? $alt : $attachment_title;
                $image =  G5Plus_Lustria()->image_resize()->resize(array(
                    'image_id' => $image['id'],
                    'width' => $img_width,
                    'height' => $img_height
                ));
                $img_html = '<img width="' . $img_width . '" height="' . $img_height . '" src="' . $image['url'] . '" alt="' . $alt_image . '">';

                if (!empty($instance['link'])) {
                    $link = $instance['link'];
                }
                ?>
                <div class="<?php echo esc_attr($wrapper_class) ?>">
                    <div class="effect-bg-image <?php echo esc_attr($banner_class); ?>"></div>
                    <?php if (!empty($link)): ?>
                        <a href="<?php echo esc_url($link) ?>" title="<?php echo esc_attr($alt_image); ?>" class="effect-content">
                            <span class="banner-overlay"></span>
                            <?php if($height_mode !== 'custom'): ?>
                                <?php echo wp_kses_post($img_html); ?>
                            <?php endif; ?>
                        </a>
                    <?php else: ?>
                        <div class="effect-content">
                            <span class="banner-overlay"></span>
                            <?php if($height_mode !== 'custom'): ?>
                                <?php echo wp_kses_post($img_html); ?>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php
            }
			echo wp_kses_post($args['after_widget']);
		}
	}
}