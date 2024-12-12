<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Typography;

class UBE_Element_Breadcrumbs extends UBE_Abstracts_Elements {
	public function get_name() {
		return 'ube-breadcrumbs';
	}

	public function get_title() {
		return esc_html__( 'Breadcrumbs', 'ube' );
	}

	public function get_ube_icon() {
		return 'eicon-product-breadcrumbs';
	}

	public function get_ube_keywords() {
		return array( 'breadcrumbs' , 'ube' , 'ube breadcrumbs');
	}

	protected function register_controls() {
		$this->register_section_content();
		$this->register_section_breadcrumbs();
		$this->register_section_separator();
		$this->register_section_icon();
	}

	private function register_section_content() {

		$this->start_controls_section( 'breadcrumb_settings_section', [
			'label' => esc_html__( 'Breadcrumbs', 'ube' ),
		] );

		$this->add_control(
			'breadcrumb_scheme',
			[
				'label'   => esc_html__( 'Text Color', 'ube' ),
				'type'    => Controls_Manager::SELECT,
				'options' => ube_get_color_schemes(),
				'default' => '',
			]
		);


		$this->add_control(
			'breadcrumb_scheme_link',
			[
				'label'   => esc_html__( 'Link Color', 'ube' ),
				'type'    => Controls_Manager::SELECT,
				'options' => ube_get_color_schemes(),
				'default' => '',
			]
		);


		$this->add_responsive_control(
			'breadcrumb_align',
			[
				'label'        => esc_html__( 'Alignment', 'ube' ),
				'type'         => Controls_Manager::CHOOSE,
				'options'      => [
					'left'   => [
						'title' => esc_html__( 'Left', 'ube' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'ube' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right'  => [
						'title' => esc_html__( 'Right', 'ube' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'prefix_class' => 'elementor%s-align-',
				'default'      => '',
			]
		);

		$this->add_control(
			'breadcrumb_separator_type',
			[
				'label'   => esc_html__( 'Separator Type', 'ube' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					''                       => esc_html__( 'Default', 'ube' ),
					'separator-angle-double' => esc_html__( 'Angle Double', 'ube' ),
					'separator-caret'        => esc_html__( 'Caret', 'ube' ),
					'separator-arrow'        => esc_html__( 'Arrow', 'ube' ),
					'separator-arrow-alt'    => esc_html__( 'Arrow Alt', 'ube' ),
					'separator-dot'          => esc_html__( 'Dot', 'ube' ),
					'separator-square'       => esc_html__( 'Square', 'ube' ),
				],
			]
		);

		$this->add_control(
			'breadcrumb_switcher_label',
			[
				'label'        => esc_html__( 'Use Title Home', 'ube' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'ube' ),
				'label_off'    => esc_html__( 'Hide', 'ube' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'breadcrumb_label',
			[
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'label_block' => true,
				'default'     => esc_html__( 'Home', 'ube' ),
				'placeholder' => esc_html__( 'Home', 'ube' ),
				'condition'   => [
					'breadcrumb_switcher_label' => 'yes',
				],
			]
		);

		$this->add_control(
			'breadcrumb_switcher_archive',
			[
				'label'        => esc_html__( 'Show Archives', 'ube' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'ube' ),
				'label_off'    => esc_html__( 'Hide', 'ube' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'breadcrumb_switcher_categories',
			[
				'label'        => esc_html__( 'Show Categories', 'ube' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'ube' ),
				'label_off'    => esc_html__( 'Hide', 'ube' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'breadcrumb_switcher_icon',
			[
				'label'        => esc_html__( 'Use Icon', 'ube' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'ube' ),
				'label_off'    => esc_html__( 'Hide', 'ube' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);

		$this->add_control(
			'breadcrumb_icon',
			[
				'label'     => esc_html__( 'Icon', 'ube' ),
				'type'      => Controls_Manager::ICONS,
				'condition' => [
					'breadcrumb_switcher_icon' => 'yes',
				],
			]
		);

		$this->end_controls_section();

	}

	private function register_section_breadcrumbs() {


		$this->start_controls_section(
			'section_breadcrumb_style',
			[
				'label' => esc_html__( 'Breadcrumbs', 'ube' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'typography',
				'selector' => '{{WRAPPER}} .breadcrumb-item',
			]
		);

		$this->add_control(
			'breadcrumb_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .breadcrumb-item.active' => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_breadcrumb_style' );

		$this->start_controls_tab(
			'tab_breadcrumb_normal',
			[
				'label' => esc_html__( 'Normal', 'ube' ),
			]
		);

		$this->add_control(
			'breadcrumb_color_link',
			[
				'label'     => esc_html__( 'Link Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .breadcrumb-item a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_breadcrumb_hover',
			[
				'label' => esc_html__( 'Hover', 'ube' ),
			]
		);

		$this->add_control(
			'breadcrumb_color_link_hover',
			[
				'label'     => esc_html__( 'Link Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .breadcrumb-item a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();


		$this->end_controls_section();
	}

	private function register_section_separator() {

		$this->start_controls_section(
			'section_breadcrumb_separator',
			[
				'label' => esc_html__( 'Separator', 'ube' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'breadcrumb_separator_spacing',
			[
				'label'     => esc_html__( 'Spacing', 'ube' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .breadcrumb-item + .breadcrumb-item'         => 'padding-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .breadcrumb-item + .breadcrumb-item::before' => 'padding-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'breadcrumb_color_separator',
			[
				'label'     => esc_html__( 'Text Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .breadcrumb-item + .breadcrumb-item::before' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	private function register_section_icon() {

		$this->start_controls_section(
			'section_breadcrumb_icon',
			[
				'label'     => esc_html__( 'Icon', 'ube' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'breadcrumb_switcher_icon' => 'yes',
				],
			]
		);

		$this->add_control(
			'breadcrumb_size_icon',
			[
				'label'     => esc_html__( 'Font Size', 'ube' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .breadcrumb-icon' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'breadcrumb_switcher_icon' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'breadcrumb_icon_spacing',
			[
				'label'     => esc_html__( 'Spacing', 'ube' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .breadcrumb-icon' => 'padding-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'breadcrumb_color_icon',
			[
				'label'     => esc_html__( 'Text Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .breadcrumb-icon' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

	}

	public function render() {
		ube_get_template( 'elements/breadcrumbs.php', array(
			'element' => $this
		) );
	}

	public function ube_the_breadcrumbs() {

		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( 'breadcrumbs', 'class', array(
			'ube-breadcrumbs',
			'breadcrumbs',
			'list-unstyled',
			'd-inline-flex',
			'flex-wrap',
			'align-items-center',
			'm-0',
			$settings['breadcrumb_separator_type'],
		) );

		$html_markup = '';
		// Add home link
		$html_markup .= $this->ube_get_breadcrumb_home();

		// Woocommerce path prefix
		if ( class_exists( 'WooCommerce' ) && ( ( is_woocommerce() && is_archive() && ! is_shop() ) || is_cart() || is_checkout() || is_account_page() ) ) {
			$html_markup .= $this->ube_get_woocommerce_shop_page();
		}

		if ( is_singular() ) {
			$post = get_post( get_queried_object_id() );
			// display archive link for post type

			if ( isset( $post->post_type ) && get_post_type_archive_link( $post->post_type ) ) {
				$html_markup .= $this->ube_get_post_type_archive();
			}

			// If the post doesn't have parents.
			if ( isset( $post->post_parent ) && ( $post->post_parent === 0 ) && $settings['breadcrumb_switcher_categories'] === 'yes' ) {
				$html_markup .= $this->ube_get_post_terms( $settings );
			}

			$html_markup .= $this->ube_get_breadcrumb_leaf_markup();
		} else {
			// Blog page is a dedicated page.
			if ( is_home() && ! is_front_page() ) {
				$posts_page       = get_option( 'page_for_posts' );
				$posts_page_title = get_the_title( $posts_page );
				$html_markup      .= $this->ube_get_single_breadcrumb_markup( $posts_page_title );
			}

			// Custom post types archives.
			if ( is_post_type_archive() ) {

				$html_markup .= $this->ube_get_post_type_archive( false );

				// Search on custom post type (e.g. Woocommerce).
				if ( is_search() ) {
					$html_markup .= $this->ube_get_breadcrumb_leaf_markup( 'search' );
				}
			} // Taxonomy Archives.
			elseif ( is_tax() || is_tag() || is_category() ) {
				if ( is_tag() ) { // If we have a tag archive, add the tag prefix.
					$html_markup .= esc_html__( 'Tag:', 'ube' );
				}
				$html_markup .= $this->ube_get_taxonomies();

				$html_markup .= $this->ube_get_breadcrumb_leaf_markup( 'term' );
			} // Date Archives.
			elseif ( is_date() ) {
				global $wp_locale;
				// Set variables.
				$year = get_the_date( 'Y' );
				// Year Archive, only is a leaf.
				if ( is_year() ) {
					$html_markup .= $this->ube_get_breadcrumb_leaf_markup( 'year' );
				} // Month Archive, needs year link and month leaf.
				elseif ( is_month() ) {
					$html_markup .= $this->ube_get_single_breadcrumb_markup( $year, get_year_link( $year ) );
					$html_markup .= $this->ube_get_breadcrumb_leaf_markup( 'month' );
				} // Day Archive, needs year and month link and day leaf.
				elseif ( is_day() ) {
					$month       = get_the_date( 'm' );
					$month_name  = $wp_locale->get_month( $month );
					$html_markup .= $this->ube_get_single_breadcrumb_markup( $year, get_year_link( $year ) );
					$html_markup .= $this->ube_get_single_breadcrumb_markup( $month_name, get_month_link( $year, $month ) );
					$html_markup .= $this->ube_get_single_breadcrumb_markup( 'day' );
				}
			} // Author Archives.
			elseif ( is_author() ) {
				$html_markup .= $this->ube_get_breadcrumb_leaf_markup( 'author' );
			} // Search Page.
			elseif ( is_search() ) {
				$html_markup .= $this->ube_get_breadcrumb_leaf_markup( 'search' );
			} // 404 Page.
			elseif ( is_404() ) {
				$html_markup .= $this->ube_get_breadcrumb_leaf_markup( '404' );
			}
		}
		if ( $html_markup ) {
			$html_markup = '<ol ' . $this->get_render_attribute_string( 'breadcrumbs' ) . '>' . $html_markup . '</ol>';
		}

		echo wp_kses_post( $html_markup );
	}

	private function ube_get_single_breadcrumb_markup( $title, $link = '', $micro_data = true ) {
		$settings             = $this->get_settings_for_display();
		$breadcrumb_item_link = '';

		if ( ! empty( $settings['breadcrumb_scheme_link'] ) ) {
			$breadcrumb_item_link = "text-{$settings['breadcrumb_scheme_link']}";
		}

		$micro_data_url = '';
		if ( $micro_data ) {
			$micro_data_url = 'itemprop="url"';
		}

		$breadcrumb_content = $title;
		if ( $link ) {
			$breadcrumb_content = '<a ' . $micro_data_url . ' href="' . esc_url( $link ) . '">' . esc_html( $breadcrumb_content ) . '</a>';
		}
		$output = '<li class="breadcrumb-item ' . esc_attr( $breadcrumb_item_link ) . '">' . $breadcrumb_content . '</li>';

		return $output;
	}

	private function ube_get_breadcrumb_home() {

		$settings = $this->get_settings_for_display();

		if ( $settings['breadcrumb_switcher_label'] === 'yes' ) {
			if ( ! is_front_page() ) {

				if ( ! empty( $settings['breadcrumb_label'] ) ) {
					$output = $this->ube_get_single_breadcrumb_markup( $settings['breadcrumb_label'], get_home_url( '/' ) );
				} else {
					$output = $this->ube_get_single_breadcrumb_markup( esc_html__( 'Home', 'ube' ), get_home_url( '/' ) );;
				}

			} else {
				$output = $this->ube_get_single_breadcrumb_markup( esc_html__( 'Blog', 'ube' ) );
			}

			return $output;
		}


	}

	private function ube_get_woocommerce_shop_page( $linked = true ) {

		$settings = $this->get_settings_for_display();

		$post_type        = 'product';
		$post_type_object = get_post_type_object( $post_type );
		$shop_page_markup = '';
		$link             = '';
		if ( isset( $post_type_object ) && class_exists( 'WooCommerce' ) && ( is_woocommerce() || is_cart() || is_checkout() || is_account_page() ) ) {
			// Get shop page id and then its name.
			$shop_page_name = wc_get_page_id( 'shop' ) ? get_the_title( wc_get_page_id( 'shop' ) ) : '';

			// Use the archive name if no shop page was set.
			if ( ! $shop_page_name ) {
				$shop_page_name = $post_type_object->labels->name;
			}

			// Check if the breadcrumb should be linked.
			if ( $linked ) {
				$link = get_post_type_archive_link( $post_type );
			}
			if ( $settings['breadcrumb_switcher_archive'] === 'yes' ) {
				$shop_page_markup = $this->ube_get_single_breadcrumb_markup( $shop_page_name, $link );
			} else {
				$shop_page_markup = '';
			}
		}

		return $shop_page_markup;
	}

	private function ube_get_post_type_archive( $linked = true ) {

		$settings = $this->get_settings_for_display();

		$post      = get_post( get_queried_object_id() );
		$post_type = isset( $post->post_type ) ? $post->post_type : '';

		if ( ! $post_type ) {
			$post_type = get_post_type();
		}

		$post_type_object = get_post_type_object( $post_type );
		if ( ! is_object( $post_type_object ) ) {
			return '';
		}

		// Woocommerce
		if ( ( $post_type === 'product' ) && class_exists( 'WooCommerce' ) ) {
			$woocommerce_shop_page = $this->ube_get_woocommerce_shop_page( $linked );

			return $woocommerce_shop_page;
		}

		$archive_title = $post_type_object->name;
		if ( isset( $post_type_object->label ) && ! empty( $post_type_object->label ) ) {
			$archive_title = $post_type_object->label;
		} elseif ( isset( $post_type_object->labels->menu_name ) && ! empty( $post_type_object->labels->menu_name ) ) {
			$archive_title = $post_type_object->labels->menu_name;
		}

		$link = '';
		if ( $linked ) {
			$link = get_post_type_archive_link( $post_type );
		}
		if ( $post_type === 'post' ) {
			$archive_title = esc_html__( 'Blog', 'ube' );
		}

		if ( $settings['breadcrumb_switcher_archive'] === 'yes' ) {
			$output = $this->ube_get_single_breadcrumb_markup( $archive_title, $link );
		} else {
			$output = '';
		}

		return $output;
	}

	private function ube_get_breadcrumb_leaf_markup( $object_type = '' ) {

		$settings           = $this->get_settings_for_display();
		$breadcrumb_classes = array(
			'breadcrumb-item',
			'active'
		);

		if ( $settings['breadcrumb_scheme'] !== '' ) {
			$breadcrumb_classes[] = "text-{$settings['breadcrumb_scheme']}";
		}
		$this->add_render_attribute( 'breadcrumb_item', 'class', $breadcrumb_classes );

		global $wp_query, $wp_locale;
		$post = get_post( get_queried_object_id() );
		switch ( $object_type ) {
			case 'term':
				$term  = $wp_query->get_queried_object();
				$title = $term->name;
				break;
			case 'year':
				$title = esc_html( get_the_date( 'Y' ) );
				break;
			case 'month':
				$title = $wp_locale->get_month( get_the_date( 'm' ) );
				break;
			case 'day':
				$title = get_the_date( 'd' );
				break;
			case 'author':
				$user  = $wp_query->get_queried_object();
				$title = $user->display_name;
				break;
			case 'search':
				$title = esc_html__( 'Search:', 'ube' ) . ' ' . esc_html( get_search_query() );
				break;
			case '404':
				$title = esc_html__( 'Page Not Found', 'ube' );
				break;
			default:
				$title = get_the_title( $post->ID );
				break;
		}

		return '<li ' . $this->get_render_attribute_string( 'breadcrumb_item' ) . '>' . esc_html( $title ) . '</li>';
	}

	private function ube_get_post_terms( $settings ) {
		$terms_markup = $show_terms = '';
		$post         = get_post( get_queried_object_id() );


		if ( $post->post_type === 'post' ) {
			$taxonomy = 'category';
		} else {
			$taxonomy = $post->post_type . '_cat';
		}
		if ( empty( $taxonomy ) ) {
			return $terms_markup;
		}

		$terms = wp_get_object_terms( $post->ID, $taxonomy );

		if ( empty( $terms ) || is_wp_error( $terms ) ) {
			return $terms_markup;
		}

		$terms_by_id = array();
		foreach ( $terms as $term ) {
			$terms_by_id[ $term->term_id ] = $term;
		}

		// Unset all terms that are parents of some term.
		foreach ( $terms as $term ) {
			unset( $terms_by_id[ $term->parent ] );
		}

		// If only one term is left, we have a single term tree.
		if ( count( $terms_by_id ) == 1 ) {
			unset( $terms );
			$terms[0] = array_shift( $terms_by_id );
		}

		// The post is only in one term.
		if ( count( $terms ) == 1 ) {
			$term_parent = $terms[0]->parent;

			// If the term has a parent we need its ancestors for a full tree.
			if ( $term_parent ) {
				// Get space separated string of term tree in slugs.
				$term_tree   = get_ancestors( $terms[0]->term_id, $taxonomy );
				$term_tree   = array_reverse( $term_tree );
				$term_tree[] = get_term( $terms[0]->term_id, $taxonomy );

				// Loop through the term tree.
				foreach ( $term_tree as $term_id ) {
					// Get the term object by its slug.
					$term_object = get_term( $term_id, $taxonomy );

					// Add it to the term breadcrumb markup string.
					$terms_markup .= $this->ube_get_single_breadcrumb_markup( $term_object->name, get_term_link( $term_object ) );
				}
			} else {
				$terms_markup = $this->ube_get_single_breadcrumb_markup( $terms[0]->name, get_term_link( $terms[0] ) );
			}
		} // the post has multiple terms
		else {
			$breadcrumb_item_link = '';

			if ( ! empty( $settings['breadcrumb_scheme_link'] ) ) {
				$breadcrumb_item_link = "text-{$settings['breadcrumb_scheme_link']}";
			}
			$terms_markup .= '<li class="breadcrumb-item ' . esc_attr( $breadcrumb_item_link ) . '">';
			$i      = 1;

			foreach ( $terms as $term ) {
				$breadcrumb_content = $term->name;
				if ( $i == count( $terms ) ) {
					$terms_markup .= '<a itemprop="url" href="' . esc_url( get_term_link( $term ) ) . '">' . esc_html( $breadcrumb_content ) . '</a>';
				} else {
					$terms_markup .= '<a href="' . esc_url( get_term_link( $term ) ) . '">' . esc_html( $breadcrumb_content ) . '</a>';
					$terms_markup .= ',&nbsp;';
				}
				$i ++;
			}
			$terms_markup .= '</li>';
		}


		return $terms_markup;
	}

	private function ube_get_taxonomies() {
		global $wp_query;
		$term         = $wp_query->get_queried_object();
		$terms_markup = '';

		// Make sure we have hierarchical taxonomy and parents.
		if ( 0 != $term->parent && is_taxonomy_hierarchical( $term->taxonomy ) ) {
			$term_ancestors = get_ancestors( $term->term_id, $term->taxonomy );
			$term_ancestors = array_reverse( $term_ancestors );
			// Loop through ancestors to get the full tree.
			foreach ( $term_ancestors as $term_ancestor ) {
				$term_object  = get_term( $term_ancestor, $term->taxonomy );
				$terms_markup .= $this->ube_get_single_breadcrumb_markup( $term_object->name, get_term_link( $term_object->term_id, $term->taxonomy ) );
			}
		}

		return $terms_markup;
	}
}