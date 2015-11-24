<?php

namespace ConferenceScheduler\Collections;

use ConferenceScheduler\Models\Speakerinvite;

class SpeakerinviteCollection
{
    /**
     * @var Speakerinvite[];
     */
    private $collection = [];

    public function __construct($models = [])
    {
        $this->collection = $models;
    }

    /**
     * @return Speakerinvite[]
     */
    public function getSpeakerinvites()
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