<?php
declare(strict_types=1);

namespace ConferenceScheduler\Application\Models\Account;

class LoginBindingModel
{
    private $username;
    private $password;

    public function __construct(){
        $context = \ConferenceScheduler\Core\HttpContext\HttpContext::getInstance();
        $this->setPassword($context->post('password'));
        $this->setUsername($context->post('username'));
    }

    /**
     * @return mixed
     */
    public function getPassword() : string
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword(string $password)
    {
        $this->password = $password;
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