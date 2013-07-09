<?php

/*----------------------------------------------------------------------------------*/
/*  WPZOOM: Flickr Widget	
/*	 			
/*  Plugin URI: http://kovshenin.com/wordpress/plugins/quick-flickr-widget/
/*  Author: Konstantin Kovshenin
/*  Modified by WPZOOM
/*
/*----------------------------------------------------------------------------------*/


add_action('widgets_init', create_function('', 'return register_widget("wpzoom_Flickr");'));

	class wpzoom_Flickr extends WP_Widget {
		
		function wpzoom_Flickr() {
			/* Widget settings. */
			$widget_ops = array( 'classname' => 'flickr', 'description' => 'A reel of latest photos from Flickr' );
	
			/* Widget control settings. */
			$control_ops = array( 'id_base' => 'wpzoom-flickr' );
	
			/* Create the widget. */
			$this->WP_Widget( 'wpzoom-flickr', 'WPZOOM: Flickr', $widget_ops, $control_ops );
		}
		
		function widget( $args, $instance ) {
			extract( $args );
	
			/* User-selected settings. */
			$title = apply_filters('widget_title', $instance['title'] );
			$username = $instance['username'];
			$group = $instance['group'];
			$show_count = $instance['show_count'];
	
			$widget_style = $instance['widget_style'];
			
			$pos = strpos($before_widget,'widget ');
			$before_widget=substr_replace($before_widget, 'widget-' . $widget_style . ' ', $pos, 0);
	
			echo $before_widget;
	
			/* Title of widget (before and after defined by themes). */
			if ( $title ) {
				echo $before_title . $title . $after_title;
			}
			
			echo '<div id="flickr_badge_wrapper" class="clearfix">';
					if ($username) { echo '<script type="text/javascript" src="http://www.flickr.com/badge_code_v2.gne?count='.$show_count.'&display=latest&size=s&layout=x&source=user&user='.$username.'"></script>'; }
					elseif ($group) { echo '<script type="text/javascript" src="http://www.flickr.com/badge_code_v2.gne?count='.$show_count.'&display=latest&size=s&layout=x&source=group&group='.$group.'"></script>'; }
				echo '</div>';
	
			/* After widget (defined by themes). */
			echo $after_widget;
		}
		
		function update( $new_instance, $old_instance ) {
			
            $instance = $old_instance;
	
			/* Strip tags (if needed) and update the widget settings. */
			$instance['title'] = strip_tags( $new_instance['title'] );
			$instance['username'] = $new_instance['username'];
			$instance['group'] = $new_instance['group'];
			$instance['show_count'] = $new_instance['show_count'];
			$instance['widget_style'] = strip_tags($new_instance['widget_style']);
	
			return $instance;
		}
		
		function form( $instance ) {
	
			/* Set up some default widget settings. */
			$defaults = array( 'title' => 'Recent Photos', 'username' => '', 'show_count' => 10 );
			$instance = wp_parse_args( (array) $instance, $defaults ); ?>
			
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label><br />
				<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>"  />
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
				<label for="<?php echo $this->get_field_id( 'username' ); ?>">Flickr Username ID:</label>
				<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'username' ); ?>" name="<?php echo $this->get_field_name( 'username' ); ?>" value="<?php echo $instance['username']; ?>" /><br />
				<span class="description" style="font-size:11px;">Find your Flickr ID: <a href="http://www.idgettr.com" target="_blank">idGettr</a></span>
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id( 'group' ); ?>">Flickr Group ID:</label>
				<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'group' ); ?>" name="<?php echo $this->get_field_name( 'group' ); ?>" value="<?php echo $instance['group']; ?>" /><br />
				<span class="description" style="font-size:11px;">Find your Flickr ID: <a href="http://www.idgettr.com" target="_blank">idGettr</a></span>
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id( 'show_count' ); ?>">Show:</label>
				<input type="text" size="2" id="<?php echo $this->get_field_id( 'show_count' ); ?>" name="<?php echo $this->get_field_name( 'show_count' ); ?>" value="<?php echo $instance['show_count']; ?>" /> photos
			</p>
	
			<?php
		}
	}
 ?>