<?php
$env = [];
$env_file = explode("\n", file_get_contents('.env'));
$i = 0;
while ($i < count($env_file)){
    $env_parts = explode('=', $env_file[$i]);
    $env_parts[0] = trim($env_parts[0]);
    $env_parts[1] = trim($env_parts[1]);
    $env[$env_parts[0]] = $env_parts[1];
    $i++;
}

define('DEV_MODE', $env['DEV_MODE']); # todo set to true or use a production env before putting live
define('BASEPATH', $env['BASEPATH']);
define('DATABASE', $env['DATABASE']); # todo update to point to production db or env
define('SECRET_KEY', $env['SECRET_KEY']);

ini_set('display_errors', DEV_MODE);
ini_set('display_startup_errors', DEV_MODE);

include "autoloader.php";
spl_autoload_register("autoloader");

include "htmlexceptionhandler.php";
include "jsonexceptionhandler.php";
set_exception_handler("JSONExceptionHandler");

include "errorhandler.php";
set_error_handler("errorHandler");


