<?php

namespace ConferenceScheduler\Application\Models\Conference;

use ConferenceScheduler\Application\Models\BaseBindingModel;

use ConferenceScheduler\Core\HttpContext\HttpContext;
use ConferenceScheduler\Models\Conference;

class ConferenceBindingModel extends BaseBindingModel
{
    private $id;
    private $startDate;
    private $endDate;
    private $title;
    private $venueId;

    public function __construct(Conference $conference = null){
        if(!$conference){
            $context = HttpContext::getInstance();
            $this->setStartDate($context->post('startDate'));
            $this->setEndDate($context->post('endDate'));
            $this->setTitle($context->post('title'));
            $this->setVenueId($context->post('venueId', 'int'));
        }
        else{
            $this->venueId = intval($conference->getVenueId());
            $this->endDate = $conference->getEnd();
            $this->startDate = $conference->getStart();
            $this->title = $conference->getName();
            $this->id = $conference->getId();
        }
    }

    /**
     * @return mixed
     */
    public function getVenueId()
    {
        return $this->venueId;
    }

    /**
     * @param mixed $venueId
     */
    public function setVenueId($venueId)
    {
        $this->venueId = $venueId;
    }

    /**
     * @return mixed
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @param mixed $startDate
     */
    public function setStartDate($startDate)
    {
        if(strtotime($startDate) < time()){
            $this->errors[] = 'Start date must be tomorrow or later!';
        }
        $this->startDate = $startDate;
    }

    /**
     * @return mixed
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * @param mixed $endDate
     */
    public function setEndDate($endDate)
    {
        if (strtotime($this->startDate) > strtotime($endDate)){
            $this->errors[] = 'End date must be later than start date';
        }
        $this->endDate = $endDate;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        if(count($title) == 0){
            $this->errors[] = 'Title length must be grater than 0!';
        }
        $this->title = $title;
    }

    public function getId(){
        return $this->id;
    }
}