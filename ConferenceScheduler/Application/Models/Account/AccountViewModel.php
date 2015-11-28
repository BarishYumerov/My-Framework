<?php
declare(strict_types=1);

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
}