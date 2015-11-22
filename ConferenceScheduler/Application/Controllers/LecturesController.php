<?php

namespace ConferenceScheduler\Application\Controllers;

use ConferenceScheduler\Application\Services\ConferenceService;
use ConferenceScheduler\Application\Services\LecturesService;
use ConferenceScheduler\View;

class LecturesController extends BaseController
{
    public function getAll(){

    }

    /**
     * @Authorize
     * @Route("Conference/{int id}/Lectures/Manage")
     */
    public function manage(){
        $id = intval(func_get_args()[0]);
        $loggedUserId = $this->identity->getUserId();

        $confService = new ConferenceService($this->dbContext);
        $service = new LecturesService($this->dbContext);

        $conference = $confService->getOne($id);
        if($conference == null){
            $this->addErrorMessage('No such conference!');
            $this->redirect('home');
        }
        if(intval($conference->getOwnerId()) !== $loggedUserId ){
            $this->addErrorMessage('You are not the owner of this conference!');
            $this->redirect('Me', "Conferences");
        }

        $lectures = $service->getLectures($id);

        return new View('lectures', 'manage', $lectures);
    }

    /**
     * @Authorize
     * @Route("Lecture/{int id}/Manage")
     */
    public function edit(){
        $lectureId = intval(func_get_args()[0]);

        $service = new LecturesService($this->dbContext);
        $lecture = $service->getOne($lectureId);
        var_dump($lecture);
    }
}