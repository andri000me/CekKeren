<?php
/**
 * Clarina functions and definitions
 *
 * @package clarina
 */

add_action( 'wp_enqueue_scripts', 'clarina_enqueue_styles', 99 );

/**
 * Enqueue scripts and styles.
 */
function clarina_enqueue_styles() {
	wp_enqueue_style( 'clarina-parent-style', get_template_directory_uri() . '/style.css' );
	wp_enqueue_style( 'clarina-fonts', clarina_fonts_url(), array(), null );
	wp_enqueue_style( 'clarina-inline-style', get_stylesheet_uri(), array(), '1.0.0' );
	wp_enqueue_script( 'clarina-custom-script', get_stylesheet_directory_uri() . '/js/custom.js', array( 'jquery' ), '2.0.2', true );
}

/**
 * Include fonts
 */
function clarina_fonts_url() {
	$fonts_url = '';

	/*
	 Translators: If there are characters in your language that are not
	* supported by Titillium Web, translate this to 'off'. Do not translate
	* into your own language.
	*/
	$titillium_web = _x( 'on', 'Titillium Web font: on or off', 'clarina' );

	/*
	 Translators: If there are characters in your language that are not
	* supported by Assistant, translate this to 'off'. Do not translate
	* into your own language.
	*/
	$assistant = _x( 'on', 'Assistant font: on or off', 'clarina' );

	if ( 'off' !== $titillium_web || 'off' !== $assistant ) {
		$font_families = array();

		if ( 'off' !== $titillium_web ) {
			$font_families[] = 'Titillium Web:400,400i,600,700';
		}
		if ( 'off' !== $assistant ) {
			$font_families[] = 'Assistant:700,400,800';
		}
		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);
		$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	}
	return esc_url_raw( $fonts_url );
}


add_action( 'customize_register','clarina_customize_register' );

/**
 * Customize controls
 */
function clarina_customize_register( $wp_customize ) {

	/* Ribbon subtitle */
	$clarina_ribbon_subtitle_default = '';
	if ( current_user_can( 'edit_theme_options' ) ) {
		/* translators: Customize link for Ribbon section subtitle */
		$clarina_ribbon_subtitle_default = sprintf( __( 'Change this subtitle in %s','clarina' ), sprintf( '<a href="%1$s">%2$s</a>', esc_url( admin_url( 'customize.php?autofocus&#91;control&#93;=clarina_ribbon_subtitle' ) ), __( 'Ribbon section','clarina' ) ) );
	}

	$wp_customize->add_setting( 'clarina_ribbon_subtitle', array(
		'default' => $clarina_ribbon_subtitle_default,
		'sanitize_callback' => 'llorix_one_lite_sanitize_text',
		'transport' => 'postMessage',
	));
	$wp_customize->add_control( 'clarina_ribbon_subtitle', array(
		'label'    => esc_html__( 'Main subtitle', 'clarina' ),
		'section'  => 'llorix_one_lite_ribbon_section',
		'priority'    => 25,
	));

	/* Ribbon image */
	$wp_customize->add_setting( 'clarina_ribbon_image', array(
		'default' => apply_filters( 'llorix_one_lite_ribbon_image_filter', llorix_one_lite_get_file( '/images/ribbon-phone.png' ) ),
		'sanitize_callback' => 'esc_url',
		'transport' => 'postMessage',
	));
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'clarina_ribbon_image', array(
		'label'    => esc_html__( 'Image', 'clarina' ),
		'section'  => 'llorix_one_lite_ribbon_section',
		'priority'    => 50,
	)));

	/* latest posts subtitle */
	$clarina_news_subtitle_default = '';
	if ( current_user_can( 'edit_theme_options' ) ) {
		/* translators: Customize link for Latest news section subtitle */
		$clarina_news_subtitle_default = sprintf( __( 'Change this subtitle in %s','clarina' ), sprintf( '<a href="%1$s">%2$s</a>', esc_url( admin_url( 'customize.php?autofocus&#91;control&#93;=clarina_news_subtitle' ) ), __( 'Latest news section','clarina' ) ) );
	}

	$wp_customize->add_setting( 'clarina_news_subtitle', array(
		'default' => $clarina_news_subtitle_default,
		'sanitize_callback' => 'llorix_one_lite_sanitize_text',
		'transport' => 'postMessage',
	));
	$wp_customize->add_control( 'clarina_news_subtitle', array(
		'label'    => esc_html__( 'Main subtitle', 'clarina' ),
		'section'  => 'llorix_one_lite_latest_news_section',
		'priority'    => 15,
	));

	/* Featured ribbon Title */
	$wp_customize->add_setting( 'clarina_featured_ribbon_title', array(
		'default' => esc_html__( 'Features','clarina' ),
		'sanitize_callback' => 'llorix_one_lite_sanitize_text',
		'transport' => 'postMessage',
	));
	$wp_customize->add_control( 'clarina_featured_ribbon_title', array(
		'label'    => esc_html__( 'Main title', 'clarina' ),
		'section'  => 'llorix_one_lite_features_ribbon_section',
		'priority'    => 15,
	));

	/* Selective refresh */
	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'clarina_ribbon_subtitle', array(
			'selector'        => '.ribbon-subtitle-wrap',
			'settings'        => 'clarina_ribbon_subtitle',
			'render_callback' => 'clarina_ribbon_subtitle_render_callback',
		) );
		$wp_customize->selective_refresh->add_partial( 'clarina_news_subtitle', array(
			'selector'        => '.latest-news-subtitle-wrap',
			'settings'        => 'clarina_news_subtitle',
			'render_callback' => 'clarina_news_subtitle_render_callback',
		) );
	}
}

