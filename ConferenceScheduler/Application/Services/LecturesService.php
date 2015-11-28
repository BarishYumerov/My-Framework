<?php
declare(strict_types=1);
namespace ConferenceScheduler\Application\Services;


use ConferenceScheduler\Application\Models\Account\AccountViewModel;
use ConferenceScheduler\Application\Models\Hall\HallViewModel;
use ConferenceScheduler\Application\Models\Lecture\LectureViewModel;

class LecturesService extends BaseService
{
    public function delete(int $lectureId){
        $this->dbContext->getLecturesspeakersRepository()->filterByLectureId(" = '$lectureId'")->delete();
        $this->dbContext->getLecturesusersRepository()->filterByLectureId(" = '$lectureId'")->delete();
        $this->dbContext->getSpeakerinvitesRepository()->filterByLectureId(" = '$lectureId'")->delete();
        $this->dbContext->getLecturesRepository()->filterById(" = '$lectureId'")->delete();

        $this->dbContext->saveChanges();
    }

    public function getLectures(int $id){
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

    public function getOne(int $lectureId){
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

    private function getLectureMembers(int $id){
        $members = $this->dbContext->getLecturesusersRepository()->filterByLectureId(" = '$id'")->findAll()->getLecturesusers();
        $membersCount = count($members);
        return $membersCount;
    }

    private function getLectureSpeakers(int $id){
        $speakers = $this->dbContext->getLecturesspeakersRepository()->filterByLectureId(" = '$id'")->findAll()->getLecturesspeakers();
        $speakersInfo = [];

        foreach ($speakers as $speaker) {
            $userId = intval($speaker->getSpeakerId());
            $user = $this->dbContext->getUsersRepository()->filterById(" = '$userId'")->findOne();
            $speakersInfo[] = new AccountViewModel($user);
        }

        return $speakersInfo;
    }

    private function getLectureHall(int $id){
        $hall = $this->dbContext->getHallsRepository()->filterById(" = '$id'")->findOne();
        $hallView = new HallViewModel($hall);
        return $hallView;
    }
}