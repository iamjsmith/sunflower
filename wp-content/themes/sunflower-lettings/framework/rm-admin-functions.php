<?php

/**
 * Convert a string to a slug
 *
 * @param string $str Input string
 * @return string Valid URL string
 */
function rm_to_slug($str) {
	$str = strtolower(trim($str));
	$str = preg_replace('/[^a-z0-9-]/', '-', $str);
	$str = preg_replace('/-+/', "-", $str);
	return $str;
}

/* Font Sizes */
function rm_font_sizes() {
    $sizes = range( 9, 71 );
    $sizes = apply_filters( 'rm_font_sizes', $sizes );
    $sizes = array_map( 'absint', $sizes );
    return $sizes;
}

/* Font Faces */
function rm_font_faces() {
    $default = rm_get_google_fonts();
    return apply_filters('rm_font_faces', $default);
}

/* Font Styles */
function rm_font_styles() {
    $default = array(
        'normal'      => __('Normal', 'ss_framework'),
        'italic'      => __('Italic', 'ss_framework'),
        'bold'        => __('Bold', 'ss_framework'),
        'bold italic' => __('Bold Italic', 'ss_framework')
        );
    return apply_filters( 'rm_font_styles', $default );
}

/* Uploader */
function rm_uploader_scripts() {
    wp_enqueue_script('media-upload');
    wp_enqueue_script('thickbox');
    wp_register_script('my-upload', RM_URL.'/scripts/rm-uploader.js', array('jquery','media-upload','thickbox'));
    wp_enqueue_script('my-upload');
}

add_action('admin_print_scripts', 'rm_uploader_scripts');

function rm_uploader_styles() {
    wp_enqueue_style('thickbox');
}

add_action('admin_print_styles', 'rm_uploader_styles');


/**
 * Parse inputs for Framework Settings page
 *
 * @param array $item Array holding input item values
 */
