<?php

/**
 * Update sidebar with default widgets
 *
 * @package Onesie Pro
 * @since Onesie Pro 1.0
 */

/**
 * Remove default WordPress widgets on theme activation
 */
function onesie_pro_do_widgets_init() {
    do_action( 'widgets_init' );
}
add_action( 'init', 'onesie_pro_do_widgets_init', 1 );

/**
 * Remove default WordPress widgets on activation
 */
function onesie_pro_remove_action() {
    remove_action( 'init', 'wp_widgets_init', 1 );
}
add_action( 'plugins_loaded', 'onesie_pro_remove_action' );