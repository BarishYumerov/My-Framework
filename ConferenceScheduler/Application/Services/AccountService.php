<?php
/**
 * Created by PhpStorm.
 * User: Barish-PC
 * Date: 20.11.2015 ã.
 * Time: 9:33
 */

namespace ConferenceScheduler\Application\Services;

use ConferenceScheduler\Application\Models\Account\LoginBindingModel;

class AccountService extends BaseService
{

    public function login(LoginBindingModel $model){
        if(!$model){
            $this->response['error'] = 'Invalid model!';
            return $this->response;
        }

        $user = $this->dbContext->getUsersRepository()
            ->filterByUsername(' = "' . $model->getUsername() . '"')
            ->findOne();

        if(!$user->getUsername()){
            $this->response['error'] = 'Invalid Username!';
            return $this->response;
        }

        if (password_verify($model->getPassword(), $user->getPassword())) {
            $_SESSION['username'] = $model->getUsername();
            $this->response['success'] = 'Successful login!';
            return $this->response;
        }

        $this->response['error'] = 'Invalid password!';
        return $this->response;
    }
}