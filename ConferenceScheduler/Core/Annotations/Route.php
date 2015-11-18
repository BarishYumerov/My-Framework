<?php

namespace ConferenceScheduler\Core\Annotations;


class Route extends Annotation
{
    private $route;

    public function __construct($route)
    {
        $this->route = $route;
    }
    public function annotate()
    {

    }
}