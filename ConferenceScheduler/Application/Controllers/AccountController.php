<?php

namespace ConferenceScheduler\Application\Controllers;


class AccountController
{
    /**
     * @Authorize
     * @Route("Pesho/All")
     */
    public function getAll()
    {
        echo '<p class="p">account all</p>';
    }

    public function getOne(){
        echo 'account get one';
    }
}