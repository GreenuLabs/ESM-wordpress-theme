<?php 
/*-----------------------------------------------------------------------------------*/
/* Initializing Widgetized Areas (Sidebars)																			 */
/*-----------------------------------------------------------------------------------*/

/*----------------------------------*/
/* Homepage widgetized areas		*/
/*----------------------------------*/
 
register_sidebar(array(
'name'=>'Homepage: Content Widgets',
'id' => 'home',
'before_widget' => '<div class="widget %2$s" id="%1$s">',
'after_widget' => '<div class="cleaner">&nbsp;</div></div>',
'before_title' => '<p class="title">',
'after_title' => '</p>',
));

/*----------------------------------*/
/* Sidebar							*/
/*----------------------------------*/
 
register_sidebar(array(
'name'=>'Sidebar: Left Column',
'id' => 'sidebar-left',
'before_widget' => '<div class="widget %2$s" id="%1$s">',
'after_widget' => '<div class="cleaner">&nbsp;</div></div>',
'before_title' => '<p class="title">',
'after_title' => '</p>',
));

register_sidebar(array(
'name'=>'Sidebar: Right Column',
'id' => 'sidebar-right',
'before_widget' => '<div class="widget %2$s" id="%1$s">',
'after_widget' => '<div class="cleaner">&nbsp;</div></div>',
'before_title' => '<p class="title">',
'after_title' => '</p>',
));

/*----------------------------------*/
/* Footer widgetized areas		*/
/*----------------------------------*/

register_sidebar(array('name'=>'Footer: Column 1',
'id' => 'footer-column-1',
'before_widget' => '<div class="widget %2$s" id="%1$s">',
'after_widget' => '<div class="cleaner">&nbsp;</div></div>',
'before_title' => '<p class="title">',
'after_title' => '</p>',
));

register_sidebar(array('name'=>'Footer: Column 2',
'id' => 'footer-column-2',
'before_widget' => '<div class="widget %2$s" id="%1$s">',
'after_widget' => '<div class="cleaner">&nbsp;</div></div>',
'before_title' => '<p class="title">',
'after_title' => '</p>',
));

register_sidebar(array('name'=>'Footer: Column 3',
'id' => 'footer-column-3',
'before_widget' => '<div class="widget %2$s" id="%1$s">',
'after_widget' => '<div class="cleaner">&nbsp;</div></div>',
'before_title' => '<p class="title">',
'after_title' => '</p>',
));

register_sidebar(array('name'=>'Footer: Column 4',
'id' => 'footer-column-4',
'before_widget' => '<div class="widget %2$s" id="%1$s">',
'after_widget' => '<div class="cleaner">&nbsp;</div></div>',
'before_title' => '<p class="title">',
'after_title' => '</p>',
));