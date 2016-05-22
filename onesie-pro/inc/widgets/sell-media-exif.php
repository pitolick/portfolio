<?php class Sell_Media_Exif_Widget extends WP_Widget
{
    function Sell_Media_Exif_Widget(){
		$widget_ops = array('description' => 'Displays image exif data (shutter speed, aperture, ISO, etc). Only use this on Single Sidebar Widgetized areas.');
		$control_ops = array('width' => 200, 'height' => 200);
		parent::WP_Widget(false,$name='Sell Media Exif',$widget_ops,$control_ops);
    }

	/* Displays the Widget in the front-end */
    function widget($args, $instance){
		extract($args);
		$title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title']);
		extract($args);
		echo $before_widget;

		global $post;
		$imgdata = wp_get_attachment_metadata( get_post_meta( $post->ID, '_sell_media_attachment_id', true ) );
		if ( $imgdata) {
			if ( $title )
				echo $before_title . $title . $after_title;
	?>
			<div class="sell-media-exif-widget">
				<ul class="exif-info">

					<?php
					if ( $imgdata['image_meta']['camera'] ) { ?>
						<li class="camera"><div class="genericon genericon-small genericon-image"></div><span class="exif-title"><?php _e('Camera ', 'onesie_pro'); ?></span><?php echo $imgdata['image_meta']['camera']; ?></li>
					<?php } ?>

					<?php
					if ( $imgdata['image_meta']['aperture'] ) { ?>
						<li class="aperture"><div class="genericon genericon-small genericon-aside"></div><span class="exif-title"><?php _e('Apperture ', 'onesie_pro'); ?></span><?php echo 'f/' .  $imgdata['image_meta']['aperture']; ?></li>
					<?php } ?>

					<?php
					if ( $imgdata['image_meta']['focal_length'] ) { ?>
						<li class="focal-length"><div class="genericon genericon-small genericon-share"></div><span class="exif-title"><?php _e('Focal Length ', 'onesie_pro'); ?></span><?php echo $imgdata['image_meta']['focal_length']; ?></li>
					<?php } ?>

					<?php
					if ( $imgdata['image_meta']['shutter_speed'] ) { ?>
						<li class="shutter-speed"><div class="genericon genericon-small genericon-time"></div><span class="exif-title"><?php _e('Shutter Speed ', 'onesie_pro'); ?></span>
							<?php
							if ((1 / $imgdata['image_meta']['shutter_speed']) > 1) {
								echo "1/";
								if (number_format((1 / $imgdata['image_meta']['shutter_speed']), 1) == number_format((1 / $imgdata['image_meta']['shutter_speed']), 0)) {
									echo number_format((1 / $imgdata['image_meta']['shutter_speed']), 0, '.', '') . ' sec';
								} else {
									echo number_format((1 / $imgdata['image_meta']['shutter_speed']), 1, '.', '') . ' sec';
								}
								} else {
									echo $imgdata['image_meta']['shutter_speed'].' sec';
							}
							?>
						</li>
					<?php } ?>

					<?php
					if ( $imgdata['image_meta']['iso'] ) { ?>
						<li class="iso"><div class="genericon genericon-small genericon-maximize"></div><span class="exif-title"><?php _e('ISO ', 'onesie_pro'); ?></span><?php echo $imgdata['image_meta']['iso']; ?></li>
					<?php } ?>
					<?php
					if ( $imgdata['image_meta']['credit'] ) { ?>
						<li class="credit"><div class="genericon genericon-small genericon-user"></div><span class="exif-title"><?php _e('Credit ', 'onesie_pro'); ?></span><?php echo $imgdata['image_meta']['credit']; ?></li>
					<?php } ?>

					<?php
					if ( $imgdata['image_meta']['created_timestamp'] ) { ?>
						<li class="timestamp"><div class="genericon genericon-small genericon-month"></div><span class="exif-title"><?php _e('Date ', 'onesie_pro'); ?></span><?php echo date("M d, Y", $imgdata['image_meta']['created_timestamp']); ?></li>
					<?php } ?>

					<?php
					if ( $imgdata['image_meta']['copyright'] ) { ?>
						<li class="copyright"><div class="genericon genericon-small genericon-warning"></div><span class="exif-title"><?php _e('Copyright ', 'onesie_pro'); ?></span><?php echo $imgdata['image_meta']['copyright']; ?></li>
					<?php } else { ?>
						<li class="copyright"><div class="genericon genericon-small genericon-warning"></div><span class="exif-title"><?php _e('Copyright ', 'onesie_pro'); ?></span><?php the_time('Y '); _e('by ', 'onesie_pro'); bloginfo( 'name' ); ?><?php echo $imgdata['image_meta']['copyright']; ?></li>
					<?php } ?>

				</ul>

			</div><!-- .sell-media-exif-widget -->

			<?php
			echo $after_widget;
		
 		}

}
	/*Saves the settings. */
	function update($new_instance, $old_instance){
		$instance = $old_instance;
		$instance['title'] = stripslashes($new_instance['title']);

		return $instance;
	}

    /*Creates the form for the widget in the back-end. */
    function form($instance){
		//Defaults
		$instance = wp_parse_args( (array) $instance, array('title'=>'Stock photo details') );
		$title = htmlspecialchars($instance['title']);

		# Title
		echo '<p><label for="' . $this->get_field_id('title') . '">' . 'Title:' . '</label><input class="widefat" id="' . $this->get_field_id('title') . '" name="' . $this->get_field_name('title') . '" type="text" value="' . $title . '" /></p>';

	}

}

function Sell_Media_Exif_WidgetInit() {
	register_widget('Sell_Media_Exif_Widget');
}

add_action('widgets_init', 'Sell_Media_Exif_WidgetInit');
?>