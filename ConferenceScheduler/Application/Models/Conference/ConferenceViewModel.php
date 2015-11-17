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
}