<?php
/**
 * Add a Rockability specific option
 *
 * @param string $name The option name
 * @param string $value The option value
 */
function rm_add_option( $name, $value ){
    rm_update_option( $name, $value );
}

/**
 * Remove a Rockability specific option
 *
 * @param string $name The option name
 */
function rm_remove_option( $name ){
    $rm_values = get_option( 'rm_framework_values' );
    unset( $rm_values[$name] ); 
    update_option( 'rm_framework_values', $rm_values );
}

/**
 * Get a Removeockability specific option
 *
 * @param string $name The option name
 * @return object|bool Option value on success, false if no value exists
 */
function rm_get_option($name){
    $rm_values = get_option( 'rm_framework_values' );
    if( array_key_exists( $name, $rm_values ) ) return $rm_values[$name];
    return false;
}


/**
 * Update a Rockability specific option
 *
 * @param string $name The option name
 * @param string $value The new option value
 */
function rm_update_option( $name, $value ){
    $rm_values = get_option( 'rm_framework_values' );
    $rm_values[$name] = $value; 
    update_option( 'rm_framework_values', $rm_values );
}


/**
 * Create a custom hook definitions
 *
 * @since 0.1
 */
/* header.php -----------------------------------------------------------------*/
function rm_meta_head() { rm_do_contextual_hook('rm_meta_head'); }
function rm_head() { rm_do_contextual_hook('rm_head'); }
function rm_body_start() { rm_do_contextual_hook('rm_body_start'); }
function rm_header_before() { rm_do_contextual_hook('rm_header_before'); }
function rm_header_after() { rm_do_contextual_hook('rm_header_after'); }
function rm_header_start() { rm_do_contextual_hook('rm_header_start'); }
function rm_header_end() { rm_do_contextual_hook('rm_header_end'); }
function rm_nav_before() { rm_do_contextual_hook('rm_nav_before'); }
function rm_nav_after() { rm_do_contextual_hook('rm_nav_after'); }
function rm_content_start() { rm_do_contextual_hook('rm_content_start'); }

/* index.php, single.php, search.php, archive.php -----------------------------*/
function rm_post_before() { rm_do_contextual_hook('rm_post_before'); }
function rm_post_after() { rm_do_contextual_hook('rm_post_after'); }
function rm_post_start() { rm_do_contextual_hook('rm_post_start'); }
function rm_post_end() { rm_do_contextual_hook('rm_post_end'); }

/* page.php -------------------------------------------------------------------*/
function rm_page_before() { rm_do_contextual_hook('rm_page_before'); }
function rm_page_after() { rm_do_contextual_hook('rm_page_after'); }
function rm_page_start() { rm_do_contextual_hook('rm_page_start'); }
function rm_page_end() { rm_do_contextual_hook('rm_page_end'); }

/* single.php, page.php, templates with comments ------------------------------*/
function rm_comments_before() { rm_do_contextual_hook('rm_comments_before'); }
function rm_comments_after() { rm_do_contextual_hook('rm_comments_after'); }

/* sidebar.php ----------------------------------------------------------------*/
function rm_sidebar_before() { rm_do_contextual_hook('rm_sidebar_before'); }
function rm_sidebar_after() { rm_do_contextual_hook('rm_sidebar_after'); }
function rm_sidebar_start() { rm_do_contextual_hook('rm_sidebar_start'); }
function rm_sidebar_end() { rm_do_contextual_hook('rm_sidebar_end'); }

/* footer.php -----------------------------------------------------------------*/
function rm_content_end() { rm_do_contextual_hook('rm_content_end'); }
function rm_footer_before() { rm_do_contextual_hook('rm_footer_before'); }
function rm_footer_after() { rm_do_contextual_hook('rm_footer_after'); }
function rm_footer_start() { rm_do_contextual_hook('rm_footer_start'); }
function rm_footer_end() { rm_do_contextual_hook('rm_footer_end'); }
function rm_body_end() { rm_do_contextual_hook('rm_body_end'); }


/**
 * Adds contextual action hooks. Users do not need to use WordPress conditional tags
 * because this function handles the logic.
 * 
 * Basic hook would be 'rm_head'. rm_do_contextual_hook() function extends
 * the hook with context (i.e., 'rm_head_singular' or 'rm_head_home')
 * 
 * Thanks to Ptah Dunbar for this function
 * @link https://twitter.com/ptahdunbar
 * 
 * @since 0.1
 * @uses rm_get_query_context() Gets the context of the current page
 * @param string $tag Usually the location of the hook but defines the base hook
 */
