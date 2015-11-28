<?php
declare(strict_types=1);

namespace ConferenceScheduler\Core\Identity;

use ConferenceScheduler\Core\Database\Db;
use ConferenceScheduler\Configs\DatabaseConfig;

class TablesUpdater
{
    public function createTable(string $name) : bool {
        $db = Db::getInstance(DatabaseConfig::DB_INSTANCE);
        $query = str_replace('{{name}}', $name, self::CREATE_TABLE);

        try {
            $statement = $db->query($query);
            $statement->execute([]);
            return true;
        } catch (\Exception $ex) {
            return false;
        }
    }

    public function dropTable(string $name) : bool {
        $db = Db::getInstance(DatabaseConfig::DB_INSTANCE);
        $query = str_replace('{{name}}', $name, self::DROP_TABLE);

        try {
            $statement = $db->query($query);
            $statement->execute([]);
            return true;
        } catch (\Exception $ex) {
            return false;
        }
    }

    public function addColumn(string $table, string $column, string $type) : bool{
        $db = Db::getInstance(DatabaseConfig::DB_INSTANCE);
        $query = str_replace('{{table}}',$table, self::UPDATE_TABLE_ADD_COL);
        $query = str_replace('{{column}}', $column, $query);
        $query = str_replace('{{type}}', $type, $query);

        try {
            $statement = $db->query($query);
            $statement->execute([]);
            return true;
        } catch (\Exception $ex) {
            return false;
        }
    }

    public function dropColumn(string $table, string $column)  : bool {
        $db = Db::getInstance(DatabaseConfig::DB_INSTANCE);
        $query = str_replace('{{table}}', $table, self::UPDATE_TABLE_DELETE_COL);
        $query = str_replace('{{column}}', $column, $query);

        try {
            $statement = $db->query($query);
            $statement->execute([]);
            return true;
        } catch (\Exception $ex) {
            return false;
        }
    }

    public function modifyColumn(string $table, string $column, string $type) : bool {
        $db = Db::getInstance(DatabaseConfig::DB_INSTANCE);
        $query = str_replace('{{table}}',$table, self::UPDATE_TABLE_MODIFY_COL);
        $query = str_replace('{{column}}', $column, $query);
        $query = str_replace('{{type}}', $type, $query);

        try {
            $statement = $db->query($query);
            $statement->execute([]);
            return true;
        } catch (\Exception $ex) {
            return false;
        }
    }

    public function tableExists(string $table) : bool {
        $db = Db::getInstance(DatabaseConfig::DB_INSTANCE);
        $query = str_replace('{{table}}',$table, self::TABLE_EXISTS);

        try {
            $statement = $db->query($query);
            $statement->execute([]);
            return $statement->rowCount() > 0;
        } catch (\Exception $ex) {
            return false;
        }
    }

    public function insertRole($role) : bool {
        $db = Db::getInstance(DatabaseConfig::DB_INSTANCE);
        $statement = $db->prepare(self::INSERT_ROLE);

        try {
            $statement->execute([$role]);
            return $statement->rowCount() > 0;
        } catch (\Exception $ex) {
            return false;
        }
    }

    const CREATE_TABLE = <<<TAG
CREATE TABLE {{name}} (id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY)
TAG;

    const DROP_TABLE = <<<TAG
DROP TABLE IF EXISTS {{name}}
TAG;


    const UPDATE_TABLE_ADD_COL = <<<TAG
ALTER TABLE {{table}}
ADD COLUMN {{column}} {{type}}
TAG;


    const UPDATE_TABLE_DELETE_COL = <<<TAG
ALTER TABLE {{table}}
DROP COLUMN {{column}}
TAG;

    const UPDATE_TABLE_MODIFY_COL = <<<TAG
ALTER TABLE {{table}} MODIFY {{column}} {{type}}
TAG;

    const TABLE_EXISTS = <<<TAG
SHOW TABLES LIKE '{{table}}'
TAG;

    const INSERT_ROLE = <<<TAG
INSERT INTO roles (id, title) values (null, ?)
TAG;
}