<?php
/*
Template Name: Sell Media Items
*/
get_header(); ?>

<section id="primary" class="clearfix sell-media">
    <div id="content" role="main">
        <header class="page-header">
            <h1 class="entry-title"><?php the_title(); ?></h1>
        </header><!-- .entry-header -->
    <?php
    global $paged, $theme_options;
    if ( get_query_var('paged') ) {
        $paged = get_query_var('paged');
    } elseif ( get_query_var('page') ) {
        $paged = get_query_var('page');
    } else {
        $paged = 1;
    }
    ?>
    <div id="content-inner">
        <?php if ( current_theme_supports( 'sell_media' ) ) : ?>

                <?php
                $args = array(
                    'post_type' => 'sell_media_item',
                    'post_status' => 'publish',
                    'paged' => $paged,
                    'orderby' => $theme_options['sellmedia_orderby'],
                    'order' => $theme_options['sellmedia_order']
                );

                $sm_query = null;

                $sm_query = new WP_Query();
                $sm_query->query( $args );
                ?>

                <?php if ( $sm_query->have_posts() ) : ?>

                <section id="sellmediahome sell-media">

                    <div class="portfolios grid">
                        <div class="sell-media-grid-container">
                            <ul class='gallery'>
                            <?php $i = 0; ?>
                            <?php while ( $sm_query->have_posts() ) : $sm_query->the_post(); $i++; ?>
                                <?php global $post; ?>
                                <?php
                                $attachment_id = get_post_thumbnail_id( $post->ID );
                                $attachment_link = get_post_meta( $attachment_id , '_gpp_custom_url', true );
                                $attachment_url = wp_get_attachment_image_src( $attachment_id, 'large' );
                                $attachment_caption = get_post_field( 'post_excerpt', $attachment_id );
                                ?>
                                <li class="sell-media-grid portfolio">
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
                                            <?php sell_media_item_icon( $attachment_id, onesie_pro_image_orientation() ); ?>
                                            </a>
                                        </div>

                                        <figcaption>
                                            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

                                            <?php sell_media_item_buy_button( $post->ID, 'text', 'Buy' ); ?>
                                        </figcaption>
                                    </figure>
                                </li>
                            <?php endwhile; ?>
                            </ul>
                        </div>
                    </div> <!-- .portfolios grid -->
                </section><!-- #sellmediahome -->
                <?php sell_media_pagination_filter(); ?>
            <?php endif; wp_reset_query(); $args = null; $i = 0; ?>
            <?php edit_post_link( __( 'Edit', 'onesie_pro' ), '<p class="edit-link">', '</p>' ); ?>
        <?php endif; ?>

    </div><!-- #content -->
</section><!-- #primary -->

<?php get_footer(); ?>