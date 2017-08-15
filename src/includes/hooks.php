<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * @package Progeny_MMXVII
 * @since 1.0.0
 */

/**
 * Add additional HTML classes to posts.
 *
 * @since 1.0.0
 *
 * @param array $classes List of HTML classes.
 * @return array
 */
function progeny_body_class( $classes ) {
	if ( progeny_is_full_width() ) {
		$classes[] = 'page-one-column';
		$classes[] = 'full-width-column';
		$classes = array_diff( $classes, array( 'page-two-column' ) );
		$classes = array_diff( $classes, array( 'has-sidebar' ) );
	}

	return $classes;
}
add_filter( 'body_class', 'progeny_body_class', 20 );
