<?php 
$loop = new WP_Query( 
	array( 
		'post__not_in' => get_option( 'sticky_posts' ),
		'posts_per_page' => option::get('featured_number'),
		'meta_key' => 'wpzoom_is_featured',
		'meta_value' => 1				
		) );

$m = 0;
$default_image = get_bloginfo('template_url') . '/images/x.gif';
?>

<?php if ($loop->have_posts()) { ?>


<div id="featured-posts" class="flexslider">
	
	<ul class="slides wpzoom-featured-posts">
		<?php while ( $loop->have_posts() ) : $loop->the_post(); $m++; ?>
		<li class="wpzoom-featured-post">
			
			<?php get_the_image( array( 'size' => 'homepage-slider', 'width' => 715, 'height' => 300, 'default_image' => $default_image, 'before' => '<div class="post-cover">', 'after' => '</div>' ) ); ?>

			<div class="post-excerpt">
				<h2><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'wpzoom' ), the_title_attribute( 'echo=0' ) ); ?>"><?php the_title(); ?></a></h2>
				<?php the_excerpt(); ?>
			</div><!-- .post excerpt -->

		</li><!-- .wpzoom-featured-post -->
		<?php endwhile; ?>
	</ul><!-- .wpzoom-featured-posts -->
</div><!-- end .featured-posts -->

<script type="text/javascript">
jQuery(document).ready(function() {
	
	jQuery("#featured-posts").flexslider({
        controlNav: false,
		directionNav: true,
        animationLoop: true,
        slideshow: <?php if (option::get('featured_rotate') == 'on') { echo "true"; } else { echo "false"; } ?>,
        <?php if (option::get('featured_rotate') == 'on') { ?>slideshowSpeed:<?php echo option::get('featured_interval'); ?>,<?php } ?>
		pauseOnAction: true,
		touch: false,
        animationSpeed: 500
    });	 

});
</script>

<?php wp_reset_query(); } else { echo '<div id="featured-posts-wrapper"><div class="no-content"><p><strong>You are now ready to set-up your Slideshow content.</strong></p>
<p>For more information about adding posts to the slider, please <strong><a href="http://www.wpzoom.com/documentation/academica-pro/">read the documentation</a></strong>.</p></div></div>'; } ?>