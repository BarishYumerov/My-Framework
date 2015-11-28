<?php
declare(strict_types=1);

namespace ConferenceScheduler\Application\Models\Account;

use ConferenceScheduler\Application\Models\BaseBindingModel;
use ConferenceScheduler\Core\HttpContext\HttpContext;

class RegisterBindingModel extends BaseBindingModel
{
    private $username;
    private $email;
    private $password;
    private $confirmPassword;
    private $telephone;

    public function __construct(){
        $context = HttpContext::getInstance();
        $this->setUsername($context->post('username'));
        $this->setPassword($context->post('password'));
        $this->setConfirmPassword($context->post('confirm'));
        $this->setEmail($context->post('email'));
        $this->setTelephone($context->post('telephone', 'int'));
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
        if(!ctype_alnum($username)){
            $this->errors[] = 'The username must contain only characters and numbers!';
        }
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getEmail() : string
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail(string $email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = "Invalid email";
        }
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getConfirmPassword() : string
    {
        return $this->confirmPassword;
    }

    /**
     * @param mixed $confirmPassword
     */
    public function setConfirmPassword(string $confirmPassword)
    {
        if($confirmPassword !== $this->getPassword()){
            $this->errors[] = 'Passwords does not match!';
        }
        $this->confirmPassword = $confirmPassword;
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
        $pattern = '/[A-Za-z0-9_]+$/';
        preg_match($pattern, $password, $matches);
        if(!isset($matches[0])){
            $this->errors[] = 'Invalid password the password must contain only characters, numbers and "_"!';
        }
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getTelephone() : int
    {
        return $this->telephone;
    }

    /**
     * @param mixed $telephone
     */
    public function setTelephone(int $telephone)
    {
        if($telephone === 0){
            $this->errors[] = 'Phone number must me only digits and length greater than 5!';
        }
        $this->telephone = $telephone;
    }
}