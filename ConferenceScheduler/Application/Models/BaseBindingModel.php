<?php

namespace ConferenceScheduler\Application\Models;

abstract class BaseBindingModel
{
    protected $errors;

    public function getErrors(){
        return $this->errors;
    }
}