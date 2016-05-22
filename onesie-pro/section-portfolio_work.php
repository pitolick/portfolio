<?php
/**
 * The template used for displaying portfolio section
 *
 * @package Onesie Pro
 */
?>

<?php
global $theme_options, $paged, $more;

if ( isset ( $theme_options['portfolio_section'] ) && ( $theme_options['portfolio_section'] == 'yes' ) ) {

	if ( get_query_var('paged') ) {
		$paged = get_query_var('paged');
	} elseif ( get_query_var('page') ) {
		$paged = get_query_var('page');
	} else {
		$paged = 1;
	}
	$args = array(
		'post_type'=>'portfolio',
		'paged' => $paged,
		'posts_per_page' => -1,
		'tax_query' => array(
				array(
					'taxonomy' => 'genre',
					'field'    => 'name',
					'terms'    => 'work',
				),
			),
	);

	$temp = $wp_query;
	$wp_query = null;

	$wp_query = new WP_Query();
	$wp_query->query( $args );

	?>
	<?php if ( $wp_query->have_posts() ) : ?>
		<section id="portfolio" class="block">
			<h2 class="section-title">
						<?php _e('Portfolio', 'onesie_pro'); ?> Work
			</h2>

			<div class="gallery">

				<?php while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>
									<?php $do_not_duplicate = $post->ID; ?>
					<?php global $post; ?>
					<?php get_template_part( 'content', 'portfolio' ); ?>
				<?php endwhile; wp_reset_query(); $wp_query = $temp; ?>

			</div>
		</section>
	<?php endif; ?>
	
<?php } ?>

