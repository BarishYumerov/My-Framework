<?php
declare(strict_types=1);

namespace ConferenceScheduler\Application\Controllers;

use ConferenceScheduler\Application\Models\Account\AddSpeakerBindingModel;
use ConferenceScheduler\Application\Models\Lecture\LectureBindingModel;
use ConferenceScheduler\Application\Services\ConferenceService;
use ConferenceScheduler\Application\Services\LecturesService;
use ConferenceScheduler\Models\Lecture;
use ConferenceScheduler\Models\Lecturesspeaker;
use ConferenceScheduler\Models\Lecturesuser;
use ConferenceScheduler\Models\Speakerinvite;
use ConferenceScheduler\View;

class LecturesController extends BaseController
{

    /**
     * @Authorize
     * @Route("Lecture/{int id}/Delete")
     */
    public function delete(){
        $lectureId = intval(func_get_args()[0]);
        $loggedUserId = $this->identity->getUserId();
        $service = new LecturesService($this->dbContext);
        $confService = new ConferenceService($this->dbContext);

        $lecture = $service->getOne($lectureId);

        if($lecture == null){
            $this->addErrorMessage('No such conference!');
            $this->redirect('home');
        }

        $id = intval($lecture->getConferenceId());

        $conference = $confService->getOne($id);

        $conferenceOwner = intval($conference->getOwnerId());

        if(!$this->identity->isInRole("Admin")){
            if($conferenceOwner !== $loggedUserId){
                $this->addErrorMessage('You cannot edit this conference lectures!');
                $this->redirectToUrl('/Me/Conferences');
            }
        }

        $service->delete($lectureId);

        $this->addInfoMessage("Lecture deleted!");
        $this->redirectToUrl("/Conference/$id/Lectures/Manage");
    }

    /**
     * @Authorize
     * @Route("Conference/{int id}/Lectures/Manage")
     */
    public function manage() : View{
        $id = intval(func_get_args()[0]);
        $loggedUserId = $this->identity->getUserId();

        $viewBag = [];

        $confService = new ConferenceService($this->dbContext);
        $service = new LecturesService($this->dbContext);

        $conference = $confService->getOne($id);

        if($conference == null){
            $this->addErrorMessage('No such conference!');
            $this->redirect('home');
        }

        $conferenceAdmins = $this->dbContext->getConferenceadminsRepository()
            ->filterByConferenceId(" = '$id'")->findAll()->getConferenceadmins();

        if(!$this->identity->isInRole("Admin")){
            if($loggedUserId !== intval($conference->getOwnerId())){
                $unauthorized = true;
                foreach ($conferenceAdmins as $admin) {
                    if(intval($admin->getUserId()) === $loggedUserId ){
                        $unauthorized = false;
                        $viewBag['isAdmin'] = true;
                        break;
                    }
                }
                if($unauthorized){
                    $this->addErrorMessage("You are not the owner of this conference!");
                    $this->redirect('Me', 'Conferences');
                }
            }
        }

        $lectures = $service->getLectures($id);

        $viewBag['conferenceId'] = $id;
        return new View('lectures', 'manage', $lectures, $viewBag);
    }

