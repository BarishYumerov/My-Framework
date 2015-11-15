<?php

namespace ConferenceScheduler\Application\Controllers;

class LecturesController
{
    public function getAll(){

    }

    /**
     * @Route("lectures/pesho")
     */
    public function getOne(){
        echo 'lectures get one';
    }
}