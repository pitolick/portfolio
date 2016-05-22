<?php
/**
 * The template used for displaying about section
 *
 * @package Onesie Pro
 */
?>
<?php
global $theme_options;
if ( ! empty( $theme_options['about'] ) ) : ?>
	<section id="about" class="block">
		<?php query_posts( 'page_id=' . $theme_options['about'] ); while (have_posts()) : the_post(); ?>
			<h2 class="section-title"><?php the_title(); ?></h2>

			<div class="lead">
				<?php
			    global $more;
				$more = 0;
				the_content(''); ?>

				<?php if ( $pos=strpos($post->post_content, '<!--more-->') ) { ?>
					<a href="<?php the_permalink() ?>" class="btn btn-translucent"><span><?php _e('Read more','onesie_pro'); ?></span></a>
				<?php } ?>
			</div>
		<?php endwhile; wp_reset_query(); ?>
	</section>
<?php endif; ?>