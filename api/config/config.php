<?php
 
 define('DEVELOPMENT_MODE', true);
 
 ini_set('display_errors', DEVELOPMENT_MODE);
 ini_set('display_startup_errors', DEVELOPMENT_MODE);
 
 include 'config/autoloader.php';
 spl_autoload_register('autoloader');

 include 'config/exceptionHandler.php';
 set_exception_handler('exceptionHandler');
 
 include 'config/errorhandler.php';
 set_error_handler('errorHandler');
