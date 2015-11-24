<?php

namespace ConferenceScheduler\Application\Models\Invite;

use ConferenceScheduler\Models\Speakerinvite;
class InviteViewModel
{
    private $userId;
    private $lectureId;
    private $lectureName;
    private $conferenceName;
    private $conferenceId;

    public function __construct(Speakerinvite $invite)
    {
        $this->userId = $invite->getUserId();
        $this->lectureId = $invite->getLectureId();
    }
    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param mixed $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return mixed
     */
    public function getLectureId()
    {
        return $this->lectureId;
    }

    /**
     * @param mixed $lectureId
     */
    public function setLectureId($lectureId)
    {
        $this->lectureId = $lectureId;
    }

    /**
     * @return mixed
     */
    public function getLectureName()
    {
        return $this->lectureName;
    }

    /**
     * @param mixed $lectureName
     */
    public function setLectureName($lectureName)
    {
        $this->lectureName = $lectureName;
    }

    /**
     * @return mixed
     */
    public function getConferenceName()
    {
        return $this->conferenceName;
    }

    /**
     * @param mixed $conferenceName
     */
    public function setConferenceName($conferenceName)
    {
        $this->conferenceName = $conferenceName;
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


}