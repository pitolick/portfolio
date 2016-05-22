<?php

/**
 * Sell Media integration
 */

/*
 * Filter the image size to use the larger thumbnail
 */
function onesie_pro_sell_media_thumbnail(){
    global $theme_options;
    if ( 'vertical' == $theme_options['onesie_pro_orientation'] )
        return 'vertical';
    else if ( 'square' == $theme_options['onesie_pro_orientation'] )
        return 'square';
    else
        return 'horizontal';
}
add_filter( 'sell_media_thumbnail', 'onesie_pro_sell_media_thumbnail' );

/*
 * Add Likes and Lightbox to Sell Media item overlay
 */
function onesie_pro_sell_media_item_overlay( $html, $post_id ){
    $html .= sell_media_lightbox_link( $post_id );

    return $html;
}
add_filter( 'sell_media_item_overlay', 'onesie_pro_sell_media_item_overlay', 10, 2 );
