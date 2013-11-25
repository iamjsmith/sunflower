<!DOCTYPE html>
<html lang="en">
<head>
	<title><?php wp_title(); ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<meta name="description" content="<?php wp_title(''); echo ' | '; bloginfo( 'description' ); ?>" />
	<?php if(rm_get_option('general_custom_favicon')) : ?><link rel="shortcut icon" href="<?php echo rm_get_option('general_custom_favicon'); ?>" type="image/x-icon" /><?php endif; ?>
	
	<!-- Wordpress Scripts -->
	<?php wp_head(); ?>
</head>

<body>
	<header>
		<div class="container">
	  		<h1 class="logo"><a href="<?php bloginfo('url') ?>">
	  			<?php if(rm_get_option('general_custom_logo')) : ?>
	  				<img src="<?php echo rm_get_option('general_custom_logo'); ?>" alt="<?php bloginfo('name') ?>" /></a>
	  			<?php else : ?>
	  				<?php bloginfo('name') ?>
	  			<?php endif; ?>
	  		</h1>


      <?php
          if(function_exists('wp_nav_menu')) {
              wp_nav_menu (
                  array (
                  'menu' => 'main_nav',
                  'container' => '',
                  'depth' => 2,
                  'menu_id' => null,
                  'menu_class' => 'nav'
                  )                    
              );
          } else {
              wp_page_menu(array('menu_class' => 'nav', 'sort_order' => 'menu_order, post_title'));
          }
      ?><!-- /.nav -->
		</div><!-- /.container	 -->
	</header>