<?php
if (!class_exists('XMenuWalker')) {
	class XMenuWalker extends Walker_Nav_Menu
	{
		/**
		 * What the class handles.
		 *
		 * @since 3.0.0
		 * @access public
		 * @var string
		 *
		 * @see Walker::$tree_type
		 */
		public $tree_type = array('post_type', 'taxonomy', 'custom');

		private $_parent_menu_id;

		/**
		 * Database fields to use.
		 *
		 * @since 3.0.0
		 * @access public
		 * @todo Decouple this.
		 * @var array
		 *
		 * @see Walker::$db_fields
		 */
		public $db_fields = array('parent' => 'menu_item_parent', 'id' => 'db_id');

		/**
		 * Starts the list before the elements are added.
		 *
		 * @param string $output Passed by reference. Used to append additional content.
		 * @param int $depth Depth of menu item. Used for padding.
		 * @param array $args An array of wp_nav_menu() arguments.
		 * @see Walker::start_lvl()
		 *
		 * @since 3.0.0
		 *
		 */
		public function start_lvl(&$output, $depth = 0, $args = array())
		{
			$sub_menu_class = array('sub-menu');
			$sub_menu_style = array();


			$transition = apply_filters('xmenu_submenu_transition', '', $args);

			/**
			 * Get XMENU Meta
			 */
			$xmenu_meta = get_post_meta($this->_parent_menu_id, '_menu_item_xmenu_config', true);
			if ($xmenu_meta) {
				$xmenu_meta = json_decode($xmenu_meta, true);
				if (is_array($xmenu_meta)) {
					if (isset($xmenu_meta['menu-submenu-width'])) {
						if ($xmenu_meta['menu-submenu-width'] === 'custom') {
							$sub_menu_style[] = 'width:' . esc_attr($xmenu_meta['menu-submenu-custom-width']);
							$sub_menu_class[] = 'x-submenu-custom-width';
						}
					}

					if (isset($xmenu_meta['menu-submenu-transition']) && !empty($xmenu_meta['menu-submenu-transition'])) {
						$transition = esc_attr($xmenu_meta['menu-submenu-transition']);
					}
				}
			}

			if (!empty($transition)) {
				$sub_menu_class[] = 'x-animated';
				$sub_menu_class[] = $transition;
			}


			$sub_menu_class = apply_filters('xmenu_submenu_class', $sub_menu_class, $args);

			$indent = str_repeat("\t", $depth);
			$output .= sprintf("\n$indent<ul class=\"%s\" style=\"%s\">\n", join(' ', $sub_menu_class), join(';', $sub_menu_style));
		}

		/**
		 * Ends the list of after the elements are added.
		 *
		 * @param string $output Passed by reference. Used to append additional content.
		 * @param int $depth Depth of menu item. Used for padding.
		 * @param array $args An array of wp_nav_menu() arguments.
		 * @see Walker::end_lvl()
		 *
		 * @since 3.0.0
		 *
		 */
		public function end_lvl(&$output, $depth = 0, $args = array())
		{
			$indent = str_repeat("\t", $depth);
			$output .= "$indent</ul>\n";
		}

		/**
		 * Starts the element output.
		 *
		 * @param string $output Passed by reference. Used to append additional content.
		 * @param object $item Menu item data object.
		 * @param int $depth Depth of menu item. Used for padding.
		 * @param array $args An array of wp_nav_menu() arguments.
		 * @param int $id Current item ID.
		 * @see Walker::start_el()
		 *
		 * @since 3.0.0
		 * @since 4.4.0 The {@see 'nav_menu_item_args'} filter was added.
		 *
		 */
		public function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
		{
			$xmenu_meta = get_post_meta($item->ID, '_menu_item_xmenu_config', true);
			if ($xmenu_meta) {
				$xmenu_meta = json_decode($xmenu_meta, true);
			}

			$this->_parent_menu_id = $item->ID;

			$indent = ($depth) ? str_repeat("\t", $depth) : '';

			$classes = empty($item->classes) ? array() : (array)$item->classes;
			$classes[] = 'menu-item-' . $item->ID;

			if (is_array($xmenu_meta)) {
				if (isset($xmenu_meta['menu-submenu-position'])) {
					if (empty($xmenu_meta['menu-submenu-position'])) {
						$data_position = apply_filters('xmenu_submenu_position', '');
					} else {
						$data_position = esc_attr($xmenu_meta['menu-submenu-position']);
					}
					$classes[] = 'x-submenu-position-' . $data_position;
				}

				if (isset($xmenu_meta['menu-submenu-width']) && ($xmenu_meta['menu-submenu-width'] !== 'custom')) {
					$classes[] = 'x-submenu-width-' . esc_attr($xmenu_meta['menu-submenu-width']);
				}
			}

			if (($depth > 0) && ($item->object === 'xmenu_mega')) {
				$classes[] = 'x-is-mega-menu';
			}

			/**
			 * Filters the arguments for a single nav menu item.
			 *
			 * @param array $args An array of arguments.
			 * @param object $item Menu item data object.
			 * @param int $depth Depth of menu item. Used for padding.
			 * @since 4.4.0
			 *
			 */
			$args = apply_filters('nav_menu_item_args', $args, $item, $depth);

			/**
			 * Filters the CSS class(es) applied to a menu item's list item element.
			 *
			 * @param array $classes The CSS classes that are applied to the menu item's `<li>` element.
			 * @param object $item The current menu item.
			 * @param array $args An array of wp_nav_menu() arguments.
			 * @param int $depth Depth of menu item. Used for padding.
			 * @since 3.0.0
			 * @since 4.1.0 The `$depth` parameter was added.
			 *
			 */
			$class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args, $depth));
			$class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

			/**
			 * Filters the ID applied to a menu item's list item element.
			 *
			 * @param string $menu_id The ID that is applied to the menu item's `<li>` element.
			 * @param object $item The current menu item.
			 * @param array $args An array of wp_nav_menu() arguments.
			 * @param int $depth Depth of menu item. Used for padding.
			 * @since 3.0.1
			 * @since 4.1.0 The `$depth` parameter was added.
			 *
			 */
			$id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth);
			$id = $id ? ' id="' . esc_attr($id) . '"' : '';

			$data_transition = apply_filters('xmenu_submenu_transition', '', $args);

			if (is_array($xmenu_meta)) {
				if (isset($xmenu_meta['menu-submenu-transition']) && !empty($xmenu_meta['menu-submenu-transition'])) {
					$data_transition = esc_attr($xmenu_meta['menu-submenu-transition']);
				}
			}
			$data_transition = $data_transition ? ' data-transition="' . esc_attr($data_transition) . '"' : '';

			$output .= $indent . '<li' . $id . $class_names . $data_transition . '>';

			$atts = array();
			$atts['title'] = !empty($item->attr_title) ? $item->attr_title : '';
			$atts['target'] = !empty($item->target) ? $item->target : '';
			$atts['rel'] = !empty($item->xfn) ? $item->xfn : '';
			$atts['href'] = !empty($item->url) ? $item->url : '';


			/**
			 * Filters the HTML attributes applied to a menu item's anchor element.
			 *
			 * @param array $atts {
			 *     The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
			 *
			 * @type string $title Title attribute.
			 * @type string $target Target attribute.
			 * @type string $rel The rel attribute.
			 * @type string $href The href attribute.
			 * }
			 * @param object $item The current menu item.
			 * @param array $args An array of wp_nav_menu() arguments.
			 * @param int $depth Depth of menu item. Used for padding.
			 * @since 3.6.0
			 * @since 4.1.0 The `$depth` parameter was added.
			 *
			 */
			$atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args, $depth);

			$attributes = '';
			foreach ($atts as $attr => $value) {
				if (!empty($value)) {
					$value = ('href' === $attr) ? esc_url($value) : esc_attr($value);
					$attributes .= ' ' . $attr . '="' . $value . '"';
				}
			}

			/** This filter is documented in wp-includes/post-template.php */
			$title = apply_filters('the_title', $item->title, $item->ID);

			/**
			 * Filters a menu item's title.
			 *
			 * @param string $title The menu item's title.
			 * @param object $item The current menu item.
			 * @param array $args An array of wp_nav_menu() arguments.
			 * @param int $depth Depth of menu item. Used for padding.
			 * @since 4.4.0
			 *
			 */
			$title = apply_filters('nav_menu_item_title', $title, $item, $args, $depth);

			/**
			 * If Menu Item is Mega Menu
			 */

			if (($depth > 0) && ($item->object === G5P()->cpt()->get_xmenu_post_type())) {
				$object_id = $item->object_id;
				$content = G5P()->helper()->content_block($object_id, G5P()->cpt()->get_xmenu_post_type());
				$output .= '<div class="x-mega-sub-menu">';
				$output .= $content;
				$output .= '</div>';
			} else {
				$item_output = $args->before;
				$item_output .= '<a class="x-menu-link" ' . $attributes . '>';

				/**
				 * Menu Icon
				 */
				if (is_array($xmenu_meta)) {
					if (isset($xmenu_meta['menu-item-icon']) && !empty($xmenu_meta['menu-item-icon'])) {
						$item_output .= '<i class="x-icon ' . esc_attr($xmenu_meta['menu-item-icon']) . '"></i> ';
					}
				}


				$item_output .= $args->link_before . "<span class='x-menu-link-text'>$title</span>" . $args->link_after;


				if (is_array($xmenu_meta)) {
					if (isset($xmenu_meta['menu-item-featured-style']) && ($xmenu_meta['menu-item-featured-style'] != '')) {
						$menu_featured_text = '';

						switch ($xmenu_meta['menu-item-featured-style']) {
							case 'hot':
							{
								$menu_featured_text = esc_html__('Hot', 'lustria-framework');
								break;
							}
							case 'new':
							{
								$menu_featured_text = esc_html__('New', 'lustria-framework');
								break;
							}
							default:
							{
								$menu_featured_text = esc_html__('Featured', 'lustria-framework');
							}
						}

						if (isset($xmenu_meta['menu-item-featured-text']) && ($xmenu_meta['menu-item-featured-text'] != '')) {
							$menu_featured_text = $xmenu_meta['menu-item-featured-text'];
						}

						$item_output .= sprintf('<span class="x-menu-link-featured x-menu-link-featured-%s">%s</span>',
							esc_attr($xmenu_meta['menu-item-featured-style']),
							esc_html($menu_featured_text));
					}
				}
				$item_output .= '</a>';

				/**
				 * Menu Description
				 */
				if (!empty($item->description)) {
					$item_output .= '<p class="x-description">' . wp_kses_post($item->description) . '</p>';
				}

				$item_output .= $args->after;

				/**
				 * Filters a menu item's starting output.
				 *
				 * The menu item's starting output only includes `$args->before`, the opening `<a>`,
				 * the menu item's title, the closing `</a>`, and `$args->after`. Currently, there is
				 * no filter for modifying the opening and closing `<li>` for a menu item.
				 *
				 * @param string $item_output The menu item's starting HTML output.
				 * @param object $item Menu item data object.
				 * @param int $depth Depth of menu item. Used for padding.
				 * @param array $args An array of wp_nav_menu() arguments.
				 * @since 3.0.0
				 *
				 */
				$output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
			}
		}

		/**
		 * Ends the element output, if needed.
		 *
		 * @param string $output Passed by reference. Used to append additional content.
		 * @param object $item Page data object. Not used.
		 * @param int $depth Depth of page. Not Used.
		 * @param array $args An array of wp_nav_menu() arguments.
		 * @since 3.0.0
		 *
		 * @see Walker::end_el()
		 *
		 */
		public function end_el(&$output, $item, $depth = 0, $args = array())
		{
			$output .= "</li>\n";
		}
	}
}