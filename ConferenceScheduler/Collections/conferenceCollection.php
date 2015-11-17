<?php

namespace ConferenceScheduler\Collections;

use ConferenceScheduler\Models\Conference;

class ConferenceCollection
{
    /**
     * @var Conference[];
     */
    private $collection = [];

    public function __construct($models = [])
    {
        $this->collection = $models;
    }

    /**
     * @return Conference[]
     */
    public function getConferences()
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