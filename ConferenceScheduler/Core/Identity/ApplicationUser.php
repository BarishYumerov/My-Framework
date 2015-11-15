<?php

namespace ConferenceScheduler\Core\Identity;

class ApplicationUser {
    protected $username;
    protected $email;

    function __construct()
    {
    }

    /**
     * @type varchar(255)
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
     * @type varchar(255)
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }
}