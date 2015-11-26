<?php

namespace ConferenceScheduler\Application\Controllers;

use ConferenceScheduler\Application\Models\Account\AccountViewModel;
use ConferenceScheduler\Application\Models\Conference\ConferenceBindingModel;
use ConferenceScheduler\Application\Models\Conference\DetailedConferenceViewModel;
use ConferenceScheduler\Application\Services\ConferenceService;
use ConferenceScheduler\Application\Services\LecturesService;
use ConferenceScheduler\Models\Conference;
use ConferenceScheduler\Models\Conferenceadmin;
use ConferenceScheduler\View;

class ConferenceController extends BaseController
{
    /**
     * @Authorize
     * @Route("Conference/{int id}/Remove/Admin/{int id}")
     */
    public function remove(){
        $confId = intval(func_get_args()[0]);
        $userId = intval(func_get_args()[1]);

        $loggedUserId = $this->identity->getUserId();

        $conference = $this->dbContext->getConferencesRepository()->filterById(" = '$confId'")->findOne();

        if(!$conference->getId()){
            $this->addErrorMessage('No such conference!');
            $this->redirect('Me', 'Conferences');
        }

        if(intval($conference->getOwnerId()) !== $loggedUserId){
            $this->addErrorMessage('You are not allowed to edit this conference!');
            $this->redirect('Me', 'Conferences');
        }

        $user = $this->dbContext->getUsersRepository()
            ->filterById(" = '$userId'")->findOne();

        if(!$user->getId()){
            $this->addErrorMessage('No such user!');
            $this->redirectToUrl("/Conference/$confId/Admins/Manage");
        }

        $this->dbContext->getConferenceadminsRepository()
            ->filterByConferenceId(" = '$confId'")
            ->filterByUserId(" = '$userId'")->delete();

        $this->dbContext->saveChanges();
        $this->redirectToUrl("/Conference/$confId/Admins/Manage");
    }

    /**
     * @Authorize
     * @Route("Conference/{int id}/Admins/Manage")
     */
    public function admins(){
        $id = intval(func_get_args()[0]);
        $loggedUserId = $this->identity->getUserId();

        $conference = $this->dbContext->getConferencesRepository()->filterById(" = '$id'")->findOne();

        if(!$conference->getId()){
            $this->addErrorMessage('No such conference!');
            $this->redirect('Me', 'Conferences');
        }

        if(intval($conference->getOwnerId()) !== $loggedUserId){
            $this->addErrorMessage('You are not allowed to edit this conference!');
            $this->redirect('Me', 'Conferences');
        }

        if($this->context->isPost()){
            $user = $this->context->post('username');

            $user = $this->dbContext->getUsersRepository()
                ->filterByUsername(" = '$user'")->findOne();

            if(!$user->getId()){
                $this->addErrorMessage('No such user!');
                $this->redirectToUrl("/Conference/$id/Admins/Manage");
            }

            if(intval($user->getId()) === $loggedUserId){
                $this->addErrorMessage('You cannot add yourself as an admin!!');
                $this->redirectToUrl("/Conference/$id/Admins/Manage");
            }

            $admins = $this->dbContext->getConferenceadminsRepository()
                ->filterByConferenceId(" = '$id'")->findAll()->getConferenceadmins();

            foreach ($admins as $admin) {
                if($admin->getUserId() == $user->getId()){
                    $this->addErrorMessage('This user is already an Admin!');
                    $this->redirectToUrl("/Conference/$id/Admins/Manage");
                }
            }

            $confAdmin = new Conferenceadmin(intval($user->getId()), $id);

            $this->dbContext->getConferenceadminsRepository()->add($confAdmin);

            $this->dbContext->saveChanges();
            $this->addInfoMessage('User have been added to admins!');
            $this->redirectToUrl("/Conference/$id/Admins/Manage");
        }

        $admins = $this->dbContext->getConferenceadminsRepository()
            ->filterByConferenceId(" = '$id'")->findAll()->getConferenceadmins();

        $usersFromDb = [];

        foreach ($admins as $admin) {
            $userId = intval($admin->getUserId());
            $usersFromDb[] = $this->dbContext->getUsersRepository()
                ->filterById(" = '$userId'")->findOne();
        }

        $model = [];

        foreach ($usersFromDb as $admin) {
            $model[] = new AccountViewModel($admin);
        }

        $viewBag = [];
        $viewBag['conferenceId'] = $id;

        return new View('Conference', 'Admins', $model, $viewBag);
    }

    /**
     * @Route("Conference/{int id}/Details")
     */
    public function details(){
        $id = intval(func_get_args()[0]);
        $conference = (new ConferenceService($this->dbContext))->getOne($id);
        $loggedUserId = $this->identity->getUserId();

        $conferenceView = new DetailedConferenceViewModel($conference);

        $venueId = $conference->getVenueId();
        $venue = $this->dbContext->getVenuesRepository()
            ->filterById(" = $venueId")
            ->findOne()
            ->getName();

        $ownerId = $conference->getOwnerId();
        $owner = $this->dbContext->getUsersRepository()
            ->filterById(" = $ownerId")
            ->findOne()
            ->getUsername();

        $lectures = (new LecturesService($this->dbContext))->getLectures($id);

        $conferenceView->setVenue($venue);
        $conferenceView->setOwner($owner);
        $conferenceView->setLectures($lectures);

        $viewBag = [];
        $viewBag['visits'] = $this->dbContext->getLecturesusersRepository()
            ->filterByUserId(" = '$loggedUserId'")->findAll()->getLecturesusers();

        return new View('Conference', 'Details', $conferenceView, $viewBag);
    }

