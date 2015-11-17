<?php

namespace ConferenceScheduler\Collections;

use ConferenceScheduler\Models\venue;

class venueCollection
{
    /**
     * @var venue[];
     */
    private $collection = [];

    public function __construct($models = [])
    {
        $this->collection = $models;
    }

    /**
     * @return venue[]
     */
    public function getvenues()
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