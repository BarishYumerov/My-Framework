<?php
declare(strict_types=1);

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

    public function setVenue(string $venue){
        $this->venue = $venue;
    }

    public function setOwner(string $owner){
        $this->owner = $owner;
    }

    /**
     * @return mixed
     */
    public function getId() : int
    {
        return intval($this->id);
    }

    /**
     * @return mixed
     */
    public function getStartDate() : string
    {
        return $this->startDate;
    }

    /**
     * @return mixed
     */
    public function getEndDate() : string
    {
        return $this->endDate;
    }

    /**
     * @return mixed
     */
    public function getOwner() : string
    {
        return $this->owner;
    }

    /**
     * @return mixed
     */
    public function getVenue() : string
    {
        return $this->venue;
    }

    /**
     * @return mixed
     */
    public function getTitle() : string
    {
        return $this->title;
    }

    /**
     * @return mixed
     */
    public function getVenueId() : int
    {
        return intval($this->venueId);
    }
}