function rm_create_input($item) {
    $rm_values = get_option('rm_framework_values');
    
    echo '<div class="input '. rm_to_slug($item['type']) .'">';
    
    // Set the class
    $class = '';
    if(array_key_exists('class', $item)) $class = ' class="'. $item['class'] .'"';
    // Do we ignore this input?
    $prefix = 'settings';
    if(array_key_exists('ignore', $item) && $item['ignore'] == true) $prefix = 'ignore';
    
    
    // text input
    if($item['type'] == 'text') {
        $val = '';
        if(array_key_exists('val', $item)) $val = ' value="'. $item['val'] .'"';
        if(array_key_exists($item['id'], $rm_values)) $val = ' value="'. $rm_values[$item['id']] .'"';
        echo '<input type="text" id="'. $item['id'] .'" name="'. $prefix .'['. $item['id'] .']"'. $val . $class .' />';
    }

    // textarea
    if($item['type'] == 'textarea') {
        $val = '';
        if(array_key_exists('val', $item)) $val = $item['val'];
        if(array_key_exists($item['id'], $rm_values)) $val = $rm_values[$item['id']];
        echo '<textarea id="'. $item['id'] .'" name="'. $prefix .'['. $item['id'] .']"'. $class .'>'. stripslashes($val) .'</textarea>';
    }

    // select
    if($item['type'] == 'select' && array_key_exists('options', $item)) {
        echo '<select id="'. $item['id'] .'" name="'. $prefix .'['. $item['id'] .']"'. $class .'>';
        foreach($item['options'] as $key=>$value){   
            $val = '';
            if(array_key_exists($item['id'], $rm_values)){
                if($rm_values[$item['id']] == $key) $val = ' selected="selected"';
            } else {
                if(array_key_exists('val', $item) && $item['val'] == $key) $val = ' selected="selected"';
            }
            echo '<option value="'. $key .'"'. $val .'>'. __( $value, 'rm' ) .'</option>';
        }
        echo '</select>';
    }

    // pages select
    if($item['type'] == 'pages') {
        $rm_pages_obj = get_pages();
        
        echo '<select id="'. $item['id'] .'" name="'. $prefix .'['. $item['id'] .']"'. $class .'>';
        foreach($rm_pages_obj as $rm_page){   
            $val = '';
            if(array_key_exists($item['id'], $rm_values)){
                if($rm_values[$item['id']] == $rm_page->ID) $val = ' selected="selected"';
            } else {
                if(array_key_exists('val', $item) && $item['val'] == $rm_page->ID) $val = ' selected="selected"';
            }
            echo '<option value="'. $rm_page->ID .'"'. $val .'>'. __( $rm_page->post_title, 'rm' ) .'</option>';
        }
        echo '</select>';
    }

    // category select
    if($item['type'] == 'categories') {
        $rm_categories_obj = get_categories('hide_empty=0');
        
        echo '<select id="'. $item['id'] .'" name="'. $prefix .'['. $item['id'] .']"'. $class .'>';
        foreach($rm_categories_obj as $rm_category){   
            $val = '';
            if(array_key_exists($item['id'], $rm_values)){
                if($rm_values[$item['id']] == $rm_category->cat_ID) $val = ' selected="selected"';
            } else {
                if(array_key_exists('val', $item) && $item['val'] == $rm_category->cat_ID) $val = ' selected="selected"';
            }
            echo '<option value="'. $rm_category->cat_ID .'"'. $val .'>'. __( $rm_category->cat_name, 'rm' ) .'</option>';
        }
        echo '</select>';
    }

	// radio
    if($item['type'] == 'radio' && array_key_exists('options', $item)) {
    	$i = 0;
        foreach($item['options'] as $key=>$value){   
            $val = '';
            if(array_key_exists($item['id'], $rm_values)){
                if($rm_values[$item['id']] == $key) $val = ' checked="checked"';
            } else {
                if(array_key_exists('val', $item) && $item['val'] == $key) $val = ' checked="checked"';
            }
            echo '<label for="'. $item['id'] .'_'. $i .'"><input type="radio" id="'. $item['id'] .'_'. $i .'" name="'. $prefix .'['. $item['id'] .']" value="'. $key .'"'. $val . $class .'> '. __( $value, 'rm' ) .'</label><br />';
            $i++;
        }
    }

    // checkbox
    if($item['type'] == 'checkbox') {
        $val = '';
        if(array_key_exists('val', $item) && $item['val'] == 'on') $val = ' checked="yes"';
        if(array_key_exists($item['id'], $rm_values) && $rm_values[$item['id']] == 'on') $val = ' checked="yes"';
        if(array_key_exists($item['id'], $rm_values) && $rm_values[$item['id']] != 'on') $val = '';
        echo '<input type="hidden" name="'. $prefix .'['. $item['id'] .']" value="off" />
        <input type="checkbox" id="'. $item['id'] .'" name="'. $prefix .'['. $item['id'] .']" value="on"'. $class . $val .' /> ';
        if(array_key_exists('text', $item)) _e( $item['text'], 'rm' );
    }

    // multi checkbox
    if($item['type'] == 'multi_checkbox' && array_key_exists('options', $item)) {
        foreach($item['options'] as $key=>$value){  
            $val = '';
            $id = $item['id'].'_'.rm_to_slug($key);
            if($value == 'on') $val = ' checked="yes"';
            if(array_key_exists($id, $rm_values) && $rm_values[$id] == 'on') $val = ' checked="yes"';
            if(array_key_exists($id, $rm_values) && $rm_values[$id] != 'on') $val = '';
            echo '<input type="hidden" name="'. $prefix .'['. $id .']" value="off" />
            <input type="checkbox" id="'. $id .'" name="'. $prefix .'['. $id .']" value="on"'. $class . $val .' /> ';
            echo '<label for="'. $id .'">'. __( $key, 'rm' ) .'</label><br />';
        }
    }

    // file
    if($item['type'] == 'file') {        
        echo '<input id="'. $item['id'] . '" class="upload_image" type="text" size="36" name="'. esc_attr( $prefix . '[' . $item['id'] . ']' ) .'" value="'. esc_attr($rm_values[$item['id']]) .'" />';
        echo '<input class="upload_image_button button-secondary" type="button" value="Upload" />';
    }

	// colour input
    if($item['type'] == 'colour') {
        $val = '';
        if(array_key_exists('val', $item)) $val = ' value="'. $item['val'] .'"';
        if(array_key_exists($item['id'], $rm_values)) $val = ' value="'. $rm_values[$item['id']] .'"';
        
        echo '<div id="' . $item['id'] . '_picker' . '" class="colorSelector"><div style="' . esc_attr( 'background-color:' . $rm_values[$item['id']] ) . '"></div></div>';
        echo '<input class="rm-color" name="'. $prefix .'['. $item['id'] .']"'. $val . ' class="shorter" id="" type="text" value="' . esc_attr( $colour ) . '" />';
    }

    // html
    if($item['type'] == 'html') {
        _e( $item['val'], 'rm' );
    }

    // typography
    if($item['type'] == 'typography') {
        unset( $font_size, $font_style, $font_face, $font_color );
        
        $typography_defaults = array(
            'size' => '',
            'face' => '',
            'style' => '',
            'colour' => ''
        );

        $typography_stored = wp_parse_args($item['std'], $typography_defaults);

        $typography_options = array(
            'sizes' => rm_font_sizes(),
            'faces' => rm_font_faces(),
            'styles' => rm_font_styles(),
            'colour' => true
        );

        if (isset($item['options'])) {
            $typography_options = wp_parse_args($item['options'], $typography_options);
        }

        // Font Size
        if ($typography_options['sizes']) {
            echo '<select class="shorter" name="' . esc_attr( $prefix . '[' . $item['id'] . '][size]' ) . '" id="' . esc_attr( $item['id'] . '_size' ) . '">';
            $sizes = $typography_options['sizes'];
            foreach ( $sizes as $i ) {
                $size = $i . 'px';

                if($rm_values[$item['id']]['size'] == $size) {
                    $val = ' selected="selected"';
                } else {
                    $val = "";
                }

                echo '<option '.$val.' value="' . esc_attr($size) . '" ' . selected($typography_stored['size'], $size, false) . '>' . esc_html($size) . '</option>';
            }
            echo '</select>';
        }

        // Font Face
        if ($typography_options['faces']) {
            echo '<select class="shorter" name="' . esc_attr( $prefix . '[' . $item['id'] . '][face]' ) . '" id="' . esc_attr( $item['id'] . '_face' ) . '">';
            $faces = $typography_options['faces'];

            foreach ( $faces as $key => $face ) {

                if($rm_values[$item['id']]['face'] == $key) {
                    $val = ' selected="selected"';
                } else {
                    $val = "";
                }

                echo '<option '.$val.' value="' . esc_attr( $key ) . '" ' . selected( $typography_stored['face'], $key, false ) . '>' . esc_html( $face ) . '</option>';
            }
            echo '</select>';
        }

        // Font Styles
        if ($typography_options['styles']) {
            echo '<select class="shorter" name="'.$prefix.'['.$item['id'].'][style]" id="'. $item['id'].'_style">';
            $styles = $typography_options['styles'];
            foreach ( $styles as $key => $style ) {

                if($rm_values[$item['id']]['style'] == $key) {
                    $val = ' selected="selected"';
                } else {
                    $val = "";
                }

                echo '<option '.$val.' value="' . esc_attr( $key ) . '" ' . selected( $typography_stored['style'], $key, false ) . '>'. $style .'</option>';
            }
            echo '</select>';
        }

        // Colour
        if ($typography_options['colour']) {

            if($rm_values[$item['id']]['colour']) {
               $colour = $rm_values[$item['id']]['colour'];
            } else {
                $colour = "#000";
            }
            echo '<div id="' . esc_attr( $item['id'] . '_picker' ) . '" class="colorSelector"><div style="' . esc_attr( 'background-color:' . $colour ) . '"></div></div>';
            echo '<input class="rm-color" name="'. $prefix .'['. $item['id'] .'][colour]'. '" id="' . esc_attr( $value['id']['colour'] ) . '" type="hidden" value="' . esc_attr( $colour ) . '" />';
        }
    }

    // Background
    if($item['type'] == 'background') {
        
        $background_defaults = array(
            'colour' => '',
            'repeat' => '',
            'position' => '',
            'scroll' => '',
            'image' => ''
        );

        $background_stored = wp_parse_args($item['std'], $background_defaults);

        $background_options = array(
            'colours' => true,
            'repeats' => array('no-repeat' => 'No Repeat', 'repeat-x' => 'Repeat Horizontal', 'repeat-y' => 'Repeat Vertical', 'repeat' => 'Repeat All'),
            'positions' => array('top left' => 'Top Left','top center' => 'Top Center','top right' => 'Top Right','center left' => 'Middle Left','center center' => 'Middle Center','center right' => 'Middle Right','bottom left' => 'Bottom Left','bottom center' => 'Bottom Center','bottom right' => 'Bottom Right'),
            'scrolls' => array('normal' => 'Scroll Normally', 'fixed' => 'Fixed in Place'),
            'images' => true
        );

        if (isset($item['options'])) {
            $background_options = wp_parse_args($item['options'], $background_options);
        }

        // Colour
        if ($background_options['colours']) {

            if($rm_values[$item['id']]['colour']) {
                $colour = $rm_values[$item['id']]['colour'];
            } else {
                $colour = "#FFF";
            }
            echo '<div id="' . esc_attr( $item['id'] . '_picker' ) . '" class="colorSelector"><div style="' . esc_attr( 'background-color:' . $colour ) . '"></div></div>';
            echo '<input class="rm-color" name="'. $prefix .'['. $item['id'] .'][colour]'. '" id="' . esc_attr( $value['id']['colour'] ) . '" type="hidden" value="' . esc_attr( $colour ) . '" />';
        }

        // file
        if($background_options['images']) {
            echo '<input id="'. $item['id']['image'] . '" class="upload_image" type="text" size="36" name="'. esc_attr( $prefix . '[' . $item['id'] . '][image]' ) .'" value="'. esc_attr($rm_values[$item['id']]['image']) .'" />';
            echo '<input class="upload_image_button button-secondary" type="button" value="Upload" />';
        }

        // Repeat
        if ($background_options['repeats']) {
            echo '<select class="shorter" name="' . esc_attr( $prefix . '[' . $item['id'] . '][repeat]' ) . '" id="' . esc_attr( $item['id'] . '_repeat' ) . '">';
            $repeats = $background_options['repeats'];
            foreach ( $repeats as $key => $i ) {
                $repeat = $i;

                if($rm_values[$item['id']]['repeat'] == $key) {
                    $val = ' selected="selected"';
                } else {
                    $val = "";
                }

                echo '<option '.$val.' value="' . esc_attr($key) . '" ' . selected($background_stored['repeat'], $repeat, false) . '>' . esc_html($repeat) . '</option>';
            }
            echo '</select>';
        }

        // Position
        if ($background_options['positions']) {
            echo '<select class="shorter" name="' . esc_attr( $prefix . '[' . $item['id'] . '][position]' ) . '" id="' . esc_attr( $item['id'] . '_position' ) . '">';
            $positions = $background_options['positions'];
            foreach ( $positions as $key => $i ) {
                $position = $i;

                if($rm_values[$item['id']]['position'] == $key) {
                    $val = ' selected="selected"';
                } else {
                    $val = "";
                }

                echo '<option '.$val.' value="' . esc_attr($key) . '" ' . selected($background_stored['position'], $position, false) . '>' . esc_html($position) . '</option>';
            }
            echo '</select>';
        }

        // Scroll
        if ($background_options['scrolls']) {
            echo '<select class="shorter" name="' . esc_attr( $prefix . '[' . $item['id'] . '][scroll]' ) . '" id="' . esc_attr( $item['id'] . '_scroll' ) . '">';
            $scrolls = $background_options['scrolls'];
            foreach ( $scrolls as $key => $i ) {
                $scroll = $i;

                if($rm_values[$item['id']]['scroll'] == $key) {
                    $val = ' selected="selected"';
                } else {
                    $val = "";
                }

                echo '<option '.$val.' value="' . esc_attr($key) . '" ' . selected($background_stored['scroll'], $scroll, false) . '>' . esc_html($scroll) . '</option>';
            }
            echo '</select>';
        }
    }

	// custom
    if($item['type'] == 'custom') {
		$func = '';
		$args = array();
		$id = '';
        if(array_key_exists('function', $item)) $func = $item['function'];
		if(array_key_exists('args', $item)) $args = $item['args'];
		if(array_key_exists('id', $item)) $id = $item['id'];
		
		if($func != '') call_user_func( $func, $id, $args );
    }
	
	// after
	if(array_key_exists('after', $item) && $item['after'] != ''){
		echo $item['after'];
	}
    
    echo '</div>';
}

