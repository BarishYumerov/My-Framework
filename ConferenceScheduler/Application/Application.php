<?php
//declare(strict_types=1);

namespace ConferenceScheduler\Application;

use ConferenceScheduler\Core\HttpContext\HttpContext;
use ConferenceScheduler\Core\Router\RoutesFinder;
use ConferenceScheduler\Core\Router\RouteMapper;
use ConferenceScheduler\Core\Identity\IdentityParser;
use ConferenceScheduler\Core\ORM\Orm;

class Application{
    private $route;
    private $controller;
    private $annotations = [];

    public function __construct($route)
    {
        RoutesFinder::getRoutes();
        $this->route = RouteMapper::map($route);

        // Set Default Route If invalid route;
        if (!$this->route) {
            $this->route['controller'] = DEFAULT_CONTROLLER;
            $this->route['action'] = DEFAULT_ACTION;
            $this->route['parameters'] = [];
            $this->route['annotations'] = [];
        }

        $this->createAnnotations($this->route);
    }

    //Initializes the context, updates orm, identity and calls controller method.
    function start(){

        if(AppMode == 'Development'){
            IdentityParser::createIdentity();
            IdentityParser::updateIdentity();
            Orm::update();
        }

        $this->createController();

        if(!isset($this->route['parameters'])){
            $this->route['parameters'] = [];
        }

        foreach ($this->annotations as $annotation) {
            $annotation->annotate(); 
        }

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
    }

    private function createAnnotations($route)
    {
        $availableAnnotations = [];

        $dirHandle = opendir('Core' . DIRECTORY_SEPARATOR . 'Annotations');
        $file = readdir($dirHandle);
        while ($file) {
            if ($file[0] == '.') {
                $file = readdir($dirHandle);
                continue;
            }

            if ($file == 'Annotation.php') {
                $file = readdir($dirHandle);
                continue;
            }

            $annotationClassName = explode('.', $file)[0];
            $availableAnnotations[] = $annotationClassName;
            $file = readdir($dirHandle);
        }

        foreach ($route['annotations'] as $key => $value) {
            $annotationName = ucfirst($key);
            if (!in_array($annotationName, $availableAnnotations)) {
                throw new \Exception("Unrecognized annotation class.", 501);
            }

            $annotationName = '\\ConferenceScheduler\\Core\\Annotations\\' . $annotationName;
            $this->annotations[] = new $annotationName($value);
        }
    }
}