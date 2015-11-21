<?php

namespace ConferenceScheduler\Application\Controllers;

use ConferenceScheduler\View;

class ConferenceController extends BaseController
{
    /**
     * @Authorize
     */
    public function create(){

        return new View('conference', 'create');
    }
}