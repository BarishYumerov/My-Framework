<?php

namespace ConferenceScheduler\Collections;

use ConferenceScheduler\Models\Hall;

class HallCollection
{
    /**
     * @var Hall[];
     */
    private $collection = [];

    public function __construct($models = [])
    {
        $this->collection = $models;
    }

    /**
     * @return Hall[]
     */
    public function getHalls()
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