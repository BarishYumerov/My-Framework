<?php
declare(strcit_types=1);

namespace ConferenceScheduler\Application\Models\Lecture;

use ConferenceScheduler\Application\Models\Hall\HallViewModel;
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
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * @param mixed $name
     */
    public function setName($name) : string
    {
        $this->name = $name;
    }

    /**
     * @param mixed $speakers
     */
    public function setSpeakers(array $speakers)
    {
        $this->speakers = $speakers;
    }

    /**
     * @param mixed $startDate
     */
    public function setStartDate(string $startDate)
    {
        $this->startDate = $startDate;
    }

    /**
     * @param mixed $endDate
     */
    public function setEndDate(string $endDate)
    {
        $this->endDate = $endDate;
    }

    /**
     * @param mixed $hall
     */
    public function setHall(HallViewModel $hall)
    {
        $this->hall = $hall;
    }

    /**
     * @param mixed $lectureJoinedMembers
     * @Return HallViewModel
     */
    public function setLectureJoinedMembers(int $lectureJoinedMembers)
    {
        $this->lectureJoinedMembers = $lectureJoinedMembers;
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
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getSpeakers() : array
    {
        return $this->speakers;
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
    public function getHall() : HallViewModel
    {
        return $this->hall;
    }

    /**
     * @return mixed
     */
    public function getLectureJoinedMembers() : int
    {
        return $this->lectureJoinedMembers;
    }

    /**
     * @return mixed
     */

    public function getConferenceId() : int
    {
        return intval($this->conferenceId);
    }

    /**
     * @param mixed $conferenceId
     */
    public function setConferenceId(int $conferenceId)
    {
        $this->conferenceId = $conferenceId;
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

}