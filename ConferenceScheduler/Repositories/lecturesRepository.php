<?php
namespace ConferenceScheduler\Repositories;

use ConferenceScheduler\Core\Database\Db;
use ConferenceScheduler\Models\Lecture;
use ConferenceScheduler\Collections\LectureCollection;

class lecturesRepository
{
    private $query;

    private $where = " WHERE 1";

    private $placeholders = [];

    private $order = '';

    private static $selectedObjectPool = [];
    private static $insertObjectPool = [];

    /**
     * @var lecturesRepository
     */
    private static $inst = null;

    private function __construct() { }

    /**
     * @return lecturesRepository
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
     * @param $speakerId
     * @return $this
     */
    public function filterBySpeakerId($speakerId)
    {
        $this->where .= " AND speakerId $speakerId";
        $this->placeholders[] = $speakerId;

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
     * @param $hallId
     * @return $this
     */
    public function filterByHallId($hallId)
    {
        $this->where .= " AND hallId $hallId";
        $this->placeholders[] = $hallId;

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
     * @param $conferenceId
     * @return $this
     */
    public function filterByConferenceId($conferenceId)
    {
        $this->where .= " AND conferenceId $conferenceId";
        $this->placeholders[] = $conferenceId;

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
     * @return LectureCollection
     * @throws \Exception
     */
    public function findAll()
    {
        $db = Db::getInstance(\ConferenceScheduler\Configs\DatabaseConfig::DB_INSTANCE);

        $this->query = "SELECT * FROM ConferenceScheduler.lectures" . $this->where . $this->order;
        $result = $db->prepare($this->query);
        $result->execute([]);

        $collection = [];
        foreach ($result->fetchAll() as $entityInfo) {
            $entity = new Lecture($entityInfo['Name'],
$entityInfo['speakerId'],
$entityInfo['Start'],
$entityInfo['End'],
$entityInfo['hallId'],
$entityInfo['venueId'],
$entityInfo['conferenceId'],
$entityInfo['id']);

            $collection[] = $entity;
            self::$selectedObjectPool[] = $entity;
        }

        $this->where = substr($this->where, 0, 8);
        return new LectureCollection($collection);
    }

    /**
     * @return Lecture
     * @throws \Exception
     */
    public function findOne()
    {
        $db = Db::getInstance(\ConferenceScheduler\Configs\DatabaseConfig::DB_INSTANCE);

        $this->query = "SELECT * FROM ConferenceScheduler.lectures" . $this->where . $this->order . " LIMIT 1";
        $result = $db->prepare($this->query);
        $result->execute([]);
        $entityInfo = $result->fetch();
        $entity = new Lecture($entityInfo['Name'],
$entityInfo['speakerId'],
$entityInfo['Start'],
$entityInfo['End'],
$entityInfo['hallId'],
$entityInfo['venueId'],
$entityInfo['conferenceId'],
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

        $this->query = "DELETE FROM ConferenceScheduler.lectures" . $this->where;
        $result = $db->prepare($this->query);
        $result->execute($this->placeholders);

        return $result->rowCount() > 0;
    }

    public static function add(Lecture $model)
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

    private static function update(Lecture $model)
    {
        $db = Db::getInstance(\ConferenceScheduler\Configs\DatabaseConfig::DB_INSTANCE);

        $query = "UPDATE lectures SET Name= :Name, speakerId= :speakerId, Start= :Start, End= :End, hallId= :hallId, venueId= :venueId, conferenceId= :conferenceId WHERE id = :id";
        $result = $db->prepare($query);
        $result->execute(
            [
                ':id' => $model->getId(),
':Name' => $model->getName(),
':speakerId' => $model->getSpeakerId(),
':Start' => $model->getStart(),
':End' => $model->getEnd(),
':hallId' => $model->getHallId(),
':venueId' => $model->getVenueId(),
':conferenceId' => $model->getConferenceId()
            ]
        );
    }

    private static function insert(Lecture $model)
    {
        $db = Db::getInstance(\ConferenceScheduler\Configs\DatabaseConfig::DB_INSTANCE);

        $query = "INSERT INTO lectures (Name,speakerId,Start,End,hallId,venueId,conferenceId) VALUES (:Name, :speakerId, :Start, :End, :hallId, :venueId, :conferenceId);";
        $result = $db->prepare($query);
        $result->execute(
            [
                ':Name' => $model->getName(),
':speakerId' => $model->getSpeakerId(),
':Start' => $model->getStart(),
':End' => $model->getEnd(),
':hallId' => $model->getHallId(),
':venueId' => $model->getVenueId(),
':conferenceId' => $model->getConferenceId()
            ]
        );
        $model->setId($db->lastInsertId());
    }

    private function isColumnAllowed($column)
    {
        $refc = new \ReflectionClass('\ConferenceScheduler\Models\Lecture');
        $consts = $refc->getConstants();

        return in_array($column, $consts);
    }
}