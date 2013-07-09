<?php

/*------------------------------------------*/
/* WPZOOM: Featured Category		*/
/*------------------------------------------*/

class wpzoom_widget_feat_category extends WP_Widget {

	/* Widget setup. */
	function wpzoom_widget_feat_category() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'wpzoom', 'description' => __('Custom WPZOOM widget. Displays posts from a category in 2 columns. Insert only into Homepage: Content Widgets sidebar.', 'wpzoom') );
		
		/* Widget control settings. */
		$control_ops = array( 'width' => 250, 'height' => 350, 'id_base' => 'wpzoom-widget-feat-category' );
		
		/* Create the widget. */
		$this->WP_Widget( 'wpzoom-widget-feat-category', __('WPZOOM: Featured Category', 'wpzoom'), $widget_ops, $control_ops );
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
		$widget_style = $instance['widget_style'];
		
		$pos = strpos($before_widget,'widget ');
		$before_widget=substr_replace($before_widget, 'widget-' . $widget_style . ' ', $pos, 0);

		echo $before_widget;

		/* Title of widget (before and after defined by themes). */
		if ( $title ) {
			if ($categoryLink1) {
				?><span class="read-more"><a class="invert" href="<?php echo $categoryLink1; ?>" rel="nofollow"><?php _e('view more posts','wpzoom'); ?></a></span><?php
				echo $before_title . '<a href="' . $categoryLink1 . '">' . $title . '</a>' . $after_title;
			}
			else {
				echo $before_title . $title . $after_title;
			}
		}
			
			$i = 0;
			$loop = new WP_Query( array( 'posts_per_page' => $show_count, 'orderby' => 'date', 'order' => 'DESC', 'cat' => $instance['category1'] ) );
			
			echo '<div class="featured-category-widget">';
			
			while ( $loop->have_posts() ) : $loop->the_post(); $i++;

			if ($i == 1) { ?>
			
			<div class="post-main posts-archive">
			
			<?php
				get_the_image( array( 'size' => 'loop-main', 'width' => 210, 'height' => 100, 'before' => '<div class="post-cover">', 'after' => '</div>' ) );
			?>

				<p class="post-meta"><time datetime="<?php the_time("Y-m-d"); ?>" pubdate><?php printf( __('%s', 'wpzoom'),  get_the_date()); ?></time></p>
				<h2><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title_attribute(); ?></a></h2>
				<?php the_excerpt(); ?>

			</div><!-- end .featured-category-post post-main -->

			<ul class="posts-archive posts-list">
			<?php
			} elseif ($i > 1) { ?>
			
				<li class="post-secondary">
					<h2><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title_attribute(); ?></a></h2>
					<?php the_excerpt(); ?>
				</li><!-- .post-secondary -->
			
			<?php }	?>
			
			<?php endwhile;
			
			if ($i > 0) {
			?>
			</ul><!-- end .posts-list -->
			<?php
			}
			
			echo '<div class="cleaner">&nbsp;</div>';
			echo '</div><!-- .featured-category-widget -->';
			
		/* After widget (defined by themes). */
		echo $after_widget; 

		wp_reset_query();  
		}
	
		/* Update the widget settings.*/
		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
	
			/* Strip tags for title and name to remove HTML (important for text inputs). */
			$instance['title'] = strip_tags( $new_instance['title'] );
			$instance['category1'] = $new_instance['category1'];
			$instance['show_count'] = $new_instance['show_count'];
			$instance['widget_style'] = strip_tags($new_instance['widget_style']);
	 
			return $instance;
		}
	
		/** Displays the widget settings controls on the widget panel.
		 * Make use of the get_field_id() and get_field_name() function when creating your form elements. This handles the confusing stuff. */
		function form( $instance ) {
	
			/* Set up some default widget settings. */
			$defaults = array('title' => 'Widget Title','category1' => 0,'show_count' => 3);
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

			<hr style="height: 1px; line-height: 1px; font-size: 1px; border: none; border-top: solid 1px #aaa; margin: 10px 0;" />		
	
			<p><label for="<?php echo $this->get_field_id( 'show_count' ); ?>">Show:</label>
			<input id="<?php echo $this->get_field_id( 'show_count' ); ?>" name="<?php echo $this->get_field_name( 'show_count' ); ?>" value="<?php echo $instance['show_count']; ?>" type="text" size="2" /> posts
			</p>
		<?php
		}
}

function wpzoom_register_fc_widget() {
	register_widget('wpzoom_widget_feat_category');
}
add_action('widgets_init', 'wpzoom_register_fc_widget');