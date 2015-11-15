<?php

namespace ConferenceScheduler\Application\Controllers;


class AccountController
{
    /**
     * @Authorize
     */
    public function getAll()
    {
        echo 'all accounts';
    }

    /**
     * @Authorize
     * @Route("account/{int id}/get")
     */
    public function getOne(){
        echo 'account get one';
    }
}