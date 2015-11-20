<?php
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
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
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