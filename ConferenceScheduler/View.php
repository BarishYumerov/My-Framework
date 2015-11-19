<?php

namespace ConferenceScheduler;

class View
{
    private $controller;
    private $action;
    private $layout;
    private $model;

    public function __construct(
        $controller = null,
        $action = null,
        $layout = 'Default',
        $model = null){

        require_once "Configs/AppConstants.php";

        $this->layout = $layout;
        $this->model = $model;

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
        $path = 'Application'
            . DIRECTORY_SEPARATOR
            .'Views'
            . DIRECTORY_SEPARATOR
            . $this->controller
            . DIRECTORY_SEPARATOR
            . $this->action . '.php';
        require $path;
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