add_action( 'llorix_one_lite_home_ribbon_section_subtitle', 'clarina_ribbon_subtitle_action', 1 );

/**
 * Add a subtitle in the Ribbon section
 */
function clarina_ribbon_subtitle_action() {

	if ( current_user_can( 'edit_theme_options' ) ) {
		/* translators: Customize link for Ribbon section subtitle */
		$clarina_ribbon_subtitle = get_theme_mod( 'clarina_ribbon_subtitle', sprintf( __( 'Change this subtitle in %s','clarina' ), sprintf( '<a href="%1$s">%2$s</a>', esc_url( admin_url( 'customize.php?autofocus&#91;control&#93;=clarina_ribbon_subtitle' ) ), __( 'Ribbon section','clarina' ) ) ) );
	} else {
		$clarina_ribbon_subtitle = get_theme_mod( 'clarina_ribbon_subtitle' );
	}

	if ( ! empty( $clarina_ribbon_subtitle ) || is_customize_preview() ) {
		echo '<div class="ribbon-subtitle-wrap' . ( empty( $clarina_ribbon_subtitle ) && is_customize_preview() ? ' llorix_one_lite_only_customizer' : '' ) . '">' . wp_kses_post( $clarina_ribbon_subtitle ) . '</div>';
	}
}

add_action( 'llorix_one_lite_home_ribbon_section_close', 'clarina_ribbon_image', 1 );

/**
 * Add a new image in the Ribbon section
 */
function clarina_ribbon_image() {
	$clarina_ribbon_image = get_theme_mod( 'clarina_ribbon_image', llorix_one_lite_get_file( '/images/ribbon-phone.png' ) );
	if ( ! empty( $clarina_ribbon_image ) || is_customize_preview() ) {
		echo '<div class="col-md-10 col-md-offset-1 ribbon-image-wrap' . ( empty( $clarina_ribbon_image ) && is_customize_preview() ? ' llorix_one_lite_only_customizer' : '' ) . '">';
			echo '<img src="' . esc_url( $clarina_ribbon_image ) . '" >';
		echo '</div>';
	}
}

add_action( 'llorix_features_ribbon_entry_top', 'clarina_features_ribbon_title', 1 );

/**
 * Featured ribbon title
 */
function clarina_features_ribbon_title() {
	$clarina_featured_ribbon_title = get_theme_mod( 'clarina_featured_ribbon_title', esc_html__( 'Features','clarina' ) );
	if ( ! empty( $clarina_featured_ribbon_title ) || isset( $wp_customize ) ) {
		echo '<div class="section-header' . ( empty( $clarina_featured_ribbon_title ) && isset( $wp_customize ) ? ' llorix_one_lite_only_customizer' : '' ) . '">';
			echo '<h2 class="dark-text">' . esc_html( $clarina_featured_ribbon_title ) . '</h2>';
			echo '<div class="colored-line"></div>';
		echo '</div>';
	}
}

/**
 * Customizer js file
 */
function clarina_customizer_live_preview() {
	wp_enqueue_script( 'clarina_customizer_script', llorix_one_lite_get_file( '/js/clarina_customizer.js' ), array( 'jquery', 'customize-preview' ), '1.0', true );
}
add_action( 'customize_preview_init', 'clarina_customizer_live_preview' );

