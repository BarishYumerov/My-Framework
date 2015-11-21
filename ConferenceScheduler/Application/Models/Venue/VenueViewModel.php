<?php

class VenueViewModel
{
    private $name;
    private $halls;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getHalls()
    {
        return $this->halls;
    }

    /**
     * @param mixed $halls
     */
    public function setHalls($halls)
    {
        $this->halls = $halls;
    }
}