/**
 * Add a Page to the Framework
 *
 * @param string $title Framework page title
 * @param array $data Framework page input data
 * @param int $order The order of the page in the menu
 */
function rm_add_framework_page( $title, $data, $order = 0 ) {
    if( !is_array($data) ) return false;
    
    // Get current Framework pages
    $rm_options = get_option('rm_framework_options');
    $rm_framework = array();
    if( is_array($rm_options['rm_framework']) ) $rm_framework = $rm_options['rm_framework'];
    
    // Add new page
    $rm_framework[$order] = array( $title => $data );
    
    // Save
    $rm_options['rm_framework'] = $rm_framework;
    update_option('rm_framework_options', $rm_options);
}

/**
 * Has the theme just been activated
 *
 * @return bool
 */
function rm_is_theme_activated() {
    global $pagenow;
    
    if ( is_admin() && isset($_GET['activated'] ) && $pagenow == "themes.php" )
        return true;
    return false;
} 

/**
 * Generate the labels for custom post types
 *
 * @param string $singular The singular post type name
 * @param string $plural The plural post type name
 * @return array Array of labels
 */
function rm_post_type_labels( $singular, $plural = '' ) {
    if( $plural == '') $plural = $singular .'s';
    
    return array(
        'name' => _x( $plural, 'post type general name', 'rm' ),
        'singular_name' => _x( $singular, 'post type singular name', 'rm' ),
        'add_new' => __( 'Add New', 'rm' ),
        'add_new_item' => __( 'Add New '. $singular, 'rm' ),
        'edit_item' => __( 'Edit '. $singular, 'rm' ),
        'new_item' => __( 'New '. $singular, 'rm' ),
        'view_item' => __( 'View '. $singular, 'rm' ),
        'search_items' => __( 'Search '. $plural, 'rm' ),
        'not_found' =>  __( 'No '. $plural .' found', 'rm' ),
        'not_found_in_trash' => __( 'No '. $plural .' found in Trash', 'rm' ), 
        'parent_item_colon' => ''
    );
}

