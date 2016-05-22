<?php
/*
Template Name: Blog - Grid Layout
*/
get_header(); ?>

<?php
global $theme_options, $paged, $more;
$cat = get_category_by_slug( $theme_options['blog_cat'] );
$category_id = $cat->term_id;

$more = 0;
if ( get_query_var('paged') ) {
	$paged = get_query_var('paged');
} elseif ( get_query_var('page') ) {
	$paged = get_query_var('page');
} else {
	$paged = 1;
}
	$args = array(
	'paged' => $paged,
	'cat' => $category_id
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
		<?php if ( have_posts() ) : ?>
			<div class="gallery clearfix">
				<?php while ( $wp_query -> have_posts() ) : $wp_query -> the_post(); ?>

	                <?php $do_not_duplicate = $post -> ID; ?>
					<?php $post_format = get_post_format( $post->ID ); ?>
					<?php global $post; ?>
					<?php
					$attachment_id = get_post_thumbnail_id( $post->ID );
					$attachment_url = wp_get_attachment_image_src( $attachment_id, 'large' );
					$attachment_caption = get_post_field( 'post_excerpt', $attachment_id );
					?>
					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<figure>
							<?php  if ( has_post_thumbnail() ) : ?>
								<div class="entry-image">
									<a href="<?php echo $attachment_url[0]; ?>" title="<?php echo $attachment_caption; ?>" rel="bookmark" class="gallery-blog-item">
									<?php the_post_thumbnail( onesie_pro_image_orientation() ); ?>
									</a>
								</div>
							<?php endif; ?>

							<figcaption>
								<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
								<span><?php the_excerpt(); ?></span>
							</figcaption>
						</figure>
					</article>

				<?php endwhile; onesie_pro_paging_nav(); wp_reset_query(); $wp_query = $temp; ?>
			</div>
			<?php edit_post_link( __( 'Edit', 'onesie_pro' ), '<p class="edit-link">', '</p>' ); ?>
		<?php else : ?>

			<?php get_template_part( 'content', 'none' ); ?>
		
		<?php endif; ?>

	</main><!-- #main -->
</section><!-- #primary -->

<?php get_footer(); ?>