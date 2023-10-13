<?php
/*
Plugin Name: Fab WP post to Facebook
Description: Automatically post new WordPress content to Facebook.
Version: 0.1
Author: Fab
*/

error_reporting(E_ALL);

// load Facebook graph api lib
require_once(plugin_dir_path(__FILE__) . '../../../vendor/autoload.php');

// global vars
require_once plugin_dir_path(__FILE__) . 'settings/fab-app-config.php';
// add open graph tags
require_once plugin_dir_path(__FILE__) . 'php/fab-add-open-graph-tags.php';
// publish on facebook a link to the new post
require_once plugin_dir_path(__FILE__) . 'php/fab-post-a-link-to-facebook.php';

?>