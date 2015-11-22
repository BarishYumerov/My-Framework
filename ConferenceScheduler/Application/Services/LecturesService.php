<?php

namespace ConferenceScheduler\Application\Services;


use ConferenceScheduler\Application\Models\Hall\HallViewModel;
use ConferenceScheduler\Application\Models\Lecture\LectureViewModel;

class LecturesService extends BaseService
{
    public function getLectures($id){
        $lectures = $this->dbContext->getLecturesRepository()->filterByConferenceId(" = '$id'")->findAll()->getLectures();
        $lecturesViewModel = [];

        foreach ($lectures as $lecture) {
            $lectureView = new LectureViewModel($lecture);

            $lectureId = intval($lecture->getId());
            $hallId = intval($lecture->getHallId());

            $members = $this->getLectureMembers($lectureId);
            $lectureView->setLectureJoinedMembers($members);

            $speakers = $this->getLectureSpeakers($lectureId);
            $lectureView->setSpeakers($speakers);

            $hall = $this->getLectureHall($hallId);
            $lectureView->setHall($hall);

            $lecturesViewModel[] = $lectureView;
        }

        return $lecturesViewModel;
    }

    public function getOne($lectureId){
        $lecture = $this->dbContext->getLecturesRepository()
            ->filterById(" = '$lectureId'")
            ->findOne();

        $lectureView = new LectureViewModel($lecture);

        $hallId = intval($lecture->getHallId());

        $members = $this->getLectureMembers($lectureId);
        $lectureView->setLectureJoinedMembers($members);

        $speakers = $this->getLectureSpeakers($lectureId);
        $lectureView->setSpeakers($speakers);

        $hall = $this->getLectureHall($hallId);
        $lectureView->setHall($hall);

        return $lectureView->getId() == null ? null : $lectureView;
    }

    private function getLectureMembers($id){
        $members = $this->dbContext->getLecturesusersRepository()->filterByLectureId(" = '$id'")->findAll()->getLecturesusers();
        $membersCount = count($members);
        return $membersCount;
    }

    private function getLectureSpeakers($id){
        $speakers = $this->dbContext->getLecturesspeakersRepository()->filterByLectureId(" = '$id'")->findAll()->getLecturesspeakers();
        $speakerNames = [];

        foreach ($speakers as $speaker) {
            $userId = $speaker->getSpeakerId();
            $speakerNames[] = $this->dbContext->getUsersRepository()->filterById(" = '$userId'")->findOne()->getUsername();
        }

        return $speakerNames;
    }

    private function getLectureHall($id){
        $hall = $this->dbContext->getHallsRepository()->filterById(" = '$id'")->findOne();
        $hallView = new HallViewModel($hall);
        return $hallView;
    }
}