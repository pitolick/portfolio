<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package onesie pro
 */

/**
 * Add favicon in head
 *
 * @return html
 */
function onesie_pro_favicon(){
    $theme_options = get_option( 'onesie_pro_options' );
    if ( ! empty( $theme_options['favicon'] ) ) {
        echo '<link rel="shortcut icon" href="' . esc_url( $theme_options['favicon'] ) . '" />' . "\n";
    }
}
add_action( 'wp_head', 'onesie_pro_favicon' );

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * @param array $args Configuration arguments.
 * @return array
 */
function onesie_pro_page_menu_args( $args ) {
    $args['show_home'] = true;
    return $args;
}
add_filter( 'wp_page_menu_args', 'onesie_pro_page_menu_args' );

/**
 * Get theme version number from WP_Theme object (cached)
 *
 * @since onesie pro 1.0
*/
function onesie_pro_get_theme_version() {
        $theme_file = get_template_directory() . '/style.css';
        $theme = new WP_Theme( basename( dirname( $theme_file ) ), dirname( dirname( $theme_file ) ) );
        return $theme->get( 'Version' );
}

/**
 * Get pages for use in Theme Options
 *
 * @return array $terms
 */
function onesie_pro_get_pages() {

    $pages = get_pages();
    $terms = array();

        $terms['']['name'] = '';
        $terms['']['title'] = __( '-- Choose One --', 'gpp' );

    foreach ( $pages as $tt ) {
        $terms[$tt->ID]['name'] = $tt->ID;
        $terms[$tt->ID]['title'] = $tt->post_title;
    }

    return $terms;
}


/**
 * Template for comments and pingbacks.
 * To override this walker in a child theme without modifying the comments template
 * simply create your own onesie_pro_comment(), and that function will be used instead.
 * Used as a callback by wp_list_comments() for displaying the comments.
 * @package Onesie Pro
 * @since Onesie Pro 1.0
 */

if ( ! function_exists( 'onesie_pro_comment' ) ) :

function onesie_pro_comment( $comment, $args, $depth ) {
    $GLOBALS['comment'] = $comment;
    switch ( $comment->comment_type ) :
        case '' :
    ?>
    <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
        <article id="comment-<?php comment_ID(); ?>" class="comment">
            <footer>
                <div class="comment-author vcard">
                    <?php echo get_avatar( $comment, 40 ); ?>
                    <?php printf( __( '%s <span class="says">says:</span>', 'onesie_pro' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
                </div><!-- .comment-author .vcard -->
                <?php if ( $comment->comment_approved == '0' ) : ?>
                    <em><?php _e( 'Your comment is awaiting moderation.', 'onesie_pro' ); ?></em>
                    <br />
                <?php endif; ?>

                <div class="comment-meta commentmetadata">
                    <a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>"><time pubdate datetime="<?php comment_time( 'c' ); ?>">
                    <?php
                        /* translators: 1: date, 2: time */
                        printf( __( '%1$s at %2$s', 'onesie_pro' ), get_comment_date(), get_comment_time() ); ?>
                    </time></a>
                    <?php edit_comment_link( __( '(Edit)', 'onesie_pro' ), ' ' );
                    ?>
                </div><!-- .comment-meta .commentmetadata -->
            </footer>

            <div class="comment-content"><?php comment_text(); ?></div>

            <div class="reply">
                <?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
            </div><!-- .reply -->
        </article><!-- #comment-## -->

    <?php
            break;
        case 'pingback' :
        case 'trackback' :
    ?>
    <li class="post pingback">
        <p><?php _e( 'Pingback:', 'onesie_pro' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'onesie_pro' ), ' ' ); ?></p>
    <?php
            break;
    endswitch;
}
endif;

if ( ! function_exists( 'onesie_pro_paging_nav' ) ) :
/**
 * Display navigation to next/previous set of posts when applicable.
 *
 * @return void
 */
function onesie_pro_paging_nav() {
    // Don't print empty markup if there's only one page.
    if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
        return;
    }
    ?>
    <nav class="navigation paging-navigation" role="navigation">
        <h1 class="screen-reader-text"><?php _e( 'Posts navigation', 'onesie_pro' ); ?></h1>
        <div class="nav-links">

            <?php if ( get_next_posts_link() ) : ?>
            <div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'onesie_pro' ) ); ?></div>
            <?php endif; ?>

            <?php if ( get_previous_posts_link() ) : ?>
            <div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'onesie_pro' ) ); ?></div>
            <?php endif; ?>

        </div><!-- .nav-links -->
    </nav><!-- .navigation -->
    <?php
}
endif;

/**
 * Replace default gallery shortcode by image slider if not blog category
 */
