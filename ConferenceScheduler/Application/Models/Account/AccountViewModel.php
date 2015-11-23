<?php

namespace ConferenceScheduler\Application\Models\Account;


use ConferenceScheduler\Models\User;

class AccountViewModel
{
    private $id;
    private $username;

    public function __construct(User $user){
        $this->id = $user->getId();
        $this->username = $user->getUsername();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
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
}