/**
 * Generate the labels for custom taxonomies
 *
 * @param string $singular The singular taxonomy name
 * @param string $plural The plural taxonomy name
 * @return array Array of labels
 */
function rm_taxonomy_labels( $singular, $plural = '' ) {
    if( $plural == '') $plural = $singular .'s';
    
    return array(
        'name' => _x( $plural, 'taxonomy general name', 'rm' ),
        'singular_name' => _x( $singular, 'taxonomy singular name', 'rm' ),
        'search_items' =>  __( 'Search '. $plural, 'rm' ),
        'popular_items' => __( 'Popular '. $plural, 'rm' ),
        'all_items' => __( 'All '. $plural, 'rm' ),
        'parent_item' => null,
        'parent_item_colon' => null,
        'edit_item' => __( 'Edit '. $singular, 'rm' ), 
        'update_item' => __( 'Update '. $singular, 'rm' ),
        'add_new_item' => __( 'Add New '. $singular, 'rm' ),
        'new_item_name' => __( 'New '. $singular .' Name', 'rm' ),
        'separate_items_with_commas' => __( 'Separate '. $plural .' with commas', 'rm' ),
        'add_or_remove_items' => __( 'Add or remove '. $plural, 'rm' ),
        'choose_from_most_used' => __( 'Choose from the most used '. $plural, 'rm' )
    ); 
}

