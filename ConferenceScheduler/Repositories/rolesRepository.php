<?php
namespace Con\Repositories;

use ConferenceScheduler\Core\Database\Db;
use ConferenceScheduler\Models\role;
use ConferenceScheduler\Collections\roleCollection;

class rolesRepository
{
    private $query;

    private $where = " WHERE 1";

    private $placeholders = [];

    private $order = '';

    private static $selectedObjectPool = [];
    private static $insertObjectPool = [];

    /**
     * @var rolesRepository
     */
    private static $inst = null;

    private function __construct() { }

    /**
     * @return rolesRepository
     */
    public static function create()
    {
        if (self::$inst == null) {
            self::$inst = new self();
        }

        return self::$inst;
    }

    /**
     * @param $id
     * @return $this
     */
    public function filterById($id)
    {
        $this->where .= " AND id $id";
        $this->placeholders[] = $id;

        return $this;
    }
    /**
     * @param $name
     * @return $this
     */
    public function filterByName($name)
    {
        $this->where .= " AND name $name";
        $this->placeholders[] = $name;

        return $this;
    }

    /**
     * @param $column
     * @return $this
     * @throws \Exception
     */
    public function orderBy($column)
    {
        if (!$this->isColumnAllowed($column)) {
            throw new \Exception("Column not found");
        }

        if (!empty($this->order)) {
            throw new \Exception("Cannot do primary order, because you already have a primary order");
        }

        $this->order .= " ORDER BY $column";

        return $this;
    }

    /**
     * @param $column
     * @return $this
     * @throws \Exception
     */
    public function orderByDescending($column)
    {
        if (!$this->isColumnAllowed($column)) {
            throw new \Exception("Column not found");
        }

        if (!empty($this->order)) {
            throw new \Exception("Cannot do primary order, because you already have a primary order");
        }

        $this->order .= " ORDER BY $column DESC";

        return $this;
    }

    /**
     * @param $column
     * @return $this
     * @throws \Exception
     */
    public function thenBy($column)
    {
        if (empty($this->order)) {
            throw new \Exception("Cannot do secondary order, because you don't have a primary order");
        }

        if (!$this->isColumnAllowed($column)) {
            throw new \Exception("Column not found");
        }

        $this->order .= ", $column ASC";

        return $this;
    }

    /**
     * @param $column
     * @return $this
     * @throws \Exception
     */
    public function thenByDescending($column)
    {
        if (empty($this->order)) {
            throw new \Exception("Cannot do secondary order, because you don't have a primary order");
        }

        if (!$this->isColumnAllowed($column)) {
            throw new \Exception("Column not found");
        }

        $this->order .= ", $column DESC";

        return $this;
    }

    /**
     * @return roleCollection
     * @throws \Exception
     */
    public function findAll()
    {
        $db = DatabaseData::getInstance(\ConferenceScheduler\Configs\DatabaseConfig::DB_INSTANCE);

        $this->query = "SELECT * FROM roles" . $this->where . $this->order;
        $result = $db->prepare($this->query);
        $result->execute([]);

        $collection = [];
        foreach ($result->fetchAll() as $entityInfo) {
            $entity = new role($entityInfo['name'],
$entityInfo['id']);

            $collection[] = $entity;
            self::$selectedObjectPool[] = $entity;
        }

        $this->where = substr($this->where, 0, 8);
        return new roleCollection($collection);
    }

    /**
     * @return role
     * @throws \Exception
     */
    public function findOne()
    {
        $db = DatabaseData::getInstance(\ConferenceScheduler\Configs\DatabaseConfig::DB_INSTANCE);

        $this->query = "SELECT * FROM roles" . $this->where . $this->order . " LIMIT 1";
        $result = $db->prepare($this->query);
        $result->execute([]);
        $entityInfo = $result->fetch();
        $entity = new role($entityInfo['name'],
$entityInfo['id']);

        self::$selectedObjectPool[] = $entity;

        $this->where = substr($this->where, 0, 8);
        return $entity;
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function delete()
    {
        $db = DatabaseData::getInstance(\ConferenceScheduler\Configs\DatabaseConfig::DB_INSTANCE);

        $this->query = "DELETE FROM roles" . $this->where;
        $result = $db->prepare($this->query);
        $result->execute($this->placeholders);

        return $result->rowCount() > 0;
    }

    public static function add(role $model)
    {
        if ($model->getId()) {
            throw new \Exception('This entity is not new');
        }

        self::$insertObjectPool[] = $model;
    }

    public static function save()
    {
        foreach (self::$selectedObjectPool as $entity) {
            self::update($entity);
        }

        foreach (self::$insertObjectPool as $entity) {
            self::insert($entity);
        }

        return true;
    }

    private static function update(role $model)
    {
        $db = DatabaseData::getInstance(\ConferenceScheduler\Configs\DatabaseConfig::DB_INSTANCE);

        $query = "UPDATE roles SET name= :name WHERE id = :id";
        $result = $db->prepare($query);
        $result->execute(
            [
                ':id' => $model->getId(),
':name' => $model->getName()
            ]
        );
    }

    private static function insert(role $model)
    {
        $db = DatabaseData::getInstance(\ConferenceScheduler\Configs\DatabaseConfig::DB_INSTANCE);

        $query = "INSERT INTO roles (name) VALUES (:name);";
        $result = $db->prepare($query);
        $result->execute(
            [
                ':name' => $model->getName()
            ]
        );
        $model->setId($db->lastInsertId());
    }

    private function isColumnAllowed($column)
    {
        $refc = new \ReflectionClass('\ConferenceScheduler\Models\role');
        $consts = $refc->getConstants();

        return in_array($column, $consts);
    }
}