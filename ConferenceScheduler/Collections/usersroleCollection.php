<?php

namespace ConferenceScheduler\Collections;

use ConferenceScheduler\Models\Usersrole;

class UsersroleCollection
{
    /**
     * @var Usersrole[];
     */
    private $collection = [];

    public function __construct($models = [])
    {
        $this->collection = $models;
    }

    /**
     * @return Usersrole[]
     */
    public function getUsersroles()
    {
        return $this->collection;
    }

    /**
     * @param callable $callback
     */
    public function each(Callable $callback)
    {
        foreach ($this->collection as $model) {
            $callback($model);
        }
    }
}