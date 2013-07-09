	<footer>
	
		<div class="wrapper">
		
			<div class="column column-first">
				
				<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer: Column 1') ) : ?> <?php endif; ?>
				
				<div class="cleaner">&nbsp;</div>
			</div><!-- end .column -->
	
			<div class="column column-second">
				
				<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer: Column 2') ) : ?> <?php endif; ?>
				
				<div class="cleaner">&nbsp;</div>
			</div><!-- end .column -->
	
			<div class="column column-third">
				
				<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer: Column 3') ) : ?> <?php endif; ?>
				
				<div class="cleaner">&nbsp;</div>
			</div><!-- end .column -->
	
			<div class="column column-last">
				
				<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer: Column 4') ) : ?> <?php endif; ?>
				
				<div class="cleaner">&nbsp;</div>
			</div><!-- end .column -->

			<div class="cleaner">&nbsp;</div>
		
		</div><!-- end .wrapper -->

	</footer>
		
	<div id="footer-copy">
		<div class="wrapper wrapper-copy">
			<p class="wpzoom"><?php _e('WordPress Theme', 'wpzoom'); ?> <?php _e('by', 'wpzoom'); ?> <a href="http://www.wpzoom.com" target="_blank">WPZOOM</a></p>
			<p class="copyright"><?php _e('Copyright', 'wpzoom'); ?> &copy; <?php echo date("Y",time()); ?> <?php bloginfo('name'); ?>. <?php _e('All Rights Reserved', 'wpzoom'); ?></p>
			<div class="cleaner">&nbsp;</div>
		</div><!-- end .wrapper .wrapper-copy -->
	</div><!-- end #footer-copy -->

</div><!-- end #container -->

<?php wp_footer(); ?>
<?php wp_reset_query();
if (is_singular()) { ?><script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script><?php } // Google Plus button ?>
</body>
</html>