if ( !function_exists( 'rm_do_contextual_hook' ) ) {
    function rm_do_contextual_hook( $tag = '', $args = '' ) {
        if ( !$tag ) { return false; }
        
        do_action( $tag, $args );
        
        foreach( (array) rm_get_query_context() as $context ) {
            do_action( "{$tag}_{$context}", $args );
        }
    }
}


/**
 * Retrieve the context of the queried template
 * 
 * @since 0.1
 * @return array $query_context
 */

if ( ! function_exists( 'rm_get_query_context' ) ) {
	function rm_get_query_context() {
		global $wp_query, $query_context;
		
		/* Return query_context if set -------------------------------------------*/
		if ( isset( $query_context->context ) && is_array( $query_context->context ) ) {
			return $query_context->context;
		} 
		
		/* Figure out the context ------------------------------------------------*/
		$query_context->context = array();
	
		/* Front page */
		if ( is_front_page() ) { 
		    $query_context->context[] = 'home'; 
		} 
	
		/* Blog page */
		if ( is_home() && ! is_front_page() ) {
			$query_context->context[] = 'blog';
			
        /* Singular views. */
		} elseif ( is_singular() ) { 

			$query_context->context[] = 'singular';
			$query_context->context[] = "singular-{$wp_query->post->post_type}";
		
			/* Page Templates. */
			if ( is_page_template() ) {
				$to_skip = array( 'page', 'post' );
			
				$page_template = basename( get_page_template() );
				$page_template = str_replace( '.php', '', $page_template );
				$page_template = str_replace( '.', '-', $page_template );
			
				if ( $page_template && ! in_array( $page_template, $to_skip ) ) {
					$query_context->context[] = $page_template;
				}
			}
			
			$query_context->context[] = "singular-{$wp_query->post->post_type}-{$wp_query->post->ID}";
		}
	
		/* Archive views. */
		elseif ( is_archive() ) {
			$query_context->context[] = 'archive';
	
			/* Taxonomy archives. */
			if ( is_tax() || is_category() || is_tag() ) {
				$term = $wp_query->get_queried_object();
				$query_context->context[] = 'taxonomy';
				$query_context->context[] = $term->taxonomy;
				$query_context->context[] = "{$term->taxonomy}-" . sanitize_html_class( $term->slug, $term->term_id );
			}
	
			/* User/author archives. */
			elseif ( is_author() ) {
				$query_context->context[] = 'user';
				$query_context->context[] = 'user-' . sanitize_html_class( get_the_author_meta( 'user_nicename', get_query_var( 'author' ) ), $wp_query->get_queried_object_id() );
			}
	
			/* Time/Date archives. */
			else {
				if ( is_date() ) {
					$query_context->context[] = 'date';
					if ( is_year() )
						$query_context->context[] = 'year';
					if ( is_month() )
						$query_context->context[] = 'month';
					if ( get_query_var( 'w' ) )
						$query_context->context[] = 'week';
					if ( is_day() )
						$query_context->context[] = 'day';
				}
				if ( is_time() ) {
					$query_context->context[] = 'time';
					if ( get_query_var( 'hour' ) )
						$query_context->context[] = 'hour';
					if ( get_query_var( 'minute' ) )
						$query_context->context[] = 'minute';
				}
			}
		}
	
		/* Search results. */
		elseif ( is_search() ) {
			$query_context->context[] = 'search';
			
		/* Error 404 pages. */
		} elseif ( is_404() ) {
			$query_context->context[] = 'error-404';
		}
		
		return $query_context->context;
	} 
}


/**
 * Add metatags with Theme and Framework Versions
 * 
 * @since 0.1
 */
function rm_add_version_meta() {
    $theme_data = get_theme_data(get_template_directory() .'/style.css');

    echo '<meta name="generator" content="' . $theme_data['Name'] . ' ' . $theme_data['Version'] .'" />' . "\n";
	echo '<meta name="generator" content="rmFramework ' . RM_FRAMEWORK_VERSION . '" />' . "\n";
}
add_action('rm_meta_head', 'rm_add_version_meta');


/**
 * Add featured image to RSS feed
 * 
 * @param string $content
 * @return string $content
 */
