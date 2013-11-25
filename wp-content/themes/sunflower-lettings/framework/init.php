<?php
/*-----------------------------------------------------------------------------------*/
/*
/*	Rockability Framework
/*
/*-----------------------------------------------------------------------------------*/


/*-----------------------------------------------------------------------------------*/
/*	Define Constants
/*-----------------------------------------------------------------------------------*/

define('RM_DIR', get_template_directory() .'/framework');
define('RM_URL', get_template_directory_uri() .'/framework');
define('RM_FRAMEWORK_VERSION', '1.0');
define('RM_DEBUG', false);


/*-----------------------------------------------------------------------------------*/
/*	Load Framework Components
/*-----------------------------------------------------------------------------------*/

require_once(RM_DIR .'/rm-admin-functions.php');
require_once(RM_DIR .'/rm-admin-init.php');
require_once(RM_DIR .'/rm-admin-metaboxes.php');
require_once(RM_DIR .'/rm-admin-page-options.php');
require_once(RM_DIR .'/rm-theme-functions.php');

?>