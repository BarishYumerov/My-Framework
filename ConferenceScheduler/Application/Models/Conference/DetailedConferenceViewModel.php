<?php
declare(strict_types=1);

namespace ConferenceScheduler\Application\Models\Conference;

use ConferenceScheduler\Models\Conference;

class DetailedConferenceViewModel
{
    private $id;
    private $startDate;
    private $endDate;
    private $owner;
    private $venue;
    private $title;
    private $venueId;
    private $lectures;

    function __construct(Conference $conference)
    {
        $this->id = $conference->getId();
        $this->title = $conference->getName();
        $this->startDate = $conference->getStart();
        $this->endDate = $conference->getEnd();
        $this->venueId = $conference->getVenueId();
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

    /**
     * @return mixed
     */
    public function getStartDate() : string
    {
        return $this->startDate;
    }

    /**
     * @param mixed $startDate
     */
    public function setStartDate(string $startDate)
    {
        $this->startDate = $startDate;
    }

    /**
     * @return mixed
     */
    public function getEndDate() : string
    {
        return $this->endDate;
    }

    /**
     * @param mixed $endDate
     */
    public function setEndDate(string $endDate)
    {
        $this->endDate = $endDate;
    }

    /**
     * @return mixed
     */
    public function getOwner() : string
    {
        return $this->owner;
    }

    /**
     * @param mixed $owner
     */
    public function setOwner(string $owner)
    {
        $this->owner = $owner;
    }

    /**
     * @return mixed
     */
    public function getVenue() : string
    {
        return $this->venue;
    }

    /**
     * @param mixed $venue
     */
    public function setVenue(string $venue)
    {
        $this->venue = $venue;
    }

    /**
     * @return mixed
     */
    public function getTitle() : string
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getVenueId() : int
    {
        return intval($this->venueId);
    }

    /**
     * @param mixed $venueId
     */
    public function setVenueId(int $venueId)
    {
        $this->venueId = $venueId;
    }

    /**
     * @return mixed
     */
    public function getLectures() : array
    {
        return $this->lectures;
    }

    /**
     * @param mixed $lectures
     */
    public function setLectures(array $lectures)
    {
        $this->lectures = $lectures;
    }


}