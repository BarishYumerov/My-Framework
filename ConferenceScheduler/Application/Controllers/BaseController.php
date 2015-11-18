<?php

//declare(strict_types=1);

namespace ConferenceScheduler\Application\Controllers;

use ConferenceScheduler\Core\HttpContext\HttpContext;
use ConferenceScheduler\Core\ORM\DbContext;

class BaseController{
    protected $dbContext;
    protected $context;

    public function __construct()
    {
        $this->dbContext = new DbContext();
        $this->context = HttpContext::getInstance();
        $this->onInit();
    }

    public function onInit() {
        // Implement initializing logic in the subclasses
    }

    public function redirectToUrl($url) {
        header("Location: " . $url);
        exit;
    }

    public function redirect($controllerName, $actionName = null, $params = null) {
        $url = '/' . urlencode($controllerName);
        if ($actionName != null) {
            $url .= '/' . urlencode($actionName);
        }
        if ($params != null) {
            $encodedParams = array_map($params, 'urlencode');
            $url .= implode('/', $encodedParams);
        }
        $this->redirectToUrl($url);
    }

    function addMessage($msg, $type) {
        if (!isset($_SESSION['messages'])) {
            $_SESSION['messages'] = array();
        };
        array_push($_SESSION['messages'],
            array('text' => $msg, 'type' => $type));
    }

    function addInfoMessage($msg) {
        $this->addMessage($msg, 'info');
    }

    function addErrorMessage($msg) {
        $this->addMessage($msg, 'error');
    }
}