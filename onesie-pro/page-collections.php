<?php
/*
 Template Name: Collections
 *
 * @package Onesie Pro
 * @since Onesie Pro 1.0
 */

get_header(); ?>
<?php
global $paged;
if ( get_query_var('paged') ) {
    $paged = get_query_var('paged');
} elseif ( get_query_var('page') ) {
    $paged = get_query_var('page');
} else {
    $paged = 1;
}
?>
<div id="primary" class="content-area collections-template sell-media">
    <div id="sell-media-archive">
        <div id="content" class="site-content" role="main">

            <header class="page-header">
                <h1 class="entry-title"><?php the_title(); ?></h1>
            </header><!-- .entry-header -->

            <?php if ( current_theme_supports( 'sell_media' ) ) : ?>
                <?php
                    global $theme_options;
                    $sell_media_options = sell_media_get_plugin_options();

                ?>
                    <div class="portfolios grid">
                        <div id="main-collections" class="sell-media-grid-container">
                            <ul class="gallery clearfix">
                            <?php

                            $taxonomy = 'collection';
                            $term_ids = array();
                            foreach( get_terms( $taxonomy ) as $term_obj ){
                                $password = sell_media_get_term_meta( $term_obj->term_id, 'collection_password', true );
                                if ( $password ) $term_ids[] = $term_obj->term_id;
                            }

                            $args = array(
                                'orderby' => 'name',
                                'hide_empty' => true,
                                'parent' => 0,
                                'exclude' => $term_ids
                            );

                            $terms = get_terms( $taxonomy, $args );

                            if ( empty( $terms ) )
                                return;

                            $count = count( $terms );

                            foreach( $terms as $term ) :
                                $args = array(
                                        'post_status' => 'publish',
                                        'taxonomy' => 'collection',
                                        'field' => 'slug',
                                        'term' => $term->slug,
                                        'tax_query' => array(
                                            array(
                                                'taxonomy' => 'collection',
                                                'field' => 'id',
                                                'terms' => $term_ids,
                                                'operator' => 'NOT IN'
                                                )
                                            )
                                        );
                                $posts = New WP_Query( $args );
                                $post_count = $posts->found_posts;

                                if ( $post_count != 0 ) : ?>
                                    <li class="sell-media-grid portfolio">
                                        <?php
                                        $args = array(
                                                'posts_per_page' => 1,
                                                'taxonomy' => 'collection',
                                                'field' => 'slug',
                                                'term' => $term->slug
                                                );

                                        $posts = New WP_Query( $args );
                                        ?>

                                        <?php foreach( $posts->posts as $post ) : ?>

                                            <?php $term_id = $term->term_id; ?>

                                            <?php global $post; ?>
                                            <?php
                                            $attachment_id = get_post_thumbnail_id( $post->ID );
                                            $attachment_link = get_post_meta( $attachment_id , '_gpp_custom_url', true );
                                            $attachment_url = wp_get_attachment_image_src( $attachment_id, 'large' );
                                            $attachment_caption = get_post_field( 'post_excerpt', $attachment_id );
                                            ?>
                                                <?php
                                                //Get Post Attachment ID
                                                $sell_media_attachment_id = get_post_meta( $post->ID, '_sell_media_attachment_id', true );
                                                if ( $sell_media_attachment_id ){
                                                    $attachment_id = $sell_media_attachment_id;
                                                } else {
                                                    $attachment_id = get_post_thumbnail_id( $post->ID );
                                                }
                                                $attachment_url = wp_get_attachment_image_src( $attachment_id, 'large' );
                                                $attachment_caption = get_post_field( 'post_excerpt', $attachment_id );
                                                ?>

                                                <figure>

                                                    <div class="entry-image">
                                                        <a href="<?php echo $attachment_url[0]; ?>" title="<?php echo $attachment_caption; ?>" rel="bookmark" class="gallery-sm-item">
                                                            <span class="genericon genericon-fullscreen"></span>
                                                        </a>
                                                        <a href="<?php echo get_term_link( $term->slug, $taxonomy ); ?>">
                                                            <?php
                                                            $collection_attachment_id = sell_media_get_term_meta( $term->term_id, 'collection_icon_id', true );
                                                            if ( ! empty ( $collection_attachment_id ) ) {
                                                                print wp_get_attachment_image( $collection_attachment_id, onesie_pro_image_orientation() );
                                                            } else {
                                                                sell_media_item_icon( $attachment_id, onesie_pro_image_orientation() );
                                                            } ?>
                                                        </a>
                                                    </div>

                                                    <figcaption>
                                                        <h3><a href="<?php echo get_term_link( $term->slug, $taxonomy ); ?>"><?php echo $term->name; ?></a></h3>
                                                        <div class="collection-details">
                                                            <span class="collection-count">
                                                                <?php echo '<span class="count">' . $post_count . '</span>' .  __( ' images in ', 'onesie_pro' ) . '<span class="collection">' . $term->name . '</span>' . __(' collection', 'onesie_pro'); ?>
                                                            </span>
                                                            <span class="collection-price">
                                                                <?php echo __( 'Starting at ', 'onesie_pro' ) . '<span class="price">' . sell_media_get_currency_symbol() . $sell_media_options->default_price . '</span>' ?>
                                                            </span>
                                                        </div>
                                                    </figcaption>
                                                </figure>

                                                    <?php endforeach; ?>
                                                </li>
                                            <?php endif; ?>
                                        <?php endforeach; ?>

                            </ul>
                        </div><!-- .sell-media-grid-container -->
                    </div><!-- .portfolios grid -->
                    <?php sell_media_pagination_filter(); ?>
                    <?php edit_post_link( __( 'Edit', 'onesie_pro' ), '<p class="edit-link">', '</p>' ); ?>
            <?php else : ?>
                <?php _e( 'Please activate Sell Media plugin to use this page.', 'onesie_pro' ); ?>
            <?php endif; ?>

        </div><!-- #content .site-content -->
    </div>
</div><!-- #primary .content-area -->
<?php get_footer(); ?>