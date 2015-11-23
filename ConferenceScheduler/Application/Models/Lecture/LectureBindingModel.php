<?php

namespace ConferenceScheduler\Application\Models\Lecture;

use ConferenceScheduler\Application\Models\BaseBindingModel;
use ConferenceScheduler\Core\HttpContext\HttpContext;

class LectureBindingModel extends BaseBindingModel
{
    private $name;
    private $startDate;
    private $endDate;
    private $hallId;

    public function __construct(){
        $context = HttpContext::getInstance();
        $this->setName($context->post('name'));
        $this->setStartDate($context->post('startDate'));
        $this->setEndDate($context->post('endDate'));
        $this->hallId = intval($context->post('hallId'));
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
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
    public function getHallId()
    {
        return $this->hallId;
    }

    /**
     * @param mixed $hallId
     */
    public function setHallId($hallId)
    {
        $this->hallId = $hallId;
    }
}