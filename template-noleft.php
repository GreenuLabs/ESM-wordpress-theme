<?php
/*
Template Name: No Left Sidebar
*/
?>
<?php get_header(); ?>

	<div id="main">

		<div class="wrapper">
	
			<?php while (have_posts()) : the_post();
			$featured_image = get_post_meta($post->ID, 'wpzoom_featured_show', true);
			?>

			<?php
			if ($featured_image == 'Full Width') { ?>
			<?php get_the_image( array( 'size' => 'thumb-full', 'width' => 960, 'height' => 350, 'attachment' => false, 'image_scan' => false, 'before' => '<div class="post-cover post-cover-full single-cover">', 'after' => '</div><!-- end .post-cover -->', 'link_to_post' => false) ); ?>
			<?php } ?>

			<div class="column column-wide">

				<?php
				if ($featured_image == 'Narrow') { ?>
				<?php get_the_image( array( 'size' => 'homepage-slider', 'width' => 715, 'attachment' => false, 'image_scan' => false, 'before' => '<div class="post-cover single-cover">', 'after' => '</div><!-- end .post-cover -->', 'link_to_post' => false ) ); ?>
				<?php } ?>
				
				<div class="widget">
					<h1 class="post-title"><?php the_title(); ?></h1>
					<?php edit_post_link( __('Edit page', 'wpzoom'), '<p class="post-meta">', '</p>'); ?>
					
					<div class="divider">&nbsp;</div>
					
					<div class="post-content">
						<?php the_content(); ?>
						
						<div class="cleaner">&nbsp;</div>
						
						<?php wp_link_pages(array('before' => '<div class="navigation"><p><strong>'.__('Pages', 'wpzoom').':</strong> ', 'after' => '</p></div>', 'next_or_number' => 'number')); ?>
						
					</div><!-- end .post-content -->
		
					<?php if (option::get('page_share') == 'on') { ?>
					
					<div class="divider">&nbsp;</div>
					<div class="wrapper-special">
						<span class="share_btn"><a href="http://twitter.com/share" data-url="<?php the_permalink() ?>" class="twitter-share-button" data-count="horizontal">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script></span>
						<span class="share_btn"><iframe src="http://www.facebook.com/plugins/like.php?href=<?php echo urlencode(get_permalink($post->ID)); ?>&amp;layout=button_count&amp;show_faces=false&amp;width=80&amp;action=like&amp;font=arial&amp;colorscheme=light&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:80px; height:21px;" allowTransparency="true"></iframe></span>
						<span class="share_btn"><g:plusone size="medium"></g:plusone></span>
						<p class="title"><?php _e('Share This Page','wpzoom'); ?></p>
					</div><!-- end .wrapper-special -->
					
					<?php } ?>

					<?php if (option::get('page_comments') == 'on') { ?>
					<div class="divider">&nbsp;</div>
					
					<div id="comments">
						<?php comments_template(); ?>  
					</div><!-- end #comments -->
		
					<?php } ?>
					
					<div class="cleaner">&nbsp;</div>
				</div><!-- end .widget -->

				<div class="cleaner">&nbsp;</div>

			</div><!-- end .column .column-medium -->
			
			<div class="column column-narrow column-last">

				<?php
				if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Sidebar: Right Column') ) : ?> <?php endif;
				?>
				
				<div class="cleaner">&nbsp;</div>

			</div><!-- end .column .column-narrow -->
			
			<div class="cleaner">&nbsp;</div>
			
			<?php endwhile; ?>
			
		</div><!-- end .wrapper -->

	</div><!-- end #main -->

<?php get_footer(); ?>