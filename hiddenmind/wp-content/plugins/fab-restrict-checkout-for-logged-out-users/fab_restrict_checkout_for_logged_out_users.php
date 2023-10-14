<?php
/*
Plugin Name: Fab restrict checkout for logged out users
Description: enforce login before checkout, only registered users can buy products
Version: 0.1
Author: Fab
*/

error_reporting(E_ALL);

// load Facebook graph api lib
require_once(plugin_dir_path(__FILE__) . '../../../vendor/autoload.php');

// global vars
require_once plugin_dir_path(__FILE__) . 'php/restrict_checkout_for_logged_out_users.php';

?>