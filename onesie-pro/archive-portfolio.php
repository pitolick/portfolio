<?php
/**
 * The template for displaying Portfolio Archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Onesie Pro
 */

get_header(); ?>

<div id="content" class="site-content">

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<h1 class="page-title archive-title">Portfolio</h1>
			</header><!-- .page-header -->

			<div class="gallery clearfix">
				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content', 'portfolio' ); ?>

				<?php endwhile; ?>

			</div>
			<?php onesie_pro_paging_nav(); ?>

		<?php else : ?>

			<?php get_template_part( 'content', 'none' ); ?>

		<?php endif; ?>

			</main><!-- #main -->
		</div><!-- #primary -->

	</div><!-- #content -->
<?php get_footer(); ?>