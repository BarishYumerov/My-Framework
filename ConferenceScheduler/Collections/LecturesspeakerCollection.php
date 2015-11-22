<?php

namespace ConferenceScheduler\Collections;

use ConferenceScheduler\Models\Lecturesspeaker;

class LecturesspeakerCollection
{
    /**
     * @var Lecturesspeaker[];
     */
    private $collection = [];

    public function __construct($models = [])
    {
        $this->collection = $models;
    }

    /**
     * @return Lecturesspeaker[]
     */
    public function getLecturesspeakers()
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