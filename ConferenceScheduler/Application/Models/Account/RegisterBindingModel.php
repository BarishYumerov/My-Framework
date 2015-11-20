<?php

namespace ConferenceScheduler\Application\Models\Account;

use ConferenceScheduler\Core\HttpContext\HttpContext;

class RegisterBindingModel
{
    private $username;
    private $email;
    private $password;
    private $confirmPassword;

    public function __construct(){
        $context = HttpContext::getInstance();
        $this->setUsername($context->post('username'));
        $this->setPassword($context->post('password'));
        $this->setConfirmPassword($context->post('confirm'));
        $this->setEmail($context->post('email'));
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

    /**
     * @return mixed
     */
    public function getConfirmPassword()
    {
        return $this->confirmPassword;
    }

    /**
     * @param mixed $confirmPassword
     */
    public function setConfirmPassword($confirmPassword)
    {
        $this->confirmPassword = $confirmPassword;
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
}