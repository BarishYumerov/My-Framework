<?php
namespace Framework\Core;
class MySqlDriver extends Driver {

    public function getDsn() {
        $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->dbName;
        return $dsn;
    }
}