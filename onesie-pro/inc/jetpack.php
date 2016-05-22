<?php

/**
 * Jetpack Compatibility
 *
 * @package Onesie Pro
 * @since Onesie Pro 1.0
 */

/**
 * Add theme support for Infinite Scroll.
 * See: http://jetpack.me/support/infinite-scroll/
 */
function onesie_jetpack_setup() {
    add_theme_support( 'infinite-scroll', array(
        'container' => 'main',
        'footer'    => 'page',
    ) );
}
add_action( 'after_setup_theme', 'onesie_jetpack_setup' );
