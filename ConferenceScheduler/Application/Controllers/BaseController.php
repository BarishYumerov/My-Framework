<?php
declare(strict_types=1);

namespace ConferenceScheduler\Application\Controllers;

use ConferenceScheduler\Application\Models\Invite\InviteViewModel;
use ConferenceScheduler\Core\HttpContext\HttpContext;
use ConferenceScheduler\Core\Identity\Identity;
use ConferenceScheduler\Core\ORM\DbContext;

abstract class BaseController{
    protected $dbContext;
    protected $context;
    protected $service;
    protected $identity;
    protected $invites;

    public function __construct()
    {
        $this->dbContext = new DbContext();
        $this->context = HttpContext::getInstance();
        $this->identity = Identity::getInstance();
        if($this->identity->isAuthorised()){
            $this->getInvites();
        }
        $this->onInit();
    }

    protected function onInit() {

    }

    public function redirectToUrl($url) {
        header("Location: " . $url);
        exit;
    }

    public function redirect($controllerName = null, $actionName = null, $params = null) {
        if($controllerName == null){
            $controllerName = 'home';
        }
        $url = '/' . urlencode($controllerName);
        if ($actionName != null) {
            $url .= '/' . urlencode($actionName);
        }
        if ($params != null) {
            $encodedParams = array_map($params, 'urlencode');
            $url .= implode('/', $encodedParams);
        }
        $this->redirectToUrl($url);
    }

    protected function getInvites(){
        $loggedUserId = $this->identity->getUserId();
        $invites = $this->dbContext->getSpeakerinvitesRepository()
                ->filterByUserId(" = '$loggedUserId'")->findAll()->getSpeakerinvites();


        $invitesViews = [];
        foreach ($invites as $invite) {
            $inviteView = new InviteViewModel($invite);
            $lectureId = intval($invite->getLectureId());
            $lecture = $this->dbContext->getLecturesRepository()->filterById(" = '$lectureId'")->findOne();
            $conferenceId = intval($lecture->getConferenceId());
            $conference = $this->dbContext->getConferencesRepository()->filterById(" = '$conferenceId'")->findOne();

            $inviteView->setLectureName($lecture->getName());
            $inviteView->setConferenceId($conferenceId);
            $inviteView->setConferenceName($conference->getName());

            $invitesViews[] = $inviteView;
        }

        if(count($invites) != 0){
            $_SESSION['hasInvites'] = true;
        }
        else{
            $_SESSION['hasInvites'] = false;
        }

        $this->invites = $invitesViews;
    }

    protected function validateToken(){
        $tokenFromSite = $this->context->post('token');
        $tokenFromSession = $this->context->session('token');
        if($tokenFromSession !== $tokenFromSite){
            throw new \Exception("Invalid CSFR Token!");
        }
    }

    function addMessage($msg, $type) {
        if (!isset($_SESSION['messages'])) {
            $_SESSION['messages'] = array();
        };
        array_push($_SESSION['messages'],
            array('text' => $msg, 'type' => $type));
    }

    function addInfoMessage($msg) {
        $this->addMessage($msg, 'alert alert-info');
    }

    function addErrorMessage($msg) {
        $this->addMessage($msg, 'alert alert-danger');
    }
}