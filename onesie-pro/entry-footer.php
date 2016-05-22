<?php
/**
 * The template for displaying posts footers
 *
 * @package Onesie Pro
 * @since Onesie Pro 1.0
 */
?>

<footer class="entry-meta clearfix"<?php if ( is_front_page() ) { ?> <?php } ?>>

    <?php do_action( 'onesie_pro_before_meta' ); ?>


        <?php if ( is_singular() && get_post_type() == "portfolio" ) { ?>
            <?php
            $onesie_pro_date = get_post_meta( get_the_ID(), '_onesie_pro_portfolio_year', true );
            $onesie_pro_client = get_post_meta( get_the_ID(), '_onesie_pro_portfolio_client', true );
            $onesie_pro_clienturl = get_post_meta( get_the_ID(), '_onesie_pro_portfolio_url', true ); ?>

            <?php
            if ( $onesie_pro_client != "" ) {
                echo '<span class="portfolio-meta">' . __( 'Client: ', 'onesie_pro' );
                if ( $onesie_pro_clienturl != "" ) { echo '<a href="' . $onesie_pro_clienturl . '">'; }
                    echo $onesie_pro_client;
                if ( $onesie_pro_clienturl != "" ) { echo '</a>'; }
                echo '</span>';
            }
            if ( $onesie_pro_date != "" ){ echo '<span class="portfolio-meta">' . __( 'Date: ', 'onesie_pro' ) . $onesie_pro_date . '</span>';
            }

            echo '<span class="portfolio-meta">' . get_the_term_list( $post->ID, 'pcategory', 'Categories: ', ', ', '' ) . '</span>';
            echo '<span class="portfolio-meta">' . get_the_term_list( $post->ID, 'ptag', 'Tags: ', ', ', '' ) . '</span>'; ?>


        <?php } elseif ( is_singular() && get_post_type() == "post" ){ ?>

            <?php echo '<span class="portfolio-meta">Categories: ' . get_the_category_list( __( ', ', 'onesie_pro' ) ) . '</span>'; ?>
            <?php echo '<span class="portfolio-meta">' . the_tags() . '</span>'; ?>

        <?php } ?>

        <?php if( ( get_post_type( $post->ID ) == "post" || is_search()) && is_single() ) { ?>
            <span class="portfolio-meta">
                <?php onesie_pro_pub_date(); ?>
            </span>
        <?php } ?>
        <?php if ( is_singular() ) : ?>
            <?php edit_post_link( __( 'Edit', 'onesie_pro' ), '<span class="edit-link">', '</span>' ); ?>
        <?php endif; ?>


        <?php if ( comments_open() || ( '0' != get_comments_number() && ! comments_open() ) ) : ?> <span class="genericon genericon-comment"></span>
            <?php comments_popup_link( __( 'Leave a comment', 'onesie_pro' ), __( '1', 'onesie_pro' ), __( '%', 'onesie_pro' ), 'comments-link' ); ?>
        <?php endif; ?>


    <?php do_action( 'onesie_pro_after_meta' ); ?>

</footer><!-- #entry-meta -->