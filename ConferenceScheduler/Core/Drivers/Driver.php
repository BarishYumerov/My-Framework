<?php

namespace ConferenceScheduler\Core\Drivers;

abstract class Driver {
    protected $user;
    protected $pass;
    protected $dbName;
    protected $host;

    public function __construct(string $user, string $pass, string $dbName, string $host = null)
    {
        $this->user = $user;
        $this->pass = $pass;
        $this->dbName = $dbName;
        $this->host = $host;
    }

    /**
     * @return string
     */
    public abstract function getDsn();
}