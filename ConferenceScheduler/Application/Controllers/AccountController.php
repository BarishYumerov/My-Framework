<?php

namespace ConferenceScheduler\Application\Controllers;


class AccountController
{
    /**
     * @Authorize
     */
    public function getAll()
    {
        echo '<p class="p">account all</p>';
    }

    /**
     * @Authorize
     * @Route("accounts/{int id}/get")
     */
    public function getOne(){
        echo 'account get one';
    }
}