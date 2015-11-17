<?php

namespace ConferenceScheduler\Application\Services;

use ConferenceScheduler\Application\Models\Conference\ConferenceViewModel;

class ConferencesServices extends BaseService
{
    public function getAll() {
        $conferenceModels = [];
        $conferences = $this->dbContext->getConferencesRepository()
            ->orderByDescending('Start')
            ->findAll();

        foreach ($conferences->getConferences() as $conference) {
            $conferenceId = $conference->getId();
            $venue = $this->dbContext->getVenuesRepository()
                ->filterById(" = $conferenceId")
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
}