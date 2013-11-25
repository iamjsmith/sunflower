<?php

/**
 * Create the General Settings section
 */
add_action('admin_init', 'rm_general_settings');

function rm_general_settings(){
    $general_settings['description'] = 'Control and configure the general setup of your theme. Upload your preferred logo, setup your feeds and insert your analytics tracking code.';
                                
	$general_settings[] = array('title' => 'Custom Logo Upload',
                                'desc' => 'Upload a logo for your theme.',
                                'type' => 'file',
                                'id' => 'general_custom_logo',
                                'val' => 'Upload Image');
                                
    $general_settings[] = array('title' => 'Custom Favicon Upload',
                                'desc' => 'Upload a 16px x 16px Png/Gif image that will represent your website\'s favicon.',
                                'type' => 'file',
                                'id' => 'general_custom_favicon',
                                'val' => 'Upload Image');
                                
    rm_add_framework_page( 'General Settings', $general_settings, 5 );
}


/* Output the favicon */
function rm_custom_favicon() {
    $rm_values = get_option( 'rm_framework_values' );
    if( array_key_exists( 'general_custom_favicon', $rm_values ) && $rm_values['general_custom_favicon'] != '' )
        echo '<link rel="shortcut icon" href="'. $rm_values['general_custom_favicon'] .'" />' . "\n";
}

add_action( 'wp_head', 'rm_custom_favicon' );

?>