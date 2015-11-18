<?php

namespace ConferenceScheduler\Application\Controllers;

use ConferenceScheduler\Core\HttpContext\HttpContext;

class AccountController extends BaseController
{
    public function getAll()
    {
        echo 'all accounts';

        var_dump($this->context->session('pesho'));
    }

    /**
     * @Authorize
     * @Route("account/{int id}/get")
     */
    public function getOne(){
        echo 'account get one';
        $this->context->addSessionItem('pesho', 'kiro');
        $this->redirect('account', 'getAll');
    }
}