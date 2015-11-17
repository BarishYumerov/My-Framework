<?php

namespace ConferenceScheduler\Collections;

use ConferenceScheduler\Models\user;

class userCollection
{
    /**
     * @var user[];
     */
    private $collection = [];

    public function __construct($models = [])
    {
        $this->collection = $models;
    }

    /**
     * @return user[]
     */
    public function getusers()
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