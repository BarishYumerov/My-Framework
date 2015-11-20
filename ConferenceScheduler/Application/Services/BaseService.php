<?php

namespace ConferenceScheduler\Application\Services;

use ConferenceScheduler\Core\HttpContext\HttpContext;
use ConferenceScheduler\Core\ORM\DbContext;

class BaseService {
    protected $dbContext;
    protected $context;
    protected $response = [];

    function __construct(DbContext $dbContext)
    {
        $this->dbContext = $dbContext;
        $this->context = HttpContext::getInstance();
    }
}