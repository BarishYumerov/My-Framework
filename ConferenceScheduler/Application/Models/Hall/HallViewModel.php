<?php

namespace ConferenceScheduler\Application\Models\Hall;

use ConferenceScheduler\Models\Hall;

class HallViewModel
{
    private $id;
    private $hallName;
    private $maxHallPlaces;

    public function __construct(Hall $hall){
        $this->hallName = $hall->getName();
        $this->maxHallPlaces = $hall->getPlaces();
        $this->id = $hall->getId();
    }

    /**
     * @return mixed
     */
    public function getHallName()
    {
        return $this->hallName;
    }

    /**
     * @param mixed $hallName
     */
    public function setHallName($hallName)
    {
        $this->hallName = $hallName;
    }

    /**
     * @return mixed
     */
    public function getMaxHallPlaces()
    {
        return $this->maxHallPlaces;
    }

    /**
     * @param mixed $maxHallPlaces
     */
    public function setMaxHallPlaces($maxHallPlaces)
    {
        $this->maxHallPlaces = $maxHallPlaces;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }
}