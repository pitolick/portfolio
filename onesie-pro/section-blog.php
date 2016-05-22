<?php
/**
 * The template used for displaying work section
 *
 * @package Onesie Pro
 */
?>
<?php
global $theme_options;
// Get Portfolio Category
if ( isset ( $theme_options['blog_cat'] ) && ! empty ( $theme_options['blog_cat'] ) ) {
	$cat = get_category_by_slug( $theme_options['blog_cat'] );
	$category_id = $cat->term_id;
}

if ( isset ( $category_id ) ) : ?>
	<?php
	$args = array(
		'posts_per_page' => 3,
		'category' => $category_id
		);
	$section_posts = get_posts( $args );

?>

	<section id="blog" class="block">
		<h2 class="section-title">
			<?php echo $cat->name; ?>
		</h2>

		<div class="gallery">
			<?php foreach ( $section_posts as $post ) : setup_postdata( $post ); ?>
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
			<?php endforeach; ?>
		</div>
	</section>
<?php endif; ?>