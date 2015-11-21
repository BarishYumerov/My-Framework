<?php

namespace ConferenceScheduler\Application\Controllers;

use ConferenceScheduler\Application\Services\ConferencesServices;
use ConferenceScheduler\View;


class HomeController extends BaseController
{
    public function index(){
        $service = new ConferencesServices($this->dbContext);
        $allConferences =$service->getAll();
        $allConferences = array_slice($allConferences, 0, 6);
        return new View('Home', 'Index', $allConferences);
    }
}