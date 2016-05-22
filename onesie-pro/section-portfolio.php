<?php
/**
 * The template used for displaying portfolio section
 *
 * @package Onesie Pro
 */
?>

<div class="flexsliders">
  <ul class="slides clearfix">
	<?php
	$term_args = array(
			'hideempty' => 1,
			'orderby' => 'description'
	);
	$term_objs = get_terms('genre',$term_args);
	foreach ($term_objs as $term_obj) :
	$term_name = $term_obj->name;
	$term_slug = $term_obj->slug;
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
							'terms'    => $term_name,
						),
						array(
							'taxonomy' => 'genre',
							'field'    => 'name',
							'terms'    => 'work',
							'operator' => 'NOT IN',
						),
					),
			);
		
			$temp = $wp_query;
			$wp_query = null;
		
			$wp_query = new WP_Query();
			$wp_query->query( $args );
		
			?>
			<?php if ( $wp_query->have_posts() ) : ?>
			<li data-thumb="<?php echo get_template_directory_uri(); ?>/images/portfolio/<?php echo $term_slug; ?>.png">
				<section id="portfolio" class="block">
					<h2 class="section-title">
						<?php _e('Portfolio', 'onesie_pro'); ?> <?php echo $term_name; ?>
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
			
			<?php // PW付き出力 ログインしている場合のみ表示
				if( $term_slug == "web" && is_user_logged_in() ):
			?>
				<?php get_template_part( 'section', 'portfolio_work' ); ?>	
			<?php endif; ?>
			
			</li>
			
		<?php } ?>
	<?php endforeach; ?>
  </ul>
</div>
