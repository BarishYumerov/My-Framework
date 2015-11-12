<?php

namespace ConferenceScheduler\Core\Drivers;

class DriverFactory {
    /**
     * @param $driver
     * @param $user
     * @param $pass
     * @param $dbName
     * @param $host
     * @return Driver
     */
    public static function create(string $driver, string $user, string $pass, string $dbName, string $host)
    {
        $driverName = strtolower($driver);
        switch ($driverName) {
            case 'mysql':
                $mySQLDriver = new MySQLDriver($user, $pass, $dbName, $host);
                return $mySQLDriver;
            default :
                $mySQLDriver = new MySQLDriver($user, $pass, $dbName, $host);
                return $mySQLDriver;
        }
    }
}