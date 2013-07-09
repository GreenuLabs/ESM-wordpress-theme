<?php wp_reset_query();

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
	'posts_per_page' => 25,
);

$events = new WP_Query( $args );

if ( $events->have_posts() ) {
?>

<ul class="posts-archive archives-columns-one">

<?php
$i = 0;

while ( $events->have_posts() ) : $events->the_post(); $i++;
unset($same_day,$same_time,$parentMeta); 

$parentMeta = get_post_custom();
$event_start_day = $parentMeta['_start_day'][0];
$event_start_month = $parentMeta['_start_month'][0];
$event_start_year = $parentMeta['_start_year'][0];
$event_end_day = $parentMeta['_end_day'][0];
$event_end_month = $parentMeta['_end_month'][0];
$event_end_year = $parentMeta['_end_year'][0];
$event_start_hour = $parentMeta['_start_hour'][0];
$event_start_minute = $parentMeta['_start_minute'][0];
$event_end_hour = $parentMeta['_end_hour'][0];
$event_end_minute = $parentMeta['_end_minute'][0];

$metaDateStart = "$event_start_day/$event_start_month/$event_start_year";
$metaDateEnd = "$event_end_day/$event_end_month/$event_end_year";
if ($event_start_hour != '00' && $event_start_minute != '00') {
	$metaTimeStart = "$event_start_hour:$event_start_minute";
}
$metaTimeEnd = "$event_end_hour:$event_end_minute";
$isoDateStart = "$event_start_year-$event_start_month-$event_start_day";
$isoDateEnd = "$event_end_year-$event_end_month-$event_end_day";

if ($metaDateEnd && ($metaDateEnd != $metaDateStart)) {
	$metaDate = "$metaDateStart - $metaDateEnd";
}
else {
	$metaDate = "$metaDateStart";
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

	<li class="loop-post-single loop-post-border">
		<?php
		get_the_image( array( 'size' => 'loop-main', 'width' => 210, 'height' => 100, 'before' => '<div class="post-cover">', 'after' => '</div>' ) );
		?>
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
				<span class="value value-time"> @ <?php echo "$event_start_hour:$event_start_minute - $event_end_hour:$event_end_minute"; ?></span>
				<?php } ?>
			</span><!-- .meta-date -->
			<?php } ?>
			<h2><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
			<?php the_excerpt(); ?>
		</div><!-- end .post-excerpt -->
		<div class="cleaner">&nbsp;</div>
	</li><!-- .loop-post-single -->

	<?php endwhile; ?>

</ul><!-- end .posts-list-->
<?php } ?>
				
<?php get_template_part( 'pagination'); ?>

<?php wp_reset_query(); ?>