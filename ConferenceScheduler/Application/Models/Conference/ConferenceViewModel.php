<?php

namespace ConferenceScheduler\Application\Models\Conference;

use ConferenceScheduler\Models\Conference;

class ConferenceViewModel
{
    private $id;
    private $startDate;
    private $endDate;
    private $owner;
    private $venue;
    private $title;
    private $venueId;

    function __construct(Conference $conference)
    {
        $this->id = $conference->getId();
        $this->title = $conference->getName();
        $this->startDate = $conference->getStart();
        $this->endDate = $conference->getEnd();
        $this->venueId = $conference->getVenueId();
    }

    public function setVenue($venue){
        $this->venue = $venue;
    }

    public function setOwner($owner){
        $this->owner = $owner;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @return mixed
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * @return mixed
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @return mixed
     */
    public function getVenue()
    {
        return $this->venue;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return mixed
     */
    public function getVenueId()
    {
        return $this->venueId;
    }
}