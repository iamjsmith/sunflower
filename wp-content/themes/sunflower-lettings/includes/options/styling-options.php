<?php

/**
 * Create the Styling Options section
 */
add_action('admin_init', 'rm_styling_options');

function rm_styling_options(){

  // Google Fonts
  $google_fonts = array_merge(
    array( '' => __('None / Default', 'rm') ),
    rm_get_google_fonts()
  );
	
	$styling_options['description'] = 'Configure the visual appearance of you theme by selecting a stylesheet if applicable, choosing your overall layout and inserting any custom CSS necessary.';

    $styling_options[] = array('title' => 'Background Image',
                               'desc' => 'Set the website background image.',
                               'type' => 'file',
                               'id' => 'style_background');

    $styling_options[] = array('title' => 'Primary Colour',
                               'desc' => 'This color will be used for highlighting and links.',
                               'type' => 'colour',
                               'id' => 'style_primary_colour');

    $styling_options[] = array('title' => 'Secondary Colour',
                               'desc' => 'This color will be used for the main font.',
                               'type' => 'colour',
                               'id' => 'style_secondary_colour');

    $styling_options[] = array('title' => 'Main Typography',
                               'desc' => 'The default type set for all elements.',
                               'type' => 'typography',
                               'id' => 'style_main_typography',
                               'std' => array(
                                  "size"  => "11px",
                                  "face"  => '"Open+Sans+Condensed:300,300italic,700&subset=greek,latin-ext,cyrillic-ext,vietnamese,greek-ext,cyrillic,latin',
                                  "style" => "normal",
                                  "colour" => "#000"
                                ));
                                
    rm_add_framework_page( 'Styling Options', $styling_options, 10 );
}

?>