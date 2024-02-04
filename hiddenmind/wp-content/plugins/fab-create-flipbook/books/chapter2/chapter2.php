<?php

$properties = getProperties_chapter2();                             // CHANGE THIS - getProperties_XXX();
$shortCodeString = $properties['short_code_string'];


// Add a shortcode to insert the flipbook in posts
    function shortcode_chapter2($atts) {                            // CHANGE THIS - shortcode_XXX($atts)

        $arrayImagePaths = getArrayImagePath_chapter2();            // CHANGE THIS - getArrayImagePath_XXX(); 
        $properties = getProperties_chapter2();                     // CHANGE THIS - getProperties_XXX();


        $bookTitle = $properties['book_title'];
        $endString = $properties['end_string'];
        $bookHtml_id = $properties['book_html_id'];

        $flipBookCreator = new FlipBookCreator();
        $output = $flipBookCreator->getBookString($arrayImagePaths, $bookTitle, $endString, $bookHtml_id); 

        return $output;
    }
    add_shortcode($shortCodeString, 'shortcode_chapter2');      // CHANGE THIS - add_shortcode($shortCodeString, 'shortcode_XXX');



    function getArrayImagePath_chapter2(){                      // CHANGE THIS - function getArrayImagePath_XXX(){ 

        $config_file_path = 'img_path.ini'; 
        $config = parse_ini_file($config_file_path);

        if ($config === false) {
            die('Error: Unable to read the configuration file.');
        }

        foreach ($config as $key => $value) {
            $arrayImagePaths[$key] = plugins_url($value, __FILE__);
        }
        return $arrayImagePaths;
    }

    function getProperties_chapter2(){                      // CHANGE THIS - function getProperties_XXX(){ 
        $config_file_path = 'config.ini'; 
        $config = parse_ini_file($config_file_path);

        if ($config === false) {
            die('Error: Unable to read the configuration file.');
        }
        return $config;
    }

?>