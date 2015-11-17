<?php

namespace ConferenceScheduler\Collections;

use ConferenceScheduler\Models\role;

class roleCollection
{
    /**
     * @var role[];
     */
    private $collection = [];

    public function __construct($models = [])
    {
        $this->collection = $models;
    }

    /**
     * @return role[]
     */
    public function getroles()
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