<?php

namespace ConferenceScheduler\Application\Controllers;

use ConferenceScheduler\Core\Database\Db;


class HomeController
{
    public function index(){
        echo '<h1>All Users</h1>';
        $db = Db::getInstance(APPLICATION_NAME);
        $statement = $db->prepare('select * from users');
        $statement->execute();
        $users = $statement->fetchAll();
        var_dump($users);
    }
}