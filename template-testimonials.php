<?php
/*
Template Name: Testimonials List
*/
?>
<?php get_header(); ?>

	<div id="main">

		<?php 
		if (!is_active_sidebar('sidebar-left')) { $no_side_left = true; }
		if (!is_active_sidebar('sidebar-right')) { $no_side_right = true; }
		?>

		<div class="wrapper">
	
			<?php while (have_posts()) : the_post();
			$template = get_post_meta($post->ID, 'wpzoom_post_template', true);
			?>

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

				<div class="widget">
					<h1 class="post-title"><?php the_title(); ?></h1>
					<?php edit_post_link( __('Edit page', 'wpzoom'), '<p class="post-meta">', '</p>'); ?>
					
					<div class="post-content">
						<?php the_content(); ?>
						
						<div class="cleaner">&nbsp;</div>
						
					</div><!-- end .post-content -->
					
					<div class="divider divider-notop">&nbsp;</div>
					
					<?php get_template_part('loop', 'testimonials'); ?>

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