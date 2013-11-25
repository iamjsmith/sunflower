<?php

/*-----------------------------------------------------------------------------------

	Here we have all the custom functions for the theme
	Please be extremely cautious editing this file,
	When things go wrong, they tend to go wrong in a big way.
	You have been warned!

-------------------------------------------------------------------------------------*/


/*-----------------------------------------------------------------------------------*/
/*  Set Max Content Width (use in conjuction with ".entry-content img" css)
/* ----------------------------------------------------------------------------------*/
if (!isset($content_width)) $content_width = 540;


/*-----------------------------------------------------------------------------------*/
/*	Theme set up
/*-----------------------------------------------------------------------------------*/

if (!function_exists('rm_theme_setup')) {
    function rm_theme_setup() {
    		
    	/* Configure WP 2.9+ Thumbnails */
    	add_theme_support('post-thumbnails');
    }
}

add_action('after_setup_theme', 'rm_theme_setup');

// Remove Admin Bar
show_admin_bar(false);


/*-----------------------------------------------------------------------------------*/
/*	Register Sidebars
/*-----------------------------------------------------------------------------------*/

if (!function_exists( 'rm_sidebars_init')) {
    function rm_sidebars_init() {
    	register_sidebar(array(
    		'name' => __('Main Sidebar', 'rm'),
    		'id' => 'sidebar-main',
    		'before_widget' => '<div id="%1$s" class="widget %2$s">',
    		'after_widget' => '</div>',
    		'before_title' => '<h3 class="widget-title">',
    		'after_title' => '</h3>',
    	));
	}
}

add_action('widgets_init', 'rm_sidebars_init');


/*-----------------------------------------------------------------------------------*/
/*	Change Default Excerpt Length
/*-----------------------------------------------------------------------------------*/

if (!function_exists('rm_excerpt_length')) {
	function rm_excerpt_length($length) {
		return 55; 
	}
}

add_filter('excerpt_length', 'rm_excerpt_length');


/*-----------------------------------------------------------------------------------*/
/*	Configure Excerpt String
/*-----------------------------------------------------------------------------------*/

if (!function_exists('rm_excerpt_more')) {
	function rm_excerpt_more($excerpt) {
		return str_replace('[...]', '...', $excerpt); 
	}
}

add_filter('wp_trim_excerpt', 'rm_excerpt_more');


/*-----------------------------------------------------------------------------------*/
/*	Custom More Link Output
/*-----------------------------------------------------------------------------------*/

if ( !function_exists( 'rm_custom_more_link' ) ) {
    function rm_custom_more_link($more_link, $more_link_text) {
        return str_replace($more_link_text, "<span>$more_link_text</span>", $more_link);
   }
}
add_filter('the_content_more_link', 'rm_custom_more_link', 10, 2);


/*-----------------------------------------------------------------------------------*/
/*	Configure Default Title
/*-----------------------------------------------------------------------------------*/

if ( !function_exists( 'rm_wp_title' ) ) {
	function rm_wp_title($title) {
		if( !rm_is_third_party_seo() ){
			if( is_front_page() ){
				return get_bloginfo('name') .' | '. get_bloginfo('description'); 
			} else {
				return trim($title) .' | '. get_bloginfo('name'); 
			}
		}
		return $title;
	}
}
add_filter('wp_title', 'rm_wp_title');


/*-----------------------------------------------------------------------------------*/
/*	Register and load JS
/*-----------------------------------------------------------------------------------*/

if (!function_exists('rm_enqueue_scripts')) {
	function rm_enqueue_scripts() {
	    /* Register our scripts -----------------------------------------------------*/
		wp_deregister_script('jquery');
		wp_register_script('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js');
        wp_register_script('bootstrap', get_bloginfo('template_directory').'/js/bootstrap.min.js', 'jquery');

        wp_register_style('bootstrap', get_bloginfo('template_directory').'/css/bootstrap.min.css');
        wp_register_style('theme_style', get_bloginfo( 'stylesheet_url' ));

        $rm_font = rm_get_option('style_main_font');
        if(rm_get_option('style_main_font')) wp_register_style('rm_main_font', 'http://fonts.googleapis.com/css?family=' . $rm_font['face'], null, false);

		/* Enqueue our scripts ------------------------------------------------------*/
		wp_enqueue_script('jquery');
        wp_enqueue_script('bootstrap');

        wp_enqueue_style('bootstrap');
        wp_enqueue_style('theme_style');
		
        if(rm_get_option('style_main_font')) wp_enqueue_style('rm_main_font');
	}
}

add_action('wp_enqueue_scripts', 'rm_enqueue_scripts');


/*-----------------------------------------------------------------------------------*/
/*	Register and load admin javascript
/*-----------------------------------------------------------------------------------*/

if ( !function_exists('rm_enqueue_admin_scripts')) {
    function rm_enqueue_admin_scripts() {
        wp_register_script('rm-admin', get_template_directory_uri() . '/includes/js/jquery.custom.admin.js', 'jquery');
        wp_enqueue_script('rm-admin');
    }
}

add_action( 'admin_enqueue_scripts', 'rm_enqueue_admin_scripts' );

/*-----------------------------------------------------------------------------------*/
/*	Clean up wp_head
/*-----------------------------------------------------------------------------------*/

remove_action( 'wp_head', 'feed_links_extra');
remove_action( 'wp_head', 'feed_links');
remove_action( 'wp_head', 'rsd_link');
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'index_rel_link' );
remove_action( 'wp_head', 'parent_post_rel_link', 10);
remove_action( 'wp_head', 'start_post_rel_link', 10);
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10);
remove_action( 'wp_head', 'wp_generator');



/*-----------------------------------------------------------------------------------*/
/*	Include the Rockability Framework
/*-----------------------------------------------------------------------------------*/

$tempdir = get_template_directory();
require_once($tempdir .'/framework/init.php');
require_once($tempdir .'/includes/init.php');

?>