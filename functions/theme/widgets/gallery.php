<?php

/*------------------------------------------*/
/* WPZOOM: Gallery		*/
/*------------------------------------------*/

class wpzoom_widget_gallery extends WP_Widget {

	/* Widget setup. */
	function wpzoom_widget_gallery() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'wpzoom', 'description' => __('Custom WPZOOM widget. Displays the featured images of posts from a category in a slider. Insert only into Homepage: Content Widgets sidebar.', 'wpzoom') );
		
		/* Widget control settings. */
		$control_ops = array( 'width' => 250, 'height' => 350, 'id_base' => 'wpzoom-widget-gallery' );
		
		/* Create the widget. */
		$this->WP_Widget( 'wpzoom-widget-gallery', __('WPZOOM: Gallery', 'wpzoom'), $widget_ops, $control_ops );
	}
	
	/* How to display the widget on the screen. */
	function widget( $args, $instance ) {
	
		extract( $args );
		
		/* Our variables from the widget settings. */

		$category1 = get_category($instance['category1']);
		if ($category1) {
			$categoryLink1 = get_category_link($category1);
		}
	
		$title = apply_filters('widget_title', $instance['title'] );
		$show_count 	= $instance['show_count'];
		$show_post_id = $instance['show_post_id'];
	
		$widget_style = $instance['widget_style'];
		
		$pos = strpos($before_widget,'widget ');
		$before_widget=substr_replace($before_widget, 'widget-' . $widget_style . ' ', $pos, 0);

		echo $before_widget;
		
		$default_image = get_bloginfo('template_url') . '/images/x.gif';

		/* Title of widget (before and after defined by themes). */
		if ( $title )
			echo $before_title . '<a href="' . $categoryLink1 . '">' . $title . '</a>' . $after_title;
			
			$i = 0;

			if (!$show_post_id && $instance['category1']) {

				$loop = new WP_Query( array( 'posts_per_page' => $show_count, 'orderby' => 'date', 'order' => 'DESC', 'cat' => $instance['category1'] ) );

			} elseif ($show_post_id) {

				$arguments = array(
					'order'          => 'ASC',
					'orderby'          => 'menu_order',
					'post_type'      => 'attachment',
					'post_parent'    => $show_post_id,
					'post_mime_type' => 'image',
					'post_status'    => null,
					'numberposts'    => $show_count
				);
				
				$attachments = get_posts($arguments);

				// $loop = new WP_Query( array( 'post_type' => 'attachment', 'post_mime_type' => 'image', 'posts_per_page' => $show_count, 'orderby' => 'menu_order', 'order' => 'ASC', 'post_parent' => $show_post_id ) );
				
			}
			
			echo '<div class="featured-gallery-widget flexslider" id="' . $args['widget_id'] . '">';
			echo '<ul class="slides">';
			
			if (!$show_post_id && $instance['category1']) {
			
				while ( $loop->have_posts() ) : $loop->the_post(); $i++;
				?>
				
				<li class="slide">
					<?php get_the_image( array( 'size' => 'thumb-gallery-widget', 'width' => 100, 'height' => 65, 'default_image' => $default_image, 'before' => '<div class="post-cover">', 'after' => '</div>' ) ); ?>
				</li>
				
				<?php
				endwhile;
			
			} else {
			
				foreach ($attachments as $attachment) { 
				$img = wp_get_attachment_image_src($attachment->ID, 'large', false, false);
				?>
		
					<li class="slide">
						<a href="<?php echo $img[0]; ?>" rel="lightbox" title="<?php echo apply_filters( 'the_title', $attachment->post_title ); ?>">
						<?php echo wp_get_attachment_image($attachment->ID, 'thumb-gallery-widget'); ?></a>
					</li>
				<?php 
				} // foreach
			
			}

			echo '</ul>';
			echo '<div class="cleaner">&nbsp;</div>';

			echo '</div><!-- .featured-gallery-widget .flexslider -->';

			?>
			<script type="text/javascript">
			jQuery(document).ready(function() {
				
				jQuery("#<?php echo $args['widget_id']; ?>").flexslider({
					controlNav: true,
					directionNav: false,
			        animation: "slide",
					animationLoop: true,
					itemWidth: 113,
					itemMargin: 0,
					move: 4,
			        slideshow: false,
					pauseOnAction: true,
					touch: false,
			        animationSpeed: 500
			    });	 
			
			});
			</script>
			<?php
			
		/* After widget (defined by themes). */
		echo $after_widget; 

		wp_reset_query();  
		}
	
		/* Update the widget settings.*/
		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
	
			/* Strip tags for title and name to remove HTML (important for text inputs). */
			$instance['title'] = strip_tags( $new_instance['title'] );
			$instance['category1'] = (int) $new_instance['category1'];
			$instance['show_count'] = (int) $new_instance['show_count'];
			$instance['show_post_id'] = (int) $new_instance['show_post_id'];
			$instance['widget_style'] = strip_tags($new_instance['widget_style']);
	 
			return $instance;
		}
	
		/** Displays the widget settings controls on the widget panel.
		 * Make use of the get_field_id() and get_field_name() function when creating your form elements. This handles the confusing stuff. */
		function form( $instance ) {
	
			/* Set up some default widget settings. */
			$defaults = array('title' => 'Widget Title','category1' => '0');
			$instance = wp_parse_args( (array) $instance, $defaults );
	    ?>
	
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>">Widget Title:</label><br />
				<input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:90%;" />
			</p>

			<p>
				<label for="<?php echo $this->get_field_id( 'widget_style' ); ?>">Widget Color Scheme:</label>
				<select id="<?php echo $this->get_field_id( 'widget_style' ); ?>" name="<?php echo $this->get_field_name( 'widget_style' ); ?>">
					<option value="0"<?php if (!$instance['widget_style'] || $instance['widget_style'] == '0') { echo ' selected="selected"';} ?>>Basic</option>
					<option value="blue"<?php if ($instance['widget_style'] == 'blue') { echo ' selected="selected"';} ?>>Blue</option>
					<option value="gold"<?php if ($instance['widget_style'] == 'gold') { echo ' selected="selected"';} ?>>Gold</option>
					<option value="grey"<?php if ($instance['widget_style'] == 'grey') { echo ' selected="selected"';} ?>>Grey</option>
				</select>
			</p>

			<p>
				<?php _e('Category:', 'wpzoom'); ?>
				<select id="<?php echo $this->get_field_id('category1'); ?>" name="<?php echo $this->get_field_name('category1'); ?>" style="width:90%;">
					<option value="0">Choose category:</option>
					<?php
					$cats = get_categories('hide_empty=0');
					
					foreach ($cats as $cat) {
					$option = '<option value="'.$cat->term_id;
					if ($cat->term_id == $instance['category1']) { $option .='" selected="selected';}
					$option .= '">';
					$option .= $cat->cat_name;
					$option .= ' ('.$cat->category_count.')';
					$option .= '</option>';
					echo $option;
					}
				?>
				</select>
			</p>

			<p>
				<label for="<?php echo $this->get_field_id( 'show_count' ); ?>">Show:</label>
				<input id="<?php echo $this->get_field_id( 'show_count' ); ?>" name="<?php echo $this->get_field_name( 'show_count' ); ?>" value="<?php echo $instance['show_count']; ?>" type="text" size="2" /> posts
			</p>

			<p>
				<label for="<?php echo $this->get_field_id( 'show_post_id' ); ?>">Display Post Instead (ID):</label><br />
				<input type="text" id="<?php echo $this->get_field_id( 'show_post_id' ); ?>" name="<?php echo $this->get_field_name( 'show_post_id' ); ?>" value="<?php echo $instance['show_post_id']; ?>" style="width:90%;" />
			</p>

		<?php
		}
}

add_action('widgets_init', create_function('', 'return register_widget("wpzoom_widget_gallery");'));

?>