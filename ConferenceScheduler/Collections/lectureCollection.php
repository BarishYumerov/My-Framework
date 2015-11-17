<?php

namespace ConferenceScheduler\Collections;

use ConferenceScheduler\Models\lecture;

class lectureCollection
{
    /**
     * @var lecture[];
     */
    private $collection = [];

    public function __construct($models = [])
    {
        $this->collection = $models;
    }

    /**
     * @return lecture[]
     */
    public function getlectures()
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