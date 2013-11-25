<?php

/** Set some basic info **/
function rm_admin_init() {
    // Redirect if theme has just been activated
    if(rm_is_theme_activated()){
    	flush_rewrite_rules();
    	header( 'Location: '. home_url() .'/wp-admin/admin.php?page=rm&activated=true' );
    }
    
    // Enable sessions
    if(!isset($_SESSION)) {
        session_start();
    }
    
    // Get theme and framework info
    $theme_data = get_theme_data(TEMPLATEPATH.'/style.css');
	$data = get_option('rm_framework_options');
	$data['theme_name'] = $theme_data['Name'];
    $data['theme_version'] = $theme_data['Version'];
	$data['framework_version'] = RM_FRAMEWORK_VERSION;
    $data['rm_framework'] = array();
	update_option('rm_framework_options', $data);
    
    // Incase it is first install and option doesn't exist
    $rm_values = get_option('rm_framework_values');
    if(!is_array($rm_values)) update_option( 'rm_framework_values', array());
}

add_action('init', 'rm_admin_init', 2);

/** Load admin CSS **/
function rm_admin_styles() {
	wp_enqueue_style('rm_admin_css', RM_URL .'/styles/rm-admin.css');
	wp_enqueue_style('rm_jgrowl', RM_URL .'/scripts/jgrowl/jquery.jgrowl.css');
    wp_enqueue_style('color-picker', RM_URL .'/styles/colorpicker.css');
	wp_enqueue_style('farbtastic');
}

add_action('admin_print_styles', 'rm_admin_styles');
 
/** Load admin JS **/
function rm_admin_scripts() {
    wp_register_script('rm-ajaxupload', RM_URL .'/scripts/ajaxupload.js', array('jquery'));
    wp_enqueue_script('rm-ajaxupload');  
    wp_register_script('rm-jgrowl', RM_URL .'/scripts/jgrowl/jquery.jgrowl_min.js', array('jquery'));
    wp_enqueue_script('rm-jgrowl'); 
    wp_register_script('rm-color-picker', RM_URL .'/scripts/colorpicker.js', array('jquery'));
    wp_enqueue_script('rm-color-picker');
    wp_register_script('rm-framework-admin', RM_URL .'/scripts/rm-admin.js', array('jquery','farbtastic'));
    wp_enqueue_script('rm-framework-admin'); 
    wp_enqueue_script('jquery');
    wp_enqueue_style('farbtastic');
}

add_action('admin_enqueue_scripts', 'rm_admin_scripts');

/** Add the Framework to the menu **/
function rm_menu(){
	$rm_options = get_option('rm_framework_options');
	$icon = RM_URL .'/images/favicon.png';

	// Theme Options page
    add_menu_page( __('Rockability', 'rm'), __('Rockability', 'rm'), 'manage_options', 'rm', 'rm_options_page', $icon);
}

add_action('admin_menu', 'rm_menu');


/** Output custom styles CSS file **/
function rm_link_custom_styles() {
    $output = '';
    if( apply_filters('rm_custom_styles', $output) ) {
        echo '<link rel="stylesheet" href="'. home_url() .'/rm-custom-styles.css?'. time() .'" type="text/css" media="screen" />' . "\n";
    }
}

add_action('wp_head', 'rm_link_custom_styles', 12);

/** Create custom styles CSS file **/
function rm_create_custom_styles() {
	if(preg_replace('/\\?.*/', '', basename($_SERVER["REQUEST_URI"])) == 'rm-custom-styles.css'){
	    $output = '';
		header('Content-Type: text/css');
		echo apply_filters('rm_custom_styles', $output);
		exit;
	}
}

add_action('init', 'rm_create_custom_styles');

?>