<?php

namespace ConferenceScheduler\Application\Controllers;

use ConferenceScheduler\Application\Models\Conference\ConferenceBindingModel;
use ConferenceScheduler\Application\Services\ConferenceService;
use ConferenceScheduler\Models\Conference;
use ConferenceScheduler\View;

class ConferenceController extends BaseController
{
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

            $conference->setName($model->getTitle());
            $conference->setVenueId($model->getVenueId());
            $conference->setEnd($model->getEndDate());
            $conference->setStart($model->getStartDate());
            $this->dbContext->saveChanges();

            $this->redirect('Me', "Conferences");
        }

        $model = new ConferenceBindingModel($conference);
        return new View('Conference', 'Edit', $model, $viewBag);
    }
}