/**
 * Theme inline style.
 */
function clarina_php_style() {

	$custom_css = '';

	$llorix_one_lite_services_section_box_title = get_theme_mod( 'llorix_one_lite_services_section_box_title', apply_filters( 'llorix_one_lite_services_section_box_title_filter', '#1e3046' ) );
	$llorix_one_shop_item_button                = get_theme_mod( 'llorix_one_shop_item_button',  apply_filters( 'llorix_one_shop_item_button_filter', '#28b7b1' ) );

	if ( ! empty( $llorix_one_lite_services_section_box_title ) ) {
		$custom_css .= '.single-service h3 { color: ' . sanitize_hex_color( $llorix_one_lite_services_section_box_title ) . '!important; }';
	}

	if ( ! empty( $llorix_one_shop_item_button ) ) {
		$custom_css .= '.home-add-to-cart-wrap a { background-color: ' . sanitize_hex_color( $llorix_one_shop_item_button ) . '!important; }';
	}

	wp_add_inline_style( 'clarina-inline-style', $custom_css );

}
add_action( 'wp_enqueue_scripts', 'clarina_php_style', 100 );

/**
 * Filter the very top header to not appear
 */
function clarina_filters_return_one() {
	return 1;
}
add_filter( 'llorix_one_lite_very_top_header_show_filter', 'clarina_filters_return_one' );

/**
 * Remove the header logo and ribbon background default options
 */
add_filter( 'llorix_one_lite_header_logo_filter', '__return_false' );
add_filter( 'llorix_one_lite_ribbon_background_filter', '__return_false' );

/**
 * Filter the big title overlay
 */
function clarina_filters_big_title_overlay( $input ) {
	return 'rgba(13, 60, 85, 0)';
}
add_filter( 'llorix_one_lite_frontpage_opacity_filter', 'clarina_filters_big_title_overlay' );

/**
 * Filter the big title layout
 */
function clarina_big_title_layout( $input ) {
	return 'layout2';
}
add_filter( 'llorix_one_lite_header_layout_filter', 'clarina_big_title_layout' );

/**
 * Filter the services section box title color
 */
function clarina_services_section_box_title( $input ) {
	return '#1e3046';
}
add_filter( 'llorix_one_lite_services_section_box_title_filter', 'clarina_services_section_box_title' );

/**
 * Filter the shop items button color
 */
function clarina_shop_item_button( $input ) {
	return '#28b7b1';
}
add_filter( 'llorix_one_shop_item_button_filter', 'clarina_shop_item_button' );

/**
 * Filter the footer links color
 */
function clarina_footer_links( $input ) {
	return '#717171';
}
add_filter( 'llorix_one_plus_footer_links_filter', 'clarina_footer_links' );

/**
 * Filter the general links color
 */
function clarina_general_links( $input ) {
	return '#28b7b1';
}
add_filter( 'llorix_plus_general_links_filter', 'clarina_general_links' );

/**
 * Filter header right image
 */
function clarina_header_right_image( $input ) {
	return llorix_one_lite_get_file( '/images/phone.png' );
}
add_filter( 'llorix_one_plus_header_right_image_filter', 'clarina_header_right_image' );

/**
 * Filter the blog opacity color
 */
function clarina_blog_opacity( $input ) {
	return 'rgba(13,60,85,0.0)';
}
add_filter( 'llorix_one_lite_blog_opacity_filter', 'clarina_blog_opacity' );

/**
 * Homepage section order
 */
function clarina_sections_order() {
	$naturelle_order = array(
		'sections/llorix_one_lite_logos_section',
		'llorix_one_lite_our_services_section',
		'sections/llorix_one_lite_our_story_section',
		'llorix_one_lite_our_team_section',
		'llorix_one_lite_happy_customers_section',
		'sections/llorix_one_lite_ribbon_section',
		'sections/llorix_one_lite_latest_news_section',
		'sections/llorix_one_lite_contact_info_section',
		'sections/llorix_one_lite_map_section',
	);
	return $naturelle_order;
}
add_filter( 'llorix_one_companion_sections_filter', 'clarina_sections_order' );

/**
 * Remove actions from parent theme
 */
