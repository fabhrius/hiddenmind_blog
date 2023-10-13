<?php
include('LoggerConfig.php');



Class LoggerManager {

    public function __construct()
    {
        $configuration = array(
            'log_to_file' => 1
        );    
        Logger::configure($configuration, 'LoggerConfig');
    }

    public function getLogger_log_to_file(){
        return Logger::getLogger('log_to_file');
    }
}


?>