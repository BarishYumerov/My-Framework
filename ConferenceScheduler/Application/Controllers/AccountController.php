<?php

namespace ConferenceScheduler\Application\Controllers;

use ConferenceScheduler\Application\Models\Account\RegisterBindingModel;
use ConferenceScheduler\Application\Services\AccountService;
use ConferenceScheduler\Application\Models\Account\LoginBindingModel;
use ConferenceScheduler\View;

class AccountController extends BaseController
{
    public function register(){
        if($this->identity->isAuthorised()){
            $this->redirect('home');
        }
        $service = new AccountService($this->dbContext);

        if($this->context->getMethod() == 'post'){
            $model = new RegisterBindingModel();
            if($model->getErrors()){
                foreach ($model->getErrors() as $error) {
                     $this->addErrorMessage($error);
                }

                return new View('account', 'register', $model);
            }

            $result = $service->register($model);

            if(isset($result['error'])){
                $this->addErrorMessage($result['error']);
                return new View('account', 'register', $model);
            }

            $this->addInfoMessage($result['success']);

            return new View('account', 'login');
        }

        return new View('account', 'register');
    }

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
            unset($_SESSION['userId']);
            $this->redirect();
        }
        $this->addErrorMessage('Cannot logout need to login first!');
        $this->redirect('account', 'login');
    }
}