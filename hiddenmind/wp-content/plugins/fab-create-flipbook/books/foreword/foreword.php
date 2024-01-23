<?php

$properties = getProperties_foreword();
$shortCodeString = $properties['short_code_string'];


// Add a shortcode to insert the flipbook in posts
    function shortcode_foreword($atts) {

        $arrayImagePaths = getArrayImagePath_foreword();
        $properties = getProperties_foreword();


        $bookTitle = $properties['book_title'];
        $endString = $properties['end_string'];
        $bookHtml_id = $properties['book_html_id'];

        $flipBookCreator = new FlipBookCreator();
        $output = $flipBookCreator->getBookString($arrayImagePaths, $bookTitle, $endString, $bookHtml_id); 

        return $output;
    }
    add_shortcode($shortCodeString, 'shortcode_foreword');



    function getArrayImagePath_foreword(){

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

    function getProperties_foreword(){
        $config_file_path = 'config.ini'; 
        $config = parse_ini_file($config_file_path);

        if ($config === false) {
            die('Error: Unable to read the configuration file.');
        }
        return $config;
    }

?>