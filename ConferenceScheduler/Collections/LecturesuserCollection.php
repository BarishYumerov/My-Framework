<?php

namespace ConferenceScheduler\Collections;

use ConferenceScheduler\Models\Lecturesuser;

class LecturesuserCollection
{
    /**
     * @var Lecturesuser[];
     */
    private $collection = [];

    public function __construct($models = [])
    {
        $this->collection = $models;
    }

    /**
     * @return Lecturesuser[]
     */
    public function getLecturesusers()
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