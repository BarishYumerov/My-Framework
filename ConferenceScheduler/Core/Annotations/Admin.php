<?php

namespace ConferenceScheduler\Core\Annotations;

use ConferenceScheduler\Core\HttpContext\HttpContext;

class Admin extends Annotation
{
    public function annotate()
    {
        $httpContext = HttpContext::getInstance();

        if (!$httpContext->session('username')) {
            throw new \Exception("Unauthorized", 401);
        }

        if(!$this->identity->isInRole("Admin")){
            throw new \Exception("Only Admin Access!!");
        }
    }
}