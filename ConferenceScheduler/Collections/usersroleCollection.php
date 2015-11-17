<?php

namespace ConferenceScheduler\Collections;

use ConferenceScheduler\Models\usersrole;

class usersroleCollection
{
    /**
     * @var usersrole[];
     */
    private $collection = [];

    public function __construct($models = [])
    {
        $this->collection = $models;
    }

    /**
     * @return usersrole[]
     */
    public function getusersroles()
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