    /**
     * @Authorize
     */
    public function create(){
        $viewBag = [];
        $viewBag['venues'] = $this->dbContext->getVenuesRepository()->findAll()->getVenues();

        if($this->context->getMethod() == 'post'){
            $model = new ConferenceBindingModel();
            if($model->getErrors()){
                foreach ($model->getErrors() as $error) {
                    $this->addErrorMessage($error);
                }
                $this->context->setMethod('get');
                return new View('conference', 'create', $model, $viewBag);
            }

            $venueId = intval($model->getVenueId());

            $conferences = $this->dbContext->getConferencesRepository()
                ->filterByVenueId(" = '$venueId'")->findAll()->getConferences();

            foreach ($conferences as $conf) {
                if (strtotime($model->getStartDate()) <= strtotime($conf->getStart())
                    && strtotime($model ->getEndDate()) >= strtotime($conf->getStart())){
                    $this->addErrorMessage('The venue is busy during this time span!');
                    $this->context->setMethod('get');
                    return new View('conference', 'create', $model, $viewBag);
                }

                if(strtotime($model->getStartDate()) <= strtotime($conf->getEnd())
                    && strtotime($model->getEndDate()) >= strtotime($conf->getEnd())){
                    $this->addErrorMessage('The venue is busy during this time span!');
                    $this->context->setMethod('get');
                    return new View('conference', 'create', $model, $viewBag);
                }

                if(strtotime($model->getStartDate()) >= strtotime($conf->getStart())
                    && strtotime($model->getEndDate()) <= strtotime($conf->getEnd())){
                    $this->addErrorMessage('The venue is during other once check the times!');
                    $this->context->setMethod('get');
                    return new View('conference', 'create', $model, $viewBag);
                }
            }

            $conference = new Conference(
                $model->getTitle(),
                $model->getVenueId(),
                $model->getStartDate(),
                $model->getEndDate(),
                $this->identity->getUserId());

            $this->dbContext->getConferencesRepository()->add($conference);
            $this->dbContext->saveChanges();
            $this->addInfoMessage('Created new Conference!');

            $this->redirect('home');
        }

        return new View('conference', 'create', null, $viewBag);
    }

    /**
     * @Authorize
     * @Route("Me/Conferences")
     */
    public function myConferences(){
        $service = new ConferenceService($this->dbContext);
        $conferences = $service->myConferences();
        return new View('Conference', 'MyConferences', $conferences);
    }

    /**
     * @Authorize
     * @Route("Conference/{int id}/Edit")
     */
    public function edit(){
        $viewBag = [];
        $viewBag['venues'] = $this->dbContext->getVenuesRepository()->findAll()->getVenues();

        $id = intval(func_get_args()[0]);
        $service = new ConferenceService($this->dbContext);
        $conference = $service->getOne($id);
        $loggedUserId = $this->identity->getUserId();

        if($loggedUserId !== intval($conference->getOwnerId())){
            $this->addErrorMessage("You are not the owner of this conference!");
            $this->redirect('Me', 'Conferences');
        }

        if($this->context->isPost()){
            $model = new ConferenceBindingModel();
            if($model->getErrors()){
                foreach ($model->getErrors() as $error) {
                    $this->addErrorMessage($error);
                }
                $this->context->setMethod('get');

                $model = new ConferenceBindingModel($conference);
                return new View('Conference', 'Edit', $model, $viewBag);
            }

            $venueId = intval($model->getVenueId());

            $conferences = $this->dbContext->getConferencesRepository()
                ->filterByVenueId(" = '$venueId'")->findAll()->getConferences();

            foreach ($conferences as $conf) {
                if(intval($conf->getId()) !== intval($id)){
                    if (strtotime($model->getStartDate()) < strtotime($conf->getStart())
                        && strtotime($model ->getEndDate()) > strtotime($conf->getStart())){
                        $this->addErrorMessage('The venue is busy during this time span!');
                        $this->context->setMethod('get');
                        return new View('Conference', 'Edit', $model, $viewBag);
                    }

                    if(strtotime($model->getStartDate()) < strtotime($conf->getEnd())
                        && strtotime($model->getEndDate()) > strtotime($conf->getEnd())){
                        $this->addErrorMessage('The venue is busy during this time span!');
                        $this->context->setMethod('get');
                        return new View('Conference', 'Edit', $model, $viewBag);
                    }

                    if(strtotime($model->getStartDate()) > strtotime($conf->getStart())
                        && strtotime($model->getEndDate()) < strtotime($conf->getEnd())){
                        $this->addErrorMessage('The venue is during other once check the times!');
                        $this->context->setMethod('get');
                        return new View('Conference', 'Edit', $model, $viewBag);
                    }
                }
            }
            $conference = $service->getOne($id);

            $conference->setName($model->getTitle());
            $conference->setVenueId($model->getVenueId());
            $conference->setEnd($model->getEndDate());
            $conference->setStart($model->getStartDate());
            $this->dbContext->saveChanges();

//            $this->redirect("Me", "Conferences");
        }
        $model = new ConferenceBindingModel($conference);
        return new View('Conference', 'Edit', $model, $viewBag);
    }
}