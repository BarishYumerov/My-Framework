<?php

namespace ConferenceScheduler\Application\Controllers;

use ConferenceScheduler\Application\Services\ConferenceService;
use ConferenceScheduler\Application\Services\LecturesService;
use ConferenceScheduler\View;


class HomeController extends BaseController
{
    public function index(){
        $service = new ConferenceService($this->dbContext);
        $allConferences =$service->getAll();
        $allConferences = array_slice($allConferences, 0, 6);
        return new View('Home', 'Index', $allConferences);
    }

    /**
     * @Authorize
     * @Route("Me/Invites")
     */
    public function invites(){
        return new View('Home', 'Invites', $this->invites);
    }

    /**
     * @Authorize
     * @Route("Me/Schedule")
     */
    public function mySchedule(){
        $loggedUserId = $this->identity->getUserId();
        $service = new LecturesService($this->dbContext);

        $lecturesToVisit = $this->dbContext->getLecturesusersRepository()
            ->filterByUserId(" = '$loggedUserId'")->findAll()->getLecturesusers();

        $lecturesToVisitView = [];

        foreach ($lecturesToVisit as $lecture) {
            $id = intval($lecture->getLectureId());
            $lecturesToVisitView[] = $service->getOne($id);
        }

        $lecturesToSpeak = $this->dbContext->getLecturesspeakersRepository()
            ->filterBySpeakerId(" = '$loggedUserId'")->findAll()->getLecturesspeakers();

        $lecturesToSpeakView = [];

        foreach ($lecturesToSpeak as $lecture) {
            $id = intval($lecture->getLectureId());
            $lecturesToSpeakView[] = $service->getOne($id);
        }

        $model = ['toVisit' => $lecturesToVisitView, 'toSpeak' => $lecturesToSpeakView];

        return new View('Home', 'mySchedule', $model);
    }
}