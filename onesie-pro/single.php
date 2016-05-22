<?php
/**
 * The Template for displaying all single posts.
 *
 * @package Onesie Pro
 * @since Onesie Pro 1.0
 */

get_header(); ?>

		<section id="primary">

			<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

				<?php // onesie_pro_content_nav( 'nav-above' ); ?>

				<?php  get_template_part( 'content', get_post_format() ); ?>

				<?php onesie_pro_content_nav( 'nav-below' ); ?>

				<?php comments_template( '', true ); ?>

			<?php endwhile; // end of the loop. ?>

		</section><!-- #primary -->

<?php get_footer(); ?>