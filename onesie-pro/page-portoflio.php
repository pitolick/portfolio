<?php
/*
Template Name: Portfolio
*/
get_header(); ?>

<?php
global $theme_options, $paged, $more;

if ( get_query_var('paged') ) {
	$paged = get_query_var('paged');
} elseif ( get_query_var('page') ) {
	$paged = get_query_var('page');
} else {
	$paged = 1;
}
$args = array(
	'post_type'=>'portfolio',
	'paged' => $paged
);

$temp = $wp_query;
$wp_query = null;

$wp_query = new WP_Query();
$wp_query->query( $args );

?>

<section id="primary" class="content-area blog-page">
	<main id="main" class="site-main grid-3" role="main">
		<header class="page-header">
			<h1 class="page-title">
				<?php the_title(); ?>
			</h1>
		</header><!-- .page-header -->
		<?php if ( $wp_query->have_posts() ) : ?>

			<div class='gallery'>

				<?php while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>

					<?php get_template_part( 'content', 'portfolio' ); ?>

				<?php endwhile; onesie_pro_paging_nav(); wp_reset_query(); $wp_query = $temp; ?>

			</div>

			<?php edit_post_link( __( 'Edit', 'onesie_pro' ), '<p class="edit-link">', '</p>' ); ?>

		<?php else : ?>

			<?php get_template_part( 'content', 'none' ); ?>

		<?php endif; ?>

	</main><!-- #main -->
</section><!-- #primary -->

<?php get_footer(); ?>
