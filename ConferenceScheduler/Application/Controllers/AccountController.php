<?php

namespace ConferenceScheduler\Application\Controllers;

use ConferenceScheduler\Application\Services\AccountService;
use ConferenceScheduler\Application\Models\Account\LoginBindingModel;
use ConferenceScheduler\View;

class AccountController extends BaseController
{
    public function login(){

        $service = new AccountService($this->dbContext);

        if($this->context->getMethod() == 'post'){
            $model = new LoginBindingModel();
            $result = $service->login($model);

            if(isset($result['error'])){
                $this->addErrorMessage($result['error']);
                return new View('account', 'login');
            }
            else{
                $this->addInfoMessage($result['success']);
                $this->redirect();
            }
        }
        return new View('account', 'login');
    }

    public function logout(){
        if($this->context->hasSession('username')){
            unset($_SESSION['username']);
            $this->redirect();
        }
        $this->addErrorMessage('Cannot logout need to login first!');
        $this->redirect('account', 'login');
    }
}