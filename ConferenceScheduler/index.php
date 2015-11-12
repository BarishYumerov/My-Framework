<?php

ini_set('display_errors', 1);

session_start();

require_once "Autoloader.php";
require_once "Configs/AppConsts.php";

\ConferenceScheduler\Autoloader::init();

$requestParts = explode('/', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

$applicationNameIndex = array_search(APPLICATION_NAME, $requestParts);

$routeParams = array_slice($requestParts, $applicationNameIndex + 1);
var_dump($routeParams);