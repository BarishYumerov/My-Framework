<?php
/**
 * Created by PhpStorm.
 * User: Barish-PC
 * Date: 16.11.2015 ã.
 * Time: 13:33
 */

namespace ConferenceScheduler\Core\Identity;


class MyUser extends ApplicationUser
{
    private $telephone;
    private $address;

    /**
     * @type varchar(50)
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * @param mixed $telephone
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;
    }

    /**
     * @type varchar(50)
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $telephone
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }
}