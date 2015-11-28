<?php
declare(strict_types=1);

namespace ConferenceScheduler\Core\Identity;


class MyUser extends ApplicationUser
{
    private $telephone;
//    private $address;

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

//    /**
//     * @type varchar(50)
//     */
//    public function getAddress()
//    {
//        return $this->address;
//    }
//
//    /**
//     * @param mixed $address
//     */
//    public function setAddress($address)
//    {
//        $this->address = $address;
//    }
}