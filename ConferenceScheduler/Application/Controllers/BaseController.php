<?php

//declare(strict_types=1);

namespace ConferenceScheduler\Application\Controllers;

use ConferenceScheduler\Core\ORM\DbContext;

class BaseController{
    protected $dbContext;

    public function __construct()
    {
        $this->dbContext = new DbContext();
        $this->onInit();
    }

    public function onInit() {
        // Implement initializing logic in the subclasses
    }
}