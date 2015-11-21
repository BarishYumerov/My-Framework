<?php
/**
 * Created by PhpStorm.
 * User: Barish-PC
 * Date: 20.11.2015 ã.
 * Time: 9:33
 */

namespace ConferenceScheduler\Application\Services;

use ConferenceScheduler\Application\Models\Account\LoginBindingModel;
use ConferenceScheduler\Application\Models\Account\RegisterBindingModel;
use ConferenceScheduler\Models\User;
use ConferenceScheduler\Models\Usersrole;

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

    public function register(RegisterBindingModel $model){
        if(!$model){
            $this->response['error'] = 'Invalid model!';
            return $this->response;
        }

        $usernameCheck = $this->dbContext->getUsersRepository()->filterByUsername(" = '" . $model->getUsername() . "'")->findOne();
        if($usernameCheck->getId()){
            $this->response['error'] = 'Username already taken!';
            return $this->response;
        }

        $emailCheck = $this->dbContext->getUsersRepository()->filterByEmail(" = '" . $model->getEmail() . "'")->findOne();
        if($emailCheck->getId()){
            $this->response['error'] = 'Email already in use!';
            return $this->response;
        }

        $user = new User(
            $model->getUsername(),
            password_hash($model->getPassword(),PASSWORD_BCRYPT),
            $model->getEmail(),
            $model->getTelephone());

        $this->dbContext->getUsersRepository()->add($user);
        $this->dbContext->saveChanges();

        $user = $this->dbContext->getUsersRepository()->filterByUsername(" = '" . $model->getUsername() . "'")->findOne();
        $userId = intval($user->getId());
        $userRole = new Usersrole($userId, 2, 0);
        $this->dbContext->getUsersrolesRepository()->add($userRole);
        $this->dbContext->saveChanges();

        $this->response['success'] = 'Register successful!';
        return $this->response;
    }
}