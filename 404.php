<?php get_header(); ?>

	<div id="main">

		<div class="wrapper">
	
			<div class="column column-narrow">

				<?php
				if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Sidebar: Left Column') ) : ?> <?php endif;
				?>
				
				<div class="cleaner">&nbsp;</div>

			</div><!-- end .column .column-narrow -->
			
			<div class="column column-medium">

				<div class="widget">
					<h1 class="post-title"><?php _e('Error 404 - Page Not Found', 'wpzoom'); ?></h1>
					<p><?php _e('The page you are looking for could not be found.', 'wpzoom');?> </p>
					<?php get_search_form(); ?>
					
					<div class="divider">&nbsp;</div>

					<div class="post-content">
		
						<p><?php _e( 'Browse Categories', 'wpzoom' ); ?></p>
						<ul>
							<?php wp_list_categories('title_li=&hierarchical=0&show_count=1'); ?>	
						</ul>
					
						<p><?php _e( 'Monthly Archives', 'wpzoom' ); ?></p>
						<ul>
							<?php wp_get_archives('type=monthly&show_post_count=1'); ?>	
						</ul>
		
					</div><!-- end .post-content -->
					
					<div class="cleaner">&nbsp;</div>
				</div><!-- end .widget -->

				<div class="cleaner">&nbsp;</div>

			</div><!-- end .column .column-medium -->
			
			<?php if (!$no_side_right) { ?>
			<div class="column column-narrow column-last">

				<?php
				if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Sidebar: Right Column') ) : ?> <?php endif;
				?>
				<div class="cleaner">&nbsp;</div>

			</div><!-- end .column .column-narrow -->
			<?php } ?>
			
			<div class="cleaner">&nbsp;</div>
			
		</div><!-- end .wrapper -->

	</div><!-- end #main -->

<?php get_footer(); ?>