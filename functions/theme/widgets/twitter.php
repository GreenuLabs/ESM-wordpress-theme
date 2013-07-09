<?php
/*----------------------------------------------------------------------------------*/
/*  WPZOOM: Twitter Widget
/*----------------------------------------------------------------------------------*/

require_once dirname(__FILE__) . '/twitteroauth/twitteroauth.php';

class wpzoom_Twitter extends WP_Widget {
	private $connection;

	function wpzoom_Twitter() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'twitter', 'description' => 'A list of latest tweets' );

		/* Widget control settings. */
		$control_ops = array( 'id_base' => 'wpzoom-twitter' );

		/* Create the widget. */
		$this->WP_Widget( 'wpzoom-twitter', 'WPZOOM: Twitter', $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );

		/* User-selected settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$username = $instance['username'];
		$show_count = $instance['show_count'];
		$hide_timestamp = isset( $instance['hide_timestamp'] ) ? $instance['hide_timestamp'] : false;
		$linked = $instance['hide_url'] ? false : '#';
		$show_follow = isset( $instance['show_follow'] ) ? $instance['show_follow'] : false;
		$show_followers = isset( $instance['show_followers'] ) ? $instance['show_followers'] : false;

		$widget_style = $instance['widget_style'];
		
		$pos = strpos($before_widget,'widget ');
		$before_widget=substr_replace($before_widget, 'widget-' . $widget_style . ' ', $pos, 0);

		$this->consumer_key = $instance['consumer_key'];
		$this->consumer_secret = $instance['consumer_secret'];
		$this->access_token = $instance['access_token'];
		$this->access_token_secret = $instance['access_token_secret'];

		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Title of widget (before and after defined by themes). */
		if ( $title )
		echo $before_title . $title . $after_title;
 
		$this->messages($username, $show_count, true, !$hide_timestamp, $linked);


		if ($show_follow) {
			echo '<div class="follow-user"><a href="https://twitter.com/' . $username . '" class="twitter-follow-button"';

			if ($show_followers) {
				echo 'data-show-count="false"';
			}

			echo '>Follow @' . $username . '</a><script src="//platform.twitter.com/widgets.js" type="text/javascript"></script></div>';
		}

		/* After widget (defined by themes). */
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags (if needed) and update the widget settings. */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['username'] = $new_instance['username'];
		$instance['show_count'] = $new_instance['show_count'];
		$instance['hide_timestamp'] = $new_instance['hide_timestamp'];
		$instance['hide_url'] = $new_instance['hide_url'];
		$instance['show_follow'] = $new_instance['show_follow'];
		$instance['show_followers'] = $new_instance['show_followers'];
		$instance['widget_style'] = strip_tags($new_instance['widget_style']);
		$instance['consumer_key'] = $new_instance['consumer_key'];
		$instance['consumer_secret'] = $new_instance['consumer_secret'];
		$instance['access_token'] = $new_instance['access_token'];
		$instance['access_token_secret'] = $new_instance['access_token_secret'];
		
		delete_transient( 'zoom_tw_msg_' . $new_instance['username'] );

		return $instance;
	}

	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => 'Latest Tweets', 'username' => '', 'show_count' => 3, 'hide_timestamp' => false, 'hide_url' => false, 'show_follow' => true, 'show_followers' => true );
		$instance = wp_parse_args( (array) $instance, $defaults );
		?>

		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title', 'wpzoom'); ?>:</label><br />
		<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'widget_style' ); ?>"><?php _e('Widget Color Scheme', 'wpzoom'); ?>:</label>
			<select id="<?php echo $this->get_field_id( 'widget_style' ); ?>" name="<?php echo $this->get_field_name( 'widget_style' ); ?>">
				<option value="0"<?php if (!$instance['widget_style'] || $instance['widget_style'] == '0') { echo ' selected="selected"';} ?>><?php _e('Default', 'wpzoom'); ?></option>
				<option value="blue"<?php if ($instance['widget_style'] == 'blue') { echo ' selected="selected"';} ?>><?php _e('Blue', 'wpzoom'); ?></option>
				<option value="gold"<?php if ($instance['widget_style'] == 'gold') { echo ' selected="selected"';} ?>><?php _e('Gold', 'wpzoom'); ?></option>
				<option value="grey"<?php if ($instance['widget_style'] == 'grey') { echo ' selected="selected"';} ?>><?php _e('Grey', 'wpzoom'); ?></option>
			</select>
		</p>

		<p>
		<label for="<?php echo $this->get_field_id( 'username' ); ?>"><?php _e('Twitter Username', 'wpzoom'); ?>:</label>
		<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'username' ); ?>" name="<?php echo $this->get_field_name( 'username' ); ?>" value="<?php echo $instance['username']; ?>"   />
		</p>

		<p>
		<label for="<?php echo $this->get_field_id( 'show_count' ); ?>"><?php _e('Show', 'wpzoom'); ?>:</label>
		<input  type="text" id="<?php echo $this->get_field_id( 'show_count' ); ?>" name="<?php echo $this->get_field_name( 'show_count' ); ?>" value="<?php echo $instance['show_count']; ?>" size="3" /> <?php _e('tweets', 'wpzoom'); ?>
		</p>

		<p>
		<input class="checkbox" type="checkbox" <?php checked( $instance['hide_timestamp'], 'on' ); ?> id="<?php echo $this->get_field_id( 'hide_timestamp' ); ?>" name="<?php echo $this->get_field_name( 'hide_timestamp' ); ?>" />
		<label for="<?php echo $this->get_field_id( 'hide_timestamp' ); ?>"><?php _e('Hide Timestamp', 'wpzoom'); ?></label>
		</p>

		<p>
		<input class="checkbox" type="checkbox" <?php checked( $instance['hide_url'], 'on' ); ?> id="<?php echo $this->get_field_id( 'hide_url' ); ?>" name="<?php echo $this->get_field_name( 'hide_url' ); ?>" />
		<label for="<?php echo $this->get_field_id( 'hide_url' ); ?>"><?php _e('Hide Tweet URL', 'wpzoom'); ?></label>
		</p>

		<p>
		<input class="checkbox" type="checkbox" <?php checked( $instance['show_follow'], 'on' ); ?> id="<?php echo $this->get_field_id( 'show_follow' ); ?>" name="<?php echo $this->get_field_name( 'show_follow' ); ?>" />
		<label for="<?php echo $this->get_field_id( 'show_follow' ); ?>"><?php _e('Display Follow me button', 'wpzoom'); ?></label>
		</p>

		<p>
		<input class="checkbox" type="checkbox" <?php checked( $instance['show_followers'], 'on' ); ?> id="<?php echo $this->get_field_id( 'show_followers' ); ?>" name="<?php echo $this->get_field_name( 'show_followers' ); ?>" />
		<label for="<?php echo $this->get_field_id( 'show_followers' ); ?>"><?php _e('Hide follower count?', 'wpzoom'); ?>?</label>
		</p>
		<br/>
		<p><strong>Your Twitter API 1.1 data</strong><em> (required)</em>

		<small><a href="http://www.wpzoom.com/docs/twitter-widget-with-api-version-1-1-setup-instructions/" target="_blank">Instructions getting your Twitter API keys</a></small>
		</p>


		<p>
		<label for="<?php echo $this->get_field_id( 'consumer_key' ); ?>"><?php _e('Consumer key', 'wpzoom'); ?>:</label><br />
		<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'consumer_key' ); ?>" name="<?php echo $this->get_field_name( 'consumer_key' ); ?>" value="<?php echo $instance['consumer_key']; ?>" />
		</p>

		<p>
		<label for="<?php echo $this->get_field_id( 'consumer_secret' ); ?>"><?php _e('Consumer secret', 'wpzoom'); ?>:</label><br />
		<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'consumer_secret' ); ?>" name="<?php echo $this->get_field_name( 'consumer_secret' ); ?>" value="<?php echo $instance['consumer_secret']; ?>" />
		</p>

		<p>
		<label for="<?php echo $this->get_field_id( 'access_token' ); ?>"><?php _e('Access token', 'wpzoom'); ?>:</label><br />
		<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'access_token' ); ?>" name="<?php echo $this->get_field_name( 'access_token' ); ?>" value="<?php echo $instance['access_token']; ?>" />
		</p>

		<p>
		<label for="<?php echo $this->get_field_id( 'access_token_secret' ); ?>"><?php _e('Access token secret', 'wpzoom'); ?>:</label><br />
		<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'access_token_secret' ); ?>" name="<?php echo $this->get_field_name( 'access_token_secret' ); ?>" value="<?php echo $instance['access_token_secret']; ?>" />
		</p>

		<?php
	}

	function messages($username = '', $num = 1, $list = false, $update = true, $linked  = '#') {
		$messages = get_transient( 'zoom_tw_msg_' . $username );
		if ($messages === false) {
			$this->connection = new TwitterOAuth( $this->consumer_key, $this->consumer_secret, $this->access_token, $this->access_token_secret );
			$this->connection->get('account/verify_credentials');

			if ( $this->connection->http_code !== 200 ) {
				echo "Can't query Twitter API.";
				set_transient( 'zoom_tw_msg_' . $username, array(), 360 );
				return;
			}

			$params = array(
				'screen_name' => $username,
				'count' => $num,
				'trim_user' => true,
				'contributor_details' => false,
				'include_entities' => false
			);
			$messages = $this->connection->get( 'statuses/user_timeline', $params );

			set_transient( 'zoom_tw_msg_' . $username, $messages, 360 );
		}

		if ($list) echo '<ul class="twitter-list">';

		if ($username == '' || $this->connection->http_code == 404) {
			if ($list) echo '<li>';
			echo 'Widget not configured or user does not exist.';
			if ($list) echo '</li>';
		} else {
			if ( !$messages ) {
				if ($list) echo '<li>';
				echo 'No Twitter messages.';
				if ($list) echo '</li>';
			} else {
				$i = 0;
				foreach ( $messages as $message ) {
					$msg = $message->text;
					$permalink = 'http://twitter.com/'. $username .'/status/'. $message->id_str;

					if ($list) echo '<li class="twitter-item">'; elseif ($num != 1) echo '<p class="twitter-message">';

					$msg = $this->hyperlinks($msg);
					$msg = $this->twitter_users($msg);

					echo $msg;

					if($update) {
						$time = strtotime($message->created_at);

						if ( ( abs( time() - $time) ) < 86400 )
							$h_time = sprintf( __('%s ago', 'wpzoom'), human_time_diff( $time ) );
						else
							$h_time = date('M j, Y', $time);

						if ($linked != '' | $linked != false) {
							echo sprintf( __('%s', 'wpzoom'),' <div class="clear"></div><a href="'.$link.'" class="twitter-link twitter-timestamp">' . $h_time . '</a>' );
						} else {
							echo sprintf( __('%s', 'wpzoom'),' <div class="clear"></div><em class="twitter-timestamp">' . $h_time . '</em>' );
						}
					}

					if ($list) echo '</li>'; elseif ($num != 1) echo '</p>';

					$i++;
					if ( $i >= $num ) break;
				}
			}
		}
		if ($list) echo '</ul>';
	}

	function hyperlinks($text) {
		$text = preg_replace('/\b([a-zA-Z]+:\/\/[\w_.\-]+\.[a-zA-Z]{2,6}[\/\w\-~.?=&%#+$*!]*)\b/i',"<a href=\"$1\" class=\"twitter-link\">$1</a>", $text);
		$text = preg_replace('/\b(?<!:\/\/)(www\.[\w_.\-]+\.[a-zA-Z]{2,6}[\/\w\-~.?=&%#+$*!]*)\b/i',"<a href=\"http://$1\" class=\"twitter-link\">$1</a>", $text);
		$text = preg_replace("/\b([a-zA-Z][a-zA-Z0-9\_\.\-]*[a-zA-Z]*\@[a-zA-Z][a-zA-Z0-9\_\.\-]*[a-zA-Z]{2,6})\b/i","<a href=\"mailto://$1\" class=\"twitter-link\">$1</a>", $text);
		$text = preg_replace('/([\.|\,|\:|\°|\o|\>|\{|\(]?)#{1}(\w*)([\.|\,|\:|\!|\?|\>|\}|\)]?)\s/i', "$1<a href=\"http://twitter.com/#search?q=$2\" class=\"twitter-link\">#$2</a>$3 ", $text);
		return $text;
	}

	function twitter_users($text) {
		$text = preg_replace('/([\.|\,|\:|\°|\o|\>|\{|\(]?)@{1}(\w*)([\.|\,|\:|\!|\?|\>|\}|\)]?)\s/i', "$1<a href=\"http://twitter.com/$2\" class=\"twitter-user\">@$2</a>$3 ", $text);
		return $text;
	}

}


function wpzoom_register_tw_widget() {
	register_widget('wpzoom_Twitter');
}

add_action('widgets_init', 'wpzoom_register_tw_widget');