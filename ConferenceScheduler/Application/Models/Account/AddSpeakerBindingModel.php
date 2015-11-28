<?php
declare(strict_types=1);

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
    public function getUsername() : string
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername(string $username)
    {
        $this->username = $username;
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
    public function setLectureId(string $lectureId)
    {
        $this->lectureId = $lectureId;
    }
}