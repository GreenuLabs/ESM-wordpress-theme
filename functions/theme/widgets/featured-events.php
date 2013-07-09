<?php

/*------------------------------------------*/
/* WPZOOM: Featured Events		*/
/*------------------------------------------*/

class wpzoom_widget_feat_events extends WP_Widget {

	/* Widget setup. */
	function wpzoom_widget_feat_events() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'wpzoom', 'description' => __('Custom WPZOOM widget. Displays a list of events.', 'wpzoom') );
		
		/* Widget control settings. */
		$control_ops = array( 'width' => 250, 'height' => 350, 'id_base' => 'wpzoom-widget-feat-events' );
		
		/* Create the widget. */
		$this->WP_Widget( 'wpzoom-widget-feat-events', __('WPZOOM: Upcoming Events', 'wpzoom'), $widget_ops, $control_ops );
	}
	
	/* How to display the widget on the screen. */
	function widget( $args, $instance ) {
	
		extract( $args );
		
		/* Our variables from the widget settings. */

		$title = apply_filters('widget_title', $instance['title'] );
		$widget_style = $instance['widget_style'];
		$showExcerpt = $instance['excerpt'];
		$num = $instance['num'];
		
		$pos = strpos($before_widget,'widget ');
		$before_widget=substr_replace($before_widget, 'widget-' . $widget_style . ' ', $pos, 0);

		echo $before_widget;

		if ( !empty($instance['title']) )
			echo $args['before_title'] . $instance['title'] . $args['after_title'];
			
		$current_time = current_time('mysql');
		list( $today_year, $today_month, $today_day, $hour, $minute, $second ) = split( '([^0-9])', $current_time );
		$current_timestamp = $today_year . $today_month . $today_day . $hour . $minute;
		
		$meta_query = array(
			array(
				'key' => '_start_eventtimestamp',
				'value' => $current_timestamp,
				'compare' => '>'
			)
		);
		
		$args = array( 
			'post_type' => 'event',
			'meta_query' => $meta_query,
			'meta_key' => '_start_eventtimestamp',
			'orderby'=> 'meta_value_num',
			'order' => 'ASC',
			'posts_per_page' => $num,
		);

		$events = new WP_Query( $args );
		
		if ( $events->have_posts() ) :
		?>
		<ul class="events-list">
		<?php
		
		while ( $events->have_posts() ) : $events->the_post();
		global $post; 
		unset($same_day,$same_time,$postMeta);
		
		$postMeta = get_post_custom($post->ID);
		
		$event_start_day = $postMeta['_start_day'][0];
		$event_start_month = $postMeta['_start_month'][0];
		$event_start_year = $postMeta['_start_year'][0];
		$event_end_day = $postMeta['_end_day'][0];
		$event_end_month = $postMeta['_end_month'][0];
		$event_end_year = $postMeta['_end_year'][0];
		$event_start_hour = $postMeta['_start_hour'][0];
		$event_start_minute = $postMeta['_start_minute'][0];
		$event_end_hour = $postMeta['_end_hour'][0];
		$event_end_minute = $postMeta['_end_minute'][0];
		
		$metaDateStart = "$event_start_day/$event_start_month/$event_start_year";
		$metaDateEnd = "$event_end_day/$event_end_month/$event_end_year";
		$metaTimeStart = "$event_start_hour:$event_start_minute";
		$metaTimeEnd = "$event_end_hour:$event_end_minute";
		$isoDateStart = "$event_start_year-$event_start_month-$event_start_day";
		$isoDateEnd = "$event_end_year-$event_end_month-$event_end_day";
		
		if ($metaDateEnd && ($metaDateEnd != $metaDateStart) || ($event_start_hour != $event_end_hour)) {
			$metaDate = "$metaDateStart $metaTimeStart - $metaDateEnd $metaTimeEnd";
		}
		else {
			$metaDate = "$metaDateStart $metaTimeStart";
		}
		
		$day_start = date("j", mktime(0,0,0,$event_start_month, $event_start_day, $event_start_year));
		$month_start = date("F", mktime(0,0,0,$event_start_month, $event_start_day, $event_start_year));
		$day_end = date("j", mktime(0,0,0,$event_end_month, $event_end_day, $event_end_year));
		$month_end = date("F", mktime(0,0,0,$event_end_month, $event_end_day, $event_end_year));
		
		if (($day_start == $day_end) && ($month_start == $month_end)) {
			$same_day = true;
		}
		
		if ($same_day && ($event_start_hour == $event_end_hour) && ($event_start_minute == $event_end_minute)) {
			$same_time = true;
		}

		?>
			<li>

				<div class="post-excerpt">
					<?php if ($metaDate) { ?>
					<span class="meta-date">
						<span class="value value-date"><?php echo $day_start; ?></span>
						<span class="value value-month"><?php echo $month_start; ?></span>
						<?php if ($same_day == false) { ?>
						<span class="value value-date"> - <?php echo $day_end; ?></span>
						<span class="value value-month"><?php echo $month_end; ?></span>
						<?php } ?>
						<?php if ($same_day == true && $same_time == false) { ?>
						<span class="value value-time"> @ <?php echo "$event_start_hour:$event_start_minute"; ?></span>
						<?php } ?>
					</span><!-- .meta-date -->
					<?php } ?>
					<h2 class="widget-post"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( '%s', 'wpzoom' ), the_title_attribute( 'echo=0' ) ); ?>"><?php the_title(); ?></a></h2>
					<?php if ($showExcerpt == 'on') { the_excerpt(); } ?>
			
				</div><!-- end .post-excerpt -->
			
				<div class="cleaner">&nbsp;</div>
			</li>
			<?php endwhile; ?>
			</ul><!-- -->
			<?php endif; 
			wp_reset_query();?>
		
		<?php 
		
		echo $after_widget;
		
		}
	
		/* Update the widget settings.*/
		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
	
			/* Strip tags for title and name to remove HTML (important for text inputs). */
			$instance['title'] = strip_tags( $new_instance['title'] );
			$instance['widget_style'] = strip_tags($new_instance['widget_style']);
			$instance['excerpt'] = $new_instance['excerpt'];
			$instance['num'] = $new_instance['num'];
	 
			return $instance;
		}
	
		/** Displays the widget settings controls on the widget panel.
		 * Make use of the get_field_id() and get_field_name() function when creating your form elements. This handles the confusing stuff. */
		function form( $instance ) {
	
			/* Set up some default widget settings. */
			$defaults = array('title' => 'Widget Title','num' => '3');
			$instance = wp_parse_args( (array) $instance, $defaults );
			$widget_style = strip_tags($instance['widget_style']);
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
				<label for="<?php echo $this->get_field_id('num'); ?>"><?php _e('Events to display:', 'wpzoom'); ?></label>
				<select id="<?php echo $this->get_field_id('num'); ?>" name="<?php echo $this->get_field_name('num'); ?>" style="width:90%;">
				<?php
					$m = 0;
					while ($m < 11) {
						$m++;
						$option = '<option value="'.$m;
						if ($m == $instance['num']) { $option .='" selected="selected';}
						$option .= '">';
						$option .= $m;
						$option .= '</option>';
						echo $option;
					}
				?>
				</select>
			</p>
		
			<p>
				<input class="checkbox" type="checkbox" id="<?php echo $this->get_field_id('excerpt'); ?>" name="<?php echo $this->get_field_name('excerpt'); ?>" <?php if ($instance['excerpt'] == 'on') { echo ' checked="checked"';  } ?> /> 
				<label for="<?php echo $this->get_field_id('excerpt'); ?>"><?php _e('Display excerpt', 'wpzoom'); ?></label>
			</p>

		<?php
		}
}

function wpzoom_register_feat_events_widget() {
	register_widget('wpzoom_widget_feat_events');
}
add_action('widgets_init', 'wpzoom_register_feat_events_widget');
?>