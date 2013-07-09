<form method="get" id="searchform" action="<?php bloginfo('url'); ?>/">
	<fieldset>
		<input type="text" onblur="if (this.value == '') {this.value = '<?php _e('Search', 'wpzoom') ?>';}" onfocus="if (this.value == '<?php _e('Search', 'wpzoom') ?>') {this.value = '';}" value="<?php _e('Search', 'wpzoom') ?>" name="s" id="setop" />
		<input type="submit" id="searchsubmit" value="<?php _e('Search', 'wpzoom') ?>" />
	</fieldset>
</form>
 