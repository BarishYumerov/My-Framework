<?php

namespace ConferenceScheduler\Application\Services;

use ConferenceScheduler\Core\ORM\DbContext;

class BaseService {
    protected $dbContext;

    function __construct(DbContext $dbContext)
    {
        $this->dbContext = $dbContext;
    }
}