function clarina_remove_from_parent_theme() {

	/**
	 * Remove the post date box on search page
	 */
	remove_action( 'llorix_one_lite_post_date_box','llorix_one_lite_post_date_box_function' );

	/**
	 * Remove upsells from parent
	 */
	remove_action( 'after_setup_theme', 'llorix_one_lite_upsells_setup' );

	remove_action( 'customize_register', 'llorix_one_lite_customize_upsells_register' );
}
add_action( 'after_setup_theme', 'clarina_remove_from_parent_theme', 0 );

/**
 * Remove the title of articles on index/search as they are in the parent theme
 */
function clarina_remove_article_title_function() {
	return false;
}
add_filter( 'llorix_one_lite_filter_article_title_on_index','clarina_remove_article_title_function' );

add_filter( 'llorix_one_lite_filter_article_title_on_search','clarina_remove_article_title_function' );

/**
 * Add the title of articles on index/search in a new place in the child theme
 */
function clarina_before_entry_meta_content_function() {
	the_title( sprintf( '<h1 class="entry-title" itemprop="headline"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' );
}

add_action( 'llorix_one_lite_before_entry_meta_content','clarina_before_entry_meta_content_function' );

/**
 * Add a slash after the author/categories/date in entry meta
 */
function clarina_after_author_and_cat_in_entry_meta_function() {
	echo '/';
}
add_action( 'llorix_one_lite_after_author_in_entry_meta','clarina_after_author_and_cat_in_entry_meta_function' );

add_action( 'llorix_one_lite_after_date_in_entry_meta','clarina_after_author_and_cat_in_entry_meta_function' );

add_action( 'llorix_one_lite_after_categories_in_entry_meta','clarina_after_author_and_cat_in_entry_meta_function' );

/**
 * Add a subtitle option in the Latest news section
 */
function clarina_add_subtitle_to_latest_news_section() {

	if ( current_user_can( 'edit_theme_options' ) ) {
		/* translators: Customize link for Latest news section subtitle */
		$clarina_news_subtitle = get_theme_mod( 'clarina_news_subtitle', sprintf( __( 'Change this subtitle in %s','clarina' ), sprintf( '<a href="%1$s">%2$s</a>', esc_url( admin_url( 'customize.php?autofocus&#91;control&#93;=clarina_news_subtitle' ) ), __( 'Latest news section','clarina' ) ) ) );
	} else {
		$clarina_news_subtitle = get_theme_mod( 'clarina_news_subtitle' );
	}

	if ( ! empty( $clarina_news_subtitle ) || is_customize_preview() ) {
		echo '<div class="latest-news-subtitle-wrap' . ( empty( $clarina_news_subtitle ) && is_customize_preview() ? ' llorix_one_lite_only_customizer' : '' ) . '">' . wp_kses_post( $clarina_news_subtitle ) . '</div>';
	}

}

add_action( 'llorix_one_lite_latest_news_section_after_title','clarina_add_subtitle_to_latest_news_section' );

/**
 * Filter the powered by message in the footer
 *
 * @return string
 */
function clarina_change_poweredby() {

	$text = sprintf(
		/* translators: 1 is the theme URI , 2 is the WordPress.org link  */
		__( '%1$s powered by %2$s', 'clarina' ),
		'<a href="https://justfreethemes.com/clarina/" rel="nofollow">Clarina</a>',
		'<a href="http://wordpress.org/" rel="nofollow">' . esc_html__( 'WordPress','clarina' ) . '</a>'
	);

	return sprintf( '<div class="powered-by">%s</div>', $text );
}

add_filter( 'llorix_one_plus_footer_text_filter','clarina_change_poweredby' );

/**
 * Filter the default copyright message
 *
 * @return string
 */
add_filter( 'llorix_one_lite_copyright_default_filter','__return_empty_string' );

/**
 * Render callback for clarina_ribbon_subtitle
 *
 * @return mixed
 */
function clarina_ribbon_subtitle_render_callback() {
	return wp_kses_post( get_theme_mod( 'clarina_ribbon_subtitle' ) );
}

/**
 * Render callback for clarina_news_subtitle
 *
 * @return mixed
 */
function clarina_news_subtitle_render_callback() {
	return wp_kses_post( get_theme_mod( 'clarina_news_subtitle' ) );
}

/**
 * Render callback for clarina_news_subtitle
 *
 * @return mixed
 */
function clarina_default_header_title() {
	return esc_html__( 'Blog','clarina' );
}

add_filter( 'llorix_one_lite_blog_header_title_default_filter','clarina_default_header_title' );