function rm_add_featured_image_to_RSS($content) {
    global $post;
    if( has_post_thumbnail($post->ID) ) {
        $content = '<div style="float:left;">' . get_the_post_thumbnail($post->ID, 'archive-thumb') . '</div>' . $content;
    }

    return $content;
}
add_filter('the_excerpt_rss', 'rm_add_featured_image_to_RSS');
add_filter('the_content_feed', 'rm_add_featured_image_to_RSS');
 

/**
 * Add browser detection and post name to body class
 * Add post title to body class on single pages
 *
 * @link http://www.wprecipes.com/wordpress-hack-automatically-add-post-name-to-the-body-class
 * @param array $classes The current body classes
 * @return array The new body classes
 */
if ( !function_exists( 'rm_browser_body_class' ) ) {
	function rm_body_classes($classes) {
	    // Add our browser class
		global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;
	
		if($is_lynx) $classes[] = 'lynx';
		elseif($is_gecko) $classes[] = 'gecko';
		elseif($is_opera) $classes[] = 'opera';
		elseif($is_NS4) $classes[] = 'ns4';
		elseif($is_safari) $classes[] = 'safari';
		elseif($is_chrome) $classes[] = 'chrome';
		elseif($is_IE){ 
			$classes[] = 'ie';
			if(preg_match('/MSIE ([0-9]+)([a-zA-Z0-9.]+)/', $_SERVER['HTTP_USER_AGENT'], $browser_version)) $classes[] = 'ie'.$browser_version[1];
		} else $classes[] = 'unknown';
	
		if($is_iphone) $classes[] = 'iphone';
		
		// Add the post title
		if( is_singular() ) {
    		global $post;
    		array_push( $classes, "{$post->post_type}-{$post->post_name}" );
    	}
    	
    	// Add 'rm'
    	array_push( $classes, "rm" );
    	
		return $classes;
	}
}
add_filter('body_class','rm_body_classes');


/**
 * Get cat ID from cat name
 *
 * @link http://www.wprecipes.com/wordpress-function-get-category-id-using-category-name
 * @param string $cat_name The category name
 * @return int The category id
 */
if ( !function_exists( 'get_category_id' ) ) {
	function get_category_id( $cat_name )
	{
		$term = get_term_by( 'name', $cat_name, 'category' );
		return $term->term_id;
	}
}

/**
 * Get "blog" URL
 *
 * @return string The URL of the "blog" page
 */
if ( !function_exists( 'rm_blog_url' ) ) {
    function rm_blog_url(){
        if( $posts_page_id = get_option('page_for_posts') ){
            return home_url(get_page_uri($posts_page_id));
        } else {
            return home_url();
        }
    }
}

/**
 * Get Google Webfonts
 *
 * @return string all google web fonts
 */
if (!function_exists('rm_get_google_fonts')) {
	function rm_get_google_fonts() {
		// Some settings
		$fonts_url  = 'http://demo.samuli.me/google-web-fonts/get.php';
		$cache_file = RM_DIR . '/cache/google-web-fonts.txt';
		$cache_time = 60 * 60 * 24 * 7;

		$cache_file_created = @file_exists($cache_file) ? @filemtime($cache_file) : 0;

		// Make sure curl is enabled
		if(is_callable('curl_init') && ini_get('allow_url_fopen')) {
			// Update only once a week
			if(time() - $cache_time > $cache_file_created) {
				// Fetch fonts
				$ch = curl_init();
				curl_setopt( $ch, CURLOPT_URL, $fonts_url );
				curl_setopt( $ch, CURLOPT_HEADER, 0 );
				curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
				$data = curl_exec( $ch );
				curl_close( $ch );

				// Update cache file
				$file = fopen( $cache_file , 'w');
				fwrite( $file, $data );
				fclose( $file );
			}
		}

		$fonts = unserialize(@file_get_contents($cache_file));
		return $fonts;
	}
}

/*-----------------------------------------------------------------------------------*/
/*	Filters that allow shortcodes in Text Widgets
/*-----------------------------------------------------------------------------------*/

add_filter('widget_text', 'shortcode_unautop');
add_filter('widget_text', 'do_shortcode');


/*-----------------------------------------------------------------------------------*/
/*	Remove Generator for Security
/*-----------------------------------------------------------------------------------*/

remove_action( 'wp_head', 'wp_generator' );
