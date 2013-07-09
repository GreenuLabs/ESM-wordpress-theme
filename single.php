<?php get_header(); ?>

	<div id="main">

		<?php 
		if (!is_active_sidebar('sidebar-left')) { $no_side_left = true; }
		if (!is_active_sidebar('sidebar-right')) { $no_side_right = true; }
		?>

		<div class="wrapper">
	
			<?php while (have_posts()) : the_post();
			$featured_image = get_post_meta($post->ID, 'wpzoom_featured_show', true);
			$template = get_post_meta($post->ID, 'wpzoom_post_template', true);
			?>

			<?php
			if ($featured_image == 'Full Width') { ?>
			<?php get_the_image( array( 'size' => 'thumb-full', 'width' => 960, 'height' => 350, 'attachment' => false, 'image_scan' => false, 'before' => '<div class="post-cover post-cover-full single-cover">', 'after' => '</div><!-- end .post-cover -->', 'link_to_post' => false) ); ?>
			<?php } ?>

			<?php if (!$no_side_left && $template != 'side-right' && $template != 'full') { ?>
			<div class="column column-narrow">

				<?php
				if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Sidebar: Left Column') ) : ?> <?php endif;
				?>
				
				<div class="cleaner">&nbsp;</div>

			</div><!-- end .column .column-narrow -->
			<?php } ?>
			
			<div class="column <?php
			if (($no_side_left && !$no_side_right) || $template == 'side-right') {
				echo 'column-wide';
			} elseif ((!$no_side_left && $no_side_right) || $template == 'side-left') {
				echo 'column-wide column-last';
			} elseif (($no_side_left && $no_side_right) || $template == 'full') {
				echo 'column-full column-last';
			} else {
				echo 'column-medium';
			} ?>">

				<?php
				if ($featured_image == 'Narrow' && ($template == 'side-both' || !$template)) {
					get_the_image( array( 'size' => 'thumb-singular', 'width' => 470, 'attachment' => false, 'image_scan' => false, 'before' => '<div class="post-cover single-cover">', 'after' => '</div><!-- end .post-cover -->', 'link_to_post' => false ) );
				} elseif ($featured_image == 'Narrow' && ( $template == 'side-left' || $template == 'side-right' )) {
					get_the_image( array( 'size' => 'homepage-slider', 'width' => 715, 'attachment' => false, 'image_scan' => false, 'before' => '<div class="post-cover single-cover">', 'after' => '</div><!-- end .post-cover -->', 'link_to_post' => false ) );
				}
				?>
				
				<div class="widget">
					<h1 class="post-title"><?php the_title(); ?></h1>
					<p class="post-meta"><?php if (option::get('post_author') == 'on') { if ($prev) {echo ' / '; } ?><?php _e('By','wpzoom');?> <?php the_author_posts_link(); $prev = TRUE; } ?>
			<?php if (option::get('post_category') == 'on') { if ($prev) {echo ' / '; } ?><span class="category"><?php _e('In ', 'wpzoom'); the_category(', '); $prev = TRUE; ?></span><?php } ?>
			<?php if (option::get('post_date') == 'on') { if ($prev) {echo ' / '; } ?><time datetime="<?php the_time("Y-m-d"); ?>" pubdate><?php the_time(get_option('date_format')); ?></time><?php $prev = TRUE; } ?>
			<?php edit_post_link( __('Edit post', 'wpzoom'), ' / ', ''); ?></p>
					
					<div class="divider">&nbsp;</div>
					
					<div class="post-content">
						<?php the_content(); ?>
						
						<div class="cleaner">&nbsp;</div>
						
						<?php wp_link_pages(array('before' => '<div class="navigation"><p><strong>'.__('Pages', 'wpzoom').':</strong> ', 'after' => '</p></div>', 'next_or_number' => 'number')); ?>
						<?php if (option::get('post_tags') == 'on') { ?><?php the_tags( '<p><strong>'.__('Tags', 'wpzoom').':</strong> ', ', ', '</p>'); } ?>
						
					</div><!-- end .post-content -->
		
					<?php if (option::get('post_share') == 'on') { ?>
					
					<div class="divider">&nbsp;</div>
					<div class="wrapper-special">
						<span class="share_btn"><a href="http://twitter.com/share" data-url="<?php the_permalink() ?>" class="twitter-share-button" data-count="horizontal">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script></span>
						<span class="share_btn"><iframe src="http://www.facebook.com/plugins/like.php?href=<?php echo urlencode(get_permalink($post->ID)); ?>&amp;layout=button_count&amp;show_faces=false&amp;width=80&amp;action=like&amp;font=arial&amp;colorscheme=light&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:80px; height:21px;" allowTransparency="true"></iframe></span>
						<span class="share_btn"><g:plusone size="medium"></g:plusone></span>
						<p class="title"><?php _e('Share This Page','wpzoom'); ?></p>
					</div><!-- end .wrapper-special -->
					
					<?php } ?>

					<?php if (option::get('post_comments') == 'on') { ?>
					<div class="divider">&nbsp;</div>
					
					<div id="comments">
						<?php comments_template(); ?>  
					</div><!-- end #comments -->
		
					<?php } ?>
					
					<div class="cleaner">&nbsp;</div>
				</div><!-- end .widget -->

				<div class="cleaner">&nbsp;</div>

			</div><!-- end .column .column-medium -->
			
			<?php if (!$no_side_right && $template != 'side-left' && $template != 'full') { ?>
			<div class="column column-narrow column-last">

				<?php
				if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Sidebar: Right Column') ) : ?> <?php endif;
				?>
				<div class="cleaner">&nbsp;</div>

			</div><!-- end .column .column-narrow -->
			<?php } ?>
			
			<div class="cleaner">&nbsp;</div>
			
			<?php endwhile; ?>
			
		</div><!-- end .wrapper -->

	</div><!-- end #main -->

<?php get_footer(); ?>