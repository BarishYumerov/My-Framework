<?php

namespace ConferenceScheduler\Application\Models\Lecture;

use ConferenceScheduler\Models\Lecture;

class LectureViewModel
{
    private $id;
    private $name;
    private $speakers;
    private $startDate;
    private $endDate;
    private $hall;
    private $lectureJoinedMembers;
    private $conferenceId;
    private $venueId;

    public function __construct(Lecture $lecture){
        $this->id = $lecture->getId();
        $this->name = $lecture->getName();
        $this->startDate = $lecture->getStart();
        $this->endDate = $lecture->getEnd();
        $this->conferenceId = $lecture->getConferenceId();
        $this->venueId = $lecture->getVenueId();
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param mixed $speakers
     */
    public function setSpeakers($speakers)
    {
        $this->speakers = $speakers;
    }

    /**
     * @param mixed $startDate
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;
    }

    /**
     * @param mixed $endDate
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
    }

    /**
     * @param mixed $hall
     */
    public function setHall($hall)
    {
        $this->hall = $hall;
    }

    /**
     * @param mixed $lectureJoinedMembers
     * @Return HallViewModel
     */
    public function setLectureJoinedMembers($lectureJoinedMembers)
    {
        $this->lectureJoinedMembers = $lectureJoinedMembers;
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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getSpeakers()
    {
        return $this->speakers;
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
    public function getHall()
    {
        return $this->hall;
    }

    /**
     * @return mixed
     */
    public function getLectureJoinedMembers()
    {
        return $this->lectureJoinedMembers;
    }

    /**
     * @return mixed
     */

    public function getConferenceId()
    {
        return $this->conferenceId;
    }

    /**
     * @param mixed $conferenceId
     */
    public function setConferenceId($conferenceId)
    {
        $this->conferenceId = $conferenceId;
    }

    /**
     * @return mixed
     */
    public function getVenueId()
    {
        return $this->venueId;
    }

    /**
     * @param mixed $venueId
     */
    public function setVenueId($venueId)
    {
        $this->venueId = $venueId;
    }

}