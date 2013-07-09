<?php get_header(); ?>

	<div id="main">

		<?php 
		if (!is_active_sidebar('sidebar-left')) { $no_side_left = true; }
		if (!is_active_sidebar('sidebar-right')) { $no_side_right = true; }
		?>

		<div class="wrapper">
	
			<div class="column column-narrow">

				<?php
				if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Sidebar: Left Column') ) : ?> <?php endif;
				?>
				<div class="cleaner">&nbsp;</div>

			</div><!-- end .column .column-narrow -->
			
			<div class="column column-wide column-wide-parent column-last">

				<?php
				if (option::get('featured_enable') == 'on' && is_home() && $paged < 2) { 
					get_template_part('featured-posts', '');
				}
				?>

				<div class="cleaner">&nbsp;</div>

				<div class="column <?php if ($no_side_right) { echo 'column-full column-last'; } else { echo 'column-wide column-wide-child'; } ?>">
	
					<?php
					if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Homepage: Content Widgets') ) : ?> <?php endif;
					?>
					<div class="cleaner">&nbsp;</div>
	
				</div><!-- end .column .column-wide -->
				
				<?php if (!$no_side_right) { ?>
				<div class="column column-narrow column-narrow-child column-last">
	
					<?php
					if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Sidebar: Right Column') ) : ?> <?php endif;
					?>
					<div class="cleaner">&nbsp;</div>
	
				</div><!-- end .column .column-narrow -->
				<?php } ?>

				<div class="cleaner">&nbsp;</div>

			</div><!-- end .column .column-wide -->

			<div class="cleaner">&nbsp;</div>
			
		</div><!-- end .wrapper -->

	</div><!-- end #main -->

<?php get_footer(); ?>