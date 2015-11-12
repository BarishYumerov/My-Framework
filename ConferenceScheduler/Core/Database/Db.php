<?php
declare(strict_types=1);

namespace ConferenceScheduler\Core\Database;

use ConferenceScheduler\Core\Drivers\DriverFactory;

class Db {
    private static $instances;
    private $db;
    private $statement;

    private function __construct(\PDO $pdo) {
        $this->db = $pdo;
    }

    /**
     * @param string $instanceName
     * @return DatabaseData
     * @throws \Exception
     */
    public static function getInstance($instanceName = 'default') {
        if (!isset(self::$instances[$instanceName])) {
            throw new \Exception('Instance with that name was not set.');
        }

        return self::$instances[$instanceName];
    }

    public static function setInstance(
        string $instanceName,
        string $driver,
        string $user,
        string $pass,
        string $dbName,
        string $host = null) {
        $driver = DriverFactory::create($driver, $user, $pass, $dbName, $host);

        $pdo = new \PDO($driver->getDsn(), $user, $pass);

        self::$instances[$instanceName] = new self($pdo);
    }

    public function query(string $statement, array $params = [])
    {
        $this->statement = $this->db->prepare($statement);
        $this->statement->execute($params);
    }

    public function fetch($fetchStyle = \PDO::FETCH_ASSOC)
    {
        return $this->statement->fetch($fetchStyle);
    }

    public function fetchAll($fetchStyle = \PDO::FETCH_ASSOC)
    {
        return $this->statement->fetchAll($fetchStyle);
    }

    public function bindParam($parameter, &$variable, $dataType = \PDO::PARAM_STR, $length = null, $driver_options = [])
    {
        return $this->statement->bindParam($parameter, $variable, $dataType, $length, $driver_options);
    }

    public function execute($input_parameters = [])
    {
        return $this->statement->execute($input_parameters);
    }

    public function rowCount()
    {
        return $this->statement->rowCount();
    }
}