<?php

namespace ConferenceScheduler;

class View
{
    private $controller;
    private $action;
    private $layout;
    private $model;
    private $area;

    public function __construct(
        $controller = null,
        $action = null,
        $layout = 'Default',
        $model = null,
        $area = null){

        require_once "Configs/AppConstants.php";

        $this->layout = $layout;
        $this->model = $model;
        $this->area = $area;

        if($area == null){
            if($controller == null){
                $this->controller = DEFAULT_CONTROLLER;
            }
            else{
                $this->controller =  $controller;
            }

            if($action == null){
                $this->action = DEFAULT_ACTION;
            }
            else{
                $this->action = $action;
            }
        }

        else{
            if($controller == null){
                $this->controller = DEFAULT_CONTROLLER;
            }
            else{
                $this->controller =  $controller;
            }

            if($action == null){
                $this->action = DEFAULT_ACTION;
            }
            else{
                $this->action = $action;
            }
        }


        $this->renderView($model);
    }

    private function renderView($model){
        $this->includeHeader();

        $this->getView();

        $this->includeFooter();
    }

    private function includeHeader()
    {
        if ($this->layout) {
            $path = 'Application'
                . DIRECTORY_SEPARATOR
                .'Views'
                . DIRECTORY_SEPARATOR
                . 'Layouts'
                . DIRECTORY_SEPARATOR
                . $this->layout
                . DIRECTORY_SEPARATOR
                . 'header.php';

            require $path;
        }
    }

    private function getView(){
        if($this->area == null){
            $path = 'Application'
                . DIRECTORY_SEPARATOR
                .'Views'
                . DIRECTORY_SEPARATOR
                . $this->controller
                . DIRECTORY_SEPARATOR
                . $this->action . '.php';
            require $path;
        }
        else{
            $path = 'Application'
                . DIRECTORY_SEPARATOR
                . 'Areas'
                . DIRECTORY_SEPARATOR
                .$this->area
                . DIRECTORY_SEPARATOR
                .'Views'
                . DIRECTORY_SEPARATOR
                . $this->controller
                . DIRECTORY_SEPARATOR
                . $this->action . '.php';
            require $path;
        }
    }

    private function includeFooter()
    {
        if ($this->layout) {
            $path = 'Application'
                . DIRECTORY_SEPARATOR
                .'Views'
                . DIRECTORY_SEPARATOR
                . 'Layouts'
                . DIRECTORY_SEPARATOR
                . $this->layout
                . DIRECTORY_SEPARATOR
                . 'footer.php';

            require $path;
        }
    }
}