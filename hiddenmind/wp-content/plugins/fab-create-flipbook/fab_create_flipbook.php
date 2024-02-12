<?php
/*
Plugin Name: Fab Create Flip Book
Description: It creates a book with flip page effect from a list of images
Version: 0.1
Author: Fab
*/

if(!defined('FAB_FLIPBOOK_POST_CATEGORY')){

    define('FAB_FLIPBOOK_POST_CATEGORY', 'flipbook');
}

    
require_once(plugin_dir_path(__FILE__) . 'php/add_css_files_to_post_by_category.php');


require_once(plugin_dir_path(__FILE__) . 'util/FlipBookCreator.php');
//require_once(plugin_dir_path(__FILE__) . 'books/chap0/chap0.php');
require_once(plugin_dir_path(__FILE__) . 'books/prologo/prologo.php');
require_once(plugin_dir_path(__FILE__) . 'books/foreword/foreword.php');
require_once(plugin_dir_path(__FILE__) . 'books/chapter1/chapter1.php');
require_once(plugin_dir_path(__FILE__) . 'books/chapter2/chapter2.php');
require_once(plugin_dir_path(__FILE__) . 'books/chapter3/chapter3.php');




?>