<?php

/**
 * Create the Post meta boxes
 */
 
add_action('add_meta_boxes', 'rm_metabox_posts');
function rm_metabox_posts(){
    
    /* Create an image metabox -------------------------------------------------------*/
	$meta_box = array(
		'id' => 'rm-metabox-post-image',
		'title' =>  __('Image & Display Settings', 'rm'),
		'description' => __('Upload images to this portfolio using the below controls. Please note that the Featured Image will be used as the "cover" image and will be skipped in the gallery.', 'rm'),
		'page' => 'post',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
    		array(
    				'name' =>  __('Upload Images', 'rm'),
    				'desc' => __('Click to upload images to this post.', 'rm'),
    				'id' => '_rm_image_upload',
    				'type' => 'images',
    				'std' => __('Upload Images', 'rm')
    			)
		)
	);
    rm_add_meta_box( $meta_box );
    
    /* Create a quote metabox -----------------------------------------------------*/
    $meta_box = array(
		'id' => 'rm-metabox-post-quote',
		'title' =>  __('Quote Settings', 'rm'),
		'description' => __('Input your quote.', 'rm'),
		'page' => 'post',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
					'name' =>  __('The Quote', 'rm'),
					'desc' => __('Input your quote.', 'rm'),
					'id' => '_rm_quote_quote',
					'type' => 'textarea',
                    'std' => ''
				)
		)
	);
    rm_add_meta_box( $meta_box );
	
	/* Create a link metabox ----------------------------------------------------*/
	$meta_box = array(
		'id' => 'rm-metabox-post-link',
		'title' =>  __('Link Settings', 'rm'),
		'description' => __('Input your link', 'rm'),
		'page' => 'post',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
					'name' =>  __('The Link', 'rm'),
					'desc' => __('Insert your link URL, e.g. http://www.themerm.com.', 'rm'),
					'id' => '_rm_link_url',
					'type' => 'text',
					'std' => ''
				)
		)
	);
    rm_add_meta_box( $meta_box );
    
    /* Create a video metabox -------------------------------------------------------*/
    $meta_box = array(
		'id' => 'rm-metabox-post-video',
		'title' => __('Video Settings', 'rm'),
		'description' => __('These settings enable you to embed videos into your posts.', 'rm'),
		'page' => 'post',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array( 
					'name' => __('Video Height', 'rm'),
					'desc' => __('The video height (e.g. 500).', 'rm'),
					'id' => '_rm_video_height',
					'type' => 'text',
					'std' => ''
				),
			array( 
					'name' => __('M4V File URL', 'rm'),
					'desc' => __('The URL to the .m4v video file', 'rm'),
					'id' => '_rm_video_m4v',
					'type' => 'text',
					'std' => ''
				),
			array( 
					'name' => __('OGV File URL', 'rm'),
					'desc' => __('The URL to the .ogv video file', 'rm'),
					'id' => '_rm_video_ogv',
					'type' => 'text',
					'std' => ''
				),
			array( 
					'name' => __('Poster Image', 'rm'),
					'desc' => __('The preview image. The preview image should be 500px wide.', 'rm'),
					'id' => '_rm_video_poster_url',
					'type' => 'text',
					'std' => ''
				),
			array(
					'name' => __('Embedded Code', 'rm'),
					'desc' => __('If you are using something other than self hosted video such as Youtube or Vimeo, paste the embed code here. Width is best at 500px with any height.<br><br> This field will override the above.', 'rm'),
					'id' => '_rm_video_embed_code',
					'type' => 'textarea',
					'std' => ''
				)
		)
	);
	rm_add_meta_box( $meta_box );
	
	/* Create an audio metabox ------------------------------------------------------*/
	$meta_box = array(
		'id' => 'rm-metabox-post-audio',
		'title' =>  __('Audio Settings', 'rm'),
		'description' => __('These settings enable you to embed audio into your posts. You must provide both .mp3 and .agg/.oga file formats in order for self hosted audio to function accross all browsers.', 'rm'),
		'page' => 'post',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array( 
					'name' => __('MP3 File URL', 'rm'),
					'desc' => __('The URL to the .mp3 audio file', 'rm'),
					'id' => '_rm_audio_mp3',
					'type' => 'text',
					'std' => ''
				),
			array( 
					'name' => __('OGA File URL', 'rm'),
					'desc' => __('The URL to the .oga, .ogg audio file', 'rm'),
					'id' => '_rm_audio_ogg',
					'type' => 'text',
					'std' => ''
				),
			array( 
					'name' => __('Audio Poster Image', 'rm'),
					'desc' => __('The preview image for this audio track. Image width should be 500px.', 'rm'),
					'id' => '_rm_audio_poster_url',
					'type' => 'text',
					'std' => ''
				),
			array( 
					'name' => __('Audio Poster Image Height', 'rm'),
					'desc' => __('The height of the poster image', 'rm'),
					'id' => '_rm_audio_height',
					'type' => 'text',
					'std' => ''
				)
		)
	);
	rm_add_meta_box( $meta_box );
}