<?php

/*-----------------------------------------------------------------------------------

	Plugin Name: Rockability Flickr Photostream
	Plugin URI: http://www.rockablemedia.com
	Description: A widget that displays your Flickr photos
	Version: 1.0
	Author: Rockable Media
	Author URI: http://www.rockablemedia.com

-----------------------------------------------------------------------------------*/


/*-----------------------------------------------------------------------------------*/
/*  Create the widget
/*-----------------------------------------------------------------------------------*/
add_action( 'widgets_init', 'rm_flickr_widgets' );

function rm_flickr_widgets() {
	register_widget( 'rm_FLICKR_Widget' );
}

/*-----------------------------------------------------------------------------------*/
/*  Widget class
/*-----------------------------------------------------------------------------------*/
class rm_flickr_widget extends WP_Widget {


/*-----------------------------------------------------------------------------------*/
/*	Widget Setup
/*-----------------------------------------------------------------------------------*/
	
function rm_FLICKR_Widget() {

	/* Widget settings --------------------------------------------------------------*/
	$widget_ops = array(
		'classname' => 'rm_flickr_widget',
		'description' => __('A widget that displays your Flickr photos.', 'rm')
	);

	/* Widget control settings ------------------------------------------------------*/
	$control_ops = array(
		'width' => 300,
		'height' => 350,
		'id_base' => 'rm_flickr_widget'
	);

	/* Create the widget ------------------------------------------------------------*/
	$this->WP_Widget( 'rm_flickr_widget', __('Custom Flickr Photos', 'rm'), $widget_ops, $control_ops );
	
}


/*-----------------------------------------------------------------------------------*/
/*	Display Widget
/*-----------------------------------------------------------------------------------*/
	
function widget( $args, $instance ) {
	extract( $args );

	/* Our variables from the widget settings ---------------------------------------*/
	$title = apply_filters('widget_title', $instance['title'] );
	$flickrID = $instance['flickrID'];
	$postcount = $instance['postcount'];
	$type = $instance['type'];
	$display = $instance['display'];

    /* Build our output -------------------------------------------------------------*/
	echo $before_widget;

	if ( $title ) {	echo $before_title . $title . $after_title; }
?>
		
	<div id="flickr_badge_wrapper" class="clearfix">
		<script type="text/javascript" src="http://www.flickr.com/badge_code_v2.gne?count=<?php echo $postcount ?>&amp;display=<?php echo $display ?>&amp;size=s&amp;layout=x&amp;source=<?php echo $type ?>&amp;<?php echo $type ?>=<?php echo $flickrID ?>"></script>
	</div>
	
<?php
	echo $after_widget;
}


/*-----------------------------------------------------------------------------------*/
/*	Update Widget
/*-----------------------------------------------------------------------------------*/
	
function update( $new_instance, $old_instance ) {
	$instance = $old_instance;

	/* Strip tags to remove HTML (important for text inputs) ------------------------*/
	$instance['title'] = strip_tags( $new_instance['title'] );
	$instance['flickrID'] = strip_tags( $new_instance['flickrID'] );

	/* No need to strip tags --------------------------------------------------------*/
	$instance['postcount'] = $new_instance['postcount'];
	$instance['type'] = $new_instance['type'];
	$instance['display'] = $new_instance['display'];

	return $instance;
}


/*-----------------------------------------------------------------------------------*/
/*	Widget Settings (Displays the widget settings controls on the widget panel)
/*-----------------------------------------------------------------------------------*/
	 
function form( $instance ) {

	/* Set up some default widget settings ------------------------------------------*/
	$defaults = array(
		'title' => 'My Photostream',
		'flickrID' => '10133335@N08',
		'postcount' => '9',
		'type' => 'user',
		'display' => 'latest',
	);
	
	$instance = wp_parse_args( (array) $instance, $defaults ); 
	
	/* Build our form fields -------------------------------------------------------*/
	?>

	<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'rm') ?></label>
		<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
	</p>

	<p>
		<label for="<?php echo $this->get_field_id( 'flickrID' ); ?>"><?php _e('Flickr ID:', 'rm') ?> (<a href="http://idgettr.com/">idGettr</a>)</label>
		<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'flickrID' ); ?>" name="<?php echo $this->get_field_name( 'flickrID' ); ?>" value="<?php echo $instance['flickrID']; ?>" />
	</p>
	
	<p>
		<label for="<?php echo $this->get_field_id( 'postcount' ); ?>"><?php _e('Number of Photos:', 'rm') ?></label>
		<select id="<?php echo $this->get_field_id( 'postcount' ); ?>" name="<?php echo $this->get_field_name( 'postcount' ); ?>" class="widefat">
			<option <?php if ( '3' == $instance['postcount'] ) echo 'selected="selected"'; ?>>3</option>
			<option <?php if ( '6' == $instance['postcount'] ) echo 'selected="selected"'; ?>>6</option>
			<option <?php if ( '9' == $instance['postcount'] ) echo 'selected="selected"'; ?>>9</option>
		</select>
	</p>
	
	<p>
		<label for="<?php echo $this->get_field_id( 'type' ); ?>"><?php _e('Type (user or group):', 'rm') ?></label>
		<select id="<?php echo $this->get_field_id( 'type' ); ?>" name="<?php echo $this->get_field_name( 'type' ); ?>" class="widefat">
			<option <?php if ( 'user' == $instance['type'] ) echo 'selected="selected"'; ?>>user</option>
			<option <?php if ( 'group' == $instance['type'] ) echo 'selected="selected"'; ?>>group</option>
		</select>
	</p>
	
	<p>
		<label for="<?php echo $this->get_field_id( 'display' ); ?>"><?php _e('Display (random or latest):', 'rm') ?></label>
		<select id="<?php echo $this->get_field_id( 'display' ); ?>" name="<?php echo $this->get_field_name( 'display' ); ?>" class="widefat">
			<option <?php if ( 'random' == $instance['display'] ) echo 'selected="selected"'; ?>>random</option>
			<option <?php if ( 'latest' == $instance['display'] ) echo 'selected="selected"'; ?>>latest</option>
		</select>
	</p>
		
	<?php
	}
}
?>