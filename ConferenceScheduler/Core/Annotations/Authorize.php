<?php

namespace ConferenceScheduler\Core\Annotations;

use ConferenceScheduler\Core\HttpContext\HttpContext;

class Authorize extends  Annotation {

    public function annotate()
    {
        $httpContext = HttpContext::getInstance();

        if (!$httpContext->session('username')) {
            throw new \Exception("Unauthorized", 401);
        }
    }
}