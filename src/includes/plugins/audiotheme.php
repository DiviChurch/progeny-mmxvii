<?php
/**
 * AudioTheme Compatibility File
 *
 * @package Progeny_MMXVII
 * @since 1.0.0
 * @link https://audiotheme.com/
 */

/**
 * Set up theme defaults and register support for various AudioTheme features.
 *
 * @since 1.0.0
 */
function progeny_audiotheme_setup() {
	add_image_size( 'record-thumbnail', 580, 580, true );
	add_image_size( 'video-thumbnail',  580, 326, true );
}
add_action( 'after_setup_theme', 'progeny_audiotheme_setup', 11 );

/**
 * Load required scripts for AudioTheme support.
 *
 * @since 1.0.0
 */
function progeny_audiotheme_enqueue_assets() {
	wp_enqueue_style(
		'progeny-audiotheme',
		get_stylesheet_directory_uri() . '/assets/css/audiotheme.css',
		array( 'progeny-parent-theme' )
	);
	wp_style_add_data( 'progeny-audiotheme', 'rtl', 'replace' );
}
add_action( 'wp_enqueue_scripts', 'progeny_audiotheme_enqueue_assets', 20 );

/**
 * Display AudioTheme templates as full width.
 *
 * @param  bool $is_full_width Is full width page template.
 * @return bool
 */
function progeny_audiotheme_is_full_width( $is_full_width ) {
	return progeny_is_audiotheme() ? true : $is_full_width;
}
add_filter( 'progeny_is_full_width', 'progeny_audiotheme_is_full_width' );

/**
 * Add additional HTML classes to posts.
 *
 * @since 1.0.0
 *
 * @param array $classes List of HTML classes.
 * @return array
 */
function progeny_audiotheme_post_class( $classes ) {
	if ( is_singular( 'audiotheme_gig' ) && audiotheme_gig_has_venue() ) {
		$classes[] = 'has-venue';
	}

	if ( is_singular( 'audiotheme_track' ) && get_audiotheme_track_thumbnail_id() ) {
		$classes[] = 'has-post-thumbnail';
	}

	if ( is_singular( 'audiotheme_video' ) && get_audiotheme_video_url() ) {
		$classes[] = 'has-post-video';
	}

	return $classes;
}
add_filter( 'post_class', 'progeny_audiotheme_post_class' );

/*
 * AudioTheme hooks.
 * -----------------------------------------------------------------------------
 */

/**
 * HTML to display before main AudioTheme content.
 *
 * @since 1.1.0
 */
function progeny_audiotheme_before_main_content() {
	echo '<div class="wrap">';
	echo '<div id="primary" class="content-area">';
	echo '<main id="main" class="site-main" role="main">';
}
add_action( 'audiotheme_before_main_content', 'progeny_audiotheme_before_main_content' );

/**
 * HTML to display after main AudioTheme content.
 *
 * @since 1.1.0
 */
function progeny_audiotheme_after_main_content() {
	echo '</main><!-- #main -->';
	echo '</div><!-- #primary -->';
	// get_sidebar();
	echo '</div><!-- .wrap -->';
}
add_action( 'audiotheme_after_main_content', 'progeny_audiotheme_after_main_content' );

/**
 * Activate default archive setting fields.
 *
 * @since 1.0.0
 *
 * @param array $fields List of default fields to activate.
 * @param string $post_type Post type archive.
 * @return array
 */
function progeny_audiotheme_archive_settings_fields( $fields, $post_type ) {
	if ( ! in_array( $post_type, array( 'audiotheme_record', 'audiotheme_video' ) ) ) {
		return $fields;
	}

	$fields['posts_per_archive_page'] = true;

	return $fields;
}
add_filter( 'audiotheme_archive_settings_fields', 'progeny_audiotheme_archive_settings_fields', 10, 2 );


/*
 * Supported Plugin Hooks
 * -----------------------------------------------------------------------------
 */

/**
 * Disable Jetpack Infinite Scroll on AudioTheme post types.
 *
 * @since 1.0.0
 *
 * @param bool $supported Whether Infinite Scroll is supported for the current request.
 * @return bool
 */
function progeny_audiotheme_infinite_scroll_archive_supported( $supported ) {
	$post_type = get_post_type() ? get_post_type() : get_query_var( 'post_type' );

	if ( $post_type && false !== strpos( $post_type, 'audiotheme_' ) ) {
		$supported = false;
	}

	return $supported;
}
add_filter( 'infinite_scroll_archive_supported', 'progeny_audiotheme_infinite_scroll_archive_supported' );


/*
 * Theme Hooks
 * -----------------------------------------------------------------------------
 */

function progeny_audiotheme_featured_image_header( $is_active ) {
	return progeny_is_audiotheme_single() ? false : $is_active;
}
add_filter( 'progeny_single_featured_image_header_is_active', 'progeny_audiotheme_featured_image_header' );


/*
 * Template tags.
 * -----------------------------------------------------------------------------
 */

/**
 * Determine if AudioTheme template.
 *
 * @return bool
 */
function progeny_is_audiotheme() {
	return is_audiotheme_post_type_archive() || progeny_is_audiotheme_single();
}

/**
 * Determine if is singular AudioTheme template.
 *
 * @return bool
 */
function progeny_is_audiotheme_single() {
	return is_singular( array( 'audiotheme_gig', 'audiotheme_record', 'audiotheme_track', 'audiotheme_video' ) );
}
