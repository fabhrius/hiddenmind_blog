<?php
/*
Plugin Name: Fab assign role after checkout
Description: assign a role after payment for suscriptions.
Version: 0.1
Author: Fab
*/

error_reporting(E_ALL);

// load Facebook graph api lib
require_once(plugin_dir_path(__FILE__) . '../../../vendor/autoload.php');

// global vars
require_once plugin_dir_path(__FILE__) . 'php/assign_role_after_checkout.php';

?>