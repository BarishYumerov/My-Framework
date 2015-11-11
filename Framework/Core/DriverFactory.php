<?php
namespace Framework\Core;
class DriverFactory {

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