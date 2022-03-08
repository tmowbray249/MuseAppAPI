<?php

const DEV_MODE = true;  # todo set to false before demos or putting live
const BASEPATH = '/museapp/MuseAppAPI/';


const DATABASE_DIS= "db/dis.sqlite";  # todo update
const DATABASE_USER = "db/user.sqlite"; # todo update

ini_set('display_errors', DEV_MODE);
ini_set('display_startup_errors', DEV_MODE);

include "autoloader.php";
spl_autoload_register("autoloader");

include "htmlexceptionhandler.php";
include "jsonexceptionhandler.php";
set_exception_handler("JSONExceptionHandler");

include "errorhandler.php";
set_error_handler("errorHandler");


