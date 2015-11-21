<?php

namespace ConferenceScheduler\Core\Identity;

use ConferenceScheduler\Core\Database\Db;
use ConferenceScheduler\Configs\DatabaseConfig;

class Identity {
    private static $_instance = null;
    private $db;

    private function __construct()
    {
        $dbConfig = new DatabaseConfig();
        $this->db = Db::getInstance($dbConfig::DB_NAME);
    }

    public static function getIdentityInstance() {
        if (self::$_instance == null) {
            self::$_instance = new Identity();
        }
        return self::$_instance;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        if (array_key_exists('username', $_SESSION)) {
            return $_SESSION['username'];
        } else {
            return null;
        }
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        if (array_key_exists('username', $_SESSION)) {
            $result = $_SESSION['username'];
            return $result;
        } else {
            return null;
        }
    }

    /**
     * @return bool
     */
    public function isAuthorised()
    {
        if ($this->getUserId() == null) {
            return false;
        }
        return true;
    }

    /**
     * @param $role
     * @return bool
     */
    public function isInRole($role)
    {
        if (!$this->isAuthorised()) {
            return false;
        }

        $query = <<<TAG
    select name
    from roles
    join usersroles
    on roles.`id` = usersroles.`roleid`
    where usersroles.`userid` = ?
TAG;

        $statement = $this->db->prepare($query);
        $statement->execute($this->getUserId());
        $userRoles = $statement->fetchAll();
        return array_key_exists($role, $userRoles);
    }

    /**
     *
     * @return \ConferenceScheduler\Core\Identity\Identity
     */
    public static function getInstance() {
        if (self::$_instance == null) {
            self::$_instance = new Identity();
        }
        return self::$_instance;
    }
}