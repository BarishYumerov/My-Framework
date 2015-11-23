<?php

namespace ConferenceScheduler\Application\Models\Account;

use ConferenceScheduler\Core\HttpContext\HttpContext;

class AddSpeakerBindingModel
{
    private $username;
    private $lectureId;

    public function __construct($lectureId){
        $this->username = HttpContext::getInstance()->post('username', 'string|xss');
        $this->lectureId = $lectureId;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
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
}