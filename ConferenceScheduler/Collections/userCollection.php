<?php

namespace ConferenceScheduler\Collections;

use ConferenceScheduler\Models\User;

class UserCollection
{
    /**
     * @var User[];
     */
    private $collection = [];

    public function __construct($models = [])
    {
        $this->collection = $models;
    }

    /**
     * @return User[]
     */
    public function getUsers()
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