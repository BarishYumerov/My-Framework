<?php
declare(strict_types=1);
//error_reporting(0);
session_start();

require_once "Autoloader.php";
require_once "Configs/AppConstants.php";

\ConferenceScheduler\Autoloader::init();

$requestParts = explode('/', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

$applicationNameIndex = array_search(APPLICATION_NAME, $requestParts);

$routeParams = array_slice($requestParts, $applicationNameIndex + 1);
$routeString = implode('/', $routeParams);

if (strlen($routeString) > 1 &&  $routeString[0] == '/') {
    $routeString = substr($routeString, 1, strlen($routeString));
}
$databaseConfig = new ConferenceScheduler\Configs\DatabaseConfig();
ConferenceScheduler\Core\Database\Db::setInstance($databaseConfig);

$app = new ConferenceScheduler\Application\Application($routeString);
$app->start();