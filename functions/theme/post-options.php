<?php
 
/*----------------------------------*/
/* Custom Posts Options				*/
/*----------------------------------*/

add_action('admin_menu', 'wpzoom_options_box');

function wpzoom_options_box() {
	add_meta_box('wpzoom_post_template', 'Post Options', 'wpzoom_post_options', 'post', 'side', 'high');
	add_meta_box('wpzoom_post_template', 'Page Options', 'wpzoom_post_options', 'page', 'side', 'high');
	add_meta_box('wpzoom_post_template', 'Event Options', 'wpzoom_post_options', 'event', 'side', 'high');
	add_meta_box('wpzoom_post_template', 'Testimonial Options', 'wpzoom_testimonial_options', 'testimonial', 'side', 'high');
	add_meta_box('wpzoom_post_layout', 'Post Layout', 'wpzoom_post_layout_options', 'post', 'normal', 'high');
	add_meta_box('wpzoom_post_layout', 'Page Layout', 'wpzoom_post_layout_options', 'page', 'normal', 'high');
	add_meta_box('wpzoom_post_layout', 'Event Layout', 'wpzoom_post_layout_options', 'event', 'normal', 'high');
	add_meta_box('wpzoom_post_layout', 'Testimonial Layout', 'wpzoom_post_layout_options', 'testimonial', 'normal', 'high');
}

add_action('save_post', 'custom_add_save');

function custom_add_save($postID){
	// called after a post or page is saved
	if($parent_id = wp_is_post_revision($postID))
	{
	  $postID = $parent_id;
	}
	
	if ($_POST['saveTestimonial']) {
		update_custom_meta($postID, $_POST['wpzoom_testimonial_author'], 'wpzoom_testimonial_author');
		update_custom_meta($postID, $_POST['wpzoom_testimonial_author_position'], 'wpzoom_testimonial_author_position');
		update_custom_meta($postID, $_POST['wpzoom_testimonial_author_company'], 'wpzoom_testimonial_author_company');
		update_custom_meta($postID, $_POST['wpzoom_testimonial_author_company_url'], 'wpzoom_testimonial_author_company_url');
	}

	if ($_POST['save'] || $_POST['publish']) {
		update_custom_meta($postID, $_POST['wpzoom_post_template'], 'wpzoom_post_template');
		update_custom_meta($postID, $_POST['wpzoom_featured_show'], 'wpzoom_featured_show');
		update_custom_meta($postID, $_POST['wpzoom_gallery_show'], 'wpzoom_gallery_show');
	}
}

function update_custom_meta($postID, $newvalue, $field_name) {
	// To create new meta
	if(!get_post_meta($postID, $field_name)){
		add_post_meta($postID, $field_name, $newvalue);
	}else{
		// or to update existing meta
		update_post_meta($postID, $field_name, $newvalue);
	}
	
}

// Custom Post Layouts
function wpzoom_post_layout_options() {
	global $post;
	$postLayouts = array('side-both' => 'Sidebar on both sides', 'side-right' => 'Sidebar on the right', 'side-left' => 'Sidebar on the left', 'full' => 'Full Width');
	?>

	<style>
	.RadioClass{  
		display: none;
	} 
	
	.RadioLabelClass {
		margin-right: 10px;
	}
	
	img.layout-select {
		border: solid 4px #c0cdd6;
		border-radius: 5px;
	}
	
	.RadioSelected img.layout-select{
		border: solid 4px #3173b2;
	}
	</style>

	<script type="text/javascript">  
	jQuery(document).ready(
	function($)
	{
		$(".RadioClass").change(function(){  
		    if($(this).is(":checked")){  
		        $(".RadioSelected:not(:checked)").removeClass("RadioSelected");  
		        $(this).next("label").addClass("RadioSelected");  
		    }  
		}); 
	});  
	</script>

	<fieldset>
		<div>
			 
			<p>
			
			<?php
			foreach ($postLayouts as $key => $value)
			{
				?>
				<input id="<?php echo $key; ?>" type="radio" class="RadioClass" name="wpzoom_post_template" value="<?php echo $key; ?>"<?php if (get_post_meta($post->ID, 'wpzoom_post_template', true) == $key) { echo' checked="checked"'; } ?> />
				<label for="<?php echo $key; ?>" class="RadioLabelClass<?php if (get_post_meta($post->ID, 'wpzoom_post_template', true) == $key) { echo' RadioSelected"'; } ?>">
				<img src="<?php echo wpzoom::$wpzoomPath; ?>/assets/images/layout-<?php echo $key; ?>.png" alt="<?php echo $value; ?>" title="<?php echo $value; ?>" class="layout-select" /></label>
			<?php
			} 
			?>

			</p>
			
  		</div>
	</fieldset>
	<?php } 

// Regular Posts Options
function wpzoom_post_options() {
	global $post;
	?>
	<fieldset>
		<div>
			<p>
 				<label>Show Featured Image on Post Page:</label><br />
				<select name="wpzoom_featured_show" id="wpzoom_featured_show">
					<option<?php selected( get_post_meta($post->ID, 'wpzoom_featured_show', true), 'Don\'t Show' ); ?>>Don't Show</option>
					<option<?php selected( get_post_meta($post->ID, 'wpzoom_featured_show', true), 'Narrow' ); ?>>Narrow</option>
					<option<?php selected( get_post_meta($post->ID, 'wpzoom_featured_show', true), 'Full Width' ); ?>>Full Width</option>
				</select>
			</p>			
  		</div>
	</fieldset>
	<?php
	}

