<?php

/**
 * Create the SEO metaboxes
 */
 
add_action('add_meta_boxes', 'rm_metabox_seo');
function rm_metabox_seo(){
    
    /* Create the SEO metabox ----------------------------------------------*/
	$meta_box = array(
		'id' => 'rm_metabox_seo',
		'title' =>  __('SEO Settings', 'rm'),
		'description' => __('These settings enable you to customize the SEO settings for this post/page.', 'rm'),
		'page' => 'post',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array( 
					'name' => __('Title', 'rm'),
					'desc' => __('Most search engines use a maximum of 60 chars for the title.', 'rm'),
					'id' => '_rm_seo_title',
					'type' => 'text',
					'std' => ''
				),
			array( 
					'name' => __('Description', 'rm'),
					'desc' => __('Most search engines use a maximum of 160 chars for the description.', 'rm'),
					'id' => '_rm_seo_description',
					'type' => 'text',
					'std' => ''
				),
			array( 
					'name' => __('Keywords', 'rm'),
					'desc' => __('A comma separated list of keywords', 'rm'),
					'id' => '_rm_seo_keywords',
					'type' => 'text',
					'std' => ''
				),
			array( 
					'name' => __('Meta Robots Index', 'rm'),
					'desc' => __('Do you want robots to index this page?', 'rm'),
					'id' => '_rm_seo_robots_index',
					'type' => 'radio',
					'std' => 'index',
					'options' => array('index', 'noindex')
				),
			array( 
					'name' => __('Meta Robots Follow', 'rm'),
					'desc' => __('Do you want robots to follow links from this page?', 'rm'),
					'id' => '_rm_seo_robots_follow',
					'type' => 'radio',
					'std' => 'follow',
					'options' => array('follow', 'nofollow')
				)
		)
	);
	
	if( !rm_is_third_party_seo() ){
		// Posts
		rm_add_meta_box( $meta_box );
		// Pages
		$meta_box['page'] = 'page';
		rm_add_meta_box( $meta_box );
	}
}


/**
 * Edit the Title
 */
function rm_metabox_seo_title($title) {
	global $post;

	if( $post && !rm_is_third_party_seo() ) {
	    if( is_home() || is_archive() || is_search() ) { 
	        $postid = get_option('page_for_posts'); 
	    } else {
	        $postid = $post->ID;
	    }
	    
		if( $seo_title = get_post_meta( $postid, '_rm_seo_title', true ) ) {
			return $seo_title;
		}
	}
	return $title;
}
add_filter('wp_title', 'rm_metabox_seo_title', 15);


/**
 * Add the Description
 */
function rm_metabox_seo_description() {
	global $post;
	
	if( $post && !rm_is_third_party_seo() ) {
	    if( is_home() || is_archive() || is_search() ) { 
	        $postid = get_option('page_for_posts'); 
	    } else {
	        $postid = $post->ID;
	    }
	    
		if( $seo_description = get_post_meta( $postid, '_rm_seo_description', true ) ){
			echo '<meta name="description" content="'. esc_html(strip_tags($seo_description)) .'" />' . "\n";
		}
	}
}
add_action('rm_meta_head', 'rm_metabox_seo_description');


/**
 * Add the Keywords
 */
function rm_metabox_seo_keywords() {
	global $post;
	
	if( $post && !rm_is_third_party_seo() ) {
	    if( is_home() || is_archive() || is_search() ) { 
	        $postid = get_option('page_for_posts'); 
	    } else {
	        $postid = $post->ID;
	    }
	    
		if( $seo_keywords = get_post_meta( $postid, '_rm_seo_keywords', true ) ){
			echo '<meta name="keywords" content="'. esc_html(strip_tags($seo_keywords)) .'" />' . "\n";
		}
	}
}
add_action('rm_meta_head', 'rm_metabox_seo_keywords');


/**
 * Add the Robots Meta
 */
function rm_metabox_seo_robots() {
	global $post;
	
	if( $post && !rm_is_third_party_seo() && get_option('blog_public') == 1 ){
	    if( is_home() || is_archive() || is_search() ) { 
	        $postid = get_option('page_for_posts'); 
	    } else {
	        $postid = $post->ID;
	    }
	    
		$seo_index = get_post_meta( $postid, '_rm_seo_robots_index', true );
		$seo_follow = get_post_meta( $postid, '_rm_seo_robots_follow', true );
		if( !$seo_index ) $seo_index = 'index';
		if( !$seo_follow ) $seo_follow = 'follow';
		
		if( !($seo_index == 'index' && $seo_follow == 'follow') )
			echo '<meta name="robots" content="'. $seo_index .','. $seo_follow .'" />' . "\n";
	}
}
add_action('rm_meta_head', 'rm_metabox_seo_robots');