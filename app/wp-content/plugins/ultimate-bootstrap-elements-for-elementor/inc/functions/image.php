<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function ube_get_img_meta($id) {
    $attachment = get_post( $id );
    if ( $attachment == null || $attachment->post_type != 'attachment' ) {
        return null;
    }

    $alt = get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true );
    if ( '' === $alt ) {
        $alt = $attachment->post_title;
    }

    return [
        'alt'         => $alt,
        'caption'     => $attachment->post_excerpt,
        'description' => $attachment->post_content,
        'href'        => get_permalink( $attachment->ID ),
        'src'         => $attachment->guid,
        'title'       => $attachment->post_title
    ];
}

/**
 * Get Image cropped url
 *
 * @param $url
 * @param array $args
 * @return array|string[]
 */
function ube_get_image_cropped_url( $url, $args = array() ) {
    extract( $args );
    /**
     * @var $size
     * @var $width
     * @var $height
     */
    if ( $url === false ) {
        return array( 0 => '' );
    }

    if ( $size === 'full' ) {
        return array( 0 => $url );
    }

    if ( $size !== 'custom' && ! preg_match( '/(\d+)x(\d+)/', $size ) ) {
        $attachment_url = wp_get_attachment_image_url( $args['id'], $size );

        if ( ! $attachment_url ) {
            return array( 0 => $url );
        } else {
            return array( 0 => $attachment_url );
        }
    }

    if ( $size !== 'custom' ) {
        $_sizes = explode( 'x', $size );
        $width  = $_sizes[0];
        $height = $_sizes[1];
    } else {
        if ( $width === '' ) {
            $width = 9999;
        }

        if ( $height === '' ) {
            $height = 9999;
        }
    }

    $width  = (int) $width;
    $height = (int) $height;

    if ( $width === 9999 || $height === 9999 ) {
        $crop = false;
    }

    if ( $width !== '' && $height !== '' && function_exists( 'ube_resize_image_max' ) ) {
        $crop_image = ube_resize_image_max( $url, $width, $height );
        $url        = $crop_image;
    }

    return array( 0 => $url );
}

function ube_build_img_tag( $attributes = array() ) {
    if ( empty( $attributes['src'] ) ) {
        return '';
    }

    $attributes_str = '';

    if ( ! empty( $attributes ) ) {
        foreach ( $attributes as $attribute => $value ) {
            $attributes_str .= ' ' . $attribute . '="' . esc_attr( $value ) . '"';
        }
    }

    $image = '<img ' . $attributes_str . ' />';

    return $image;
}

function ube_get_attachment_by_id( $args = array() ) {
    $defaults = array(
        'id'     => '',
        'size'   => 'full',
        'width'  => '',
        'height' => '',
        'crop'   => true,
    );

    $args = wp_parse_args( $args, $defaults );

    $image_full = ube_get_img_meta( $args['id'] );

    if ( $image_full === null ) {
        return false;
    }

    $url           = $image_full['src'];
    $cropped_image = ube_get_image_cropped_url( $url, $args );

    if ( $cropped_image[0] === '' ) {
        return '';
    }

    $image_attributes = array(
        'src' => $cropped_image[0],
        'alt' => $image_full['alt'],
    );

    if ( isset( $cropped_image[1] ) ) {
        $image_attributes['width'] = $cropped_image[1];
    }

    $image = ube_build_img_tag( $image_attributes );

    // Wrap img with caption tags.
    if ( isset( $args['caption_enable'] ) && $args['caption_enable'] === true && $image_full['caption'] !== '' ) {
        $before = '<figure>';
        $after  = '<figcaption class="wp-caption-text gallery-caption">' . esc_html($image_full['caption']) . '</figcaption></figure>';

        $image = $before . $image . $after;
    }

    return $image;
}

function ube_get_elementor_attachment( array $args ) {
    $defaults = array(
        'settings'       => [],
        'image_key'      => 'image',
        'size_settings'  => [],
        'image_size_key' => 'image_size',
        'attributes'     => [],
    );

    $args = wp_parse_args( $args, $defaults );
    extract( $args );

    if ( empty( $settings ) ) {
        _doing_it_wrong( sprintf( '%s::%s', get_called_class(), __FUNCTION__ ), esc_html__( 'Cannot get attachment because missing elementor widget settings.', 'ube' ), '1.0.0' );

        return false;
    }
    /**
     * @var $image_key
     */

    if ( empty( $settings["{$image_key}"] ) ) {
        _doing_it_wrong( sprintf( '%s::%s', get_called_class(), __FUNCTION__ ), sprintf( esc_html__( 'Cannot get attachment because image key: %s is not exits.', 'ube' ), $image_key ), '1.0.0' );

        return false;
    }

    $image = $settings["{$image_key}"];

    // Default same name with $image_key
    if ( empty( $image_size_key ) ) {
        $image_size_key = $image_key;
    }

    // If image has no both id & url.
    if ( empty( $image['url'] ) && empty( $image['id'] ) ) {
        _doing_it_wrong( sprintf( '%s::%s', get_called_class(), __FUNCTION__ ), sprintf( esc_html__( 'Cannot get attachment because image key: %s has no both id & url.', 'ube' ), $image_key ), '1.0.0' );

        return false;
    }

    // If image has id.
    if ( ! empty( $image['id'] ) ) {
        $attachment_args = array(
            'id' => $image['id'],
        );

        // If not override. then use from $settings.
        if ( empty( $size_settings ) ) {
            $size_settings = $settings;
        }

        // Check if image has custom size.
        // Usage: `{name}_size` and `{name}_custom_dimension`, default `image_size` and `image_custom_dimension`.
        if ( isset( $size_settings["{$image_size_key}_size"] ) ) {
            $image_size = $size_settings["{$image_size_key}_size"];

            // Get get image size.
            if ( 'custom' === $image_size ) {
                $width  = $size_settings["{$image_size_key}_custom_dimension"]['width'];
                $height = $size_settings["{$image_size_key}_custom_dimension"]['height'];

                if ( empty( $width ) ) {
                    $width = 9999;

                    $attachment_args['crop'] = false;
                }

                if ( empty( $height ) ) {
                    $height = 9999;

                    $attachment_args['crop'] = false;
                }

                $attachment_args['size'] = "{$width}x{$height}";

            } else {
                // WP Image Size like: full, thumbnail, large...
                $attachment_args['size'] = $image_size;
            }
        }

        $attachment = ube_get_attachment_by_id( $attachment_args );
    } else {
        $attributes['src'] = $image['url'];

        $attachment = ube_build_img_tag( $attributes );
    }

    return $attachment;
}

