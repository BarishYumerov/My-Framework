<?php

namespace ConferenceScheduler\Application\Controllers;

use ConferenceScheduler\Application\Services\ConferencesServices;


class HomeController extends BaseController
{
    public function index(){
        $service = new ConferencesServices($this->dbContext);
        $allConferences =$service->getAll();

        var_dump($allConferences);
    }
}