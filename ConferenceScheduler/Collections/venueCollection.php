<?php

namespace ConferenceScheduler\Collections;

use ConferenceScheduler\Models\Venue;

class VenueCollection
{
    /**
     * @var Venue[];
     */
    private $collection = [];

    public function __construct($models = [])
    {
        $this->collection = $models;
    }

    /**
     * @return Venue[]
     */
    public function getVenues()
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