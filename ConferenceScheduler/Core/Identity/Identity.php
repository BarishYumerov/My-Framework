<?php
declare(strict_types=1);

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

    public static function getIdentityInstance() : Identity {
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
        if (array_key_exists('userId', $_SESSION)) {
            return intval($_SESSION['userId']);
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

    public function isAuthorised() : bool
    {
        if ($this->getUserId() == null) {
            return false;
        }
        return true;
    }

    public function isInRole(string $role) : bool
    {
        if (!$this->isAuthorised()) {
            return false;
        }

        $query = <<<TAG
    select name
    from roles
    join usersroles
    on roles.`id` = usersroles.`roleid`
    where usersroles.`userId` = ?
TAG;

        $statement = $this->db->prepare($query);
        $statement->execute([$this->getUserId()]);
        $userRoles = $statement->fetchAll();
        foreach ($userRoles as $userRole) {
             if($userRole['name'] == $role){
                 return true;
             }
        }
        return false;
    }

    public static function getInstance() : Identity {
        if (self::$_instance == null) {
            self::$_instance = new Identity();
        }
        return self::$_instance;
    }
}