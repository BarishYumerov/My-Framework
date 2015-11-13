<?php

namespace ConferenceScheduler\Core\Annotations;

use ConferenceScheduler\Core\HttpContext;

class Authorize extends  Annotation {

    public function annotate()
    {
        $httpContext = HttpContext::getInstance();
        if (!$httpContext->session('userId')) {
            throw new \Exception("Unauthorized", 401);
        }
    }
}