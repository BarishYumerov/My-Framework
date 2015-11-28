<?php
declare(strict_types=1);

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
    public static function create($driver, $user, $pass, $dbName, $host)
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