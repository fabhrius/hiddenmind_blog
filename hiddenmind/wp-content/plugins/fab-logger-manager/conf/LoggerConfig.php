<?php

class LoggerConfig implements LoggerConfigurator {
    	
    public function configure(LoggerHierarchy $hierarchy, $input = null) { 

        $layout = new LoggerLayoutPattern();
        $layout->setConversionPattern("%date %logger %msg%newline");
        $layout->activateOptions();

        // Create an appender which logs to file
        $appFile = new LoggerAppenderFile('log_to_file');
        $appFile->setFile('log/mylog.txt');
        $appFile->setAppend(true);
        $appFile->setLayout($layout);
        $appFile->setThreshold('all');
        $appFile->activateOptions();
        

        
        // Add appenders to the root logger
        $root = $hierarchy->getRootLogger();
        $root->addAppender($appFile);
    }
}


?>