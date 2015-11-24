<?php

namespace ConferenceScheduler\Application\Controllers;

use ConferenceScheduler\Application\Services\ConferenceService;
use ConferenceScheduler\View;


class HomeController extends BaseController
{
    public function index(){
        $service = new ConferenceService($this->dbContext);
        $allConferences =$service->getAll();
        $allConferences = array_slice($allConferences, 0, 6);
        return new View('Home', 'Index', $allConferences);
    }

    /**
     * @Authorize
     * @Route("Me/Invites")
     */
    public function invites(){
        return new View('Home', 'Invites', $this->invites);
    }
}