    /**
     * @Authorize
     * @Route("Conference/{int id}/Add/Lecture")
     */
    public function add() : View{
        $conferenceId = intval(func_get_args()[0]);
        $viewBag = [];
        $viewBag['conferenceId'] = $conferenceId;

        $conferenceService = new ConferenceService($this->dbContext);
        $conference = $conferenceService->getOne($conferenceId);

        if(!$this->identity->isInRole("Admin")){
            if(intval($conference->getOwnerId()) !== $this->identity->getUserId()){
                $this->addErrorMessage('You are not allowed to add lectures to this conference!');
                $this->redirect('Me', 'Conferences');
            }
        }

        $venueId = $conference->getVenueId();
        $halls = $this->dbContext->getHallsRepository()->filterByVenueId(" = '$venueId'")->findAll()->getHalls();

        $viewBag['halls'] = $halls;

        if($this->context->isPost()){
            $this->validateToken();
            $model = new LectureBindingModel();
            if($model->getErrors()){
                foreach ($model->getErrors() as $error) {
                    $this->addErrorMessage($error);
                }
                $this->redirectToUrl('/Conference/' . $conferenceId . '/Add/Lecture');
            }

            if(strtotime($conference->getStart()) > strtotime($model->getStartDate())){
                $this->addErrorMessage('Start of the lecture must be later than start of the conference');
                $this->redirectToUrl('/Conference/' . $conferenceId . '/Add/Lecture');
            }

            if(strtotime($conference->getEnd()) < strtotime($model->getEndDate())){
                $this->addErrorMessage('End of the lecture must be earlier than the end of the conference');
                $this->redirectToUrl('/Conference/' . $conferenceId . '/Add/Lecture');
            }

            $conferenceId = intval($conference->getId());

            $conferenceLectures = $this->dbContext->getLecturesRepository()
                ->filterByConferenceId(" = '$conferenceId'")
                ->findAll()->getLectures();

            foreach ($conferenceLectures as $confLecture) {
                if(intval($confLecture->getHallId()) == intval($model->getHallId())){
                    if (strtotime($model->getStartDate()) <= strtotime($confLecture->getStart())
                        && strtotime($model ->getEndDate()) >= strtotime($confLecture->getStart())){
                        $this->addErrorMessage('The hall is busy during this time!');
                        $this->redirectToUrl('/Conference/' . $conferenceId . '/Add/Lecture');
                    }

                    if(strtotime($model->getStartDate()) <= strtotime($confLecture->getEnd())
                        && strtotime($model->getEndDate()) >= strtotime($confLecture->getEnd())){
                        $this->addErrorMessage('The hall is busy during this time!');
                        $this->redirectToUrl('/Conference/' . $conferenceId . '/Add/Lecture');
                    }

                    if(strtotime($model->getStartDate()) >= strtotime($confLecture->getStart())
                        && strtotime($model->getEndDate()) <= strtotime($confLecture->getEnd())){
                        $this->addErrorMessage('The lecture is during other once check the times!');
                        $this->redirectToUrl('/Conference/' . $conferenceId . '/Add/Lecture');
                    }
                }
            }

            $lecture = new Lecture(
                $model->getName(),
                $model->getStartDate(),
                $model->getEndDate(),
                intval($model->getHallId()),
                intval($conference->getVenueId()),
                $conferenceId);

            $this->dbContext->getLecturesRepository()->add($lecture);
            $this->dbContext->saveChanges();
            $this->redirectToUrl("/Conference/$conferenceId/Edit");
        }

        return new View('Lectures', 'Add', null, $viewBag);

    }