function onesie_pro_gallery_shortcode($attr) {

    wp_enqueue_style( 'onesie-pro-flexslider-style' );
    wp_enqueue_script( 'onesie-pro-flexslider' );

    $post = get_post();

    static $instance = 0;
    $instance++;

    if ( ! empty( $attr['ids'] ) ) {
        // 'ids' is explicitly ordered, unless you specify otherwise.
        if ( empty( $attr['orderby'] ) )
            $attr['orderby'] = 'post__in';
        $attr['include'] = $attr['ids'];
    }

    // Allow plugins/themes to override the default gallery template.
    $output = apply_filters('post_gallery', '', $attr);
    if ( $output != '' )
        return $output;

    // We're trusting author input, so let's at least make sure it looks like a valid orderby statement
    if ( isset( $attr['orderby'] ) ) {
        $attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
        if ( !$attr['orderby'] )
            unset( $attr['orderby'] );
    }

    extract(shortcode_atts(array(
        'order'      => 'ASC',
        'orderby'    => 'menu_order ID',
        'id'         => $post->ID,
        'columns'    => 3,
        'size'       => 'thumbnail',
        'include'    => '',
        'exclude'    => ''
    ), $attr));

    $id = intval($id);
    if ( 'RAND' == $order )
        $orderby = 'none';

    if ( !empty($include) ) {
        $_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

        $attachments = array();
        foreach ( $_attachments as $key => $val ) {
            $attachments[$val->ID] = $_attachments[$key];
        }
    } elseif ( !empty($exclude) ) {
        $attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
    } else {
        $attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
    }

    if ( empty($attachments) )
        return '';

    $selector = "gallery-{$instance}";

    $swshortcode = '<div class="flexslider" id="'.$selector.'"><ul class="slides">';
               $counter = 0;
               foreach ( $attachments as $attachment ) :
                    $_post = get_post( $attachment );
                    $url = wp_get_attachment_url($_post->ID);
                    $post_title = esc_attr($_post->post_title);
                    $large_image = wp_get_attachment_image($_post->ID, 'large');
                    $caption = get_post_field('post_excerpt', $_post->ID);

                $swshortcode .= '<li><span class="flex-full-screen"></span>' . $large_image;
                if ($caption) {
                    $swshortcode .= '<p class="flex-caption">' . $caption . '</p>';
                }
                $swshortcode .= '</li>';
            $counter++;
            endforeach;

    $swshortcode .= '</ul>';
    $swshortcode .= '</div>';

    return $swshortcode;

}
remove_shortcode( 'gallery', 'gallery_shortcode' );
add_shortcode( 'gallery', 'onesie_pro_gallery_shortcode' );

/**
 * Returns true if a blog has more than 1 category.
 */
function onesie_pro_categorized_blog() {
    if ( false === ( $all_the_cool_cats = get_transient( 'all_the_cool_cats' ) ) ) {
        // Create an array of all the categories that are attached to posts.
        $all_the_cool_cats = get_categories( array(
            'hide_empty' => 1,
        ) );

        // Count the number of categories that are attached to the posts.
        $all_the_cool_cats = count( $all_the_cool_cats );

        set_transient( 'all_the_cool_cats', $all_the_cool_cats );
    }

    if ( '1' != $all_the_cool_cats ) {
        // This blog has more than 1 category so onesie_pro_categorized_blog should return true.
        return true;
    } else {
        // This blog has only 1 category so onesie_pro_categorized_blog should return false.
        return false;
    }
}

/**
 * Excerpt length
 */
function onesie_pro_excerpt_length( $length ) {
    return 20;
}
add_filter( 'excerpt_length', 'onesie_pro_excerpt_length', 999 );

/**
 * Excerpt more text
 */
function onesie_pro_new_excerpt_more( $more ) {
    return '...';
}
add_filter('excerpt_more', 'onesie_pro_new_excerpt_more');

/**
 * Add custom class to nav menu items
 */
function onesie_pro_custom_nav_class($classes, $item){

    if( $item->object == "page"){
        $template = get_post_meta( $item->object_id, '_wp_page_template', true );
        if ( $template == "page-lightbox.php" ) {
            $classes[] = "lightbox-menu";
        }
    }
    return $classes;
}
add_filter('nav_menu_css_class' , 'onesie_pro_custom_nav_class' , 10 , 2);

/**
 * Check theme options for thumbnail orientation
 *
 * @since 1.0
 */
function onesie_pro_image_orientation() {

    if ( get_option( gpp_get_current_theme_id() . '_options' ) ) {

        $options = get_option( gpp_get_current_theme_id() . '_options' );

        if ( ! empty( $options['onesie_pro_orientation'] ) && $options[ 'onesie_pro_orientation' ] == 'vertical' )
            return 'vertical';
        elseif ( ! empty( $options['onesie_pro_orientation'] ) && $options[ 'onesie_pro_orientation' ] == 'horizontal' )
            return 'horizontal';
        else
            return 'square';

    } else {

        return 'vertical';

    }

}

/**
 * Adds custom classes to the array of body classes.
 */
function onesie_pro_body_classes( $classes ) {
    if ( ! is_home() )
        $classes[] = 'not-home';

    $background_image = get_background_image();
    if ( $background_image )
        $classes[] = 'has-background-image';

    $header_image = get_header_image();
    if ( $header_image )
        $classes[] = 'has-header-image';

    return $classes;
}
add_filter( 'body_class', 'onesie_pro_body_classes' );