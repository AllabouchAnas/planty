<?php
/**
 * Class Fonts
 *
 * @package WordPress
 * @subpackage emo
 * @since emo 1.0
 */
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}

if (!class_exists('GSF_Core_Fonts')) {
    class GSF_Core_Fonts
    {
        /*
         * loader instances
         */
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
            add_filter( 'editor_stylesheets', array( $this, 'editor_stylesheets' ), 100 );
            add_action('init', array($this, 'fontEnqueue'));
            add_action('admin_menu', array($this, 'menu'));
            add_action('wp_ajax_gsf_get_font_list', array($this, 'ajaxGetFontList'));
            add_action('wp_ajax_gsf_upload_fonts', array($this, 'ajaxUploadFonts'));
            add_action('wp_ajax_gsf_delete_custom_font', array($this, 'ajaxDeleteCustomFont'));
            add_action('wp_ajax_gsf_using_font', array($this, 'ajaxUsingFont'));
            add_action('wp_ajax_gsf_remove_active_font', array($this, 'ajaxRemoveActiveFont'));
            add_action('wp_ajax_gsf_save_active_font', array($this, 'ajaxSaveActiveFont'));
            add_action('wp_ajax_gsf_reset_active_font', array($this, 'ajaxResetActiveFont'));
            add_action( 'enqueue_block_editor_assets', array($this,'block_editor_styles') );

        }

        public function menu()
        {
            if (!get_theme_support( 'gsf_font_management' )) return;

            add_submenu_page(
                'gsf_welcome',
                esc_html__('Fonts Management', 'lustria-framework'),
                esc_html__('Fonts Management', 'lustria-framework'),
                'manage_options',
                'gsf_fonts_management',
                array($this, 'binderPage')
            );

            $current_page = isset($_GET['page']) ? $_GET['page'] : '';
            if ($current_page == 'gsf_fonts_management') {
                // Enqueue common styles and scripts
                add_action('admin_init', array($this, 'adminEnqueueStyles'));
                add_action('admin_init', array($this, 'adminEnqueueScripts'), 15);
                add_action('admin_footer', array($this, 'fontsTemplates'), 1000);
            }
        }

        public function adminEnqueueStyles()
        {
            wp_enqueue_style('magnific-popup');
            wp_enqueue_style('font-awesome-5pro');
            wp_enqueue_style(GSF()->assetsHandle('fonts'), GSF()->helper()->getAssetUrl('core/fonts/assets/fonts.min.css'), array(), GSF()->pluginVer());
        }

        public function adminEnqueueScripts()
        {
            wp_enqueue_script('magnific-popup');
            wp_enqueue_script(GSF()->assetsHandle('fonts'), GSF()->helper()->getAssetUrl('core/fonts/assets/fonts.min.js'), array('jquery', 'wp-util', 'jquery-form'), GSF()->pluginVer(), true);
            wp_localize_script(GSF()->assetsHandle('fonts'), 'GSF_META_DATA', array(
                'ajaxUrl' => admin_url('admin-ajax.php'),
                'nonce'   => GSF()->helper()->getNonceValue(),
                'font_url' => $this->fontResoucesUrl(),
                'msgConfirmDeleteCustomFont' => esc_html__('Are you sure delete custom font?','lustria-framework'),
                'msgConfirmRemoveActiveFont' => esc_html__('Are you sure remove this font?','lustria-framework'),
                'msgConfirmResetFont' => esc_html__('Are you sure reset active fonts?','lustria-framework'),
            ));
        }

        public function fontEnqueue() {
            if (is_admin()) {
                return;
            }
            $fonts = $this->getFontEnqueue();
            foreach ($fonts['urls'] as $key => $url) {
                wp_enqueue_style(GSF()->assetsHandle($key), $url);
            }
            $custom_css = $fonts['custom_css'];
            if (!empty($custom_css)) {
                foreach ($custom_css as $key => $value) {
                    GSF()->customCss()->addCss(sprintf('%s{font-family:%s!important;}', $value, $key));
                }
            }
        }

        public function editor_stylesheets($stylesheets) {
            if (get_theme_support( 'gsf_font_management' )) {
                $fonts = $this->getFontEnqueue();
                foreach ( $fonts['urls'] as $key => $url ) {
                    $stylesheets[] = $url;
                }
            }
            return $stylesheets;
        }

        public function block_editor_styles() {
            if (get_theme_support( 'gsf_font_management' )) {
                $fonts = $this->getFontEnqueue();
                $last_key = '';
                foreach ($fonts['urls'] as $key => $url) {
                    wp_enqueue_style(GSF()->assetsHandle($key), $url);
                    $last_key = $key;
                }
                $custom_css = $fonts['custom_css'];
                if (!empty($custom_css)) {
                    $css = '';
                    foreach ($custom_css as $key => $value) {
                        $css .= sprintf('.editor-styles-wrapper %s{font-family:\'%s\' !important;}', $value, $key);
                    }
                    wp_add_inline_style(GSF()->assetsHandle($last_key), $css);
                }
            }
        }

        public function getFontEnqueue() {
            $options = $this->getActiveFonts();
            $google_fonts = array();
            $subsets = array();
            $custom_css = array();
            $urls = array();
            foreach ($options as $font) {
                switch ($font['kind']) {
                    case 'webfonts#webfont': {
                        foreach ($font['variants'] as &$v) {
                            if ($v == 'italic') {
                                $v = '400italic';
                            }
                            $v = str_replace('italic', 'i', $v);
                        }
                        foreach ($font['subsets'] as $s) {
                            if (!in_array($s, $subsets)) {
                                $subsets[] = $s;
                            }
                        }
                        $google_fonts[] = sprintf('%s:%s', str_replace(' ', '+', $font['family']), join(',', $font['variants']));
                        break;
                    }
                    case 'custom': {
                        $urls['custom_font_' . $font['family']] = isset($font['css_url']) ? $font['css_url'] : $this->fontResoucesUrl() . $font['css_file'];
                    }
                }
                if (!empty($font['selector'])) {
                    $custom_css[$font['family']] = $font['selector'];
                }
            }
            if (!empty($google_fonts)) {
                $url = sprintf('https://fonts.googleapis.com/css?family=%s%s', join('|', $google_fonts),
                    !empty($subsets) ? '&amp;subset=' . join(',', $subsets) : '');
                $urls['google-fonts'] = $url;
            }
            return array(
                'urls' => $urls,
                'custom_css' => $custom_css
            );
        }

        public function getFontFamily($name) {
            if ((strpos($name, ',') === false) || (strpos($name, ' ') === false)) {
                return $name;
            }
            return "'{$name}'";
        }

        public function processFont($fonts) {
            if (isset($fonts['font_weight']) && (($fonts['font_weight'] === '') || ($fonts['font_weight'] === 'regular')) ) {
                $fonts['font_weight'] = '400';
            }

            if (isset($fonts['font_style']) && ($fonts['font_style'] === '') ) {
                $fonts['font_style'] = 'normal';
            }
            return $fonts;
        }

        public function binderPage()
        {
            GSF()->helper()->getTemplate('core/fonts/templates/fonts');
        }

        public function getActiveFontsKey() {
            return apply_filters('gsf_font_options', 'gsf_font_options');
        }

        public function getActiveFonts()
        {
            $fonts = get_option($this->getActiveFontsKey());
            if (!is_array($fonts)) {
                $fonts = apply_filters('gsf_theme_font_default', array());
                $standard_fonts = &$this->getStandardFontsSource();
                $google_fonts = &$this->getGoogleFontsSource();

                foreach ($fonts as $key => $font) {
                    switch ($font['kind']) {
                        case 'standard': {
                            foreach ($standard_fonts as $f) {
                                if ($f['family'] == $font['family']) {
                                    $fonts[$key] = $f;
                                    break;
                                }
                            }
                            break;
                        }
                        case 'webfonts#webfont': {
                            foreach ($google_fonts['items'] as $f) {
                                if ($f['family'] == $font['family']) {
                                    $fonts[$key] = $f;
                                    break;
                                }
                            }
                            break;
                        }
                    }

                    if (!isset($fonts[$key]['subsets']) || !is_array($fonts[$key]['subsets'])) {
                        $fonts[$key]['subsets'] = array();
                    }
                    if (!isset($fonts[$key]['variants']) || !is_array($fonts[$key]['variants'])) {
                        $fonts[$key]['variants'] = array();
                    }

                    $fonts[$key]['default_variants'] = $fonts[$key]['variants'];
                    $fonts[$key]['default_subsets'] = $fonts[$key]['subsets'];
                    $fonts[$key]['selector'] = '';
                }
            }

            return $fonts;
        }

        public function updateActiveFonts($fonts)
        {
            update_option($this->getActiveFontsKey(), $fonts);
        }

        public function getFontSources()
        {
            return array(
                'google'   => esc_html__('Google Fonts', 'lustria-framework'),
                'standard' => esc_html__('Standard Fonts', 'lustria-framework'),
                'custom'   => esc_html__('Custom Fonts', 'lustria-framework'),
            );
        }

        public function ajaxGetFontList()
        {
            $nonce = $_REQUEST['_nonce'];
            if (!wp_verify_nonce($nonce, GSF()->helper()->getNonceVerifyKey())) {
                wp_send_json_error('Access deny!');
                die();
            }

            $font_type = $_REQUEST['font_type'];
            $data = array(
                'font_type' => $font_type
            );
            switch ($font_type) {
                case 'google': {
                    $data['fonts'] = $this->getGoogleFonts();
                    break;
                }
                case 'standard': {
                    $data['fonts'] = array();
                    $data['fonts']['items'] = $this->getStandardFonts();
                    break;
                }
                case 'custom': {
                    $data['fonts'] = array();
                    $data['fonts']['items'] = $this->getCustomFonts();
                    break;
                }
                case 'active': {
                    $data['fonts']['items'] = $this->getActiveFonts();
                    break;
                }
            }

            wp_send_json_success($data);
            die();
        }

        public function fontResoucesDir() {
            $upload_dir = wp_upload_dir();
            return  $upload_dir['basedir'] . '/gsf-fonts/';
        }
        public function fontResoucesUrl() {
            $upload_dir = wp_upload_dir();
            return  $upload_dir['baseurl'] . '/gsf-fonts/';
        }

        public function fontsTemplates() {
            GSF()->helper()->getTemplate('core/fonts/templates/google.tpl');
            GSF()->helper()->getTemplate('core/fonts/templates/standard.tpl');
            GSF()->helper()->getTemplate('core/fonts/templates/custom.tpl');
            GSF()->helper()->getTemplate('core/fonts/templates/active.tpl');
        }

        private function isInActiveFont($fonts, $name) {
            foreach ($fonts as $font) {
                if ($font['family'] == $name) {
                    return true;
                }
            }
            return false;
        }

        private function &getGoogleFontsSource() {
            $fonts = json_decode(GSF()->file()->getContents(GSF()->pluginDir('assets/webfonts.json')), true);
            return $fonts;
        }
        private function getGoogleFonts()
        {
            $fonts = &$this->getGoogleFontsSource();
            $active_fonts = $this->getActiveFonts();
            $categories = array();
            foreach ($fonts['items'] as &$item) {
                if (isset($item['category'])) {
                    if (!isset($categories[$item['category']])) {
                        $categories[$item['category']] = array(
                            'name' => $item['category'],
                            'count' => 1
                        );
                    }
                    else {
                        $categories[$item['category']]['count']++;
                    }
                }
                foreach ($item['variants'] as &$v) {
                    if ($v == 'regular') {
                        $v = '400';
                    }
                }
                $item['using'] = $this->isInActiveFont($active_fonts, $item['family']);

            }
            $fonts['categories'] = array();
            foreach ($categories as $cate) {
                $fonts['categories'][] = $cate;
            }
            return $fonts;
        }

        private function &getStandardFontsSource() {
            $variants =  array(
                '100',
                '200',
                '300',
                '400',
                '500',
                '600',
                '700',
                '800',
                '900',
                '1000',
                '100italic' ,
                '200italic' ,
                '300italic' ,
                '400italic' ,
                '500italic' ,
                '600italic' ,
                '700italic' ,
                '800italic' ,
                '900italic' ,
                '1000italic',
            );
            $fonts = array(
                array(
                    'family' => "Arial, Helvetica, sans-serif",
                    'name' => "Arial, Helvetica, sans-serif",
                ),
                array(
                    'family' => "'Arial Black', Gadget, sans-serif",
                    'name' => "Arial Black, Gadget, sans-serif"
                ),
                array(
                    'family' => "'Bookman Old Style', serif",
                    'name' => "Bookman Old Style, serif"
                ),
                array(
                    'family' => "'Comic Sans MS', cursive",
                    'name' => "Comic Sans MS, cursive"
                ),
                array(
                    'family' => "Courier, monospace",
                    'name' => "Courier, monospace"
                ),
                array(
                    'family' => "Garamond, serif",
                    'name' => "Garamond, serif"
                ),
                array(
                    'family' => "Georgia, serif",
                    'name' => "Georgia, serif"
                ),
                array(
                    'family' => "Impact, Charcoal, sans-serif",
                    'name' => "Impact, Charcoal, sans-serif"
                ),
                array(
                    'family' => "'Lucida Console', Monaco, monospace" ,
                    'name' => "Lucida Console, Monaco, monospace"
                ),
                array(
                    'family' => "'Lucida Sans Unicode', 'Lucida Grande', sans-serif",
                    'name' => "Lucida Sans Unicode, Lucida Grande, sans-serif",
                ),
                array(
                    'family' => "'MS Sans Serif', Geneva, sans-serif",
                    'name' => "MS Sans Serif, Geneva, sans-serif"
                ),
                array(
                    'family' => "'MS Serif', 'New York', sans-serif",
                    'name' => "MS Serif, New York, sans-serif"
                ),
                array(
                    'family' => "'Palatino Linotype', 'Book Antiqua', Palatino, serif",
                    'name' => "Palatino Linotype, Book Antiqua, Palatino, serif"
                ),
                array(
                    'family' => "Tahoma,Geneva, sans-serif",
                    'name' => "Tahoma,Geneva, sans-serif"
                ),
                array(
                    'family' => "'Times New Roman', Times,serif",
                    'name' => "Times New Roman, Times,serif"
                ),
                array(
                    'family' => "'Trebuchet MS', Helvetica, sans-serif",
                    'name' => "Trebuchet MS, Helvetica, sans-serif"
                ),
                array(
                    'family' => "Verdana, Geneva, sans-serif" ,
                    'name' => "Verdana, Geneva, sans-serif"
                ),
            );
            foreach ($fonts as &$item) {
                $item['variants'] = $variants;
                $item['kind'] = 'standard';
            }

            return $fonts;
        }

        private function getStandardFonts()
        {
            $fonts = &$this->getStandardFontsSource();
            $active_fonts = $this->getActiveFonts();
            foreach ($fonts as &$item) {
                $item['using'] = $this->isInActiveFont($active_fonts, $item['family']);
            }

            return $fonts;
        }

        private function getCustomFonts()
        {
            $custom_fonts = get_option('gsf_custom_fonts');
            if (is_array($custom_fonts)) {
                $active_fonts = $this->getActiveFonts();
                foreach ($custom_fonts as &$item) {
                    $item['using'] = $this->isInActiveFont($active_fonts, $item['family']);
                }
            }
            return $custom_fonts;
        }

        private function setCustomFonts($options) {
            update_option('gsf_custom_fonts', $options);
        }

        public function ajaxUploadFonts() {
            $nonce = $_REQUEST['_nonce'];
            if (!wp_verify_nonce($nonce, GSF()->helper()->getNonceVerifyKey())) {
                wp_send_json_error(esc_html__('Access deny!','lustria-framework'));
                die();
            }
            $name = $_POST['name'];
            $sanitize_name = sanitize_title($name);

            if (!file_exists($this->fontResoucesDir())) {
                GSF()->file()->mkdir($this->fontResoucesDir());
            }

            $target_file = $this->fontResoucesDir() . $_FILES['file_font']['name'];
            move_uploaded_file($_FILES['file_font']["tmp_name"], $target_file);



            // Extract
            $zip = new ZipArchive;
            $allow_extract = array();
            $css_file = '';
            $css_count = 0;
            $font_dir = '';
            $create_font_dir = false;
            if (file_exists($target_file) && ($fp = $zip->open($target_file))) {
                for ( $i=0; $i < $zip->numFiles; $i++ )
                {
                    $entry = $zip->getNameIndex($i);
                    if (preg_match('/__MACOSX/', $entry)) {
                        continue;
                    }
                    if (preg_match('/((\.eot)|(\.svg)|(\.ttf)|(\.woff)|(\.woff2)|(\.css))$/', $entry)) {
                        $allow_extract[] = $entry;
                    }
                    if (preg_match('/(\.css)$/', $entry)) {
                        $css_file = $entry;
                        $css_count+= 1;
                    }
                    $entry_exp = preg_split('/[\/\\\\]/', $entry);
                    if (count($entry_exp) == 1) {
                        $create_font_dir = true;
                    }
                    else {
                        $font_dir = $entry_exp[0];
                    }
                }

                if ($css_count === 1) {
                    if ($create_font_dir) {
                        if (@file_exists($this->fontResoucesDir() . $sanitize_name)) {
                            wp_send_json_error(esc_html__('Font Exist!','lustria-framework'));
                            $zip->close();
                            unlink($target_file);
                            die();
                        }
                        GSF()->file()->mkdir($this->fontResoucesDir() . $sanitize_name);
                        $zip->extractTo($this->fontResoucesDir() . $sanitize_name, $allow_extract);
                    }
                    else {
                        if (@file_exists($this->fontResoucesDir() . $font_dir)) {
                            wp_send_json_error(esc_html__('Font Exist!','lustria-framework'));
                            $zip->close();
                            unlink($target_file);
                            die();
                        }
                        $zip->extractTo($this->fontResoucesDir(), $allow_extract);
                    }
                }
                $zip->close();
            }
            if (file_exists($target_file)) {
                unlink($target_file);
            }

            $variants = array();
            $font_family = '';
            if ($css_count === 1) {
                $css_file = $create_font_dir ? $sanitize_name . '/' . $css_file : $css_file;

                $css_content = GSF()->file()->getContents($this->fontResoucesDir() . $css_file);

                $count = preg_match_all('/@font-face\s*\{([^\{]*(?=\}))\}/', $css_content, $matches);
                if (!$count) {
                    wp_send_json_error(esc_html__('Missing css file!','lustria-framework'));
                    die();
                }

                foreach ($matches[1] as $css_attrs) {
                    if (preg_match('/(?<=font\-family)(\s*:\s*)([^;]*)/', $css_attrs, $matches_attr)) {
                        $font_family = trim(strtolower($matches_attr[2]));
                        $font_family = preg_replace("/'(.*)'/", '$1', $font_family);
                        $font_family = preg_replace('/"(.*)"/', '$1', $font_family);
                    }


                    $variant_style =  $variant_weight = '';
                    if (preg_match('/(?<=font\-style)(\s*:\s*)([^;]*)/', $css_attrs, $matches_attr)) {
                        $variant_style = trim(strtolower($matches_attr[2]));
                    }
                    if (preg_match('/(?<=font\-weight)(\s*:\s*)([^;]*)/', $css_attrs, $matches_attr)) {
                        $variant_weight = trim(strtolower($matches_attr[2]));
                    }
                    if ($variant_style != 'italic') {
                        $variant_style = '';
                    }
                    if ($variant_weight == 'normal') {
                        $variant_weight = '400';
                    }
                    if (!in_array($variant_weight, array('100', '200', '300', '400', '500', '600', '700', '800', '900', '1000'))) {
                        $variant_weight = '400';
                    }
                    if (!in_array($variant_weight . $variant_style, $variants)) {
                        $variants[] = $variant_weight . $variant_style;
                    }
                }

                $option_fonts = $this->getCustomFonts();
                $data = array(
                    'kind' => 'custom',
                    'font_dir' => $create_font_dir ? $sanitize_name : $font_dir,
                    'css_file' => $css_file,
                    'name' => $name,
                    'family' => $font_family,
                    'variants' => $variants,
                );
                $option_fonts[] = $data;
                $this->setCustomFonts($option_fonts);

                wp_send_json_success($data);
            }
            else {
                wp_send_json_error(esc_html__('Only allowed with 1 css file!','lustria-framework'));
            }
            die();
        }

        public function ajaxDeleteCustomFont() {
            $nonce = $_REQUEST['_nonce'];
            if (!wp_verify_nonce($nonce, GSF()->helper()->getNonceVerifyKey())) {
                wp_send_json_error(esc_html__('Access deny!','lustria-framework'));
                die();
            }
            $family_name = $_POST['family_name'];
            $family_name = wp_unslash($family_name);

            $option_fonts = $this->getCustomFonts();
            $data_delete = array();
            foreach ($option_fonts as $key => $font) {
                if ($font['family'] == $family_name) {
                    if (GSF()->file()->delete($this->fontResoucesDir() . $font['font_dir'], true, 'd')) {
                        $data_delete = $option_fonts[$key];
                        unset($option_fonts[$key]);
                        $this->setCustomFonts($option_fonts);
                        wp_send_json_success($data_delete);
                        die();
                    }
                    wp_send_json_error(esc_html__('Font directory is not deleted','lustria-framework'));
                    die();
                }
            }
            wp_send_json_success(esc_html__('Delete custom font done!','lustria-framework'));
            die();
        }

        public function ajaxResetActiveFont() {
            $nonce = $_REQUEST['_nonce'];
            if (!wp_verify_nonce($nonce, GSF()->helper()->getNonceVerifyKey())) {
                wp_send_json_error(esc_html__('Access deny!','lustria-framework'));
                die();
            }

            delete_option($this->getActiveFontsKey());
            wp_send_json_success(esc_html__('Delete custom font done!','lustria-framework'));
            die();
        }

        public function ajaxUsingFont() {
            $nonce = $_REQUEST['_nonce'];
            if (!wp_verify_nonce($nonce, GSF()->helper()->getNonceVerifyKey())) {
                wp_send_json_error(esc_html__('Access deny!','lustria-framework'));
                die();
            }

            $font_data = $_POST['font_data'];
            $font_data['family'] = wp_unslash($font_data['family']);

            $options = $this->getActiveFonts();
            foreach ($options as $font) {
                if ($font['family'] == $font_data['family']) {
                    wp_send_json_error(esc_html__('Fonts already exists!','lustria-framework'));
                    die();
                }
            }

            if (!isset($font_data['subsets']) || !is_array($font_data['subsets'])) {
                $font_data['subsets'] = array();
            }
            if (!isset($font_data['variants']) || !is_array($font_data['variants'])) {
                $font_data['variants'] = array();
            }

            $font_data['default_variants'] = $font_data['variants'];
            $font_data['default_subsets'] = $font_data['subsets'];
            $font_data['selector'] = '';
            $options[] = $font_data;

            $this->updateActiveFonts($options);
            wp_send_json_success($font_data);
            die();
        }

        public function ajaxRemoveActiveFont() {
            $nonce = $_REQUEST['_nonce'];
            if (!wp_verify_nonce($nonce, GSF()->helper()->getNonceVerifyKey())) {
                wp_send_json_error(esc_html__('Access deny!','lustria-framework'));
                die();
            }

            $family_name = $_POST['family_name'];
            $family_name = wp_unslash($family_name);
            $options = $this->getActiveFonts();
            $font_data = null;
            foreach ($options as $key => $value) {
                if ($value['family'] == $family_name) {
                    $font_data = $options[$key];
                    unset($options[$key]);
                    break;
                }
            }
            $this->updateActiveFonts($options);
            wp_send_json_success($font_data);
            die();
        }
        public function ajaxSaveActiveFont() {
            $nonce = $_REQUEST['_nonce'];
            if (!wp_verify_nonce($nonce, GSF()->helper()->getNonceVerifyKey())) {
                wp_send_json_error(esc_html__('Access deny!','lustria-framework'));
                die();
            }

            $options = $this->getActiveFonts();

            $fonts = $_POST['font'];
            if (!array($fonts)) {
                $fonts = array();
            }
            foreach ($fonts as $key => $font) {
                if (!isset($options[$key])) {
                    continue;
                }
                switch ($font['kind']) {
                    case 'webfonts#webfont': {
                        $options[$key]['variants'] = $font['variants'];
                        $options[$key]['subsets'] = $font['subsets'];
                        $options[$key]['selector'] = $font['selector'];
                        break;
                    }
                    case 'standard':
                    case 'custom': {
                        $options[$key]['selector'] = $font['selector'];
                        break;
                    }
                }
            }
            $this->updateActiveFonts($options);
            wp_send_json_success(esc_html__('Save Done!','lustria-framework'));
            die();
        }
    }
}