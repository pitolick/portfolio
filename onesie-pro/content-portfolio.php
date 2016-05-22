<?php
/**
 * The template used for displaying portfolio content
 *
 * @package Onesie Pro
 * @since Onesie Pro 1.0
 */
?>

<?php
$attachment_id = get_post_thumbnail_id( $post->ID );
$attachment_link = get_post_meta( $attachment_id , '_gpp_custom_url', true );
$attachment_url = wp_get_attachment_image_src( $attachment_id, 'large' );
$attachment_caption = get_post_field( 'post_excerpt', $attachment_id );
?>
<?php
$onesie_pro_date = get_post_meta( get_the_ID(), '_onesie_pro_portfolio_year', true );
$onesie_pro_client = get_post_meta( get_the_ID(), '_onesie_pro_portfolio_client', true );
$onesie_pro_clienturl = get_post_meta( get_the_ID(), '_onesie_pro_portfolio_url', true );

$onesie_pro_comment = get_field('comment');
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<figure>

		<?php  if ( (is_object_in_term($post->ID, 'genre','web') && ! empty( $onesie_pro_clienturl ) || is_object_in_term($post->ID, 'genre','work') && ! empty( $onesie_pro_clienturl )) ) : ?>
			<div class="entry-image">
				<a href="<?php echo esc_url( $onesie_pro_clienturl ); ?>" title="<?php the_title(); ?>" target="_blank">
					<?php echo do_shortcode('[browser-shot url="'. esc_url( $onesie_pro_clienturl ).'" width="420" height="300"]'); ?>
				</a>
			</div>

		<?php  elseif ( has_post_thumbnail() ) : ?>
			<div class="entry-image">
				<?php /*<a href="<?php echo $attachment_url[0]; ?>" title="<?php echo $attachment_caption; ?>" rel="bookmark" class="gallery-item">
					<span class="genericon genericon-fullscreen"></span>
				</a> */ ?>
				<a href="<?php echo $attachment_url[0]; ?>" title="<?php echo $attachment_caption; ?>" rel="bookmark" class="gallery-item">
					<?php the_post_thumbnail( onesie_pro_image_orientation() ); ?>
				</a>
			</div>
		<?php endif; ?>

		<figcaption>
			<?php  if ( (is_object_in_term($post->ID, 'genre','web') && ! empty( $onesie_pro_clienturl ) || is_object_in_term($post->ID, 'genre','work') && ! empty( $onesie_pro_clienturl )) ) : ?>
				<h3><a href="<?php echo esc_url( $onesie_pro_clienturl ); ?>" title="<?php the_title(); ?>" target="_blank"><?php the_title(); ?></a></h3>
			<?php  else : ?>
				<h3><?php /*<a href="<?php the_permalink(); ?>"><?php */the_title(); /*?></a>*/?></h3>
			<?php endif; ?>
			<span class="portfolio-meta-block">

				<?php
				if( $onesie_pro_client != "" ) {
					if( $onesie_pro_clienturl != "" ) { echo '<div class="portfolio-meta">' . __( '<!--Client: -->', 'onesie_pro' ) . $onesie_pro_client . '</div>'; }
				}
				if( $onesie_pro_date != "" ){ echo '<div class="portfolio-meta">' . __( '<!--Date: -->', 'onesie_pro' ) . $onesie_pro_date . '</div>'; }
				
				if( $onesie_pro_comment != "" ){ echo '<div class="portfolio-meta">' . __( '<!--Date: -->', 'onesie_pro' ) . $onesie_pro_comment . '</div>'; }

				// 担当出力
				//echo '<div class="portfolio-meta charge">' . get_the_term_list( $post->ID, 'charge', '', ' ', '' ) . '</div>';
				$terms_charge = get_the_terms( $post->ID, 'charge' );
				if ( !empty($terms_charge) ) {
					if ( !is_wp_error( $terms_charge ) ) {
						echo '<div class="portfolio-meta charge">';
						foreach( $terms_charge as $term_charge ) {
							echo '<span>'.$term_charge->name.'</span>';
						}
						echo '</div>';
					}
				}
				
				// ツール出力
				//echo '<div class="portfolio-meta tool">' . get_the_term_list( $post->ID, 'tool', '', ' ', '' ) . '</div>';
				$terms_tool = get_the_terms( $post->ID, 'tool' );
				if ( !empty($terms_tool) ) {
					if ( !is_wp_error( $terms_tool ) ) {
						echo '<div class="portfolio-meta tool">';
						foreach( $terms_tool as $term_tool ) {
							echo '<span>'.$term_tool->name.'</span>';
						}
						echo '</div>';
					}
				}
			
				// Adobe出力
				$terms_adobe = get_the_terms( $post->ID, 'adobe' );
				if ( !empty($terms_adobe) ) {
					if ( !is_wp_error( $terms_adobe ) ) {
						echo '<ul class="portfolio-adobe clearfix">';
						foreach( $terms_adobe as $term_adobe ) {
							echo '<li><img src="'.get_template_directory_uri().'/images/adobe/'.$term_adobe->slug.'.png" alt="'.$term_adobe->name .'" /></li>';
						}
						echo '</ul>';
					}
				}
				
				echo '<div class="portfolio-meta">' . get_the_term_list( $post->ID, 'pcategory', 'Categories: ', ', ', '' ) . '</div>';
				echo get_the_term_list( $post->ID, 'ptag', 'Tags: ', ', ', '' ); ?>

			</span>
			<?php if ( ! empty( $onesie_pro_clienturl ) ) { ?>
				<a href="<?php echo esc_url( $onesie_pro_clienturl ); ?>" title="<?php the_title(); ?>" target="_blank" ><span class="genericon genericon-external"></span></a>
			<?php } ?>
		</figcaption>
	</figure>
</article>