// Testimonials Options
function wpzoom_testimonial_options() {
	global $post;
	?>
	<fieldset>
		<input type="hidden" name="saveTestimonial" id="saveTestimonial" value="1" />
		<div>
			<p>
 				<label>Show Featured Image on Testimonial Page:</label><br />
				<select name="wpzoom_featured_show" id="wpzoom_featured_show">
					<option<?php selected( get_post_meta($post->ID, 'wpzoom_featured_show', true), 'Don\'t Show' ); ?>>Don't Show</option>
					<option<?php selected( get_post_meta($post->ID, 'wpzoom_featured_show', true), 'Narrow' ); ?>>Narrow</option>
					<option<?php selected( get_post_meta($post->ID, 'wpzoom_featured_show', true), 'Full Width' ); ?>>Full Width</option>
				</select>
			</p>
			<p>
				<label for="wpzoom_testimonial_author">Testimonial Author:</label><br />
				<input type="text" style="width:90%;" name="wpzoom_testimonial_author" id="wpzoom_testimonial_author" value="<?php echo get_post_meta($post->ID, 'wpzoom_testimonial_author', true); ?>"><br />
			</p>
			<p>
				<label for="wpzoom_testimonial_author_position">Author Position:</label><br />
				<input type="text" style="width:90%;" name="wpzoom_testimonial_author_position" id="wpzoom_testimonial_author_position" value="<?php echo get_post_meta($post->ID, 'wpzoom_testimonial_author_position', true); ?>"><br />
				<span class="description">Example: CEO &amp; Founder</span>
			</p>
			<p>
				<label for="wpzoom_testimonial_author_company">Author Company:</label><br />
				<input type="text" style="width:90%;" name="wpzoom_testimonial_author_company" id="wpzoom_testimonial_author_company" value="<?php echo get_post_meta($post->ID, 'wpzoom_testimonial_author_company', true); ?>"><br />
				<span class="description">Example: WPZOOM</span>
			</p>
			<p>
				<label for="wpzoom_testimonial_author_company_url">Author Company Link:</label><br />
				<input type="text" style="width:90%;" name="wpzoom_testimonial_author_company_url" id="wpzoom_testimonial_author_company_url" value="<?php echo get_post_meta($post->ID, 'wpzoom_testimonial_author_company_url', true); ?>"><br />
				<span class="description">Example: http://www.wpzoom.com</span>
			</p>
			
  		</div>
	</fieldset>
	<?php
	}

$wpzoom_featured_fields = array(
	array(
		"name"		=> "wpzoom_is_featured",
		"label"		=> "Feature this Post",
		"type"		=> "checkbox"
	)	// checkbox
	);

function wpzoom_featured_meta( $post_data, $meta_info ) {
	global $post, $wpzoom_featured_fields;
	echo '<div class="wpzoom_panel"><input type="hidden" name="wpzoom_featured_metaes_nonce" value="'.wp_create_nonce( plugin_basename(__FILE__) ).'" />';
	foreach( $wpzoom_featured_fields as $o ){
		$val = get_post_meta( $post->ID, $o['name'], true );
		echo '<p>';

		switch ( $o['type'] ){
			case "checkbox":
				$isChecked = ( $val == 1 ? 'checked="checked"' : '' ); // we store checked checkboxes as 1
				echo '<input type="checkbox" name="' . $o['name'] . '" id="' . $o['name'] . '" ' . $isChecked . ' /> <label for="wpzoom_is_featured" >' . $o['label'] . '</label>';
			break; // checkbox

			case "text":
				default:
				echo '<input type="text" name="' . $o['name'] . '" id="' . $o['name'] . '" value="' . $val . '" placeholder="' . $o['label'] . '" />';
			break; // text & default

			 
		}// switch

	}// foreach
	echo '</div>';
?>

<style type="text/css" media="screen">
	.wpzoom_panel input[type="text"],
	.wpzoom_panel textarea {
		width:100%;
	}
	.wpzoom_panel .desc {
		text-align:right;
	}
 
</style>

<?php 
}

function wpzoom_create_featured_meta() {
	if ( function_exists( 'add_meta_box' ) ) {
		add_meta_box( 'wpzoom_featured_meta', 'Feature this Post?', 'wpzoom_featured_meta', 'post', 'side', 'high' );
	}
}

function wpzoom_save_featured_meta( $post_id ) {

	global $post, $post_id, $wpzoom_featured_fields;
	if ( in_array( $_REQUEST['post_type'], array('page') ) ) {
		if ( !current_user_can( 'edit_page', $post_id ) ) {return $post_id;}
	} else {
		if ( !current_user_can( 'edit_post', $post_id ) ) {return $post_id;}
	}

	foreach($wpzoom_featured_fields as $o){
		if ( !wp_verify_nonce( $_REQUEST['wpzoom_featured_metaes_nonce'], plugin_basename(__FILE__) )) {
			return $post_id;
		}
		switch ($o['type']){
			case "checkbox":
				update_post_meta( $post_id, $o['name'], isset( $_REQUEST[$o['name']] ) );
			break;
			default:
				update_post_meta($post_id, $o['name'], $_REQUEST[$o['name']]);
			break;
		}
	}
}
add_action( 'admin_menu', 'wpzoom_create_featured_meta' );  
add_action( 'save_post', 'wpzoom_save_featured_meta' );
