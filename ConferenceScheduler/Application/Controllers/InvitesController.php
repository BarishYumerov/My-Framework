<?php
/**
 * Created by PhpStorm.
 * User: Barish-PC
 * Date: 24.11.2015 ã.
 * Time: 23:42
 */

namespace ConferenceScheduler\Application\Controllers;


use ConferenceScheduler\Models\Lecturesspeaker;

class InvitesController extends BaseController
{
    /**
     * @Authorize
     * @Route("Invite/{int id}/Accept")
     */
    public function accept(){
        $id = intval(func_get_args()[0]);
        $invite = $this->dbContext->getSpeakerinvitesRepository()->filterById(" = '$id'")->findOne();

        if(intval($invite->getUserId()) !== $this->identity->getUserId()){
            $this->addErrorMessage("This invitation is not for you!");
            $this->redirect('home');
        }

        $lectureSpeaker = new Lecturesspeaker(intval($invite->getLectureId()), $this->identity->getUserId());

        $this->dbContext->getLecturesspeakersRepository()->add($lectureSpeaker);

        $this->dbContext->getSpeakerinvitesRepository()->filterById(" = '$id'")->delete();
        $this->addInfoMessage('You have approved the invitation');

        $this->dbContext->saveChanges();
        $this->redirect('Me', 'Invites');
    }

    /**
     * @Authorize
     * @Route("Invite/{int id}/Decline")
     */
    public function decline(){
        $id = intval(func_get_args()[0]);
        $invite = $this->dbContext->getSpeakerinvitesRepository()->filterById(" = '$id'")->findOne();

        if(intval($invite->getUserId()) !== $this->identity->getUserId()){
            $this->addErrorMessage("This invitation is not for you!");
            $this->redirect('home');
        }

        $this->dbContext->getSpeakerinvitesRepository()->filterById(" = '$id'")->delete();
        $this->addInfoMessage('You have declined the invitation');

        $this->dbContext->saveChanges();
        $this->redirect('Me', 'Invites');
    }
}