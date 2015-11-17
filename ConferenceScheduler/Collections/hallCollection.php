<?php

namespace ConferenceScheduler\Collections;

use ConferenceScheduler\Models\hall;

class hallCollection
{
    /**
     * @var hall[];
     */
    private $collection = [];

    public function __construct($models = [])
    {
        $this->collection = $models;
    }

    /**
     * @return hall[]
     */
    public function gethalls()
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