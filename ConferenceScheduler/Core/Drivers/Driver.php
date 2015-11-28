<?php
declare(strict_types=1);

namespace ConferenceScheduler\Core\Drivers;

abstract class Driver {
    protected $user;
    protected $pass;
    protected $dbName;
    protected $host;

    public function __construct($user, $pass, $dbName, $host = null)
    {
        $this->user = $user;
        $this->pass = $pass;
        $this->dbName = $dbName;
        $this->host = $host;
    }

    public abstract function getDsn() : string;
}