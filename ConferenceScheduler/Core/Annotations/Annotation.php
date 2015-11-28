<?php

namespace ConferenceScheduler\Core\Annotations;

use ConferenceScheduler\Core\Identity\Identity;

abstract class Annotation
{
    protected $identity;

    public function __construct(){
        $this->identity = Identity::getInstance();
    }

    public abstract function annotate();
}