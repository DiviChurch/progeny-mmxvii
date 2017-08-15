<?php
/**
 * Custom template tags.
 *
 * @package Progeny_MMXVII
 * @since 1.0.0
 */

/**
 * Determine if single featured image header should display.
 *
 * @return bool
 */
function progeny_single_featured_image_header_is_active() {
	/*
	 * If a regular post or page, and not the front page, show the featured image.
	 * Using get_queried_object_id() here since the $post global may not be set
	 * before a call to the_post().
	 *
	 * @see twentyseventeen/header.php
	 */
	$is_active = ( is_single() || ( is_page() && ! twentyseventeen_is_frontpage() ) ) && has_post_thumbnail( get_queried_object_id() );

	return apply_filters( 'progeny_single_featured_image_header_is_active', $is_active );
}

/**
 * Determine if a page should use the full-width layout.
 *
 * @since 1.0.0
 *
 * @return bool
 */
function progeny_is_full_width() {
	$is_full_width = is_page_template( array(
		'full-width-page.php',
	) );

	return (bool) apply_filters( 'progeny_is_full_width', $is_full_width );
}

/**
 * Allow only the allowedtags array in a string.
 *
 * @since 1.0.0
 *
 * @link https://www.tollmanz.com/wp-kses-performance/
 *
 * @param  string $string The unsanitized string.
 * @return string The sanitized string.
 */
function progeny_allowed_tags( $string ) {
	global $allowedtags;

	$theme_tags = array(
		'a'	=> array(
			'class'	=> true,
			'href'  => true,
			'rel'   => true,
			'title'	=> true,
		),
		'br' => array(),
		'h2' => array(
			'class' => true,
		),
		'img' => array(
			'alt'    => true,
			'height' => true,
			'sizes'  => true,
			'src'    => true,
			'srcset' => true,
			'width'  => true,
		),
		'p' => array(
			'class' => true,
		),
		'span' => array(
			'class' => true,
		),
		'time' => array(
			'class'	=> true,
			'datetime' => true,
		),
	);

	return wp_kses( $string, array_merge( $allowedtags, $theme_tags ) );
}

/**
 * Theme credits text.
 *
 * @link https://wordpress.org/plugins/footer-credits/
 *
 * @since 1.0.0
 *
 * @param string $text Text to display.
 * @return string
 */
function progeny_credits() {
	$credits = apply_filters( 'progeny_credits', sprintf(
		'<a href="%1$s">%2$s</a>',
		esc_url( __( 'https://wordpress.org/', 'progeny' ) ),
		sprintf( esc_html__( 'Proudly powered by %s', 'progeny' ), 'WordPress' )
	) );
	$credits = apply_filters( 'footer_credits', $credits );
	echo progeny_allowed_tags( $credits );
}