/**
 * Are there any third party SEO plugins active
 *
 * @return bool True is other plugin is detected
 */
function rm_is_third_party_seo() {
	include_once( ABSPATH .'wp-admin/includes/plugin.php' );
	
	if(is_plugin_active('headspace2/headspace.php')) return true;
	if(is_plugin_active('all-in-one-seo-pack/all_in_one_seo_pack.php')) return true;
	if(is_plugin_active('wordpress-seo/wp-seo.php')) return true;
	
	return false;
}

/* ---------------------------------------------------------------------- */
/*  Insert all custom CSS styles
/* ---------------------------------------------------------------------- */

if (!function_exists('rm_insert_custom_styles')) {
    function rm_insert_custom_styles() {

        $typography = rm_get_option('style_main_typography');

        if(rm_get_option('style_main_typography')) {
            $font_face = explode(":", $typography['face']);
            $font_face = str_replace('+', ' ', $font_face[0]);

            $headings_face = explode(":", $headings['face']);
            $headings_face = str_replace('+', ' ', $headings_face[0]);
        }

        ?>

        <style>
        /* Main styles */
        body {
            background-attachment: fixed;
            background-image: url('<?php echo rm_get_option('style_background'); ?>');
            background-size: cover;
            color: <?php echo $typography['colour']; ?>;
            font-family: <?php echo $font_face; ?>; 
            font-size: <?php echo $typography['size']; ?>;
            font-weight: <?php echo $typography['style']; ?>;
        }

        /* Main heading font*/
        h1, h2, h3, h4, h5, h6 {
            color: <?php echo rm_get_option('style_primary_colour') ?>;
        }
        </style>
    <?php }
    
    add_action('wp_head', 'rm_insert_custom_styles');
}

?>