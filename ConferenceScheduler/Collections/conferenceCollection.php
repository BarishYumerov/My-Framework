<?php

namespace ConferenceScheduler\Collections;

use ConferenceScheduler\Models\conference;

class conferenceCollection
{
    /**
     * @var conference[];
     */
    private $collection = [];

    public function __construct($models = [])
    {
        $this->collection = $models;
    }

    /**
     * @return conference[]
     */
    public function getconferences()
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