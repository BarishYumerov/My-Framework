<?php

namespace ConferenceScheduler\Application\Controllers;


class AccountController
{
    /**
     * @Authorize
     */
    public function getAll()
    {
        echo '<p class="p">account awioh all</p>';
    }

    /**
     * @Authorize
     * @Route("account/{int id}/get")
     * @Pesho
     */
    public function getOne(){
        echo 'account get one';
    }
}