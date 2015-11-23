<?php

namespace ConferenceScheduler\Application\Controllers;

use ConferenceScheduler\Application\Models\Account\AddSpeakerBindingModel;
use ConferenceScheduler\Application\Models\Lecture\LectureBindingModel;
use ConferenceScheduler\Application\Services\ConferenceService;
use ConferenceScheduler\Application\Services\LecturesService;
use ConferenceScheduler\Models\Lecturesspeaker;
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
        $venueId = $lecture->getVenueId();
        $halls = $this->dbContext->getHallsRepository()->filterByVenueId(" = '$venueId'")->findAll()->getHalls();
        $viewBag = [];
        $viewBag['halls'] = $halls;
        if($this->context->isPost()){
            $model = new LectureBindingModel();
            if($model->getErrors()){
                foreach ($model->getErrors() as $error) {
                     $this->addErrorMessage($error);
                }
                $this->redirectToUrl('/Lecture/' . $lectureId . '/Manage');
            }

            $conferenceServive = new ConferenceService($this->dbContext);
            $conference = $conferenceServive->getOne(intval($lecture->getConferenceId()));

            if(strtotime($conference->getStart()) > strtotime($model->getStartDate())){
                $this->addErrorMessage('Start of the lecture must be later than start of the conference');
                $this->redirectToUrl('/Lecture/' . $lectureId . '/Manage');
            }

            if(strtotime($conference->getEnd()) < strtotime($model->getEndDate())){
                $this->addErrorMessage('End of the lecture must be earlier than the end of the conference');
                $this->redirectToUrl('/Lecture/' . $lectureId . '/Manage');
            }
            $conferenceId = intval($conference->getId());
            $conferenceLectures = $this->dbContext->getLecturesRepository()
                ->filterByConferenceId(" = '$conferenceId'")
                ->findAll()->getLectures();

            foreach ($conferenceLectures as $confLecture) {
                if(intval($confLecture->getId()) !== intval($lectureId)){
                    if (strtotime($model->getStartDate()) <= strtotime($confLecture->getStart())
                        && strtotime($model ->getEndDate()) >= strtotime($confLecture->getStart())){
                        $this->addErrorMessage('The lecture is during other once check the times!');
                        $this->redirectToUrl('/Lecture/' . $lectureId . '/Manage');
                    }

                    if(strtotime($model->getStartDate()) <= strtotime($confLecture->getEnd())
                        && strtotime($model->getEndDate()) >= strtotime($confLecture->getEnd())){
                        $this->addErrorMessage('The lecture is during other once check the times!');
                        $this->redirectToUrl('/Lecture/' . $lectureId . '/Manage');
                    }

                    if(strtotime($model->getStartDate()) >= strtotime($confLecture->getStart())
                        && strtotime($model->getEndDate()) <= strtotime($confLecture->getEnd())){
                        $this->addErrorMessage('The lecture is during other once check the times!');
                        $this->redirectToUrl('/Lecture/' . $lectureId . '/Manage');
                    }
                }
            }

            $lecture = $this->dbContext->getLecturesRepository()
                ->filterById(" = '$lectureId'")
                ->findOne();
            var_dump($model);
            $lecture->setName($model->getName());
            $lecture->setEnd($model->getEndDate());
            $lecture->setHallId($model->getHallId());
            $lecture->setStart($model->getStartDate());

            $this->dbContext->saveChanges();
            $this->redirectToUrl('/Conference/' . $conferenceId . '/Lectures/Manage');
        }

        return new View('lectures', 'edit', $lecture, $viewBag);
    }

    /**
     * @Authorize
     * @Route("Lecture/{int id}/Remove/Speaker/{int id}")
     */
    public function removeSpeaker(){
        $params = func_get_args();
        $lectureId = intval($params[0]);
        $speakerId = intval($params[1]);

        $speaker = $this->dbContext->getLecturesspeakersRepository()
            ->filterByLectureId(" = '$lectureId'")
            ->filterBySpeakerId(" = '$speakerId'")
            ->findOne();

        if(!$speaker->getId()){
            $this->addErrorMessage('Invalid lecture or speaker!');
            $this->redirect('home');
        }

        $this->dbContext->getLecturesspeakersRepository()
            ->filterByLectureId(" = '$lectureId'")
            ->filterBySpeakerId(" = '$speakerId'")
            ->delete();

        $this->dbContext->saveChanges();

        $this->addInfoMessage("The user was deleted from speakers!");
        $this->redirectToUrl('/Lecture/' . $lectureId . '/Manage');
    }

    /**
     * @Authorize
     * @Route("Lecture/{int id}/Invite/Speaker")
     */
    public function inviteSpeaker(){
        $lectureId = intval(func_get_args()[0]);
        $model = new AddSpeakerBindingModel($lectureId);

        if($this->context->isPost()){
            $user = new AddSpeakerBindingModel($lectureId);
            $username = $user->getUsername();
            $user = $this->dbContext->getUsersRepository()->filterByUsername(" = '$username'")
                ->findOne();

            if(!$user->getId()){
                $this->addErrorMessage('No such user!');
                $this->redirectToUrl("/Lecture/$lectureId/Invite/Speaker");
            }

            $userId = $user->getId();
            $speakerCheck = $this->dbContext->getLecturesspeakersRepository()
                ->filterBySpeakerId(" = '$userId'")
                ->filterByLectureId(" = '$lectureId'")
                ->findOne();

            if($speakerCheck->getId()){
                $this->addErrorMessage('This user is already a speaker in this lecture!');
                $this->redirectToUrl("/Lecture/$lectureId/Invite/Speaker");
            }

            $lectureSpeaker = new Lecturesspeaker($lectureId, $userId);

            $this->dbContext->getLecturesspeakersRepository()->add($lectureSpeaker);
            $this->dbContext->saveChanges();

            $this->addInfoMessage('User added to lecture speakers!');

            $this->redirectToUrl('/Lecture/' . $lectureId . '/Manage');
        }
        return new View('lectures', 'inviteSpeaker', $model);
    }
}