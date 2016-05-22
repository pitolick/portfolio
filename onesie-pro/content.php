
<?php
/**
 * @package Onesie Pro
 */
?>

<?php do_action( 'onesie_pro_before_article' ); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
        <?php do_action( 'onesie_pro_before_title' ); ?>
        <?php if ( is_singular() ) { ?>
            <h1 class="entry-title"><?php the_title(); ?></h1>
        <?php } else { ?>
            <h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php esc_attr( sprintf( __( 'Permalink to %s', 'onesie_pro' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
        <?php } ?>
        <?php do_action( 'onesie_pro_after_title' ); ?>
    </header><!-- .entry-header -->


    <?php if ( is_search() ) : // Only display Excerpts for Search ?>
    <div class="entry-summary">
        <?php do_action( 'onesie_pro_before_content' ); ?>
        <?php the_content( __('Read More', 'onesie_pro') ); ?>
        <?php do_action( 'onesie_pro_after_content' ); ?>
    </div><!-- .entry-summary -->
    <?php else : ?>
    <div class="entry-content">
        <?php do_action( 'onesie_pro_before_content' ); ?>
        <?php the_content( __('Read More', 'onesie_pro' ) ); ?>
        <?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'onesie_pro' ), 'after' => '</div>' ) ); ?>
        <?php do_action( 'onesie_pro_after_content' ); ?>
    </div><!-- .entry-content -->
    <?php endif; ?>

    <?php get_template_part( 'entry', 'footer' ); ?>

</article><!-- #post-<?php the_ID(); ?> -->
<?php do_action( 'onesie_pro_after_article' ); ?>