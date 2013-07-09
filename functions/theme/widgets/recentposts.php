<?php

/*------------------------------------------*/
/* WPZOOM: Recent Posts           */
/*------------------------------------------*/
 
class Wpzoom_Feature_Posts extends WP_Widget {
	
	function Wpzoom_Feature_Posts() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'feature-posts', 'description' => 'A list of posts, optionally filtered by category.' );

		/* Widget control settings. */
		$control_ops = array( 'id_base' => 'wpzoom-feature-posts' );

		/* Create the widget. */
		$this->WP_Widget( 'wpzoom-feature-posts', 'WPZOOM: Recent Posts', $widget_ops, $control_ops );
	}
	
	function widget( $args, $instance ) {
		
		extract( $args );

		/* User-selected settings. */
		$title 			= apply_filters('widget_title', $instance['title'] );
		$category 		= $instance['category'];
		$show_count 	= $instance['show_count'];
		$showDate = $instance['datetime'];
		$showComments = $instance['comments'];

		$widget_style = $instance['widget_style'];
		
		$pos = strpos($before_widget,'widget ');
		$before_widget=substr_replace($before_widget, 'widget-' . $widget_style . ' ', $pos, 0);

		echo $before_widget;
		
		/* Title of widget (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;
		

		echo '<ul class="posts posts-archive posts-side">';
		
		$query_opts = apply_filters('wpzoom_query', array(
			'posts_per_page' => $show_count,
			'post_type' => 'post'
		));
		if ( $category ) $query_opts['cat'] = $category;
		
		query_posts($query_opts);
		if ( have_posts() ) : while ( have_posts() ) : the_post(); 
		unset($prev, $image); 
		?>
			<li>
				<?php
				get_the_image( array( 'size' => 'loop-main', 'width' => 210, 'height' => 100, 'before' => '<div class="post-cover">', 'after' => '</div>' ) );
				?>

				<div class="post-excerpt">
					<h2><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'wpzoom' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title_attribute(); ?></a></h2>
					<?php if ($showDate == 'on' || $showComments == 'on') { ?>
					<p class="post-meta">
						<span>
							<?php if ($showDate == 'on') { ?><time datetime="<?php the_time("Y-m-d"); ?>" pubdate><?php the_time("jS F Y"); ?></time><?php $prev = TRUE; } ?>
							<?php if ($showComments == 'on') { if ($prev) {echo ' / '; } ?><?php comments_popup_link( __('0 comments', 'wpzoom'), __('1 comment', 'wpzoom'), __('% comments', 'wpzoom'), '', ''); } ?>
						</span>
					</p><!-- .post-meta -->
					<?php } ?>
				</div><!-- .post-excerpt -->
			<div class="cleaner">&nbsp;</div>
			</li>
			<?php
			endwhile; endif;
			
			//Reset query_posts
			wp_reset_query();			
		echo '</ul>';

		/* After widget (defined by themes). */
		echo $after_widget;
	}
	
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags (if needed) and update the widget settings. */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['category'] = $new_instance['category'];
		$instance['show_count'] = $new_instance['show_count'];
		$instance['datetime'] = $new_instance['datetime'];
		$instance['comments'] = $new_instance['comments'];
		$instance['widget_style'] = strip_tags($new_instance['widget_style']);

		return $instance;
	}
	
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => 'Widget Title', 'category' => 0, 'show_count' => 3, 'datetime' => 'on', 'comments' => 'on');
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">Widget Title:</label><br />
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" type="text" class="widefat" />
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
			<label for="<?php echo $this->get_field_id( 'category' ); ?>">Category:</label>
				<select id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>" style="width:90%;">
					<option value="0">- show from all categories -</option>
					<?php
					
					$cats = get_categories('hide_empty=0');
					foreach ($cats as $cat) {
					$option = '<option value="'.$cat->term_id;
					if ($cat->term_id == $instance['category']) { $option .='" selected="selected';}
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
		<br/>
		<input class="checkbox" type="checkbox" id="<?php echo $this->get_field_id('datetime'); ?>" name="<?php echo $this->get_field_name('datetime'); ?>" <?php if ($instance['datetime'] == 'on') { echo ' checked="checked"';  } ?> /> 
		<label for="<?php echo $this->get_field_id('datetime'); ?>"><?php _e('Display date', 'wpzoom'); ?></label>
		<br/>
		<input class="checkbox" type="checkbox" id="<?php echo $this->get_field_id('comments'); ?>" name="<?php echo $this->get_field_name('comments'); ?>" <?php if ($instance['comments'] == 'on') { echo ' checked="checked"';  } ?> /> 
		<label for="<?php echo $this->get_field_id('comments'); ?>"><?php _e('Display number of comments', 'wpzoom'); ?></label></p>
		
		<?php
	}
}

function wpzoom_register_fp_widget() {
	register_widget('Wpzoom_Feature_Posts');
}
add_action('widgets_init', 'wpzoom_register_fp_widget');