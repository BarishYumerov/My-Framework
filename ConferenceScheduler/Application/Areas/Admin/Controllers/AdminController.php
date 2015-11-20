<?php

namespace ConferenceScheduler\Application\Areas\Admin\Controllers;

use ConferenceScheduler\Application\Controllers\BaseController;
use ConferenceScheduler\Core\HttpContext\HttpContext;
use ConferenceScheduler\View;

class AdminController extends BaseController
{
    /**
     * @Route("admin/KillThemAll");
     */
    public function index(){
        return new View('Admin', 'index', 'Default', null, 'Admin');
    }
}