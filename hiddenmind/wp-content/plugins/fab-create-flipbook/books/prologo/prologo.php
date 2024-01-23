<?php

$properties = getProperties_prologo();
$shortCodeString = $properties['short_code_string'];


// Add a shortcode to insert the flipbook in posts
    function shortcode_prologo($atts) {

        $arrayImagePaths = getArrayImagePath_prologo();
        $properties = getProperties_prologo();


        $bookTitle = $properties['book_title'];
        $endString = $properties['end_string'];
        $bookHtml_id = $properties['book_html_id'];
        //$coverSupPath = $properties['cover_sup_path'];
       // $coverInfPath = $properties['cover_inf_path'];

        $flipBookCreator = new FlipBookCreator();
        $output = $flipBookCreator->getBookString($arrayImagePaths, $bookTitle, $endString, $bookHtml_id); // , $coverSupPath, $coverInfPath

        return $output;
    }
    add_shortcode($shortCodeString, 'shortcode_prologo');



    function getArrayImagePath_prologo(){

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

    function getProperties_prologo(){
        $config_file_path = 'config.ini'; 
        $config = parse_ini_file($config_file_path);

        if ($config === false) {
            die('Error: Unable to read the configuration file.');
        }
        return $config;
    }

?>