<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head>
    <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

    <title><?php ui::title(); ?></title>

	<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url'); ?>" media="screen" />
    
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
    
	<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600,400italic' rel='stylesheet' type='text/css'>

    <?php wp_head(); ?>
</head>
<body <?php body_class() ?>>

<div id="container">

	<header>
	
		<div class="wrapper">

			<div id="logo">

				<?php if (!option::get('misc_logo_path')) { echo "<h1>"; } ?>
				
				<a href="<?php bloginfo('url'); ?>" title="<?php bloginfo('description'); ?>">
					<?php if (!option::get('misc_logo_path')) { bloginfo('name'); } else { ?>
						<img src="<?php echo ui::logo(); ?>" alt="<?php bloginfo('name'); ?>" />
					<?php } ?>
				</a>
				
				<?php if (!option::get('misc_logo_path')) { echo "</h1>"; } ?>

				<?php if (option::get('logo_desc') == 'on') {  ?><p id="tagline"><?php bloginfo('description'); ?></p><?php } ?>

			</div><!-- end #logo -->

			<?php if (option::get('menu_top_secondary_show') == 'on') { ?>
			<nav id="top-menu">
				<?php 
				
				if (option::get('social_icons_show') == 'on') {

					$menuSocial = '';
					if (strlen(option::get('misc_feedburner')) < 1) {
						$rssurl = get_bloginfo('rss2_url');
					} else {
						$rssurl = option::get('misc_feedburner');
					}

					$menuSocial = '<li class="social-icons">';
					if (option::get('social_icons_email')) { $menuSocial .= '<a href="mailto:' . option::get('social_icons_email') . '" rel="nofollow"><img src="' . get_bloginfo('template_url') . '/images/social/email_small.png" width="16" height="16" alt="" /></a>'; }
					if (option::get('social_icons_facebook')) { $menuSocial .= '<a href="' . option::get('social_icons_facebook') . '" rel="nofollow"><img src="' . get_bloginfo('template_url') . '/images/social/facebook_small.png" width="16" height="16" alt="" /></a>'; }
					if (option::get('social_icons_twitter')) { $menuSocial .= '<a href="' . option::get('social_icons_twitter') . '" rel="nofollow"><img src="' . get_bloginfo('template_url') . '/images/social/twitter_small.png" width="16" height="16" alt="" /></a>'; }
					if (option::get('social_icons_vimeo')) { $menuSocial .= '<a href="' . option::get('social_icons_vimeo') . '" rel="nofollow"><img src="' . get_bloginfo('template_url') . '/images/social/vimeo_small.png" width="16" height="16" alt="" /></a>'; }
					if (option::get('social_icons_yelp')) { $menuSocial .= '<a href="' . option::get('social_icons_yelp') . '" rel="nofollow"><img src="' . get_bloginfo('template_url') . '/images/social/yelp_small.png" width="16" height="16" alt="" /></a>'; }
					if (option::get('social_icons_youtube')) { $menuSocial .= '<a href="' . option::get('social_icons_youtube') . '" rel="nofollow"><img src="' . get_bloginfo('template_url') . '/images/social/youtube_small.png" width="16" height="16" alt="" /></a>'; }
					$menuSocial .= '<a href="' . $rssurl . '" rel="nofollow"><img src="' . get_bloginfo('template_url') . '/images/social/feed_small.png" width="16" height="16" alt="" /></a>';
					$menuSocial .= '</li>';
				} ?>
				
				<?php if (has_nav_menu( 'secondary' )) { 
					$menu = wp_nav_menu( array('container' => '', 'container_class' => '', 'menu_class' => '', 'menu_id' => '', 'sort_column' => 'menu_order', 'echo' => false, 'depth' => '1', 'theme_location' => 'secondary','items_wrap' => '<ul>%3$s'.$menuSocial.'</ul>' ) );
					print($menu);
				}
				else
				{
					echo '<p class="wpzoom-notice">Please set your Secondary Menu on the <a href="'.get_admin_url().'nav-menus.php">Appearance > Menus</a> page. For more information please <a href="http://www.wpzoom.com/documentation/academica-pro/">read the documentation</a></p>';
				}
				?>
			</nav><!-- end #top-menu -->
			<?php } ?>

			<?php if (option::get('tel_enable') == 'on') { ?>
			<div id="header-helpful">

				<?php if (option::get('search_form') == 'on') { ?>
				<div class="search-form">
				<?php get_template_part('searchform'); ?>
				</div><!-- end .search-form -->
				<?php } ?>

				<span class="action"><?php print(option::get('tel_caption')); ?><span class="value"><?php print(option::get('tel_text')); ?></span></span>
			</div><!-- end #header-helpful -->
			<?php } // if show header text ?>
			
			<div class="cleaner">&nbsp;</div>
		
		</div><!-- end .wrapper -->
	
	</header>

	<?php if (option::get('menu_top_show') == 'on') { ?>
	<nav id="nav-main-menu">

		<a class="btn_menu" id="toggle" href="#"></a>
		
		<div class="wrapper wrapper-menu">

			<?php if (has_nav_menu( 'primary' )) { 
				wp_nav_menu( array('container' => '', 'container_class' => '', 'menu_class' => 'dropdown', 'menu_id' => '', 'sort_column' => 'menu_order', 'theme_location' => 'primary','items_wrap' => '<ul id="menu-main" class="dropdown">%3$s<li class="cleaner">&nbsp;</li></ul>'  ) );
			}
			else
			{
				echo '<p class="wpzoom-notice">Please set your Main Menu on the <a href="'.get_admin_url().'nav-menus.php">Appearance > Menus</a> page. For more information please <a href="http://www.wpzoom.com/documentation/academica-pro/">read the documentation</a></p>';
			}
			?>
		
		</div><!-- end .wrapper .wrapper-menu -->
		
	</nav><!-- end #main-menu -->
	<?php } ?>