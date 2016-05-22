<?php

/**
 * These functions display define Post loops
 *
 * @package Onesie Pro
 * @since Onesie Pro 1.0
 */

if ( ! function_exists( 'onesie_pro_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 * Create your own onesie_pro_posted_on to override in a child theme
 *
 * @since Onesie Pro 1.2
 */
function onesie_pro_posted_on() {
    printf( __( '<span class="sep">Posted on </span><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s" >%4$s</time></a><span class="byline"> <span class="sep"> by </span> <span class="author vcard"><a class="url fn n" href="%5$s" title="%6$s" rel="author">%7$s</a></span></span>', 'onesie_pro' ),
        esc_url( get_permalink() ),
        esc_attr( get_the_time() ),
        esc_attr( get_the_date( 'c' ) ),
        esc_html( get_the_date() ),
        esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
        esc_attr( sprintf( __( 'View all posts by %s', 'onesie_pro' ), get_the_author() ) ),
        esc_html( get_the_author() )
    );
}
endif;

if ( ! function_exists( 'onesie_pro_pub_date' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 * Create your own onesie_pro_posted_on to override in a child theme
 *
 * @since Onesie Pro 1.2
 */
function onesie_pro_pub_date() {
    printf( __( '<a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s" >%4$s</time></a>', 'onesie_pro' ),
        esc_url( get_permalink() ),
        esc_attr( get_the_time() ),
        esc_attr( get_the_date( 'c' ) ),
        esc_html( get_the_date() )
    );
}
endif;


/**
 * Returns the_content or the_excerpt or none
 * User theme option
 *
 * @since Onesie Pro 1.0
 */
function onesie_pro_custom_content() {

    global $gpp;

    if( isset( $gpp[ 'onesie_pro_cen' ] ) )
        $cen = $gpp[ 'onesie_pro_cen' ];
    if( is_single() ) {
        return the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'onesie_pro' ) );
    } else {
        if( isset($cen) && 'the_content' == $cen )
            return the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'onesie_pro' ) );
        elseif( isset( $cen ) && 'the_excerpt' == $cen )
            return the_excerpt();
        else
            return '';
    }
}