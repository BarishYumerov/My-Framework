<?php

namespace ConferenceScheduler\Collections;

use ConferenceScheduler\Models\Conferenceadmin;

class ConferenceadminCollection
{
    /**
     * @var Conferenceadmin[];
     */
    private $collection = [];

    public function __construct($models = [])
    {
        $this->collection = $models;
    }

    /**
     * @return Conferenceadmin[]
     */
    public function getConferenceadmins()
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