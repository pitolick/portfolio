<?php

/**
 * Display navigation to next/previous pages when applicable
 *
 * @package Onesie Pro
 * @since Onesie Pro 1.0
 */

if ( ! function_exists( 'onesie_pro_content_nav' ) ):

function onesie_pro_content_nav( $nav_id ) {
    global $wp_query;

    ?>
    <nav id="<?php echo $nav_id; ?>">
        <h1 class="assistive-text"><?php _e( 'Post navigation', 'onesie_pro' ); ?></h1>

    <?php if ( is_single() ) : // navigation links for single posts ?>

        <?php if (function_exists('wp_pagenavi')) { ?>
            <?php wp_pagenavi(); ?>
            <?php } else { ?>
            <?php previous_post_link( '<div class="nav-previous">%link</div>', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'onesie_pro' ) . '</span> %title' ); ?>
            <?php next_post_link( '<div class="nav-next">%link</div>', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'onesie_pro' ) . '</span>' ); ?>
            <?php } ?>

    <?php elseif ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) : // navigation links for home, archive, and search pages ?>

        <?php if (function_exists('wp_pagenavi')) { ?>
            <?php wp_pagenavi(); ?>
            <?php } else { ?>

            <?php if ( get_next_posts_link() ) : ?>
            <div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'onesie_pro' ) ); ?></div>
            <?php endif; ?>

            <?php if ( get_previous_posts_link() ) : ?>
            <div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'onesie_pro' ) ); ?></div>
            <?php endif; ?>

        <?php } ?>

    <?php endif; ?>

    </nav><!-- #<?php echo $nav_id; ?> -->
    <?php
}
endif;