<?php
/**
 * The template used for displaying work section
 *
 * @package Onesie Pro
 */
?>
<?php
    if ( current_theme_supports( 'sell_media' ) ) {
        global $theme_options;

        if ( isset ( $theme_options['sellmedia_section'] ) && ( $theme_options['sellmedia_section'] == 'yes' ) ) { ?>

            <section id="sell-media-section" class="block">

                <h2 class="section-title">
                    <?php $obj = get_post_type_object( 'sell_media_item' ); echo ucfirst( $obj->rewrite['slug'] ); ?>
                </h2>

                <?php echo do_shortcode( '[sell_media_all_items show=9]' ); ?>

            </section>
        <?php }
    }
?>