    /**
     * @Authorize
     * @Route("Lecture/{int id}/Manage")
     */
    public function edit() : View{
        $lectureId = intval(func_get_args()[0]);

        $service = new LecturesService($this->dbContext);
        $lecture = $service->getOne($lectureId);

        $conferenceService = new ConferenceService($this->dbContext);
        $conference = $conferenceService->getOne(intval($lecture->getConferenceId()));
        $viewBag = [];
        $loggedUserId = $this->identity->getUserId();
        $id = intval($conference->getId());

        $conferenceAdmins = $this->dbContext->getConferenceadminsRepository()
            ->filterByConferenceId(" = '$id'")->findAll()->getConferenceadmins();

        if(!$this->identity->isInRole("Admin")){
            if($loggedUserId !== intval($conference->getOwnerId())){
                $unauthorized = true;
                foreach ($conferenceAdmins as $admin) {
                    if(intval($admin->getUserId()) === $loggedUserId ){
                        $unauthorized = false;
                        $viewBag['isAdmin'] = true;
                        break;
                    }
                }
                if($unauthorized){
                    $this->addErrorMessage("You are not the owner of this conference!");
                    $this->redirect('Me', 'Conferences');
                }
            }
        }

        $venueId = $lecture->getVenueId();
        $halls = $this->dbContext->getHallsRepository()->filterByVenueId(" = '$venueId'")->findAll()->getHalls();
        $viewBag['halls'] = $halls;

        if($this->context->isPost()){
            $this->validateToken();
            $model = new LectureBindingModel();
            if($model->getErrors()){
                foreach ($model->getErrors() as $error) {
                     $this->addErrorMessage($error);
                }
                $this->redirectToUrl('/Lecture/' . $lectureId . '/Manage');
            }

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
                if(intval($confLecture->getHallId()) == intval($model->getHallId())){
                    if(intval($confLecture->getId()) !== intval($lectureId)){
                        if (strtotime($model->getStartDate()) <= strtotime($confLecture->getStart())
                            && strtotime($model ->getEndDate()) >= strtotime($confLecture->getStart())){
                            $this->addErrorMessage('The hall is busy during this time span!');
                            $this->redirectToUrl('/Lecture/' . $lectureId . '/Manage');
                        }

                        if(strtotime($model->getStartDate()) <= strtotime($confLecture->getEnd())
                            && strtotime($model->getEndDate()) >= strtotime($confLecture->getEnd())){
                            $this->addErrorMessage('The hall is busy during this time span!');
                            $this->redirectToUrl('/Lecture/' . $lectureId . '/Manage');
                        }

                        if(strtotime($model->getStartDate()) >= strtotime($confLecture->getStart())
                            && strtotime($model->getEndDate()) <= strtotime($confLecture->getEnd())){
                            $this->addErrorMessage('The lecture is during other once check the times!');
                            $this->redirectToUrl('/Lecture/' . $lectureId . '/Manage');
                        }
                    }
                }
            }

            $lecture = $this->dbContext->getLecturesRepository()
                ->filterById(" = '$lectureId'")
                ->findOne();

            $lecture->setName($model->getName());
            $lecture->setEnd($model->getEndDate());
            if($model->getHallId()){
                $lecture->setHallId($model->getHallId());
            }
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
        $loggedUserId = $this->identity->getUserId();

        $lecture = (new LecturesService($this->dbContext))->getOne($lectureId);
        $conference = (new ConferenceService($this->dbContext))->getOne(intval($lecture->getConferenceId()));

        $conferenceId = intval($conference->getId());

        $conferenceAdmins = $this->dbContext->getConferenceadminsRepository()
            ->filterByConferenceId(" = '$conferenceId'")->findAll()->getConferenceadmins();

        if(!$this->identity->isInRole("Admin")){
            if($loggedUserId !== intval($conference->getOwnerId())){
                $unauthorized = true;
                foreach ($conferenceAdmins as $admin) {
                    if(intval($admin->getUserId()) === $loggedUserId ){
                        $unauthorized = false;
                        $viewBag['isAdmin'] = true;
                        break;
                    }
                }
                if($unauthorized){
                    $this->addErrorMessage("You are not the owner of this conference!");
                    $this->redirect('Me', 'Conferences');
                }
            }
        }

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
    public function inviteSpeaker() : View{
        $lectureId = intval(func_get_args()[0]);
        $lecture = $this->dbContext->getLecturesRepository()->filterById(" = '$lectureId'")->findOne();

        $conferenceId = intval($lecture->getConferenceId());

        $loggedUserId = $this->identity->getUserId();

        $conferenceService = new ConferenceService($this->dbContext);
        $conference = $conferenceService->getOne($conferenceId);

        $conferenceAdmins = $this->dbContext->getConferenceadminsRepository()
            ->filterByConferenceId(" = '$conferenceId'")->findAll()->getConferenceadmins();

        if(!$this->identity->isInRole("Admin")){
            if($loggedUserId !== intval($conference->getOwnerId())){
                $unauthorized = true;
                foreach ($conferenceAdmins as $admin) {
                    if(intval($admin->getUserId()) === $loggedUserId ){
                        $unauthorized = false;
                        $viewBag['isAdmin'] = true;
                        break;
                    }
                }
                if($unauthorized){
                    $this->addErrorMessage("You are not the owner of this conference!");
                    $this->redirect('Me', 'Conferences');
                }
            }
        }

        $model = new AddSpeakerBindingModel($lectureId);

        if($this->context->isPost()){
            $this->validateToken();
            $username = $model->getUsername();
            $user = $this->dbContext->getUsersRepository()->filterByUsername(" = '$username'")
                ->findOne();

            if(!$user->getId()){
                $this->addErrorMessage('No such user!');
                $this->redirectToUrl("/Lecture/$lectureId/Invite/Speaker");
            }

            $userId = intval($user->getId());
            $speakerCheck = $this->dbContext->getLecturesspeakersRepository()
                ->filterBySpeakerId(" = '$userId'")
                ->filterByLectureId(" = '$lectureId'")
                ->findOne();

            if($speakerCheck->getId()){
                $this->addErrorMessage('This user is already a speaker in this lecture!');
                $this->redirectToUrl("/Lecture/$lectureId/Invite/Speaker");
            }

            $speakerInvite = new Speakerinvite($userId, $lectureId);

            $this->dbContext->getSpeakerinvitesRepository()->add($speakerInvite);
            $this->dbContext->saveChanges();

            $this->addInfoMessage('User invited to lecture speakers!');

            $this->redirectToUrl('/Lecture/' . $lectureId . '/Manage');
        }
        return new View('lectures', 'inviteSpeaker', $model);
    }

    /**
     * @Authorize
     * @Route("Lecture/{int id}/Visit")
     */
    public function addVisit(){
        $loggedUserId = $this->identity->getUserId();
        $lectureId = intval(func_get_args()[0]);
        $lecture = $this->dbContext->getLecturesRepository()->filterById(" = '$lectureId'")->findOne();

        $conferenceId = $lecture->getConferenceId();

        $lectureFullInfo = (new LecturesService($this->dbContext))->getOne($lectureId);
        $joinedMembersNumber = intval($lectureFullInfo->getLectureJoinedMembers());
        $hallMembers = intval($lectureFullInfo->getHall()->getMaxHallPlaces());

        if($joinedMembersNumber === $hallMembers){
            $this->addErrorMessage('Lecture is full!');
            $this->redirectToUrl("/Conference/$conferenceId/Details");
        }


        $myVisits = $this->dbContext->getLecturesusersRepository()
            ->filterByUserId(" = '$loggedUserId'")->findAll()->getLecturesusers();

        $myVisitLectures = [];

        foreach ($myVisits as $visit) {
            $id = intval($visit->getLectureId());
            $myVisitLectures[] = $this->dbContext->getLecturesRepository()->filterById(" = '$id'")->findOne();
        }

        foreach ($myVisitLectures as $visit) {
            if (strtotime($lecture->getStart()) <= strtotime($visit->getEnd())
                && strtotime($lecture ->getEnd()) >= strtotime($visit->getStart())){
                $this->addErrorMessage('You have another lecture during this time!');
                $this->redirectToUrl("/Conference/$conferenceId/Details");
            }

            if(strtotime($lecture->getStart()) <= strtotime($visit->getEnd())
                && strtotime($lecture->getEnd()) >= strtotime($visit->getEnd())){
                $this->addErrorMessage('You have another lecture during this time!');
                $this->redirectToUrl("/Conference/$conferenceId/Details");
            }

            if(strtotime($lecture->getStart()) >= strtotime($visit->getStart())
                && strtotime($lecture->getEnd()) <= strtotime($visit->getEnd())){
                $this->addErrorMessage('You have another lecture during this time!');
                $this->redirectToUrl("/Conference/$conferenceId/Details");
            }
        }

        $visit = new Lecturesuser($lectureId, $loggedUserId);
        $this->dbContext->getLecturesusersRepository()->add($visit);
        $this->dbContext->saveChanges();

        $this->addInfoMessage('You have joined this lecture!');

        $this->redirectToUrl("/Conference/$conferenceId/Details");
    }

    /**
     * @Authorize
     * @Route("Lecture/{int id}/NotVisit")
     */
    public function notVisit(){
        $loggedUserId = $this->identity->getUserId();
        $lectureId = intval(func_get_args()[0]);

        $id = intval($this->dbContext->getLecturesRepository()->filterById(" = '$lectureId'")->findOne()->getConferenceId());


        $visit = $this->dbContext->getLecturesusersRepository()
            ->filterByUserId(" = '$loggedUserId'")
            ->filterByLectureId(" = $lectureId")
            ->findOne();

        if(!$visit->getId()){
            $this->addErrorMessage("You cannot remove not visited lecture!");
            $this->redirect('home');
        }

        if($visit->getUserId() != intval($visit->getUserId())){
            $this->addErrorMessage("You cannot remove other people visits!");
            $this->redirect('home');
        }

        $this->dbContext->getLecturesusersRepository()
            ->filterByUserId(" = '$loggedUserId'")
            ->filterByLectureId(" = $lectureId")->delete();

        $this->dbContext->saveChanges();
        $this->redirectToUrl("/Conference/$id/Details");
    }
}