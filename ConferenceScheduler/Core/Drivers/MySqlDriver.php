<?php
declare(strict_types=1);

namespace ConferenceScheduler\Core\Drivers;

class MySQLDriver extends Driver {

    public function getDsn() : string {
        $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->dbName;

        return $dsn;
    }
}