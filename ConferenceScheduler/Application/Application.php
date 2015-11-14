<?php
//declare(strict_types=1);

namespace ConferenceScheduler\Application;

use ConferenceScheduler\Core\HttpContext\HttpContext;
use ConferenceScheduler\Core\Router\RoutesFinder;
use ConferenceScheduler\Core\Router\RouteMapper;

class Application{
    private $route;
    private $controller;

    public function __construct($route)
    {
        RoutesFinder::getRoutes();
        $this->route = RouteMapper::map($route);

        // If no area-route or standard route has been found - assign default route and action
        if (!$this->route) {
            $this->route['controller'] = DEFAULT_CONTROLLER;
            $this->route['action'] = DEFAULT_ACTION;
            $this->route['parameters'] = [];
            $this->route['annotations'] = [];
        }
    }

    function start(){
        $context = HttpContext::getInstance();
        $context->setGet($_GET);
        $context->setPost($_POST);
        $context->setCookies($_COOKIE);
        $context->setSession($_SESSION);
        $context->setMethod(strtolower($_SERVER['REQUEST_METHOD']));

        $this->createController();

        call_user_func_array(
            [
                $this->controller,
                $this->route['action']
            ],
            $this->route['parameters']
        );
    }

    private function createController()
    {
        $controllerClassName = $this->route['controller'];
        $this->controller = new $controllerClassName();
        $this->route['parameters'] = [];
    }
}