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
    }
}