<?php
namespace Con\Repositories;

use ConferenceScheduler\Core\Database\Db;
use ConferenceScheduler\Models\hall;
use ConferenceScheduler\Collections\hallCollection;

class hallsRepository
{
    private $query;

    private $where = " WHERE 1";

    private $placeholders = [];

    private $order = '';

    private static $selectedObjectPool = [];
    private static $insertObjectPool = [];

    /**
     * @var hallsRepository
     */
    private static $inst = null;

    private function __construct() { }

    /**
     * @return hallsRepository
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
     * @param $Name
     * @return $this
     */
    public function filterByName($Name)
    {
        $this->where .= " AND Name $Name";
        $this->placeholders[] = $Name;

        return $this;
    }
    /**
     * @param $places
     * @return $this
     */
    public function filterByPlaces($places)
    {
        $this->where .= " AND places $places";
        $this->placeholders[] = $places;

        return $this;
    }
    /**
     * @param $venueId
     * @return $this
     */
    public function filterByVenueId($venueId)
    {
        $this->where .= " AND venueId $venueId";
        $this->placeholders[] = $venueId;

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
     * @return hallCollection
     * @throws \Exception
     */
    public function findAll()
    {
        $db = DatabaseData::getInstance(\ConferenceScheduler\Configs\DatabaseConfig::DB_INSTANCE);

        $this->query = "SELECT * FROM halls" . $this->where . $this->order;
        $result = $db->prepare($this->query);
        $result->execute([]);

        $collection = [];
        foreach ($result->fetchAll() as $entityInfo) {
            $entity = new hall($entityInfo['Name'],
$entityInfo['places'],
$entityInfo['venueId'],
$entityInfo['id']);

            $collection[] = $entity;
            self::$selectedObjectPool[] = $entity;
        }

        $this->where = substr($this->where, 0, 8);
        return new hallCollection($collection);
    }

    /**
     * @return hall
     * @throws \Exception
     */
    public function findOne()
    {
        $db = DatabaseData::getInstance(\ConferenceScheduler\Configs\DatabaseConfig::DB_INSTANCE);

        $this->query = "SELECT * FROM halls" . $this->where . $this->order . " LIMIT 1";
        $result = $db->prepare($this->query);
        $result->execute([]);
        $entityInfo = $result->fetch();
        $entity = new hall($entityInfo['Name'],
$entityInfo['places'],
$entityInfo['venueId'],
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

        $this->query = "DELETE FROM halls" . $this->where;
        $result = $db->prepare($this->query);
        $result->execute($this->placeholders);

        return $result->rowCount() > 0;
    }

    public static function add(hall $model)
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

    private static function update(hall $model)
    {
        $db = DatabaseData::getInstance(\ConferenceScheduler\Configs\DatabaseConfig::DB_INSTANCE);

        $query = "UPDATE halls SET Name= :Name, places= :places, venueId= :venueId WHERE id = :id";
        $result = $db->prepare($query);
        $result->execute(
            [
                ':id' => $model->getId(),
':Name' => $model->getName(),
':places' => $model->getPlaces(),
':venueId' => $model->getVenueId()
            ]
        );
    }

    private static function insert(hall $model)
    {
        $db = DatabaseData::getInstance(\ConferenceScheduler\Configs\DatabaseConfig::DB_INSTANCE);

        $query = "INSERT INTO halls (Name,places,venueId) VALUES (:Name, :places, :venueId);";
        $result = $db->prepare($query);
        $result->execute(
            [
                ':Name' => $model->getName(),
':places' => $model->getPlaces(),
':venueId' => $model->getVenueId()
            ]
        );
        $model->setId($db->lastInsertId());
    }

    private function isColumnAllowed($column)
    {
        $refc = new \ReflectionClass('\ConferenceScheduler\Models\hall');
        $consts = $refc->getConstants();

        return in_array($column, $consts);
    }
}