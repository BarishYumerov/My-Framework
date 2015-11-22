<?php

namespace ConferenceScheduler\Application\Services;

use ConferenceScheduler\Application\Models\Conference\ConferenceViewModel;

class ConferenceService extends BaseService
{
    public function getOne($id){
        $conference = $this->dbContext->getConferencesRepository()->filterById(" = '$id'")->findOne();
        if($conference->getId() == null){
            return null;
        }

        return $conference;
    }

    public function getAll() {
        $conferenceModels = [];
        $conferences = $this->dbContext->getConferencesRepository()
            ->orderByDescending('Start')
            ->findAll();

        foreach ($conferences->getConferences() as $conference) {
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

            $model = new ConferenceViewModel($conference);

            $model->setVenue($venue);
            $model->setOwner($owner);
            $conferenceModels[] = $model;
        }
        return $conferenceModels;
    }

    public function myConferences(){
        $loggedInUserId = $this->context->session('userId');
        $conferences = $this->dbContext->getConferencesRepository()->filterByOwnerId(" = '$loggedInUserId'")->findAll()->getConferences();

        $conferenceViewModels = [];
        foreach ($conferences as $conference) {
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

            $model = new ConferenceViewModel($conference);

            $model->setVenue($venue);
            $model->setOwner($owner);
            $conferenceViewModels[] = $model;
        }

        return $conferenceViewModels;
    }
}