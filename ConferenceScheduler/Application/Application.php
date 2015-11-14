<?php
//declare(strict_types=1);

namespace ConferenceScheduler\Application;

use ConferenceScheduler\Core\HttpContext\HttpContext;
use ConferenceScheduler\Core\Router\RouteCreator;

class Application{
    private $raute;
    private $controller;

    public function __construct($route)
    {
        RouteCreator::getRoutes();
    }

    function start(){
        $context = HttpContext::getInstance();
        $context->setGet($_GET);
        $context->setPost($_POST);
        $context->setCookies($_COOKIE);
        $context->setSession($_SESSION);
        $context->setMethod(strtolower($_SERVER['REQUEST_METHOD']));
    }
}