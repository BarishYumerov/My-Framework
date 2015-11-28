<?php
declare(strict_types=1);
namespace ConferenceScheduler\Application\Areas\Admin\Controllers;

use ConferenceScheduler\Application\Controllers\BaseController;
use ConferenceScheduler\Core\HttpContext\HttpContext;
use ConferenceScheduler\View;

class AdminController extends BaseController
{
    /**
     * @Route("admin/KillThemAll");
     * @Admin
     */
    public function index() : View{
        return new View('Admin', 'Index',null, null,'Admin');
    }
}