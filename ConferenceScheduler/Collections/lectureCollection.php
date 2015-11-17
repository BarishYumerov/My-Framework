<?php

namespace ConferenceScheduler\Collections;

use ConferenceScheduler\Models\Lecture;

class LectureCollection
{
    /**
     * @var Lecture[];
     */
    private $collection = [];

    public function __construct($models = [])
    {
        $this->collection = $models;
    }

    /**
     * @return Lecture[]
     */
    public function getLectures()
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