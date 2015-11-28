<?php
declare(strcit_types=1);

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
    public function getHallName() : string
    {
        return $this->hallName;
    }

    /**
     * @param mixed $hallName
     */
    public function setHallName(string $hallName)
    {
        $this->hallName = $hallName;
    }

    /**
     * @return mixed
     */
    public function getMaxHallPlaces() : int
    {
        return intval($this->maxHallPlaces);
    }

    /**
     * @param mixed $maxHallPlaces
     */
    public function setMaxHallPlaces(string $maxHallPlaces)
    {
        $this->maxHallPlaces = $maxHallPlaces;
    }

    /**
     * @return mixed
     */
    public function getId() : int
    {
        return intval($this->id);
    }

    /**
     * @param mixed $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }
}