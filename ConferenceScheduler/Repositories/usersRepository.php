<?php
namespace ConferenceScheduler\Repositories;

use ConferenceScheduler\Core\Database\Db;
use ConferenceScheduler\Models\User;
use ConferenceScheduler\Collections\UserCollection;

class usersRepository
{
    private $query;

    private $where = " WHERE 1";

    private $placeholders = [];

    private $order = '';

    private static $selectedObjectPool = [];
    private static $insertObjectPool = [];

    /**
     * @var usersRepository
     */
    private static $inst = null;

    private function __construct() { }

    /**
     * @return usersRepository
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
     * @param $username
     * @return $this
     */
    public function filterByUsername($username)
    {
        $this->where .= " AND username $username";
        $this->placeholders[] = $username;

        return $this;
    }
    /**
     * @param $email
     * @return $this
     */
    public function filterByEmail($email)
    {
        $this->where .= " AND email $email";
        $this->placeholders[] = $email;

        return $this;
    }
    /**
     * @param $telephone
     * @return $this
     */
    public function filterByTelephone($telephone)
    {
        $this->where .= " AND telephone $telephone";
        $this->placeholders[] = $telephone;

        return $this;
    }
    /**
     * @param $address
     * @return $this
     */
    public function filterByAddress($address)
    {
        $this->where .= " AND address $address";
        $this->placeholders[] = $address;

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
     * @return UserCollection
     * @throws \Exception
     */
    public function findAll()
    {
        $db = Db::getInstance(\ConferenceScheduler\Configs\DatabaseConfig::DB_INSTANCE);

        $this->query = "SELECT * FROM users" . $this->where . $this->order;
        $result = $db->prepare($this->query);
        $result->execute([]);

        $collection = [];
        foreach ($result->fetchAll() as $entityInfo) {
            $entity = new User($entityInfo['username'],
$entityInfo['email'],
$entityInfo['telephone'],
$entityInfo['address'],
$entityInfo['id']);

            $collection[] = $entity;
            self::$selectedObjectPool[] = $entity;
        }

        $this->where = substr($this->where, 0, 8);
        return new UserCollection($collection);
    }

    /**
     * @return User
     * @throws \Exception
     */
    public function findOne()
    {
        $db = Db::getInstance(\ConferenceScheduler\Configs\DatabaseConfig::DB_INSTANCE);

        $this->query = "SELECT * FROM users" . $this->where . $this->order . " LIMIT 1";
        $result = $db->prepare($this->query);
        $result->execute([]);
        $entityInfo = $result->fetch();
        $entity = new User($entityInfo['username'],
$entityInfo['email'],
$entityInfo['telephone'],
$entityInfo['address'],
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

        $this->query = "DELETE FROM users" . $this->where;
        $result = $db->prepare($this->query);
        $result->execute($this->placeholders);

        return $result->rowCount() > 0;
    }

    public static function add(User $model)
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

    private static function update(User $model)
    {
        $db = Db::getInstance(\ConferenceScheduler\Configs\DatabaseConfig::DB_INSTANCE);

        $query = "UPDATE users SET username= :username, email= :email, telephone= :telephone, address= :address WHERE id = :id";
        $result = $db->prepare($query);
        $result->execute(
            [
                ':id' => $model->getId(),
':username' => $model->getUsername(),
':email' => $model->getEmail(),
':telephone' => $model->getTelephone(),
':address' => $model->getAddress()
            ]
        );
    }

    private static function insert(User $model)
    {
        $db = Db::getInstance(\ConferenceScheduler\Configs\DatabaseConfig::DB_INSTANCE);

        $query = "INSERT INTO users (username,email,telephone,address) VALUES (:username, :email, :telephone, :address);";
        $result = $db->prepare($query);
        $result->execute(
            [
                ':username' => $model->getUsername(),
':email' => $model->getEmail(),
':telephone' => $model->getTelephone(),
':address' => $model->getAddress()
            ]
        );
        $model->setId($db->lastInsertId());
    }

    private function isColumnAllowed($column)
    {
        $refc = new \ReflectionClass('\ConferenceScheduler\Models\User');
        $consts = $refc->getConstants();

        return in_array($column, $consts);
    }
}