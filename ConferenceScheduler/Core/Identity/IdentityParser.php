<?php

namespace ConferenceScheduler\Core\Identity;

use ConferenceScheduler\Core\Database\Db;
use ConferenceScheduler\Configs\DatabaseConfig;

class IdentityParser
{
    public static function updateIdentity()
    {

        $columnsToAdd = new ColumnsParser();
        $columnsToDelete = new ColumnsParser();
        $columnsToUpdate = new ColumnsParser();

        $databaseUser = self::getUserFromDatabase();
        $codeUser = self::getUserFromIdentitySystem();

        foreach ($codeUser->getColumns() as $name => $type) {
            if (!$databaseUser->hasColumn($name)) {
                $columnsToAdd->setColumn($name, $type);
            } else {
                if ($type !== $databaseUser->getColumnType($name)) {
                    $columnsToUpdate->setColumn($name, $type);
                }
            }
        }
        foreach ($databaseUser->getColumns() as $name => $type) {
            if (!$codeUser->hasColumn($name)) {
                if ($name == 'id' || $name == 'Id' || $name == 'password' || $name == 'passwordHash') {
                    continue;
                }

                $columnsToDelete->setColumn($name, $type);
            } else {
                if ($type !== $codeUser->getColumnType($name)) {
                    $columnsToUpdate->setColumn($name, $codeUser->getColumnType($name));
                }
            }
        }

        $tableOps = new TablesUpdater();
        foreach ($columnsToAdd->getColumns() as $column => $type) {
            $tableOps->addColumn('users', $column, $type);
        }
        foreach ($columnsToDelete->getColumns() as $column => $type) {
            $tableOps->dropColumn('users', $column);
        }
        foreach ($columnsToUpdate->getColumns() as $column => $type) {
            $tableOps->modifyColumn('users', $column, $type);
        }

        if (!$tableOps->tableExists('roles')) {
            self::createRolesTable();
        }
        if (!$tableOps->tableExists('usersroles')) {
            self::createUsersRolesTable();
        }
    }

    public static function createIdentity()
    {
        $tableOps = new TablesUpdater();
        if ($tableOps->tableExists('users')) {
            return;
        }

        $tableOps->dropTable('roles');
        $tableOps->dropTable('usersroles');

        $tableOps->createTable('users');
        $tableOps->addColumn('users', 'passwordHash', 'varchar(255)');

        $codeUser = self::getUserFromIdentitySystem();

        foreach ($codeUser->getColumns() as $column => $type) {
            $tableOps->addColumn('users', $column, $type);
        }

        self::createRolesTable();
        self::createUsersRolesTable();
    }

    private static function getUserFromDatabase()
    {
        $userTable = new ColumnsParser();

        $db = Db::getInstance(DatabaseConfig::DB_INSTANCE);
        $statement = $db->query("show columns from users");
        $columns =
            array_map(function($c) {
                return [
                    'name' => $c['Field'],
                    'type' => $c['Type']
                ];
            },
                $statement->fetchAll());
        if (count($columns) == 0) {
            return null;
        }

        foreach ($columns as $column) {
            $userTable->setColumn($column['name'], $column['type']);
        }
        return $userTable;
    }

    private static function getUserFromIdentitySystem()
    {
        $userTable = new ColumnsParser();

        $className = IDENTITY_MODEL_NAME;
        $userInstance = new $className();
        $class = new \ReflectionClass($userInstance);
        $methods = $class->getMethods(\ReflectionMethod::IS_PUBLIC);

        foreach ($methods as $method) {
            if (strpos($method->getName(), 'get') === 0) {
                $columnName = substr($method->getName(), 3, strlen($method->getName()));
                $columnName = strtolower($columnName);

                $annotationsText = $method->getDocComment();
                preg_match("/@type\s+([\w\d\(\)]+)/", $annotationsText, $matches);
                $type = $matches[1];

                $userTable->setColumn($columnName, $type);
            }
        }

        return $userTable;
    }

    private static function createRolesTable()
    {
        $tableOps = new TablesUpdater();
        $tableOps->createTable('roles');
        $tableOps->addColumn('roles', 'name', 'varchar(255)');
        $roles = ['Admin', 'User'];
        foreach ($roles as $role) {
            $tableOps->insertRole($role);
        }
    }

    private static function createUsersRolesTable()
    {
        $tableOps = new TablesUpdater();
        $tableOps->createTable('usersroles');
        $tableOps->addColumn('usersroles', 'id', 'int(11)');
        $tableOps->addColumn('usersroles', 'userid', 'int(11)');
        $tableOps->addColumn('usersroles', 'roleid', 'int(11)');
    }
}