<?php
namespace ConferenceScheduler\Repositories;

use ConferenceScheduler\Core\Database\Db;
use ConferenceScheduler\Models\Conference;
use ConferenceScheduler\Collections\ConferenceCollection;

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
     * @param $OwnerId
     * @return $this
     */
    public function filterByOwnerId($OwnerId)
    {
        $this->where .= " AND OwnerId $OwnerId";
        $this->placeholders[] = $OwnerId;

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
     * @return ConferenceCollection
     * @throws \Exception
     */
    public function findAll()
    {
        $db = Db::getInstance(\ConferenceScheduler\Configs\DatabaseConfig::DB_INSTANCE);

        $this->query = "SELECT * FROM ConferenceScheduler.conferences" . $this->where . $this->order;
        $result = $db->prepare($this->query);
        $result->execute([]);

        $collection = [];
        foreach ($result->fetchAll() as $entityInfo) {
            $entity = new Conference($entityInfo['Name'],
$entityInfo['VenueId'],
$entityInfo['Start'],
$entityInfo['End'],
$entityInfo['OwnerId'],
$entityInfo['id']);

            $collection[] = $entity;
            self::$selectedObjectPool[] = $entity;
        }

        $this->where = substr($this->where, 0, 8);
        return new ConferenceCollection($collection);
    }

    /**
     * @return Conference
     * @throws \Exception
     */
    public function findOne()
    {
        $db = Db::getInstance(\ConferenceScheduler\Configs\DatabaseConfig::DB_INSTANCE);

        $this->query = "SELECT * FROM ConferenceScheduler.conferences" . $this->where . $this->order . " LIMIT 1";
        $result = $db->prepare($this->query);
        $result->execute([]);
        $entityInfo = $result->fetch();
        $entity = new Conference($entityInfo['Name'],
$entityInfo['VenueId'],
$entityInfo['Start'],
$entityInfo['End'],
$entityInfo['OwnerId'],
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
        $db = Db::getInstance(\ConferenceScheduler\Configs\DatabaseConfig::DB_INSTANCE);

        $this->query = "DELETE FROM ConferenceScheduler.conferences" . $this->where;
        $result = $db->prepare($this->query);
        $result->execute($this->placeholders);

        return $result->rowCount() > 0;
    }

    public static function add(Conference $model)
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

    private static function update(Conference $model)
    {
        $db = Db::getInstance(\ConferenceScheduler\Configs\DatabaseConfig::DB_INSTANCE);

        $query = "UPDATE conferences SET Name= :Name, VenueId= :VenueId, Start= :Start, End= :End, OwnerId= :OwnerId WHERE id = :id";
        $result = $db->prepare($query);
        $result->execute(
            [
                ':id' => $model->getId(),
':Name' => $model->getName(),
':VenueId' => $model->getVenueId(),
':Start' => $model->getStart(),
':End' => $model->getEnd(),
':OwnerId' => $model->getOwnerId()
            ]
        );
    }

    private static function insert(Conference $model)
    {
        $db = Db::getInstance(\ConferenceScheduler\Configs\DatabaseConfig::DB_INSTANCE);

        $query = "INSERT INTO conferences (Name,VenueId,Start,End,OwnerId) VALUES (:Name, :VenueId, :Start, :End, :OwnerId);";
        $result = $db->prepare($query);
        $result->execute(
            [
                ':Name' => $model->getName(),
':VenueId' => $model->getVenueId(),
':Start' => $model->getStart(),
':End' => $model->getEnd(),
':OwnerId' => $model->getOwnerId()
            ]
        );
        $model->setId($db->lastInsertId());
    }

    private function isColumnAllowed($column)
    {
        $refc = new \ReflectionClass('\ConferenceScheduler\Models\Conference');
        $consts = $refc->getConstants();

        return in_array($column, $consts);
    }
}