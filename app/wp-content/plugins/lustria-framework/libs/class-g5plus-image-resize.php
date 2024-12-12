<?php
/**
 * The template for displaying class-g5plus-image-resi.php
 *
 */
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
if (!class_exists('G5Plus_Image_Resize')) {
    class G5Plus_Image_Resize
    {
        private static $_instance;

        public static function getInstance()
        {
            if (self::$_instance == NULL) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        public function init()
        {
            add_action('delete_attachment', array($this, 'delete_resized_images'));
        }

        public function resize($args = array())
        {
            $default = array(
                'image_id' => '',
                'width'    => '',
                'height'   => '',
                'crop'     => true,
                'retina'   => false,
                'resize'   => true
            );

            $settings = wp_parse_args($args, $default);
            if ($settings['image_id'] === '') {
                return array('url' => '', 'width' => $settings['width'], 'height' => $settings['height']);
            }

            if ($settings['retina']) {
                $this->resize_by_id($settings['image_id'], $settings['width'], $settings['height'], $settings['crop'], true);
            }
            return $this->resize_by_id($settings['image_id'], $settings['width'], $settings['height'], $settings['crop'], false);
        }

        private function resize_by_id($attachment_id, $width = '', $height = '', $crop = true, $retina = false)
        {
            $width = intval($width !== '' ? $width : get_option('thumbnail_size_w'));
            $height = intval($height !== '' ? $height : get_option('thumbnail_size_h'));
            $retina = ($retina === true) ? 2 : 1;
            $orig_image = wp_get_attachment_image_src($attachment_id, 'full');
            if ($orig_image === false) {
                return array('url' => '', 'width' => $width, 'height' => $height);
            }
            $url = $orig_image[0];
            $orig_width = $orig_image[1];
            $orig_height = $orig_image[2];
            $file_path = get_attached_file($attachment_id);
            if ($height === 0) {
                $height = round(($orig_height / $orig_width) * $width);
            }


            // Destination width and height variables
            $dest_width = $width * $retina;
            $dest_height = $height * $retina;
            // Some additional info about the image.
            $info = pathinfo($file_path);
            $dir = $info['dirname'];
            $ext = '';
            if (!empty($info['extension'])) {
                $ext = $info['extension'];
            }
            $name = wp_basename($file_path, ".$ext");

            // Suffix applied to filename.
            $suffix_retina = (1 != $retina) ? '@' . $retina . 'x' : null;
            $suffix = "{$width}x{$height}{$suffix_retina}";
            // Get the destination file name.
            $dest_file_name = "{$dir}/{$name}-{$suffix}.{$ext}";
            if (!file_exists($dest_file_name)) {
                // Load WordPress Image Editor.
                $editor = wp_get_image_editor($file_path);
                if (is_wp_error($editor)) {
                    return array('url' => $url, 'width' => $width, 'height' => $height);
                }
                $src_x = $src_y = 0;
                $src_w = $orig_width;
                $src_h = $orig_height;
                if ($crop) {
                    $cmp_x = $orig_width / $dest_width;
                    $cmp_y = $orig_height / $dest_height;
                    // Calculate x or y coordinate, and width or height of source.
                    if ($cmp_x > $cmp_y) {
                        $src_w = round($orig_width / $cmp_x * $cmp_y);
                        $src_x = round(($orig_width - ($orig_width / $cmp_x * $cmp_y)) / 2);
                    } elseif ($cmp_y > $cmp_x) {
                        $src_h = round($orig_height / $cmp_y * $cmp_x);
                        $src_y = round(($orig_height - ($orig_height / $cmp_y * $cmp_x)) / 2);
                    }
                }

                // Check if the file is writable before proceeding.
                global $wp_filesystem;
                if (empty($wp_filesystem)) {
                    require_once(ABSPATH . '/wp-admin/includes/file.php');
                    WP_Filesystem();
                }
                if (!$wp_filesystem->put_contents($dest_file_name, '', FS_CHMOD_FILE)) {
                    return array('url' => $url, 'width' => $orig_width, 'height' => $orig_height);
                }

                // Time to crop the image!
                $editor->crop($src_x, $src_y, $src_w, $src_h, $dest_width, $dest_height);
                // Now let's save the image.
                $saved = $editor->save($dest_file_name);
                // If saving fails, return the original image.
                if (is_wp_error($saved)) {
                    return array('url' => $url, 'width' => $width, 'height' => $height);
                }

                // Get resized image information.
                $resized_url = str_replace(basename($url), basename($saved['path']), $url);
                $resized_width = $saved['width'];
                $resized_height = $saved['height'];
                $resized_type = $saved['mime-type'];
                // Add the resized dimensions to original image metadata (so we can delete our resized images when the original image is delete from the Media Library).
                $metadata = wp_get_attachment_metadata($attachment_id);
                if (isset($metadata['image_meta'])) {
                    //$metadata['image_meta']['resized_images'][] = $resized_width . 'x' . $resized_height;
                    $metadata['image_meta']['resized_images'][] = "{$name}-{$suffix}.{$ext}";
                    wp_update_attachment_metadata($attachment_id, $metadata);
                }
                $image_array = array(
                    'url'    => $resized_url,
                    'width'  => $resized_width,
                    'height' => $resized_height,
                    'type'   => $resized_type,
                    'path'   => $dest_file_name,
                );
            } else {
				$image_array = array(
					'url' => str_replace(wp_basename($url), wp_basename($dest_file_name), $url),
					'width' => $dest_width,
					'height' => $dest_height,
					'type' => $ext,
					'path' => $dest_file_name
				);
			}

    $retina_url = file_exists("{$dir}/{$name}-{$suffix}{$suffix_retina}.{$ext}") ? rtrim($image_array['url'], ".{$ext}") . "@2x.{$ext}" : false;
    $image_array['retina_url'] = $retina_url;
    return $image_array;
}

    public
    function delete_resized_images($post_id)
    {
        $metadata = wp_get_attachment_metadata($post_id);
        if (!$metadata) return;
        if (!isset($metadata['file']) || !isset($metadata['image_meta']['resized_images'])) return;
        $pathinfo = pathinfo($metadata['file']);
        $resized_images = $metadata['image_meta']['resized_images'];
        $wp_upload_dir = wp_upload_dir();
        $upload_dir = $wp_upload_dir['basedir'];
        if (!is_dir($upload_dir)) return;
        foreach ($resized_images as $dims) {
            // Get the resized images filename
            $file = $upload_dir . '/' . $pathinfo['dirname'] . '/' . $dims;
            // Delete the resized image
            @unlink($file);
        }
    }
}
}