<?php
declare(strict_types=1);

namespace ConferenceScheduler\Core\Drivers;

class MySQLDriver extends Driver {
    /**
     * @return string
     */
    public function getDsn() {
        $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->dbName;

        return $dsn;
    }
}