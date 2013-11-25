<?php

/**
 * Theme Options Page
 */
function rm_options_page(){    
	global $rm_changelog_link, $rm_docs_link;
	$rm_options = get_option('rm_framework_options');
    ksort($rm_options['rm_framework']);
    ?>
    <div id="rm-framework-messages">
        <?php if(isset($_GET['activated'])){ ?>
        <div class="updated" id="message"><p><?php _e( $rm_options['theme_name'] .' activated', 'rm' ); ?></p></div>
        <?php } ?>
    </div>
	<div id="rm-framework" class="clearfix">
		<form action="<?php echo site_url() .'/wp-admin/admin-ajax.php'; ?>" method="post">
			<div class="header clearfix">
			    <a href="http://rockablemedia.com" target="_blank" class="rm-logo">
			        <img src="<?php echo get_bloginfo('template_directory'); ?>/framework/images/logo.png" alt="Rockability" />
		        </a>
				<h1 class="theme-name"><?php _e( $rm_options['theme_name'], 'rm' ); ?></h1>
				<span class="theme-version">v.<?php echo $rm_options['theme_version']; ?></span>
				<ul class="theme-links">
					<li><a href="http://www.facebook.com/rockables" target="_blank" class="forums"><?php _e( 'Follow us', 'rm' ); ?></a></li>
					<li><a href="http://twitter.com/rockable_media" class="themes"><?php _e( '@rockable_media', 'rm' ); ?></a></li>
				</ul>
			</div>
			<div class="main clearfix">
				<div class="nav">
					<ul>
                    
						<?php foreach( $rm_options['rm_framework'] as $page ){ ?>
                        
                        <li><a href="#<?php echo rm_to_slug( key($page) ); ?>"><?php _e( key($page), 'rm' ); ?></a></li>
                        
                        <?php } ?>
                        
					</ul>
				</div>
				<div class="content">
                
					<?php foreach( $rm_options['rm_framework'] as $page ){ ?>
                    
                    <div id="page-<?php echo rm_to_slug( key($page) ); ?>" class="page">
                        <h2><?php _e( key($page), 'rm' ); ?></h2>
                        <p class="page-desc"><?php 
                        if( isset($page[key($page)]['description']) && $page[key($page)]['description'] != '') _e( $page[key($page)]['description'], 'rm' ); 
                        ?></p>
                        <?php foreach( $page[key($page)] as $item ){ ?>
                        	<?php if(key((array)$item) == 'description') continue; ?>
                            <div class="section <?php echo rm_to_slug( $item['title'] ); ?>">
                                <h3><?php _e( $item['title'], 'rm' ); ?></h3>
                                <?php if(isset($item['desc']) && $item['desc'] != ''){ ?>
                                <div class="desc">
                                    <?php _e( $item['desc'], 'rm' ); ?>
                                </div>
                                <?php } ?>
                                <?php rm_create_input( $item ); ?>
                                <div class="rm-clear"></div>
                            </div>
                        <?php } ?>
                        
                    </div>
                    
                    <?php } ?>
				</div>
				<div class="rm-clear"></div>
			</div>
			<div class="footer clearfix">
                <input type="hidden" name="action" value="rm_framework_save" />
                <input type="hidden" name="rm_noncename" id="rm_noncename" value="<?php echo wp_create_nonce('rm_framework_options'); ?>" />
                <input type="button" value="<?php _e( 'Reset Options', 'rm' ); ?>" class="button" id="reset-button" />
                <input type="submit" value="<?php _e( 'Save All Changes', 'rm' ); ?>" class="button-primary" id="save-button" />
			</div>
		</form>
	</div>
    
	<?php if( RM_DEBUG ){ ?>
    <div id="rm-debug">
        <p><strong>Debug Output</strong></p>
        <textarea><?php 
        echo '//rm_framework_values'."\n";
        print_r(get_option('rm_framework_values'));
        echo '//rm_framework_options'."\n";
        print_r($rm_options);
        echo '//misc'."\n";
        echo 'TEMPLATEPATH: '. TEMPLATEPATH;
        ?></textarea>
    </div>
    <?php }
}

/**
 * AJAX Save Options
 */
function rm_framework_save(){
    $response['error'] = false;
    $response['message'] = '';
    $response['type'] = '';
    
    // Verify this came from the our screen and with proper authorization
    if(!isset($_POST['rm_noncename']) || !wp_verify_nonce($_POST['rm_noncename'], plugin_basename('rm_framework_options'))){
        $response['error'] = true;
        $response['message'] = __('You do not have sufficient permissions to save these options.', 'rm' );
        echo json_encode($response);
    	die;
    }
            
    $rm_values = get_option('rm_framework_values');
    foreach( $_POST['settings'] as $key => $val ){
        $rm_values[$key] = $val;
    }
    
    $rm_values = apply_filters( 'rm_framework_save', $rm_values ); // Pre save filter
    
    update_option('rm_framework_values', $rm_values);
    
    $response['message'] = __( 'Settings saved', 'rm' );    
    echo json_encode($response);
    die;
}
add_action('wp_ajax_rm_framework_save', 'rm_framework_save');

/**
 * AJAX Reset Options
 */
function rm_framework_reset(){
    $response['error'] = false;
    $response['message'] = '';
    
    // Verify this came from the our screen and with proper authorization
    if(!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], plugin_basename('rm_framework_options'))){
        $response['error'] = true;
        $response['message'] = __('You do not have sufficient permissions to reset these options.', 'rm' );
        echo json_encode($response);
    	die;
    }
            
    update_option('rm_framework_values', array());
      
    echo json_encode($response);
    die;
}
add_action('wp_ajax_rm_framework_reset', 'rm_framework_reset');
    
?>