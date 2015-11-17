<?php
namespace Con\Repositories;

use ConferenceScheduler\Core\Database\Db;
use ConferenceScheduler\Models\conference;
use ConferenceScheduler\Collections\conferenceCollection;

class conferencesRepository
{
    private $query;

    private $where = " WHERE 1";

    private $placeholders = [];

    private $order = '';

    private static $selectedObjectPool = [];
    private static $insertObjectPool = [];

    /**
     * @var conferencesRepository
     */
    private static $inst = null;

    private function __construct() { }

    /**
     * @return conferencesRepository
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
     * @param $VenueId
     * @return $this
     */
    public function filterByVenueId($VenueId)
    {
        $this->where .= " AND VenueId $VenueId";
        $this->placeholders[] = $VenueId;

        return $this;
    }
    /**
     * @param $Start
     * @return $this
     */
    public function filterByStart($Start)
    {
        $this->where .= " AND Start $Start";
        $this->placeholders[] = $Start;

        return $this;
    }
    /**
     * @param $End
     * @return $this
     */
    public function filterByEnd($End)
    {
        $this->where .= " AND End $End";
        $this->placeholders[] = $End;

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
     * @return conferenceCollection
     * @throws \Exception
     */
    public function findAll()
    {
        $db = DatabaseData::getInstance(\ConferenceScheduler\Configs\DatabaseConfig::DB_INSTANCE);

        $this->query = "SELECT * FROM conferences" . $this->where . $this->order;
        $result = $db->prepare($this->query);
        $result->execute([]);

        $collection = [];
        foreach ($result->fetchAll() as $entityInfo) {
            $entity = new conference($entityInfo['Name'],
$entityInfo['VenueId'],
$entityInfo['Start'],
$entityInfo['End'],
$entityInfo['id']);

            $collection[] = $entity;
            self::$selectedObjectPool[] = $entity;
        }

        $this->where = substr($this->where, 0, 8);
        return new conferenceCollection($collection);
    }

    /**
     * @return conference
     * @throws \Exception
     */
    public function findOne()
    {
        $db = DatabaseData::getInstance(\ConferenceScheduler\Configs\DatabaseConfig::DB_INSTANCE);

        $this->query = "SELECT * FROM conferences" . $this->where . $this->order . " LIMIT 1";
        $result = $db->prepare($this->query);
        $result->execute([]);
        $entityInfo = $result->fetch();
        $entity = new conference($entityInfo['Name'],
$entityInfo['VenueId'],
$entityInfo['Start'],
$entityInfo['End'],
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

        $this->query = "DELETE FROM conferences" . $this->where;
        $result = $db->prepare($this->query);
        $result->execute($this->placeholders);

        return $result->rowCount() > 0;
    }

    public static function add(conference $model)
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

    private static function update(conference $model)
    {
        $db = DatabaseData::getInstance(\ConferenceScheduler\Configs\DatabaseConfig::DB_INSTANCE);

        $query = "UPDATE conferences SET Name= :Name, VenueId= :VenueId, Start= :Start, End= :End WHERE id = :id";
        $result = $db->prepare($query);
        $result->execute(
            [
                ':id' => $model->getId(),
':Name' => $model->getName(),
':VenueId' => $model->getVenueId(),
':Start' => $model->getStart(),
':End' => $model->getEnd()
            ]
        );
    }

    private static function insert(conference $model)
    {
        $db = DatabaseData::getInstance(\ConferenceScheduler\Configs\DatabaseConfig::DB_INSTANCE);

        $query = "INSERT INTO conferences (Name,VenueId,Start,End) VALUES (:Name, :VenueId, :Start, :End);";
        $result = $db->prepare($query);
        $result->execute(
            [
                ':Name' => $model->getName(),
':VenueId' => $model->getVenueId(),
':Start' => $model->getStart(),
':End' => $model->getEnd()
            ]
        );
        $model->setId($db->lastInsertId());
    }

    private function isColumnAllowed($column)
    {
        $refc = new \ReflectionClass('\ConferenceScheduler\Models\conference');
        $consts = $refc->getConstants();

        return in_array($column, $consts);
    }
}