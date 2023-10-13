<?php
/*
Plugin Name: Fab Logger Manager
Description: Provide Configurable Logs support for other plugins
Version: 0.1
Author: Fab
*/

require_once(plugin_dir_path(__FILE__) . '../../../vendor/autoload.php');

if ( ! defined( 'LOGGER_MANAGER_AVAILABLE' ) ) {

    require_once(plugin_dir_path(__FILE__) . 'conf/LoggerManager.php');
    define( 'LOGGER_MANAGER_AVAILABLE', true );
}




?>