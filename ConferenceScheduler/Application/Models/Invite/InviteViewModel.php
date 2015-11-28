<?php
declare(strcit_types=1);

namespace ConferenceScheduler\Application\Models\Invite;

use ConferenceScheduler\Models\Speakerinvite;
class InviteViewModel
{
    private $id;
    private $userId;
    private $lectureId;
    private $lectureName;
    private $conferenceName;
    private $conferenceId;

    public function __construct(Speakerinvite $invite)
    {
        $this->id = $invite->getId();
        $this->userId = $invite->getUserId();
        $this->lectureId = $invite->getLectureId();
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
    public function setId(string $id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getUserId() : int
    {
        return intval($this->userId);
    }

    /**
     * @param mixed $userId
     */
    public function setUserId(int $userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return mixed
     */
    public function getLectureId() : int
    {
        return intval($this->lectureId);
    }

    /**
     * @param mixed $lectureId
     */
    public function setLectureId(int $lectureId)
    {
        $this->lectureId = $lectureId;
    }

    /**
     * @return mixed
     */
    public function getLectureName() : string
    {
        return $this->lectureName;
    }

    /**
     * @param mixed $lectureName
     */
    public function setLectureName(string $lectureName)
    {
        $this->lectureName = $lectureName;
    }

    /**
     * @return mixed
     */
    public function getConferenceName() : string
    {
        return $this->conferenceName;
    }

    /**
     * @param mixed $conferenceName
     */
    public function setConferenceName(string $conferenceName)
    {
        $this->conferenceName = $conferenceName;
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

}